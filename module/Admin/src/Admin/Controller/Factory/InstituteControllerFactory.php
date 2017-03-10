<?php

namespace Admin\Controller\Factory;

use Admin\Controller\InstituteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InstituteControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $instituteService = $realServiceLocator->get('Admin\Service\InstituteServiceInterface');

        return new InstituteController($commonService, $adminService, $instituteService);
    }

}
