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

use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\Router\RouteInterface;
use Zend\Stdlib\AbstractOptions;
use StrokerForm\FormManager;

abstract class AbstractRenderer implements RendererInterface, TranslatorAwareInterface
{
    /**
     * @var \Zend\Mvc\Router\RouteInterface
     */
    protected $httpRouter;

    /**
     * Translator (optional)
     *
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Translator text domain (optional)
     *
     * @var string
     */
    protected $translatorTextDomain = 'default';

    /**
     * Whether translator should be used
     *
     * @var bool
     */
    protected $translatorEnabled = true;

    /**
     * @var AbstractOptions
     */
    protected $defaultOptions = array();

    /**
     * @var AbstractOptions
     */
    protected $options = array();

    /**
     * @var FormManager
     */
    protected $formManager;

    /**
     * Sets translator to use in helper
     *
     * @param TranslatorInterface $translator [optional] translator.
     *                                 Default is null, which sets no translator.
     * @param string $textDomain [optional] text domain
     *                                 Default is null, which skips setTranslatorTextDomain
     * @return AbstractTranslatorHelper
     */
    public function setTranslator(TranslatorInterface $translator = null, $textDomain = null)
    {
        $this->translator = $translator;
        if (null !== $textDomain) {
            $this->setTranslatorTextDomain($textDomain);
        }

        return $this;
    }

    /**
     * Returns translator used in helper
     *
     * @return Translator|null
     */
    public function getTranslator()
    {
        if (!$this->isTranslatorEnabled()) {
            return null;
        }

        return $this->translator;
    }

    /**
     * Checks if the helper has a translator
     *
     * @return bool
     */
    public function hasTranslator()
    {
        return (bool) $this->getTranslator();
    }

    /**
     * Sets whether translator is enabled and should be used
     *
     * @param bool $enabled [optional] whether translator should be used.
     *                       Default is true.
     * @return AbstractTranslatorHelper
     */
    public function setTranslatorEnabled($enabled = true)
    {
        $this->translatorEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * Returns whether translator is enabled and should be used
     *
     * @return bool
     */
    public function isTranslatorEnabled()
    {
        return $this->translatorEnabled;
    }

    /**
     * Set translation text domain
     *
     * @param  string                   $textDomain
     * @return AbstractTranslatorHelper
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->translatorTextDomain = $textDomain;

        return $this;
    }

    /**
     * Return the translation text domain
     *
     * @return string
     */
    public function getTranslatorTextDomain()
    {
        return $this->translatorTextDomain;
    }

    /**
     * @return RouteInterface
     */
    public function getHttpRouter()
    {
        return $this->httpRouter;
    }

    /**
     * @param RouteInterface $assetRoute
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
        $this->options = clone $this->defaultOptions;
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
