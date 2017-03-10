<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'dynamicpages' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '[/:param]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'viewProfile',
                    ),
                ),
            ),
            
            'matrimonial' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/matrimonial[/[:action[/][:id]]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Matrimonial',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'membership' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/membership[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Membership',
                        'action' => 'index',
                    ),
                ),
            ),
            'community' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/community[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Community',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'justborn' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/justborn[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Justborn',
                        'action' => 'index',
                    ),
                ),
            ),
            'obituary' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/obituary[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Obituary',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'posts' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/posts[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Posts',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'events' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/events[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Events',
                        'action' => 'index',
                    ),
                ),
            ),
            'news' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/news[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'News',
                        'action' => 'index',
                    ),
                ),
            ),
            'account' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/account[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Account',
                        'action' => 'index',
                    ),
                ),
            ),
            'profile' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/my-rustagi[/:action[/:slug][/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Profile',
                        'action' => 'index',
                    ),
                ),
            ),
            'user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user[/:action[/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'User',
                        'action' => 'index',
                    ),
                ),
            ),
            'about' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/about',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'about',
                    ),
                ),
            ),
             'history' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/history',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'history',
                    ),
                ),
            ),
             'communities' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/communities',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'communities',
                    ),
                ),
            ),
             'vision' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/vision',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'vision',
                    ),
                ),
            ),
             'contact' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/contact',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'contact',
                    ),
                ),
            ),
             'photo-gallery' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/photo-gallery',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'photoGallery',
                    ),
                ),
            ),
			'terms-of-use' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/terms-of-use',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'termsOfUse',
                    ),
                ),
            ),
			'career' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/career',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'career',
                    ),
                ),
            ),
            'fee' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/fee',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'fee',
                    ),
                ),
            ),
            'membershipfee' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/membershipfee',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'membershipfee',
                    ),
                ),
            ),
            'matrimonialfee' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/matrimonialfee',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'matrimonialfee',
                    ),
                ),
            ),
            'advertisewithus' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/advertisewithus',                 
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'advertisewithus',
                    ),
                ),
            ),
            'UserRestful' => array(
                'type' => 'Segment',
                //'type'=> 'Literal',
                'options' => array(
                    'route' => '/userrestful[/:action[/:id]]',
                  // 'route'=>'userrestful',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                    ),
                    'defaults' => array(
                        //'__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Application\Controller\UserRestful',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            // The following is to remove the application from the URL ////////////
//            'noModule' => array(
//                'type' => 'Segment',
//                'options' => array(
//                    'route' => '/[:controller[/:action[/:id]]]',
//                    'constraints' => array(
//                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id' => '[0-9]*',
//                    ),
//                    'defaults' => array(
//                        '__NAMESPACE__' => 'Application\Controller',
//                        'controller' => 'Index',
//                        'action' => 'index',
//                    ),
//                ),
//            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            //'Application\Controller\Index' => 'Application\Controller\IndexController',
            //'Application\Controller\Pages' => 'Application\Controller\PagesController',
            //'Application\Controller\User' => 'Application\Controller\UserController',
            //'Application\Controller\App' => 'Application\Controller\AppController',
            //'Application\Controller\Account' => 'Application\Controller\AccountController',
            //'Application\Controller\Membership' => 'Application\Controller\MembershipController',
            //'Application\Controller\Matrimonial' => 'Application\Controller\MatrimonialController',
            //'Application\Controller\Community' => 'Application\Controller\CommunityController',
            //'Application\Controller\News' => 'Application\Controller\NewsController',
            //'Application\Controller\Events' => 'Application\Controller\EventsController',
            //'Application\Controller\Posts' => 'Application\Controller\PostsController',
            //'Application\Controller\Obituary' => 'Application\Controller\ObituaryController',
            //'Application\Controller\Justborn' => 'Application\Controller\JustbornController'
        ),
        'factories' => array(
            'Application\Controller\Index' => 'Application\Controller\Factory\IndexControllerFactory',
            'Application\Controller\Account' => 'Application\Controller\Factory\AccountControllerFactory',
            'Application\Controller\Pages' => 'Application\Controller\Factory\PagesControllerFactory',
            'Application\Controller\Membership' => 'Application\Controller\Factory\MembershipControllerFactory',
            'Application\Controller\Community' => 'Application\Controller\Factory\CommunityControllerFactory',
            'Application\Controller\Matrimonial' => 'Application\Controller\Factory\MatrimonialControllerFactory',
            'Application\Controller\News' => 'Application\Controller\Factory\NewsControllerFactory',
            'Application\Controller\Justborn' => 'Application\Controller\Factory\JustbornControllerFactory',
            'Application\Controller\Events' => 'Application\Controller\Factory\EventsControllerFactory',
            'Application\Controller\Posts' => 'Application\Controller\Factory\PostsControllerFactory',
            'Application\Controller\Obituary' => 'Application\Controller\Factory\ObituaryControllerFactory',
            'Application\Controller\User' => 'Application\Controller\Factory\UserControllerFactory',
            'Application\Controller\Profile' => 'Application\Controller\Factory\ProfileControllerFactory',
            'Application\Controller\UserRestful' => 'Application\Controller\Factory\UserRestfulControllerFactory',
            
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'application/membership/filters' => __DIR__ . '/../view/application/membership/filters.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        //'flash-message' => __DIR__ . '/../view/layout/partial/flash-message.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    // 'view_helpers' => array(
    //     'invokables'=> array(
    //         'dfgfg' => 'Application\View\Helper\MyHelper'  
    //     )
    // ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
