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

class IndexController extends AbstractAppController
{
    public function indexAction()
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

    public function homeAction()
    {

        return new ViewModel();
    }

    
}
