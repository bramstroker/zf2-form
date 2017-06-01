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

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Validator\InArray as InArrayValidator;

class InArray extends AbstractRule
{
    /**
     * Get the validation rules
     *
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @param \Zend\Form\ElementInterface         $element
     *
     * @return array
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null)
    {
        // Javascript doesn't support associative arrays. Therefore, check if the array is associative,
        // and if so, transform it to a non-associative one.
        if (array_keys($validator->getHaystack()) !== range(0, count($validator->getHaystack()) - 1)) {
            return ['in_array' => array_values($validator->getHaystack())];
        }

        return ['in_array' => (array)$validator->getHaystack()];
    }

    /**
     * Get the validation message
     *
     * @param  \Zend\Validator\ValidatorInterface $validator
     *
     * @return string
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return [
            'in_array' => $validator->getMessageTemplates()[\Zend\Validator\InArray::NOT_IN_ARRAY]
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
        return $validator instanceof InArrayValidator;
    }
}
