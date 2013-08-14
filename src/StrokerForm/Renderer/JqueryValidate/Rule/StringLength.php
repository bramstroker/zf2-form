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

use Zend\Validator\ValidatorInterface;

class StringLength extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator)
    {
        $rules = array();
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
        $messages = array();
        if ($validator->getMin() > 0) {
            $messages['minlength'] = sprintf($this->translateMessage('At least %s characters are required'), $validator->getMin());
        }
        if ($validator->getMax() > 0) {
            $messages['maxlength'] = sprintf($this->translateMessage('At most %s characters are allowed'), $validator->getMax());
        }

        return $messages;
    }
}
