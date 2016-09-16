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

use StrokerForm\Renderer\AbstractValidateRenderer;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use StrokerForm\Renderer\JqueryValidate\Rule\RulePluginManager;
use Zend\Form\Element\Email;
use Zend\Form\ElementInterface;
use Zend\Form\FormInterface;
use Zend\Json\Json;
use Zend\Validator\EmailAddress;
use Zend\Validator\Regex;
use Zend\Validator\ValidatorInterface;
use Zend\View\Renderer\PhpRenderer as View;

class Renderer extends AbstractValidateRenderer
{
    /**
     * @var array
     */
    protected $skipValidators = [
        'Explode',
        'Upload'
    ];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $messages = [];

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
     *
     * @return FormInterface
     */
    public function preRenderForm($formAlias, View $view, FormInterface $form = null, array $options = [])
    {
        $form = parent::preRenderForm($formAlias, $view, $form, $options);

        /** @var $options Options */
        $options = $this->getOptions();

        $inlineScript = $view->plugin('inlineScript');
        $inlineScript->appendScript($this->buildInlineJavascript($form, $options));

        if ($options->getIncludeAssets()) {
            $assetBaseUri = $this->getHttpRouter()->assemble([], ['name' => 'strokerform-asset']);
            $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/jquery.validate.js');
            $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/custom_rules.js');
            if ($options->isUseTwitterBootstrap() === true) {
                $inlineScript->appendFile($assetBaseUri . '/jquery_validate/js/jquery.validate.bootstrap.js');
            }
        }

        $this->reset();
        return $form;
    }

    /**
     * @param  \Zend\Form\FormInterface $form
     * @param Options                   $options
     *
     * @return string
     */
    protected function buildInlineJavascript(FormInterface $form, Options $options)
    {
        $validateOptions = [];
        foreach ($options->getValidateOptions() as $key => $value) {
            $value = (is_string($value)) ? $value : var_export($value, true);
            $validateOptions[] = '"' . $key . '": ' . $value;
        }

        return sprintf(
            $options->getInitializeTrigger(),
            sprintf(
                '$(\'form[name="%s"]\').each(function() { $(this).validate({%s"rules":%s,"messages":%s}); });',
                $form->getName(),
                count($validateOptions) > 0 ? implode(',', $validateOptions) . ',' : '',
                Json::encode($this->rules),
                Json::encode($this->messages)
            )
        );
    }

    /**
     * @param string                             $formAlias
     * @param \Zend\Form\ElementInterface        $element
     * @param \Zend\Validator\ValidatorInterface $validator
     *
     * @return mixed|void
     */
    protected function addValidationAttributesForElement($formAlias, ElementInterface $element, ValidatorInterface $validator = null)
    {
        if (in_array($this->getValidatorClassName($validator), $this->skipValidators)) {
            return;
        }
        if ($element instanceof Email && $validator instanceof Regex) {
            $validator = new EmailAddress();
        }

        $rule = $this->getRule($validator);
        $rules = [];
        if ($rule !== null) {
            $rules = $rule->getRules($validator, $element);
            $messages = $rule->getMessages($validator);
        } elseif (!$this->getOptions()->isDisableAjaxFallback()) {
            //fallback ajax
            $ajaxUri = $this->getHttpRouter()->assemble(['form' => $formAlias], ['name' => 'strokerform-ajax-validate']);
            $rules = [
                'remote' => [
                    'url'  => $ajaxUri,
                    'type' => 'POST'
                ]
            ];
            $messages = [];
        }

        if (count($rules) > 0) {
            $elementName = $this->getElementName($element);
            $this->addRules($elementName, $rules);
            $this->addMessages($elementName, $messages);
        }
    }

    /**
     * @param  \Zend\Validator\ValidatorInterface $validator
     *
     * @return null|RuleInterface
     */
    public function getRule(ValidatorInterface $validator = null)
    {
        foreach ($this->getRulePluginManager()->getRegisteredServices() as $rules) {
            foreach ($rules as $rule) {
                $ruleInstance = $this->getRulePluginManager()->get($rule);
                if ($ruleInstance->canHandle($validator)) {
                    return $ruleInstance;
                }
            }
        }

        return;
    }

    /**
     * @param string $elementName
     * @param array  $rules
     */
    protected function addRules($elementName, array $rules = [])
    {
        if (!isset($this->rules[$elementName])) {
            $this->rules[$elementName] = [];
        }
        $this->rules[$elementName] = array_merge($this->rules[$elementName], $rules);
    }

    /**
     * @param string $elementName
     * @param array  $messages
     */
    protected function addMessages($elementName, array $messages = [])
    {
        if (!isset($this->messages[$elementName])) {
            $this->messages[$elementName] = [];
        }
        $this->messages[$elementName] = array_merge($this->messages[$elementName], $messages);
    }

    /**
     * Resets previously set rules and messages, if you have multiple forms on one request
     */
    protected function reset()
    {
        $this->rules = [];
        $this->messages = [];
    }
}
