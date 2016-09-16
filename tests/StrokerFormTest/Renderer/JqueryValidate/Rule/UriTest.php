<?php

/**
 * UriTest.
 *
 * @category  StrokerForm
 *
 * @copyright 2012 Bram Gerritsen
 *
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use StrokerForm\Renderer\JqueryValidate\Rule\Uri;
use Zend\Validator\Uri as ZendUri;
use Zend\Validator\ValidatorInterface;

class UriTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new Uri();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new ZendUri();
    }

    /**
     * Assert that the currect rules are returned.
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(['url' => true], $this->getRules());
    }

    /**
     * Assert that the correct messages are returned.
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('url', $this->getMessages());
    }
}
