<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Internal_URL')) {
	class Internal_URL extends \Elementor\Core\DynamicTags\Data_Tag {

		public function get_name() {
			return 'internal-url';
		}

		public function get_group() {
			return ['pixfort-site'];
		}

		public function get_categories() {
			return [\Elementor\Modules\DynamicTags\Module::URL_CATEGORY];
		}

		public function get_title() {
			return esc_html__('Internal URL', 'pixfort-core');
		}

		public function get_panel_template() {
			return ' ({{ url }})';
		}

		/**
		 * @since 3.6.0
		 * @deprecated 3.8.0 Use `On_Import_Trait::on_import_update_dynamic_content()` instead.
		 *
		 * Remove in the future.
		 */
		public static function on_import_replace_dynamic_content($config, $map_old_new_post_ids) {
			if (isset($config['settings']['post_id'])) {
				$config['settings']['post_id'] = $map_old_new_post_ids[$config['settings']['post_id']];
			}

			return $config;
		}

	public function get_value(array $options = []) {
		$settings = $this->get_settings();

		$type = $settings['type'];
		$url = '';

		if ('post' === $type && !empty($settings['post_id'])) {
			$url = get_permalink((int) $settings['post_id']);
		} elseif ('taxonomy' === $type && !empty($settings['taxonomy_id'])) {
			$url = get_term_link((int) $settings['taxonomy_id']);
		} elseif ('attachment' === $type && !empty($settings['attachment_id'])) {
			$url = get_attachment_link((int) $settings['attachment_id']);
		} elseif ('author' === $type && !empty($settings['author_id'])) {
			$url = get_author_posts_url((int) $settings['author_id']);
		} else {
            $url = get_permalink((int) $settings['post_id']);
        }

		if (!is_wp_error($url)) {
			return $url;
		}

		return '';
	}

	protected function register_controls() {
		$this->add_control('type', [
			'label' => esc_html__('Type', 'pixfort-core'),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'post' => esc_html__('Content', 'pixfort-core'),
				'taxonomy' => esc_html__('Taxonomy', 'pixfort-core'),
				'attachment' => esc_html__('Media', 'pixfort-core'),
				'author' => esc_html__('Author', 'pixfort-core'),
			],
		]);

		$this->add_control('post_id', [
			'label' => esc_html__('Search & Select', 'pixfort-core'),
			'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
			'default' => '',
			'label_block' => true,
			'object_type' => 'post',
			'query' => [
				'post_type' => 'any',
			],
			'description' => esc_html__('Search for a post or page by name.', 'pixfort-core'),
			'condition' => [
				'type' => 'post',
			],
		]);

		$this->add_control('taxonomy_id', [
			'label' => esc_html__('Search & Select', 'pixfort-core'),
			'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
			'default' => '',
			'label_block' => true,
			'object_type' => 'taxonomy',
			'description' => esc_html__('Search for a taxonomy term (category, tag, etc.) by name.', 'pixfort-core'),
			'condition' => [
				'type' => 'taxonomy',
			],
		]);

		$this->add_control('attachment_id', [
			'label' => esc_html__('Search & Select', 'pixfort-core'),
			'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
			'default' => '',
			'label_block' => true,
			'object_type' => 'attachment',
			'description' => esc_html__('Search for a media file by name.', 'pixfort-core'),
			'condition' => [
				'type' => 'attachment',
			],
		]);

		$this->add_control('author_id', [
			'label' => esc_html__('Search & Select', 'pixfort-core'),
			'type' => \Elementor\CustomControl\Pix_Query_Search_Control::PixQuerySearch,
			'default' => '',
			'label_block' => true,
			'object_type' => 'author',
			'description' => esc_html__('Search for an author by name.', 'pixfort-core'),
			'condition' => [
				'type' => 'author',
			],
		]);
	}
}
}