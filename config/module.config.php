<?php
use StrokerForm\Controller\AjaxController;

return [
    'router' => [
        'routes' => [
            'strokerform-ajax-validate' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/form/validate-ajax/:form',
                    'defaults' => [
                        'controller' => AjaxController::class,
                        'action' => 'validate',
                    ],
                ]
            ],
            'strokerform-asset' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/assets',
                ]
            ],
        ]
    ],
    'stroker_form' => [
        'jquery_validate_rule_plugins' => []
    ]
];
