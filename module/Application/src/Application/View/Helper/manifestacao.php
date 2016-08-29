<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Admin\Model\ScheduleModel;
use Doctrine\ORM\EntityManager;
use Application\Model\ScupApiModel;

class manifestacao extends AbstractHelper
{
    /**
     * @var EntityManager
     * */
    
    protected $entityManager;
    
    
   
    public function __invoke()
    {   
        $sm = $this->getView()->getHelperPluginManager()->getServiceLocator();
        $renderer = $sm->get('Zend\View\Renderer\RendererInterface');

        return $this;
    }

    public function getFiltroManifestacao($filtro)
    {
        switch($filtro){
            case 'man1':
                $result = 'Man1';
            break;
            case 'dataini':
                $result = 'Data Inicial';
            break;
            case 'datafim':
                $result = 'Data Final';
                break;
            case 'grupo':
                $result = 'Categoria';
                break;
            case 'codProd':
                $result = 'Cód. Produto';
                break;
            case 'produto':
                $result = 'Produto';
            break;
            case 'desc1':
                 $result = 'Grupo';
            break;
            case 'desc2':
                $result = 'Fam&iacute;lia';
            break;
            case 'desc3':
                $result = 'Acabamento';
            break;
            case 'desc3':
                $result = 'Tipo';
            break;
            case 'desc5':
                $result = 'Cores';
            break;
        }

        return $result;

    }
  
}