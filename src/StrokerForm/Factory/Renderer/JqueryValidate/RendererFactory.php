<?php
/**
 * RendererFactory
 *
 * @category  StrokerForm\Factory\Renderer\JqueryValidate
 * @package   StrokerForm\Factory\Renderer\JqueryValidate
 * @copyright 2013 ACSI Holding bv (http://www.acsi.eu)
 * @version   SVN: $Id$
 */

namespace StrokerForm\Factory\Renderer\JqueryValidate;

use StrokerForm\Renderer\JqueryValidate\Renderer;
use StrokerForm\Renderer\JqueryValidate\Rule\RulePluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RendererFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = new Renderer();
        $pluginManager = new RulePluginManager();
        $pluginManager->setServiceLocator($serviceLocator);
        $renderer->setRulePluginManager($pluginManager);
        return $renderer;
    }
}
