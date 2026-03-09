<?php

namespace ImageOptimization\Modules\Connect\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Config
 */
class Config {
	const APP_NAME = 'image-optimizer';
	const APP_PREFIX = 'image_optimizer';
	const APP_REST_NAMESPACE = 'image-optimizer/v1';
	const PLUGIN_SLUG = 'image-optimization';
	const BASE_URL = 'https://my.elementor.com/connect';
	const ADMIN_PAGE = 'admin.php?page=image-optimization-settings';
	const APP_TYPE = 'app_io';
	const SCOPES = 'openid offline_access';
	const STATE_NONCE = 'image_optimizer_auth_nonce';
	/**
	 * Connect mode
	 * accepts 'site' or 'user'
	 */
	const CONNECT_MODE = 'site';
}
