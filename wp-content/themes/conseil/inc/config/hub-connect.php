<?php

class PixfortHub {
    public $hub_url;
    public static $item_name = 'conseil';
    public static $item_id = '61457003';

    public function __construct() {

        $this->hub_url = 'https://hub.pixfort.com/';

        add_action('wp_ajax_pix_theme_verify', array($this, 'pix_theme_verify'));
        add_action('wp_ajax_nopriv_pix_theme_verify', array($this, 'pix_theme_verify'));

        add_action('wp_ajax_pix_deactivate_theme', array($this, 'pix_deactivate_theme'));
        add_action('wp_ajax_nopriv_pix_deactivate_theme', array($this, 'pix_deactivate_theme'));

        add_action('wp_ajax_pix_finish_dashboard', array($this, 'pix_finish_dashboard'));
        add_action('wp_ajax_nopriv_pix_finish_dashboard', array($this, 'pix_finish_dashboard'));

        add_action('rest_api_init', function () {
            register_rest_route('pixfort', 'verification', array(
                'methods'  => 'POST',
                'callback' => 'pix_theme_verify',
                'permission_callback' => '__return_true',
            ));
            register_rest_route('pixfort', 'verification', array(
                'methods'  => 'GET',
                'callback' => 'pix_theme_verify',
                'permission_callback' => '__return_true',
            ));
        });
    }

    public function getVerifyUrl() {
        return $this->hub_url . 'theme-verification/start';
    }
    public function getFinalVerifyUrl() {
        return $this->hub_url . 'theme-verification/verify';
    }
    public function getDeactuvateUrl() {
        return $this->hub_url . 'theme-verification/deactivate';
    }
    public function getUpdateUrl() {
        return $this->hub_url . 'theme-verification/update';
    }
    public static function getverifyAction() {
        return esc_url(home_url('wp-json/pixfort/theme-verification'));
        return esc_url_raw(rest_url('pixfort/theme-verification'));
    }

    public function disableActivation() {
        $opt_key = 'envato_purchase_code_' . self::$item_id;
        update_option($opt_key, '');
        update_option('pixfort_key', '');
    }

    public static function getCsrfToken() {
        return false;
    }

    public function getVerifyNonce() {
        return wp_create_nonce('wp_rest');
    }

    public function theme_activate($envato_key, $pixfort_key) {
        $opt_key = 'envato_purchase_code_' . self::$item_id;
        update_option($opt_key, $envato_key);
        update_option('pixfort_key', $pixfort_key);
        update_option('pix_license_update_fail', '');
        delete_option('envato_purchase_code_27889640');
    }

    function pix_theme_verify($key) {
        $result = [];
        $res['result'] = false;
        $res['message'] = '';
        if (!$this->checkValidation()) {
            $url = $this->getFinalVerifyUrl();
            $url .= '?pixfort_key=' . rawurlencode($key);
            $url .= '&domain=' . site_url();
            $validation = wp_remote_get($url);
            if (is_wp_error($validation)) {
                $validation = wp_remote_get($url, array('sslverify' => false));
            }
            if (is_wp_error($validation)) {
                echo '<div class="notice pixfort-notice notice-error is-dismissible">
                     <p><strong>Error:</strong>The server is unable to connect with the external websites.</p>
                     <p>We recommend to contact your hosting provider to check and solve the connection issue:
                        <ul>
                        <li>Ask your host if there is some limitation with wp-cron, or if loopback is disabled.</li>
                        <li>Ask your host if there a firewall or security modules (e.g. mod_security ) that could block the outgoing cURL requests.</li>
                        </ul>
                    </p>
                    </div>';
            } else {
                if (!empty($validation['body'])) {
                    $res = $validation['body'];
                    $data = json_decode($res, true);
                    if (!empty($data['purchase_key']) && strlen($data['purchase_key']) > 2) {
                        $this->theme_activate($data['purchase_key'], rawurldecode(urlencode($key)));
                        $result['result'] = true;
                    }
                    if (!empty($data['message'])) {
                        $result['message'] = $data['message'];
                    }
                }
            }
        }
        return $result;
    }

