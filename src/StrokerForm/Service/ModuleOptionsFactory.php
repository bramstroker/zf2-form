<?php
/**
 * Description
 *
 * @category  StrokerForm
 * @package   StrokerForm\Options
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Service;

use Zend\ServiceManager\FactoryInterface;
use StrokerForm\Options\ModuleOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('Config');
        $options = isset($options['stroker_form']) ? $options['stroker_form'] : null;

        if (null === $options) {
            throw new RuntimeException(
                sprintf(
                    'Configuration with name "%s" could not be found in "doctrine.configuration".',
                    $this->name
                )
            );
        }

        return new ModuleOptions($options);
    }
}
