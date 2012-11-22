<?php
/**
 * GreaterThan
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

class GreaterThan extends AbstractRule
{
	/**
	 * Get the validation rules
	 *
	 * @return array
	 */
	public function getRules(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('min' => $validator->getMin());
	}

	/**
	 * Get the validation message
	 *
	 * @return string
	 */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator)
	{
		return array(
			'min' =>
			sprintf($this->translateMessage('The input is not greater than %s'), $validator->getMin())
		);
	}
}
