<?php

namespace Admin\Controller\Factory;

use Admin\Controller\SubeventsController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubeventsControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        //$adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $subeventsService = $realServiceLocator->get('Admin\Service\SubeventsServiceInterface');

        return new SubeventsController($commonService, $adminService, $subeventsService);
    }

}
