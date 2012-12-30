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
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return array
     */
	public function getRules(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('digits' => true);
	}

    /**
     * Get the validation message
     *
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return string
     */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('digits' => $this->translateMessage('The input must contain only digits'));
	}
}
