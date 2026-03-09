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
class ElseifBlock extends Block
{
    /**
     * @var array
     */
    public $cond;

    public function __construct()
    {
        $this->type = Type::T_ELSEIF;
    }
}
