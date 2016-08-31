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
use StrokerForm\Renderer\RendererCollection;
use StrokerForm\Renderer\RendererInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RendererFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     *
     * @return RendererInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options ModuleOptions */
        $options = $serviceLocator->get(ModuleOptions::class);
        $rendererCollection = new RendererCollection();
        foreach ($options->getActiveRenderers() as $rendererAlias) {
            /** @var $renderer RendererInterface */
            $renderer = $serviceLocator->get($rendererAlias);
            $renderer->setDefaultOptions($options->getRendererOptions($rendererAlias));
            $renderer->setFormManager($serviceLocator->get(FormManager::class));
            if ($serviceLocator->has('translator')) {
                $renderer->setTranslator($serviceLocator->get('translator'));
            }
            $renderer->setHttpRouter($serviceLocator->get('HttpRouter'));
            $rendererCollection->addRenderer($renderer);
        }

        return $rendererCollection;
    }
}
