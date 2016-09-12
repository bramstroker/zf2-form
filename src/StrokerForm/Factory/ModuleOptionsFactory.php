<?php
/**
 * Description
 *
 * @category  StrokerForm
 * @package   StrokerForm\Options
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Factory;

use RuntimeException;
use StrokerForm\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('Config');
        $options = isset($options['stroker_form']) ? $options['stroker_form'] : null;

        if (null === $options) {
            throw new RuntimeException('Configuration with key stroker_form not found');
        }

        return new ModuleOptions($options);
    }
}
