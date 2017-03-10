<?php

namespace CurrentRoute\Factory\View\Helper;


use CurrentRoute\View\Helper\CurrentRoute;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrentRouteFactory implements FactoryInterface {

    
     public function createService(ServiceLocatorInterface $serviceLocator) {

        $routeMatch=$serviceLocator->getServiceLocator()->get('Application')->getMvcEvent()->getRouteMatch();   
        $controller = $action = $route = $module = '';

        if($routeMatch){
            $controller = $routeMatch->getParam('controller');
            $action     = $routeMatch->getParam('action');
            $module     = $routeMatch->getParam('__NAMESPACE__');
            $route      = $routeMatch->getMatchedRouteName();
        }
        return new CurrentRoute($controller, $action, $route, $module);
    }

//    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
//    {
//        $routeMatch = $container->get('Application')->getMvcEvent()->getRouteMatch();
//        $controller = $action = $route = $module = '';
//
//        if($routeMatch){
//            $controller = $routeMatch->getParam('controller');
//            $action     = $routeMatch->getParam('action');
//            $module     = $routeMatch->getParam('__NAMESPACE__');
//            $route      = $routeMatch->getMatchedRouteName();
//        }
//
//        return new CurrentRoute($controller, $action, $route, $module);
//    }

}
