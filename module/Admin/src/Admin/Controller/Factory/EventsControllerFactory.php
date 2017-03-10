<?php

namespace Admin\Controller\Factory;

use Admin\Controller\EventsController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventsControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        //$adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $eventsService = $realServiceLocator->get('Admin\Service\EventsServiceInterface');

        return new EventsController($commonService, $adminService, $eventsService);
    }

}
