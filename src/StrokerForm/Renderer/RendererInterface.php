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
use Zend\Stdlib\AbstractOptions;
use Zend\Form\FormInterface;
use Zend\Mvc\Router\RouteInterface;
use Zend\View\Renderer\PhpRenderer as View;

interface RendererInterface
{
    /**
     * Excecuted before the ZF2 view helper renders the element
     *
     * @param string $formAlias
     * @param View $view
     * @param \Zend\Form\FormInterface $form
     */
	public function preRenderForm($formAlias, View $view, FormInterface $form = null);

	/**
	 * Excecuted before the ZF2 view helper renders the element
	 *
	 * @param ElementInterface $element
	 */
	public function preRenderInputField(ElementInterface $element);

	/**
	 * Sets translator to use in helper
	 *
	 * @param  Translator $translator  [optional] translator.
	 *                                 Default is null, which sets no translator.
	 * @param  string     $textDomain  [optional] text domain
	 *                                 Default is null, which skips setTranslatorTextDomain
	 * @return AbstractTranslatorHelper
	 */
	public function setTranslator(\Zend\I18n\Translator\Translator $translator = null, $textDomain = null);

	/**
	 * Set the route to use for serving assets
	 *
	 * @param \Zend\Mvc\Router\RouteInterface $route
	 * @return mixed
	 */
	public function setHttpRouter(RouteInterface $route);

	/**
	 * Set renderer options
	 *
	 * @param AbstractOptions $options
	 */
	public function setOptions(AbstractOptions $options = null);
}