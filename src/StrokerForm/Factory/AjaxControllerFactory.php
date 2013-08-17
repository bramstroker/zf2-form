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

use Zend\ServiceManager\FactoryInterface;
use StrokerForm\Controller\AjaxController;
use Zend\ServiceManager\ServiceLocatorInterface;

class AjaxControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $locator = $serviceLocator->getServiceLocator();
        $formManager = $locator->get('StrokerForm\FormManager');
        $controller = new AjaxController($formManager);

        return $controller;
    }
}
