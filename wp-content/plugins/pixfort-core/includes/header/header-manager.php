<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Header Manager.
 *
 * 
 *
 * @since 1.0.0
 */
class HeaderManager {

	public $headerID = false;
	public $headerPost;

	public $headerData;

	public $headerStyle = false;
	public $headerSticky = '';
	public $isSecondaryFont = false;
	public $headerContainerWidth = '';
	public $headerContainerWidthCustom = '';
	public $headerContainerScrollWidth = '';
	public $headerContainerScrollWidthCustom = '';
	public $headerStyleMobile = '';
	private $styleEnqueued = false;
	public $headerHeight = 0;
	public $headerHeightMobile = 0;
	public $headerScrollHeight = 0;
	public $headerScrollHeightMobile = 0;
	public function __construct() {

		add_action('wp', [$this, 'initHeaderID']);
		add_action('wp', [$this, 'initHeaderData']);
		add_action('pixfort_location_header', [$this, 'renderHeader'], 10, 2);
		add_action('wp_enqueue_scripts',  [$this, 'enqueueScripts'], 100);
		add_action('wp_ajax_pix_header_preview', array($this, 'headerPreview'));
	}


	function previewHeader($ID, $data, $headerStyle, $isSecondaryFont, $headerSticky, $headerContainerWidth, $headerContainerWidthCustom, $headerContainerScrollWidth, $headerContainerScrollWidthCustom) {
		$this->headerID = $ID;
		$this->headerData = $data;
		$this->headerStyle = $headerStyle;
		$this->headerSticky = $headerSticky;
		$this->isSecondaryFont = $isSecondaryFont;
		$this->headerContainerWidth = $headerContainerWidth;
		$this->headerContainerWidthCustom = $headerContainerWidthCustom;
		$this->headerContainerScrollWidth = $headerContainerScrollWidth;
		$this->headerContainerScrollWidthCustom = $headerContainerScrollWidthCustom;
		$this->renderHeader();
		$this->generateStyling(true);
		add_action('wp_enqueue_scripts',  [$this, 'enqueueScripts'], 100);
	}

	function renderHeader() {
		try {
			if (!$this->headerID || $this->headerID === 'disable' || empty($this->headerData)) {
				if(!$this->headerID&&$this->headerID !== 'disable'&&empty($this->headerData)){
					$this->headerData = json_decode('{"topbar":{"name":"topbar","val":{"topbar_1":{"name":"topbar_1","val":[]},"topbar_2":{"name":"topbar_2","val":[]}}},"header":{"name":"header","val":{"header_1":{"name":"header_1","val":[{"id":"fb4598c9-55db-4926-9dfa-c90e5b016735","name":"logo","content":"Logo","category":"main","icon":"logoMini","val":[]},{"id":"ffb9ad5b-1f9a-431e-9f67-01754627cc4a","name":"menu","content":"Menu","category":"main","icon":"barsMenu","val":[]}]}}},"stack":{"name":"stack","val":{"stack_1":{"name":"stack_1","val":[]},"stack_2":{"name":"stack_2","val":[]},"stack_3":{"name":"stack_3","val":[]}}},"m_topbar":{"name":"m_topbar","val":{"m_topbar_1":{"name":"m_topbar_1","val":[]}}},"m_header":{"name":"m_header","val":{"m_header_1":{"name":"m_header_1","val":[{"id":"d1276612-74d6-4313-9578-39bae4f5b30c","name":"logo","content":"Logo","category":"main","icon":"logoMini","val":[]},{"id":"339f8ddb-e98c-4d0a-a736-39d093c60df7","name":"menu","content":"Menu","category":"main","icon":"barsMenu","val":[]}]}}},"m_stack":{"name":"m_stack","val":{"m_stack_1":{"name":"m_stack_1","val":[]}}}}');
				} else {
					return;
				}
			}
			include_once('parts/topbar.php');
			include_once('parts/stack.php');
			include_once('header-functions.php');

			// Transparent Header
			if ($this->headerStyle == "transparent" || $this->headerStyle == "transparent-full") {
				include_once('parts/header_transparent.php');
?>
				<div class="pix-header-transparent pix-header-transparent-parent position-relative" data-width="<?php echo $this->headerContainerWidth; ?>" data-scroll-width="<?php echo $this->headerContainerScrollWidth; ?>">
					<div class="position-absolute w-100 pix-left-0">
						<?php
						if (isset($this->headerData->topbar)) {
							$opts = $this->getHeaderOpts($this->headerData->topbar);
							renderTopbar($this->headerData->topbar->val, $opts);
						}
						?>
						<div class="pix-header-placeholder position-relative d-block w-100">
							<?php
							if (isset($this->headerData->header)) {
								$opts = $this->getHeaderOpts($this->headerData->header);
								renderHeaderTransparent($this->headerData->header->val, $opts, $this->headerSticky, $this->headerStyle);
							}
							?>
						</div>
						<?php
						if (isset($this->headerData->stack)) {
							$opts = $this->getHeaderOpts($this->headerData->stack);
							renderStack($this->headerData->stack, $opts);
						}
						?>
					</div>
				</div>
			<?php
			} elseif ($this->headerStyle == "boxed" || $this->headerStyle == "boxed-full") {
				// Boxed Header
				include_once('parts/header_boxed.php');
				$isTopbarEmpty = true;
				$topbarBg = 'gray-1';
				$topbarScrollBg = '';
				$topbarSticky = '';
				$topbarOpts = $this->getHeaderOpts($this->headerData->topbar);
				if (!empty($this->headerData->topbar) && !empty($this->headerData->topbar->val)) {
					if (!empty($this->headerData->topbar->val->topbar_1) && !empty($this->headerData->topbar->val->topbar_1->val)) {
						$isTopbarEmpty = false;
					} else if (!empty($this->headerData->topbar->val->topbar_2) && !empty($this->headerData->topbar->val->topbar_2->val)) {
						$isTopbarEmpty = false;
					} else if (!empty($this->headerData->topbar->val->topbar_3) && !empty($this->headerData->topbar->val->topbar_3->val)) {
						$isTopbarEmpty = false;
					}
					if (!$isTopbarEmpty && !empty($topbarOpts['background'])) {
						$topbarBg = $topbarOpts['background'];
					}
					if (!$isTopbarEmpty && !empty($topbarOpts['scroll_background'])) {
						$topbarScrollBg = $topbarOpts['scroll_background'];
					}
					if (!$isTopbarEmpty && !empty($topbarOpts['sticky'])) {
						$topbarSticky = $topbarOpts['sticky'];
					}
				}
			?>
				<div class="pix-header-boxed" data-width="<?php echo $this->headerContainerWidth; ?>" data-scroll-width="<?php echo $this->headerContainerScrollWidth; ?>">
					<div class="position-absolute w-100 pix-left-0">
						<?php
						// Desktop header
						if (!empty($this->headerData->topbar)) {

							renderTopbar($this->headerData->topbar->val, $topbarOpts);
						}
						?>
						<div class="pix-header-placeholder position-relative d-block w-100">
							<?php
							if (!empty($this->headerData->header)) {
								$stack_data = null;
								if (!empty($this->headerData->stack)) {
									$stack_data = $this->headerData->stack;
								}
								$opts = $this->getHeaderOpts($this->headerData->header);
								$stackOpts = $this->getHeaderOpts($this->headerData->stack);
								// include('header_boxed.php');
								renderHeaderBoxed($this->headerData->header, $opts, $this->headerSticky, $stack_data, $stackOpts, $topbarBg, $topbarScrollBg, $topbarSticky, $isTopbarEmpty);
							}
							?>
						</div>
					</div>
				</div>
			<?php
			} else {
				include_once('parts/header.php');
				// Default Header
				if (isset($this->headerData->topbar)) {
					$opts = $this->getHeaderOpts($this->headerData->topbar);
					renderTopbar($this->headerData->topbar->val, $opts, $this->headerContainerWidth, $this->headerContainerScrollWidth);
				}
				if (isset($this->headerData->header)) {
					$opts = $this->getHeaderOpts($this->headerData->header);
					renderHeaderDefault($this->headerData->header, $opts, $this->headerSticky, $this->headerContainerWidth, $this->headerContainerScrollWidth);
				}
				if (isset($this->headerData->stack)) {
					$opts = $this->getHeaderOpts($this->headerData->stack);
					renderStack($this->headerData->stack, $opts, $this->headerContainerWidth, $this->headerContainerScrollWidth);
				}
			}


			// Mobile header
			if ($this->headerStyleMobile === "overlap") {
			?>
			<div class="pix-header-mobile-container is-overlap">
			<?php
			}
				if (isset($this->headerData->m_topbar)) {
					include_once('parts/m_topbar.php');
					$opts = $this->getHeaderOpts($this->headerData->m_topbar);
					renderMobileTopbar($this->headerData->m_topbar->val, $opts);
				}
			if (isset($this->headerData->m_header) && isset($this->headerData->m_header->val)) {
				include_once('parts/m_header.php');
				$opts = $this->getHeaderOpts($this->headerData->m_header);
				renderMobileHeader($this->headerData->m_header->val, $opts, $this->headerPost);
			}
			if (isset($this->headerData->m_stack)) {
				include_once('parts/m_stack.php');
				$opts = $this->getHeaderOpts($this->headerData->m_stack);
					renderMobileStack($this->headerData->m_stack->val, $opts);
				}
			if ($this->headerStyleMobile === "overlap") {
			?>
			</div>
			<?php
			}

			wp_reset_postdata();
			// echo '<header class="pixfort-header ' . $this->headerSticky  . '">';
			// foreach ($this->headerData as $area) {
			// 	if (!empty($area)) {
			// 		$smart = '';
			// 		if($area->name == 'topbar' || $area->name == 'stack'){
			// 			$smart = 'is-smart-sticky';
			// 		}
			// 		echo '<div class="pixfort-header-area pix-site-sticky-top '.$smart.'" data-area="' . $area->name . '">';
			// 		echo '<div class="' . $container_class  . '">';
			// 		echo '<div class="row">';
			// 		$this->renderHeaderArea($area);
			// 		echo '</div>';
			// 		echo '</div>';
			// 		echo '</div>';
			// 	}
			// }
			// echo '</header>';
		} catch (\Throwable $th) {
			echo $th;
		}
	}


