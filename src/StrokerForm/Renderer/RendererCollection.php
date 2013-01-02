<?php
/**
 * Description
 *
 * @category  StrokerForm
 * @package   StrokerForm\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Renderer;

use Zend\Form\ElementInterface;
use Zend\Form\FormInterface;
use Zend\View\Renderer\PhpRenderer as View;
use Zend\Form\Form;

class RendererCollection extends AbstractRenderer
{
	/**
	 * @var RendererInterface[]
	 */
	private $renderers = array();

	/**
	 * Get inner renderers
	 *
	 * @return RendererInterface[]
	 */
	public function getRenderers()
	{
		return $this->renderers;
	}

	/**
	 * Set inner renderer
	 *
	 * @param RendererInterface[] $renderers
	 */
	public function setRenderers($renderers)
	{
		$this->renderers = $renderers;
	}

	/**
	 * Add a renderer
	 *
	 * @param RendererInterface $renderer
	 */
	public function addRenderer(RendererInterface $renderer)
	{
		$this->renderers[] = $renderer;
	}

    /**
     * Excecuted before the ZF2 view helper renders the element
     *
     * @param string $formAlias
     * @param \Zend\View\Renderer\PhpRenderer $view
     * @param \Zend\Form\FormInterface $form
     * @return mixed
     */
	public function preRenderForm($formAlias, View $view, FormInterface $form = null)
	{
		foreach($this->getRenderers() as $renderer)
		{
			$renderer->preRenderForm($formAlias, $view, $form);
		}
	}

	/**
	 * Excecuted before the ZF2 view helper renders the element
	 *
	 * @param ElementInterface $element
	 * @return mixed
	 */
	public function preRenderInputField(ElementInterface $element)
	{
		foreach ($this->getRenderers() as $renderer)
		{
			$renderer->preRenderInputField($element);
		}
	}
}
