<div class="wrap">
  <img src="https://collect.chat/assets/images/ccdark.png" style="margin-bottom: 10px;" height="50"/>
  <div>
  <a class="add-new-h2" target="_blank" href="<?php echo esc_url("https://help.collect.chat/article/show/56885-add-to-wordpress"); ?>"><?php _e('Read Instructions', 'collectchat'); ?></a>
  <a class="add-new-h2" target="_blank" href="<?php echo esc_url("https://www.youtube.com/watch?v=JhcqBT0W6VQ"); ?>"><?php _e('Watch Tutorial', 'collectchat'); ?></a>
  </div>

  <hr />
  <div id="poststuff">
  <div id="post-body" class="metabox-holder columns-2">
    <div id="post-body-content">
      <div class="postbox">
        <div class="inside">
          <form name="dofollow" action="options.php" method="post">

            <?php
            settings_fields('collectchat-settings-group');
            $settings = get_option('collectchat-plugin-settings');
            $script = (array_key_exists('script', $settings) ? $settings['script'] : '');
            $showOn = (array_key_exists('showOn', $settings) ? $settings['showOn'] : 'all');
            $allowed_html = array(
                'script' => array(),
            );
            ?>
            <div id="collectchat-instructions">
            <h3 class="cc-labels"><?php _e('3 Easy to steps to get started: ', 'collectchat'); ?></h3>
            <?php
            $userEmail = '';
            if (wp_get_current_user() instanceof WP_User) $userEmail = wp_get_current_user()->user_email;
            ?>
            <p><b>1.</b> <?php _e('If you are not an existing Collect.chat user<a href="https://dashboard.collect.chat/getstarted?user=' . $userEmail . '&source=wordpress" target="_blank" class="button button-primary" style="margin: auto 15px; background-color: #208a46; border-color: #208a46; text-shadow: none; box-shadow: none;">Create a free account</a>', 'collectchat'); ?></p>

            <p><b>2.</b> <?php _e('Design your Chatbot using <a href="https://dashboard.collect.chat/" target="_blank">Drag & Drop Dashboard</a>', 'collectchat'); ?></p>

            <p><b>3.</b> <?php _e('Copy the code snippet from Dashboard > Share and paste it here', 'collectchat'); ?></p>
            </div>
            <h3 class="cc-labels" for="script"><?php _e('Chatbot Snippet:', 'collectchat'); ?></h3>

            <textarea id="collectchat-plugin-snippet" style="width:100%;" rows="5" cols="50" id="script" name="collectchat-plugin-settings[script]" <?php disabled(!current_user_can( 'unfiltered_html') ); ?>><?php echo wp_kses($script, $allowed_html); ?></textarea>

            <?php
            if(!current_user_can( 'unfiltered_html' )) {
              echo '<p style="color:#ffc107"><b>Note:</b> ' . __('You do not have permission to add or edit scripts. Please contact your administrator.', 'collectchat') . '</p>';
            }
            ?>

            <p>
              <h3>Show Above Chatbot On: </h3>
              <input type="radio" name="collectchat-plugin-settings[showOn]" value="all" id="all" <?php checked('all', $showOn); ?> <?php disabled(!current_user_can( 'unfiltered_html') ); ?>> <label class="collectchat-plugin-label" for="all"><?php _e('Everywhere', 'collectchat'); ?> </label> 
              <input type="radio" name="collectchat-plugin-settings[showOn]" value="home" id="home" <?php checked('home', $showOn); ?> <?php disabled(!current_user_can( 'unfiltered_html') ); ?>> <label class="collectchat-plugin-label" for="home"><?php _e('Homepage Only', 'collectchat'); ?> </label> 
              <input type="radio" name="collectchat-plugin-settings[showOn]" value="nothome" id="nothome" <?php checked('nothome', $showOn); ?> <?php disabled(!current_user_can( 'unfiltered_html') ); ?>> <label class="collectchat-plugin-label" for="nothome"><?php _e('Everywhere except Home', 'collectchat'); ?> </label>
              <input type="radio" name="collectchat-plugin-settings[showOn]" value="none" id="none" <?php checked('none', $showOn); ?> <?php disabled(!current_user_can( 'unfiltered_html') ); ?>> <label class="collectchat-plugin-label" for="none"><?php _e('Nowhere', 'collectchat'); ?> </label>
            </p>

            <p class="submit">
              <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save', 'collectchat'); ?>"  style="padding: 0px 30px;font-size:15px;background-color: #2c6ac3;border-color: #2c6ac3;" <?php disabled(!current_user_can( 'unfiltered_html') ); ?>/>
            </p>
            <p><?php _e('<b>Note:</b> You can insert different bots to specific pages or posts from respective edit sections. <a href="https://help.collect.chat/article/show/76319-in-wordpress-how-can-i-add-a-different-chatbot-for-a-different-page" target="_blank">Learn more</a>', 'collectchat'); ?></p>

          </form>
        </div>
    </div>
    </div>

    <?php require_once (CC_PLUGIN_DIR . '/sidebar.php'); ?>
    </div>
  </div>
</div>


<style>
  .collectchat-plugin-label {
    vertical-align: initial;
    margin-right: 5px;
  }
</style>
<script>
  const snippetValue = document.getElementById("collectchat-plugin-snippet") && document.getElementById("collectchat-plugin-snippet").value
  console.log('hi',<?php wp_get_current_user() ?>);
  if(snippetValue.indexOf('<script') !== -1) {
    document.getElementById("collectchat-instructions").style.display = "none";
  }
</script>
