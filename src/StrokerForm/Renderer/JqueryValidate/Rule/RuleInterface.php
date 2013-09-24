<?php
/**
 * RuleInterface
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;

interface RuleInterface
{
    /**
     * Get the validation rules
     *
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @param \Zend\Form\ElementInterface $element
     * @return array
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null);

    /**
     * Get the validation message
     *
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @return string
     */
    public function getMessages(ValidatorInterface $validator);
}
