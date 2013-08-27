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

use Zend\View\Renderer\PhpRenderer as View;
use Zend\Form\FormInterface;
use Zend\Validator\ValidatorInterface;
use Zend\Form\ElementInterface;
use Zend\Form\Form;
use Zend\Form\Element\Collection;

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

    public function extractValidatorsForForm($formOrFieldset, $inputFilter)
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

        /** @var $fieldset \Zend\Form\FieldSetInterface */
        foreach ($formOrFieldset->getFieldsets() as $key => $fieldset) {
            $foundValidators = array_merge($foundValidators, $this->extractValidatorsForForm($fieldset, $inputFilter->get($key)));
        }

        return $foundValidators;
    }

    public function getValidatorsForElement($inputFilter, $element)
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
     * @param  string                             $formAlias
     * @param  \Zend\Form\ElementInterface        $element
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @return mixed
     */
    abstract protected function addValidationAttributesForElement($formAlias, ElementInterface $element, ValidatorInterface $validator = null);

    /**
     * Get the name of the form element
     *
     * @param  \Zend\Form\ElementInterface $element
     * @return string
     */
    protected function getElementName(ElementInterface $element)
    {
        $elementName = $element->getName();
        if ($element instanceof \Zend\Form\Element\MultiCheckbox && !$element instanceof \Zend\Form\Element\Radio) {
            $elementName .= '[]';
        }

        return $elementName;
    }

    /**
     * Get the classname of the zend validator
     *
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @return mixed
     */
    protected function getValidatorClassName(ValidatorInterface $validator = null)
    {
        $namespaces = explode('\\', get_class($validator));
        return end($namespaces);
    }
}
