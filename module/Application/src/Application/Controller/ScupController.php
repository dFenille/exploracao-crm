<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Mencao;
use Application\Model\MencaoModel;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Model\ScupApiModel;
use Abraham\TwitterOAuth\TwitterOAuth;
use Zend\I18n\View\Helper\DateFormat;

class ScupController extends AbstractAppController
{
    public function homeAction()
    {
        $request    = $this->getRequest();
        $data       = $request->getQuery();
        $result     = null;
        $time       = time();
        $getUrl     = null;
        $getUrl.="publickey=".PUBLIC_KEY."&time=".$time."&signature=".md5($time.PRIVATE_KEY);


        $scupModel = new ScupApiModel($this->getEntityManager());
        $result = $scupModel->getMonitoring($getUrl);
        if(!empty($result) && !isset($result->data->error_code)){
            foreach($result->data as $valuesMonitoring){
                $tags = $scupModel->getTags(array('idMonitoring'=>$valuesMonitoring->id));
                $scupModel->sincronizarTags($tags,$valuesMonitoring->id);
            }
        }

        return new ViewModel(array('result'=>$result));
    }

    public function indexAction()
    {

        $mencaoModel = new MencaoModel($this->getEntityManager());
        $conversas = $mencaoModel->getConversas();
        $tags      = $mencaoModel->setMonitoring('109199')->getTags();

        $conversas = $mencaoModel->getConversas();
        $totalConversas = $mencaoModel->getTotalConversa();

        $this->layout()->title = "Mídias Sociais: Monitoria e Integração ao CRM";

        return new ViewModel(array('conversas'=>$conversas,'totalConversas'=> $totalConversas,'tags'=>$tags));
    }


    public function resultadoPesquisaAction()
    {
        $request = $this->getRequest();

        if($request->isPost()){
            $data = $request->getPost();

            $mencaoModel = new MencaoModel($this->getEntityManager());
            $conversas = $mencaoModel->getConversas(1,!empty($data['maxConversa'])?$data['maxConversa']:15,$data['dataIni'],$data['dataFim'],$data['nome_pessoa'],$data['conteudo_post'],$data['conteudo_resposta'],$data['sentimento'],$data['canais']);
            $totalConversas = $mencaoModel->getTotalConversa($data['dataIni'],$data['dataFim'],$data['nome_pessoa'],$data['conteudo_post'],$data['conteudo_resposta'],$data['sentimento'],$data['canais']);
        }
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setVariables(array('conversas'=>$conversas,'totalConversas'=>$totalConversas));
        return $viewModel;
    }

    
}
