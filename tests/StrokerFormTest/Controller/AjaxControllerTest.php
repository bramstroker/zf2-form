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

namespace StrokerFormTest\Controller;

use StrokerForm\Controller\AjaxController;
use StrokerForm\FormManager;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

class AjaxControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractController
     */
    protected $controller;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * @var MvcEvent
     */
    protected $event;

    /**
     * @var FormManager
     */
    protected $formManager;

    /**
     * Setup.
     */
    public function setUp()
    {
        $this->setFormManager(new FormManager());
        $this->controller = new AjaxController($this->getFormManager());
        $this->request = new Request();
        $this->response = new Response();

        $controllerName = strtolower(
            str_replace('Controller', '', get_class($this->controller))
        );
        $this->routeMatch = new RouteMatch(
            ['controller' => $controllerName]
        );
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    /**
     * testExceptionWhenNoPostDataIsProvided.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionWhenNoPostDataIsProvided()
    {
        $this->dispatchAction('validate');
    }

    /**
     * @param string $actionName
     *
     * @return mixed|\Zend\Stdlib\ResponseInterface
     */
    protected function dispatchAction($actionName)
    {
        $this->getRouteMatch()->setParam('action', $actionName);

        return $this->getController()->dispatch(
            $this->getRequest(), $this->getResponse()
        );
    }

    /**
     * Assert response code matches given responseCode.
     *
     * @param int $responseCode
     */
    protected function assertResponseCode($responseCode)
    {
        $this->assertEquals(
            $responseCode, $this->getResponse()->getStatusCode()
        );
    }

    /**
     * Assert certain header is found.
     *
     * @param string $expectedValue
     * @param string $headerType
     */
    protected function assertHeader($expectedValue, $headerType)
    {
        $header = $this->getResponse()->getHeaders()->get($headerType);
        if ($header === false) {
            $this->fail('No '.$headerType.' header found');
        }
        $this->assertEquals($expectedValue, $header->getFieldValue());
    }

    /**
     * @return \Zend\Mvc\Controller\AbstractController
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param \Zend\Mvc\Controller\AbstractController $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Zend\Stdlib\ResponseInterface $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return \Zend\Mvc\Router\RouteMatch
     */
    public function getRouteMatch()
    {
        return $this->routeMatch;
    }

    /**
     * @param \Zend\Mvc\Router\RouteMatch $routeMatch
     */
    public function setRouteMatch($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    /**
     * @return \Zend\Mvc\MvcEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return FormManager
     */
    public function getFormManager()
    {
        return $this->formManager;
    }

    /**
     * @param FormManager $formManager
     */
    public function setFormManager(FormManager $formManager)
    {
        $this->formManager = $formManager;
    }
}
