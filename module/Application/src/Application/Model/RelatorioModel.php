<?php
/**
 * Created by PhpStorm.
 * User: diego.santos
 * Date: 22/08/2016
 * Time: 10:51
 */

namespace Application\Model;


use Doctrine\ORM\EntityManager;
use Zend\XmlRpc\Value\Boolean;

class RelatorioModel
{
    /**
     * @var EntityManager
     */
    private $em;
    public  function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    /** BASE PV **/
    public function getTotalManifesto()
    {


        $sql = "SELECT count(*) as total FROM FaberManifest ORDER BY 1 ASC";
        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        if(empty($result))
            return 0;

        return $result[0]['total'];
    }

    /** BASE PV **/
    public function getTotalContato($request)
    {
        $sql = "SELECT count(distinct(faberContato.cod_mens)) as total
                           FROM FaberManifest  
                    INNER JOIN faberContato ON faberManifest.cod_mens = faberContato.cod_mens                     
                           WHERE 1=1 ";

        if(isset($request['canal']) && !empty($request['canal'])){
            $sql.= $this->montaWhere($request['canal'],'faberManifest.canal');
        }

        if(isset($request['man1']) && !empty($request['man1'])){
            $sql.= $this->montaWhere($request['man1'],'man1');
        }

        if(isset($request['man2']) && !empty($request['man2'])){
            $sql.= $this->montaWhere($request['man2'],'man2');
        }

        if(isset($request['man3']) && !empty($request['man3'])){
            $sql.= $this->montaWhere($request['man3'],'man3');
        }

        if(isset($request['grupo']) && !empty($request['grupo'])){
            $sql.= $this->montaWhere($request['grupo'],'grupo');
        }

        if(isset($request['codProd']) && !empty($request['codProd'])){
            $sql.= $this->montaWhere($request['codProd'],'codProduto');
        }

        if(isset($request['produto']) && !empty($request['produto'])){
            $sql.= $this->montaWhere($request['produto'],'produto');
        }

        if(isset($request['desc1']) && !empty($request['desc1'])){
            $sql.= $this->montaWhere($request['desc1'],'desc1');
        }

        if(isset($request['desc2']) && !empty($request['desc2'])){
            $sql.= $this->montaWhere($request['desc2'],'desc2');
        }

        if(isset($request['desc3']) && !empty($request['desc3'])){
            $sql.= $this->montaWhere($request['desc3'],'desc3');
        }

        if(isset($request['desc4']) && !empty($request['desc4'])){
            $sql.= $this->montaWhere($request['desc4'],'desc4');
        }
        if(isset($request['desc5']) && !empty($request['desc5'])){
            $sql.= $this->montaWhere($request['desc5'],'desc5');
        }

        if(isset($request['dataini']) && !empty($request['dataini'])){
            $sql.=" AND faberManifest.dt_coleta >= '{$this->convertDate($request['dataini'])} 00:00:00'";
        }

        if(isset($request['datafim']) && !empty($request['datafim'])){
            $sql.=" AND faberManifest.dt_coleta <= '{$this->convertDate($request['datafim'])} 23:59:59'";
        }

        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $totalContatos = $query->fetchAll();

        if(empty($totalContatos))
            return 0;

        return $totalContatos[0]['total'];
    }

