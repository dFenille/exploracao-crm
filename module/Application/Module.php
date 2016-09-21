<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\Validator\AbstractValidator;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements ConsoleBannerProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface
{

    protected $sessionConfig = array(
        'remember_me_seconds' => 360,
        'use_cookies' => true,
        'cookie_httponly' => true,
        'name'  => 'exploracao-crm',

    );

    protected $list = array(

    );

    public function onBootstrap(MvcEvent $e)
    {
        $this->initSession();
        $this->initLayout($e);
        $this->initTranslate($e);
        $this->initConstantes();

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $list = $this->list;
        $auth = array();

        $eventManager->attach(MvcEvent::EVENT_ROUTE, function ($e) use($list, $auth) {
            $match = $e->getRouteMatch();

            // No route match, this is a 404
            if (! $match instanceof RouteMatch) {
                return;
            }

            // Route is whitelisted
            $route = $match->getMatchedRouteName();
            $params = $match->getParams();
            $module = explode('/',$route);


//             if(@$module[0] == 'api' ||  $route == 'admin/day-notification' || $route == 'swagger-ui' || $route ==  'swagger-resource-detail' || $route ==  'swagger-resources'){
//                 return;
//             }

        }, - 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function ($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },

            )
        );
    }
    public function initSession()
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($this->sessionConfig);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }

    public function initLayout($e)
    {
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)
        {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }
        , 100);
    }

    public function initTranslate($e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $translator = $serviceManager->get('MvcTranslator');
        $translator->addTranslationFile('phpArray','vendor/zendframework/zendframework/resources/languages/pt_BR/Zend_Validate.php');

        AbstractValidator::setDefaultTranslator($translator);
    }

    public function initConstantes(){

        define('PRIVATE_KEY','dHutz1gx');
        define('PUBLIC_KEY', 'RqxJQFHt');

    }

    public function getConsoleBanner(Console $console)
    {
        return 'Scup 0.0.1';
    }

    public function getConsoleUsage(Console $console)
    {
        return array(
            array( '--verbose' , 'Liga modo verbose' ),
            array( '-v'        , 'Mesmo que --verbose' ),
            array( '--idMonitoring'    , 'id de Monitoracao'),
            array( '--data_ini'    , 'data inicial'),
            array( '--data_fim'    , 'data final'),
        );
    }
}
