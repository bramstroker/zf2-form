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

class Options extends \StrokerForm\Renderer\Options
{
    /**
     * @var array
     */
    private $validateOptions = array();

    /**
     * @var bool
     */
    private $useTwitterBootstrap = true;

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
     * @param array $validateOptions
     */
    public function setValidateOptions($validateOptions)
    {
        $this->validateOptions = $validateOptions;
    }

    /**
     * @param string $option
     */
    public function addValidateOption($option)
    {
        $this->validateOptions[] = $option;
    }

    /**
     * @return bool
     */
    public function isUseTwitterBootstrap()
    {
        return $this->useTwitterBootstrap;
    }

    /**
     * @param bool $useTwitterBootstrap
     */
    public function setUseTwitterBootstrap($useTwitterBootstrap)
    {
        $this->useTwitterBootstrap = $useTwitterBootstrap;
    }
}
