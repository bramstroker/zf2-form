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

use Zend\ServiceManager\AbstractPluginManager;
use Zend\Form\FormInterface;

class FormManager extends AbstractPluginManager
{
    /**
     * Validate the plugin
     *
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed             $plugin
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
}
