<?php
/**
 * RendererTest
 *
 * @category  StrokerFormTest
 * @package   StrokerFormTest\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate;

use Mockery\MockInterface;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Zend\Form\Fieldset;
use StrokerForm\Renderer\JqueryValidate\Rule\RulePluginManager;
use Zend\Form\Factory;
use StrokerForm\Renderer\JqueryValidate\Renderer;
use Zend\I18n\Translator\Translator;
use Zend\InputFilter\InputFilter;
use Zend\View\Renderer\PhpRenderer;

class RendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var \StrokerForm\Renderer\JqueryValidate\Options
     */
    private $rendererOptions;

    /**
     * @var \Zend\View\Renderer\PhpRenderer
     */
    private $view;

    /**
     * @var MockInterface|\Zend\Mvc\Router\RouteInterface
     */
    private $routerMock;

    /**
     * @var MockInterface|\Zend\I18n\Translator\Translator
     */
    private $translatorMock;

    /**
     * @var MockInterface
     */
    private $formManager;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->formManager = \Mockery::mock('StrokerForm\FormManager');
        $this->renderer = new Renderer();
        $this->renderer->setRulePluginManager(new RulePluginManager());
        $this->renderer->setFormManager($this->formManager);
        $this->view = new PhpRenderer();

        $this->routerMock = \Mockery::mock('Zend\Mvc\Router\SimpleRouteStack')
            ->shouldReceive('assemble')
            ->byDefault()
            ->getMock();
        $this->translatorMock = \Mockery::mock('Zend\I18n\Translator\Translator')
            ->shouldReceive('translate')
            ->andReturnUsing(
                function ($string) {
                    return $string;
                }
            )
            ->getMock();
        $this->rendererOptions = new \StrokerForm\Renderer\JqueryValidate\Options();
        $this->renderer->setHttpRouter($this->routerMock);
        $this->renderer->setTranslator($this->translatorMock);
        $this->renderer->setDefaultOptions($this->rendererOptions);
    }

    /**
     * Get a test form with fields setup
     *
     * @param string $alias
     * @return \Zend\Form\FormInterface
     */
    protected function createForm($alias)
    {
        $factory = new Factory();
        $form = $factory->createForm(
            array(
                'hydrator' => 'Zend\Stdlib\Hydrator\ArraySerializable',
                'name' => 'test',
                'elements' => array(
                    array(
                        'spec' => array(
                            'name' => 'name',
                            'options' => array(
                                'label' => 'Your name',
                            ),
                        )
                    ),
                    array(
                        'spec' => array(
                            'name' => 'email',
                            'type' => 'Zend\Form\Element\Email',
                            'options' => array(
                                'label' => 'Your email address',
                            ),
                        ),
                    ),
                )
            )
        );

        // Register form to the form manager
        $this->formManager
            ->shouldReceive('get')
            ->with($alias)
            ->andReturn($form);

        return $form;
    }

    public function testCorrectRulesAreAdded()
    {
        $form = $this->createForm('test');

        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'emailAddress'
                )
            )
        ));
        $inputFilter->add(array(
            'name'     => 'name',
            'required' => true
        ));

        $form->setInputFilter($inputFilter);

        $this->renderer->preRenderForm('test', $this->view);

        $matches = $this->getMatchesFromInlineScript();

        $rules = $matches['rules'];
        $messages = $matches['messages'];

        $this->assertEquals('test', $matches['form']);
        $this->assertTrue($rules['name']['required']);
        $this->assertTrue($rules['email']['required']);
        $this->assertTrue($rules['email']['email']);
        $this->assertNotEmpty($messages['name']['required']);
        $this->assertNotEmpty($messages['email']['required']);
        $this->assertNotEmpty($messages['email']['email']);
    }

    public function testFallbackToAjaxWhenNoClientsideValidatorAvailable()
    {
        $form = $this->createForm('test');

        $this->routerMock
            ->shouldReceive('assemble')
            ->andReturn('/the/uri/to/ajax');

        $inputFilter = new InputFilter();
        $inputFilter->add(array(
            'name'     => 'name',
            'validators' => array(
                array(
                    'name' => 'isbn'
                )
            )
        ));

        $form->setInputFilter($inputFilter);

        $this->renderer->preRenderForm('test', $this->view);

        $matches = $this->getMatchesFromInlineScript();

        $rules = $matches['rules'];

        $this->assertEquals('/the/uri/to/ajax', $rules['name']['remote']['url']);
        $this->assertEquals('POST', $rules['name']['remote']['type']);
    }

    public function testDefaultRendererOptionsCanBeOverwrittenAtRuntime()
    {
        $this->createForm('test');
        $this->rendererOptions->setIncludeAssets(false);

        $this->renderer->preRenderForm('test', $this->view, null, array('include_assets' => true));

        $this->assertTrue($this->renderer->getOptions()->isIncludeAssets());
    }

    public function testExtraValidateOptionsCouldBeSet()
    {
        $this->createForm('test');
        $this->rendererOptions->setValidateOptions(array(
            'onsubmit' => false,
            'submitHandler' => 'myHandler'
        ));
        $this->renderer->preRenderForm('test', $this->view);
        $matches = $this->getMatchesFromInlineScript();
        $this->assertStringStartsWith('{"onsubmit": false,"submitHandler": myHandler', $matches['options']);
    }

    public function testJavascriptAssetsAreIncludedToInlineScript()
    {
        $this->createForm('test');
        $this->renderer->preRenderForm('test', $this->view);

        /** @var $inlineScript \Zend\View\Helper\InlineScript */
        $inlineScript = $this->view->plugin('inlineScript');
        $jsTagsFound = 0;
        foreach ($inlineScript->getContainer() as $item) {
            if ($item->type == 'text/javascript' &&
                !empty($item->attributes) &&
                strpos($item->attributes['src'], '/js/jqueryvalidate/jquery.validate') >= 0) {
                $jsTagsFound++;
            }
        }
        $this->assertEquals(2, $jsTagsFound);
    }

    public function testEmailElementAlwaysUsesEmailAddressValidator()
    {
        $this->createForm('test');

        $this->renderer->preRenderForm('test', $this->view);
        $matches = $this->getMatchesFromInlineScript();

        $rules = $matches['rules'];
        $this->assertTrue($rules['email']['email']);
    }

    public function testExcludeElement()
    {
        $form = $this->createForm('test');
        $nameElement = $form->get('name');
        $nameElement->setOptions(array('strokerform-exclude' => true));
        $this->renderer->preRenderForm('test', $this->view);

        $matches = $this->getMatchesFromInlineScript();

        $rules = $matches['rules'];
        $this->assertArrayNotHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
    }

    public function testFormWithFieldset()
    {
        $form = $this->createForm('test');

        $foobarElement = new Element('foobar');
        $foobarInput = new Input('foobar');
        $foobarInput->setRequired(true);

        $fieldset = new Fieldset('myfieldset');
        $fieldset->add($foobarElement);

        $fieldsetInputfilter = new InputFilter();
        $fieldsetInputfilter->add($foobarInput);

        $form->getInputFilter()->add($fieldsetInputfilter, 'myfieldset');

        $form->add($fieldset);

        $form->prepare();

        $this->renderer->preRenderForm('test', $this->view);

        $matches = $this->getMatchesFromInlineScript();

        $rules = $matches['rules'];
        $messages = $matches['messages'];
        $this->assertArrayHasKey('myfieldset[foobar]', $rules);
        $this->assertArrayHasKey('myfieldset[foobar]', $messages);
    }

    /**
     * Get rules and messages as matches from the inlineScript string
     *
     * @return array
     */
    protected function getMatchesFromInlineScript()
    {
        /** @var $inlineScript \Zend\View\Helper\InlineScript */
        $inlineScript = $this->view->plugin('inlineScript');
        $inlineString = preg_replace('/(\r\n|\r|\n|\t)+/', '', $inlineScript->toString());
        if(preg_match('/\$\(\'form\[name=\"(?P<form>[a-z]*)"\]\'\)\.validate\((?P<options>.*)\);}\);/', $inlineString, $matches))
        {
            return $matches;
        }

        return array();
    }

    /**
     * @return \Mockery\MockInterface
     */
    public function getFormManager()
    {
        return $this->formManager;
    }
}
