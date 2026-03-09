<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Classes\Basic_Enum;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Image_Conversion_Option extends Basic_Enum {
	public const ORIGINAL = 'original';
	public const WEBP = 'webp';
	public const AVIF = 'avif';
}
