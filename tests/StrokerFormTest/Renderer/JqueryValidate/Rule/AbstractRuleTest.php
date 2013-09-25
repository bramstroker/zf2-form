<?php
/**
 * Description
 *
 * @category  StrokerFormTest
 * @package   StrokerFormTest\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use Zend\Form\Element\Text;
use Zend\Form\ElementInterface;
use Zend\Validator\ValidatorInterface;

abstract class AbstractRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var ElementInterface
     */
    protected $element;

    /**
     * @var
     */
    protected $translatorMock;

    /**
     * @return RuleInterface
     */
    abstract protected function createRule();

    /**
     * @return ValidatorInterface
     */
    abstract protected function createValidator();

    /**
     * Create Form element
     */
    protected function createElement()
    {
        if($this->element === null)
        {
            $this->element = new Text("element");
        }
        return $this->element;
    }

    /**
     * Setup test
     */
    public function setUp()
    {
        $this->rule = $this->createRule();
        $this->translatorMock = $this->getMock('Zend\I18n\Translator\Translator', array('translate'));
        $this->rule->setTranslator($this->translatorMock);
        $this->validator = $this->createValidator();
        $this->element = $this->createElement();
    }

    /**
     * @return array
     */
    protected function getRules()
    {
        return $this->getRule()->getRules($this->getValidator(), $this->getElement());
    }

    /**
     * @return array
     */
    protected function getMessages()
    {
        return $this->getRule()->getMessages($this->getValidator());
    }

    /**
     * @return RuleInterface
     */
    protected function getRule()
    {
        return $this->rule;
    }

    /**
     * @return ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return \Zend\Form\ElementInterface
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @return mixed
     */
    protected function getTranslatorMock()
    {
        return $this->translatorMock;
    }

    /**
     * testGetRulesReturnsArray
     */
    public function testGetRulesReturnsArray()
    {
        $this->assertTrue(is_array($this->getRule()->getRules($this->getValidator(), $this->getElement())));
    }
}
