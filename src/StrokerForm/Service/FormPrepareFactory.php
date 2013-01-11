<?php
/**
 * Factory for the formPrepare view helper
 *
 * @category  StrokerForm
 * @package   StrokerForm\Service
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Service;

use Zend\ServiceManager\FactoryInterface;
use StrokerForm\View\Helper\FormPrepare;
use Zend\ServiceManager\ServiceLocatorInterface;

class FormPrepareFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = $serviceLocator->getServiceLocator()->get('stroker_form.renderer');

        return new FormPrepare($renderer);
    }
}
