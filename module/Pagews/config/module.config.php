<?php

namespace Pagews;

use Pagews\Controller\SearchwsController;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'controllers' => array(
        'factories' => array(
            SearchwsController::class => InvokableFactory::class,
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'pagews' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/pagews[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        //'id' => '[0-9]+',
                        'id' => '[a-zA-Z0-9_-]*[.]{0,1}[a-zA-Z]*',),
                    'defaults' => array(
                        'controller' => SearchwsController::class,
                    ),
                    //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
