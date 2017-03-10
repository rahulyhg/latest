<?php

namespace Application\Service\Factory;

use Application\Service\AccountService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AccountServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new AccountService(
                $serviceLocator->get('Application\Mapper\AccountMapperInterface')
        );
    }

}
