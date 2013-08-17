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
use StrokerForm\Renderer\RendererCollection;
use Zend\ServiceManager\ServiceLocatorInterface;

class RendererFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param  ServiceLocatorInterface                 $serviceLocator
     * @return \StrokerForm\Renderer\RendererInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \StrokerForm\Options\ModuleOptions */
        $options = $serviceLocator->get('StrokerForm\Options\ModuleOptions');
        $rendererCollection = new RendererCollection();
        foreach ($options->getActiveRenderers() as $rendererAlias) {
            /** @var $renderer \StrokerForm\Renderer\RendererInterface */
            $renderer = $serviceLocator->get($rendererAlias);
            $renderer->setDefaultOptions($options->getRendererOptions($rendererAlias));
            $renderer->setFormManager($serviceLocator->get('StrokerForm\FormManager'));
            if ($serviceLocator->has('translator')) {
                $renderer->setTranslator($serviceLocator->get('translator'));
            }
            $renderer->setHttpRouter($serviceLocator->get('HttpRouter'));
            $rendererCollection->addRenderer($renderer);
        }

        return $rendererCollection;
    }
}
