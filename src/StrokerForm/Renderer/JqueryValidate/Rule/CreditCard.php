<?php
/**
 * CreditCard
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

use Zend\Form\Element;
use Zend\Validator\ValidatorInterface;

class CreditCard extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, Element $element = null)
    {
        return array('creditcard' => true);
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return array('creditcard' => $this->translateMessage('The creditcard number is invalid'));
    }
}