    function checkLicenseUpdate($m = false) {
        if ($this->checkValidation()) {
            $pixfortKey = get_option('pixfort_key');
            if (substr($pixfortKey, 0, 5) !== "rtxc9" || $m || (!strpos($pixfortKey, '//') && !defined('PIX_DEV'))) {
                if (!get_option('pix_license_update_fail') || $m) {
                    $opt_key = 'envato_purchase_code_' . self::$item_id;
                    $code = get_option($opt_key);
                    $url = $this->getUpdateUrl();
                    $url .= '?purchase_key=' . $code;
                    $url .= '&domain=' . site_url();
                    $url .= '&version=2';
                    $update = wp_remote_get($url, array('sslverify' => false));
                    if (is_wp_error($update)) {
                        // show update fail warning
                    } else {
                        if (!empty($update['body'])) {
                            $res = $update['body'];
                            $data = json_decode($res, true);
                            if (!empty($data['result']) && $data['result']) {
                                if (!empty($data['pixfort_key']) && strlen($data['pixfort_key']) > 2) {
                                    update_option('pixfort_key', rawurldecode($data['pixfort_key']));
                                }
                            } else {
                                update_option('pix_license_update_fail', true);
                            }
                        }
                    }
                }
            }
        }
    }

    public static function checkValidation() {
        $opt_key = 'envato_purchase_code_' . self::$item_id;
        $code = get_option($opt_key);
        if ($code) {
            return true;
        }
        return false;
    }

    function pix_finish_dashboard() {
        $dashboard_options = get_option('pixfort_dashboard_options');
        if ($dashboard_options) {
            $dashboard_options['is-start'] = false;
        } else {
            $dashboard_options = array(
                'is-start' => false,
                'step'     => 1
            );
        }
        update_option('pixfort_dashboard_options', $dashboard_options);
        return true;
    }

    function pix_deactivate_theme() {
        $opt_key = 'envato_purchase_code_' . self::$item_id;
        if (!empty($_REQUEST['um'])) {
            $this->checkLicenseUpdate(true);
        }
        if (!empty($_REQUEST['fd']) && !empty($_REQUEST['pk'])) {
            $pk = $_REQUEST['pk'];
            $code = get_option($opt_key);
            if ($pk === $code) {
                update_option($opt_key, '');
                update_option('pixfort_key', '');
                update_option('pix_license_update_fail', '');
            }
        }
        if (!empty($_REQUEST['up'])) {
            update_option('pix_item_update_fail', '');
        }
        if (!empty($_REQUEST['pk'])) {
            $pk = $_REQUEST['pk'];
            if ($this->checkValidation()) {
                $code = get_option($opt_key);
                if ($pk === $code) {
                    $pixfortKey = get_option('pixfort_key');
                    $url = $this->getDeactuvateUrl();
                    $url .= '?purchase_key=' . $code;
                    $url .= '&pixfort_key=' . $pixfortKey;
                    $url .= '&domain=' . site_url();
                    $deactivation = wp_remote_get($url, array('sslverify' => false));
                    if (is_wp_error($deactivation)) {
                        // $validation = wp_remote_get($url, array('sslverify' => false));
                        var_dump($deactivation);
                    }
                    if (!empty($deactivation['body'])) {
                        $res = $deactivation['body'];
                        $data = json_decode($res, true);
                        if (!empty($data['result']) && $data['result']) {
                            update_option($opt_key, '');
                            update_option('pixfort_key', '');
                            update_option('pix_license_update_fail', '');
                            $data = array(
                                'is-start' => true,
                                'step'     => 1
                            );
                            update_option('pixfort_dashboard_wizard', $data);
                            $result = array(
                                'result'    => true,
                                'message'    => 'The theme has been deactivated successfully!'
                            );
                            echo json_encode($result);
                            wp_die();
                        }
                    }
                    $result = array(
                        'result'    => false,
                        'code'    => $code,
                        'pixfortKey'    => $pixfortKey,
                        'site_url'    => site_url(),
                        'message'    => 'Error 1, couldn\'t deactivate the theme!'
                    );
                    echo json_encode($result);
                    wp_die();
                }
            }
        }

        $result = array(
            'result'    => false,
            'message'    => 'Error 2, couldn\'t deactivate the theme!'
        );
        echo json_encode($result);
        wp_die();
    }
}
if (is_user_logged_in() || (defined('DOING_AJAX') && DOING_AJAX)) {
    $pixfortHub = new PixfortHub();
}
