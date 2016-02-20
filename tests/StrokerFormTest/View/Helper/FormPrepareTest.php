<?php
/**
 * FormPrepareTest
 *
 * @category  StrokerFormTest
 * @package   StrokerFormTest\View
 * @copyright 2016 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Controller;

use PHPUnit_Framework_TestCase;
use Mockery as M;
use StrokerForm\View\Helper\FormPrepare;

class FormPrepareTest extends PHPUnit_Framework_TestCase
{
    public function testFormPrepareIsCalledOnRenderer()
    {
        $viewRenderer = M::mock('Zend\View\Renderer\PhpRenderer');
        $rendererMock = M::mock('StrokerForm\Renderer\RendererInterface')
            ->shouldReceive('preRenderForm')
            ->with('form-alias', $viewRenderer, null, array())
            ->once()
            ->getMock();
        $helper = new FormPrepare($rendererMock);

        $helper->setView($viewRenderer);

        $helper->__invoke('form-alias', null, array());
    }
}
