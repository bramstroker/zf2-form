<?php
/**
 * AbstractRule
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Validator\AbstractValidator;

abstract class AbstractRule implements RuleInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator = null;

    /**
     * @var bool
     */
    protected $translatorEnabled = true;

    /**
     * @var string
     */
    protected $translatorTextDomain;

    /**
     * Translate a validation message
     *
     * @param  string $message
     * @return string
     */
    protected function translateMessage($message)
    {
        $translator = $this->getTranslator();
        if (!$translator) {
            return $message;
        }

        return $translator->translate($message, $this->getTranslatorTextDomain());
    }

    /**
     * Sets translator to use in helper
     *
     * @param  TranslatorInterface $translator
     * @param  string     $textDomain
     * @return AbstractRule
     */
    public function setTranslator(TranslatorInterface $translator = null, $textDomain = null)
    {
        $this->translator = $translator;

        if (!is_null($textDomain)) {
            $this->setTranslatorTextDomain($textDomain);
        }

        return $this;
    }

    /**
     * Returns translator used in object
     *
     * @return Translator
     */
    public function getTranslator()
    {
        if($this->translator === null)
        {
            $this->translator = AbstractValidator::getDefaultTranslator();
        }
        return $this->translator;
    }

    /**
     * Checks if the object has a translator
     *
     * @return bool
     */
    public function hasTranslator()
    {
        return !is_null($this->translator);
    }

    /**
     * Sets whether translator is enabled and should be used
     *
     * @param  bool  $enabled
     * @return AbstractRule
     */
    public function setTranslatorEnabled($enabled = true)
    {
        $this->translatorEnabled = $enabled;

        return $this;
    }

    /**
     * Returns whether translator is enabled and should be used
     *
     * @return bool
     */
    public function isTranslatorEnabled()
    {
        $this->translator = AbstractValidator::getDefaultTranslator();
        return $this->translatorEnabled;
    }

    /**
     * Set translation text domain
     *
     * @param  string $textDomain
     * @return AbstractRule
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
        if($this->translatorTextDomain === null)
        {
            $this->translatorTextDomain = AbstractValidator::getDefaultTranslatorTextDomain();
        }
        return $this->translatorTextDomain;
    }
}
