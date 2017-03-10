<?php

namespace Admin\Controller\Factory;

use Admin\Controller\MembershipfeatureController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MembershipfeatureControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $membershipfeatureService = $realServiceLocator->get('Admin\Service\MembershipfeatureServiceInterface');

        return new MembershipfeatureController($commonService, $adminService, $membershipfeatureService);
    }

}
