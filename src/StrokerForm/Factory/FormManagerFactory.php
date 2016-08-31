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

use StrokerForm\FormManager;
use StrokerForm\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FormManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     *
     * @return FormManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $moduleOptions ModuleOptions */
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);

        // init FormManager
        $manager = new FormManager($moduleOptions->getForms());
        // add serviceLocator to FormManager
        $manager->setServiceLocator($serviceLocator);

        return $manager;
    }
}
