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

use StrokerForm\FormManager;
use Zend\Mvc\Controller\AbstractActionController;

class AjaxController extends AbstractActionController
{
    /**
     * @var FormManager
     */
    protected $formManager;

    /**
     * Default constructor
     *
     * @param FormManager $formManager
     */
    public function __construct(FormManager $formManager)
    {
        $this->setFormManager($formManager);
    }

    /**
     * Validate a field and return validation messages on failure
     *
     * @throws \InvalidArgumentException
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function validateAction()
    {
        /** @var $request \Zend\Http\PhpEnvironment\Request */
        $request = $this->getRequest();
        $response = $this->getResponse();

        $data = $request->getPost()->toArray();

        if (count($data) > 1) {
            throw new \InvalidArgumentException('Validating multiple fields is not allowed');
        }
        if (empty($data)) {
            throw new \InvalidArgumentException('No input data received');
        }

        $formAlias = $this->getEvent()->getRouteMatch()->getParam('form');

        /** @var $form \Zend\Form\FormInterface */
        $form = $this->getFormManager()->get($formAlias);

        $filter = $form->getInputFilter();
        $filter->setData($data);
        $filter->setValidationGroup($this->convertDataArrayToValidationGroup($data));
        $valid = $filter->isValid();

        if (!$valid) {
            $messages = $filter->getMessages();

            $result = false;
            array_walk_recursive($messages, function($item) use (&$result) {
                if (is_string($item)) {
                    $result = $item;
                }
            });
        } else {
            $result = true;
        }

        $response->setContent(\Zend\Json\Json::encode($result));

        return $response;
    }

    /**
     * Convert post data to a format for the validation group
     *
     * i.e. from:
     *   array('fieldset' => array('field1' => 'field value'))
     * to:
     *   array('fieldset' => array('field1'))
     *
     * @param $data
     * @return array
     */
    protected function convertDataArrayToValidationGroup($data) {
        $ret = array();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $ret[$key] = $this->convertDataArrayToValidationGroup($value);
            } else {
                $ret[] = $key;
            }
        }
        return $ret;
    }

    /**
     * @return \StrokerForm\FormManager
     */
    public function getFormManager()
    {
        return $this->formManager;
    }

    /**
     * @param \StrokerForm\FormManager $formManager
     */
    public function setFormManager($formManager)
    {
        $this->formManager = $formManager;
    }
}
