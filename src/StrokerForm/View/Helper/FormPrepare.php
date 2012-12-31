<?php
/**
 * This view helper makes the view and form available in the renderers
 *
 * @category  StrokerForm
 * @package   StrokerForm\View
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use StrokerForm\Renderer\RendererInterface;
use Zend\Form\Form;

class FormPrepare extends AbstractHelper
{
	/**
	 * @var RendererInterface
	 */
	private $renderer;

	/**
	 * @param RendererInterface $renderer
	 */
	public function __construct(RendererInterface $renderer)
	{
		$this->renderer = $renderer;
	}

	/**
	 * @param string $formAlias
	 */
	public function __invoke($formAlias)
	{
		$this->renderer->preRenderForm($formAlias, $this->getView());
	}
}
