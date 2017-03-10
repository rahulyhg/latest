<?php

use Zend\Authentication\AuthenticationService;

return array(
    'controllers' => array(
        'invokables' => array(
          /*  'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
            'Admin\Controller\Country' => 'Admin\Controller\CountryController',
            'Admin\Controller\State' => 'Admin\Controller\StateController',
            'Admin\Controller\City' => 'Admin\Controller\CityController',
            'Admin\Controller\Religion' => 'Admin\Controller\ReligionController',
            'Admin\Controller\Gothra' => 'Admin\Controller\GothraController',
            'Admin\Controller\Starsign' => 'Admin\Controller\StarsignController',
            'Admin\Controller\Zodiacsign' => 'Admin\Controller\ZodiacsignController',
            'Admin\Controller\Master' => 'Admin\Controller\MasterController',
            'Admin\Controller\News' => 'Admin\Controller\NewsController',
            'Admin\Controller\Events' => 'Admin\Controller\EventsController',
            'Admin\Controller\Matrimonyuser' => 'Admin\Controller\MatrimonyuserController',
            'Admin\Controller\Pages' => 'Admin\Controller\PagesController',
            'Admin\Controller\Homepage' => 'Admin\Controller\HomepageController',
            'Admin\Controller\Education' => 'Admin\Controller\EducationController',
            'Admin\Controller\Profession' => 'Admin\Controller\ProfessionController',
            'Admin\Controller\Designation' => 'Admin\Controller\DesignationController',*/
			'Admin\Controller\Ad' => 'Admin\Controller\AdController',            
        ),
        'factories' => array(
            'Admin\Controller\Index' => 'Admin\Controller\Factory\IndexControllerFactory',
            'Admin\Controller\Admin' => 'Admin\Controller\Factory\AdminControllerFactory',
            'Admin\Controller\Country' => 'Admin\Controller\Factory\CountryControllerFactory',
            'Admin\Controller\State' => 'Admin\Controller\Factory\StateControllerFactory',
            'Admin\Controller\City' => 'Admin\Controller\Factory\CityControllerFactory',
            'Admin\Controller\Religion' => 'Admin\Controller\Factory\ReligionControllerFactory',
            'Admin\Controller\Region' => 'Admin\Controller\Factory\RegionControllerFactory',            
            'Admin\Controller\Usertypemaster' => 'Admin\Controller\Factory\UsertypemasterControllerFactory',
            'Admin\Controller\Gothra' => 'Admin\Controller\Factory\GothraControllerFactory',
            'Admin\Controller\Community' => 'Admin\Controller\Factory\CommunityControllerFactory',
            'Admin\Controller\Subcommunity' => 'Admin\Controller\Factory\SubcommunityControllerFactory',
            'Admin\Controller\Starsign' => 'Admin\Controller\Factory\StarsignControllerFactory',
            'Admin\Controller\Zodiacsign' => 'Admin\Controller\Factory\ZodiacsignControllerFactory',
            'Admin\Controller\Master' => 'Admin\Controller\Factory\MasterControllerFactory',
            'Admin\Controller\News' => 'Admin\Controller\Factory\NewsControllerFactory',
            'Admin\Controller\Events' => 'Admin\Controller\Factory\EventsControllerFactory',
            'Admin\Controller\Subevents' => 'Admin\Controller\Factory\SubeventsControllerFactory',
            'Admin\Controller\Eventmaster' => 'Admin\Controller\Factory\EventmasterControllerFactory',
            'Admin\Controller\Sponsertype' => 'Admin\Controller\Factory\SponsertypeControllerFactory',
            'Admin\Controller\Sponsermaster' => 'Admin\Controller\Factory\SponsermasterControllerFactory',
            'Admin\Controller\Membershipfeature' => 'Admin\Controller\Factory\MembershipfeatureControllerFactory',
            'Admin\Controller\Award' => 'Admin\Controller\Factory\AwardControllerFactory',
            'Admin\Controller\Matrimonyuser' => 'Admin\Controller\Factory\MatrimonyuserControllerFactory',
            'Admin\Controller\Pages' => 'Admin\Controller\Factory\PagesControllerFactory',
            'Admin\Controller\Homepage' => 'Admin\Controller\Factory\HomepageControllerFactory',
            'Admin\Controller\Education' => 'Admin\Controller\Factory\EducationControllerFactory',
            'Admin\Controller\Educationlevel' => 'Admin\Controller\Factory\EducationlevelControllerFactory',
            'Admin\Controller\Profession' => 'Admin\Controller\Factory\ProfessionControllerFactory',
            'Admin\Controller\Designation' => 'Admin\Controller\Factory\DesignationControllerFactory',
            'Admin\Controller\Branch' => 'Admin\Controller\Factory\BranchControllerFactory',
            'Admin\Controller\Institute' => 'Admin\Controller\Factory\InstituteControllerFactory',
			'Admin\Controller\Ad' => 'Admin\Controller\Factory\AdControllerFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admincontrol',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Index',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Index',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                    // 'dashboard' => array(
                    //     'type' => 'Literal',
                    //     'options' => array(
                    //         'route' => '/dashboard',
                    //         'defaults' => array(
                    //             'controller' => 'Admin\Controller\Admin',
                    //             'action' => 'dashboard',
                    //         ),
                    //     ),
                    // ),
                     'dashboard' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/dashboard[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Admin',
                                'action' => 'dashboard',
                                'id' => 0
                            ),
                        ),
                    ),
                    'user' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/user[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Admin',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'country' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/country[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Country',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'state' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/state[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\State',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'city' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/city[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\City',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'religion' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/religion[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Religion',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    // 'admin' => array(
                    //     'type' => 'segment',
                    //     'options' => array(
                    //         'route' => '/admin[/:action][/:id]',
                    //         'constraints' => array(
                    //             'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    //             'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    //             'id' => '[0-9]*'
                    //         ),
                    //         'defaults' => array(
                    //             'controller' => 'Admin\Controller\Admin',
                    //             'action' => 'index',
                    //             'id' => 0
                    //         ),
                    //     ),
                    // ),
                    'region' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/region[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Region',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'usertypemaster' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/usertypemaster[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Usertypemaster',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'gothra' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/gothra[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Gothra',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'community' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/community[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Community',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'subcommunity' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/subcommunity[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Subcommunity',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'starsign' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/starsign[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Starsign',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'zodiacsign' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/zodiacsign[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Zodiacsign',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'master' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/master[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Master',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'news' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/news[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\News',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'events' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/events[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Events',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                    'subevents' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/subevents[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Subevents',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                    'award' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/award[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Award',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                    'eventmaster' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/eventmaster[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Eventmaster',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                    'sponsertype' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/sponsertype[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Sponsertype',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                     'sponsermaster' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/sponsermaster[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Sponsermaster',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),


                    
                    'pages' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/pages[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Pages',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                    'membershipfeature' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/membershipfeature[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Membershipfeature',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    
                    'matrimonyuser' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/matrimonyuser[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Matrimonyuser',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                    'education' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/education[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Education',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                    'educationlevel' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/educationlevel[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Educationlevel',
                                'action' => 'manageEducationLevel',
                                'id' => 0
                            ),
                        ),
                    ),


                    'profession' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/profession[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Profession',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
					 'ad' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/ad[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Ad',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                     'branch' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/branch[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Branch',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                     'institute' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/institute[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Institute',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),

                    'designation' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/designation[/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'Admin\Controller\Designation',
                                'action' => 'index',
                                'id' => 0
                            ),
                        ),
                    ),
                ),
            ),
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view'
        ),
    ),
    'admin_layout' => array(
        'use_admin_layout' => true,
        'admin_layout_template' => 'layout/adminLayout',
        'admin_login_layout_template' => 'layout/loginLayout',
    ),
   
);
