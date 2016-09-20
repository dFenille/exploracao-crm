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

    public function createArrayGraphicEnt($options)
    {
        $dates = null;
        setlocale(LC_ALL, 'pt_BR');
        switch($options['filtro']){
            case 1:
                $dates= "'".date('d/m')."',";
                break;
            case 2:
                $rangeDate = $this->date_range(date('Y-m-d',strtotime('- 7 days')),date('Y-m-d'),'+1 day', $output_format = 'd/M');
                foreach($rangeDate as $values){
                    $dates.= "'".$values."',";
                }
                break;
            case 3:

                if(isset($options['qtde']) && $options['qtde'] > 1)
                    $rangeDate = $this->date_range(date( "Y-m-d", strtotime( "-2 month" ) ),date('Y-m-d'),'+1 day', $output_format = 'd/M');
                else
                    $rangeDate = $this->date_range(date( "Y-m-d", strtotime( "-1 month" ) ),date('Y-m-d'),'+1 day', $output_format = 'd/M');

                foreach($rangeDate as $values){
                    $dates.= "'".$values."',";
                }
                break;
            case 4:
                $rangeDate = $this->date_range(date('Y-m-d',strtotime('- 1 year')),date('Y-m-d'),'+1 day', $output_format = 'd/M');
                foreach($rangeDate as $values){
                    $dates.= "'".$values."',";
                }
                break;
        }

        return $dates;
    }

    public function prepareArrayGraphicEnt($data,$options = array('filtro' => 2, 'dataIni' => '','dataFim' => ''))
    {
        $options['dataIni'] = date('Y-m-d',strtotime('-1 day'));
        $options['dataFim'] = date('Y-m-d');
        switch($options['filtro']){
            case 1:
                $dates[date('Y-m-d')] = 0;
            break;
            case 2:
                $rangeDate = $this->date_range(date('Y-m-d',strtotime('- 7 days')),date('Y-m-d'));
                foreach($rangeDate as $values){
                    $dates[$values] = 0;
                }
            break;
            case 3:
                $rangeDate = $this->date_range(date( "Y-m-d", strtotime( "-1 month" ) ),date('Y-m-d'));
                foreach($rangeDate as $values){
                    $dates[$values] = 0;
                }
            break;
            case 4:
                $rangeDate = $this->date_range(date('Y-m-d',strtotime('- 1 year')),date('Y-m-d'));
                foreach($rangeDate as $values){
                    $dates[$values] = 0;
                }
            break;
        }

        $result = null;
        foreach($data as $values){
            $dates[$values['dia']] = $values['qtd'];
        }

        foreach($dates as $key => $values){
            $result.= $values.",";
        }

        return $result;
    }

    function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }

}