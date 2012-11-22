<?php
/**
 * Options for the jquery validate renderer
 *
 * @category   StrokerForm
 * @package    StrokerForm\Renderer
 * @subpackage JqueryValidate
 * @copyright  2012 Bram Gerritsen
 * @version    SVN: $Id$
 */

namespace StrokerForm\Renderer\JqueryValidate;

use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
	/**
	 * @var array
	 */
	private $validateOptions = array();

	/**
	 * @var bool
	 */
	private $includeAssets = true;

	/**
	 * @return array
	 */
	public function getValidateOptions()
	{
		return $this->validateOptions;
	}

	/**
	 * Overwrite default options for the jquery.validate plugin
	 * See: http://docs.jquery.com/Plugins/Validation#Options_for_the_validate.28.29_method
	 *
	 * @param $validateOptions
	 */
	public function setValidateOptions($validateOptions)
	{
		$this->validateOptions = $validateOptions;
	}

	/**
	 * @param $key
	 * @param $value
	 */
	public function addValidateOption($key, $value)
	{
		$this->validateOptions[$key] = $value;
	}

	/**
	 * @return bool
	 */
	public function getIncludeAssets()
	{
		return $this->includeAssets;
	}

	/**
	 * @param bool $includeAssets
	 */
	public function setIncludeAssets($includeAssets)
	{
		$this->includeAssets = $includeAssets;
	}
}