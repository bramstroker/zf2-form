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

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

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
                'StrokerForm\Options\ModuleOptions' => 'StrokerForm\Factory\ModuleOptionsFactory',
                'StrokerForm\FormManager' => 'StrokerForm\Factory\FormManagerFactory',
                'stroker_form.renderer' => 'StrokerForm\Factory\RendererFactory',
                'forminput' => 'StrokerForm\Factory\FormInputFactory',
                'stroker_form.renderer.jqueryvalidate' => 'StrokerForm\Factory\Renderer\JqueryValidate\RendererFactory',
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
                'StrokerForm\Controller\Ajax' => 'StrokerForm\Factory\AjaxControllerFactory'
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
                'form_element' => 'StrokerForm\Factory\FormElementFactory',
                'strokerFormPrepare' => 'StrokerForm\Factory\FormPrepareFactory'
            )
        );
    }
}
