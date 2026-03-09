<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Areas Cache Manager.
 *
 * 
 *
 * @since 1.0
 */
class AreasCache {

	const OPTION_NAME = 'pixfort_conditions';

	protected $conditions = [];

	public function __construct() {
		$this->load();
	}

	public function load() {
		$this->conditions = get_option(self::OPTION_NAME, []);
		return $this;
	}

	public function remove($post_id) {
		$post_id = absint($post_id);

		foreach ($this->conditions as $location => $templates) {
			foreach ($templates as $id => $template) {
				if ($post_id === $id) {
					unset($this->conditions[$location][$id]);
				}
			}
		}

		return $this;
	}

	public function clear() {
		$this->conditions = [];

		return $this;
	}

	public function getAreaByLocation($location) {
		if (isset($this->conditions[$location])) {
			return $this->conditions[$location];
		}

		return [];
	}

	public function refreshPostConditions($location, $post_id, $meta_key) {
		$post_id = absint($post_id);
		if (empty($location) || empty($post_id) || empty($meta_key)) {
			return $this;
		}

		if (!isset($this->conditions[$location])) {
			$this->conditions[$location] = [];
		}

		if (isset($this->conditions[$location][$post_id])) {
			unset($this->conditions[$location][$post_id]);
		}

		if (get_post_status($post_id) !== 'publish') {
			update_option(self::OPTION_NAME, $this->conditions);
			return $this;
		}

		$conditions = get_post_meta($post_id, $meta_key, true);
		$conditions = json_decode($conditions);
		if ($conditions) {
			foreach ($conditions as $key => $condition) {
				$this->conditions[$location][$post_id][$key] = [
					'include'   => $condition->include === 'include' ? true : false,
					'general'   => $condition->general
				];
				if (!empty($condition->nestedValue)) {
					$this->conditions[$location][$post_id][$key]['nestedValue'] = $condition->nestedValue;
				}
				if (!empty($condition->subIDValue)) {
					$this->conditions[$location][$post_id][$key]['subIDValue'] = $condition->subIDValue;
				}
			}
		}

		update_option(self::OPTION_NAME, $this->conditions);
		return $this;
	}