    /** BASE PV **/
    public function getTotalConsumidor($request)
    {

        $sql = "SELECT count(distinct(faberConsum.cod_cons)) AS total FROM faberManifest
                    INNER JOIN faberContato ON faberManifest.cod_mens = faberContato.cod_mens
                    INNER JOIN faberConsum  ON  faberContato.cod_cons = faberConsum.cod_cons
                    WHERE 1=1 ";

        if(isset($_REQUEST['nome']) && !empty($_REQUEST['nome'])){
            $sql.= $this->montaWhereSingular($_REQUEST['nome'],'faberConsum.nome',true);
        }

        if(isset($_REQUEST['cidade']) && !empty($_REQUEST['cidade'])){
            $sql.= $this->montaWhere($_REQUEST['cidade'],'cidade');
        }

        if(isset($_REQUEST['estado']) && !empty($_REQUEST['estado'])){
            $sql.= $this->montaWhere($_REQUEST['estado'],'estado');
        }

        if(isset($_REQUEST['tipoConsumidor']) && !empty($_REQUEST['tipoConsumidor'])){
            $sql.= $this->montaWhere($_REQUEST['tipoConsumidor'],'tipoConsumidor');
        }

        if(isset($_REQUEST['publico']) && !empty($_REQUEST['publico'])){
            $sql.= $this->montaWhere($_REQUEST['publico'],'publico');
        }

        if(isset($request['canal']) && !empty($request['canal'])){
            $sql.= $this->montaWhere($request['canal'],'faberManifest.canal');
        }

        if(isset($request['man1']) && !empty($request['man1'])){
            $sql.= $this->montaWhere($request['man1'],'man1');
        }

        if(isset($request['man2']) && !empty($request['man2'])){
            $sql.= $this->montaWhere($request['man2'],'man2');
        }

        if(isset($request['man3']) && !empty($request['man3'])){
            $sql.= $this->montaWhere($request['man3'],'man3');
        }

        if(isset($request['grupo']) && !empty($request['grupo'])){
            $sql.= $this->montaWhere($request['grupo'],'grupo');
        }

        if(isset($request['codProd']) && !empty($request['codProd'])){
            $sql.= $this->montaWhere($request['codProd'],'codProduto');
        }

        if(isset($request['produto']) && !empty($request['produto'])){
            $sql.= $this->montaWhere($request['produto'],'produto');
        }

        if(isset($request['desc1']) && !empty($request['desc1'])){
            $sql.= $this->montaWhere($request['desc1'],'desc1');
        }

        if(isset($request['desc2']) && !empty($request['desc2'])){
            $sql.= $this->montaWhere($request['desc2'],'desc2');
        }

        if(isset($request['desc3']) && !empty($request['desc3'])){
            $sql.= $this->montaWhere($request['desc3'],'desc3');
        }

        if(isset($request['desc4']) && !empty($request['desc4'])){
            $sql.= $this->montaWhere($request['desc4'],'desc4');
        }
        if(isset($request['desc5']) && !empty($request['desc5'])){
            $sql.= $this->montaWhere($request['desc5'],'desc5');
        }

        if(isset($request['dataini']) && !empty($request['dataini'])){
            $sql.=" AND faberManifest.dt_coleta >= '{$this->convertDate($request['dataini'])} 00:00:00'";
        }else{
            $sql.=" AND faberManifest.dt_coleta >= '2016-07-01 00:00:00'";
        }

        if(isset($request['datafim']) && !empty($request['datafim'])){
            $sql.=" AND faberManifest.dt_coleta <= '{$this->convertDate($request['datafim'])} 23:59:59'";
        }else{
            $sql.=" AND faberManifest.dt_coleta <= '2016-07-31 23:59:59'";
        }


        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $totalConsumidor = $query->fetchAll();

        if(empty($totalConsumidor))
            return 0;

        return $totalConsumidor[0]['total'];

    }


    /** BASE HTH **/
    public function getProtocolo($idProtocolo){

        $sql = "SELECT * FROM v_protocolo WHERE protocolo_id = {$idProtocolo}";
        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $protocolo = $query->fetchAll();

        return $protocolo;
    }
    public function getFilterVInboxPending($columnName = 'depto_to'){

        $sql = "SELECT DISTINCT ({$columnName}) FROM v_inbox_pending_gerencia ORDER BY 1 ASC ";
        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }



    /** BASE PV **/
    public function getFilterVProtocolo($columnName = 'depto_from'){

        $sql = "SELECT DISTINCT ({$columnName}) FROM v_protocolo ORDER BY 1 ASC ";
        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getFilterFaberManifest($columnName = 'canal'){

        $sql = "SELECT DISTINCT {$columnName} FROM FaberManifest ORDER BY 1 ASC";
        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getFilterFaberCons($columnName = 'cidade')
    {

        $sql = "SELECT DISTINCT {$columnName} FROM FaberConsum ORDER BY 1 ASC";
        $query = $this->em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function montaWhereSingular($value,$where, $isLike = false)
    {
        $query = '';
        if(!empty($value) && !empty($where)){
            $query.=" AND (  {$where} ";

            if($isLike==true)
                $query.=" like '%{$value}%' ) ";
            else
                $query.=" = '{$value}' ) ";

        }
        return $query;
    }

    public function montaWhere($field,$where)
    {
        $query = '';
        if(!empty($field[0])){
            $query.=" AND (";

            $countField = count($field);
            $iField = 1;

            foreach ($field as $value){

                $query.= " {$where} = '{$value}'";

                if($iField < $countField)
                    $query.=" OR ";

                $iField++;

            }
            $query.=" )";
        }

        return $query;
    }

    public function convertDate($date)
    {
        if(!empty($date)){
            $dateExplode = explode('/',$date);
            $newDate = $dateExplode[2]."-".$dateExplode[1]."-".$dateExplode[0];
        }else{
            $newDate = date('Y-m-d');
        }

        return $newDate;
    }

    public function limitarTexto($texto, $idProtocolo = 0,$limite = 70){
        $contador = strlen($texto);
        if ( $contador >= $limite ) {
            $texto = ucfirst(mb_convert_case($texto, MB_CASE_LOWER, "UTF-8"));
            $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . "<a href='javascript:void(0);' onclick=\"showModal({$idProtocolo})\"> ... ver mais</a>";

            return $texto;
        }
        else{
            return $texto;
        }
    }
}