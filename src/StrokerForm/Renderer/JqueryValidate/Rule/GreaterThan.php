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

use Zend\Form\Element;
use Zend\Validator\ValidatorInterface;

class GreaterThan extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, Element $element = null)
    {
        return array('min' => $validator->getMin());
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return array(
            'min' =>
            sprintf($this->translateMessage('The input is not greater than %s'), $validator->getMin())
        );
    }
}
