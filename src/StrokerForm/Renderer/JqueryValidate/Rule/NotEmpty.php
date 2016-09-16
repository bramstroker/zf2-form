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

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Validator\NotEmpty as NotEmptyValidator;

class NotEmpty extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null)
    {
        return ['required' => true];
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return ['required' => $this->translateMessage('The input is required and cannot be empty')];
    }

    /**
     * Whether this rule supports certain validators
     *
     * @param ValidatorInterface $validator
     * @return mixed
     */
    public function canHandle(ValidatorInterface $validator)
    {
        return $validator instanceof NotEmptyValidator;
    }
}
