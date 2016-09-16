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

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Validator\LessThan as LessThanValidator;

class LessThan extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null)
    {
        return ['max' => $validator->getMax()];
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return [
            'max' =>
                sprintf($this->translateMessage('The input is not less than %s'), $validator->getMax())
        ];
    }

    /**
     * Whether this rule supports certain validators
     *
     * @param ValidatorInterface $validator
     * @return mixed
     */
    public function canHandle(ValidatorInterface $validator)
    {
        return $validator instanceof LessThanValidator;
    }
}
