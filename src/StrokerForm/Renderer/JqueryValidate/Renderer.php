<?php
/**
 * Renderer for the jquery.validate plugin
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate;

use StrokerForm\Renderer\JqueryValidate\Rule\RulePluginManager;
use Zend\Json\Json;
use Zend\View\Renderer\PhpRenderer as View;
use Zend\Form\FormInterface;
use StrokerForm\Renderer\AbstractValidateRenderer;
use Zend\Validator\ValidatorInterface;
use Zend\Form\ElementInterface;

class Renderer extends AbstractValidateRenderer
{
    /**
     * @var array
     */
    protected $skipValidators = array(
        'InArray',
        'Explode',
        'Upload'
    );

    /**
     * @var array
     */
    private $rules = array();

    /**
     * @var array
     */
    private $messages = array();

    /**
     * @var RulePluginManager
     */
    protected $rulePluginManager;

    /**
     * @param RulePluginManager $rulePluginManager
     */
    public function setRulePluginManager(RulePluginManager $rulePluginManager)
    {
        $this->rulePluginManager = $rulePluginManager;
    }

    /**
     * @return RulePluginManager
     */
    public function getRulePluginManager()
    {
        return $this->rulePluginManager;
    }

    /**
     * Executed before the ZF2 view helper renders the element
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

        parent::preRenderForm($formAlias, $view, $form, $options);

        /** @var $options Options */
        $options = $this->getOptions();

        $inlineScript = $view->plugin('inlineScript');
        $inlineScript->appendScript($this->getInlineJavascript($form, $options));

        if ($options->isIncludeAssets()) {
            $assetBaseUri = $this->getHttpRouter()->assemble(array(), array('name' => 'strokerform-asset'));
            $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/jquery.validate.js');
            if ($options->isUseTwitterBootstrap() === true) {
                $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/jquery.validate.bootstrap.js');
            }
        }
    }

    /**
     * @param  \Zend\Form\FormInterface $form
     * @param Options $options
     * @return string
     */
    protected function getInlineJavascript(FormInterface $form, Options $options)
    {
        $validateOptions = $options->getValidateOptions();
        $validateOptions['rules'] = $this->rules;
        $validateOptions['messages'] = $this->messages;

        return sprintf(
            $options->getInitializeTrigger(),
            sprintf(
                '$(\'form[name="%s"]\').validate(%s);',
                $form->getName(),
                Json::encode($validateOptions)
            )
        );
    }

    /**
     * @param string $formAlias
     * @param \Zend\Form\ElementInterface        $element
     * @param \Zend\Validator\ValidatorInterface $validator
     * @return mixed|void
     */
    protected function addValidationAttributesForElement($formAlias, ElementInterface $element, ValidatorInterface $validator = null)
    {
        if (in_array($this->getValidatorClassName($validator), $this->skipValidators)) {
            return;
        }
        if ($element instanceof \Zend\Form\Element\Email && $validator instanceof \Zend\Validator\Regex) {
            $validator = new \Zend\Validator\EmailAddress();
        }

        $rule = $this->getRule($validator);
        if ($rule !== null) {
            $rules = $rule->getRules($validator, $element);
            $messages = $rule->getMessages($validator);
        } else {
            //fallback ajax
            $ajaxUri = $this->getHttpRouter()->assemble(array('form' => $formAlias), array('name' => 'strokerform-ajax-validate'));
            $rules = array(
                'remote' => array(
                    'url' => $ajaxUri,
                    'type' => 'POST'
                )
            );
            $messages = array();
        }

        $elementName = $this->getElementName($element);

        if (!isset($this->rules[$elementName])) {
            $this->rules[$elementName] = array();
        }
        $this->rules[$elementName] = array_merge($this->rules[$elementName], $rules);
        if (!isset($this->messages[$elementName])) {
            $this->messages[$elementName] = array();
        }
        $this->messages[$elementName] = array_merge($this->messages[$elementName], $messages);
    }

    /**
     * @param  \Zend\Validator\ValidatorInterface $validator
     * @return null|Rule\AbstractRule
     */
    public function getRule(ValidatorInterface $validator = null)
    {
        $validatorName = lcfirst($this->getValidatorClassName($validator));
        if ($this->getRulePluginManager()->has($validatorName)) {
            $rule = $this->getRulePluginManager()->get($validatorName);
            if ($rule instanceof TranslatorAwareInterface) {
                $rule->setTranslatorTextDomain($this->getTranslatorTextDomain());
            }
            return $rule;
        }
        return null;
    }
}
