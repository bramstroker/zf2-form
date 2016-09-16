<?php

/**
 * NotEmptyTest.
 *
 * @category  StrokerForm
 *
 * @copyright 2012 Bram Gerritsen
 *
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\NotEmpty;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use Zend\Validator\NotEmpty as ZendEmpty;
use Zend\Validator\ValidatorInterface;

class NotEmptyTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new NotEmpty();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new ZendEmpty();
    }

    /**
     * Assert that the currect rules are returned.
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(['required' => true], $this->getRules());
    }

    /**
     * Assert that the correct messages are returned.
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('required', $this->getMessages());
    }
}
