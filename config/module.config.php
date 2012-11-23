<?php
return array(
	'stroker_form' => array(
		'activeRenderers' => array(
			'stroker_form.renderer.jqueryvalidate',
		),
		'renderer_options' => array(
			'stroker_form.renderer.jqueryvalidate' => array(
				'options_class' => 'StrokerForm\Renderer\JqueryValidate\Options',
				'include_assets' => true,
				'use_twitter_bootstrap' => true,
				'validateOptions' => array(
					//'onsubmit : false',
					'onkeyup : false',
				)
			)
		),
	),
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