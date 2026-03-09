<?php

/**
 * The plugin page view - the "settings" page of the plugin.
 *
 * @package ocdi
 */

namespace OCDI;

$predefined_themes = $this->import_files;

if (!empty($this->import_files) && isset($_GET['import-mode']) && 'manual' === $_GET['import-mode']) {
	$predefined_themes = array();
}

?>

<div class="ocdi  wrap  about-wrap">

	<?php ob_start(); ?>
	<h1 class="ocdi__title "><?php esc_html_e('pixfort Demo Import', 'pixfort-core'); ?></h1>
	<?php
	$plugin_title = ob_get_clean();

	// Display the plugin title (can be replaced with custom title text through the filter below).
	echo wp_kses_post(apply_filters('pt-ocdi/plugin_page_title', $plugin_title));

	// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
	if (ini_get('safe_mode')) {
		printf(
			esc_html__('%sWarning: your server is using %sPHP safe mode%s. This means that you might experience server timeout errors.%s', 'pixfort-core'),
			'<div class="notice  notice-warning  is-dismissible"><p>',
			'<strong>',
			'</strong>',
			'</p></div>'
		);
	}

	// Start output buffer for displaying the plugin intro text.
	ob_start();
	?>

	<div class="ocdi__intro-notice  notice  notice-warning  is-dismissible">
		<p><?php esc_html_e('Before you begin, make sure all the required plugins are activated.', 'pixfort-core'); ?></p>
		<p>
			<?php esc_html_e('Note that it\'s recommended to import the demo content into a fresh WordPress installation to prevent an conflicts, if you want to reset you WordPress before importing the demo content you can check ', 'pixfort-core'); ?><a href="<?php echo esc_url(\PixfortCore::instance()->adminCore->getParam('docs_how_to_reset')); ?>" target="_blank">this article</a><?php esc_html_e(' from our knowledge base.', 'pixfort-core'); ?>
		</p>
	</div>

	<?php
	if (class_exists('\Elementor\Plugin')) {
	?>
		<div class="ocdi__intro-notice  notice  pixfort-admin-notice  is-dismissible">
			<div class="notice-text"><?php esc_html_e('It seems that you are using Elementor on your website! Please make sure to follow these steps before importing Elementor demo content.', 'pixfort-core'); ?></div>
			<a href="<?php echo esc_url(\PixfortCore::instance()->adminCore->getParam('docs_import_elementor_demo')); ?>" target="_blank" class="button button-primary">Check the article on our knowledge base</a>
		</div>
	<?php
	}
	?>

	<div class="ocdi__intro-text">
		<p class="about-description">
			<?php esc_html_e('Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme.', 'pixfort-core'); ?>
			<?php esc_html_e('It will allow you to quickly edit everything instead of creating content from scratch.', 'pixfort-core'); ?>
		</p>

		<hr>

		<p><?php esc_html_e('When you import the data, the following things might happen:', 'pixfort-core'); ?></p>

		<ul>
			<li><?php esc_html_e('No existing posts, pages, categories, images, custom post types will be deleted or modified.', 'pixfort-core'); ?></li>
			<li><?php esc_html_e('When choosing to import Theme Options, the current Theme Options values will be overridden with the imported options.', 'pixfort-core'); ?></li>
			<li><?php esc_html_e('Posts, pages, images, widgets, menus and other theme settings will get imported.', 'pixfort-core'); ?></li>
			<li><?php esc_html_e('Please click on the Import button only once and wait, it can take a couple of minutes.', 'pixfort-core'); ?></li>
		</ul>

		<?php if (!empty($this->import_files)) : ?>
			<?php if (empty($_GET['import-mode']) || 'manual' !== $_GET['import-mode']) : ?>
				<a href="<?php echo esc_url(add_query_arg(array('page' => $this->plugin_page_setup['menu_slug'], 'import-mode' => 'manual'), menu_page_url($this->plugin_page_setup['parent_slug'], false))); ?>" class="ocdi__import-mode-switch"><?php esc_html_e('Switch to manual import!', 'pixfort-core'); ?></a>
			<?php else : ?>
				<a href="<?php echo esc_url(add_query_arg(array('page' => $this->plugin_page_setup['menu_slug']), menu_page_url($this->plugin_page_setup['parent_slug'], false))); ?>" class="ocdi__import-mode-switch"><?php esc_html_e('Switch back to theme predefined imports!', 'pixfort-core'); ?></a>
			<?php endif; ?>
		<?php endif; ?>

		<hr>
	</div>

	<?php
	$plugin_intro_text = ob_get_clean();

	// Display the plugin intro text (can be replaced with custom text through the filter below).
	echo wp_kses_post(apply_filters('pt-ocdi/plugin_intro_text', $plugin_intro_text));
	?>

	<?php if (empty($this->import_files)) : ?>
		<div class="notice  notice-info  is-dismissible">
			<p><?php esc_html_e('There are no predefined import files available in this theme. Please upload the import files manually!', 'pixfort-core'); ?></p>
		</div>
	<?php endif; ?>

	<?php if (empty($predefined_themes)) : ?>

		<div class="ocdi__file-upload-container">
			<h2><?php esc_html_e('Manual demo files upload', 'pixfort-core'); ?></h2>

			<div class="ocdi__file-upload">
				<h3><label for="content-file-upload"><?php esc_html_e('Choose a XML file for content import:', 'pixfort-core'); ?></label></h3>
				<input id="ocdi__content-file-upload" type="file" name="content-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="widget-file-upload"><?php esc_html_e('Choose a WIE or JSON file for widget import:', 'pixfort-core'); ?></label></h3>
				<input id="ocdi__widget-file-upload" type="file" name="widget-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="customizer-file-upload"><?php esc_html_e('Choose a DAT file for customizer import:', 'pixfort-core'); ?></label></h3>
				<input id="ocdi__customizer-file-upload" type="file" name="customizer-file-upload">
			</div>


			<div class="ocdi__file-upload">
				<h3><label for="redux-file-upload"><?php esc_html_e('Choose a JSON file for Theme Options import:', 'pixfort-core'); ?></label></h3>
				<input id="ocdi__redux-file-upload" type="file" name="redux-file-upload">
				<div>

					<input id="ocdi__redux-option-name" type="hidden" value="pix_options" name="redux-option-name">
				</div>
			</div>

		</div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e('Import Demo Data', 'pixfort-core'); ?></button>
		</p>

	<?php elseif (1 === count($predefined_themes)) : ?>

		<div class="ocdi__demo-import-notice  js-ocdi-demo-import-notice"><?php
																			if (is_array($predefined_themes) && !empty($predefined_themes[0]['import_notice'])) {
																				echo wp_kses_post($predefined_themes[0]['import_notice']);
																			}
																			?></div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e('Import Demo Data', 'pixfort-core'); ?></button>
		</p>

	<?php else : ?>

		<!-- OCDI grid layout -->
		<div class="ocdi__gl  js-ocdi-gl">
			<?php
			// Prepare navigation data.
			$categories = Helpers::get_all_demo_import_categories($predefined_themes);
			?>
			<?php if (!empty($categories)) : ?>
				<div class="ocdi__gl-header  js-ocdi-gl-header">
					<nav class="ocdi__gl-navigation">
						<ul>
							<li class="active"><a href="#all" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php esc_html_e('All', 'pixfort-core'); ?></a></li>
							<?php foreach ($categories as $key => $name) : ?>
								<li><a href="#<?php echo esc_attr($key); ?>" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php echo esc_html($name); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<div clas="ocdi__gl-search">
						<input type="search" class="ocdi__gl-search-input  js-ocdi-gl-search" name="ocdi-gl-search" value="" placeholder="<?php esc_html_e('Search demos...', 'pixfort-core'); ?>">
					</div>
				</div>
			<?php endif; ?>
			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container">
				<?php foreach ($predefined_themes as $index => $import_file) : ?>
					<?php
					// Prepare import item display data.
					$img_src = isset($import_file['import_preview_image_url']) ? $import_file['import_preview_image_url'] : '';
					// Default to the theme screenshot, if a custom preview image is not defined.
					if (empty($img_src)) {
						$theme = wp_get_theme();
						$img_src = $theme->get_screenshot();
					}

					?>
					<div class="ocdi__gl-item js-ocdi-gl-item" data-categories="<?php echo esc_attr(Helpers::get_demo_import_item_categories($import_file)); ?>" data-name="<?php echo esc_attr(strtolower($import_file['import_file_name'])); ?>">
						<div class="ocdi__gl-item-image-container">
							<?php if (!empty($img_src)) : ?>
								<img class="ocdi__gl-item-image" src="<?php echo esc_url($img_src) ?>">
							<?php else : ?>
								<div class="ocdi__gl-item-image  ocdi__gl-item-image--no-image"><?php esc_html_e('No preview image.', 'pixfort-core'); ?></div>
							<?php endif; ?>
						</div>
						<div class="ocdi__gl-item-footer<?php echo !empty($import_file['preview_url']) ? '  ocdi__gl-item-footer--with-preview' : ''; ?>">
							<h4 class="ocdi__gl-item-title" title="<?php echo esc_attr($import_file['import_file_name']); ?>"><?php echo esc_html($import_file['import_file_name']); ?></h4>
							<button class="ocdi__gl-item-button  button  button-primary  js-ocdi-gl-import-data" value="<?php echo esc_attr($index); ?>"><?php esc_html_e('Import', 'pixfort-core'); ?></button>
							<?php if (!empty($import_file['preview_url'])) : ?>
								<a class="ocdi__gl-item-button  button" href="<?php echo esc_url($import_file['preview_url']); ?>" target="_blank"><?php esc_html_e('Preview', 'pixfort-core'); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div id="js-ocdi-modal-content"></div>

	<?php endif; ?>

	<p class="ocdi__ajax-loader  js-ocdi-ajax-loader">
		<span class="spinner"></span> <?php esc_html_e('Importing, please wait!', 'pixfort-core'); ?>
	</p>

	<div class="ocdi__response  js-ocdi-ajax-response"></div>
</div>