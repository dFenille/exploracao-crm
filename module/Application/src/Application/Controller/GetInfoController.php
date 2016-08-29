<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\ScupApiModel;
use Abraham\TwitterOAuth\TwitterOAuth;
use Zend\I18n\View\Helper\DateFormat;

class GetInfoController extends AbstractAppController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function sincronizarAction(){
        $request    = $this->getRequest();
        $data       = $request->getQuery();
        $scupModel  = new ScupApiModel($this->getEntityManager());
        $result     = null;
        $page       = 1;
        $time       = time();
        $finish     = false;
        
        $dateStart  = isset($data['dataInicio'])?$data['dataInicio']:date('Y-m-d', strtotime('-1 day'));
        $dateEnd    = isset($data['dataFim'])?$data['dataFim']:date('Y-m-d', strtotime('-1 day'));
        
        
        /** PARAMETROS 123**/
        $result.="publickey=".PUBLIC_KEY."&signature=".md5($time.PRIVATE_KEY)."&time=".$time;
//      $result.='&published_date='.date('Y-m-d')."%2000:00:00|".date('Y-m-d')."%2023:59:59";
        $result.='&published_date='.$dateStart."%2000:00:00|".$dateEnd."%2023:59:59";
        $result.="&ipp=100&page=".$page;
        
        $returnData = $scupModel->getMetions(array('idMonitoring' => $data['idMonitoring'],'sync' => true),$result);
        
        
        /** PAGINACAO DE PARAMETROS **/
        if(!empty($returnData) && !isset($returnData->data->error_code)){
            while($finish == false){
                $result = null;
                $time = time();
                $page++;
                $result.="publickey=".PUBLIC_KEY."&signature=".md5($time.PRIVATE_KEY)."&time=".$time;
//              $result.='&published_date='.date('Y-m-d')."%2000:00:00|".date('Y-m-d')."%2023:59:59";
                $result.='&published_date='.$dateStart."%2000:00:00|".$dateEnd."%2023:59:59";
                $result.="&ipp=100&page=".$page;
                
                $returnData = $scupModel->getMetions(array('idMonitoring' => $data['idMonitoring'],'sync' => true),$result);
                if(empty($returnData) || isset($returnData->data[0]->error_code)){
                    $finish = true; 
                    $return = isset($returnData->data[0]->error_code)?(($returnData->data[0]->message_error == 'is empty')?'Concluído com sucesso':$returnData->data[0]->message_error):'Concluído com sucesso';
                }else{
                    $finish = false;
                }
            }
        }
        
        return new JsonModel(array('result'=>$return,'totalPaginas' => $page - 1 ));
    }
    
    
    public function getSearchsAction()
    {
        $request    = $this->getRequest();
        $data       = $request->getQuery();
        $result     = null;
        $time       = time();
        
        $result.="publickey=".PUBLIC_KEY."&signature=".md5($time.PRIVATE_KEY)."&time=".$time;
        
        $scupModel  = new ScupApiModel($this->getEntityManager());
        $result     = $scupModel->getSearchs(array('idMonitoring'=>$data['monitoring_id']),$result);
       
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setVariables(array('result'=>$result));
        return $viewModel;
    }
    
    
    public function getMentionsAction()
    {
    
        $request    = $this->getRequest();
        $data       = $request->getQuery();
        $result     = null;
        $time       = time();
        
        foreach ($data as $key => $value){
            if(!empty($value)){
                if($key != 'idMonitoring'){
                    
                    switch ($key){
                        case 'published_date':
                            
                            /** STR_REPLACE ESPACO POR %20, SENAO RETORNA COM ERRO **/
                            if(!empty($value[0]) && !empty($value[1])){
                                $result.= $key."=".str_replace(' ', '%20',$value[0])."|".str_replace(' ', '%20',$value[1])."&";
                            }else{
                                if(!empty($value[0])){
                                    $result.= $key."=".str_replace(' ', '%20',$value[0]);
                                     if(!empty($value[1]))
                                        $result.="|".str_replace(' ', '%20',$value[1])."&";
                                    else{
                                        $result.="|".date('Y-m-d')."%2023:59:00&";
                                    }
                                }
                            }
                        break;
                        default:
                            $result.= $key."=".$value."&";
                        break;
                    }
                }
            }
        }
        
        $result.="publickey=".PUBLIC_KEY."&signature=".md5($time.PRIVATE_KEY)."&time=".$time;
        
        $scupModel  = new ScupApiModel($this->getEntityManager());
        $result     = $scupModel->getMetions(array('idMonitoring'=>$data['idMonitoring'],'idSearch'=> $data['searches_ids'],'sync'=>true),$result);
    
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setVariables(array('result'=>$result));
        return $viewModel;
    }
    
    
    public function getPublicacaoTwitterAction()
    {
        define('CONSUMER_KEY','48S7BBmDSWi885XuLTxFRkqus');
        define('CONSUMER_SECRET','uX3KHaETs3un96MDVJn92X2zhkA2CCagAngyoEmCuuEIyDT0kj');
        define('CONSUMER_TOKEN','231656611-ukKUxbTrnP4vqHaf4UWhdifTZvVEnwqma4Z7mrbB');
        define('CONSUMER_TOKEN_SECRET','g3vHLr4YR9g9ZXrkcKDiMiKAw9todjYfcULIfBnIRWyxl');
        $request = $this->getRequest();
        $data = $request->getQuery();

        $dateStart  = isset($data['dataInicio'])?$data['dataInicio']:date('Y-m-d', strtotime('-1 day'));
        $dateEnd    = isset($data['dataFim'])?$data['dataFim']:date('Y-m-d', strtotime('-1 day'));


        
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,CONSUMER_TOKEN,CONSUMER_TOKEN_SECRET);
        $content = $connection->get("account/verify_credentials");
        $request_token = $connection->oauth('oauth/request_token');
       
        $sessionTwitter = new \Zend\Session\Container('twitter');
        $sessionTwitter->oauth_token         = $request_token['oauth_token'];
        $sessionTwitter->oauth_token_secret  = $request_token['oauth_token_secret'];
        
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->select('mencao')
                ->from('Application\Entity\Mencao', 'mencao')
//                 ->where("mencao.tipoCaptura = 'twitterstream' and mencao.dtEnvio >= '2016-07-02 00:00:00' and mencao.dtEnvio <= '2016-07-02 23:59:59'");
                ->where("mencao.tipoCaptura = 'twitterstream' and mencao.dtEnvio >= '{$dateStart} 00:00:00' and mencao.dtEnvio <= '{$dateEnd} 23:59:59' ");
        
        $result = $query->getQuery()->getResult();
        if(!empty($result)){
            foreach($result as $values){
                $explodeLink = explode('/', $values->getPermalink());
                $id = array_reverse($explodeLink);
                $statuses = $connection->get("statuses/show", array('id' => $id[0]));
                if(isset($statuses->text) && !empty($statuses->text)){
                    $this->getEntityManager()->getConnection()->beginTransaction();
                    try{
                        $values->setMensagem($statuses->text);
                        $this->getEntityManager()->persist($values);
                        $this->getEntityManager()->flush();
                        $this->getEntityManager()->getConnection()->commit();
                    }catch (\Exception $e){
                        $this->getEntityManager()->getConnection()->rollBack();
                        throw new \Exception("Error: ".$e->getMessage());
                    }
                }
            }
            $result = 'Mensagens do Twitter atualizadas';
        }else{
            $result = 'Mensagens do Twitter não foram atualizadas';
        }
        
        return new JsonModel(array('result'=> $result));
        
    }
    
}
