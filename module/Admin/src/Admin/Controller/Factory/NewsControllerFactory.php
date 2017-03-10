<?php

namespace Admin\Controller\Factory;

use Admin\Controller\NewsController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NewsControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $commonService = $realServiceLocator->get('Common\Service\CommonServiceInterface');
        $adminService = $realServiceLocator->get('Admin\Service\AdminServiceInterface');
        $newsService = $realServiceLocator->get('Admin\Service\NewsServiceInterface');

        return new NewsController($commonService, $adminService, $newsService);
    }

}
