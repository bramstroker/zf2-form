<?php
/**
 * EmailAddressTest
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

class EmailAddressTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new \StrokerForm\Renderer\JqueryValidate\Rule\EmailAddress();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new \Zend\Validator\EmailAddress();
    }

    /**
     * Assert that the currect rules are returned
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(array('email' => true), $this->getRules());
    }

    /**
     * Assert that the correct messages are returned
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('email', $this->getMessages());
    }
}