	public function regenerate() {
		$this->clear();
		$popup_posts = get_posts([
			'post_type' => 'pixpopup',
			'post_status' => 'publish',
			'fields' => 'ids',
			'meta_key' => 'popup-condition',
			'numberposts' => -1
		]);

		foreach ($popup_posts as $post_id) {
			// if (function_exists('icl_get_languages')) {
			//     $post_id = get_post(apply_filters('wpml_object_id', $post_id, 'page', true));
			// } 
			$conditions = get_post_meta($post_id, 'popup-condition', true);
			$conditions = json_decode($conditions);
			if ($conditions) {
				foreach ($conditions as $key => $condition) {
					$this->conditions['popup'][$post_id][$key] = [
						'include'   => $condition->include === 'include' ? true : false,
						'general'   => $condition->general
					];
					if (!empty($condition->nestedValue)) {
						$this->conditions['popup'][$post_id][$key]['nestedValue'] = $condition->nestedValue;
					}
					if (!empty($condition->subIDValue)) {
						$this->conditions['popup'][$post_id][$key]['subIDValue'] = $condition->subIDValue;
					}
				}
			}
		}


		// $templates_posts = get_posts([
		// 	'post_type' => 'pixfort_template',
		// 	'post_status' => 'publish',
		// 	'fields' => 'ids',
		// 	'meta_key' => 'template-condition',
		// 	'numberposts' => -1
		// ]);
		// foreach ($templates_posts as $post_id) {
		// 	$conditions = get_post_meta($post_id, 'template-condition', true);
		// 	$conditions = json_decode($conditions);
		// 	if ($conditions) {
		// 		foreach ($conditions as $key => $condition) {
		// 			$this->conditions['template'][$post_id][$key] = [
		// 				'include'   => $condition->include === 'include' ? true : false,
		// 				'general'   => $condition->general
		// 			];
		// 			if (!empty($condition->nestedValue)) {
		// 				$this->conditions['template'][$post_id][$key]['nestedValue'] = $condition->nestedValue;
		// 			}
		// 			if (!empty($condition->subIDValue)) {
		// 				$this->conditions['template'][$post_id][$key]['subIDValue'] = $condition->subIDValue;
		// 			}
		// 		}
		// 	}
		// }

		/*
		 * Header
		 */
		$header_posts = get_posts([
			'post_type' => 'pixheader',
			'post_status' => 'publish',
			'fields' => 'ids',
			'meta_key' => 'header-condition',
			'numberposts' => -1
		]);
		foreach ($header_posts as $post_id) {
			$conditions = get_post_meta($post_id, 'header-condition', true);
			$conditions = json_decode($conditions);
			if ($conditions) {
				foreach ($conditions as $key => $condition) {
					$this->conditions['header'][$post_id][$key] = [
						'include'   => $condition->include === 'include' ? true : false,
						'general'   => $condition->general
					];
					if (!empty($condition->nestedValue)) {
						$this->conditions['header'][$post_id][$key]['nestedValue'] = $condition->nestedValue;
					}
					if (!empty($condition->subIDValue)) {
						$this->conditions['header'][$post_id][$key]['subIDValue'] = $condition->subIDValue;
					}
				}
			}
		}

		/*
		 * Footer
		 */
		$footer_posts = get_posts([
			'post_type' => 'pixfooter',
			'post_status' => 'publish',
			'fields' => 'ids',
			'meta_key' => 'footer-condition',
			'numberposts' => -1
		]);
		foreach ($footer_posts as $post_id) {
			$conditions = get_post_meta($post_id, 'footer-condition', true);
			$conditions = json_decode($conditions);
			if ($conditions) {
				foreach ($conditions as $key => $condition) {
					$this->conditions['footer'][$post_id][$key] = [
						'include'   => $condition->include === 'include' ? true : false,
						'general'   => $condition->general
					];
					if (!empty($condition->nestedValue)) {
						$this->conditions['footer'][$post_id][$key]['nestedValue'] = $condition->nestedValue;
					}
					if (!empty($condition->subIDValue)) {
						$this->conditions['footer'][$post_id][$key]['subIDValue'] = $condition->subIDValue;
					}
				}
			}
		}


		/*
		 * Intro
		 */
		$intro_posts = get_posts([
			'post_type' => 'pixintro',
			'post_status' => 'publish',
			'fields' => 'ids',
			'meta_key' => 'intro-condition',
			'numberposts' => -1
		]);
		foreach ($intro_posts as $post_id) {
			$conditions = get_post_meta($post_id, 'intro-condition', true);
			$conditions = json_decode($conditions);
			if ($conditions) {
				foreach ($conditions as $key => $condition) {
					$this->conditions['intro'][$post_id][$key] = [
						'include'   => $condition->include === 'include' ? true : false,
						'general'   => $condition->general
					];
					if (!empty($condition->nestedValue)) {
						$this->conditions['intro'][$post_id][$key]['nestedValue'] = $condition->nestedValue;
					}
					if (!empty($condition->subIDValue)) {
						$this->conditions['intro'][$post_id][$key]['subIDValue'] = $condition->subIDValue;
					}
				}
			}
		}

		/*
		 * Templates (pixtemplate)
		 */
		$templates_posts = get_posts([
			'post_type' => 'pixfort_template',
			'post_status' => 'publish',
			'fields' => 'ids',
			'meta_key' => 'template-condition',
			'numberposts' => -1
		]);
		foreach ($templates_posts as $post_id) {
			$conditions = get_post_meta($post_id, 'template-condition', true);
			$conditions = json_decode($conditions);
			if ($conditions) {
				foreach ($conditions as $key => $condition) {
					$this->conditions['template'][$post_id][$key] = [
						'include'   => $condition->include === 'include' ? true : false,
						'general'   => $condition->general
					];
					if (!empty($condition->nestedValue)) {
						$this->conditions['template'][$post_id][$key]['nestedValue'] = $condition->nestedValue;
					}
					if (!empty($condition->subIDValue)) {
						$this->conditions['template'][$post_id][$key]['subIDValue'] = $condition->subIDValue;
					}
				}
			}
		}

		update_option(self::OPTION_NAME, $this->conditions);
		return $this;
	}
}
