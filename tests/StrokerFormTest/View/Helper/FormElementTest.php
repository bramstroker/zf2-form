<?php
/**
 * FormElementTest
 *
 * @category  StrokerFormTest
 * @package   StrokerFormTest\View
 * @copyright 2016 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Controller;

use PHPUnit_Framework_TestCase;
use Mockery as M;
use StrokerForm\View\Helper\FormElement;

class FormElementTest extends PHPUnit_Framework_TestCase
{
    public function testRenderInput()
    {
        $elementMock = M::mock('Zend\Form\ElementInterface');
        $rendererMock = M::mock('StrokerForm\Renderer\RendererInterface')
            ->shouldReceive('preRenderInputField')
            ->with($elementMock)
            ->once()
            ->getMock();

        $helper = new FormElement($rendererMock);
        $helper->__invoke($elementMock);
    }

    public function testHelperExtendsBaseZendHelper()
    {
        $helper = new FormElement(M::mock('StrokerForm\Renderer\RendererInterface'));
        $this->assertInstanceOf('Zend\Form\View\Helper\FormElement', $helper);
    }
}
