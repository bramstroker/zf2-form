<?php
/**
 * Description
 *
 * @category  Acsi
 * @package   Acsi\
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer;

class RendererCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RendererCollection
     */
    private $rendererCollection = null;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->rendererCollection = new RendererCollection($this->getMock('StrokerForm\FormManager'));
        for ($i = 0; $i < 3; $i++) {
            $renderer = $this->getMock('StrokerForm\Renderer\RendererInterface');
            $this->rendererCollection->addRenderer($renderer);
        }
    }

    /**
     * testGetRenderers
     */
    public function testGetRenderers()
    {
        $this->assertCount(3, $this->rendererCollection->getRenderers());
    }

    /**
     * testPreRenderFormIsCalledOnInnerRenderers
     */
    public function testPreRenderFormIsCalledOnInnerRenderers()
    {
        $formAlias = 'testAlias';
        $viewMock = $this->getMock('Zend\View\Renderer\PhpRenderer');

        /** @var $renderer \PHPUnit_Framework_MockObject_MockObject */
        foreach ($this->rendererCollection->getRenderers() as $renderer) {
            $renderer->expects($this->once())
                     ->method('preRenderForm')
                     ->with($formAlias, $this->equalTo($viewMock));
        }

        $this->rendererCollection->preRenderForm($formAlias, $viewMock);
    }

    /**
     * testPreRenderInputFieldIsCalledOnInnerRenderers
     */
    public function testPreRenderInputFieldIsCalledOnInnerRenderers()
    {
        $elemMock = $this->getMock('Zend\Form\ElementInterface');

        /** @var $renderer \PHPUnit_Framework_MockObject_MockObject */
        foreach ($this->rendererCollection->getRenderers() as $renderer) {
            $renderer->expects($this->once())
                     ->method('preRenderInputField')
                     ->with($this->equalTo($elemMock));
        }

        $this->rendererCollection->preRenderInputField($elemMock);
    }
}
