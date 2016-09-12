<?php

/**
 * DigitsTest.
 *
 * @category  StrokerForm
 *
 * @copyright 2012 Bram Gerritsen
 *
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\Digits;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use Zend\Validator\Digits as ZendDigits;
use Zend\Validator\ValidatorInterface;

class DigitsTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new Digits();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new ZendDigits();
    }

    /**
     * Assert that the currect rules are returned.
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(array('digits' => true), $this->getRules());
    }

    /**
     * Assert that the correct messages are returned.
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('digits', $this->getMessages());
    }
}
