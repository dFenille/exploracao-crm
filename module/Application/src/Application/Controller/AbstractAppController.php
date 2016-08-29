<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;

class AbstractAppController extends AbstractActionController
{   
    /**
     * The EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
	protected $entityManager;

    /**
     * The EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManagerFaber;

    /**
     * The EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManagerHth;

	/**
	 * The PhpRenderer.
	 *
	 * @var \Zend\View\Renderer\PhpRenderer
	 */
	protected $renderer;
	
	public function getEntityManager()
	{
		if(! $this->entityManager ){
			$this->entityManager = $this->getServiceLocator()->get( 'Doctrine\ORM\EntityManager' );
		}
	
		return $this->entityManager;
	}

    public function getEntityManagerFaber()
    {
        if(! $this->entityManagerFaber ){

            $this->entityManagerFaber = $this->getServiceLocator()->get( 'doctrine.entitymanager.orm_crawler' );
        }

        return $this->entityManagerFaber;
    }

    public function getEntityManagerHth()
    {
        if(! $this->entityManagerHth ){

            $this->entityManagerHth = $this->getServiceLocator()->get( 'doctrine.entitymanager.orm_hth' );
        }

        return $this->entityManagerHth;
    }

	public function getServiceRenderer()
	{
	    if( !$this->renderer ){
	        $this->renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
	    }
	    return $this->renderer;
	}
	
	public function getNewId(){
	    $strQuery = " SELECT (CONVERT([varchar](60),newid())) as token";
	    $query = $this->getEntityManager()->getConnection()->prepare($strQuery);
	    $query->execute();
	
	    return $query->fetchColumn();
	}
	
	public function getConfig(){
		return $this->getServiceLocator()->get('Config');
	}
	
	public function hashPass( $pass ){
	    $config = $this->getConfig();
	    $bcrypt = new \Zend\Crypt\Password\Bcrypt();
	    $bcrypt->setSalt($config['crypt']['salt']);
	
	    return $bcrypt->create($pass);
	}
	
}