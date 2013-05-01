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
        if ($form === null) {
            $form = $this->getFormManager()->get($formAlias);
        }

        $inputFilter = $form->getInputFilter();
        foreach ($form->getElements() as $element) {
            $input = null;
            if ($inputFilter !== null && $inputFilter->has($element->getName())) {
                $input = $inputFilter->get($element->getName());
            }
            if ($input === null) {
                continue;
            }

            // Make sure NotEmpty validator is added when input is required
            $input->isValid();

            $chain = $input->getValidatorChain();
            $validators = $chain->getValidators();
            foreach ($validators as $validator) {
                $this->addValidationAttributesForElement($formAlias, $element, $validator['instance']);
            }
        }
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
}
