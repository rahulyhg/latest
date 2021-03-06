<?php

namespace Admin\Controller\Factory;

use Admin\Controller\BranchController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BranchControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $branchService = $realServiceLocator->get('Admin\Service\BranchServiceInterface');

        return new BranchController($commonService, $adminService, $branchService);
    }

}
