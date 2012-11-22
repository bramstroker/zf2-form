<?php
/**
 * NotEmpty
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

class NotEmpty extends AbstractRule
{
	/**
	 * Get the validation rules
	 *
	 * @return array
	 */
	public function getRules(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('required' => true);
	}

	/**
	 * Get the validation message
	 *
	 * @return string
	 */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('required' => $this->translateMessage('The input is required and cannot be empty'));
	}
}
