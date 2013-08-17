<?php
return array(
    'router' => array(
        'routes' => array(
            'strokerform-ajax-validate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/form/validate-ajax/:form',
                    'defaults' => array(
                        'controller' => 'StrokerForm\Controller\Ajax',
                        'action' => 'validate',
                    ),
                )
            ),
            'strokerform-asset' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/assets',
                )
            ),
        )
    ),
);
