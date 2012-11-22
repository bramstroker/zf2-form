<?php
/**
 * BetweenTest
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

class BetweenTest extends AbstractRuleTest
{
	/**
	 * @return RuleInterface
	 */
	protected function createRule()
	{
		return new \StrokerForm\Renderer\JqueryValidate\Rule\Between();
	}

	/**
	 * @return ValidatorInterface
	 */
	protected function createValidator()
	{
		return new \Zend\Validator\Between();
	}

	/**
	 * Assert that the currect rules are returned
	 */
	public function testBoundariesAreCorrectUsingInclusiveMode()
	{
		$min = 5;
		$max = 10;
		$this->getValidator()->setMin($min);
		$this->getValidator()->setMax($max);
		$this->getValidator()->setInclusive(true);
		$this->assertEquals(array('range' => array($min, $max)), $this->getRules());
	}

	/**
	 * Assert that the currect rules are returned
	 */
	public function testBoundariesAreCorrectUsingNonInclusiveMode()
	{
		$min = 5;
		$max = 10;
		$this->getValidator()->setMin($min);
		$this->getValidator()->setMax($max);
		$this->getValidator()->setInclusive(false);
		$this->assertEquals(array('range' => array(6, 9)), $this->getRules());
	}

	/**
	 * Assert that the correct messages are returned
	 */
	public function testCorrectMessagesAreReturned()
	{
		$this->assertArrayHasKey('range', $this->getMessages());
	}
}