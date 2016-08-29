<?php
namespace Application\Model;

use Doctrine\ORM\EntityManager;
use Application\Entity\Mencao;
use Application\Entity\UsuariosFacebook;
use Application\Entity\UsuariosInstagram;
use Application\Entity\TicketMencao;
use Application\Entity\TagMencao;
use Application\Entity\Tags;
class ScupApiModel {
    
    
    /**
     * @param EntityManager
     *
     * **/
    private $entityManager;
    
    /**
     * @param UsuariosFacebook
     * 
     * **/
    private $usuariosFacebook;
    
    /**
     * @param UsuariosInstagram
     *
     * **/
    private $usuariosInstagram;
    
    /**
     * @param Mencao
     * */
    private $mention;

    
    /**
     * @param TicketMencao
     * */
    private $ticket;

    /**
     * @param Tags
     * */
    private $tag;
    
    
    /**
     * @param TagMencao
     * */
    private $tagMention;
    
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    
    /***
     * @var getUrl Get com os filtros
     * @descript   Retorna as monitorações cadastradas no Scup
     * return      Object
     * */
    public function getMonitoring($getUrl)
    {
         
       $url = "http://api.scup.com/1.1/monitorings/?".$getUrl;
         
        $ch = curl_init();
         
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
         
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));
         
        $response = curl_exec($ch);
        curl_close($ch);


        return json_decode($response);
         
    }
     
     /***
      * @var getUrl Get com os filtros
      * @descript   Retorna as pesquisas cadastradas no Scup por idMonitoração
      * return      Object
      * */
     public function getSearchs($options = array(),$getUrl)
     {
          
         $url = "http://api.scup.com/1.1/searches/".$options['idMonitoring']."/?".$getUrl;
          
         $ch = curl_init();
          
         curl_setopt($ch, CURLOPT_URL, $url );
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($ch, CURLOPT_HEADER, FALSE);
          
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             "Accept: application/json"
         ));
          
         $response = curl_exec($ch);
         curl_close($ch);
          
         return json_decode($response);
          
     }
    
     
     /***
      * @var        int $idMonitoring
      * @var        get $getUrl  = get com os filtros
      * @descript   Retorna as menções filtradas
      * return      Object
      * */
     public function getMetions($options = array(),$getUrl)
     {
          
         $url = "http://api.scup.com/1.1/mentions/".$options['idMonitoring']."/?".$getUrl;
          
         $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $url );
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($ch, CURLOPT_HEADER, FALSE);
          
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             "Accept: application/json"
         ));
          
         $response = curl_exec($ch);
         curl_close($ch);
          
         if(!empty($response) && $options['sync'] == true)
             $this->sincronizarMencao(json_decode($response),$options['idMonitoring']);
          
         return json_decode($response);
          
     }
     
     /***
      * @var Object $data
      * @var int $idSearch
      * @description Grava na base de dados as menções captadas e faz a verificação se existe ou não
      * */
     public function sincronizarMencao($data,$idMonitoring)
     {  
         if(isset($data->data->error_code) || empty($data) || !isset($data->data))
             return false;
         
         foreach($data->data as $values){
             
             if(isset($values->mention->id)){
                 
                 $this->setMention($values->mention->id);
                 
                 if(empty($this->mention)){
                     $result = false;
                     $this->entityManager->getConnection()->beginTransaction();
                     $mention = new Mencao();
                     $mention->setDtEnvio(new \DateTime('now'));
                     $mention->setIdMention($values->mention->id);
                     $mention->setIdMonitoring($idMonitoring);
                     $mention->setDtEnvio(new \DateTime($values->mention->published_at));
                     $mention->setDtColetaScup(new \DateTime($values->mention->collected_at));
                     $mention->setTipoCaptura($values->search->search_type_name);
                     $mention->setSentimento($values->mention->sentiment);
                     $mention->setPermalink($values->mention->content->permalink);
                     
                        switch ($values->search->search_type_name){
                            case 'twitterstream':
                                $mention->setMensagem($values->mention->content->permalink);
                            break;
                            case 'facebookmessages':
                                $list = explode('PICTURE:', $values->mention->content->description);
                                $description = explode('LINK:', $list[0]);
                                $mention->setMensagem($description[0]);
                            break;
                            case 'facebookwall':
                                $list = explode('PICTURE:', $values->mention->content->description);
                                $description = explode('LINK:', $list[0]);
                                $mention->setMensagem($description[0]);
                            break;
                            case 'instagramtags':
                                $list = explode('PICTURE:', $values->mention->content->description);
                                $description = explode('LINK:', $list[0]);
                                $mention->setMensagem($description[0]);
                            break;
                        }   
                     
                     if(!empty($values->parent->id)){
                         $mention->setParentId($values->parent->id);
                     }
                     
                     if(!empty($values->user->facebook_id)){
                         $userFacebook = $this->addUsuariosFacebook($values->user)->getUsuariosFacebook();
                         $mention->setIdUsuarioFacebook($userFacebook->getIdUsuariosFacebook());
                     }
                     
                     if(!empty($values->user->instagram_id)){
                         $mention->setIdUsuarioInstagram($this->addUsuariosInstagram($values->user)->getUsuariosInstagram()->getIdUsuariosInstagram());
                     }
                     
                     if(!empty($values->ticket->ticket_id)){
                         $this->addTickets(array('ticket_id'   => $values->ticket->ticket_id,
                                                 'assignee_id' => $values->ticket->assignee_id,
                                                 'status'      => $values->ticket->status,
                                                 'id_mention'  => $values->mention->id,
                                            ));
                         
                     }
                     
                     try{
                         $this->entityManager->persist($mention);
                         $this->entityManager->flush();
                         
                         $this->entityManager->getConnection()->commit();
                         $result = true;
                     }catch(\Exception $e){
                         $this->entityManager->getConnection()->rollBack();
                         throw new \Exception($e->getMessage());
                     }
                     
                     $tags = $this->getTagsMention(array('idMonitoring'=>$idMonitoring), $values->mention->id);
                     
                     if(!empty($tags) && isset($tags->data) && !isset($tags->data[0]->error_code) && $result == true){
                         foreach($tags->data as $valuesTags){
                             if(!empty($valuesTags->action_id))
                                $this->addTagMention(array('action_id'=>$valuesTags->action_id, 'mention_id' => $values->mention->id));
                         }
                     }
                 }
            }
         }
         
     }
     
     /***
      * @var int $idMention
      * @description seta a menção
      * return class
      * */
     public function setMention($idMention)
     {
         $this->mention = $this->entityManager->getRepository('Application\Entity\Mencao')->findOneBy(array('idMention'=>$idMention));
          
         return $this;
     }
     
     /***
      * @var int $idMention
      * @description seta a menção
      * return Mention
      * */
     public function getMention() 
     {
     
         if(!$this->mention)
             throw new \Exception("Menção não encontrada");
     
         return $this->mention;
     
     }
     
     /** METODOS FACEBOOK **/
     
     /***
      * @var int $idFacebook
      * @var string $nomeFacebook
      * @var string $fotoUsuario
      * @description Adiciona o usuario facebook a tabela UsuariosFacebook
      * return Mention
      * */
     public function addUsuariosFacebook($data)
     {
         
         $this->setUsuariosFacebook($data->facebook_id);
         
         if(empty($this->usuariosFacebook)){
             $this->usuariosFacebook = new UsuariosFacebook();
             $this->usuariosFacebook->setIdFacebook($data->facebook_id)
                                     ->setNome($data->facebook_name)
                                     ->setFotoUsuario($data->picture)
                                     ->setDescricao($data->description)
                                     ->setDocumento($data->document)
                                     ->setEmail($data->email)
                                     ->setLocalizacao($data->location);
             
             try{
                 $this->entityManager->persist($this->usuariosFacebook);
                 $this->entityManager->flush();
                 
             }catch(\Exception $e){
                 throw new \Exception($e->getMessage());
             }
         }
         
        return $this; 
     }
     
     /***
      * @var int $idFacebook
      * @description seta o usuário facebook
      * return class
      * */
     public function setUsuariosFacebook($idFacebook)
     {
         $this->usuariosFacebook = $this->entityManager->getRepository('Application\Entity\UsuariosFacebook')->findOneBy(array('idFacebook'=>$idFacebook));
         
         return $this;
     }
     
     
     /***
      * @description Pega Usuarios Facebook
      * return UsuariosFacebook
      * */
     public function getUsuariosFacebook() 
     {
            
        if(!$this->usuariosFacebook)
            throw new \Exception("Usuario não encontrado"); 
        
        return $this->usuariosFacebook;
            
     }
     
     
     /** METODOS INSTAGRAM **/
     
     /***
      * @var int $idInstragram
      * @var string $nomeInstagram
      * @var string $fotoUsuario
      * @description Adiciona o usuario instagram a tabela UsuariosInstagram
      * return Mention
      * */
     public function addUsuariosInstagram($data)
     {
         $this->setUsuariosInstagram($data->instagram_id);
         if(empty($this->usuariosInstagram)){
             $this->usuariosInstagram = new UsuariosInstagram();
             $this->usuariosInstagram->setIdInstagram($data->instagram_id)
             ->setNome($data->instagram_name)
             ->setFotoPerfil($data->picture)
             ->setDescricao($data->description)
             ->setDocumento($data->document)
             ->setEmail($data->email)
             ->setLocalizacao($data->location);
                
             try{
                 $this->entityManager->persist($this->usuariosInstagram);
                 $this->entityManager->flush();
                 
             }catch(\Exception $e){
                 throw new \Exception($e->getMessage());
             }
         }
          
         return $this;
     }
     
     
     /***
      * @var int $idInstagram
      * @description seta o usuário instagram
      * return class
      * */
     public function setUsuariosInstagram($idInstagram)
     {
         $this->usuariosInstagram = $this->entityManager->getRepository('Application\Entity\UsuariosInstagram')->findOneBy(array('idInstagram'=>$idInstagram));
          
         return $this;
     }
     
     
     /***
      * @description Pega Usuarios Instagram
      * return UsuariosInstagram
      * */
     public function getUsuariosInstagram() 
     {
     
         if(!$this->usuariosInstagram)
             throw new \Exception("Usuario não encontrado");
     
         return $this->usuariosInstagram;
     
     }
     
     
     /** METODOS TICKETS **/
     
     
     /***
      * @var array $data
      * @description Adiciona os tickets
      * return Object
      * */
     public function addTickets($data = array()){
         $this->entityManager->getConnection()->beginTransaction();
         $this->ticket = new TicketMencao();
         $this->ticket->setAssinaturaId($data['assignee_id'])
                ->setTicketId($data['ticket_id'])
                ->setStatus($data['status'])
                ->setIdMention($data['id_mention']);
         
            try{
                 $this->entityManager->persist($this->ticket);
                 $this->entityManager->flush();
                 $this->entityManager->getConnection()->commit();
             }catch(\Exception $e){
                 $this->entityManager->getConnection()->rollBack();
                 throw new \Exception($e->getMessage());
             }
         return $this;
     }
     
     
     /** METODOS TAGS **/
     
    
     /***
      * @var int $idTagAction
      * @description seta a Tag
      * return Object
      * */
    public function setTag($idTagAction){
        $this->tag = $this->entityManager->getRepository('Application\Entity\Tags')->findOneBy(array('idTagAction'=>$idTagAction));
        
        return $this;
    }
    
    /***
     * @description returna a Tag setada
     * return Object
     * */
    public function getTag(){
        return $this->tag;
    }
     
    /**
     * @var array $options
     * @description Captura todas as Tags cadastradas no Scup
     * return Object
     * */
    public function getTags($options = array('idMonitoring')){
        
        http://api.scup.com/1.1/tags/35/?publickey=VyYKI7hf&time=1308596542&signature=90f0b5162d8ac448aaf549709e414cc5&type=mention
        $time = time();
         
        $url = "http://api.scup.com/1.1/tags/".$options['idMonitoring']."/?publickey=".PUBLIC_KEY."&time=".$time."&signature=".md5($time.PRIVATE_KEY)."&type=mention";
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response);
    }
    
    /***
     * @var array $options
     * @var bigint $idMention
     * @description Captura os Ids das tags da lencao atraves do log
     * return Object
     * */
    public function getTagsMention($options = array(),$idMention){
        $time = time();
         
        $url = "http://api.scup.com/1.1/logmentions/".$options['idMonitoring']."/?publickey=".PUBLIC_KEY."&time=".$time."&signature=".md5($time.PRIVATE_KEY)."&mention_id=".$idMention."&action=tag&ipp=100&page=1";        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response);
        
    }
    
    public function addTagMention($dataTags = array()){

        if(!empty($this->setTag($dataTags['action_id'])->getTag())){
            $this->entityManager->getConnection()->beginTransaction();
            try{
                $this->tagMention = new TagMencao();
                $this->tagMention->setIdTag($this->getTag())
                             ->setIdMencao($this->setMention($dataTags['mention_id'])->getMention());

                $this->entityManager->persist($this->tagMention);
                $this->entityManager->flush();
                $this->entityManager->getConnection()->commit();
            }catch(\Exception $e){
                $this->entityManager->getConnection()->rollBack();
                throw new \Exception($e->getMessage());
            }
        }
    }
    
    /***
     * @var Object data
     * description Captura todas as Tags do Scup e sincroniza na base
     * @return ScupApiModel
     * */
    public function sincronizarTags($data,$idMonitoring){
        if(!empty($data->data) && !isset($data->data->error_code)){
            foreach($data->data as $valuesTags){
                $this->entityManager->getConnection()->beginTransaction();
                $this->setTag($valuesTags->id);
                
                if(empty($this->getTag())){
                    $tag = new Tags();
                    $tag->setIdTagAction($valuesTags->id)
                        ->setTag($valuesTags->name)
                        ->setIdMonitoring($idMonitoring);
                    
                    try{
                        $this->entityManager->persist($tag);
                        $this->entityManager->flush();
                        $this->entityManager->getConnection()->commit();
                    }catch(\Exception $e){
                        $this->entityManager->getConnection()->rollBack();
                        throw new \Exception($e->getMessage());
                    }
                }
            }
        }
        return $this;
    }


     
 }