<?php

namespace WebServices;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) { 
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        include __DIR__.'/WebServiceConstant.php';
         include __DIR__.'/TableName.php';
         include __DIR__.'/Image.php';
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {    
        return array(
            'factories' => array(
                'WebServices\Service\CommonServicesInterface' => 'WebServices\Service\Factory\CommonServicesFactory',
                'WebServices\Service\LoginServicesInterface' => 'WebServices\Service\Factory\LoginServicesFactory',
                'WebServices\Service\UserServicesInterface' => 'WebServices\Service\Factory\UserServicesFactory',
                'WebServices\Service\ImageServicesInterface' => 'WebServices\Service\Factory\ImageServicesFactory',
             
            ),
        );
           
    }
    

}
