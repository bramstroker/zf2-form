<?php
/**
 * Identical
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Validator\Identical as IdenticalValidator;

class Identical extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null)
    {
        $token = $validator->getToken();

        if (strpos($element->getName(), "[") !== false) {
            $token = preg_replace('#\[[^\]]+\]$#i', "[" . $token . "]", $element->getName());
        }

        return ['equalTo' => '[name="' . $token . '"]'];
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return ['equalTo' => $this->translateMessage('Please enter the same value again.')];
    }

    /**
     * Whether this rule supports certain validators
     *
     * @param ValidatorInterface $validator
     * @return mixed
     */
    public function canHandle(ValidatorInterface $validator)
    {
        return $validator instanceof IdenticalValidator;
    }
}
