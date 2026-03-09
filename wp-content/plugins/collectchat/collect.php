<?php
/**
 * Plugin Name: Collect.chat - Chatbot
 * Version: 2.4.9
 * Plugin URI: https://collect.chat
 * Description: Chatbots are the simplest, easiest way to collect leads & data from visitors. Create free chatbot without coding using Collect.chat. Never miss an opportunity by engaging every site visitor.
 * Author: Collect.chat Inc.
 * Author URI: https://collect.chat
 * License: GPLv3
 */

// exit if accessed directly
if (!defined('ABSPATH'))
{
    exit;
}

define('CC_PLUGIN_DIR', str_replace('\\', '/', dirname(__FILE__)));

if (!class_exists('ScriptLoader'))
{

    class ScriptLoader
    {


        function __construct()
        {
            // Add text domain loading
            add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));

            add_action('admin_init', array(&$this,
                'admin_init'
			));
			
            add_action('admin_menu', array(&$this,
                'admin_menu'
			));
			
            add_action('wp_head', array(&$this,
                'wp_head'
			));
			
            add_action('plugins_loaded', array(&$this,
                'register_embed'
            ));

            $plugin = plugin_basename(__FILE__);
            add_filter("plugin_action_links_$plugin", array(&$this,
                'collectchat_settings_link'
            ));

			// Toaster if not configured
            add_action('admin_notices', array($this, 'collectchat_settings_message'));
			
			
			// Activation page auto redirect
			add_action( 'activated_plugin', array(&$this,
			'collectchat_activation_redirect'
            ));
            

            // Message to rate the plugin
            add_action('admin_notices', array($this, 'collectchat_rating_request'));
            add_action('admin_init', array($this, 'collectchat_ignore_notice'));

			// Deactivation feedback
			require_once dirname( __FILE__ ) . '/deactivation-feedback/register.php';
            collectchat_feedback_include_init( plugin_basename( __FILE__ ) );

			// Register oEmbed providers
			wp_oembed_add_provider('https://links.collect.chat/*', 'https://dashboard.collect.chat/forms-embed');

        }

        // Add new method to load text domain
        public function load_plugin_textdomain() {
            load_plugin_textdomain(
                'collectchat',
                false,
                dirname(plugin_basename(__FILE__)) . '/languages/'
            );
        }

        function register_embed()
        {
            //Register shortcode
            add_shortcode('collect-chat', array(&$this,
                'embed_bot'
            ));
        }

        //[collect-chat] oembed
        function embed_bot($atts)
        {
            if (isset($atts['id']))
            {
                if (!isset($atts['height']))
                {
                    $atts['height'] = "500";
                }
                $id = preg_replace("/[^a-zA-Z0-9]+/", "", $atts["id"]);
                $height = preg_replace("/[^a-zA-Z0-9]+/", "", $atts["height"]);

                return '<iframe src="https://links.collect.chat/' .  $id . '" width="100%" height="' . $height . '" frameBorder="0" allowfullscreen></iframe>';
            }
            else
            {
                return 'Please enter a valid Collect.chat bot id';
            }
		
		}


        function collectchat_activation_redirect($plugin)
        {
			if( $plugin == plugin_basename( __FILE__ ) ) {
				exit(wp_redirect(admin_url('admin.php?page=collectchat')));
			}
        }

        function collectchat_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=collectchat">' . __('Settings', 'collectchat') . '</a>';
            $support_link = '<a href="https://help.collect.chat" target="_blank">' . __('Support', 'collectchat') . '</a>';

            array_push($links, $settings_link);
            array_push($links, $support_link);

            return $links;
        }

        function collectchat_settings_message()
        {
            $settings = get_option('collectchat-plugin-settings');
            $postmeta_query_args = array(
                'post_type'        => 'post',
                'meta_key'         => '_inpost_head_script',
            );
            $postmeta_query = new WP_Query( $postmeta_query_args );
            if (!(isset($settings) && !empty($settings['script'])) && !$postmeta_query->have_posts() && !(isset($_GET['page']) && $_GET['page'] == 'collectchat'))
            {
		?>
			<div class="notice notice-error" style="display: flex;">
					<a href="https://collect.chat" class="logo" style="margin: auto;"><img src="https://collect.chat/assets/images/logo-black.png" width="60px" height="60px"  alt="Collect.chat"/></a>
					<div style="flex-grow: 1; margin: 15px 15px;">
						<h4 style="margin: 0;"><?php _e('Add chatbot snippet to continue', 'collectchat'); ?></h4>
						<p><?php _e('Oops!😓 It appears that your Collect.chat chatbot is not configured correctly.', 'collectchat'); ?></p>
					</div>
					    <a href="https://dashboard.collect.chat/getstarted?user=<?php echo esc_attr(wp_get_current_user()->user_email); ?>&source=wordpress" target="_blank" class="button button-primary" style="margin: auto 15px; background-color: #208a46; border-color: #208a46; text-shadow: none; box-shadow: none;"><?php _e('Create a free account', 'collectchat'); ?></a>
					    <a href="admin.php?page=collectchat" class="button button-primary" style="margin: auto 15px; background-color: #f16334; border-color: #f16334; text-shadow: none; box-shadow: none;"><?php _e('Add the bot snippet', 'collectchat'); ?></a>
            </div>
		<?php
            }
        }

        // Add admin notice to rate the plugin
        function collectchat_rating_request(){
            $settings = get_option('collectchat-plugin-settings');
            if(!empty($settings['installedOn'])){
                $ignore_rating = empty($settings['ignore_rating']) ? "" : $settings['ignore_rating'];
                if($ignore_rating != "yes"){
                    $date1 = $settings['installedOn'];
                    $date2 = date("Y/m/d");
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $days = floor($diff / (60*60*24));
                    if($days >= 7){
                        $cc_new_URI = $_SERVER['REQUEST_URI'];
                        $cc_new_URI = add_query_arg('collectchat-ignore-notice', '0', $cc_new_URI);
                        echo '<div class="notice notice-success">';
                        echo '<div style="display:flex;"><a href="https://collect.chat" class="logo" style="margin: auto;"><img src="https://collectcdn.com/assets/heart.gif" width="60px" height="60px"  alt="Collect.chat"/></a>';
                        printf(__('<div style="flex-grow:1;margin: 15px;"><h4 style="margin: 0;">Awesome! You have been using <a href="admin.php?page=collectchat">Collect.chat</a> chatbot plugin for more than 1 week 😎</h4>
                        <p>Would you mind taking a few seconds to give it a 5-star rating on WordPress?<br/>Thank you in advance :)</p></div></div>'));
                        printf(__('<a href="%2$s" class="button button-primary" style="margin-bottom: 10px; background-color: #208a46; border-color: #208a46;" target="_blank">Ok, you deserved it</a>
                        <a class="button button-primary" style="margin-bottom: 10px;" href="%1$s">I already did</a>
                        <a class="button button-error" style="margin-bottom: 10px;" href="%1$s">No, not good enough</a>', 'advanced-database-cleaner'), $cc_new_URI,
                        'https://wordpress.org/support/plugin/collectchat/reviews/?filter=5');
                        echo "</div>";
                    }
                }
            }
        }
        
        function collectchat_ignore_notice(){
            if(isset($_GET['collectchat-ignore-notice']) && $_GET['collectchat-ignore-notice'] == "0"){
                $settings = get_option('collectchat-plugin-settings');
                $settings['ignore_rating'] = "yes";
                update_option('collectchat-plugin-settings', $settings, "no");
            }
        }

        function collectchat_html_sanitize($input) {
            $allowed_html = array(
                'script' => array(),
            );
            
            if (current_user_can('unfiltered_html')) {
                $input['script'] = wp_kses($input['script'], $allowed_html); // Script sanitization for users with the unfiltered_html capability
            } else {
                $input['script'] = wp_kses_post($input['script']); // Sanitize all content for other users
            }
            return $input;
        }


        function admin_init()
        {

            // register settings for sitewide script
            register_setting('collectchat-settings-group', 'collectchat-plugin-settings', array( 'sanitize_callback' => array( $this, 'collectchat_html_sanitize') ));

            add_settings_field('script', 'Script', 'trim', 'collectchat');
            add_settings_field('showOn', 'Show On', 'trim', 'collectchat');
            add_settings_field('installedOn', 'Show On', 'trim', 'collectchat');

            // default value for settings
            $initialSettings = get_option('collectchat-plugin-settings');
            if ($initialSettings === false)
            {
                $initialSettings['showOn'] = 'all';
                $initialSettings['installedOn'] = date("Y/m/d");
                update_option('collectchat-plugin-settings', $initialSettings);
            } 
            if($initialSettings === true && !$initialSettings['showOn']) {
                $initialSettings['showOn'] = 'all';
                update_option('collectchat-plugin-settings', $initialSettings);
            } 
            if($initialSettings === true && !$initialSettings['installedOn']) {
                $initialSettings['installedOn'] = date("Y/m/d");
                update_option('collectchat-plugin-settings', $initialSettings);
            }
            
            // add meta box to all post types
            add_meta_box('cc_all_post_meta', esc_html__('Collect.chat Snippet:', 'collectchat-settings') , 'collectchat_meta_setup', array(
                'post',
                'page'
            ) , 'normal', 'default');

			add_action('save_post', 'collectchat_post_meta_save');
			
 
			
        }

        // adds menu item to wordpress admin dashboard
        function admin_menu()
        {
            add_menu_page(__('Collect.chat', 'collectchat-settings') , __('Collect.chat', 'collectchat-settings') , 'manage_options', 'collectchat', array(&$this,
                'collectchat_options_panel'
            ) , 'data:image/svg+xml;base64,PHN2ZyBpZD0ic3ZnIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIiB2aWV3Qm94PSIwLCAwLCA0MDAsNDAwIj48ZyBpZD0ic3ZnZyI+PHBhdGggaWQ9InBhdGgwIiBkPSJNMTkxLjM1OCA2NC45MjYgQyAxMTEuNjcyIDcwLjg0OSw1My41MTkgMTQzLjgwNCw2NS4zNTIgMjIzLjAwNiBDIDY3LjY4MiAyMzguNTk5LDc0LjI5MyAyNTcuMzc3LDgyLjA5OCAyNzAuNTcyIEwgODIuOTMzIDI3MS45ODMgNzkuMTQ5IDI4Ni4yMzkgQyA3Ny4wNjggMjk0LjA3OSw3NC41MjQgMzAzLjY3MCw3My40OTYgMzA3LjU1MSBDIDcyLjQ2NyAzMTEuNDMzLDcwLjE0MCAzMjAuMTk4LDY4LjMyMyAzMjcuMDI5IEwgNjUuMDIxIDMzOS40NTAgMTM0LjM0NSAzMzkuNTM1IEMgMjA2LjM3OCAzMzkuNjIzLDIwOS4wMTAgMzM5LjU4OSwyMTguMjA3IDMzOC40MzggQyAyNzkuODcyIDMzMC43MjUsMzI5LjExMyAyODIuMTIwLDMzNy4yOTYgMjIwLjg4OSBDIDMzOC4zNDYgMjEzLjAzMCwzMzguNTQwIDIwOS45NzIsMzM4LjUyNSAyMDEuNTUzIEMgMzM4LjM4MiAxMjIuNjA5LDI2OS45NTcgNTkuMDg1LDE5MS4zNTggNjQuOTI2IE0yNjUuNDA2IDIxNC4xMTQgQyAyNjQuNTE0IDI0My45MjcsMjQxLjU5MSAyNzAuMjcxLDIxMS43NTMgMjc1Ljc3NCBDIDE3NS42MjkgMjgyLjQzNiwxNDAuOTE1IDI1Ny44NDgsMTM1LjA2MyAyMjEuNDU0IEMgMTM0LjYxNiAyMTguNjc5LDEzNC4xMTAgMjExLjUwMywxMzQuMzQ0IDIxMS4yNjkgQyAxMzQuNDEwIDIxMS4yMDMsMTYzLjk0NSAyMTEuMTgxLDE5OS45NzcgMjExLjIyMCBMIDI2NS40OTAgMjExLjI5MSAyNjUuNDA2IDIxNC4xMTQgIiBzdHJva2U9Im5vbmUiIGZpbGw9IiNhNGE0YWMiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PC9wYXRoPjxwYXRoIGlkPSJwYXRoMSIgZD0iTTMzOC41NzYgMjAxLjY5NCBDIDMzOC41NzYgMjA0LjE3OCwzMzguNjE5IDIwNS4xNTYsMzM4LjY3MiAyMDMuODY4IEMgMzM4LjcyNCAyMDIuNTgwLDMzOC43MjQgMjAwLjU0NywzMzguNjcxIDE5OS4zNTEgQyAzMzguNjE4IDE5OC4xNTYsMzM4LjU3NSAxOTkuMjEwLDMzOC41NzYgMjAxLjY5NCAiIHN0cm9rZT0ibm9uZSIgZmlsbD0iIzljYTRhNCIgZmlsbC1ydWxlPSJldmVub2RkIj48L3BhdGg+PHBhdGggaWQ9InBhdGgyIiBkPSIiIHN0cm9rZT0ibm9uZSIgZmlsbD0iI2E0YTRiMCIgZmlsbC1ydWxlPSJldmVub2RkIj48L3BhdGg+PHBhdGggaWQ9InBhdGgzIiBkPSIiIHN0cm9rZT0ibm9uZSIgZmlsbD0iI2E0YTRiMCIgZmlsbC1ydWxlPSJldmVub2RkIj48L3BhdGg+PHBhdGggaWQ9InBhdGg0IiBkPSIiIHN0cm9rZT0ibm9uZSIgZmlsbD0iI2E0YTRiMCIgZmlsbC1ydWxlPSJldmVub2RkIj48L3BhdGg+PC9nPjwvc3ZnPg==');

        }

        function wp_head()
        {

            $settings = get_option('collectchat-plugin-settings');
            $allowed_html = array(
                'script' => array(),
            );

            if (is_array($settings) && array_key_exists('script', $settings))
            {
                $script = $settings['script'];
                $showOn = $settings['showOn'];

                // main bot
                if ($script != '')
                {
                    if (($showOn === 'all') || ($showOn === 'home' && (is_home() || is_front_page())) || ($showOn === 'nothome' && !is_home() && !is_front_page()) || !$showOn === 'none')
                    {
                        echo wp_kses($script, $allowed_html), wp_kses('<script type="text/javascript">var CollectChatWordpress = true;</script>', $allowed_html), "\n";
                    }
                }
            }

            // post and page bots
            $cc_post_meta = get_post_meta(get_the_ID() , '_inpost_head_script', true);
            if ($cc_post_meta != '' && !is_home() && !is_front_page())
            {
          
                echo wp_kses($cc_post_meta['synth_header_script'], $allowed_html), wp_kses('<script type="text/javascript">var CollectChatWordpress = true;</script>', $allowed_html), "\n";
                
            }

        }

        function collectchat_options_panel()
        {
            // Load options page
            require_once (CC_PLUGIN_DIR . '/options.php');
        }
    }

    function collectchat_meta_setup()
    {
        global $post;

        // using an underscore, prevents the meta variable
        // from showing up in the custom fields section
        $meta = get_post_meta($post->ID, '_inpost_head_script', true);

        // instead of writing HTML here, lets do an include
        include_once (CC_PLUGIN_DIR . '/meta.php');

        // create a custom nonce for submit verification later
        echo '<input type="hidden" name="cc_post_meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
    }

    function collectchat_post_meta_save($post_id)
    {

        // make sure data came from our meta box
        if (!isset($_POST['cc_post_meta_noncename']) || !wp_verify_nonce($_POST['cc_post_meta_noncename'], __FILE__)) return $post_id;

        // check user permissions
        if ($_POST['post_type'] == 'page')
        {
            if (!current_user_can('edit_page', $post_id)) return $post_id;

        }
        else
        {

            if (!current_user_can('edit_post', $post_id)) return $post_id;

        }

        // only users with unfiltered_html capability can save scripts
        if (!current_user_can('unfiltered_html')) return $post_id;

        $current_data = get_post_meta($post_id, '_inpost_head_script', true);

        $new_data = $_POST['_inpost_head_script'];

        collectchat_post_meta_clean($new_data);

        if ($current_data)
        {

            if (is_null($new_data)) delete_post_meta($post_id, '_inpost_head_script');

            else update_post_meta($post_id, '_inpost_head_script', $new_data);

        }
        elseif (!is_null($new_data))
        {

            add_post_meta($post_id, '_inpost_head_script', $new_data, true);

        }

        return $post_id;
    }

    function collectchat_post_meta_clean(&$arr)
    {

        $allowed_html = array(
            'script' => array(),
        );

        if (is_array($arr))
        {

            foreach ($arr as $i => $v)
            {

                if (is_array($arr[$i]))
                {
                    collectchat_post_meta_clean($arr[$i]);

                    if (!count($arr[$i]))
                    {
                        unset($arr[$i]);
                    }

                }
                else
                {



                    if (trim($arr[$i]) == '')
                    {
                        unset($arr[$i]);
                    } else {
                        if (current_user_can('unfiltered_html')) {
                            $arr[$i] = wp_kses($v, $allowed_html);
                        } else {
                            $arr[$i] = wp_kses_post($v);
                        }
                    }
                }
            }

            if (!count($arr))
            {
                $arr = NULL;
            }
        }
    }

    $scripts = new ScriptLoader();

}
?>