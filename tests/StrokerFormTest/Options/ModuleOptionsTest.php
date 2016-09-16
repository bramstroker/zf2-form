<?php

/**
 * ModuleOptionsTest.
 *
 * @category  StrokerFormTest
 *
 * @copyright 2016 Bram Gerritsen
 *
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Controller;

use PHPUnit_Framework_TestCase;
use StrokerForm\Options\ModuleOptions;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    public function testCanSetActiveRenderers()
    {
        $options = new ModuleOptions();
        $options->setActiveRenderers(['foo', 'bar']);
        $this->assertEquals(
            ['foo', 'bar'], $options->getActiveRenderers()
        );
    }
}
