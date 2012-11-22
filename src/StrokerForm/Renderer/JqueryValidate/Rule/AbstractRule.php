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

abstract class AbstractRule implements RuleInterface
{
	/**
	 * @var \Zend\I18n\Translator\Translator
	 */
	protected $translator;

	/**
	 * @return \Zend\I18n\Translator\Translator
	 */
	public function getTranslator()
	{
		return $this->translator;
	}

	/**
	 * @param \Zend\I18n\Translator\Translator $translator
	 */
	public function setTranslator(\Zend\I18n\Translator\Translator $translator = null)
	{
		$this->translator = $translator;
	}

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

		return $translator->translate(
			$message, $this->getTranslatorTextDomain()
		);
	}
}
