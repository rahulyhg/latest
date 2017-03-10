<?php

namespace Application;

use Application\Helper\MyHelper;
use Application\Model\AnnualIncomeTable;
use Application\Model\CityTable;
use Application\Model\ContactTable;
use Application\Model\CountryTable;
use Application\Model\DesignationTable;
use Application\Model\EducationFieldTable;
use Application\Model\EducationLevelTable;
use Application\Model\EmailLogsTable;
use Application\Model\FamilyInfoTable;
use Application\Model\GothraTable;
use Application\Model\HeightTable;
use Application\Model\PostcategoryTable;
use Application\Model\PostTable;
use Application\Model\ProfessionTable;
use Application\Model\ReligionTable;
use Application\Model\RustagiBranchTable;
use Application\Model\StateTable;
use Application\Model\UserInfoTable;
use Application\Model\UserTable;
use Application\Model\UserTypeTable;
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
        include __DIR__.'/ApplicationConstant.php';
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
                'Application\Mapper\IndexMapperInterface' => 'Application\Mapper\Factory\IndexDbSqlMapperFactory',
                'Application\Service\IndexServiceInterface' => 'Application\Service\Factory\IndexServiceFactory',
                'Application\Mapper\MatrimonialMapperInterface' => 'Application\Mapper\Factory\MatrimonialDbSqlMapperFactory',
                'Application\Service\MatrimonialServiceInterface' => 'Application\Service\Factory\MatrimonialServiceFactory',
                'Application\Mapper\AccountMapperInterface' => 'Application\Mapper\Factory\AccountDbSqlMapperFactory',
                'Application\Service\AccountServiceInterface' => 'Application\Service\Factory\AccountServiceFactory',
                'Application\Mapper\ProfileMapperInterface' => 'Application\Mapper\Factory\ProfileDbSqlMapperFactory',
                'Application\Service\ProfileServiceInterface' => 'Application\Service\Factory\ProfileServiceFactory',
                'Application\Mapper\MembershipMapperInterface' => 'Application\Mapper\Factory\MembershipDbSqlMapperFactory',
                'Application\Service\MembershipServiceInterface' => 'Application\Service\Factory\MembershipServiceFactory',
                'Application\Mapper\CommunityMapperInterface' => 'Application\Mapper\Factory\CommunityDbSqlMapperFactory',
                'Application\Service\CommunityServiceInterface' => 'Application\Service\Factory\CommunityServiceFactory',
                'Application\Mapper\EventsMapperInterface' => 'Application\Mapper\Factory\EventsDbSqlMapperFactory',
                'Application\Service\EventsServiceInterface' => 'Application\Service\Factory\EventsServiceFactory',
                'Application\Mapper\UserMapperInterface' => 'Application\Mapper\Factory\UserDbSqlMapperFactory',
                'Application\Service\UserServiceInterface' => 'Application\Service\Factory\UserServiceFactory',
                'Application\Mapper\ObituaryMapperInterface' => 'Application\Mapper\Factory\ObituaryDbSqlMapperFactory',
                'Application\Service\ObituaryServiceInterface' => 'Application\Service\Factory\ObituaryServiceFactory',
                'Application\Mapper\PagesMapperInterface' => 'Application\Mapper\Factory\PagesDbSqlMapperFactory',
                'Application\Service\PagesServiceInterface' => 'Application\Service\Factory\PagesServiceFactory',
                'Application\Mapper\PostsMapperInterface' => 'Application\Mapper\Factory\PostsDbSqlMapperFactory',
                'Application\Service\PostsServiceInterface' => 'Application\Service\Factory\PostsServiceFactory',
                'Application\Mapper\NewsMapperInterface' => 'Application\Mapper\Factory\NewsDbSqlMapperFactory',
                'Application\Service\NewsServiceInterface' => 'Application\Service\Factory\NewsServiceFactory',
                'Application\Mapper\JustbornMapperInterface' => 'Application\Mapper\Factory\JustbornDbSqlMapperFactory',
                'Application\Service\JustbornServiceInterface' => 'Application\Service\Factory\JustbornServiceFactory',
                'Application\Mapper\UserRestfulMapperInterface' => 'Application\Mapper\Factory\UserRestfulDbSqlMapperFactory',
                'Application\Service\UserRestfulServiceInterface' => 'Application\Service\Factory\UserRestfulServiceFactory',
                
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
                'SpeckAuthnet\Client' => function($sm) {
                    return new \SpeckAuthnet\Client;
                },
                'Application\Model\UserTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTable($dbAdapter);
                    return $table;
                },
                'Application\Model\UserTypeTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserTypeTable($dbAdapter);
                    return $table;
                },
                'Application\Model\GothraTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new GothraTable($dbAdapter);
                    return $table;
                },
                'Application\Model\ProfessionTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ProfessionTable($dbAdapter);
                    return $table;
                },
                'Application\Model\ContactTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ContactTable($dbAdapter);
                    return $table;
                },
                'Application\Model\EmailLogsTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EmailLogsTable($dbAdapter);
                    return $table;
                },
                'Application\Model\UserInfoTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UserInfoTable($dbAdapter);
                    return $table;
                },
                'Application\Model\EducationLevelTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EducationLevelTable($dbAdapter);
                    return $table;
                },
                'Application\Model\CountryTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CountryTable($dbAdapter);
                    return $table;
                },
                'Application\Model\StateTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new StateTable($dbAdapter);
                    return $table;
                },
                'Application\Model\CityTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new CityTable($dbAdapter);
                    return $table;
                },
                'Application\Model\AnnualIncomeTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new AnnualIncomeTable($dbAdapter);
                    return $table;
                },
                'Application\Model\HeightTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new HeightTable($dbAdapter);
                    return $table;
                },
                'Application\Model\EducationFieldTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new EducationFieldTable($dbAdapter);
                    return $table;
                },
                'Application\Model\ReligionTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ReligionTable($dbAdapter);
                    return $table;
                },
                'Application\Model\FamilyInfoTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new FamilyInfoTable($dbAdapter);
                    return $table;
                },
                'Application\Model\DesignationTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new DesignationTable($dbAdapter);
                    return $table;
                },
                'Application\Model\RustagiBranchTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RustagiBranchTable($dbAdapter);
                    return $table;
                }, 'Application\Model\PostcategoryTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PostcategoryTable($dbAdapter);
                    return $table;
                }, 'Application\Model\PostTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PostTable($dbAdapter);
                    return $table;
                }
            ),
        );
           
    }
    

}
