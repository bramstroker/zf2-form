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

use Zend\Stdlib\AbstractOptions;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Config;
use StrokerForm\Options\RendererOptions;

class ModuleOptions extends AbstractOptions
{
	/**
	 * @var array
	 */
	private $activeRenderers;

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
	 * @return array
	 */
	public function getForms()
	{
		return $this->forms;
	}

	/**
	 * @param array $forms
	 * @throws InvalidArgumentException
	 */
	public function setForms($forms)
	{
		if (is_array($forms))
		{
			$forms = new Config($forms);
		}

		if (!$forms instanceof ConfigInterface)
		{
			throw new InvalidArgumentException('Plugins argument must be an array or instanceof Zend\ServiceManager\ConfigInterface');
		}

		$this->forms = $forms;
	}

	/**
	 * @param array $options
	 */
	public function setRendererOptions(array $options)
	{
		$this->rendererOptions = array();
		foreach($options as $renderer => $options)
		{
			$this->addRendererOptions($renderer, $options);
		}
	}

	/**
	 * @param $renderer
	 * @param $options
	 */
	public function addRendererOptions($renderer, $options)
	{
		if (!is_array($options))
		{
			throw new \InvalidArgumentException('No options given for renderer ' . $renderer);
		}
		if (!isset($options['options_class']))
		{
			throw new \InvalidArgumentException('No options_class configured for renderer ' . $renderer);
		}

		$optionsClass = $options['options_class'];
		unset($options['options_class']);
		$options = new $optionsClass($options);

		$this->rendererOptions[$renderer] = $options;
	}

	/**
	 * @param $renderer
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function getRendererOptions($renderer)
	{
		return $this->rendererOptions[$renderer];
	}

	/**
	 * @return \StrokerForm\Renderer\JqueryValidate\Options
	 */
	public function getJqueryValidateOptions()
	{
		return $this->jqueryValidateOptions;
	}

	/**
	 * @param array $jqueryValidateOptions
	 */
	public function setJqueryValidateOptions(array $jqueryValidateOptions)
	{
		$this->jqueryValidateOptions = new \StrokerForm\Renderer\JqueryValidate\Options($jqueryValidateOptions);
	}
}