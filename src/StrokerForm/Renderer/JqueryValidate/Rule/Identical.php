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

use Zend\Validator\ValidatorInterface;

class Identical extends AbstractRule
{
    /**
     * {@inheritDoc}
     */
    public function getRules(ValidatorInterface $validator)
    {
        return array('equalTo' => '[name="' . $validator->getToken() . '"]');
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return array('equalTo' => $this->translateMessage('Please enter the same value again.'));
    }
}
