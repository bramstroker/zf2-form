<?php
/**
 * Form manager
 *
 * @category  StrokerForm
 * @package   StrokerForm
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm;

use Zend\Form\FormInterface;
use Zend\ServiceManager\AbstractPluginManager;

class FormManager extends AbstractPluginManager
{
    /**
     * Validate the plugin
     *
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed $plugin
     *
     * @return void
     * @throws \RuntimeException if invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof FormInterface) {
            // we're okay
            return;
        }

        throw new \RuntimeException(
            sprintf(
                'Form of type %s is invalid; must implement FormInterface',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin))
            )
        );
    }

    /**
     * @param string $name
     * @param array  $options
     * @param bool   $usePeeringServiceManagers
     *
     * @return FormInterface
     */
    public function get($name, $options = [], $usePeeringServiceManagers = true)
    {
        $formElementManager = $this->getServiceLocator()->get('FormElementManager');
        if ($formElementManager->has($name)) {
            $form = $formElementManager->get($name);
            if ($form instanceof FormInterface) {
                return $form;
            }
        }
        
        //allow use of form factory
        if($this->getServiceLocator()->has($name)){
            $form = $this->getServiceLocator()->get($name);

            return $form;
        }
        
        return parent::get($name, $options, $usePeeringServiceManagers);
    }
}
