<?php
/**
 * Regex
 *
 * @category  AcsiWidget\Renderer\JqueryValidate\Rule
 * @package   AcsiWidget\Renderer\JqueryValidate\Rule
 * @copyright 2016 ACSI Holding bv (http://www.acsi.eu)
 * @version   SVN: $Id: $
 */

namespace StrokerForm\Renderer\JqueryValidate\Rule;

use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Validator\Regex as RegexValidator;

class Regex extends AbstractRule
{

    /**
     * Get the validation rules
     *
     * @param ValidatorInterface $validator
     * @param ElementInterface $element
     * @return array
     */
    public function getRules(ValidatorInterface $validator, ElementInterface $element = null)
    {
        /**@var RegexValidator $validator */
        $pattern = $validator->getPattern();
        $modifier = '';

        // Only i, m and g modifier are compatible with Ecmascript regexp
        if (preg_match('/\/(.*)\/([img])?/', $pattern, $matches)) {
            $pattern = $matches[1];
            if (isset($matches[2])) {
                $modifier = $matches[2];
            }
        }

        return ['regex' => [$pattern, $modifier]];
    }

    /**
     * Get the validation message
     *
     * @param  ValidatorInterface $validator
     * @return array
     */
    public function getMessages(ValidatorInterface $validator)
    {
        return ['regex' => $this->translateMessage('Field does not match expected pattern')];
    }

    /**
     * @param ValidatorInterface $validator
     * @return bool
     */
    public function canHandle(ValidatorInterface $validator)
    {
        return $validator instanceof RegexValidator;
    }
}