	function getHeaderOpts($data) {
		$opts = [];
		if (isset($data->opts)) {
			foreach ($data->opts as $i => $v) {
				$opts[$v->name] = $v->val;
			}
		}
		$opts['is_secondary_font'] = $this->isSecondaryFont;
		return $opts;
	}

	function generateStyling($forceGenerate = false) {
		if (!is_user_logged_in()) {
			if (!$forceGenerate) {
				$headerStyling = get_post_field('pixfort-header-styling', $this->headerPost);
				if (!empty($headerStyling)) {
					wp_register_style('pixfort-custom-header-style', false);
					wp_enqueue_style('pixfort-custom-header-style');
					wp_add_inline_style('pixfort-custom-header-style', $headerStyling);
					return;
				}
			}
		}
		$customStyle = '';
		if ($this->headerData === null) {
			return;
		}

		$blurStatments = 'content: "";
		-webkit-backdrop-filter: saturate(180%) blur(20px);
		backdrop-filter: saturate(180%) blur(20px);
		transition: background 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), filter 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), opacity 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
		position: absolute;
		overflow: hidden;
		width: 100%;
		background: var(--pix-blur-color) !important;
		opacity: var(--pix-opacity-header-blur, 0);
		height: 100%;
		border-radius: inherit;
		top: 0;
		left: 0;
		z-index: -1;
		';
		foreach ($this->headerData as $area) {
			if (!empty($area) && !empty($area->opts)) {
				$opts = [];
				if (!empty($area->opts)) {
					foreach ($area->opts as $i => $v) {
						$opts[$v->name] = $v->val;
					}
				}
				extract(wp_parse_args($opts, [
					'background' 		=> '',
					'custom_background' 		=> '',
					'scroll_background'             => '',
					'scroll_custom_background'         => '#fff',
					'style' 		=> '',
					'line_color' 		=> 'gray-1',
					'custom_line_color' 		=> '',
					'scroll_line_color' 		=> '',
					'scroll_custom_line_color' 		=> '',
					'bold' 		=> '',
					'color' 		=> 'body-default',
					'scroll_color'                     => '',
					'scroll_custom_color'                     => '',
					'custom_color' 		=> '',
					'header_shadow' 		=> '',
					'scroll_shadow' 		=> '',
					'border_radius' 		=> '',
					'scroll_border_radius' 		=> ''
				]));
				$statments = [];
				$addBlurStatments = false;
				if (!empty($background) && $background !== 'default') {
					if ($background === 'custom') {
						array_push($statments, '--pix-header-bg-color: ' . $custom_background . ';');
					} else {
						if ($background === 'dark-blur' || $background === 'light-blur' || $background === 'dynamic-blur') {
							array_push($statments, '--pix-display-header-blur: block;');
							array_push($statments, '--pix-opacity-header-blur: 1;');
							$addBlurStatments = true;
							array_push($statments, '--pix-header-bg-color: transparent;');
							if($background === 'dynamic-blur'){
								array_push($statments, '--pix-blur-color: var(--pix-dynamic-blur);');
							} elseif ($background === 'dark-blur') {
								array_push($statments, '--pix-blur-color: rgba(29, 29, 31, 0.72);');
							} else {
								array_push($statments, '--pix-blur-color: rgba(255,255,255,0.8);');
							}
						} else {
							array_push($statments, '--pix-header-bg-color: var(--pix-' . $background . ');');
						}
					}
				}
				if (!empty($scroll_background)) {
					if ($scroll_background === 'custom') {
						array_push($statments, '--pix-header-scroll-bg-color: ' . $scroll_custom_background . ';');
					} else {
						if ($scroll_background === 'dark-blur' || $scroll_background === 'light-blur' || $scroll_background === 'dynamic-blur') {
							array_push($statments, '--pix-display-header-scroll-blur: block;');
							array_push($statments, '--pix-opacity-header-scroll-blur: 1;');
							$addBlurStatments = true;
							if($scroll_background === 'dynamic-blur'){
								array_push($statments, '--pix-scroll-blur-color: var(--pix-dynamic-blur);');
							} elseif ($scroll_background === 'dark-blur') {
								array_push($statments, '--pix-scroll-blur-color: rgba(29, 29, 31, 0.72);');
							} else {
								array_push($statments, '--pix-scroll-blur-color: rgba(255,255,255,0.8);');
							}
							array_push($statments, '--pix-header-scroll-bg-color: transparent;');
						} else {
							array_push($statments, '--pix-display-header-scroll-blur: none;');
							array_push($statments, '--pix-opacity-header-scroll-blur: 0;');
							array_push($statments, '--pix-header-scroll-bg-color: var(--pix-' . $scroll_background . ');');
						}
					}
				}
				if (!empty($color) && $color !== 'default') {
					if ($color === 'custom') {
						array_push($statments, '--pix-header-text-color: ' . $custom_color . ';');
					} else {
						array_push($statments, '--pix-header-text-color: var(--pix-' . $color . ');');
					}
				}
				if (!empty($scroll_color)) {
					if ($scroll_color === 'custom') {
						array_push($statments, '--pix-header-scroll-text-color: ' . $scroll_custom_color . ';');
					} else {
						array_push($statments, '--pix-header-scroll-text-color: var(--pix-' . $scroll_color . ');');
					}
				}
				if (!empty($style) && !empty($line_color)) {
					// $borderColor = '';
					if ($line_color === 'custom') {
						array_push($statments, '--pix-header-area-line-color: ' . $custom_line_color . ';');
						// $borderColor = $custom_line_color;
					} else {
						// if($line_color === 'gradient-primary'){
						// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] .pix-header-area-line{ background-image: var(--pix-gradient-primary); }';
						// } elseif($line_color === 'gradient-primary-light'){
						// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] .pix-header-area-line{ background-image: var(--pix-gradient-primary-light); }';
						// } else {
						array_push($statments, '--pix-header-area-line-color: var(--pix-' . $line_color . ');');
						// }
						// $borderColor = 'var(--pix-' . $line_color . ')';
					}
					if(!empty($scroll_line_color)){
						if($scroll_line_color === 'custom'){
							array_push($statments, '--pix-header-scroll-line-color: ' . $scroll_custom_line_color . ';');
						} else {
							if($scroll_line_color === 'transparent'){
								$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '].is-scroll .pix-header-area-line { display: none; }';
							} else {
								array_push($statments, '--pix-header-scroll-line-color: var(--pix-' . $scroll_line_color . ');');
							}
						}
					}
					// if ($style == "border-bottom-wide") {
					// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] { border-bottom: 1px solid ' . $borderColor . '; }';
					// } elseif ($style == "border-bottom") {
					// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] .pix-row { border-bottom: 1px solid ' . $borderColor . '; }';
					// } elseif ($style == "border-top-wide") {
					// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] { border-top: 1px solid ' . $borderColor . '; }';
					// } elseif ($style == "border-top") {
					// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] .pix-row { border-top: 1px solid ' . $borderColor . '; }';
					// } elseif ($style == "border-both-wide") {
					// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] { border-top: 1px solid ' . $borderColor . '; border-bottom: 1px solid ' . $borderColor . '; }';
					// } elseif ($style == "border-both") {
					// 	$customStyle .= '.pixfort-header-area[data-area=' . $area->name . '] .pix-row { border-top: 1px solid ' . $borderColor . '; border-bottom: 1px solid ' . $borderColor . '; }';
					// }
				}
				if (!empty($header_shadow)) {
					array_push($statments, '--pix-header-shadow: var(--pix-' . $header_shadow . ');');
				}
				if (empty($scroll_shadow) && ($area->name == 'header' || $area->name == 'm_header')) {
					$scroll_shadow = 'shadow-lg';
				}
				if (!empty($scroll_shadow)) {
					array_push($statments, '--pix-scroll-header-shadow: var(--pix-' . $scroll_shadow . ');');
				}

				// Apply border radius to the header area
				if (!empty($border_radius)) {
					if($this->headerStyle === 'boxed' && ($area->name === 'header' || $area->name === 'stack')){
						$customStyleValue = '';
						$tl= $this->getDimensionsValue($border_radius, 'top');
						if(isset($tl) && $tl !== ''){
							$customStyleValue .= '--pix-boxed-round-tl: ' . $tl . 'px;';
						}
						$tr= $this->getDimensionsValue($border_radius, 'right');
						if(isset($tr) && $tr !== ''){
							$customStyleValue .= '--pix-boxed-round-tr: ' . $tr . 'px;';
						}
						$br= $this->getDimensionsValue($border_radius, 'bottom');
						if(isset($br) && $br !== ''){
							$customStyleValue .= '--pix-boxed-round-br: ' . $br . 'px;';
						}
						$bl= $this->getDimensionsValue($border_radius, 'left');
						if(isset($bl) && $bl !== ''){
							$customStyleValue .= '--pix-boxed-round-bl: ' . $bl . 'px;';
						}
						$customStyle .= '.pixfort-area-content[data-area=' . $area->name . '] { ' .$customStyleValue.' }';
					} else {
						$customStyle .= $this->getDimensionsCSS($border_radius, 'border-radius', '.pixfort-area-content[data-area=' . $area->name . ']');
					}
				}

				if (!empty($statments)) {
					$customStyle .= '.pixfort-area-content[data-area=' . $area->name . '] { ' . join(' ', $statments) . ' }';
					if($addBlurStatments){
						$customStyle .= '.pixfort-area-content[data-area=' . $area->name . ']:before { ' .  $blurStatments . ' }';
					}
				}

				// For scrolling state - apply scroll border radius
				if (!empty($scroll_border_radius)) {
					// check if the header is boxed
					if($this->headerStyle === 'boxed' && ($area->name === 'header' || $area->name === 'stack')){
						$customStyleValue = '';
						$tl = $this->getDimensionsValue($scroll_border_radius, 'top');
						if(isset($tl) && $tl !== ''){
							$customStyleValue .= '--pix-boxed-round-tl: ' . $tl . 'px;';
						}
						$tr = $this->getDimensionsValue($scroll_border_radius, 'right');
						if(isset($tr) && $tr !== ''){
							$customStyleValue .= '--pix-boxed-round-tr: ' . $tr . 'px;';
						}
						$br = $this->getDimensionsValue($scroll_border_radius, 'bottom');
						if(isset($br) && $br !== ''){
							$customStyleValue .= '--pix-boxed-round-br: ' . $br . 'px;';
						}
						$bl = $this->getDimensionsValue($scroll_border_radius, 'left');
						if(isset($bl) && $bl !== ''){
							$customStyleValue .= '--pix-boxed-round-bl: ' . $bl . 'px;';
						}
						$customStyle .= '.is-scroll .pixfort-area-content[data-area=' . $area->name . '], .pixfort-area-content.is-scroll[data-area=' . $area->name . '] { '.$customStyleValue.' }';
					} else {
						$customStyle .= $this->getDimensionsCSS($scroll_border_radius, 'border-radius', '.is-scroll .pixfort-area-content[data-area=' . $area->name . '], .pixfort-area-content.is-scroll[data-area=' . $area->name . ']');
					}
				}

				foreach ($area->val as $col) {
					if (!empty($col) && !empty($col->opts)) {
						$columnOpts = [];
						if (!empty($col->opts)) {
							foreach ($col->opts as $i => $v) {
								if (!empty($v->name)) $columnOpts[$v->name] = $v->val;
							}
						}
						extract(shortcode_atts([
							'width' 		=> '',
							'background' 		=> '',
							'scroll_background' 		=> '',
							'text_color'       => '',
							'custom_text_color'       => '',
							'scroll_text_color'       => '',
							'scroll_custom_text_color'       => '',
							'padding' 		=> '',
							'scroll_padding'     => '',
							'margin' 		=> '',
							'scroll_margin'     => '',
							'border_radius' 		=> '',
							'scroll_border_radius'     => '',
							'size' 		=> '',
							'custom_size' 		=> '',
						], $columnOpts));
						// $background = $columnOpts['background'] ?? '';
						$columnStatments = [];
						if (!empty($background) && $background !== 'default') {
							if ($background === 'custom') {
								array_push($columnStatments, '--pix-col-bg-color: ' . $custom_background . ';');
							} else {
								if ($background === 'dark-blur' || $background === 'light-blur' || $background === 'dynamic-blur') {
									array_push($columnStatments, 'position: relative;');
									array_push($columnStatments, '--pix-display-col-blur: block;');
									array_push($columnStatments, '--pix-col-bg-color: transparent;');
									if($background === 'dynamic-blur'){
										array_push($columnStatments, '--pix-blur-color: var(--pix-dynamic-blur);');
									} elseif ($background === 'dark-blur') {
										array_push($columnStatments, '--pix-blur-color: rgba(29, 29, 31, 0.72);');
									} else {
										array_push($columnStatments, '--pix-blur-color: rgba(255,255,255,0.8);');
									}
								} else {
									array_push($columnStatments, '--pix-col-bg-color: var(--pix-' . $background . ');');
								}
							}
						}
						
						// Handle scroll background for columns
						if (!empty($scroll_background) && $scroll_background !== 'default') {
							if ($scroll_background === 'dark-blur' || $scroll_background === 'light-blur' || $scroll_background === 'dynamic-blur') {
								$scrollColumnStyles = 'position: relative; --pix-display-col-blur: block; --pix-col-bg-color: transparent;';
								if($scroll_background === 'dynamic-blur'){
									$scrollColumnStyles .= ' --pix-blur-color: var(--pix-dynamic-blur);';
								} elseif ($scroll_background === 'dark-blur') {
									$scrollColumnStyles .= ' --pix-blur-color: rgba(29, 29, 31, 0.72);';
								} else {
									$scrollColumnStyles .= ' --pix-blur-color: rgba(255,255,255,0.8);';
								}
								$customStyle .= '.is-scroll .pixfort-header-col[data-col=' . $col->name . '] { ' . $scrollColumnStyles . ' }';
							} else {
								$customStyle .= '.is-scroll .pixfort-header-col[data-col=' . $col->name . '] { --pix-col-bg-color: var(--pix-' . $scroll_background . ') !important;--pix-display-col-blur: none; }';
							}
						}
						
						if (!empty($text_color) && $text_color !== 'default') {
							if ($text_color === 'custom') {
								array_push($columnStatments, '--pix-header-text-color: ' . $custom_text_color . ';');
							} else {
								array_push($columnStatments, '--pix-header-text-color: var(--pix-' . $text_color . ');');
							}
						}
						
						// Apply scroll text color if set
						if (!empty($scroll_text_color) && $scroll_text_color !== 'default') {
							if ($scroll_text_color === 'custom') {
								$customStyle .= '.is-scroll .pixfort-header-col[data-col=' . $col->name . '] { --pix-header-scroll-text-color: ' . $scroll_custom_text_color . ' !important; }';
							} else {
								$customStyle .= '.is-scroll .pixfort-header-col[data-col=' . $col->name . '] { --pix-header-scroll-text-color: var(--pix-' . $scroll_text_color . ') !important; }';
							}
						}
						
						if (!empty($size) && !empty($custom_size)) {
							if ($size === 'flex-custom') {
								$customStyle .= '.pixfort-header-col[data-col=' . $col->name . '] { width: ' . $custom_size . '; }';
							}
						}

						$customStyle .= $this->getDimensionsCSS($padding, 'padding', '.pixfort-header-col[data-col=' . $col->name . ']');
						
						// Apply scroll padding if set
						if (!empty($scroll_padding)) {
							$customStyle .= $this->getDimensionsCSS($scroll_padding, 'padding', '.is-scroll .pixfort-header-col[data-col=' . $col->name . ']');
						}
						
						$customStyle .= $this->getDimensionsCSS($margin, 'margin', '.pixfort-header-col[data-col=' . $col->name . ']');
						
						// Apply scroll margin if set
						if (!empty($scroll_margin)) {
							$customStyle .= $this->getDimensionsCSS($scroll_margin, 'margin', '.is-scroll .pixfort-header-col[data-col=' . $col->name . ']');
						}
						
						$customStyle .= $this->getDimensionsCSS($border_radius, 'border-radius', '.pixfort-header-col[data-col=' . $col->name . ']');

						// Apply scroll border radius if set
						if (!empty($scroll_border_radius)) {
							$customStyle .= $this->getDimensionsCSS($scroll_border_radius, 'border-radius', '.is-scroll .pixfort-header-col[data-col=' . $col->name . ']');
						}

						if (!empty($columnStatments)) {
							$customStyle .= '.pixfort-header-col[data-col=' . $col->name . '] { ' . join(' ', $columnStatments) . ' }';
						}
					}
				}
			}
		}
		if (pix_plugin_get_option('pix-body-padding') && pix_plugin_get_option('pix-body-padding') !== 'none') {
			$containerPadding = preg_replace('/\D/', '', pix_plugin_get_option('pix-body-padding'));
			$containerPadding = is_numeric($containerPadding) ? (int)$containerPadding : 0;
			$containerPadding = $containerPadding * 2;
			$customStyle .= ':root { --pix-container-padding: ' . $containerPadding . 'px; }';
		}
		if (strcmp($this->headerStyle, "default-full") == 0 || strcmp($this->headerStyle, "transparent-full") == 0) {
			if (pix_plugin_get_option('pix-body-padding') && pix_plugin_get_option('pix-body-padding') !== 'none') {
				$customStyle .= '.pixfort-header-area .container { --pix-header-container-width: calc(100vw - var(--pix-container-padding)); }';
				$customStyle .= '.pixfort-header-area { left: 0; }';
			} else {
				$customStyle .= '.pixfort-header-area .container { --pix-header-container-width: 100%; }';
			}
		}
		if (strcmp($this->headerStyle, "boxed-full") == 0) {
			if (pix_plugin_get_option('pix-body-padding') && pix_plugin_get_option('pix-body-padding') !== 'none') {
				$customStyle .= '.pix-header-boxed .container { --pix-header-container-width: calc(100vw - var(--pix-container-padding)); }';
			} else {
				$customStyle .= '.pix-header-boxed .container { --pix-header-container-width: 100vw; }';
			}
		}

		if (!empty($this->headerContainerWidth)) {
			if ($this->headerContainerWidth === 'default') {
				$customStyle .= '.pix-header .container, .pixfort-header-area .container { --pix-header-container-width: var(--pix-container-width, 1140px); }';
			} elseif ($this->headerContainerWidth === 'full') {
				$customStyle .= '.pix-header .container, .pixfort-header-area .container { --pix-header-container-width: 100vw; }';
			} elseif ($this->headerContainerWidth === 'custom') {
				$customStyle .= '.pix-header .container, .pixfort-header-area .container { --pix-header-container-width: ' . $this->headerContainerWidthCustom . '; }';
			// } elseif ($this->headerContainerWidth === 'content') {
				// $customStyle .= '.pix-header .container, .pixfort-header-area .container { --pix-header-container-width: 0px;--pix-header-container-width: calc-size(max-content, size); }';
			}
		}

		if (!empty($this->headerContainerScrollWidth)) {
			if ($this->headerContainerScrollWidth === 'default') {
				$customStyle .= '.pix-header .container:has(.is-scroll), .is-scroll .container { --pix-header-container-width: var(--pix-container-width, 1140px); }';
			} elseif ($this->headerContainerScrollWidth === 'full') {
				$customStyle .= '.pix-header .container:has(.is-scroll), .is-scroll .container { --pix-header-container-width: 100vw; }';
			} elseif ($this->headerContainerScrollWidth === 'custom') {
				$customStyle .= '.pix-header .container:has(.is-scroll), .is-scroll .container { --pix-header-container-width: ' . $this->headerContainerScrollWidthCustom . '; }';
			// } elseif ($this->headerContainerScrollWidth === 'content') {
				// $customStyle .= '.pix-header .container:has(.is-scroll), .is-scroll .container { --pix-header-container-width: 0px;--pix-header-container-width: calc-size(max-content, size); }';
			}
		}
		if(strcmp($this->headerStyle, "boxed") == 0 || strcmp($this->headerStyle, "transparent") == 0){
			if (!empty($this->headerHeight)) {
				$customStyle .= ':root { --pix-header-height: ' . $this->headerHeight . 'px;--pix-header-height-display: block; }';
			}
		}
		if(strcmp($this->headerStyleMobile, "overlap") == 0){
			if (!empty($this->headerHeightMobile)) {
				$customStyle .= ':root { --pix-header-height-mobile: ' . $this->headerHeightMobile . 'px;--pix-header-height-mobile-display: block; }';
			}
		}
		if(!empty($this->headerScrollHeight)){
			$customStyle .= ':root { --pix-header-scroll-height: ' . $this->headerScrollHeight . 'px; }';
		}
		if(!empty($this->headerScrollHeightMobile)){
			$customStyle .= ':root { --pix-header-scroll-height-mobile: ' . $this->headerScrollHeightMobile . 'px; }';
		}
		if (!empty($customStyle)) {
			wp_register_style('pixfort-custom-header-style', false);
			wp_enqueue_style('pixfort-custom-header-style');
			wp_add_inline_style('pixfort-custom-header-style', $customStyle);
			if (!empty($this->headerPost->ID)) {
				update_post_meta($this->headerPost->ID, 'pixfort-header-styling', $customStyle);
			}
		}
	}

	function getDimensionsCSS($dataString, $attribute, $selector) {
		$result = '';
		if (!empty($dataString)) {
			$data = false;
			if (is_string($dataString)) {
				$data = json_decode(wp_specialchars_decode($dataString));
			} elseif ($dataString instanceof stdClass) {
				$data = $dataString;
			}
			if ($data) {
				if ($data->isAdvanced) {
					$top = !empty($data->top) ? $data->top : 0;
					$right = !empty($data->right) ? $data->right : 0;
					$bottom = !empty($data->bottom) ? $data->bottom : 0;
					$left = !empty($data->left) ? $data->left : 0;
					$result = $selector . ' { ' . $attribute . ': ' . $top . 'px ' . $right . 'px ' . $bottom . 'px ' . $left . 'px !important; }';
				} else {
					if (isset($data->value) && ($data->value !== '' || $data->value === 0)) {
						$result = $selector . ' { ' . $attribute . ':' . $data->value . 'px !important; }';
					}
				}
			}
		}
		return $result;
	}

	function getDimensionsValue($dataString, $direction) {
		$result = '';
		if (!empty($dataString)) {
			$data = false;
			if (is_string($dataString)) {
				$data = json_decode(wp_specialchars_decode($dataString));
			} elseif ($dataString instanceof stdClass) {
				$data = $dataString;
			}
			if ($data) {
				if ($data->isAdvanced) {
					if($direction === 'top'){
						$result = !empty($data->top) ? $data->top : 0;
					} elseif($direction === 'right'){
						$result = !empty($data->right) ? $data->right : 0;
					} elseif($direction === 'bottom'){
						$result = !empty($data->bottom) ? $data->bottom : 0;
					} elseif($direction === 'left'){
						$result = !empty($data->left) ? $data->left : 0;
					}
				} else {
					if (isset($data->value) && ($data->value !== '' || $data->value === 0)) {
						$result = $data->value;
					}
				}
			}
		}
		return $result;
	}

	// function getColumnAlign($name, $opts) {
	// 	if (!empty($opts['align'])) {
	// 		$align = $opts['align'];
	// 		switch ($align) {
	// 			case 'text-left':
	// 				$align .= ' justify-content-start';
	// 				break;
	// 			case 'text-right':
	// 				$align .= ' justify-content-end';
	// 				break;
	// 			case 'text-center':
	// 				$align .= ' justify-content-center';
	// 				break;
	// 			case 'd-flex':
	// 				$align .= ' justify-content-between';
	// 				break;
	// 		}
	// 	} else {
	// 		$align = 'text-left justify-content-start';
	// 		switch ($name) {
	// 			case 'stack_2':
	// 				$align = 'text-center justify-content-center';
	// 				break;
	// 			case 'stack_3':
	// 			case 'topbar_2':
	// 				$align = 'text-right justify-content-end';
	// 				break;
	// 		}
	// 	}
	// 	return $align;
	// }

	public function initHeaderID() {
		if (get_post_type() === 'pixheader') {
			$this->headerID = get_the_ID();
			return;
		}
		$pagePostTypes = ['page', 'post', 'portfolio', 'product'];
		$pagePostTypes = apply_filters('pixfort_page_options_post_types', $pagePostTypes);
		$pageID = get_the_ID();
		$single_header = false;
		if (class_exists('WooCommerce') && is_shop()) {
			$pageID = get_option('woocommerce_shop_page_id');
		}
		$pageHeaderMeta = get_post_meta($pageID, 'pix-page-header', true);
		/*
		* Header set by Layout builder conditions
		*/
		$LayoutHeaders = \PixfortCore::instance()->areasManager->getLocationTemplates('header');
		if(!empty($LayoutHeaders[0])){
			$single_header = $LayoutHeaders[0];
		} 
		if (is_404()) {
			if (!empty(pix_plugin_get_option('pix-enable-custom-404')) && !empty(pix_plugin_get_option('pix-custom-404-page'))) {
				$custom404 = pix_plugin_get_option('pix-custom-404-page');
				if (function_exists('icl_get_languages')) {
					$custom404 = apply_filters('wpml_object_id', $custom404, 'page', true);
				}
				if ($custom404 && get_post_meta($custom404, 'pix-page-header', true) && get_post_meta($custom404, 'pix-page-header', true) !== 'default') {
					$single_header = get_post_meta($custom404, 'pix-page-header', true);
				}
			}
		} elseif (!is_search() && ((class_exists('WooCommerce') && is_shop()) || (in_array(get_post_type(), $pagePostTypes)) && $pageHeaderMeta)) {
			if (!empty($pageHeaderMeta)&&$pageHeaderMeta!=='default') {
				if($pageHeaderMeta === 'disable'){
					$single_header = 'disable';
				} else {
					// Check if post exists and is of type pixheader
					$post_exists = get_post($pageHeaderMeta);
					if ($post_exists && $post_exists->post_type === 'pixheader') {
						$single_header = $pageHeaderMeta;
					}
				}
			}
		}
		if (!$single_header) {
			if (pix_plugin_get_option('pix-header')) {
				$single_header = pix_plugin_get_option('pix-header');
				if ($single_header !== 'disable') {
					if (!get_post($single_header)) {
						$single_header = false;
					} else {
						if (get_post_type($single_header) != 'pixheader') {
							$single_header = false;
						}
					}
				}
			}
		}
		if ((empty($single_header) || !$single_header) && $single_header !== 'disable' && $single_header !== null) {
			$header_items = get_posts([
				'post_type' => 'pixheader',
				'post_status' => 'publish',
				'numberposts' => 1
			]);
			if (!empty($header_items)) {
				$single_header = $header_items[0]->ID;
			}
		}
		$this->headerID = $single_header;
	}
	public function initHeaderData() {

		if (!empty($this->headerID) && $this->headerID != 'disable') {
			
			$post = false;
			$correct_id = $this->headerID;
			if (function_exists('icl_get_languages')) {
				$correct_id = apply_filters('wpml_object_id', $this->headerID, 'page', true);
				$post = get_post($correct_id);
			} else {
				$post = get_post($this->headerID);
			}


		

			$cache_key = 'pix_header_data_' . $this->headerID;
			$this->headerData = wp_cache_get($cache_key);
			if ($this->headerData === false) {
				// Load header data and then cache it
				$data = get_post_field('pix-header-drag', $post);
				$data = json_decode(wp_specialchars_decode($data));
				wp_cache_set($cache_key, $data, '', DAY_IN_SECONDS); // Cache for 1 day
				$this->headerData = $data;
			}

			$header_style = '';
			$header_style_mobile = '';
			$headerContainerWidth = '';
			$headerContainerWidthCustom = '';
			$headerContainerScrollWidth = '';
			$headerContainerScrollWidthCustom = '';
			if (!empty(get_post_field('pix-header-style', $post))) {
				$header_style = get_post_field('pix-header-style', $post);
			}
			if (!empty(get_post_field('pix-header-style-mobile', $post))) {
				$header_style_mobile = get_post_field('pix-header-style-mobile', $post);
			}
			if (!empty(get_post_field('container-width', $post))) {
				$headerContainerWidth = get_post_field('container-width', $post);
			}
			if (!empty(get_post_field('container-width-custom', $post))) {
				$headerContainerWidthCustom = get_post_field('container-width-custom', $post);
			}
			if(\PixfortCore::instance()->getThemeParam('custom_header_width')) {
				if (!empty(get_post_field('container-width-scroll', $post))) {
					$headerContainerScrollWidth = get_post_field('container-width-scroll', $post);
				}
				if (!empty(get_post_field('container-width-scroll-custom', $post))) {
					$headerContainerScrollWidthCustom = get_post_field('container-width-scroll-custom', $post);
				}
			}
			// $header_sticky = 'pix-is-sticky-header';
			$header_sticky = 'is-sticky';
			$sticky_setting = get_post_field('pix-enable-sticky', $post);
			if (!empty($sticky_setting)) {
				if ($sticky_setting == 'disable') {
					// $header_sticky = '';
					$header_sticky = 'static-header';
				} elseif ($sticky_setting == 'smart') {
					// $header_sticky = 'pix-is-sticky-header is-smart-sticky';
					$header_sticky = 'is-smart-sticky';
				}
			}

			$is_secondary_font = false;
			if (!empty(get_post_field('is_secondary_font', $post))) {
				$is_secondary_font = get_post_field('is_secondary_font', $post);
			}

			$headerHeight = get_post_field('header-height', $post);
			$headerHeightMobile = get_post_field('header-height-mobile', $post);
			$headerScrollHeight = get_post_field('header-height-scroll', $post);
			$headerScrollHeightMobile = get_post_field('header-height-scroll-mobile', $post);
			$this->headerPost = $post;
			$this->headerStyle = $header_style;
			$this->headerSticky = $header_sticky;
			$this->isSecondaryFont = $is_secondary_font;
			$this->headerContainerWidth = $headerContainerWidth;
			$this->headerContainerWidthCustom = $headerContainerWidthCustom;
			$this->headerContainerScrollWidth = $headerContainerScrollWidth;
			$this->headerContainerScrollWidthCustom = $headerContainerScrollWidthCustom;
			$this->headerStyleMobile = $header_style_mobile;
			$this->headerHeight = $headerHeight;
			$this->headerHeightMobile = $headerHeightMobile;
			$this->headerScrollHeight = $headerScrollHeight;
			$this->headerScrollHeightMobile = $headerScrollHeightMobile;
		}
	}

	public function enqueueScripts() {
		if (!$this->styleEnqueued) {
			wp_enqueue_style(
				'pixfort-header-styles',
				PIX_CORE_PLUGIN_URI . 'includes/assets/css/header.min.css',
				false,
				PIXFORT_PLUGIN_VERSION,
				'all'
			);
			$this->generateStyling();
			$this->styleEnqueued = true;
		}
	}

	function headerPreview() {
		$nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
		if (!wp_verify_nonce($nonce, 'pixfort_ajax_nonce')) {
			wp_die('Unauthorized: Invalid security token', 'Security Error', array('response' => 403));
		}
		if (isset($_REQUEST['data'])) {
			$data = $_REQUEST['data'];
			$data = stripslashes($data);
			$obj = json_decode(wp_specialchars_decode($data, TRUE));
			
			// Validate JSON decode
			if (!$obj || !is_object($obj)) {
				wp_die('Invalid data format');
			}
			
			$single_header_preview_data = isset($obj->data) ? $obj->data : null;

			$isSecondaryFont = false;
			$headerSticky = '';
			$headerStyle = '';
			$headerContainerWidth = '';
			$headerContainerWidthCustom = '';
			$headerContainerScrollWidth = '';
			$headerContainerScrollWidthCustom = '';
			$previewState = 'false';
			$headerMode = '';
			$bgColor = '#ffffff'; // Default safe background color
			
			if (isset($obj->isSecondaryFont)) {
				$isSecondaryFont = (bool) $obj->isSecondaryFont;
			}
			if (isset($obj->previewState)) {
				if($obj->previewState === 'scroll'){
					$previewState = 'true';
				}
			}
			// if(!empty($obj->options->{'pix-enable-mobile-sticky'})&&!empty($obj->options->{'pix-enable-mobile-sticky'}->value)) {
			// 	$headerSticky = $obj->options->{'pix-enable-mobile-sticky'}->value;
			// }
			if (!empty($obj->headerStyle)) {
				$headerStyle = sanitize_text_field($obj->headerStyle);
			}
			if (!empty($obj->containerWidth)) {
				$headerContainerWidth = sanitize_text_field($obj->containerWidth);
			}
			if (!empty($obj->containerWidthScroll)) {
				$headerContainerScrollWidth = sanitize_text_field($obj->containerWidthScroll);
			}
			if (!empty($obj->containerWidthCustom)) {
				$headerContainerWidthCustom = sanitize_text_field($obj->containerWidthCustom);
			}
			if (!empty($obj->containerWidthScrollCustom)) {
				$headerContainerScrollWidthCustom = sanitize_text_field($obj->containerWidthScrollCustom);
			}
			if (!empty($obj->darkTestState) && $obj->darkTestState === 'dark') {
				$headerMode = 'pix-dark';
			}
			if (!empty($obj->bgColor)) {
				// Validate and sanitize background color
				$input_color = sanitize_text_field($obj->bgColor);
				// Allow only valid CSS color formats (hex, rgb, rgba, named colors)
				if (preg_match('/^(#[0-9a-f]{3,6}|rgb\([0-9,\s]+\)|rgba\([0-9,.\s]+\)|[a-z]+)$/i', $input_color)) {
					$bgColor = $input_color;
				}
			}
			error_reporting(0);
			@ini_set('display_errors', 0);
			ob_start();
			ob_flush();
			?>
			<!doctype html>
			<html <?php language_attributes(); ?> class="render <?php echo esc_attr($headerMode); ?>">

			<head>
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<?php wp_head(); ?>
				<?php
				wp_enqueue_script('pix-header-preview', PIX_CORE_PLUGIN_URI . 'includes/assets/js/header-preview.js' , ['jquery'], PIXFORT_PLUGIN_VERSION, true);
				?>
				<style>
					body { min-height: 100vh; }
					.is-scroll-hide { display: none !important;}
				</style>
			</head>

			<body class="<?php echo esc_attr('render header-preview'); ?> <?php echo esc_attr($headerMode); ?>" style="background: <?php echo esc_attr($bgColor); ?> !important;">
				<?php
				\PixfortCore::instance()->headerManager->previewHeader(13469, $single_header_preview_data, $headerStyle, $isSecondaryFont, $headerSticky, $headerContainerWidth, $headerContainerWidthCustom, $headerContainerScrollWidth, $headerContainerScrollWidthCustom);
				wp_footer();
				?>
				<script>
					function getHeaderHeight() {
						const css = `
						<style>.pix-header-mobile{display: block !important;} .pix-header-desktop{display: block !important;}@media (max-width: 1024px) { .pix-header-desktop { display: block !important; } }    [data-area="topbar"], [data-area="header"], [data-area="stack"] { display: block !important;}</style>
						`;
						$('body').append(css);
						// return the height of the header and the height of the header mobile
						let mobileHeight = 0;
						let desktopHeight = 0;
						let scrollDesktopHeight = 0;
						let scrollMobileHeight = 0;
						if($('[data-area="m_topbar"], [data-area="m_header"], [data-area="m_stack"]').length){
							$('[data-area="m_topbar"], [data-area="m_header"], [data-area="m_stack"]').each(function(){
								mobileHeight += $(this).height();
							});
						}
						if($('[data-area="header"], [data-area="topbar"], [data-area="stack"]').length){
							$('[data-area="header"], [data-area="topbar"], [data-area="stack"]').each(function(){
								desktopHeight += $(this).height();
							});
						}	


						if($('[data-area="header"].is-sticky, [data-area="topbar"].is-sticky, [data-area="stack"].is-sticky').length){
							$('[data-area="header"].is-sticky, [data-area="topbar"].is-sticky, [data-area="stack"].is-sticky').each(function(){
								scrollDesktopHeight += $(this).height();
							});
						}	
						if($('[data-area="header"]').hasClass('pix-scroll-top-margin')){
							scrollDesktopHeight += 20;
						}
						if($('[data-area="m_header"].is-sticky, [data-area="m_topbar"].is-sticky, [data-area="m_stack"].is-sticky').length){
							$('[data-area="m_header"].is-sticky, [data-area="m_topbar"].is-sticky, [data-area="m_stack"].is-sticky').each(function(){
								scrollMobileHeight += $(this).height();
							});
						}	
						// if($('[data-area="header"].pix-mt-20').length){
						// 	desktopHeight += 20;
						// }
						if(desktopHeight > 0){
							desktopHeight += 20;
						}
						if(mobileHeight > 20){
							mobileHeight -= 20;
						}
						return {
							headerHeight: desktopHeight,
							headerHeightMobile: mobileHeight,
							scrollDesktopHeight: scrollDesktopHeight,
							scrollMobileHeight: scrollMobileHeight
						};
					}
					function changePreviewState(state) {
						if (state) {
							$('.pixfort-header-area').addClass('is-scroll');
							$('.pixfort-header-area:not(.is-sticky):not(.is-smart-sticky').hide();
							$('.pixfort-header-area:not(.is-sticky):not(.is-smart-sticky').addClass('is-scroll-hide');
							if(window.headerScrollPreview) window.headerScrollPreview(true);
						} else {
							$('.pixfort-header-area:not(.is-sticky):not(.is-smart-sticky').show();
							$('.pixfort-header-area').removeClass('is-scroll');
							$('.pixfort-header-area:not(.is-sticky):not(.is-smart-sticky').removeClass('is-scroll-hide');
							if(window.headerScrollPreview) window.headerScrollPreview(false);
						}
					}
					function changeDarkTestState(state) {
						if (state) {
							$('html, body').addClass('pix-dark');
						} else {
							$('html, body').removeClass('pix-dark');
						}
					}
					$(document).ready(function() {
						changePreviewState(<?php echo $previewState; ?>);
					});
					document.querySelectorAll('a').forEach(link => {
						// Add a click event listener to each link
						link.addEventListener('click', function(e) {
							// Check if the link's href attribute is either empty or points to an anchor on the same page
							if (
								!link.getAttribute('href') ||
								!link.getAttribute('href').startsWith('#')

							) {
								// Allow this link to work normally
								e.preventDefault();
							}
							e.stopPropagation();
							e.preventDefault();
							e.stopImmediatePropagation();
							return;
							// Prevent the default action for links that change the page
						});
					});
					$('a').unbind('keydown');
					$(document).on('click', 'a', function(e) {
						// Check if the link is an anchor link or a same-page link
						let link = $(this).href ? $(this) : $(this).closest('a');
						const href = link.attr('href');
						if (
							!link ||
							!href || // No href attribute
							!href.startsWith('#')
						) {
							// Prevent the default action for links that navigate away
							e.preventDefault();
							e.stopPropagation();
						}
						e.stopPropagation();
						e.preventDefault();
						e.stopImmediatePropagation();
						return;
					});
					// Prevent all form submissions
					$(document).on('submit', 'form', function(event) {
						// Prevent any form from being submitted
						event.preventDefault();
						event.stopImmediatePropagation();
						event.stopPropagation();
					});
				</script>
			</body>

			</html>
<?php
			$Previewcontent = ob_get_contents();
			ob_get_clean();
			echo $Previewcontent;
			wp_die();
		}
	}
}
