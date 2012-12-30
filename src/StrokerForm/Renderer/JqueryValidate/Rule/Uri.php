<?php
/**
 * Uri
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

class Uri extends AbstractRule
{
    /**
     * Get the validation rules
     *
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return array
     */
	public function getRules(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('url' => true);
	}

    /**
     * Get the validation message
     *
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return string
     */
	public function getMessages(\Zend\Validator\ValidatorInterface $validator)
	{
		return array('url' => $this->translateMessage('This is not a valid URI'));
	}
}
