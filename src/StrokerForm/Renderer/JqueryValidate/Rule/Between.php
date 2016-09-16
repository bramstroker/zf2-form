<?php
/**
 * Between
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Validator\Between as BetweenValidator;

class Between extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null)
    {
        return ['range' => [$this->getMin($validator), $this->getMax($validator)]];
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return [
            'range' =>
                sprintf($this->translateMessage('The input is not between %s and %s'), $this->getMin($validator), $this->getMax($validator))
        ];
    }

    /**
     * @param  ValidatorInterface $validator
     *
     * @return mixed
     */
    protected function getMin(ValidatorInterface $validator)
    {
        return $validator->getInclusive() ? $validator->getMin() : $validator->getMin() + 1;
    }

    /**
     * @param  ValidatorInterface $validator
     *
     * @return mixed
     */
    protected function getMax(ValidatorInterface $validator)
    {
        return $validator->getInclusive() ? $validator->getMax() : $validator->getMax() - 1;
    }

    /**
     * Whether this rule supports certain validators
     *
     * @param ValidatorInterface $validator
     * @return mixed
     */
    public function canHandle(ValidatorInterface $validator)
    {
        return $validator instanceof BetweenValidator;
    }
}
