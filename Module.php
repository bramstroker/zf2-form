<?php
/**
 * StrokerForm module
 *
 * @category  StrokerForm
 * @package   StrokerForm
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */
namespace StrokerForm;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
	AutoloaderProviderInterface,
	ServiceProviderInterface,
	ConfigProviderInterface,
	ControllerProviderInterface,
	ViewHelperProviderInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				),
			),
		);
	}

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'StrokerForm\Options\ModuleOptions' => 'StrokerForm\Service\ModuleOptionsFactory',
				'StrokerForm\FormPluginManager' => 'StrokerForm\Service\FormPluginManagerFactory',
				'stroker_form.renderer' => 'StrokerForm\Service\RendererFactory',
				'forminput' => 'StrokerForm\Service\FormInputFactory',
			),
			'invokables' => array (
				'stroker_form.renderer.jqueryvalidate' => 'StrokerForm\Renderer\JqueryValidate\Renderer',
			),
		);
	}

	/**
	 * Returns configuration to merge with application configuration
	 *
	 * @return array|\Traversable
	 */
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to seed
	 * such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getControllerConfig()
	{
		return array(
			'factories' => array(
				'StrokerForm\Controller\Ajax' => 'StrokerForm\Service\AjaxControllerFactory'
			),
		);
	}

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getViewHelperConfig()
	{
		return array(
			'factories' => array(
				'form_element' => 'StrokerForm\Service\FormElementFactory',
				'strokerFormPrepare' => 'StrokerForm\Service\FormPrepareFactory'
			)
		);
	}
}