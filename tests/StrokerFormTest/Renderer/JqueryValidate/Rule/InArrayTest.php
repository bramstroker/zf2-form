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


use StrokerForm\Renderer\JqueryValidate\Rule\InArray;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use Zend\Validator\InArray as ZendInArray;
use Zend\Validator\ValidatorInterface;

class InArrayTest extends AbstractRuleTest
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new InArray();
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        $validator = new ZendInArray();
        $validator->setHaystack(array(1, 2, 3, 4, 5));

        return $validator;
    }

    /**
     * Assert that the currect rules are returned
     */
    public function testCorrectRulesAreReturned()
    {
        $this->assertEquals(
            array('in_array' => array(1, 2, 3, 4, 5)), $this->getRules()
        );
    }

    /**
     * Assert that the correct messages are returned
     */
    public function testCorrectMessagesAreReturned()
    {
        $this->assertArrayHasKey('in_array', $this->getMessages());
    }

    public function testIfAssociativeArrayTransformed()
    {
        $validator = new ZendInArray();
        $validator->setHaystack(array('foo' => 'bar', 'fuu' => 'buz'));

        $this->validator = $validator;

        $this->assertEquals(
            array('in_array' => array(0 => 'bar', 1 => 'buz')),
            $this->getRules()
        );
    }
}
