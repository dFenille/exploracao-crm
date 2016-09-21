<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Abraham\TwitterOAuth\TwitterOAuth;
use Doctrine\ORM\EntityManager;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\ScupApiModel;
use Zend\Console\Request as ConsoleRequest;

class IndexController extends AbstractAppController
{
    /**
     * @var EntityManager
     */
    public $em;

    public function indexAction()
    {
        $request    = $this->getRequest();
        $data       = $request->getQuery();
        $result     = null;
        $time       = time();
        $getUrl     = null;
        $getUrl.="publickey=".PUBLIC_KEY."&time=".$time."&signature=".md5($time.PRIVATE_KEY);


        $scupModel = new ScupApiModel($this->em);
        $result = $scupModel->getMonitoring($getUrl);
        if(!empty($result) && !isset($result->data->error_code)){
            foreach($result->data as $valuesMonitoring){
                $tags = $scupModel->getTags(array('idMonitoring'=>$valuesMonitoring->id));
                $scupModel->sincronizarTags($tags,$valuesMonitoring->id);
            }
        }

        return new ViewModel(array('result'=>$result));
    }

    public function homeAction()
    {

        return new ViewModel();
    }

    public function sincronizarAction()
    {
        $request = $this->getRequest();
        $verbose = $request->getParam('verbose') || $request->getParam('v');

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException ('Esta requisição só está ativa para console');
        }


        $this->em = $this->getServiceLocator()->get( 'Doctrine\ORM\EntityManager' );
        $config = $this->getServiceLocator()->get( 'Config' );


        $request    = $this->getRequest();
        $data       = $request->getParams();
        $scupModel  = new ScupApiModel($this->em);
        $result     = null;
        $page       = 1;
        $time       = time();
        $finish     = false;

        $dateStart  = isset($data['data_ini'])?$data['data_ini']:date('Y-m-d', strtotime('-7 day'))." 00:00:00";
        $dateEnd    = isset($data['data_fim'])?$data['data_fim']:date('Y-m-d', strtotime('-7 day'))." 23:59:59";



        /** PARAMETROS 123**/
        $result.="publickey=".PUBLIC_KEY."&signature=".md5($time.PRIVATE_KEY)."&time=".$time;
//      $result.='&published_date='.date('Y-m-d')."%2000:00:00|".date('Y-m-d')."%2023:59:59";
        $result.='&published_date='.str_replace(' ','%20',$dateStart)."|".str_replace(' ','%20',$dateEnd);
        $result.="&ipp=100&page=".$page;

        $returnData = $scupModel->getMetions(array('idMonitoring' => $data['idMonitoring'],'sync' => true),$result);

       /** PAGINACAO DE PARAMETROS **/
        if(!isset($returnData->erro)){
            if(!empty($returnData)){
                while($finish == false){
                    $result = null;
                    $time = time();
                    $page++;
                    $result.="publickey=".PUBLIC_KEY."&signature=".md5($time.PRIVATE_KEY)."&time=".$time;
    //              $result.='&published_date='.date('Y-m-d')."%2000:00:00|".date('Y-m-d')."%2023:59:59";
                    $result.='&published_date='.str_replace(' ','%20',$dateStart)."|".str_replace(' ','%20',$dateEnd);
                    $result.="&ipp=100&page=".$page;

                    $returnData = $scupModel->getMetions(array('idMonitoring' => $data['idMonitoring'],'sync' => true),$result);


                    if(empty($returnData) || isset($returnData->data[0]->error_code) || isset($returnData->erro)){
                        $finish = true;
                        $return = isset($returnData->data[0]->error_code)?(($returnData->data[0]->message_error == 'is empty')?'Concluído com sucesso':$returnData->data[0]->message_error):'Concluído com sucesso';
                        if(isset($returnData->erro)){
                            $this->sendMail("ERRO: ".$returnData->erro."</br> Data Inicial:{$dateStart} </br> Data Final: {$dateEnd}");
                        }
                    }else{
                        $finish = false;
                    }
                }
                $this->getPublicacaoTwitter($dateStart, $dateEnd);
            }else{
                $this->sendMail("Pesquisa retornou vazia");
            }
        }else{
            $this->sendMail("ERRO: ".$returnData->erro."\r\nData Inicial:{$dateStart} \r\nData Final: {$dateEnd}");
            echo "ERRO: ".$returnData->erro;
        }

