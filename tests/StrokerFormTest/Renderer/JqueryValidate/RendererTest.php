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

use Zend\Form\Factory;
use StrokerForm\Renderer\JqueryValidate\Renderer;

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
	 * @var \PHPUnit_Framework_MockObject_MockObject|\Zend\Mvc\Router\RouteInterface
	 */
	private $routerMock;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject|\Zend\I18n\Translator\Translator
	 */
	private $translatorMock;

	/**
	 * Setup
	 */
	public function setUp()
	{
		$this->renderer = new Renderer();

		/*$this->inlineScriptMock = \Mockery::mock('Zend\View\Helper\InlineScript');
		$this->viewMock = \Mockery::mock('Zend\View\Renderer\PhpRenderer')
			->shouldReceive('plugin')
			->with('inlineScript')
			->andReturn()*/

		$this->view = new \Zend\View\Renderer\PhpRenderer();

		$this->routerMock = \Mockery::mock('Zend\Mvc\Router\SimpleRouteStack')
			->shouldReceive('assemble')
			->getMock();
		$this->translatorMock = \Mockery::mock('Zend\I18n\Translator\Translator')
			->shouldReceive('translate')
			->andReturnUsing(function($string) { return $string; } )
			->getMock();
		$this->rendererOptions = new \StrokerForm\Renderer\JqueryValidate\Options();
		$this->renderer->setHttpRouter($this->routerMock);
		$this->renderer->setTranslator($this->translatorMock);
		$this->renderer->setOptions($this->rendererOptions);
	}

	/**
	 * Get a test form with fields setup
	 *
	 * @return \Zend\Form\FormInterface
	 */
	protected function createForm()
	{
		$factory = new Factory();
		$form = $factory->createForm(array(
			'hydrator' => 'Zend\Stdlib\Hydrator\ArraySerializable',
			'name' => 'test',
			'elements' => array(
				array(
					'spec' => array(
						'name' => 'name',
						'options' => array(
							'label' => 'Your name',
						),
						'attributes' => array(
							'type' => 'text'
						),
					)
				),
				array(
					'spec' => array(
						'name' => 'email',
						'options' => array(
							'label' => 'Your email address',
						),
						'attributes' => array(
							'type' => 'text'
						)
					),
				),
			)
		));
		return $form;
	}

	/**
	 * testCorrectRulesAreAdded
	 */
	public function testCorrectRulesAreAdded()
	{
		$form = $this->createForm();

		$inputFilter = new \Zend\InputFilter\InputFilter();
		$inputFilter->add(array(
			'name'     => 'email',
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

		$this->renderer->preRenderForm($form, 'test', $this->view);

		$matches = $this->getMatchesFromInlineScript();

		$rules = json_decode($matches['rules']);
		$messages = json_decode($matches['messages']);

		$this->assertEquals('test', $matches['form']);
		$this->assertTrue($rules->name->required);
		$this->assertTrue($rules->email->required);
		$this->assertTrue($rules->email->email);
		$this->assertNotEmpty($messages->name->required);
		$this->assertNotEmpty($messages->email->required);
		$this->assertNotEmpty($messages->email->email);
	}

	/**
	 * testNoRulesAddedWhenNoInputfilterIsSet
	 */
	public function testNoRulesAddedWhenNoInputfilterIsSet()
	{
		$this->renderer->preRenderForm($this->createForm(), 'test', $this->view);
		$matches = $this->getMatchesFromInlineScript();
		$rules = json_decode($matches['rules']);
		$this->assertEmpty($rules);
	}

	/**
	 * testExtraValidateOptionsCouldBeSet
	 */
	public function testExtraValidateOptionsCouldBeSet()
	{
		$this->rendererOptions->setValidateOptions(array(
			'onsubmit: false'
		));
		$this->renderer->preRenderForm($this->createForm(), 'test', $this->view);
		$matches = $this->getMatchesFromInlineScript();
		$this->assertContains('onsubmit: false', $matches['validate_options']);
	}

	/**
	 * testJavascriptAssetsAreIncludedToInlineScript
	 */
	public function testJavascriptAssetsAreIncludedToInlineScript()
	{
		$this->renderer->preRenderForm($this->createForm(), 'test', $this->view);

		/** @var $inlineScript \Zend\View\Helper\InlineScript */
		$inlineScript = $this->view->plugin('inlineScript');
		$jsTagsFound = 0;
		foreach($inlineScript->getContainer() as $item)
		{
			if ($item->type == 'text/javascript' &&
				!empty($item->attributes) &&
				strpos($item->attributes['src'], '/js/jqueryvalidate/jquery.validate') >= 0)
			{
				$jsTagsFound++;
			}
		}
		$this->assertEquals(2, $jsTagsFound);
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
		preg_match('/\$\(\'\#(?P<form>.*)\'\)\.validate\((?P<validate_options>.*)rules:(?P<rules>.*),messages:(?P<messages>.*),}\);.*/', $inlineString, $matches);
		return $matches;
	}
}
