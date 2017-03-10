<?php

namespace Common\SessionServices\Factory;

use Common\SessionServices\SessionService;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;

class SessionServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        //$sessionContainer = new Container('user');
        $routeMatch = $serviceLocator->get('Application')->getMvcEvent()->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        if (0 === strpos($routeMatch->getMatchedRouteName(), 'admin/login')) {
            $sessionContainer = new Container('admin');
        } else {
            $sessionContainer = new Container('user');
        }

        $sessionService = new SessionService();
        $sessionService->setSessionContainer($sessionContainer);
        return $sessionService;
    }

}
