<?php
/**
 * Digits
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

class Digits extends AbstractRule
{
	/**
	 * Get the validation rules
	 *
	 * @return array
	 */
	public function getRules(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('digits' => true);
	}

	/**
	 * Get the validation message
	 *
	 * @return string
	 */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('digits' => $this->translateMessage('The input must contain only digits'));
	}
}
