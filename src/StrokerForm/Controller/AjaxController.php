<?php
/**
 * Ajax controller. Used for validating forms through ajax
 *
 * @category  StrokerForm
 * @package   StrokerForm\Controller
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Controller;

use StrokerForm\FormPluginManager;

class AjaxController extends \Zend\Mvc\Controller\AbstractActionController
{
	/**
	 * @var FormPluginManager
	 */
	protected $formManager;

	/**
	 * Default constructor
	 *
	 * @param ModuleOptions $options
	 */
	public function __construct(FormPluginManager $formManager)
	{
		$this->setFormManager($formManager);
	}

	/**
	 * Validate a field and return validation messages on failure
	 */
	public function validateAction()
	{
		/** @var $request \Zend\Http\PhpEnvironment\Request */
		$request = $this->getRequest();
		$response = $this->getResponse();

		$data = $request->getPost()->toArray();

		if (count($data) > 1)
		{
			throw new \InvalidArgumentException('Validating multiple fields is not allowed');
		}
		if (empty($data))
		{
			throw new \InvalidArgumentException('No input data received');
		}

		$formAlias = $this->getEvent()->getRouteMatch()->getParam('form');

		/** @var $form \Zend\Form\Form */
		$form = $this->getFormManager()->get($formAlias);

		$fieldName = key($data);

		$filter = $form->getInputFilter();
		$filter->setData($data);
		$filter->setValidationGroup($fieldName);
		$valid = $filter->isValid();

		if (!$valid)
		{
			$messages = $filter->getMessages();
			$messages = $messages[$fieldName];
			$result = (count($messages) > 0) ? current($messages) : false;
		}
		else
		{
			$result = true;
		}

		$response->setContent(\Zend\Json\Json::encode($result));
		return $response;
	}

	/**
	 * @return \StrokerForm\FormPluginManager
	 */
	public function getFormManager()
	{
		return $this->formManager;
	}

	/**
	 * @param \StrokerForm\FormPluginManager $formManager
	 */
	public function setFormManager($formManager)
	{
		$this->formManager = $formManager;
	}
}
