<?php

namespace Admin\Controller\Factory;

use Admin\Controller\EventmasterController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EventmasterControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $eventmasterService = $realServiceLocator->get('Admin\Service\EventmasterServiceInterface');

        return new EventmasterController($commonService, $adminService,$eventmasterService);
    }

}
