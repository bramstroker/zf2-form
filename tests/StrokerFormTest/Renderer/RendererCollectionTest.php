<?php

/**
 * Description.
 *
 * @category  Acsi
 *
 * @copyright 2012 Bram Gerritsen
 *
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer;

use Mockery;
use StrokerForm\FormManager;
use Zend\Form\ElementInterface;
use Zend\View\Renderer\PhpRenderer;

class RendererCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RendererCollection
     */
    private $rendererCollection = null;

    /**
     * Setup.
     */
    public function setUp()
    {
        $this->rendererCollection = new RendererCollection(
            $this->createMock(FormManager::class)
        );
        for ($i = 0; $i < 3; ++$i) {
            $renderer = $this->createMock(
                RendererInterface::class
            );
            $this->rendererCollection->addRenderer($renderer);
        }
    }

    /**
     * testGetRenderers.
     */
    public function testGetRenderers()
    {
        $this->assertCount(3, $this->rendererCollection->getRenderers());
    }

    /**
     * testPreRenderFormIsCalledOnInnerRenderers.
     */
    public function testPreRenderFormIsCalledOnInnerRenderers()
    {
        $formAlias = 'testAlias';
        $viewMock = Mockery::mock(PhpRenderer::class);

        /** @var $renderer \PHPUnit_Framework_MockObject_MockObject */
        foreach ($this->rendererCollection->getRenderers() as $renderer) {
            $renderer->expects($this->once())
                ->method('preRenderForm')
                ->with($formAlias, $this->equalTo($viewMock));
        }

        $this->rendererCollection->preRenderForm($formAlias, $viewMock);
    }

    /**
     * testPreRenderInputFieldIsCalledOnInnerRenderers.
     */
    public function testPreRenderInputFieldIsCalledOnInnerRenderers()
    {
        $elemMock = $this->createMock(ElementInterface::class);

        /** @var $renderer \PHPUnit_Framework_MockObject_MockObject */
        foreach ($this->rendererCollection->getRenderers() as $renderer) {
            $renderer->expects($this->once())
                ->method('preRenderInputField')
                ->with($this->equalTo($elemMock));
        }

        $this->rendererCollection->preRenderInputField($elemMock);
    }
}
