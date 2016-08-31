<?php
/**
 * IdenticalTest
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\Identical as IdenticalRule;
use Zend\Form\Element\Text;
use Zend\Validator\Identical as IdenticalValidator;

class IdenticalTest extends AbstractRuleTest
{
    /**
     * @var string
     */
    protected $token = 'token';

    /**
     * @var IdenticalValidator
     */
    protected $validator;

    /**
     * @var IdenticalRule
     */
    protected $rule;

    /**
     * @return IdenticalRule
     */
    protected function createRule()
    {
        if ($this->rule === null) {
            $this->rule = new IdenticalRule();
        }
        return $this->rule;
    }

    /**
     * @return IdenticalValidator
     */
    protected function createValidator()
    {
        if ($this->validator === null) {
            $this->validator = new IdenticalValidator($this->token);
        }
        return $this->validator;
    }

    /**
     * Create Form element
     */
    protected function createElement()
    {
        if ($this->element === null) {
            $this->element = new Text("fieldset[element]");
        }
        return $this->element;
    }

    /**
     * Test only minlegth attribute when no max length is set on the validator
     */
    public function testToken()
    {
        $this->assertEquals(
            array('equalTo' => '[name="fieldset[' . $this->token . ']"]'),
            $this->getRules()
        );
        $this->assertArrayHasKey('equalTo', $this->getMessages());
    }
}
