<?php
/**
 * Created by PhpStorm.
 * User: diego.santos
 * Date: 15/08/2016
 * Time: 12:45
 */

namespace Application\Model;


use Application\Entity\Tags;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\DateTime;

class MencaoModel
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Tags
     */
    private $tag;

    private $monitoring;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setMonitoring($idMonitoring)
    {
        $this->monitoring = $idMonitoring;
        return $this;
    }

    public function getMonitoring()
    {
        if(!$this->monitoring)
            return 0;

        return $this->monitoring;
    }

    public function setTag($idTag)
    {
        $this->tag = $this->entityManager->getRepository('Application\Entity\Tags')->findOneBy(array('idTag'=>$idTag));

        return $this;
    }

    public function getTag()
    {
        if(!$this->tag)
            return null;

        return $this->tag;
    }



    public function getTags()
    {
        $tags = $this->entityManager->getRepository('Application\Entity\Tags')->findBy(array('idMonitoring'=>$this->monitoring));
        return $tags;
    }
    public function getConversas($offset = 1, $limit = 15,$dataIni = null, $dataFim = null, $nomePessoa = '', $post= '', $resp = '', $tpSentimento = null, $tpCanal = null, $tags= null, $minInteracao= null, $maxInteracao= null,$order ='canal',$sense = 'asc')
    {

        if(empty($dataIni))
            $dataIni = date('Y-m-d', strtotime('-2 day'));
        else
            $dataIni = $this->converterData($dataIni);

        if(empty($dataFim))
            $dataFim = date('Y-m-d', strtotime('-1 day'));
        else
            $dataFim = $this->converterData($dataFim);

        $result= array();
        $query = "DECLARE @FirstRow INT, @LastRow INT
                    SELECT  @FirstRow   = (({$offset} - 1) * {$limit}) + 1,
                            @LastRow    = (({$offset} - 1) * {$limit}) + {$limit};
                    WITH conversas AS
                    (
                        SELECT canal.canal, Conversa.idCanal, 
                                        POSTS.id_conversa,
                                        nome = CASE 
                                            when Conversa.idCanal between 1 and 3	then usuFB.nome 
                                            when Conversa.idCanal = 4				then usuIns.nome
                                            else '' end, 
                                        foto_perfil = CASE 
                                            when Conversa.idCanal between 1 and 3	then usuFB.foto_usuario 
                                            when Conversa.idCanal = 4				then usuIns.foto_perfil
                                        else '' end, 
                                        CONVERT(varchar(30),POSTS.dt_post,103) as dt_post,
                                        CONVERT(varchar(30),POSTS.dt_post,108) as hh_post,
                                        POSTS.post, POSTS.resp, POSTS.sentimento, POSTS.tag, POSTS.permalink
                               , row_number() OVER (ORDER BY canal, POSTS.id_conversa, CONVERT(varchar(30),POSTS.dt_post,103), CONVERT(varchar(30),POSTS.dt_post,108) ASC) as RowNumber 
                        FROM POSTS INNER JOIN Conversa ON POSTS.id_conversa = Conversa.id_conversa
                                        INNER JOIN tab_canais canal ON Conversa.idCanal = canal.idCanal
                                        LEFT OUTER JOIN usuarios_facebook usuFB ON POSTS.idUser = usuFB.[id_usuarios_facebook]
                                LEFT OUTER JOIN usuarios_instagram usuIns ON POSTS.idUser = isNULL(usuIns.[id_usuarios_instagram],'') 
                        WHERE POSTS.id_conversa IN  (
                                    select distinct id_conversa from Conversa where id_mention IN 
                                            (select id_mention from POSTS pd
                                                            where pd.dt_post between '{$dataIni}' and '{$dataFim}' ";

                                            if(!empty($post))
                                                    $query.=" AND pd.post LIKE '%{$post}%' ";
                                            if(!empty($resp))
                                                    $query.=" AND pd.resp LIKE '%{$resp}%' ";

                                            $query.=")
                                                    )";

                            if(!empty($nomePessoa))
                                $query.=" AND (usuFB.nome like '%{$nomePessoa}%' OR usuIns.nome like '%{$nomePessoa}%')";


                            if(!empty($tpSentimento)){
                                $query.=" AND (";

                                $countTpSentimento = count($tpSentimento);
                                $iTpSentimento = 1;

                                foreach ($tpSentimento as $key=> $value){
                                    $query.= " sentimento = '{$key}'";

                                    if($iTpSentimento < $countTpSentimento)
                                        $query.=" OR ";

                                    $iTpSentimento++;

                                }
                                $query.=" )";
                            }

                            if(!empty($tpCanal)){
                                $countTpCanal = count($tpCanal);
                                $iTpCanal = 1;
                                $query.=" AND (";
                                foreach ($tpCanal as $keyCanal=> $valueCanal){
                                    $query.= " Conversa.idCanal = '{$keyCanal}'";

                                    if($iTpCanal < $countTpCanal)
                                        $query.=" OR ";

                                    $iTpCanal++;
                                }
                                $query.=" )";
                            }


        $query.=")
                        SELECT * , (SELECT COUNT(*) FROM conversas) AS TotalRecords
                        FROM conversas
                        WHERE RowNumber BETWEEN @FirstRow AND @LastRow
                        ORDER BY RowNumber ASC";

//        \Zend\Debug\Debug::dump($query);

        $sql = $this->entityManager->getConnection()->prepare($query);
        $sql->execute();

        $result = $sql->fetchAll();

        return $result;
    }

    public function getTotalConversa($dataIni = null, $dataFim = null, $nomePessoa = '', $post= '', $resp = '', $tpSentimento = null, $tpCanal = null,  $tags= null, $minInteracao= null, $maxInteracao= null,$order ='canal',$sense = 'asc')
    {

        if(empty($dataIni))
            $dataIni = date('Y-m-d', strtotime('-2 day'));
        else
            $dataIni = $this->converterData($dataIni);

        if(empty($dataFim))
            $dataFim = date('Y-m-d', strtotime('-1 day'));
        else
            $dataFim = $this->converterData($dataFim);

        $result= array();
        $query = "SELECT count(distinct(posts.id_conversa)) as totalConversas
                        FROM POSTS INNER JOIN Conversa ON POSTS.id_conversa = Conversa.id_conversa
                                        INNER JOIN tab_canais canal ON Conversa.idCanal = canal.idCanal
                                        LEFT OUTER JOIN usuarios_facebook usuFB ON POSTS.idUser = usuFB.[id_usuarios_facebook]
                                LEFT OUTER JOIN usuarios_instagram usuIns ON POSTS.idUser = isNULL(usuIns.[id_usuarios_instagram],'') 
                        WHERE POSTS.id_conversa IN  (
                                    select distinct id_conversa from Conversa where id_mention IN 
                                            (select id_mention from POSTS pd
                                                            where pd.dt_post between '{$dataIni}' and '{$dataFim}' ";

                                    if(!empty($post))
                                        $query.=" AND pd.post LIKE '%{$post}%' ";
                                    if(!empty($resp))
                                        $query.=" AND pd.resp LIKE '%{$resp}%' ";

                                     $query.=")
                                     )";

                        if(!empty($nomePessoa))
                            $query.=" AND (usuFB.nome like '%{$nomePessoa}%' OR usuIns.nome like '%{$nomePessoa}%')";

                        if(!empty($tpSentimento)){
                            $query.=" AND (";

                            $countTpSentimento = count($tpSentimento);
                            $iTpSentimento = 1;

                            foreach ($tpSentimento as $key=> $value){
                                $query.= " sentimento = '{$key}'";

                                if($iTpSentimento < $countTpSentimento)
                                    $query.=" OR ";

                                $iTpSentimento++;

                            }
                            $query.=" )";
                        }

                        if(!empty($tpCanal)){
                            $countTpCanal = count($tpCanal);
                            $iTpCanal = 1;
                            $query.=" AND (";
                                foreach ($tpCanal as $keyCanal=> $valueCanal){
                                    $query.= " Conversa.idCanal = '{$keyCanal}'";

                                    if($iTpCanal < $countTpCanal)
                                        $query.=" OR ";

                                    $iTpCanal++;
                                }
                            $query.=" )";
                        }


        $sql = $this->entityManager->getConnection()->prepare($query);
        $sql->execute();

        $result = $sql->fetchAll();

        return $result;
    }


    protected function converterData($date)
        {
        $list = explode('/',$date);
        $newDate = $list[2]."-".$list[1]."-".$list[0];
        return $newDate;
    }

}