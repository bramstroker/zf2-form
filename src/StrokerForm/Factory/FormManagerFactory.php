<?php
/**
 * Description
 *
 * @category  Acsi
 * @package   Acsi\
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use StrokerForm\FormManager;

class FormManagerFactory implements \Zend\ServiceManager\FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return FormManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $moduleOptions \StrokerForm\Options\ModuleOptions  */
        $moduleOptions = $serviceLocator->get('StrokerForm\Options\ModuleOptions');

        // init FormManager
        $manager = new FormManager($moduleOptions->getForms());
        // add serviceLocator to FormManager
        $manager->setServiceLocator($serviceLocator);

        return $manager;
    }
}
