<?php

if (!defined('ABSPATH')) {
    exit;
}

class styleFunctions {

    public $darkModeEnabled = false;

    function __construct() {
        if (defined('PIXFORT_THEME_SLUG') && PIXFORT_THEME_SLUG !== 'essentials') {
            if (!empty(get_option("pix_options", []) && !empty(get_option("pix_options", [])['pix-enable-dynamic-colors']))) {
                if (get_option("pix_options", [])['pix-enable-dynamic-colors']) {
                    $this->darkModeEnabled = true;
                }
            }
        }
        add_action('wp_head', array($this, 'loadDynamicColors'), 0);
        add_action('wp_enqueue_scripts', array($this, 'loadPageTransition'));
        add_action('wp_head', array($this, 'loadPageTransitionColors'), 0);
        if ($this->darkModeEnabled) {
            add_action('wp_head', array($this, 'loadThemeSwitcher'), 1);
        }
        add_filter('pix_wp_scss_variables', array($this, 'pixThemeScssVars'), 10, 2);
    }

    public function loadPageTransitionColors() {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return false;
        }
        // Get page transition colors for inline CSS
        $pageTransitionColor = '#ffffff';
        $pageTransitionColorDark = '#000000';
        if (!empty(pix_plugin_get_option('site-page-transition-color'))) {
            $pageTransitionColorValue = pix_plugin_get_option('site-page-transition-color');
            if (is_array($pageTransitionColorValue) || is_object($pageTransitionColorValue)) {
                $pageTransitionColorValue = (array) $pageTransitionColorValue;
                if (!empty($pageTransitionColorValue['light'])) {
                    $pageTransitionColor = $pageTransitionColorValue['light'];
                }
                if ($this->darkModeEnabled && !empty($pageTransitionColorValue['dark'])) {
                    $pageTransitionColorDark = $pageTransitionColorValue['dark'];
                }
            } else {
                $pageTransitionColor = $pageTransitionColorValue;
            }
        }
?>
        <style> html { --pix-pagetransition-bg: <?php echo $pageTransitionColor; ?>; } </style>
        <?php
        if ($this->darkModeEnabled) {
            // Get the default theme mode setting
            $defaultThemeMode = pix_plugin_get_option('pix-default-theme-mode');
            if (empty($defaultThemeMode)) {
                $defaultThemeMode = 'light'; // fallback to light if not set
            }
        ?>
            <script>
                (function() {
                    try {
                        let themeToApply = localStorage.getItem('theme');
                        if (!themeToApply) {
                            <?php if ($defaultThemeMode === 'system'): ?>
                                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                    themeToApply = 'Dark';
                                } else {
                                    themeToApply = 'Light';
                                }
                            <?php elseif ($defaultThemeMode === 'dark'): ?>
                                themeToApply = 'Dark';
                            <?php else: ?>
                                themeToApply = 'Light';
                            <?php endif; ?>
                        }
                        if (themeToApply === 'Dark') {
                            document.documentElement.style.setProperty('--pix-pagetransition-bg', '<?php echo $pageTransitionColorDark; ?>');
                            document.documentElement.style.backgroundColor = '<?php echo $pageTransitionColorDark; ?>';
                            document.documentElement.classList.add('pix-dark');
                        } else {
                            document.documentElement.style.setProperty('--pix-pagetransition-bg', '<?php echo $pageTransitionColor; ?>');
                            document.documentElement.style.backgroundColor = '<?php echo $pageTransitionColor; ?>';
                        }
                    } catch (e) {}
                })();
            </script>
        <?php
        }
    }

    public function loadThemeSwitcher() {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return false;
        }

        // Get the default theme mode setting
        $defaultThemeMode = pix_plugin_get_option('pix-default-theme-mode');
        if (empty($defaultThemeMode)) {
            $defaultThemeMode = 'light'; // fallback to light if not set
        }
        ?>
        <script>
            (function() {
                try {
                    let themeToApply = localStorage.getItem('theme');
                    if (!themeToApply) {
                        <?php if ($defaultThemeMode === 'system'): ?>
                            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                themeToApply = 'Dark';
                            } else {
                                themeToApply = 'Light';
                            }
                        <?php elseif ($defaultThemeMode === 'dark'): ?>
                            themeToApply = 'Dark';
                        <?php else: ?>
                            themeToApply = 'Light';
                        <?php endif; ?>
                        localStorage.setItem('theme', themeToApply);
                    }
                    if (themeToApply === 'Dark') {
                        document.documentElement.classList.add('pix-dark');
                        document.addEventListener('DOMContentLoaded', function() {
                            const elementorElement = document.querySelector('.elementor');
                            if (elementorElement) {
                                elementorElement.classList.add('pix-dark');
                            }
                        });
                    } else {
                        document.documentElement.classList.remove('pix-dark');
                        document.addEventListener('DOMContentLoaded', function() {
                            const elementorElement = document.querySelector('.elementor');
                            if (elementorElement) {
                                elementorElement.classList.remove('pix-dark');
                            }
                        });
                    }
                } catch (e) {}
            })();
        </script>
    <?php
    }


    public function loadThemeSwitcherImageSrc() {
    ?>
        <script>
            (function() {
                try {
                    let theme = localStorage.getItem('theme');
                    const isDark = theme === 'Dark';

                    document.documentElement.classList.toggle('pix-dark', isDark);

                    // Function to switch image attributes based on theme
                    function switchThemeImages(themeValue) {
                        // Use current theme if no theme is provided
                        const currentTheme = themeValue || localStorage.getItem('theme');
                        const mode = currentTheme === 'Dark' ? 'dark' : 'light';
                        const images = document.querySelectorAll('[data-light-src][data-dark-src]');

                        images.forEach(img => {
                            // Only update if the data attribute exists
                            if (img.dataset[`${mode}Src`]) {
                                img.src = img.dataset[`${mode}Src`];
                            }

                            if (img.dataset[`${mode}Alt`]) {
                                img.alt = img.dataset[`${mode}Alt`];
                            }
                            if (img.dataset[`${mode}Width`]) {
                                img.width = img.dataset[`${mode}Width`];
                            }
                            if (img.dataset[`${mode}Height`]) {
                                img.height = img.dataset[`${mode}Height`];
                            }
                            if (img.dataset[`${mode}Title`]) {
                                img.title = img.dataset[`${mode}Title`];
                            }
                        });
                    }

                    // Call immediately for initial load
                    switchThemeImages(theme);

                    // Call on DOM ready (for cases where images are loaded dynamically)
                    document.addEventListener('DOMContentLoaded', () => {
                        switchThemeImages();
                    });

                    // Expose function globally for theme toggle button
                    window.switchThemeImages = switchThemeImages;
                } catch (e) {}
            })();
        </script>
<?php
    }


    /**
     * Generate dark mode styling
     */
    public function generateStyling() {
        require_once PIX_CORE_PLUGIN_DIR . '/functions/style/WP_SCSS_Compiler.php';
        $comp = WP_SCSS_Compiler::instance();
        $script_url = $comp->parse_stylesheet(PIX_CORE_PLUGIN_URI . '/includes/assets/dark-mode/main.scss', 'pixfort-dark-mode-style');
        update_option('pix_dark_mode_style_url', $script_url, 'yes');
        $styleID = rand(1, 200000000);
        update_option('pix_dark_mode_style_url_id', $styleID, 'yes');

        // Generate and store custom colors CSS
        $this->generateAndStoreCustomColorsCSS();
    }

    /**
     * Generate custom colors CSS and store it in options
     */
    private function generateAndStoreCustomColorsCSS() {
        $dynamic_css = $this->generate_dynamic_css();

        // Store the generated CSS
        if (!empty($dynamic_css)) {
            update_option('pix_custom_colors_css', $dynamic_css);
        } else {
            // Clear the stored CSS if no dynamic colors exist
            delete_option('pix_custom_colors_css');
        }
    }

    public function pixThemeScssVars($vars, $handle) {
        if ($handle === 'pixfort-dark-mode-style') {
            $dynamicColorOptions = [
                'pix-dynamic-gray-950-dark' => 'pix-dynamic-gray-950',
                'pix-dynamic-gray-900-dark' => 'pix-dynamic-gray-900',
                'pix-dynamic-gray-800-dark' => 'pix-dynamic-gray-800',
                'pix-dynamic-gray-700-dark' => 'pix-dynamic-gray-700',
                'pix-dynamic-gray-600-dark' => 'pix-dynamic-gray-600',
                'pix-dynamic-gray-500-dark' => 'pix-dynamic-gray-500',
                'pix-dynamic-gray-400-dark' => 'pix-dynamic-gray-400',
                'pix-dynamic-gray-300-dark' => 'pix-dynamic-gray-300',
                'pix-dynamic-gray-200-dark' => 'pix-dynamic-gray-200',
                'pix-dynamic-gray-100-dark' => 'pix-dynamic-gray-100',
                'pix-dynamic-gray-50-dark' => 'pix-dynamic-gray-50',
                'pix-dynamic-background-dark' => 'pix-dynamic-background',
                'pix-dynamic-heading-dark' => 'pix-dynamic-heading',
                'link-color' => 'opt-link-color',
            ];
            foreach ($dynamicColorOptions as $color => $option) {
                if (!empty(pix_plugin_get_option($option))) {
                    $varValue = pix_plugin_get_option($option);
                    if (is_array($varValue) || is_object($varValue)) {
                        $varValue = (array) $varValue;
                        if (!empty($varValue['dark'])) {
                            $vars[$color] = $varValue['dark'];
                        }
                    }
                }
            }
        }
        return $vars;
    }

    /**
     * Main function to handle dynamic CSS generation and enqueueing
     */
    public function loadDynamicColors() {
        if ($this->darkModeEnabled) {
            if (get_option('pix_dark_mode_style_url')) {
                wp_enqueue_style('pixfort-dark-mode-style', get_option('pix_dark_mode_style_url'), [], get_option('pix_dark_mode_style_url_id'), 'all');
            }
        }
        // Get the pre-generated custom colors CSS
        $custom_colors_css = get_option('pix_custom_colors_css');

        // Add inline CSS to the dark mode stylesheet if it exists
        if (!empty($custom_colors_css)) {
            wp_register_style('pixfort-dark-mode-inline', false);
            wp_enqueue_style('pixfort-dark-mode-inline');
            wp_add_inline_style('pixfort-dark-mode-inline', $custom_colors_css);
        }
    }

    /**
     * Generate dynamic CSS from pix_options
     */
    private function generate_dynamic_css() {
        $dynamic_colors = get_option('pix_options');
        $dark_mode_enabled = false;
        if (!empty($dynamic_colors['pix-enable-dynamic-colors']) && $dynamic_colors['pix-enable-dynamic-colors']) {
            $dark_mode_enabled = true;
        }

        if (empty($dynamic_colors)) {
            return '';
        }

        $css = '';
        $root_vars = [];
        $dark_vars = [];
        $text_vars = [];

        // Process custom colors for dark mode
        if (!empty($dynamic_colors['pix-custom-colors-items'])) {
            $custom_colors = $dynamic_colors['pix-custom-colors-items'];
            foreach ($custom_colors as $customColor) {
                if (is_array($customColor) || is_object($customColor)) {
                    $color_array = (array) $customColor;

                    // Extract color ID and dark value
                    $colorId = null;
                    $darkValue = null;
                    $lightValue = null;

                    if (isset($color_array['id']) && !empty($color_array['id'])) {
                        $colorId = $color_array['id'];
                    }

                    if (isset($color_array['value']) && !empty($color_array['value'])) {
                        if (isset($color_array['value']->dark) && !empty($color_array['value']->dark)) {
                            $darkValue = $color_array['value']->dark;
                        }
                        if (isset($color_array['value']->light) && !empty($color_array['value']->light)) {
                            $lightValue = $color_array['value']->light;
                        }
                    }

                    if ($colorId) {
                        // Add CSS variable for dark mode if both ID and dark value exist
                        if ($darkValue) {
                            $dark_vars[] = '--e-global-color-pix' . $colorId . ': ' . $darkValue;
                            $dark_vars[] = '--pix-c-' . $colorId . ': ' . $darkValue;
                        }

                        if ($darkValue) {
                            $dark_vars[] = '.btn-c-' . $colorId . ', .btn-line-c-' . $colorId . ', .btn-outline-c-' . $colorId . ', .btn-underline-c-' . $colorId . ', .btn-blink-c-' . $colorId . ' {
                                --pix-btn-color: ' . $this->colorYiqLd($darkValue) . ';
                                --pix-btn-blink-color-hover: ' . $this->colorYiqLd($darkValue) . ';
                            }';
                        }
                        if ($lightValue) {
                            $root_vars[] = '--pix-c-' . $colorId . ': ' . $lightValue;
                        }
                        $text_vars[] = '.text-c-' . $colorId . ' { color: var(--pix-c-' . $colorId . ') !important; }';
                        $text_vars[] = '.bg-c-' . $colorId . ' { --pix-bg-color: var(--pix-c-' . $colorId . '); }';
                        $text_vars[] = '.btn-c-' . $colorId . ', .btn-line-c-' . $colorId . ', .btn-outline-c-' . $colorId . ', .btn-underline-c-' . $colorId . ', .btn-blink-c-' . $colorId . ' {
                            --pix-btn-background: var(--pix-c-' . $colorId . ');
                            --pix-btn-line-color: var(--pix-c-' . $colorId . ');
                            --pix-btn-outline-color: var(--pix-c-' . $colorId . ');
                            --pix-btn-underline-color: var(--pix-c-' . $colorId . ');
                            --pix-btn-blink-color: var(--pix-c-' . $colorId . ');
                            --pix-btn-blink-color-hover: ' . $this->colorYiqLd($lightValue) . ';
                            --pix-btn-color: ' . $this->colorYiqLd($lightValue) . ';
                        }';
                    }
                }
            }
        }
        $dynamicColorOptions = [
            'pixDynamicHeading' => 'pix-dynamic-heading',
            'pixDynamicBackground' => 'pix-dynamic-background',
            'pixDynamicGray50' => 'pix-dynamic-gray-50',
            'pixDynamicGray100' => 'pix-dynamic-gray-100',
            'pixDynamicGray200' => 'pix-dynamic-gray-200',
            'pixDynamicGray300' => 'pix-dynamic-gray-300',
            'pixDynamicGray400' => 'pix-dynamic-gray-400',
            'pixDynamicGray500' => 'pix-dynamic-gray-500',
            'pixDynamicGray600' => 'pix-dynamic-gray-600',
            'pixDynamicGray700' => 'pix-dynamic-gray-700',
            'pixDynamicGray800' => 'pix-dynamic-gray-800',
            'pixDynamicGray900' => 'pix-dynamic-gray-900',
            'pixDynamicGray950' => 'pix-dynamic-gray-950',
        ];
        foreach ($dynamicColorOptions as $color => $option) {
            if (!empty(pix_plugin_get_option($option))) {
                $varValue = pix_plugin_get_option($option);
                if (is_array($varValue) || is_object($varValue)) {
                    $varValue = (array) $varValue;
                    if (!empty($varValue['dark']) && !empty($varValue['light']) && $varValue['dark'] != $varValue['light']) {
                        $dark_vars[] = '--e-global-color-' . $color . ': ' . $varValue['dark'];
                    }
                }
            }
        }

        if (!empty(pix_plugin_get_option('pix-dynamic-blur'))) {
            $varValue = pix_plugin_get_option('pix-dynamic-blur');
            if (is_array($varValue) || is_object($varValue)) {
                $varValue = (array) $varValue;
                if (!empty($varValue['dark']) && !empty($varValue['light']) && $varValue['dark'] != $varValue['light']) {
                    $dark_vars[] = '--pix-dynamic-blur: ' . $varValue['dark'];
                }
                if (!empty($varValue['light'])) {
                    $root_vars[] = '--pix-dynamic-blur: ' . $varValue['light'];
                }
            }
        }


        // Generate CSS for dark mode variables
        if (!empty($dark_vars) && $dark_mode_enabled) {
            $css .= ':root:has(.pix-dark), html.pix-dark, .pix-dark, .pix-dark .elementor {';
            foreach ($dark_vars as $var) {
                $css .= ' ' . $var . ';';
            }
            $css .= '}';
        }

        if (!empty($root_vars)) {
            $css .= ':root {';
            foreach ($root_vars as $var) {
                $css .= ' ' . $var . ';';
            }
            $css .= '}';
        }

        if (!empty($text_vars)) {
            foreach ($text_vars as $var) {
                $css .=  $var;
            }
        }
        return $css;
    }

    /**
     * Update Elementor global colors with custom colors from pix_options
     */
    public function updateElementorGlobalColors() {
        // Ensure Elementor is active/loaded
        if (!did_action('elementor/loaded')) {
            return;
        }

        // Get the Kits Manager from Elementor 
        if (!defined('ELEMENTOR_VERSION') || !class_exists('\Elementor\Plugin') || !method_exists('\Elementor\Plugin', 'instance')) {
            return;
        }

        $pix_options = get_option("pix_options");
        if (empty($pix_options)) {
            return;
        }

        $elementor = \Elementor\Plugin::instance();
        if (!$elementor || !property_exists($elementor, 'kits_manager')) {
            return;
        }

        $kits_manager = $elementor->kits_manager;
        if (!$kits_manager) {
            return;
        }

        // Get the active Kit (Site Settings)
        $kit = $kits_manager->get_active_kit();
        if (!$kit) {
            return;
        }

        // Get existing global colors or default to an empty array
        $custom_colors = $kit->get_settings('custom_colors');
        if (!is_array($custom_colors)) {
            $custom_colors = [];
        }

        // Build array of colors to add/update
        $colors_to_process = [];

        // Add dynamic color options
        $dynamicColorOptions = [
            'pixDynamicGray950' => 'pix-dynamic-gray-950',
            'pixDynamicGray900' => 'pix-dynamic-gray-900',
            'pixDynamicGray800' => 'pix-dynamic-gray-800',
            'pixDynamicGray700' => 'pix-dynamic-gray-700',
            'pixDynamicGray600' => 'pix-dynamic-gray-600',
            'pixDynamicGray500' => 'pix-dynamic-gray-500',
            'pixDynamicGray400' => 'pix-dynamic-gray-400',
            'pixDynamicGray300' => 'pix-dynamic-gray-300',
            'pixDynamicGray200' => 'pix-dynamic-gray-200',
            'pixDynamicGray100' => 'pix-dynamic-gray-100',
            'pixDynamicGray50' => 'pix-dynamic-gray-50',
            'pixDynamicBackground' => 'pix-dynamic-background',
            'pixDynamicHeading' => 'pix-dynamic-heading',
        ];
        $dynamicColorOptionsNames = [
            'pixDynamicGray950' => 'Dynamic Gray 950',
            'pixDynamicGray900' => 'Dynamic Gray 900',
            'pixDynamicGray800' => 'Dynamic Gray 800',
            'pixDynamicGray700' => 'Dynamic Gray 700',
            'pixDynamicGray600' => 'Dynamic Gray 600',
            'pixDynamicGray500' => 'Dynamic Gray 500',
            'pixDynamicGray400' => 'Dynamic Gray 400',
            'pixDynamicGray300' => 'Dynamic Gray 300',
            'pixDynamicGray200' => 'Dynamic Gray 200',
            'pixDynamicGray100' => 'Dynamic Gray 100',
            'pixDynamicGray50' => 'Dynamic Gray 50',
            'pixDynamicBackground' => 'Dynamic Background',
            'pixDynamicHeading' => 'Dynamic Heading',
        ];

        foreach ($dynamicColorOptions as $color => $option) {
            if (!empty(pix_plugin_get_option($option))) {
                $varValue = pix_plugin_get_option($option);
                if (is_array($varValue) || is_object($varValue)) {
                    $varValue = (array) $varValue;
                    if (!empty($varValue['light'])) {
                        $colors_to_process[$color] = [
                            'title' => $dynamicColorOptionsNames[$color],
                            'color' => $varValue['light']
                        ];
                    }
                }
            }
        }

        // Get the old custom colors for comparison
        $old_custom_colors = get_option('pix_latest_custom_colors', []);

        // Custom colors
        $new_custom_colors = isset($pix_options['pix-custom-colors-items']) ? $pix_options['pix-custom-colors-items'] : [];

        // Build list of custom colors to add
        if (!empty($new_custom_colors)) {
            foreach ($new_custom_colors as $customColor) {
                $colorValue = null;
                $colorTitle = null;
                $colorId = null;
                // Handle color data as object/array with light and dark values
                if (is_array($customColor) || is_object($customColor)) {
                    $color_array = (array) $customColor;

                    // Use light value for Elementor global color
                    if (isset($color_array['value']) && !empty($color_array['value'])) {
                        if (isset($color_array['value']->light) && !empty($color_array['value']->light)) {
                            $colorValue = $color_array['value']->light;
                        }
                    }
                    if (isset($color_array['label']) && !empty($color_array['label'])) {
                        $colorTitle = $color_array['label'];
                    }
                    if (isset($color_array['id']) && !empty($color_array['id'])) {
                        $colorId = 'pix' . $color_array['id'];
                    }
                }
                if ($colorValue && $colorId) {
                    $colors_to_process[$colorId] = [
                        'title' => $colorTitle,
                        'color' => $colorValue
                    ];
                }
            }
        }

        // Get IDs to remove (colors that existed before but don't exist now)
        $ids_to_remove = $this->getColorIdsToRemove($old_custom_colors, $new_custom_colors);

        // Process all color operations in one batch
        $updated_colors = $this->batchProcessColors($custom_colors, $colors_to_process, $ids_to_remove);

        // Only save if there were actual changes
        if ($updated_colors !== $custom_colors) {
            // Update the kit's settings
            $kit->set_settings('custom_colors', $updated_colors);

            // Save the updated settings - SINGLE SAVE OPERATION
            $updated_settings = $kit->get_settings();
            $kit->save([
                'settings' => $updated_settings
            ], 'general');
        }

        // Update stored custom colors for next comparison
        if (!empty($new_custom_colors)) {
            update_option('pix_latest_custom_colors', $new_custom_colors);
        }

        // Regenerate custom colors CSS after updating Elementor colors
        $this->generateAndStoreCustomColorsCSS();
    }

    /**
     * Get color IDs that should be removed (exist in old but not in new)
     */
    private function getColorIdsToRemove($old_colors, $new_colors) {
        $old_ids = [];
        $new_ids = [];

        // Extract IDs from old colors
        if (!empty($old_colors)) {
            foreach ($old_colors as $oldColor) {
                if (is_array($oldColor) || is_object($oldColor)) {
                    $color_array = (array) $oldColor;
                    if (isset($color_array['id']) && !empty($color_array['id'])) {
                        $old_ids[] = 'pix' . $color_array['id'];
                    }
                }
            }
        }

        // Extract IDs from new colors
        if (!empty($new_colors)) {
            foreach ($new_colors as $newColor) {
                if (is_array($newColor) || is_object($newColor)) {
                    $color_array = (array) $newColor;
                    if (isset($color_array['id']) && !empty($color_array['id'])) {
                        $new_ids[] = 'pix' . $color_array['id'];
                    }
                }
            }
        }

        // Return IDs that exist in old but not in new (these should be removed)
        return array_diff($old_ids, $new_ids);
    }

    /**
     * Batch process all color operations (add, update, remove) in one go
     */
    private function batchProcessColors($existing_colors, $colors_to_add, $ids_to_remove) {
        $updated_colors = [];

        // First, copy existing colors but skip ones marked for removal and track duplicates
        $processed_ids = [];
        foreach ($existing_colors as $color_item) {
            $color_id = isset($color_item['_id']) ? $color_item['_id'] : null;

            // Skip colors marked for removal
            if ($color_id && in_array($color_id, $ids_to_remove)) {
                continue;
            }

            // Skip duplicate IDs (keep only the first occurrence)
            if ($color_id && in_array($color_id, $processed_ids)) {
                continue;
            }

            if ($color_id) {
                $processed_ids[] = $color_id;
            }

            $updated_colors[] = $color_item;
        }

        // Then add/update colors from the colors_to_add array
        foreach ($colors_to_add as $color_id => $color_data) {
            $new_color_item = [
                '_id'   => $color_id,
                'title' => $color_data['title'],
                'color' => $color_data['color'],
            ];

            // Check if this ID already exists in our updated array
            $found_index = null;
            foreach ($updated_colors as $index => $existing_color) {
                if (isset($existing_color['_id']) && $existing_color['_id'] === $color_id) {
                    $found_index = $index;
                    break;
                }
            }

            if ($found_index !== null) {
                // Update existing
                $updated_colors[$found_index] = array_merge(
                    $updated_colors[$found_index],
                    [
                        'title' => $color_data['title'],
                        'color' => $color_data['color'],
                    ]
                );
            } else {
                // Add new
                $updated_colors[] = $new_color_item;
            }
        }

        return $updated_colors;
    }

    private function colorYiqLd($color, $dark = '#18181B', $light = '#FFFFFF') {
        // Convert color to RGB array
        $rgb = $this->parseColorToRgb($color);
        if (!$rgb) return null;

        // YIQ formula
        $yiq = (($rgb['r'] * 299) + ($rgb['g'] * 587) + ($rgb['b'] * 114)) / 1000;

        // Adjust color brightness
        if ($yiq >= 220) {
            return $this->adjustBrightness($rgb, -0.8); // darken by 80%
        } else {
            return $this->adjustBrightness($rgb, 0.8);  // lighten by 80%
        }
    }

    private function parseColorToRgb($color) {
        if (strpos($color, 'rgba') !== false || strpos($color, 'rgb') !== false) {
            preg_match_all('/\d+\.?\d*/', $color, $matches);
            return ['r' => $matches[0][0], 'g' => $matches[0][1], 'b' => $matches[0][2]];
        }

        $color = ltrim($color, '#');
        if (strlen($color) == 3) {
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        }

        if (strlen($color) != 6) return null;

        return [
            'r' => hexdec(substr($color, 0, 2)),
            'g' => hexdec(substr($color, 2, 2)),
            'b' => hexdec(substr($color, 4, 2))
        ];
    }

    function adjustBrightness($rgb, $percent) {
        $adjusted = array_map(function ($channel) use ($percent) {
            $new = $channel + ($percent * (255 - $channel));
            return max(0, min(255, round($new)));
        }, $rgb);

        return sprintf("#%02X%02X%02X", $adjusted['r'], $adjusted['g'], $adjusted['b']);
    }


    public function loadPageTransition() {
        $pageTransition = 'default';
        if (!empty(pix_plugin_get_option('site-page-transition'))) {
            $pageTransitionVal = pix_plugin_get_option('site-page-transition');
            if ($pageTransitionVal == 'fade-page-transition') {
                $pageTransition = 'fade';
            } elseif ($pageTransitionVal == 'disable-page-transition') {
                $pageTransition = 'disable';
            }
        }
        $introStyle = '
        body:not(.render) .pix-overlay-item {
            opacity: 0 !important;
        }
        body:not(.pix-loaded) .pix-wpml-header-btn {
            opacity: 0;
        }';
        // Page transition background color is now set in loadThemeSwitcher() method
        if ($pageTransition == 'fade') {
            $introStyle .= '
            html:has(body:not(.render)) {
                background: var(--pix-pagetransition-bg)  !important;
            }
            .pix-page-loading-bg:after {
                content: " ";
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                display: block;
                pointer-events: none;
                transition: opacity .16s ease-in-out;
                transform-style: flat;
                z-index: 99999999999999999999;
                opacity: 1;
                background: var(--pix-pagetransition-bg) !important;
            }
            body.render .pix-page-loading-bg:after {
                opacity: 0;
            }
            ';
        } elseif ($pageTransition == 'default') {
            $introStyle .= '
            html:not(.render) {
                background: var(--pix-pagetransition-bg)  !important;
            }
            .pix-page-loading-bg:after {
                content: " ";
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                display: block;
                background: var(--pix-pagetransition-bg) !important;
                pointer-events: none;
                transform-style: flat;
                transform: scaleX(1);
                transition: transform .3s cubic-bezier(.27,.76,.38,.87);
                transform-origin: right center;
                z-index: 99999999999999999999;
            }
            body.render .pix-page-loading-bg:after {
                transform: scaleX(0);
                transform-origin: left center;
            }';
        } elseif ($pageTransition === 'disable') {
            $introStyle = '';
        }


        if (!empty($introStyle)) {
            wp_register_style('pix-intro-handle', false);
            wp_enqueue_style('pix-intro-handle');
            wp_add_inline_style('pix-intro-handle', $introStyle);
        }
    }

    public function getTransformData($settings) {
        $transform_data = false;
        if ($settings['pix_scale_in'] === 'pix-advanced-transform') {
            $start = [];
            $end = [];
            if (!empty($settings['advanced_transform_start_popover']) && $settings['advanced_transform_start_popover'] === 'yes') {
                $start = [
                    'opacity' => isset($settings['pix_transform_start_opacity']['size']) ? $settings['pix_transform_start_opacity']['size'] : 1,
                    'scale' => isset($settings['pix_transform_start_scale']['size']) ? $settings['pix_transform_start_scale']['size'] : 1,
                    'rotateType' => isset($settings['pix_transform_start_rotate_type']) ? $settings['pix_transform_start_rotate_type'] : '2d',
                    'rotate2d' => isset($settings['pix_transform_start_rotate_2d']['size']) ? $settings['pix_transform_start_rotate_2d']['size'] : 0,
                    'rotate3dX' => isset($settings['pix_transform_start_rotate_3d_x']['size']) ? $settings['pix_transform_start_rotate_3d_x']['size'] : 0,
                    'rotate3dY' => isset($settings['pix_transform_start_rotate_3d_y']['size']) ? $settings['pix_transform_start_rotate_3d_y']['size'] : 0,
                    'rotate3dZ' => isset($settings['pix_transform_start_rotate_3d_z']['size']) ? $settings['pix_transform_start_rotate_3d_z']['size'] : 0,
                    'skewX' => isset($settings['pix_transform_start_skew_x']) ? $settings['pix_transform_start_skew_x'] : 0,
                    'skewY' => isset($settings['pix_transform_start_skew_y']) ? $settings['pix_transform_start_skew_y'] : 0,
                    'offsetX' => isset($settings['pix_transform_start_offset_x']) ? $settings['pix_transform_start_offset_x'] : 0,
                    'offsetY' => isset($settings['pix_transform_start_offset_y']) ? $settings['pix_transform_start_offset_y'] : 0,
                ];
            } else if (defined('WPB_VC_VERSION')) {
                if( !empty($settings['pix_transform_start_opacity']) ) {
                    $start['opacity'] = $settings['pix_transform_start_opacity'];
                }
                if( !empty($settings['pix_transform_start_scale']) ) {
                    $start['scale'] = $settings['pix_transform_start_scale'];
                }
                if( !empty($settings['pix_transform_start_rotate_type']) ) {
                    $start['rotateType'] = $settings['pix_transform_start_rotate_type'];
                }
                if( !empty($settings['pix_transform_start_rotate_2d']) ) {
                    $start['rotate2d'] = $settings['pix_transform_start_rotate_2d'];
                }
                if( !empty($settings['pix_transform_start_rotate_3d_x']) ) {
                    $start['rotate3dX'] = $settings['pix_transform_start_rotate_3d_x'];
                }
                if( !empty($settings['pix_transform_start_rotate_3d_y']) ) {
                    $start['rotate3dY'] = $settings['pix_transform_start_rotate_3d_y'];
                }
                if( !empty($settings['pix_transform_start_rotate_3d_z']) ) {
                    $start['rotate3dZ'] = $settings['pix_transform_start_rotate_3d_z'];
                }
                if( !empty($settings['pix_transform_start_skew_x']) ) {
                    $start['skewX'] = $settings['pix_transform_start_skew_x'];
                }
                if( !empty($settings['pix_transform_start_skew_y']) ) {
                    $start['skewY'] = $settings['pix_transform_start_skew_y'];
                }
                if( !empty($settings['pix_transform_start_offset_x']) ) {
                    $start['offsetX'] = $settings['pix_transform_start_offset_x'];
                }
                if( !empty($settings['pix_transform_start_offset_y']) ) {
                    $start['offsetY'] = $settings['pix_transform_start_offset_y'];
                }
                if( !empty($settings['pix_transform_start_rotate_type']) ) {
                    $start['rotateType'] = $settings['pix_transform_start_rotate_type'];
                }
                if( !empty($settings['pix_transform_start_rotate_2d']) ) {
                    $start['rotate2d'] = $settings['pix_transform_start_rotate_2d'];
                }
                if( !empty($settings['pix_transform_start_rotate_3d_x']) ) {
                    $start['rotate3dX'] = $settings['pix_transform_start_rotate_3d_x'];
                }
                if( !empty($settings['pix_transform_start_rotate_3d_y']) ) {
                    $start['rotate3dY'] = $settings['pix_transform_start_rotate_3d_y'];
                }
                if( !empty($settings['pix_transform_start_rotate_3d_z']) ) {
                    $start['rotate3dZ'] = $settings['pix_transform_start_rotate_3d_z'];
                }
                if( !empty($settings['pix_transform_start_skew_x']) ) {
                    $start['skewX'] = $settings['pix_transform_start_skew_x'];
                }
                if( !empty($settings['pix_transform_start_skew_y']) ) {
                    $start['skewY'] = $settings['pix_transform_start_skew_y'];
                }
                if( !empty($settings['pix_transform_start_offset_x']) ) {
                    $start['offsetX'] = $settings['pix_transform_start_offset_x'];
                }
            }
            if (!empty($settings['advanced_transform_end_popover']) && $settings['advanced_transform_end_popover'] === 'yes') {
                $end = [
                    'opacity' => isset($settings['pix_transform_end_opacity']['size']) ? $settings['pix_transform_end_opacity']['size'] : 1,
                    'scale' => isset($settings['pix_transform_end_scale']['size']) ? $settings['pix_transform_end_scale']['size'] : 1,
                    'rotateType' => isset($settings['pix_transform_end_rotate_type']) ? $settings['pix_transform_end_rotate_type'] : '2d',
                    'rotate2d' => isset($settings['pix_transform_end_rotate_2d']['size']) ? $settings['pix_transform_end_rotate_2d']['size'] : 0,
                    'rotate3dX' => isset($settings['pix_transform_end_rotate_3d_x']['size']) ? $settings['pix_transform_end_rotate_3d_x']['size'] : 0,
                    'rotate3dY' => isset($settings['pix_transform_end_rotate_3d_y']['size']) ? $settings['pix_transform_end_rotate_3d_y']['size'] : 0,
                    'rotate3dZ' => isset($settings['pix_transform_end_rotate_3d_z']['size']) ? $settings['pix_transform_end_rotate_3d_z']['size'] : 0,
                    'skewX' => isset($settings['pix_transform_end_skew_x']) ? $settings['pix_transform_end_skew_x'] : 0,
                    'skewY' => isset($settings['pix_transform_end_skew_y']) ? $settings['pix_transform_end_skew_y'] : 0,
                    'offsetX' => isset($settings['pix_transform_end_offset_x']) ? $settings['pix_transform_end_offset_x'] : 0,
                    'offsetY' => isset($settings['pix_transform_end_offset_y']) ? $settings['pix_transform_end_offset_y'] : 0,
                ];
            } else if (defined('WPB_VC_VERSION')) {
                if( !empty($settings['pix_transform_end_opacity']) ) {
                    $end['opacity'] = $settings['pix_transform_end_opacity'];
                }
                if( !empty($settings['pix_transform_end_scale']) ) {
                    $end['scale'] = $settings['pix_transform_end_scale'];
                }
                if( !empty($settings['pix_transform_end_rotate_type']) ) {
                    $end['rotateType'] = $settings['pix_transform_end_rotate_type'];
                }
                if( !empty($settings['pix_transform_end_rotate_2d']) ) {
                    $end['rotate2d'] = $settings['pix_transform_end_rotate_2d'];
                }
                if( !empty($settings['pix_transform_end_rotate_3d_x']) ) {
                    $end['rotate3dX'] = $settings['pix_transform_end_rotate_3d_x'];
                }
                if( !empty($settings['pix_transform_end_rotate_3d_y']) ) {
                    $end['rotate3dY'] = $settings['pix_transform_end_rotate_3d_y'];
                }
                if( !empty($settings['pix_transform_end_rotate_3d_z']) ) {
                    $end['rotate3dZ'] = $settings['pix_transform_end_rotate_3d_z'];
                }
                if( !empty($settings['pix_transform_end_skew_x']) ) {
                    $end['skewX'] = $settings['pix_transform_end_skew_x'];
                }
                if( !empty($settings['pix_transform_end_skew_y']) ) {
                    $end['skewY'] = $settings['pix_transform_end_skew_y'];
                }
                if( !empty($settings['pix_transform_end_offset_x']) ) {
                    $end['offsetX'] = $settings['pix_transform_end_offset_x'];
                }
                if( !empty($settings['pix_transform_end_offset_y']) ) {
                    $end['offsetY'] = $settings['pix_transform_end_offset_y'];
                }
                if( !empty($settings['pix_transform_end_rotate_type']) ) {
                    $end['rotateType'] = $settings['pix_transform_end_rotate_type'];
                }
                if( !empty($settings['pix_transform_end_rotate_2d']) ) {
                    $end['rotate2d'] = $settings['pix_transform_end_rotate_2d'];
                }
                if( !empty($settings['pix_transform_end_rotate_3d_x']) ) {
                    $end['rotate3dX'] = $settings['pix_transform_end_rotate_3d_x'];
                }
                if( !empty($settings['pix_transform_end_rotate_3d_y']) ) {
                    $end['rotate3dY'] = $settings['pix_transform_end_rotate_3d_y'];
                }
                if( !empty($settings['pix_transform_end_rotate_3d_z']) ) {
                    $end['rotate3dZ'] = $settings['pix_transform_end_rotate_3d_z'];
                }
                if( !empty($settings['pix_transform_end_skew_x']) ) {
                    $end['skewX'] = $settings['pix_transform_end_skew_x'];
                }
                if( !empty($settings['pix_transform_end_skew_y']) ) {
                    $end['skewY'] = $settings['pix_transform_end_skew_y'];
                }
                if( !empty($settings['pix_transform_end_offset_x']) ) {
                    $end['offsetX'] = $settings['pix_transform_end_offset_x'];
                }
                if( !empty($settings['pix_transform_end_offset_y']) ) {
                    $end['offsetY'] = $settings['pix_transform_end_offset_y'];
                }
            }
            if(count($start) > 0 || count($end) > 0) {
                $transform_data = [
                    'start' => $start,
                    'end' => $end
                ];
            }
        }
        return $transform_data;
    }
}
