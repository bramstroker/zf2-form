<?php
/**
 * LessThan
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

class LessThan extends AbstractRule
{
	/**
	 * Get the validation rules
	 *
	 * @return array
	 */
	public function getRules(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('max' => $validator->getMax());
	}

	/**
	 * Get the validation message
	 *
	 * @return string
	 */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator)
	{
		return array(
			'max' =>
			sprintf($this->translateMessage('The input is not less than %s'), $validator->getMax())
		);
	}
}
