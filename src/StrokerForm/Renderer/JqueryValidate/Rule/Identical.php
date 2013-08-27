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

use Zend\Form\Element;
use Zend\Validator\ValidatorInterface;

class Identical extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator, Element $element = null)
    {
        $token = $validator->getToken();

        if (strpos($element->getName(), "[") !== false) {
            $token = preg_replace('#\[[^\]]+\]$#i', "[" . $token ."]", $element->getName());
        }

        return array('equalTo' => '[name="' . $token . '"]');
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return array('equalTo' => $this->translateMessage('Please enter the same value again.'));
    }
}
