<?php
 /**
 * InArrayTest
 *
 * @category  StrokerFormTest\Renderer\JqueryValidate\Rule
 * @package   StrokerFormTest\Renderer\JqueryValidate\Rule
 * @copyright 2013 ACSI Holding bv (http://www.acsi.eu)
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;


use Zend\Validator\InArray;

class InArrayTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new \StrokerForm\Renderer\JqueryValidate\Rule\InArray();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        $validator = new InArray();
        $validator->setHaystack(array(1, 2, 3, 4, 5));

        return $validator;
    }

    /**
     * Assert that the currect rules are returned
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(array('in_array' => array(1, 2, 3, 4, 5)), $this->getRules());
    }

    /**
     * Assert that the correct messages are returned
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('in_array', $this->getMessages());
    }
}
