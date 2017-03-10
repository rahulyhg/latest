<?php

namespace Common;

use Common\Helper\MyHelper;
use Common\Helper\MatrimonialHelper;
use Zend\Authentication\AuthenticationService;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerPluginConfig() {
        return array(
            'invokables' => array(
                'checkUserLogin' => 'Common\Plugin\CheckUserLoginPlugin',
            ),
            'factories' => array(
                //'getUserSession' => 'Common\Plugin\SessionPluginFactory',//not in use
                'Common\Plugin\UserSessionPlugin' => 'Common\Plugin\Factory\UserSessionPluginFactory', //all session related data
                'Common\Plugin\TablePlugin' => 'Common\Plugin\Factory\TablePluginFactory', // all table related data
                'Common\Plugin\AuthFrontPlugin' => 'Common\Plugin\Factory\AuthFrontPluginFactory',
                'Common\Plugin\MyPlugin' => 'Common\Plugin\Factory\MyPluginFactory', // all table related data
            ),
            'aliases' => array(
                'authUser' => 'Common\Plugin\AuthFrontPlugin',
                'getUser' => 'Common\Plugin\UserSessionPlugin',
                'getTable' => 'Common\Plugin\TablePlugin',
                'MyPlugin' => 'Common\Plugin\MyPlugin'
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
//            'invokables' => array(
//                'myhelper' => 'Common\Helper\MyHelper',
//            ),
            'factories' => array(
                'Common\Helper\UserSessionHelper' => 'Common\Helper\Factory\UserSessionHelperFactory',
                'Common\Helper\AuthFrontHelper' => 'Common\Helper\Factory\AuthFrontHelperFactory',
                'Common\Helper\AuthAdminHelper' => 'Common\Helper\Factory\AuthAdminHelperFactory',
                'myHelper' => function($sm) {
                    // either create a new instance of your model
                    //$model = new \Application\Model\CountryTable();
                    // or, if your model is in the servicemanager, fetch it from there
                    $dbAdapter = $sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                    $model = $sm->getServiceLocator()->get('Application\Model\PostTable');
                    // $model = $sm->getServiceLocator()->get('Application\Model\PostTable');
                    // print_r($model);
                    // die;
                    // create a new instance of your helper, injecting the model it uses
                    $helper = new MyHelper($model, $dbAdapter);
                    return $helper;
                },
                'matrimonialHelper' => function($sm) {
                    // either create a new instance of your model
                    //$model = new \Application\Model\CountryTable();
                    // or, if your model is in the servicemanager, fetch it from there
                    $dbAdapter = $sm->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                    $model = $sm->getServiceLocator()->get('Application\Model\PostTable');
                    // $model = $sm->getServiceLocator()->get('Application\Model\PostTable');
                    // print_r($model);
                    // die;
                    // create a new instance of your helper, injecting the model it uses
                    $helper = new MatrimonialHelper($model, $dbAdapter);
                    return $helper;
                },
            ),
            'aliases' => array(
                'authUser' => 'Common\Helper\AuthFrontHelper',
                'authAdmin' => 'Common\Helper\AuthAdminHelper',
                'getUser' => 'Common\Helper\UserSessionHelper'
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(// main session define
                'Common\SessionServices' => 'Common\SessionServices\Factory\SessionServiceFactory',
                'Common\Cache\Redis' => 'Common\Factory\RedisFactory',
                'Common\Mapper\PostMapperInterface' => 'Common\Mapper\Factory\ZendDbSqlMapperFactory',
                'Common\Mapper\CommonMapperInterface' => 'Common\Mapper\Factory\CommonDbSqlMapperFactory',
                'Common\Service\PostServiceInterface' => 'Common\Service\Factory\PostServiceFactory',
                'Common\Service\CommonServiceInterface' => 'Common\Service\Factory\CommonServiceFactory',
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
                'Zend\Authentication\AuthenticationService' => function ($serviceManager) {
                $authenticationServices = new AuthenticationService();
                return $authenticationServices;
            },
            ),
            'aliases' => array(
                'sessionService' => 'Common\SessionServices'
            ),
        );
    }

}
