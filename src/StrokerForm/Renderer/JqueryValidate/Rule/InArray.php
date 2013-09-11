<?php
 /**
 * InArray
 *
 * @category  StrokerForm\Renderer\JqueryValidate\Rule
 * @package   StrokerForm\Renderer\JqueryValidate\Rule
 * @copyright 2013 ACSI Holding bv (http://www.acsi.eu)
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;


use Zend\Validator\ValidatorInterface;

class InArray extends AbstractRule
{

    /**
     * Get the validation rules
     *
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @return array
     */
    public function getRules(ValidatorInterface $validator)
    {
        return array('in_array' => $validator->getHaystack());
    }

    /**
     * Get the validation message
     *
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @return string
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return array(
            'in_array' =>
            $this->translateMessage('The input is not a valid option')
        );
    }
}
