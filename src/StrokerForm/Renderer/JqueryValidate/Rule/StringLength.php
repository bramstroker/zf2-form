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

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Validator\StringLength as StringLengthValidator;

class StringLength extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null)
    {
        $rules = [];
        if ($validator->getMin() > 0) {
            $rules['minlength'] = $validator->getMin();
        }
        if ($validator->getMax() > 0) {
            $rules['maxlength'] = $validator->getMax();
        }

        return $rules;
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        $messages = [];
        if ($validator->getMin() > 0) {
            $messages['minlength'] = sprintf($this->translateMessage('At least %s characters are required'), $validator->getMin());
        }
        if ($validator->getMax() > 0) {
            $messages['maxlength'] = sprintf($this->translateMessage('At most %s characters are allowed'), $validator->getMax());
        }

        return $messages;
    }

    /**
     * Whether this rule supports certain validators
     *
     * @param ValidatorInterface $validator
     * @return mixed
     */
    public function canHandle(ValidatorInterface $validator)
    {
        return $validator instanceof StringLengthValidator;
    }
}
