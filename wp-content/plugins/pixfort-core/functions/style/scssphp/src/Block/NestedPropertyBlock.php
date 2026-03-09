<?php

/**
 * SCSSPHP
 *
 * @copyright 2012-2020 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace PixScssPhp\ScssPhp\Block;

use PixScssPhp\ScssPhp\Block;
use PixScssPhp\ScssPhp\Type;

/**
 * @internal
 */
class NestedPropertyBlock extends Block
{
    /**
     * @var bool
     */
    public $hasValue;

    /**
     * @var array
     */
    public $prefix;

    public function __construct()
    {
        $this->type = Type::T_NESTED_PROPERTY;
    }
}
