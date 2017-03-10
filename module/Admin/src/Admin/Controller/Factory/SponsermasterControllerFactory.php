<?php

namespace Admin\Controller\Factory;

use Admin\Controller\SponsermasterController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SponsermasterControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $sponsermasterService = $realServiceLocator->get('Admin\Service\SponsermasterServiceInterface');

        return new SponsermasterController($commonService, $adminService, $sponsermasterService);
    }

}
