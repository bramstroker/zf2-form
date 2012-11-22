<?php
/**
 * LessThanTest
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

class LessThanTest extends AbstractRuleTest
{
	/**
	 * @return RuleInterface
	 */
	protected function createRule()
	{
		return new \StrokerForm\Renderer\JqueryValidate\Rule\LessThan();
	}

	/**
	 * @return ValidatorInterface
	 */
	protected function createValidator()
	{
		return new \Zend\Validator\LessThan();
	}

	/**
	 * Assert that the currect rules are returned
	 */
	public function testCorrectRulesAreReturned()
	{
		$max = 20;
		$this->getValidator()->setMax($max);
		$this->assertEquals(array('max' => $max), $this->getRules());
	}

	/**
	 * Assert that the correct messages are returned
	 */
	public function testCorrectMessagesAreReturned()
	{
		$this->assertArrayHasKey('max', $this->getMessages());
	}
}