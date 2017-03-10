<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */   //die('ddd');
return array(
    'router' => array(
        'routes' => array(
            'CommonServices' => array(
                'type' => 'Segment',
                //'type'=> 'Literal',
                'options' => array(
                    'route' => '/commonservices[/:action[/:id]]',
                  // 'route'=>'userrestful',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                       // '__NAMESPACE__' => 'WebServices\Controller',
                        'controller' => 'WebServices\Controller\CommonServices',
                        'action' => 'index',
                    ),
                ),
            ),
            'LoginServices' => array(
                'type' => 'Segment',
                //'type'=> 'Literal',
                'options' => array(
                    'route' => '/loginservices[/:action[/:id]]',
                  // 'route'=>'userrestful',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                       // '__NAMESPACE__' => 'WebServices\Controller',
                        'controller' => 'WebServices\Controller\LoginServices',
                        'action' => 'index',
                    ),
                ),
            ),
            'userServices' => array(
                'type' => 'Segment',
                //'type'=> 'Literal',
                'options' => array(
                    'route' => '/userservices[/:action[/:id]]',
                  // 'route'=>'userrestful',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                       // '__NAMESPACE__' => 'WebServices\Controller',
                        'controller' => 'WebServices\Controller\UserServices',
                        'action' => 'index',
                    ),
                ),
            ),
            'imageServices' => array(
                'type' => 'Segment',
                //'type'=> 'Literal',
                'options' => array(
                    'route' => '/imageservices[/:action[/:id]]',
                  // 'route'=>'userrestful',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                       // '__NAMESPACE__' => 'WebServices\Controller',
                        'controller' => 'WebServices\Controller\ImageServices',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'controllers' => array(
     
        'factories' => array(
            'WebServices\Controller\CommonServices' => 'WebServices\Controller\Factory\CommonServicesControllerFactory',
            'WebServices\Controller\LoginServices' => 'WebServices\Controller\Factory\LoginServicesControllerFactory',
            'WebServices\Controller\UserServices' => 'WebServices\Controller\Factory\UserServicesControllerFactory',
            'WebServices\Controller\ImageServices' => 'WebServices\Controller\Factory\ImageServicesControllerFactory',
        )
//        'factories' => array(
//            'Common\Controller\Common' => 'Common\Controller\Factory\CommonControllerFactory'
//        )
    ),
    'view_manager' => array(

       
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
       
    ),
);
