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

use StrokerForm\Renderer\JqueryValidate\Rule\CreditCard;

class CreditCardTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new CreditCard();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new \Zend\Validator\CreditCard();
    }

    /**
     * Assert that the currect rules are returned
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(array('creditcard' => true), $this->getRules());
    }

    /**
     * Assert that the correct messages are returned
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('creditcard', $this->getMessages());
    }
}
