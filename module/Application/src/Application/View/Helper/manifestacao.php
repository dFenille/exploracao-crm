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
            case 'canal':
                $result = 'Canal';
            break;
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

    public function createArrayGraphic($data)
    {
        $result = array( '0 a 2' => 0,'2 a 6' => 0,'6 a 12' => 0,'12 a 24' => 0,'24 a 36' => 0,'36 a 72' => 0,'72 a +' => 0,);

        foreach($data as $values){
            $result[$values['faixa_hh_uteis']] = $values['qtde'];
        }

        $return = null;
        foreach($result as $key => $values){
            $return.= $values.",";
        }

        return $return;
    }

    public function createArrayGraphicEnt($mes = '07', $ano = 2016 )
    {
        $totalDia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $dias = null;
        for($i=1;$i<=$totalDia;$i++){
            $dias.=$i.",";
        }
        return $dias;
    }

    public function prepareArrayGraphicEnt($data,$mes=7,$ano=2016)
    {
        $totalDia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
        $dias = null;

        for($i=1;$i<=$totalDia;$i++){
            if($i<10)
                $dates[$ano."-0".$mes."-"."0".$i] = 0;
            else
                $dates[$ano."-0".$mes."-".$i] = 0;
        }

        $result = null;
        foreach($data as $values){
            $dates[$values['dia']]= $values['qtd'];
        }

        foreach($dates as $key => $values){
            $result.= $values.",";
        }

        return $result;
    }

}