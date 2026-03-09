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
use PixScssPhp\ScssPhp\Compiler\Environment;
use PixScssPhp\ScssPhp\Type;

/**
 * @internal
 */
class ContentBlock extends Block
{
    /**
     * @var array|null
     */
    public $child;

    /**
     * @var Environment|null
     */
    public $scope;

    public function __construct()
    {
        $this->type = Type::T_INCLUDE;
    }
}
