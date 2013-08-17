<?php
/**
 * UriTest
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use StrokerForm\Renderer\JqueryValidate\Rule\Uri;

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
        return new \Zend\Validator\Uri();
    }

    /**
     * Assert that the currect rules are returned
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(array('url' => true), $this->getRules());
    }

    /**
     * Assert that the correct messages are returned
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('url', $this->getMessages());
    }
}
