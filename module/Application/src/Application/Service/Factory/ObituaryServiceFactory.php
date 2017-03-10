<?php

namespace Application\Service\Factory;

use Common\Service\CommonService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ObituaryServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new CommonService(
                $serviceLocator->get('Common\Mapper\CommonMapperInterface')
        );
    }

}
