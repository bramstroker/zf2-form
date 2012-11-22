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

use Zend\ServiceManager\FactoryInterface;
use StrokerForm\Controller\AjaxController;
use Zend\ServiceManager\ServiceLocatorInterface;

class AjaxControllerFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$locator = $serviceLocator->getServiceLocator();
		$formManager = $locator->get('StrokerForm\FormPluginManager');
		$controller = new AjaxController($formManager);
		return $controller;
	}
}
