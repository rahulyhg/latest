<?php

namespace Admin\Controller\Factory;

use Admin\Controller\AwardController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AwardControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        //$adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $awardService = $realServiceLocator->get('Admin\Service\AwardServiceInterface');

        return new AwardController($commonService, $adminService, $awardService);
    }

}
