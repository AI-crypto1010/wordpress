<?php

class PixfortThemeUpdater {

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $api_url;

    /**
     * @var string
     */
    public $cache_key;

    /**
     * @var boolean
     */
    public $cache_allowed;

    public function __construct($id, $slug, $version, $api_url) {
        $this->id     = $id;
        $this->slug   = $slug;
        $this->version       = $version;
        $this->api_url       = $api_url;
        $this->cache_key     = str_replace('-', '_', $this->slug) . '_updater';
        $this->cache_allowed = true; 
        // update_option('pix_item_update_fail', '');
        if (!get_option('pix_item_update_fail')) {
            add_filter('themes_api', array($this, 'info'), 20, 3);
            add_filter('site_transient_update_themes', array($this, 'update'));
            add_action('upgrader_process_complete', array($this, 'purge'), 10, 2);
            if (defined('PIXFORT_DEV')) {
                add_filter( 'http_request_args', function ( $args ) {
                    $args['reject_unsafe_urls'] = false;
                    return $args;
                }, 999 );
            }
        }
    }

    /**
     * Fetch the update info from the remote server.
     *
     * @return object|bool
     */
    public function request() {
        $remote = get_transient($this->cache_key);
        if (false !== $remote && $this->cache_allowed) {
            if ('error' === $remote) {
                return false;
            }
            return json_decode( $remote );
        }
        // delete_transient('pix_updated_request');
        // delete_transient($this->cache_key);
        if(!get_transient('pix_updated_request')){
            set_transient('pix_updated_request', true, 10);
            $getArgs = [];
            $getArgs['headers'] = [
                'timeout' => 10,
            ];

            $key = get_option('envato_purchase_code_27889640');
            if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG) {
                if(PIXFORT_THEME_SLUG == 'conseil') {
                    $key = get_option('envato_purchase_code_61457003');
                }
            }
            if (defined('IS_PIXFORT_THEME')) {
                $key = get_option('pixfort_license_key');
            }
            $params = [
                'domain' => site_url(),
                'purchase_key' => $key,
                'item' => $this->id,
                'current_version' => $this->version
            ];
            $url = $this->api_url . "/updates/info";
            $url_with_param = add_query_arg($params, $url);
            $remote = wp_remote_get(
                $url_with_param,
                $getArgs
            );
            if (
                is_wp_error($remote)
                || 200 !== wp_remote_retrieve_response_code($remote)
                || empty(wp_remote_retrieve_body($remote))
            ) {
                $url = "https://hub.pixfort.net/updates/info";
                $url_with_param = add_query_arg($params, $url);
                $remote = wp_remote_get(
                    $url_with_param,
                    $getArgs
                );

                if (
                    is_wp_error($remote)
                    || 200 !== wp_remote_retrieve_response_code($remote)
                    || empty(wp_remote_retrieve_body($remote))
                ) {
                    set_transient($this->cache_key, 'error', MINUTE_IN_SECONDS * 30);
                    return false;
                }
            }

            $payload = wp_remote_retrieve_body($remote);
            
            $remote = json_decode($payload);
            if ($remote && !empty($remote->success) && $remote->success) {
                set_transient($this->cache_key, $payload, WEEK_IN_SECONDS );
            } else {
                set_transient($this->cache_key, $payload, DAY_IN_SECONDS);
            }
            if ($remote && !empty($remote->fail)) {
                update_option('pix_item_update_fail', true);
                return false;
            } elseif ($remote && !empty($remote->noupdates)) {
                set_transient('pix_updated_request', true, MONTH_IN_SECONDS);
            }
            return $remote;
        } else {
            if (false !== $remote) {
                if ('error' === $remote) {
                    return false;
                }
                return json_decode( $remote );
            }
        }
        return false;
    }

    /**
     * Override the WordPress request to return the correct theme info.
     *
     * @see https://developer.wordpress.org/reference/hooks/themes_api/
     *
     * @param false|object|array $result
     * @param string $action
     * @param object $args
     * @return object|bool
     */
    public function info($result, $action, $args) {
        if ('theme_information' !== $action) {
            return false;
        }

        if ($this->slug !== $args->slug) {
            return false;
        }

        $remote = $this->request();
        if (!$remote || !$remote->success || empty($remote->update)) {
            return false;
        }

        // $plugin_data = get_plugin_data(__FILE__);

        $result       = $remote->update;
        // $result->name = $plugin_data['Name'];
        // $result->slug = $this->plugin_slug;
        // $result->sections = (array) $result->sections;

        return $result;
    }

    /**
     * Override the WordPress request to check if an update is available.
     *
     * @see https://make.wordpress.org/core/2020/07/30/recommended-usage-of-the-updates-api-to-support-the-auto-updates-ui-for-plugins-and-themes-in-wordpress-5-5/
     *
     * @param object $transient
     * @return object
     */
    public function update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
        // $res = (object) array(
        // 	'id'            => $this->id,
        // 	'slug'          => $this->slug,
        // 	'plugin'        => $this->id,
        // 	'new_version'   => $this->version,
        // 	'url'           => '',
        // 	'package'       => '',
        // 	'tested'        => '',
        // 	'requires_php'  => '',
        // );
        
        $res = []; // Ensure this matches the expected object type
        $res['name'] = 'Essentials';
        $res['version'] = $this->version;
        $res['author'] = 'pixfort';

        $res['theme'] = $this->id; // The theme's slug
        $res['url'] = \PixfortCore::instance()->adminCore->getParam('changelog_link');


        $remote = $this->request();
        if (
            $remote && !empty($remote->success) && $remote->success && !empty($remote->update)
            && version_compare($this->version, $remote->update->version, '<')
        ) {
            if (!empty($remote->update->download_link)) {
                $res['new_version'] = $remote->update->version;
                $res['package']     = $remote->update->download_link;
            }
            if (!empty($remote->update->url)) {
                $res['url']     = $remote->update->url;
            }
            $transient->response[$this->id] = $res;
        } else {
            $transient->no_update[$this->id] = $res;
        }
    
        return $transient;
    }

    /**
     * When the update is complete, purge the cache.
     *
     * @see https://developer.wordpress.org/reference/hooks/upgrader_process_complete/
     *
     * @param WP_Upgrader $upgrader
     * @param array $options
     * @return void
     */
    public function purge($upgrader, $options) {
        if (
            $this->cache_allowed
            && 'update' === $options['action']
            && 'theme' === $options['type']
            && !empty($options['themes'])
        ) {
            foreach ($options['themes'] as $item) {
                if ($item === $this->id) {
                    delete_transient($this->cache_key);
                }
            }
        }
    }
}
