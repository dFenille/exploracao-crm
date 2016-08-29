<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Admin\Model\ScheduleModel;
use Doctrine\ORM\EntityManager;
use Application\Model\ScupApiModel;

class mentions extends AbstractHelper
{
    /**
     * @var EntityManager
     * */
    
    protected $entityManager;
    
    
   
    public function __invoke()
    {   
        $sm = $this->getView()->getHelperPluginManager()->getServiceLocator();
        $renderer = $sm->get('Zend\View\Renderer\RendererInterface');
        $this->entityManager = $sm->get('Doctrine\ORM\EntityManager');
        
        return $this;
    }
    
    public function getMention($idMonitoring, $privateKey, $publicKey, $idMention,$idSearch){
        
        $scupModel = new ScupApiModel($this->entityManager);
        $time = time();
        
        $data = "publickey=".$publicKey."&time=".$time."&signature=".md5($time.$privateKey)."&mention_id=".$idMention;
        
        $result = $scupModel->getMetions(array('idMonitoring'=>$idMonitoring,'idSearch' => $idSearch,'sync'=>false),$data);
        
        return $result;
    }

    public function getTipoCanal($canal,$caminhoRaiz){

        switch ($canal){
            case 'facebookmessages':
                return "<img src='$caminhoRaiz/img/fb-message.png' style='max-width:25px; margin-left: 20px;'><br><label style='margin-left: 20px;'>Inbox</label>";
            break;
            case 'facebookwall':
                return "<img src='$caminhoRaiz/img/fb-post.jpg' style='max-width:25px; margin-left: 20px;'><br><label style='margin-left: 20px;'>Mural</label>";
            break;
            case 'twitterstream':
                return "<img src='$caminhoRaiz/img/twitter.png' style='max-width:25px; margin-left: 20px;'><br><label style='margin-left: 20px;'>Twitter</label>";
            break;
            case 'instagramtags':
                return "<img src='$caminhoRaiz/img/instagram.png' style='max-width:25px; margin-left: 20px;'><br><label style='margin-left: 20px;'>Instagram</label>";
            break;

        }

    }
  
}