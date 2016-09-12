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
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\Validator\ValidatorInterface;

interface RuleInterface extends TranslatorAwareInterface
{
    /**
     * Get the validation rules
     *
     * @param ValidatorInterface $validator
     * @param ElementInterface   $element
     *
     * @return array
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null);

    /**
     * Get the validation message
     *
     * @param  ValidatorInterface $validator
     *
     * @return array
     */
    public function getMessages(ValidatorInterface $validator);
}
