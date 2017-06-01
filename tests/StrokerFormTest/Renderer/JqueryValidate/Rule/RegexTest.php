<?php

/**
 * RegexTest.
 *
 * @category  StrokerForm
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use PHPUnit\Framework\TestCase;
use StrokerForm\Renderer\JqueryValidate\Rule\Regex;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use Zend\Validator\Regex as RegexValidator;

class RegexTest extends TestCase
{
    /**
     * @return RuleInterface
     */
    protected function createRule()
    {
        return new Regex();
    }

    /**
     * @dataProvider rulesProvider
     * @param string $pattern
     * @param array $jqueryValidateParams
     */
    public function testGetRules($pattern, array $jqueryValidateParams)
    {
        $validator = new RegexValidator($pattern);
        $rule = new Regex();
        $rules = $rule->getRules($validator);
        $this->assertEquals(['regex' => $jqueryValidateParams], $rules);
    }

    /**
     * @return array
     */
    public function rulesProvider()
    {
        return [
            'regex_without_slaches' => ['(^-?\d*(.\d+)?$)', ['(^-?\d*(.\d+)?$)', '']],
            'supported_modifier' => ['/\d/i', ['\d', 'i']],
            'unsupported_modifier' => ['/\d/s', ['\d', '']],
        ];
    }
}
