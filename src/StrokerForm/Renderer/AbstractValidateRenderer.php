<?php
/**
 * Description
 *
 * @category  Acsi
 * @package   Acsi\
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer;

use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Radio;
use Zend\Form\FieldsetInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\View\Renderer\PhpRenderer as View;
use Zend\Form\FormInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Form\ElementInterface;

abstract class AbstractValidateRenderer extends AbstractRenderer
{
    /**
     * Excecuted before the ZF2 view helper renders the element
     *
     * @param string                          $formAlias
     * @param \Zend\View\Renderer\PhpRenderer $view
     * @param \Zend\Form\FormInterface        $form
     * @param array                           $options
     */
    public function preRenderForm($formAlias, View $view, FormInterface $form = null, array $options = array())
    {
        $this->setOptions($options);

        if ($form === null) {
            $form = $this->getFormManager()->get($formAlias);
        }

        $inputFilter = $form->getInputFilter();

        /** @var $element \Zend\Form\Element */
        $validators = $this->extractValidatorsForForm($form, $inputFilter);
        foreach ($validators as $validator) {
            $element = $validator['element'];
            foreach ($validator['validators'] as $val) {
                $this->addValidationAttributesForElement($formAlias, $element, $val['instance']);
            };
        }
    }

    /**
     * Iterate through all the elements and retrieve their validators
     *
     * @param FieldsetInterface $formOrFieldset
     * @param InputFilterInterface $inputFilter
     * @return array
     */
    public function extractValidatorsForForm(FieldsetInterface $formOrFieldset, InputFilterInterface $inputFilter)
    {
        $foundValidators = array();
        foreach ($formOrFieldset->getElements() as $element) {
            $validators = $this->getValidatorsForElement($inputFilter, $element);
            if (count($validators) > 0) {
                $foundValidators[] = array(
                    'element' => $element,
                    'validators' => $validators
                );
            }
        }

        foreach ($formOrFieldset->getFieldsets() as $key => $fieldset) {
            if ($inputFilter->has($key)) {
                $foundValidators = array_merge($foundValidators, $this->extractValidatorsForForm($fieldset, $inputFilter->get($key)));
            }
        }

        return $foundValidators;
    }

    /**
     * Get all validators for a given element
     *
     * @param InputFilterInterface $inputFilter
     * @param ElementInterface     $element
     * @return mixed
     */
    public function getValidatorsForElement(InputFilterInterface $inputFilter, ElementInterface $element)
    {
        if ($element->getOption('strokerform-exclude')) {
            return;
        }

        // Check if we are dealing with a fieldset element
        if (preg_match('/^.*\[(.*)\]$/', $element->getName(), $matches)) {
            $elementName = $matches[1];
        } else {
            $elementName = $element->getName();
        }

        if (!$inputFilter->has($elementName)) {
            return;
        }
        $input = $inputFilter->get($elementName);

        // Make sure NotEmpty validator is added when input is required
        $input->isValid();

        $chain = $input->getValidatorChain();
        return $chain->getValidators();
    }

    /**
     * Excecuted before the ZF2 view helper renders the element
     *
     * @param  ElementInterface $element
     * @return mixed
     */
    public function preRenderInputField(ElementInterface $element)
    {
    }

    /**
     * @param  string             $formAlias
     * @param  ElementInterface   $element
     * @param  ValidatorInterface $validator
     * @return mixed
     */
    abstract protected function addValidationAttributesForElement($formAlias, ElementInterface $element, ValidatorInterface $validator = null);

    /**
     * Get the name of the form element
     *
     * @param  ElementInterface $element
     * @return string
     */
    protected function getElementName(ElementInterface $element)
    {
        $elementName = $element->getName();
        if ($element instanceof MultiCheckbox && !$element instanceof Radio) {
            $elementName .= '[]';
        }

        return $elementName;
    }

    /**
     * Get the classname of the zend validator
     *
     * @param  ValidatorInterface $validator
     * @return mixed
     */
    protected function getValidatorClassName(ValidatorInterface $validator = null)
    {
        $namespaces = explode('\\', get_class($validator));
        return end($namespaces);
    }
}
