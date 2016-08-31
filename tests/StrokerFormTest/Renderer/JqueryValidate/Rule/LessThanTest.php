<?php

/**
 * LessThanTest.
 *
 * @category  StrokerForm
 *
 * @copyright 2012 Bram Gerritsen
 *
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\LessThan;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use Zend\Validator\LessThan as ZendLessThan;
use Zend\Validator\ValidatorInterface;

class LessThanTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new LessThan();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new ZendLessThan();
    }

    /**
     * Assert that the currect rules are returned.
     */
    public function testCorrectRulesAreReturned()
    {
        $max = 20;
        $this->getValidator()->setMax($max);
        $this->assertEquals(array('max' => $max), $this->getRules());
    }

    /**
     * Assert that the correct messages are returned.
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('max', $this->getMessages());
    }
}
