<?php
/**
 * Description
 *
 * @category  Acsi
 * @package   Acsi\
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Service;

use StrokerForm\FormPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class FormPluginManagerFactory implements \Zend\ServiceManager\FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		/** @var $moduleOptions \StrokerForm\Options\ModuleOptions  */
		$moduleOptions = $serviceLocator->get('StrokerForm\Options\ModuleOptions');
		return new FormPluginManager($moduleOptions->getForms());
	}
}
