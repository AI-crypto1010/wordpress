<?php

namespace ImageOptimization\Classes\Image;

use ImageOptimization\Modules\Settings\Classes\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Image_Conversion {
	protected ?string $convert_to_format;
	protected array $options;

	public function is_enabled(): bool {
		return Image_Conversion_Option::ORIGINAL !== $this->convert_to_format;
	}

	public function get_current_conversion_option(): string {
		return $this->convert_to_format;
	}

	public function get_current_file_extension(): ?string {
		if ( ! $this->is_enabled() ) {
			return null;
		}

		return $this->options[ $this->convert_to_format ]['extension'];
	}

	public function get_current_mime_type(): ?string {
		if ( ! $this->is_enabled() ) {
			return null;
		}

		return $this->options[ $this->convert_to_format ]['mime_type'];
	}

	public function __construct() {
		$this->convert_to_format = Settings::get( Settings::CONVERT_TO_FORMAT_OPTION_NAME );

		$this->options = [
			Image_Conversion_Option::WEBP => [
				'extension' => 'webp',
				'mime_type' => 'image/webp',
			],
			Image_Conversion_Option::AVIF => [
				'extension' => 'avif',
				'mime_type' => 'image/avif',
			],
		];
	}
}
