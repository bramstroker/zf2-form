<?php
/**
 * Options for renderers
 *
 * @category   StrokerForm
 * @package    StrokerForm\Renderer
 * @subpackage JqueryValidate
 * @copyright  2012 Bram Gerritsen
 * @version    SVN: $Id$
 */

namespace StrokerForm\Renderer;

use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    /**
     * @var bool
     */
    private $includeAssets = true;

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

    /**
     * True merging of two arrays, as opposed to PHPs default array_merge_recursive,
     * which doesn't do true merging of array keys
     *
     * @param array $a The original array
     * @param array $b The array to merge
     *
     * @return array
     */
    public function mergeRecursive(array $a, array $b)
    {
        $merged = $a;

        if (is_array($b)) {
            foreach ($b as $key => $val) {
                if (is_array($b[$key])) {
                    if (isset($merged[$key])) {
                        $merged[$key] = is_array($merged[$key]) ? $this->mergeRecursive($merged[$key], $b[$key]) : $b[$key];
                    } else {
                        $merged[$key] = $b[$key];
                    }
                } else {
                    $merged[$key] = $val;
                }
            }
        }

        return $merged;
    }
}
