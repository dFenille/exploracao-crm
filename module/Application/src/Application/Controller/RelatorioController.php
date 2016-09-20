<?php
/**
 * Created by PhpStorm.
 * User: diego.santos
 * Date: 18/08/2016
 * Time: 11:32
 */

namespace Application\Controller;


use Application\Form\CartasEmailForm;
use Application\Form\GlossaryForm;
use Application\Model\RelatorioModel;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class RelatorioController extends AbstractAppController
{
        public  function indexAction()
        {
            $relatModel = new RelatorioModel($this->getEntityManagerFaber());
            $canal = $relatModel->getFilterFaberManifest('canal');
            $man1  = $relatModel->getFilterFaberManifest('man1');
            $man2  = $relatModel->getFilterFaberManifest('man2');
            $man3  = $relatModel->getFilterFaberManifest('man3');
            $grupo = $relatModel->getFilterFaberManifest('grupo');
            $codProd = $relatModel->getFilterFaberManifest('codProduto');
            $produto = $relatModel->getFilterFaberManifest('produto');
            $desc1    = $relatModel->getFilterFaberManifest('desc1');
            $desc2    = $relatModel->getFilterFaberManifest('desc2');
            $desc3    = $relatModel->getFilterFaberManifest('desc3');
            $desc4    = $relatModel->getFilterFaberManifest('desc4');
            $desc5    = $relatModel->getFilterFaberManifest('desc5');
            $totalManifesto = $relatModel->getTotalManifesto();

            $this->layout()->title = 'CRM - Exploração de manifestações';

            return new ViewModel(array('canal' => $canal, 'grupo' => $grupo, 'man1'=> $man1, 'man2'=> $man2, 'man3'=> $man3,'codProd' => $codProd, 'produto' => $produto,
                                        'desc1' => $desc1, 'desc2'=>$desc2, 'desc3'=>$desc3, 'desc4'=>$desc4, 'desc5'=>$desc5,
                                        'totalManifesto' => $totalManifesto    ));

        }

        public function listManifestoAction()
        {
            $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
            $sql = "SELECT count(canal) as total
                           FROM FaberManifest  WHERE 1=1 ";


            if(isset($_REQUEST['canal']) && !empty($_REQUEST['canal'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['canal'],'canal');
            }

            if(isset($_REQUEST['man1']) && !empty($_REQUEST['man1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man1'],'man1');
            }

            if(isset($_REQUEST['man2']) && !empty($_REQUEST['man2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man2'],'man2');
            }

            if(isset($_REQUEST['man3']) && !empty($_REQUEST['man3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man3'],'man3');
            }

            if(isset($_REQUEST['grupo']) && !empty($_REQUEST['grupo'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['grupo'],'grupo');
            }

            if(isset($_REQUEST['codProd']) && !empty($_REQUEST['codProd'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['codProd'],'codProduto');
            }

            if(isset($_REQUEST['produto']) && !empty($_REQUEST['produto'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['produto'],'produto');
            }

            if(isset($_REQUEST['desc1']) && !empty($_REQUEST['desc1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc1'],'desc1');
            }

            if(isset($_REQUEST['desc2']) && !empty($_REQUEST['desc2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc2'],'desc2');
            }

            if(isset($_REQUEST['desc3']) && !empty($_REQUEST['desc3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc3'],'desc3');
            }

            if(isset($_REQUEST['desc4']) && !empty($_REQUEST['desc4'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc4'],'desc4');
            }
            if(isset($_REQUEST['desc5']) && !empty($_REQUEST['desc5'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc5'],'desc5');
            }

            if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
                $sql.=" AND dt_coleta >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
            }else{
                $sql.=" AND dt_coleta >= '2016-07-01 00:00:00'";
            }

            if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
                $sql.=" AND dt_coleta <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59'";
            }else{
                $sql.=" AND dt_coleta <= '2016-07-31 23:59:59'";
            }


            $query = $this->getEntityManagerFaber()->getConnection()->prepare($sql);
            $query->execute();
            $totalDados = $query->fetchAll();

            if(empty($totalDados))
                $totalDados = 0;
            else
                $totalDados = $totalDados[0]['total'];


            $iTotalRecords = $totalDados;
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
            $iDisplayStart = intval($_REQUEST['start']);
            $sEcho = intval($_REQUEST['draw']);


            $order = $_REQUEST['order'];

            $orderbyColumn = $order[0]['column'];
            $orderbyDir    = $order[0]['dir'];

            $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1)) + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH manifesto AS
                    (
            
                        SELECT cod_mens,canal,
                                       man1, man2, man3, grupo, codProduto, Produto, desc1, desc2, desc3, desc4, desc5,dt_coleta,
                                       row_number() OVER (ORDER BY ".$this->getOrderByColumn($orderbyColumn)." $orderbyDir) as RowNumber
                                    FROM FaberManifest WHERE 1=1 ";

            if(isset($_REQUEST['canal']) && !empty($_REQUEST['canal'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['canal'],'canal');
            }

            if(isset($_REQUEST['man1']) && !empty($_REQUEST['man1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man1'],'man1');
            }

            if(isset($_REQUEST['man2']) && !empty($_REQUEST['man2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man2'],'man2');
            }

            if(isset($_REQUEST['man3']) && !empty($_REQUEST['man3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man3'],'man3');
            }

            if(isset($_REQUEST['grupo']) && !empty($_REQUEST['grupo'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['grupo'],'grupo');
            }

            if(isset($_REQUEST['codProd']) && !empty($_REQUEST['codProd'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['codProd'],'codProduto');
            }

            if(isset($_REQUEST['produto']) && !empty($_REQUEST['produto'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['produto'],'produto');
            }

            if(isset($_REQUEST['desc1']) && !empty($_REQUEST['desc1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc1'],'desc1');
            }

            if(isset($_REQUEST['desc2']) && !empty($_REQUEST['desc2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc2'],'desc2');
            }

            if(isset($_REQUEST['desc3']) && !empty($_REQUEST['desc3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc3'],'desc3');
            }

            if(isset($_REQUEST['desc4']) && !empty($_REQUEST['desc4'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc4'],'desc4');
            }
            if(isset($_REQUEST['desc5']) && !empty($_REQUEST['desc5'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc5'],'desc5');
            }

            if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
                $sql.=" AND dt_coleta >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
            }

            if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
                $sql.=" AND dt_coleta <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59'";
            }

            $sql.=")
                SELECT * , (SELECT COUNT(*) FROM manifesto) AS TotalRecords
                        FROM manifesto
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

            $query = $this->getEntityManagerFaber()->getConnection()->prepare($sql);
            $query->execute();

            $result = $query->fetchAll();

                $records = array();
            $records["data"] = array();

            foreach($result as $row){
                $records["data"][] = array(
                    intval($row['cod_mens']),
                    $row['canal'],
                    $row['man1'],
                    $row['man2'],
                    $row['man3'],
                    $row['grupo'],
                    $row['codProduto'],
                    $row['Produto'],
                    $row['desc1'],
                    $row['desc2'],
                    $row['desc3'],
                    $row['desc4'],
                    $row['desc5']
                );
            }

            if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
            }

            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            $records["totalContatos"] = $relatorioModel->getTotalContato($_REQUEST);
            $records["totalConsumidores"] = $relatorioModel->getTotalConsumidor($_REQUEST);

            return new JsonModel($records);
        }


        private function getOrderByColumn($idColumn)
        {

            $columns = array(1 => 'canal',
                            2 => 'man1',
                            3 => 'man2',
                            4 => 'man3',
                            5 => 'grupo',
                            6 => 'codProduto',
                            7 => 'Produto',
                            8 => 'desc1',
                            9 => 'desc2',
                            10 => 'desc3',
                            11 => 'desc4',
                            12 => 'desc5',
                    );

            return $columns[$idColumn];

        }



        public function consumidorAction()
        {
            $this->layout()->title = 'CRM - Exploração de manifestações - Consumidores';
            $request = $this->getRequest();
            $data = $request->getQuery();
            $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
            $cidade = $relatorioModel->getFilterFaberCons('cidade');
            $estado = $relatorioModel->getFilterFaberCons('estado');
            $tipoConsumidor = $relatorioModel->getFilterFaberCons('tipoConsumidor');
            $publico = $relatorioModel->getFilterFaberCons('publico');
            return new ViewModel(array('filtro'=>$data,'cidade'=>$cidade, 'estado' => $estado, 'tipoConsumidor' => $tipoConsumidor,'publico' => $publico));
        }

        public function listConsumidorAction()
        {
            $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
            $totalDados = 0;
            /** QUERY MOSTRA O TOTAL**/
            $sql = "SELECT count(distinct(faberConsum.cod_cons)) AS total FROM faberManifest
                    INNER JOIN faberContato ON faberManifest.cod_mens = faberContato.cod_mens
                    INNER JOIN faberConsum  ON  faberContato.cod_cons = faberConsum.cod_cons
                    WHERE 1=1 ";


            if(isset($_REQUEST['nome']) && !empty($_REQUEST['nome'])){
                $sql.= $relatorioModel->montaWhereSingular($_REQUEST['nome'],'faberConsum.nome',true);
            }

            if(isset($_REQUEST['cidade']) && !empty($_REQUEST['cidade'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['cidade'],'cidade');
            }

            if(isset($_REQUEST['estado']) && !empty($_REQUEST['estado'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['estado'],'estado');
            }

            if(isset($_REQUEST['tipoConsumidor']) && !empty($_REQUEST['tipoConsumidor'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['tipoConsumidor'],'tipoConsumidor');
            }

            if(isset($_REQUEST['publico']) && !empty($_REQUEST['publico'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['publico'],'publico');
            }

            if(isset($_REQUEST['canal']) && !empty($_REQUEST['canal'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['canal'],'faberManifest.canal');
            }

            if(isset($_REQUEST['man1']) && !empty($_REQUEST['man1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man1'],'man1');
            }

            if(isset($_REQUEST['man2']) && !empty($_REQUEST['man2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man2'],'man2');
            }

            if(isset($_REQUEST['man3']) && !empty($_REQUEST['man3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man3'],'man3');
            }

            if(isset($_REQUEST['grupo']) && !empty($_REQUEST['grupo'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['grupo'],'grupo');
            }

            if(isset($_REQUEST['codProd']) && !empty($_REQUEST['codProd'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['codProd'],'codProduto');
            }

            if(isset($_REQUEST['produto']) && !empty($_REQUEST['produto'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['produto'],'produto');
            }

            if(isset($_REQUEST['desc1']) && !empty($_REQUEST['desc1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc1'],'desc1');
            }

            if(isset($_REQUEST['desc2']) && !empty($_REQUEST['desc2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc2'],'desc2');
            }

            if(isset($_REQUEST['desc3']) && !empty($_REQUEST['desc3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc3'],'desc3');
            }

            if(isset($_REQUEST['desc4']) && !empty($_REQUEST['desc4'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc4'],'desc4');
            }
            if(isset($_REQUEST['desc5']) && !empty($_REQUEST['desc5'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc5'],'desc5');
            }

            if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
                $sql.=" AND faberManifest.dt_coleta >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
            }

            if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
                $sql.=" AND faberManifest.dt_coleta <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59' ";
            }


            $query = $this->getEntityManagerFaber()->getConnection()->prepare($sql);
            $query->execute();
            $totalDados = $query->fetchAll();

            if(!empty($totalDados[0]))
                $totalDados = $totalDados[0]['total'];
            else
                $totalDados = 0;

            $iTotalRecords = $totalDados;
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
            $iDisplayStart = intval($_REQUEST['start']);
            $sEcho = intval($_REQUEST['draw']);


            $order = $_REQUEST['order'];

            $orderbyColumn = $order[0]['column'];
            $orderbyDir    = $order[0]['dir'];

            /** QUERY PRINCIPAL **/
            $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1))   + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH pessoas AS
                    (
                        SELECT  faberConsum.cod_cons,nome,cidade,estado,tipoConsumidor,publico,
                                        row_number() OVER (ORDER BY ".$this->getOrderByColumnPessoa($orderbyColumn)." $orderbyDir) as RowNumber
                        FROM faberManifest
                    INNER JOIN faberContato ON faberManifest.cod_mens = faberContato.cod_mens
                    INNER JOIN faberConsum  ON  faberContato.cod_cons = faberConsum.cod_cons
                    WHERE 1=1 
                      ";

            if(isset($_REQUEST['nome']) && !empty($_REQUEST['nome'])){
                $sql.= $relatorioModel->montaWhereSingular($_REQUEST['nome'],'faberConsum.nome',true);
            }

            if(isset($_REQUEST['cidade']) && !empty($_REQUEST['cidade'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['cidade'],'cidade');
            }

            if(isset($_REQUEST['estado']) && !empty($_REQUEST['estado'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['estado'],'estado');
            }

            if(isset($_REQUEST['tipoConsumidor']) && !empty($_REQUEST['tipoConsumidor'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['tipoConsumidor'],'tipoConsumidor');
            }

            if(isset($_REQUEST['publico']) && !empty($_REQUEST['publico'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['publico'],'publico');
            }

            if(isset($_REQUEST['canal']) && !empty($_REQUEST['canal'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['canal'],'faberManifest.canal');
            }

            if(isset($_REQUEST['man1']) && !empty($_REQUEST['man1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man1'],'man1');
            }

            if(isset($_REQUEST['man2']) && !empty($_REQUEST['man2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man2'],'man2');
            }

            if(isset($_REQUEST['man3']) && !empty($_REQUEST['man3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['man3'],'man3');
            }

            if(isset($_REQUEST['grupo']) && !empty($_REQUEST['grupo'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['grupo'],'grupo');
            }

            if(isset($_REQUEST['codProd']) && !empty($_REQUEST['codProd'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['codProd'],'codProduto');
            }

            if(isset($_REQUEST['produto']) && !empty($_REQUEST['produto'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['produto'],'produto');
            }

            if(isset($_REQUEST['desc1']) && !empty($_REQUEST['desc1'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc1'],'desc1');
            }

            if(isset($_REQUEST['desc2']) && !empty($_REQUEST['desc2'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc2'],'desc2');
            }

            if(isset($_REQUEST['desc3']) && !empty($_REQUEST['desc3'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc3'],'desc3');
            }

            if(isset($_REQUEST['desc4']) && !empty($_REQUEST['desc4'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc4'],'desc4');
            }
            if(isset($_REQUEST['desc5']) && !empty($_REQUEST['desc5'])){
                $sql.= $relatorioModel->montaWhere($_REQUEST['desc5'],'desc5');
            }

            if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
                $sql.=" AND faberManifest.dt_coleta >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
            }

            if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
                $sql.=" AND faberManifest.dt_coleta <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59'";
            }

            $sql.="
                    GROUP BY   faberConsum.cod_cons,nome,cidade,estado,tipoConsumidor,publico
                 )
                 SELECT * , (SELECT COUNT(*) FROM pessoas) AS TotalRecords
                        FROM pessoas
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow";


            $query = $this->getEntityManagerFaber()->getConnection()->prepare($sql);
            $query->execute();

            $result = $query->fetchAll();

            $records = array();
            $records["data"] = array();

            foreach($result as $row){
                $records["data"][] = array(
                    intval($row['cod_cons']),
                    $row['nome'],
                    $row['cidade'],
                    $row['estado'],
                    $row['tipoConsumidor'],
                    $row['publico'],

                );
            }

            if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
            }

            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            $records["totalConsumidores"] = $relatorioModel->getTotalConsumidor($_REQUEST);

            return new JsonModel($records);


        }

    private function getOrderByColumnPessoa($idColumn)
    {

        $columns = array(1 => 'nome',
                        2 => 'cidade',
                        3 => 'estado',
                        4 => 'tipoConsumidor',
                        5 => 'publico',
        );

        return $columns[$idColumn];

    }

    public function fupAction()
    {

        $this->layout()->title = 'CRM - Tempo de conclusão de atividades internas';
        $request = $this->getRequest();
        $data = $request->getQuery();
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $origDepto = $relatorioModel->getFilterVProtocolo('depto_from');
        $origAgt   = $relatorioModel->getFilterVProtocolo('nome_agente_from');
        $destDepto = $relatorioModel->getFilterVProtocolo('depto_to');
        $destAgt   = $relatorioModel->getFilterVProtocolo('nome_agente_to');
        $conclAgt   = $relatorioModel->getFilterVProtocolo('nome_agente_encer');
        $evento   = $relatorioModel->getFilterVProtocolo('evento');

        return new ViewModel(array('filtro'=>$data,'origDepto'=>$origDepto, 'origAgt' => $origAgt, 'destDepto' => $destDepto,'destAgt' => $destAgt,
                                        'conclAgt' => $conclAgt,'evento' => $evento));
    }

    public function listFupAction()
    {
        $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
        $sql = "SELECT  count(protocolo_id) as total
                  FROM v_protocolo WHERE 1=1 ";

        if(isset($_REQUEST['ctt']) && !empty($_REQUEST['ctt'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['ctt'],'cod_mens');
        }
        if(isset($_REQUEST['depto_from']) && !empty($_REQUEST['depto_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_from'],'depto_from');
        }

        if(isset($_REQUEST['nome_agente_from']) && !empty($_REQUEST['nome_agente_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_from'],'nome_agente_from');
        }

        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['nome_agente_to']) && !empty($_REQUEST['nome_agente_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_to'],'nome_agente_to');
        }

        if(isset($_REQUEST['nome_agente_encer']) && !empty($_REQUEST['nome_agente_encer'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_encer'],'nome_agente_encer');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['evento'],'evento');
        }

        if(isset($_REQUEST['batepapo']) && !empty($_REQUEST['batepapo'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['batepapo'],'batepapo',true);
        }

        if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND dt_geracao_fup >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
        }else{
            $sql.=" AND dt_geracao_fup >= '2016-07-01 00:00:00'";
        }

        if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
            $sql.=" AND dt_geracao_fup <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59'";
        }else{
            $sql.=" AND dt_geracao_fup <= '2016-07-31 23:59:59'";
        }

        if(isset($_REQUEST['diaini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) >= '{$_REQUEST['diaini']}'";
        }

        if(isset($_REQUEST['diafim']) && !empty($_REQUEST['diafim'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) <= '{$_REQUEST['diafim']}'";
        }

        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();
        $totalDados = $query->fetchAll();

        if(empty($totalDados))
            $totalDados = 0;
        else
            $totalDados = $totalDados[0]['total'];


        $iTotalRecords = $totalDados;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);


        $order = $_REQUEST['order'];

        $orderbyColumn = $order[0]['column'];
        $orderbyDir    = $order[0]['dir'];

        $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1)) + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH vProtocolo AS
                    (
            
                        SELECT  
                                    protocolo_id as id, cod_mens as ctt, depto_from as [depto_orig], nome_agente_from as [agt_orig], 
                                    depto_to as [depto_dest], nome_agente_to as [agt_dest], nome_agente_encer as [agt_concl],evento, 
                                    CONVERT(varchar(20),dt_geracao_fup,103) +' '+ CONVERT(varchar(10),dt_geracao_fup,108) as [dt_fup],
									CONVERT(varchar(20), isNULL(dt_previsao,dt_geracao_fup) + 4,103) +' '+ CONVERT(varchar(10), isNULL(dt_previsao,dt_geracao_fup) + 4,108)  as[dt_prev] ,
									CONVERT(varchar(20),dt_conclusao,103) +' '+ CONVERT(varchar(10),dt_conclusao,108) as [dt_concl],
									batepapo as orientacao,
                                    datediff(day,dt_incl,dt_conclusao) as [tempo_dias], 
                                    datediff(hour,dt_incl,dt_conclusao) as [tempo_horas],
                                    nivelServico = case	when dt_previsao is not NULL and dt_conclusao > isNULL(dt_previsao,dt_geracao_fup) + 4 then 'vencido'
                                                when dt_previsao is not NULL and dt_conclusao <= isNULL(dt_previsao,dt_geracao_fup) + 4 then 'no prazo'
                                                when dt_previsao is  NULL then 'no prazo'
                                                else 'não definido' end,
                                    row_number() OVER (ORDER BY {$this->getOrderByColumnFup($orderbyColumn)} $orderbyDir) as RowNumber

                        FROM v_protocolo WHERE 1=1 ";

        if(isset($_REQUEST['ctt']) && !empty($_REQUEST['ctt'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['ctt'],'cod_mens');
        }

        if(isset($_REQUEST['depto_from']) && !empty($_REQUEST['depto_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_from'],'depto_from');
        }
        if(isset($_REQUEST['nome_agente_from']) && !empty($_REQUEST['nome_agente_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_from'],'nome_agente_from');
        }

        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['nome_agente_to']) && !empty($_REQUEST['nome_agente_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_to'],'nome_agente_to');
        }

        if(isset($_REQUEST['nome_agente_encer']) && !empty($_REQUEST['nome_agente_encer'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_encer'],'nome_agente_encer');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['evento'],'evento');
        }

        if(isset($_REQUEST['batepapo']) && !empty($_REQUEST['batepapo'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['batepapo'],'batepapo',true);
        }

        if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND dt_geracao_fup >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
        }else{
            $sql.=" AND dt_geracao_fup >= '2016-07-01 00:00:00'";
        }

        if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
            $sql.=" AND dt_geracao_fup <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59'";
        }else{
            $sql.=" AND dt_geracao_fup <= '2016-07-31 23:59:59'";
        }

        if(isset($_REQUEST['diaini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) >= '{$_REQUEST['diaini']}'";
        }

        if(isset($_REQUEST['diafim']) && !empty($_REQUEST['diafim'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) <= '{$_REQUEST['diafim']}'";
        }


        $sql.=")
                SELECT * , (SELECT COUNT(*) FROM vProtocolo) AS TotalRecords
                        FROM vProtocolo
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $records = array();
        $records["data"] = array();

        foreach($result as $row){
            $records["data"][] = array(
                $row['id'],
                $row['ctt'],
                $row['depto_orig'],
                $row['agt_orig'],
                $row['depto_dest'],
                $row['agt_dest'],
                $row['agt_concl'],
                $row['evento'],
                $row['dt_fup'],
                $row['dt_prev'],
                $row['dt_concl'],
                $relatorioModel->limitarTexto($row['orientacao'],$row['id']),
                $row['tempo_dias'],
                $row['tempo_horas'],
                $row['nivelServico'],
            );
        }

        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        $records["totalContatos"] = $relatorioModel->getTotalContato($_REQUEST);
        $records["totalConsumidores"] = $relatorioModel->getTotalConsumidor($_REQUEST);

        return new JsonModel($records);
    }



    public function fupPendenteAction()
    {

        $this->layout()->title = 'CRM - Tempo de conclusão de atividades internas';
        $request = $this->getRequest();
        $data = $request->getQuery();
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $origDepto = $relatorioModel->getFilterVProtocolo('depto_from');
        $origAgt   = $relatorioModel->getFilterVProtocolo('nome_agente_from');
        $destDepto = $relatorioModel->getFilterVProtocolo('depto_to');
        $destAgt   = $relatorioModel->getFilterVProtocolo('nome_agente_to');
        $conclAgt   = $relatorioModel->getFilterVProtocolo('nome_agente_encer');
        $evento   = $relatorioModel->getFilterVProtocolo('evento');

        return new ViewModel(array('filtro'=>$data,'origDepto'=>$origDepto, 'origAgt' => $origAgt, 'destDepto' => $destDepto,'destAgt' => $destAgt,
            'conclAgt' => $conclAgt,'evento' => $evento));
    }

    public function listFupPendenteAction()
    {
        $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
        $sql = "SELECT  count(protocolo_id) as total
                  FROM v_protocolo WHERE 1=1 ";

        if(isset($_REQUEST['ctt']) && !empty($_REQUEST['ctt'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['ctt'],'cod_mens');
        }
        if(isset($_REQUEST['depto_from']) && !empty($_REQUEST['depto_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_from'],'depto_from');
        }

        if(isset($_REQUEST['nome_agente_from']) && !empty($_REQUEST['nome_agente_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_from'],'nome_agente_from');
        }

        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['nome_agente_to']) && !empty($_REQUEST['nome_agente_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_to'],'nome_agente_to');
        }

        if(isset($_REQUEST['nome_agente_encer']) && !empty($_REQUEST['nome_agente_encer'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_encer'],'nome_agente_encer');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['evento'],'evento');
        }

        if(isset($_REQUEST['batepapo']) && !empty($_REQUEST['batepapo'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['batepapo'],'batepapo',true);
        }

        if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND dt_geracao_fup >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
        }else{
            $sql.=" AND dt_geracao_fup >= '2016-07-01 00:00:00'";
        }

        if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
            $sql.=" AND dt_geracao_fup <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59'";
        }else{
            $sql.=" AND dt_geracao_fup <= '2016-07-31 23:59:59'";
        }

        if(isset($_REQUEST['diaini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) >= '{$_REQUEST['diaini']}'";
        }

        if(isset($_REQUEST['diafim']) && !empty($_REQUEST['diafim'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) <= '{$_REQUEST['diafim']}'";
        }

        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();
        $totalDados = $query->fetchAll();

        if(empty($totalDados))
            $totalDados = 0;
        else
            $totalDados = $totalDados[0]['total'];


        $iTotalRecords = $totalDados;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);


        $order = $_REQUEST['order'];

        $orderbyColumn = $order[0]['column'];
        $orderbyDir    = $order[0]['dir'];

        $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1)) + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH vProtocolo AS
                    (

                        SELECT
                                    protocolo_id as id, cod_mens as ctt, depto_from as [depto_orig], nome_agente_from as [agt_orig],
                                    depto_to as [depto_dest], nome_agente_to as [agt_dest], nome_agente_encer as [agt_concl],evento,
                                    CONVERT(varchar(20),dt_geracao_fup,103) +' '+ CONVERT(varchar(10),dt_geracao_fup,108) as [dt_fup],
									CONVERT(varchar(20), isNULL(dt_previsao,dt_geracao_fup) + 4,103) +' '+ CONVERT(varchar(10), isNULL(dt_previsao,dt_geracao_fup) + 4,108)  as[dt_prev] ,
									CONVERT(varchar(20),dt_conclusao,103) +' '+ CONVERT(varchar(10),dt_conclusao,108) as [dt_concl],
									batepapo as orientacao,
                                    datediff(day,dt_incl,dt_conclusao) as [tempo_dias],
                                    datediff(hour,dt_incl,dt_conclusao) as [tempo_horas],
                                    nivelServico = case	when dt_previsao is not NULL and dt_conclusao > isNULL(dt_previsao,dt_geracao_fup) + 4 then 'vencido'
                                                when dt_previsao is not NULL and dt_conclusao <= isNULL(dt_previsao,dt_geracao_fup) + 4 then 'no prazo'
                                                when dt_previsao is  NULL then 'no prazo'
                                                else 'não definido' end,
                                    row_number() OVER (ORDER BY {$this->getOrderByColumnFup($orderbyColumn)} $orderbyDir) as RowNumber

                        FROM v_protocolo WHERE 1=1 ";



        if(isset($_REQUEST['depto_from']) && !empty($_REQUEST['depto_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_from'],'depto_from');
        }
        if(isset($_REQUEST['nome_agente_from']) && !empty($_REQUEST['nome_agente_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_from'],'nome_agente_from');
        }

        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['nome_agente_to']) && !empty($_REQUEST['nome_agente_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_to'],'nome_agente_to');
        }

        if(isset($_REQUEST['nome_agente_encer']) && !empty($_REQUEST['nome_agente_encer'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_encer'],'nome_agente_encer');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['evento'],'evento');
        }

        if(isset($_REQUEST['batepapo']) && !empty($_REQUEST['batepapo'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['batepapo'],'batepapo',true);
        }

        if(isset($_REQUEST['dataini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND dt_geracao_fup >= '{$relatorioModel->convertDate($_REQUEST['dataini'])} 00:00:00'";
        }else{
            $sql.=" AND dt_geracao_fup >= '2016-07-01 00:00:00'";
        }

        if(isset($_REQUEST['datafim']) && !empty($_REQUEST['datafim'])){
            $sql.=" AND dt_geracao_fup <= '{$relatorioModel->convertDate($_REQUEST['datafim'])} 23:59:59'";
        }else{
            $sql.=" AND dt_geracao_fup <= '2016-07-31 23:59:59'";
        }

        if(isset($_REQUEST['diaini']) && !empty($_REQUEST['dataini'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) >= '{$_REQUEST['diaini']}'";
        }

        if(isset($_REQUEST['diafim']) && !empty($_REQUEST['diafim'])){
            $sql.=" AND datediff(day,dt_incl,dt_conclusao) <= '{$_REQUEST['diafim']}'";
        }


        $sql.=")
                SELECT * , (SELECT COUNT(*) FROM vProtocolo) AS TotalRecords
                        FROM vProtocolo
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $records = array();
        $records["data"] = array();

        foreach($result as $row){
            $records["data"][] = array(
                $row['id'],
                $row['ctt'],
                $row['depto_orig'],
                $row['agt_orig'],
                $row['depto_dest'],
                $row['agt_dest'],
                $row['agt_concl'],
                $row['evento'],
                $row['dt_fup'],
                $row['dt_prev'],
                $row['dt_concl'],
                $relatorioModel->limitarTexto($row['orientacao'],$row['id']),
                $row['tempo_dias'],
                $row['tempo_horas'],
                $row['nivelServico'],
            );
        }

        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        $records["totalContatos"] = $relatorioModel->getTotalContato($_REQUEST);
        $records["totalConsumidores"] = $relatorioModel->getTotalConsumidor($_REQUEST);

        return new JsonModel($records);
    }


    private function getOrderByColumnFup($idColumn)
    {
        $columns = array(1 => 'cod_mens',
                         2 => 'depto_from',
                         3 => 'nome_agente_from',
                         4 => 'depto_to',
                         5 => 'nome_agente_to',
                         6 => 'nome_agente_encer',
                         7 => 'evento',
                         8 => 'dt_geracao_fup',
                         9 => 'isNULL(dt_previsao,dt_geracao_fup) + 4',
                         10 => 'dt_conclusao',
                         11 => 'batepapo',
                         12 => 'datediff(day,dt_incl,dt_conclusao)',
                         13 => 'datediff(hour,dt_incl,dt_conclusao)',
                         14 => 'nivelServico',

        );

        return $columns[$idColumn];

    }

    public function eventoPendenteAction()
    {
        $this->layout()->title = 'CRM - Eventos Pendentes';
        $request = $this->getRequest();
        $data = $request->getQuery();
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $deptoTo = $relatorioModel->getFilterVInboxPending('depto_to');
        $agtTo   = $relatorioModel->getFilterVInboxPending('agente_to');
        $evento = $relatorioModel->getFilterVInboxPending('evento');

        return new ViewModel(array('deptoTo' => $deptoTo, 'agtTo' => $agtTo,'evento' => $evento));

    }

    public function listEventoPendenteAction()
    {
        $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
        $sql = "SELECT
                               COUNT(*) OVER () AS TotalRecords
                  FROM v_inbox_pending_gerencia
                    WHERE evento <> 'virgem' AND
                        NOT (depto_to = 'SAC' AND evento = 'RESPONSAVEL') AND
                        NOT (depto_to = 'SAC' AND evento = 'CONHECIMENTO') ";

        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['nome_agente_from']) && !empty($_REQUEST['nome_agente_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_from'],'agente_to');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['evento'],'evento');
        }

        if(isset($_REQUEST['agente_destino']) && !empty($_REQUEST['agente_destino'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['agente_destino'],'agente_destino');
        }

        if(isset($_REQUEST['qtde']) && !empty($_REQUEST['qtde'])){
            $sql.= " AND qtde >={$_REQUEST['qtde']} AND qtde <= {$_REQUEST['qtde']}";
        }


        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();
        $totalDados = $query->fetchAll();

        if(empty($totalDados))
            $totalDados = 0;
        else
            $totalDados = $totalDados[0]['TotalRecords'];


        $iTotalRecords = $totalDados;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);


        $order = $_REQUEST['order'];

        $orderbyColumn = $order[0]['column'];
        $orderbyDir    = $order[0]['dir'];

        $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1)) + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH vEventoPendente AS
                    (

                        SELECT depto_to as depto_destino,
                               agente_to as agente_destino,
                               evento,
                               CONVERT(varchar(20),min(dt_transf) ,103) +' '+ CONVERT(varchar(10),min(dt_transf) ,108) as dt_mais_antiga,
                               COUNT(*) as qtde,
                               row_number() OVER (ORDER BY {$this->getOrderByColumnEvento($orderbyColumn)} {$orderbyDir}) AS RowNumber,
                               COUNT(*) OVER () AS TotalRecords
                        FROM v_inbox_pending_gerencia
                        where evento <> 'virgem' AND
                            NOT (depto_to = 'SAC' and evento = 'RESPONSAVEL') AND
                            NOT (depto_to = 'SAC' and evento = 'CONHECIMENTO')  ";
        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['nome_agente_from']) && !empty($_REQUEST['nome_agente_from'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['nome_agente_from'],'agente_to');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['evento'],'evento');
        }

        if(isset($_REQUEST['agente_destino']) && !empty($_REQUEST['agente_destino'])){
            $sql.= $relatorioModel->montaWhere($_REQUEST['agente_destino'],'agente_destino');
        }

        if(isset($_REQUEST['qtde']) && !empty($_REQUEST['qtde'])){
            $sql.= " AND qtde >={$_REQUEST['qtde']} AND qtde <= {$_REQUEST['qtde']}";
        }

        $sql.=" GROUP BY depto_to, agente_to, evento ";

        $sql.=")
                SELECT * , (SELECT COUNT(*) FROM vEventoPendente) AS TotalRecords
                        FROM vEventoPendente
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $records = array();
        $records["data"] = array();

        foreach($result as $row){
            $records["data"][] = array(
                '',
                $row['depto_destino'],
                $row['agente_destino'],
                "<a href='{$this->url()->fromRoute('relatorio',array('action'=>'detalhe-evento'))}?depto_to={$row['depto_destino']}&agente_to={$row['agente_destino']}&evento={$row['evento']}' target='_blank'>".$row['evento']."</a>",
                $row['dt_mais_antiga'],
                $row['qtde'],
                '',

            );
        }

        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        $records["totalContatos"] = count($result);

        return new JsonModel($records);

    }

    public function getOrderByColumnEvento($idColumn)
    {

        $columns = array(1 => 'depto_to',
            2 => 'agente_to',
            3 => 'evento',
            4 => 'min(dt_transf)',
            5 => 'count(*)',

        );

        return $columns[$idColumn];

    }


    public function detalheEventoAction()
    {
        $request = $this->getRequest();
        $data = $request->getQuery();
        return new ViewModel(array('data'=>$data));
    }

    public function listDetalheEventoAction()
    {
        $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
        $sql = "SELECT
                               COUNT(*) OVER () AS TotalRecords
                  FROM v_inbox_pending_gerencia
                    WHERE 1=1 ";

        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['agente_to']) && !empty($_REQUEST['agente_to'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['agente_to'],'agente_to');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['evento'],'evento');
        }


        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();
        $totalDados = $query->fetchAll();

        if(empty($totalDados))
            $totalDados = 0;
        else
            $totalDados = $totalDados[0]['TotalRecords'];


        $iTotalRecords = $totalDados;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);


        $order = $_REQUEST['order'];

        $orderbyColumn = $order[0]['column'];
        $orderbyDir    = $order[0]['dir'];

        $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1)) + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH vEventoPendente AS
                    (

                        SELECT cod_mens,dt_coleta,dt_previsao,dt_transf,
                            tempo_fup_horas_previsto,tempo_fup_horas_decorrido,evento,
                            urgente,mensagem,agente_from,nome,
                            row_number() OVER (ORDER BY {$this->getFilterColumnDetalhe($orderbyColumn)} {$orderbyDir}) AS RowNumber,
                               COUNT(*) OVER () AS TotalRecords
                        FROM v_inbox_pending_gerencia
                        where 1=1  ";

        if(isset($_REQUEST['depto_to']) && !empty($_REQUEST['depto_to'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['depto_to'],'depto_to');
        }

        if(isset($_REQUEST['agente_to']) && !empty($_REQUEST['agente_to'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['agente_to'],'agente_to');
        }

        if(isset($_REQUEST['evento']) && !empty($_REQUEST['evento'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['evento'],'evento');
        }

        $sql.=")
                SELECT * , (SELECT COUNT(*) FROM vEventoPendente) AS TotalRecords
                        FROM vEventoPendente
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $records = array();
        $records["data"] = array();

        foreach($result as $row){
            $records["data"][] = array(
                $row['cod_mens'],
                $this->ajustaData(substr($row['dt_coleta'], 0, 16)),
                $this->ajustaData(substr($row['dt_previsao'], 0, 16)),
                $this->ajustaData(substr($row['dt_transf'], 0, 16)),
                $row['tempo_fup_horas_previsto'],
                $row['tempo_fup_horas_decorrido'],
                $row['evento'],
                $row['urgente'],
                $row['mensagem'],
                $row['agente_from'],
                $row['nome'],


            );
        }

        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        $records["totalContatos"] = count($result);

        return new JsonModel($records);

    }

    public function getFilterColumnDetalhe($idColumn)
    {
        $columns = array(
                        1  => 'dt_coleta',
                        2  => 'dt_previsao',
                        3  => 'dt_transf',
                        4  => 'tempo_fup_horas_previsto',
                        5  => 'tempo_fup_horas_decorrido',
                        6  => 'evento',
                        7  => 'urgente',
                        8  => 'mensagem',
                        9  => 'agente_from',
                        10 => 'nome',
            );

        return $columns[$idColumn];

    }


    public function tempoAtendimentoAction()
    {
        $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());
        $indiceGrafico  = $relatorioModel->getIndiceGrafico();
        $colunasGraficos = $relatorioModel->getColunasGrafico();
        $areaComercial  = $relatorioModel->getValoresGrafico('ÁREA COMERCIAL');
        $emailLivre     = $relatorioModel->getValoresGrafico('EMAIL LIVRE');
        $faleConosco    = $relatorioModel->getValoresGrafico('FALE CONOSCO');
        $midiasSociais  = $relatorioModel->getValoresGrafico('MIDIAS SOCIAIS');
        $reclameAqui    = $relatorioModel->getValoresGrafico('RECLAME AQUI');
        $telefone       = $relatorioModel->getValoresGrafico('TELEFONE');



        return new ViewModel(array('indiceGrafico' => $indiceGrafico, 'colunas' => $colunasGraficos,
                                    'areaComercial'=> $areaComercial, 'emailLivre' => $emailLivre,
                                    'faleConosco' => $faleConosco,'midiasSociais' => $midiasSociais,
                                    'reclameAqui' => $reclameAqui,'telefone' => $telefone,
                                    ));
    }


    public function entradaContatoAction()
    {
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $indiceGrafico  = $relatorioModel->getIndiceGraficoEntradaCtt();
        $areaComercial  = $relatorioModel->getValoresGraficoEnt('ÁREA COMERCIAL HTH');
        $emailLivre  = $relatorioModel->getValoresGraficoEnt('EMAIL LIVRE');
        $faleConosco  = $relatorioModel->getValoresGraficoEnt('FALE CONOSCO HTH');
        $telefone  = $relatorioModel->getValoresGraficoEnt('TELEFONE');

        return new ViewModel(array('indiceGrafico' => $indiceGrafico,'areaComercial' => $areaComercial,
                                    'emailLivre' => $emailLivre,'faleConosco' => $faleConosco,
                                    'telefone' => $telefone ));
    }


    public function filtroEntradaContatoAction()
    {
        $request = $this->getRequest();
        $data = $request->getQuery();


        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $indiceGrafico  = $relatorioModel->getIndiceGraficoEntradaCtt();
        $areaComercial  = $relatorioModel->getValoresGraficoEnt('ÁREA COMERCIAL HTH',array('filtro'=>$data['filtro'],'qtde' => $data['qtde']));
        $emailLivre  = $relatorioModel->getValoresGraficoEnt('EMAIL LIVRE',array('filtro'=>$data['filtro'],'qtde' => $data['qtde']));
        $faleConosco  = $relatorioModel->getValoresGraficoEnt('FALE CONOSCO HTH',array('filtro'=>$data['filtro'],'qtde' => $data['qtde']));
        $telefone  = $relatorioModel->getValoresGraficoEnt('TELEFONE',array('filtro'=>$data['filtro'],'qtde' => $data['qtde']));

        $filtro = array('filtro'=>$data['filtro'],'qtde' => $data['qtde']);

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setVariables(array('indiceGrafico' => $indiceGrafico,'areaComercial' => $areaComercial,
            'emailLivre' => $emailLivre,'faleConosco' => $faleConosco,
            'telefone' => $telefone,'filtro'=>$filtro ));
        return $viewModel;
    }

    public function cartaEmailAction()
    {

        return new ViewModel();
    }

    public function listCartaEmailAction()
    {
        $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());

        $sql = "SELECT count(*) as TotalRecords FROM cartas_email WHERE 1=1 ";

        if(isset($_REQUEST['carta']) && !empty($_REQUEST['carta'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['carta'],'carta',true);
        }

        if(isset($_REQUEST['descr']) && !empty($_REQUEST['descr'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['descr'],'descr',true);
        }

        if(isset($_REQUEST['modelo']) && !empty($_REQUEST['modelo'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['modelo'],'modelo',true);
        }

        if(isset($_REQUEST['status-filtro']) && !empty($_REQUEST['status-filtro'])){
            $sql.= $relatorioModel->montaWhereSingular(0,'ativo');
        }


        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();
        $totalDados = $query->fetchAll();

        if(empty($totalDados))
            $totalDados = 0;
        else
            $totalDados = $totalDados[0]['TotalRecords'];


        $iTotalRecords = $totalDados;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);


        $order = $_REQUEST['order'];

        $orderbyColumn = $order[0]['column'];
        $orderbyDir    = $order[0]['dir'];

        $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1)) + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH cartaEmail AS
                    (

                        SELECT id,carta,descr,modelo,ativo,
                            row_number() OVER (ORDER BY {$this->getFilterCartaEmail($orderbyColumn)} {$orderbyDir}) AS RowNumber,
                               COUNT(*) OVER () AS TotalRecords
                        FROM cartas_email
                        where 1=1  ";

        if(isset($_REQUEST['carta']) && !empty($_REQUEST['carta'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['carta'],'carta',true);
        }

        if(isset($_REQUEST['descr']) && !empty($_REQUEST['descr'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['descr'],'descr',true);
        }

        if(isset($_REQUEST['modelo']) && !empty($_REQUEST['modelo'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['modelo'],'modelo',true);
        }

        if(isset($_REQUEST['status-filtro']) && !empty($_REQUEST['status-filtro'])){
            $sql.= $relatorioModel->montaWhereSingular(0,'ativo');
        }

        $sql.=")
                SELECT * , (SELECT COUNT(*) FROM cartaEmail) AS TotalRecords
                        FROM cartaEmail
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

//        print_r($sql);
        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $records = array();
        $records["data"] = array();

        foreach($result as $row){
            $records["data"][] = array(
                $row['id'],
                $row['carta'],
                $row['descr'],
                $relatorioModel->limitarTexto($row['modelo'],$row['id']),
//                $row['ativo'],
                "<a href='{$this->url()->fromRoute('relatorio',array('action'=>'edita-carta-email','id'=>$row['id']))}' class='btn green'> Editar </a>",
           );
        }



        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        $records["totalContatos"] = count($result);

        return new JsonModel($records);
    }


    protected function getFilterCartaEmail($idColumn){

        $filter = array(1 => 'carta',
                        2 => 'descr',
                        3 => 'modelo',
            );

        return $filter[$idColumn];

    }



    public function addCartaEmailAction()
    {
        $id = $this->params()->fromRoute('id',0);
        $request = $this->getRequest();
        $form = new CartasEmailForm();
        $success = null;

        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
                $relatorioModel->addCartaEmail($data);
                $success = "Resposta automática adicionada com sucesso";
            }
        }


        return new ViewModel(array('form'=>$form,'success'=>$success));
    }

    public function editaCartaEmailAction()
    {
        $id = $this->params()->fromRoute('id',0);
        $request = $this->getRequest();
        $form = new CartasEmailForm();
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $relatorioModel->setCartaEmail($id);
        $populateValues = $relatorioModel->populateCartaEmail();

        if(!empty($populateValues))
            $form->populateValues($populateValues);

        $success = null;

        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $relatorioModel->updateCartaEmail($data,$id);
                $success = "Resposta automática atualizada com sucesso";
            }
        }


        return new ViewModel(array('form'=>$form,'success'=>$success));
    }


    public function getModeloCartaEmailAction()
    {
        $id = $this->params()->fromRoute('id',0);
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $cartaEmail = $relatorioModel->setCartaEmail($id)->getCartaEmail();

        if(!empty($cartaEmail))
            $modelo = $cartaEmail->modelo;
        else
            $modelo = null;


        return new JsonModel(array('modelo'=>$modelo));

    }

    public function glossaryAction()
    {
        return new ViewModel(array());
    }

    public function listGlossaryAction()
    {

        $relatorioModel = new RelatorioModel($this->getEntityManagerFaber());

        $sql = "SELECT count(*) as TotalRecords FROM glossary_email WHERE 1=1 ";

        if(isset($_REQUEST['verbete']) && !empty($_REQUEST['verbete'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['verbete'],'verbete',true);
        }

//        if(isset($_REQUEST['glossario']) && !empty($_REQUEST['glossario'])){
//            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['glossario'],'glossario',true);
//        }

        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();
        $totalDados = $query->fetchAll();

        if(empty($totalDados))
            $totalDados = 0;
        else
            $totalDados = $totalDados[0]['TotalRecords'];


        $iTotalRecords = $totalDados;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);


        $order = $_REQUEST['order'];

        $orderbyColumn = $order[0]['column'];
        $orderbyDir    = $order[0]['dir'];

        $sql = "
                DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = ((({$_REQUEST['start']}+1) - 1)) + 1,
                            @LastRow    = ((({$_REQUEST['start']}+1) - 1)) + {$_REQUEST['length']};
                    WITH glossaryEmail AS
                    (

                        select id,verbete,glossario,
                            row_number() OVER (ORDER BY {$this->getFilterGlossary($orderbyColumn)} {$orderbyDir}) AS RowNumber,
                               COUNT(*) OVER () AS TotalRecords
                        FROM glossary_email
                        where 1=1  ";

        if(isset($_REQUEST['verbete']) && !empty($_REQUEST['verbete'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['verbete'],'verbete',true);
        }

        if(isset($_REQUEST['glossario']) && !empty($_REQUEST['glossario'])){
            $sql.= $relatorioModel->montaWhereSingular($_REQUEST['glossario'],'glossario',true);
        }

        $sql.=")
                SELECT * , (SELECT COUNT(*) FROM glossaryEmail) AS TotalRecords
                        FROM glossaryEmail
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

//        print_r($sql);
        $query = $this->getEntityManagerHth()->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        $records = array();
        $records["data"] = array();

        foreach($result as $row){
            $records["data"][] = array(
                $row['id'],
                $row['verbete'],
                $relatorioModel->limitarTexto($row['glossario'],$row['id']),
//                $row['ativo'],
                "<a href='{$this->url()->fromRoute('relatorio',array('action'=>'edita-glossary','id'=>$row['id']))}' class='btn green'> Editar </a>",
            );
        }


        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        $records["totalContatos"] = count($result);

        return new JsonModel($records);
    }

    public function addGlossaryAction()
    {
        $request = $this->getRequest();
        $form = '';

        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){

            }
        }

        return new ViewModel(array('form'=>$form));
    }


    public function editaGlossaryAction()
    {
        $id = $this->params()->fromRoute('id',0);
        $request = $this->getRequest();
        $form = new GlossaryForm();
        $success = null;
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $populateValues = $relatorioModel->setGlossary($id)->populateGlossary();
        if(!empty($populateValues))
            $form->populateValues($populateValues);

        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){

                $success = "Glossario editado com sucesso";
            }
        }

        return new ViewModel(array('form'=>$form,'success'=>$success));
    }

    public function getGlossaryAction()
    {
        $id = $this->params()->fromRoute('id',0);
        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $glossary = $relatorioModel->setGlossary($id)->getGlossary();

        if(!empty($glossary))
            $glossary = $glossary->glossario;
        else
            $glossary = null;

        return new JsonModel(array('glossario' => $glossary));

    }

    protected function getFilterGlossary($idColumn){

        $filter = array(1=>'verbete',
                        2=>'glossario');

        return $filter[$idColumn];

    }


    public function getOrientacaoAction()
    {
        $request = $this->getRequest();
        $data = $request->getPost();

        $relatorioModel = new RelatorioModel($this->getEntityManagerHth());
        $protocolo =  $relatorioModel->getProtocolo($data['idProtocolo']);

        if(!empty($protocolo))
            $orientacao = $protocolo[0]['batepapo'];
        else
            $orientacao = '';

        $orientacao = ucfirst(mb_convert_case($orientacao, MB_CASE_LOWER, "UTF-8"));
        return new JsonModel(array('orientacao'=>$orientacao));
    }

    public function ajustaData($date)
    {
        if(!empty($date))
            $date = explode(' ',$date);
        else
            return null;

        $newDate = explode('-',$date[0]);
        $result = $newDate[2]."/".$newDate[1]."/".$newDate[0];

        $result.=" ".$date[1];

        return $result;

    }


}