        system('exit');
        return;
    }

    protected function getPublicacaoTwitter($dateStart,$dateEnd)
    {
        define('CONSUMER_KEY','48S7BBmDSWi885XuLTxFRkqus');
        define('CONSUMER_SECRET','uX3KHaETs3un96MDVJn92X2zhkA2CCagAngyoEmCuuEIyDT0kj');
        define('CONSUMER_TOKEN','231656611-ukKUxbTrnP4vqHaf4UWhdifTZvVEnwqma4Z7mrbB');
        define('CONSUMER_TOKEN_SECRET','g3vHLr4YR9g9ZXrkcKDiMiKAw9todjYfcULIfBnIRWyxl');

        $dateStart  = !empty($dateStart)?str_replace('%20',' ',$dateStart):date('Y-m-d', strtotime('-7 day'))." 00:00:00";
        $dateEnd    = !empty($dateEnd)?str_replace('%20',' ',$dateEnd):date('Y-m-d', strtotime('-7 day'))." 23:59:59";

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,CONSUMER_TOKEN,CONSUMER_TOKEN_SECRET);
        $content = $connection->get("account/verify_credentials");
        $request_token = $connection->oauth('oauth/request_token');

        $sessionTwitter = new \Zend\Session\Container('twitter');
        $sessionTwitter->oauth_token         = $request_token['oauth_token'];
        $sessionTwitter->oauth_token_secret  = $request_token['oauth_token_secret'];

        $query = $this->em->createQueryBuilder();
        $query->select('mencao')
            ->from('Application\Entity\Mencao', 'mencao')
//                 ->where("mencao.tipoCaptura = 'twitterstream' and mencao.dtEnvio >= '2016-07-02 00:00:00' and mencao.dtEnvio <= '2016-07-02 23:59:59'");
            ->where("mencao.tipoCaptura = 'twitterstream' and mencao.dtEnvio >= '{$dateStart}' and mencao.dtEnvio <= '{$dateEnd}' ");

        $result = $query->getQuery()->getResult();
        if(!empty($result)){
            foreach($result as $values){
                $explodeLink = explode('/', $values->getPermalink());
                $id = array_reverse($explodeLink);
                $statuses = $connection->get("statuses/show", array('id' => $id[0]));

                echo "Importando conteudo Twitter #{$id[0]}\r\n";

                if(isset($statuses->text) && !empty($statuses->text)){
                    $this->em->getConnection()->beginTransaction();
                    try{
                        $values->setMensagem($statuses->text);
                        $this->em->persist($values);
                        $this->em->flush();
                        $this->em->getConnection()->commit();
                    }catch (\Exception $e){
                        $this->em->getConnection()->rollBack();
                    }
                }
            }
            $result = 'Mensagens do Twitter atualizadas';
        }else{
            $result = 'Mensagens do Twitter não foram atualizadas';
        }

        return new JsonModel(array('result'=> $result));

    }

    public function sendMail($erro)
    {
        // Setup SMTP transport
        ini_set("SMTP","192.168.111.9");

        $mail = new Message();
        $mail->setBody($erro);
        $mail->setFrom('from@paginaviva.com.br', 'Sinc Scup');
        $mail->addTo(array('diego.santos@paginaviva.com.br','daniel.ferreira@paginaviva.com.br'), 'Error');
        $mail->setSubject('Erro Scup');

        $sendMail = new Sendmail();
        $sendMail->send($mail);

        return new JsonModel(array('success'=>true));
    }
}
