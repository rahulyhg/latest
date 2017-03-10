<?php

namespace Admin\Controller\Factory;

use Admin\Controller\UsertypemasterController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsertypemasterControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $usertypemasterService = $realServiceLocator->get('Admin\Service\UsertypemasterServiceInterface');

        return new UsertypemasterController($commonService, $adminService, $usertypemasterService);
    }

}
