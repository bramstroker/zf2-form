<?php

/**
 * EmailAddressTest.
 *
 * @category  StrokerForm
 *
 * @copyright 2012 Bram Gerritsen
 *
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\EmailAddress;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use Zend\Validator\EmailAddress as ZendEmailAddress;
use Zend\Validator\ValidatorInterface;

class EmailAddressTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new EmailAddress();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new ZendEmailAddress();
    }

    /**
     * Assert that the currect rules are returned.
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(['email' => true], $this->getRules());
    }

    /**
     * Assert that the correct messages are returned.
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('email', $this->getMessages());
    }
}
