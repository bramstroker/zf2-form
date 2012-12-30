<?php
/**
 * StringLength
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

class StringLength extends AbstractRule
{
    /**
     * Get the validation rules
     *
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return array
     */
	public function getRules(\Zend\Validator\ValidatorInterface $validator)
	{
		$rules = array();
		if ($validator->getMin() > 0)
		{
			$rules['minlength'] = $validator->getMin();
		}
		if ($validator->getMax() > 0)
		{
			$rules['maxlength'] = $validator->getMax();
		}
		return $rules;
	}

    /**
     * Get the validation message
     *
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return string
     */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator)
	{
		$messages = array();
		if ($validator->getMin() > 0)
		{
			$messages['minlength'] = sprintf($this->translateMessage('At least %s characters are required'), $validator->getMin());
		}
		if ($validator->getMax() > 0)
		{
			$messages['maxlength'] = sprintf($this->translateMessage('At most %s characters are allowed'), $validator->getMax());
		}
		return $messages;
	}
}
