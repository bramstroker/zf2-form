<?php
/**
 * StrokerForm module
 *
 * @category  StrokerForm
 * @package   StrokerForm
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */
namespace StrokerForm;

use StrokerForm\Controller\AjaxController;
use StrokerForm\Factory\AjaxControllerFactory;
use StrokerForm\Factory\FormElementFactory;
use StrokerForm\Factory\FormManagerFactory;
use StrokerForm\Factory\FormPrepareFactory;
use StrokerForm\Factory\ModuleOptionsFactory;
use StrokerForm\Factory\Renderer\JqueryValidate\RendererFactory as jQueryRendererFactory;
use StrokerForm\Factory\RendererFactory;
use StrokerForm\Options\ModuleOptions;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ServiceProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ViewHelperProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                ModuleOptions::class                   => ModuleOptionsFactory::class,
                FormManager::class                     => FormManagerFactory::class,
                'stroker_form.renderer'                => RendererFactory::class,
                'stroker_form.renderer.jqueryvalidate' => jQueryRendererFactory::class,
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                AjaxController::class => AjaxControllerFactory::class
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'form_element'       => FormElementFactory::class,
                'strokerFormPrepare' => FormPrepareFactory::class
            )
        );
    }
}
