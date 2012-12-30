<?php
/**
 * RuleInterface
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

interface RuleInterface
{
    /**
     * Get the validation rules
     *
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return array
     */
	public function getRules(\Zend\Validator\ValidatorInterface $validator);

    /**
     * Get the validation message
     *
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return string
     */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator);

	/**
	 * Set the translator
	 *
	 * @param \Zend\I18n\Translator\Translator $translator
	 * @return mixed
	 */
	public function setTranslator(\Zend\I18n\Translator\Translator $translator = null);
}