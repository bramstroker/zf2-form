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

use Mockery as M;
use PHPUnit_Framework_TestCase;
use StrokerForm\Renderer\RendererInterface;
use StrokerForm\View\Helper\FormPrepare;
use Zend\View\Renderer\PhpRenderer;

class FormPrepareTest extends PHPUnit_Framework_TestCase
{
    public function testFormPrepareIsCalledOnRenderer()
    {
        $viewRenderer = M::mock(PhpRenderer::class);
        $rendererMock = M::mock(RendererInterface::class)
            ->shouldReceive('preRenderForm')
            ->with('form-alias', $viewRenderer, null, array())
            ->once()
            ->getMock();
        $helper = new FormPrepare($rendererMock);

        $helper->setView($viewRenderer);

        $helper->__invoke('form-alias', null, array());
    }
}
