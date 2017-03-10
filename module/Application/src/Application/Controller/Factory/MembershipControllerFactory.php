<?php

namespace Application\Controller\Factory;

use Application\Controller\MembershipController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MembershipControllerFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $postService = $realServiceLocator->get('Application\Service\MembershipServiceInterface');

        return new MembershipController($postService);
    }

}
