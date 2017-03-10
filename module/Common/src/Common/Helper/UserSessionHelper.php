<?php

namespace Common\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserSessionHelper extends AbstractHelper implements ServiceLocatorAwareInterface {

    protected $session;
    protected $userdata;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function __invoke($name = null) {
        if (0 === func_num_args()) {
            return $this;
        }

        //$this->session=$this->view->SessionHelper();
        $sm = $this->getServiceLocator()->getServiceLocator();
        $getUserSession = $sm->get('ControllerPluginManager')->get('getUser');
        $this->session = $getUserSession()->session();
        $this->userdata = $this->session->$name;
        return $this->userdata;
    }

    public function test() {
        $sm = $this->getServiceLocator()->getServiceLocator();
        $getUserSession = $sm->get('ControllerPluginManager')->get('getUserSession');
        //$pluginA = $this->serviceLocator->get('ControllerPluginManager')->get('getUserSession');
        return $getUserSession();
    }

    public function name($name = null) {
        if (0 === func_num_args()) {
            return $this;
        }

        //$this->session=$this->view->SessionHelper();
        $sm = $this->getServiceLocator()->getServiceLocator();
        $getUserSession = $sm->get('ControllerPluginManager')->get('getUser');
        $this->session = $getUserSession()->session();
        $this->userdata = $this->session->$name;
        return $this->userdata;
    }

}
