<?php
/**
 * GreaterThanTest
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

class GreaterThanTest extends AbstractRuleTest
{
	/**
	 * @return RuleInterface
	 */
	protected function createRule()
	{
		return new \StrokerForm\Renderer\JqueryValidate\Rule\GreaterThan();
	}

	/**
	 * @return ValidatorInterface
	 */
	protected function createValidator()
	{
		return new \Zend\Validator\GreaterThan();
	}

	/**
	 * Assert that the currect rules are returned
	 */
	public function testCorrectRulesAreReturned()
	{
		$min = 20;
		$this->getValidator()->setMin($min);
		$this->assertEquals(array('min' => $min), $this->getRules());
	}

	/**
	 * Assert that the correct messages are returned
	 */
	public function testCorrectMessagesAreReturned()
	{
		$this->assertArrayHasKey('min', $this->getMessages());
	}
}