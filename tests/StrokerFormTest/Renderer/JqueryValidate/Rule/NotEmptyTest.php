<?php
/**
 * NotEmptyTest
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use Zend\Validator\NotEmpty;

class NotEmptyTest extends AbstractRuleTest
{
	/**
	 * @return RuleInterface
	 */
	protected function createRule()
	{
		return new \StrokerForm\Renderer\JqueryValidate\Rule\NotEmpty();
	}

	/**
	 * @return ValidatorInterface
	 */
	protected function createValidator()
	{
		return new NotEmpty();
	}

	/**
	 * Assert that the currect rules are returned
	 */
	public function testCorrectRulesAreReturned()
	{
		$this->assertEquals(array('required' => true), $this->getRules());
	}

	/**
	 * Assert that the correct messages are returned
	 */
	public function testCorrectMessagesAreReturned()
	{
		$this->assertArrayHasKey('required', $this->getMessages());
	}
}