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
use Zend\Mvc\Router\RouteInterface;
use Zend\Stdlib\AbstractOptions;
use Zend\View\Renderer\PhpRenderer as View;

interface RendererInterface
{
    /**
     * Excecuted before the ZF2 view helper renders the element
     *
     * @param string                   $formAlias
     * @param View                     $view
     * @param \Zend\Form\FormInterface $form
     * @param array                    $options
     *
     * @return
     */
    public function preRenderForm($formAlias, View $view, FormInterface $form = null, array $options = array());

    /**
     * Excecuted before the ZF2 view helper renders the element
     *
     * @param ElementInterface $element
     */
    public function preRenderInputField(ElementInterface $element);

    /**
     * Set the route to use for serving assets
     *
     * @param  \Zend\Mvc\Router\RouteInterface $route
     *
     * @return mixed
     */
    public function setHttpRouter(RouteInterface $route);

    /**
     * Set renderer options
     *
     * @param AbstractOptions $options
     */
    public function setDefaultOptions(AbstractOptions $options = null);
}
