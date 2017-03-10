<?php

namespace Application\Controller\Factory;

use Application\Controller\JustbornController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class JustbornControllerFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $postService = $realServiceLocator->get('Application\Service\JustbornServiceInterface');

        return new JustbornController($postService);
    }

}
