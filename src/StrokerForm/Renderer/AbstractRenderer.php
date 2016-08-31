<?php
/**
 * Abstract form renderer
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer;

use StrokerForm\FormManager;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\Mvc\Router\RouteInterface;
use Zend\Stdlib\AbstractOptions;

abstract class AbstractRenderer implements RendererInterface, TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    /**
     * @var \Zend\Mvc\Router\RouteInterface
     */
    protected $httpRouter;

    /**
     * @var AbstractOptions
     */
    protected $defaultOptions = array();

    /**
     * @var Options
     */
    protected $options = null;

    /**
     * @var FormManager
     */
    protected $formManager;

    /**
     * @return RouteInterface
     */
    public function getHttpRouter()
    {
        return $this->httpRouter;
    }

    /**
     * @param RouteInterface $httpRouter
     *
     * @return void
     */
    public function setHttpRouter(RouteInterface $httpRouter)
    {
        $this->httpRouter = $httpRouter;
    }

    /**
     * @return AbstractOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options = array())
    {
        if ($this->options === null) {
            $this->options = clone $this->defaultOptions;
        }

        foreach ($options as $key => $value) {
            if (isset($this->options->{$key}) && is_array($this->options->{$key})) {
                $options[$key] = $this->options->mergeRecursive($this->options->{$key}, $value);
            }
        }

        $this->options->setFromArray($options);
    }

    /**
     * @param AbstractOptions $options
     */
    public function setDefaultOptions(AbstractOptions $options = null)
    {
        $this->defaultOptions = $options;
    }

    /**
     * @return FormManager
     */
    public function getFormManager()
    {
        return $this->formManager;
    }

    /**
     * @param FormManager $formManager
     */
    public function setFormManager(FormManager $formManager)
    {
        $this->formManager = $formManager;
    }
}
