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

use Zend\ServiceManager\ServiceLocatorInterface;
use StrokerForm\FormManager;

class FormManagerFactory implements \Zend\ServiceManager\FactoryInterface
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
		return new FormManager($moduleOptions->getForms());
	}
}
