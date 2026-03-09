<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PixfortIcons {

    /**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 */
	// public static $instance = null;

    public static $isEnabled = true;
    public $mappingList = false;
    public $mappingListDuo = false;
    public $solidList = false;

    function __construct() {
        $this->init();
    }

    // public static function instance() {
		// if ( is_null( self::$instance ) ) {
		// 	self::$instance = new self();
        //     self::$instance->init();
		// }

		// return self::$instance;
	// }

    public function init() {
        if (!$this->checkIsEnabled()) {
            self::$isEnabled = false;
            return;
        }
        add_action('wp_ajax_pix_icons_data', array($this, 'getIconsData'));
    }

    public function getIconsData(){
        check_ajax_referer('pix_icons_data', 'nonce');
        require PIX_CORE_PLUGIN_DIR . '/includes/icons/pixfort-icons-list.php';
        require dirname( __FILE__ ) . '/pixfort-icons-social-list.php';
		$svgList = [];
		$svgDuoList = [];
		$svgSolidList = [];
		foreach ($pixfortIconsList as $icon) {
            $iconName = 'pixfort-icon-'.$icon;
			$content = pixGetFileContents( '/includes/icons/assets/svg/Line/' . $iconName . '.svg');
			if (!empty($content)) {
				array_push($svgList, ['name' => $iconName, 'icon' => $content]);
			}
			$content2 = pixGetFileContents( '/includes/icons/assets/svg/Duotone/' . $iconName . '.svg');
			if (!empty($content2)) {
				array_push($svgDuoList, ['name' => $iconName, 'icon' => $content2]);
			}
            // All SOLID ICONS
            $content3 = pixGetFileContents( '/includes/icons/assets/svg/Solid/' . $iconName . '.svg');
			if (!empty($content3)) {
				array_push($svgSolidList, ['name' => $iconName, 'icon' => $content3]);
			}
		}
		// foreach ($pixfortSocialIconsList as $icon) {
		// 	$content = pixGetFileContents( '/includes/icons/assets/svg/Solid/' . $icon . '.svg');
		// 	if (!empty($content)) {
		// 		array_push($svgSolidList, ['name' => $icon, 'icon' => $content]);
		// 	}
		// }
		require PIX_CORE_PLUGIN_DIR . '/includes/icons/mapping-duotone.php';
		require PIX_CORE_PLUGIN_DIR . '/includes/icons/mapping.php';
        // Clear any previous output and buffers
        while (ob_get_level()) {
            ob_end_clean();
        }

        $response = [
            'LINE_ICONS' => $svgList,
            'DUO_ICONS' => $svgDuoList,
            'SOLID_ICONS' => $svgSolidList,
            'SOLID_ICONS_LIST' => $pixfortSocialIconsList,
            'MappingDuo' => $pix_icons_list,
            'MappingFonticons' => $pixfort_icons
        ];
        
        // Ensure no headers have been sent
        if (!headers_sent()) {
            // Set appropriate headers for JSON response
            header('Content-Type: application/json');
            
            

            $jsonData = json_encode($response);
            
            // Try compression only if content is larger than 1KB
            if (strlen($jsonData) > 1024) {
                $encoded = false;
                
                // Try gzip first if available
                if (function_exists('gzencode') && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
                    $compressed = gzencode($jsonData, 9);
                    if ($compressed !== false) {
                        header('Content-Encoding: gzip');
                        echo $compressed;
                        $encoded = true;
                    }
                }
                
                // If gzip failed, try deflate
                if (!$encoded && function_exists('gzdeflate') && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') !== false) {
                    $compressed = gzdeflate($jsonData, 9);
                    if ($compressed !== false) {
                        header('Content-Encoding: deflate');
                        echo $compressed;
                        $encoded = true;
                    }
                }
                
                // If both compression methods failed, send uncompressed
                if (!$encoded) {
                    echo $jsonData;
                }
            } else {
                // Small content, send uncompressed
                echo $jsonData;
            }
        } else {
            // Headers already sent, send uncompressed
            echo json_encode($response);
        }
        wp_die();
    }

    public static function isEnabled(){
        return self::$isEnabled;
    }

    function checkIsEnabled(){
        $enabled = true;
        // $options = get_option("pix_options");
        // return !(isset($options['pix-disable-pixfort-icons']) && $options['pix-disable-pixfort-icons']);
        $pix_disable_icons = get_option("pix_disable_icons");
        if (isset($pix_disable_icons)&&$pix_disable_icons) {
            $enabled = false;
        }
        // Use "update_option('pix_disable_icons', '');" to disable pixfort icons
        return $enabled;
    }

    function verifyIconName($icon, $forceNew = false) {
        if(self::$isEnabled || $forceNew) {
            if(!is_string($icon)) return $icon;
            if(strpos($icon, '/') === false){
                if(!str_contains($icon, 'pixicon')){
                    // TODO: verify social solid icons mapping
                    if(!$this->mappingListDuo){
                        require dirname( __FILE__ ) . '/mapping-duotone.php';
                        $this->mappingListDuo = $pix_icons_list;
                    }
                    if(!empty($this->mappingListDuo[$icon])){
                        $icon = 'Duotone/'.$this->mappingListDuo[$icon];
                    }
                } else {
                    if(!$this->mappingList){
                        require dirname( __FILE__ ) . '/mapping.php';
                        $this->mappingList = $pixfort_icons;
                    }
                    if(!$this->solidList){
                        require dirname( __FILE__ ) . '/pixfort-icons-social-list.php';
                        $this->solidList = $pixfortSocialIconsList;
                    }
                    if(!empty($this->mappingList[$icon])){
                        if(in_array($this->mappingList[$icon], $this->solidList)){
                            $icon = 'Solid/'.$this->mappingList[$icon];
                        } else {
                            $icon = 'Line/'.$this->mappingList[$icon];
                        }
                    }
                }
            }
        } else {
            if(strpos($icon, '/') !== false){
                if(str_contains($icon, 'Line/')){
                    $iconID = str_replace("Line/","",$icon);
                    if(!$this->mappingList){
                        require dirname( __FILE__ ) . '/mapping.php';
                        $this->mappingList = $pixfort_icons;
                    }
                    $invertedFonticon = array_flip($this->mappingList);
                    if(!empty($invertedFonticon[$iconID])){
                        $icon = $invertedFonticon[$iconID];
                    }
                } elseif(str_contains($icon, 'Solid/')){
                    $iconID = str_replace("Solid/","",$icon);
                    if(!$this->mappingList){
                        require dirname( __FILE__ ) . '/mapping.php';
                        $this->mappingList = $pixfort_icons;
                    }
                    $invertedFonticon = array_flip($this->mappingList);
                    if(!empty($invertedFonticon[$iconID])){
                        $icon = $invertedFonticon[$iconID];
                    }
                } elseif(str_contains($icon, 'Duotone/')){
                    $iconID = str_replace("Duotone/","",$icon);
                    if(!$this->mappingListDuo){
                        require dirname( __FILE__ ) . '/mapping-duotone.php';
                        $this->mappingListDuo = $pix_icons_list;
                    }
                    $invertedDuo = array_flip($this->mappingListDuo);
                    if(!empty($invertedDuo[$iconID])){
                        $icon = $invertedDuo[$iconID];
                    }
                }
            }
        }
        return $icon;
    }

    function getIcon( $filename, $size = 24, $classes = '', $attrs = '', $forceNew = false ) {
        $size = intval($size);
        if(!empty($filename)){
            $filename = $this->verifyIconName($filename, $forceNew);
            if(strpos($filename, '/') === false){
                if(!str_contains($filename, 'pixicon')){
                    if(!$this->mappingListDuo){
                        require dirname( __FILE__ ) . '/mapping-duotone.php';
                        $this->mappingListDuo = $pix_icons_list;
                    }
                    if(!empty($this->mappingListDuo[$filename])){
                        $path =  '/includes/icons/assets/svg/Duotone/' . $this->mappingListDuo[$filename] . '.svg';
                        return loadSvgContentWithCache($path, $classes, $size, $attrs, 'Duotone/' . $filename);
                    }
                }else{
                    if(!$this->mappingList){
                        require dirname( __FILE__ ) . '/mapping.php';
                        $this->mappingList = $pixfort_icons; 
                    }
                    if(!empty($this->mappingList[$filename])){
                        // $content = pixGetFileContents(PIX_CORE_PLUGIN_DIR . '/includes/icons/assets/svg/Line/'.$this->mappingList[$filename].'.svg');
                        // if(!empty($content)){
                        //     return '<svg class="pixfort-icon '.$classes.'" width="'.$size.'" height="'.$size.'" '.$attrs.' data-name="Line/'.$filename.'" viewBox="2 2 20 20">'.$content.'</svg>';
                        // }
                        $path =  '/includes/icons/assets/svg/Line/' . $this->mappingList[$filename] . '.svg';
                        return loadSvgContentWithCache($path, $classes, $size, $attrs, 'Line/' . $filename);
                    }
                }
            }else{
                // $cacheKey = 'pix_'.$filename;
                // $content = get_transient($cacheKey);
                // if ($content === false) {
                //     $content = pixGetFileContents( '/includes/icons/assets/svg/'.$filename.'.svg');
                //     set_transient($cacheKey, $content, HOUR_IN_SECONDS);
                // } 
                // if(!empty($content)){
                //     return '<svg class="pixfort-icon '.$classes.'" width="'.$size.'" height="'.$size.'" '.$attrs.' data-name="'.$filename.'" viewBox="2 2 20 20">'.$content.'</svg>';
                // }
                $path =  '/includes/icons/assets/svg/' . $filename . '.svg';
                return $this->loadSvgContentWithCache($path, $classes, $size, $attrs, $filename);

            }
        }
        return '<i class="'.$filename.' '.$classes.'"></i>';
    }

    // Helper function to load SVG content and return SVG markup
    function loadSvgContentWithCache($path, $classes, $size, $attrs, $filename) {
        // $cacheKey = 'pix_'.$filename;
        // $content = get_transient($cacheKey);
        // if ($content === false) {
        //     $content = pixGetFileContents($path);
        //     set_transient($cacheKey, $content, HOUR_IN_SECONDS);
        // }
        $content = pixGetFileContents($path);
        if (!empty($content)) {
            return '<svg class="pixfort-icon ' . esc_attr($classes) . '" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" ' . $attrs . ' data-name="' . esc_attr($filename) . '" viewBox="2 2 20 20">' . $content . '</svg>';
        }
        return '';
    }

    function verifyElementorData($data, $repeater = false, $repeaterKey = '', $typeKey = 'media_type') {
        if(self::$isEnabled) {
            if(!empty($data['settings'])){
                if($repeater) {
                    if($typeKey==='pix-comparison-table') {
                        if (!empty($data['settings'][$repeaterKey])) {
                            foreach ($data['settings'][$repeaterKey] as $key => $item) {
                                

                                    // Col 1
                                    if (isset($item['col_1_media_type']) && $item['col_1_media_type'] === 'duo_icon') {
                                        if (!empty($item['col_1_pix_duo_icon'])) {
                                            $DuoValue = $item['col_1_pix_duo_icon'];
                                            $data['settings'][$repeaterKey][$key]['col_1_icon'] = $this->verifyIconName($DuoValue);
                                            $data['settings'][$repeaterKey][$key]['col_1_media_type'] = 'icon';	
                                            $data['settings'][$repeaterKey][$key]['col_1_pix_duo_icon'] = '';
                                        }
                                    }
                                    // Col 2
                                    if (isset($item['col_2_media_type']) && $item['col_2_media_type'] === 'duo_icon') {
                                        if (!empty($item['col_2_pix_duo_icon'])) {
                                            $DuoValue = $item['col_2_pix_duo_icon'];
                                            $data['settings'][$repeaterKey][$key]['col_2_icon'] = $this->verifyIconName($DuoValue);
                                            $data['settings'][$repeaterKey][$key]['col_2_media_type'] = 'icon';	
                                            $data['settings'][$repeaterKey][$key]['col_2_pix_duo_icon'] = '';
                                        }
                                    }
                                    // Col 3
                                    if (isset($item['col_3_media_type']) && $item['col_3_media_type'] === 'duo_icon') {
                                        if (!empty($item['col_3_pix_duo_icon'])) {
                                            $DuoValue = $item['col_3_pix_duo_icon'];
                                            $data['settings'][$repeaterKey][$key]['col_3_icon'] = $this->verifyIconName($DuoValue);
                                            $data['settings'][$repeaterKey][$key]['col_3_media_type'] = 'icon';	
                                            $data['settings'][$repeaterKey][$key]['col_3_pix_duo_icon'] = '';
                                        }
                                    }
                                
                            }
                            
                        }
                    } else {
                        if (!empty($data['settings'][$repeaterKey])) {
                            foreach ($data['settings'][$repeaterKey] as $key => $item) {
                                if (!empty($item[$typeKey])) {
                                    if ($item[$typeKey] === 'duo_icon') {
                                        if (!empty($item['pix_duo_icon'])) {
                                            $DuoValue = $item['pix_duo_icon'];
                                            $data['settings'][$repeaterKey][$key]['icon'] = $this->verifyIconName($DuoValue);
                                            $data['settings'][$repeaterKey][$key][$typeKey] = 'icon';	
                                            $data['settings'][$repeaterKey][$key]['pix_duo_icon'] = '';
                                        }
                                    }
                                }
                            }
                            
                        }
                    }
                } else {
                    // if($data["widgetType"]==='pix-feature'){
                    //     print_r($data);
                    // }
                    if(!empty($data['settings']['media_type'])){
                        if($data['settings']['media_type']==='duo_icon'){
                            if(!empty($data['settings']['pix_duo_icon'])) {
                                $DuoValue = $data['settings']['pix_duo_icon'];
                                $data['settings']['icon'] = $this->verifyIconName($DuoValue);
                                $data['settings']['media_type'] = 'icon';
                                $data['settings']['pix_duo_icon'] = '';
                                if(in_array($data["widgetType"], ['pix-feature', 'pix-icon'])){
                                    if(!empty($data['settings']['icon_size'])&&$data['settings']['icon_size']!==''){
                                        if(!isset($data['settings']['has_icon_bg'])||empty($data['settings']['has_icon_bg'])||$data['settings']['has_icon_bg']!=='yes'){
                                            $data['settings']['icon_size'] = (int) $data['settings']['icon_size'] * 1.8;
                                        }
                                        if($data["widgetType"] === 'pix-icon'){
                                            $data['settings']['icon_size'] = round((int) $data['settings']['icon_size'] * 0.75);
                                        }
                                        if($data["widgetType"] === 'pix-feature'){
                                            $data['settings']['icon_size'] = round((int) $data['settings']['icon_size'] * 0.85);
                                        }
                                    }
                                    
                                    if(isset($data['settings']['icon_position']) && $data['settings']['icon_position'] === 'left'){
                                        // check if padding_title contains "px" string, then get its (int) valur and add 2 to it, then save the value with 'px' at the end in padding_title
                                        if(isset($data['settings']['padding_title']) && strpos($data['settings']['padding_title'], 'px') !== false){
                                            $padding_title = (int) $data['settings']['padding_title'];
                                            if($padding_title >=3) $padding_title -= 3;
                                            $data['settings']['padding_title'] = $padding_title . 'px';
                                        }
                                    }
                                }
                            }
                        } elseif($data['settings']['media_type']==='icon'){
                            if($data["widgetType"] === 'pix-icon'){
                                if(!empty($data['settings']['icon'])){
                                    if(strpos($data['settings']['icon'], '/') === false){
                                        if(empty($data['settings']['has_icon_bg']) || $data['settings']['has_icon_bg'] === ''){
                                            $data['settings']['has_icon_bg'] = 'yes';
                                            $data['settings']['icon_bg_color'] = 'transparent';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
		} else {
            if(!empty($data['settings'])){
                if($repeater) {
                    if($typeKey==='pix-comparison-table') {
                        if (!empty($data['settings'][$repeaterKey])) {
                            foreach ($data['settings'][$repeaterKey] as $key => $item) {
                                // Col 1
                                if (!empty($item['col_1_media_type']) && $item['col_1_media_type'] === 'icon') {
                                    if (!empty($item['col_1_icon'])) {
                                        if(str_contains($item['col_1_icon'], 'Duotone/')){
                                            $data['settings'][$repeaterKey][$key]['col_1_media_type'] = 'duo_icon';
                                            $data['settings'][$repeaterKey][$key]['col_1_pix_duo_icon'] = $this->verifyIconName($item['col_1_icon']);
                                        } else {
                                            $data['settings'][$repeaterKey][$key]['col_1_icon'] = $this->verifyIconName($item['col_1_icon']);
                                        }
                                    }
                                }
                                // Col 2
                                if (!empty($item['col_2_media_type']) && $item['col_2_media_type'] === 'icon') {
                                    if (!empty($item['col_2_icon'])) {
                                        if(str_contains($item['col_2_icon'], 'Duotone/')){
                                            $data['settings'][$repeaterKey][$key]['col_2_media_type'] = 'duo_icon';
                                            $data['settings'][$repeaterKey][$key]['col_2_pix_duo_icon'] = $this->verifyIconName($item['col_2_icon']);
                                        } else {
                                            $data['settings'][$repeaterKey][$key]['col_2_icon'] = $this->verifyIconName($item['col_2_icon']);
                                        }
                                    }
                                }
                                // Col 3
                                if (!empty($item['col_3_media_type']) && $item['col_3_media_type'] === 'icon') {
                                    if (!empty($item['col_3_icon'])) {
                                        if(str_contains($item['col_3_icon'], 'Duotone/')){
                                            $data['settings'][$repeaterKey][$key]['col_3_media_type'] = 'duo_icon';
                                            $data['settings'][$repeaterKey][$key]['col_3_pix_duo_icon'] = $this->verifyIconName($item['col_3_icon']);
                                        } else {
                                            $data['settings'][$repeaterKey][$key]['col_3_icon'] = $this->verifyIconName($item['col_3_icon']);
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if (!empty($data['settings'][$repeaterKey])) {
                            foreach ($data['settings'][$repeaterKey] as $key => $item) {
                                if (!empty($item[$typeKey])) {
                                    if ($item[$typeKey] === 'icon') {
                                        if(!empty($item['icon'])){
                                            if(str_contains($item['icon'], 'Duotone/')){
                                                $data['settings'][$repeaterKey][$key][$typeKey] = 'duo_icon';
                                                $data['settings'][$repeaterKey][$key]['pix_duo_icon'] = $this->verifyIconName($item['icon']);
                                            } else {
                                                $data['settings'][$repeaterKey][$key]['icon'] = $this->verifyIconName($item['icon']);
                                            }
                                        }
                                    }
                                }
                            }
                            
                        }
                    }
                } else {
                    if(!empty($data['settings']['media_type'])){
                        if($data['settings']['media_type']==='icon'){
                            if(!empty($data['settings']['icon'])){
                                if(str_contains($data['settings']['icon'], 'Duotone/')){
                                    $data['settings']['media_type'] = 'duo_icon';
                                    $data['settings']['pix_duo_icon'] = $this->verifyIconName($data['settings']['icon']);
                                    if(in_array($data["widgetType"], ['pix-feature', 'pix-icon'])){
                                        if(!empty($data['settings']['icon_size'])&&$data['settings']['icon_size']!==''){
                                            if(!isset($data['settings']['has_icon_bg'])||empty($data['settings']['has_icon_bg'])||$data['settings']['has_icon_bg']!=='yes'){
                                                $data['settings']['icon_size'] = (int) $data['settings']['icon_size'] / 1.8;
                                            }
                                            if($data["widgetType"] === 'pix-icon'){
                                                $data['settings']['icon_size'] = round((int) $data['settings']['icon_size'] / 0.75);
                                            }
                                            if($data["widgetType"] === 'pix-feature'){
                                                $data['settings']['icon_size'] = round((int) $data['settings']['icon_size'] / 0.85);
                                            }
                                        }
                                        if(isset($data['settings']['icon_position']) && $data['settings']['icon_position'] === 'left'){
                                            // check if padding_title contains "px" string, then get its (int) valur and add 2 to it, then save the value with 'px' at the end in padding_title
                                            if(isset($data['settings']['padding_title']) && strpos($data['settings']['padding_title'], 'px') !== false){
                                                $padding_title = (int) $data['settings']['padding_title'];
                                                $padding_title += 3;
                                                $data['settings']['padding_title'] = $padding_title . 'px';
                                            }
                                        }
                                    }
                                } else {
                                    $data['settings']['icon'] = $this->verifyIconName($data['settings']['icon']);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
}
