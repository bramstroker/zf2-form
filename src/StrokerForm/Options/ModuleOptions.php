<?php
/**
 * Defines all possible options for the module
 *
 * @category  StrokerForm
 * @package   StrokerForm\Options
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerForm\Options;

use InvalidArgumentException;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ConfigInterface;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    private $activeRenderers = array();

    /**
     * @var array
     */
    private $forms = array();

    /**
     * @var array
     */
    private $rendererOptions = array();

    /**
     * @return array
     */
    public function getActiveRenderers()
    {
        return $this->activeRenderers;
    }

    /**
     * @param array
     */
    public function setActiveRenderers(array $activeRenderers)
    {
        $this->activeRenderers = $activeRenderers;
    }

    /**
     * @return ConfigInterface
     * @throws InvalidArgumentException
     */
    public function getForms()
    {
        if (is_array($this->forms)) {
            $this->forms = new Config($this->forms);
        }

        if (!$this->forms instanceof ConfigInterface) {
            throw new InvalidArgumentException('Plugins argument must be an array or instanceof Zend\ServiceManager\ConfigInterface');
        }

        return $this->forms;
    }

    /**
     * @param array $forms
     */
    public function setForms($forms)
    {
        $this->forms = $forms;
    }

    /**
     * @param array $options
     */
    public function setRendererOptions(array $options)
    {
        $this->rendererOptions = array();
        foreach ($options as $renderer => $rendererOptions) {
            $this->addRendererOptions($renderer, $rendererOptions);
        }
    }

    /**
     * @param  string $renderer
     * @param  array  $options
     *
     * @throws \InvalidArgumentException
     */
    public function addRendererOptions($renderer, $options)
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException('No options given for renderer ' . $renderer);
        }
        if (!isset($options['options_class'])) {
            throw new \InvalidArgumentException('No options_class configured for renderer ' . $renderer);
        }

        $optionsClass = $options['options_class'];
        unset($options['options_class']);
        $options = new $optionsClass($options);

        $this->rendererOptions[$renderer] = $options;
    }

    /**
     * @param string $renderer
     *
     * @return null|AbstractOptions
     * @throws \InvalidArgumentException
     */
    public function getRendererOptions($renderer)
    {
        return $this->rendererOptions[$renderer];
    }
}
