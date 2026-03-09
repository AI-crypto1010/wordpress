<?php

function pixfort_demo_elementor_popups() {
	$data = array();
	$elementor = false;
	if (class_exists('\Elementor\Plugin')) {
		$elementor = true;
	}
	$import_url = 'https://import.pixfort.com/conseil/';
	$import_image_url = 'https://theme.assets.pixfort.com/thumbnails/popups/';

	if ($elementor) {
		// [Elementor] Popups with Launcher

		$demo = array(
			'import_file_name'             => 'General Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-general-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-general.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/popup-builder/launcher-general-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Contact Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-contact-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-contact.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-contact-popup-preview',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Call Links Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-call-links-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-call-links.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-call-links-popup-preview',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Sidebar Links Right with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-sidebar-links-right-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-sidebar-links-right.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-sidebar-links-right-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Circles Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-circles-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-circles.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-circles-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Cookie Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-cookie-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-cookie.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-cookie-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Social Buttons with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-social-buttons-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-social-buttons.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-social-buttons-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Deal Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-deal-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-deal.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-deal-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'News Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-news-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-news.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-news-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Help Popup with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-help-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-help.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-help-popup-preview/',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Contact Full Screen with Launcher - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-launcher-contact-full-screen-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-launcher-contact-full-screen.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/launcher-contact-full-screen-popup-preview/',
		);
		array_push($data, $demo);

		// [Elementor] Normal Popups

		$demo = array(
			'import_file_name'             => 'Sidebar Links Left Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-sidebar-links-left-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-sidebar-links-left.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Circles Default Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-circles-default-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-circles-default.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Promo Mini Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-promo-mini-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-promo-mini.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Promo Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-promo-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-promo.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Promo Wide Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-promo-wide-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-promo-wide.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Photo Boxes Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-photo-boxes-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-photo-boxes.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Newsletter Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-newsletter-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-newsletter.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Features Small Left Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-features-small-left-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-features-small-left.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Welcome Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-welcome-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-welcome.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Banner Small Right Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-banner-small-right-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-banner-small-right.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Project Overview Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-project-overview-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-project-overview.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Quick Overview Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-quick-overview-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-quick-overview.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Search Extended Full Screen - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-search-extended-full-screen-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-search-extended.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Top Bar Search Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-top-bar-search-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-top-bar-search.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Search Simple Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-search-simple-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-search-simple.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Links Full Screen Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-links-full-screen-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-links-full-screen.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Links Top Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-details-top-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-links-top.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Article Overview Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-article-overview-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-article-overview.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'About Bottom Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-about-bottom-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-about-bottom.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Sidebar About Right Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-sidebar-about-right-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-sidebar-about-right.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Bottom Bar Social Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-bottom-bar-social-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-bottom-bar-social.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Bottom Bar Links Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-bottom-bar-links-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-bottom-bar-links.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Quick Links Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-quick-links-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-quick-links.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Cookie Normal Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-cookie-normal-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-cookie-normal.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Cookie Non-dismissible Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-cookie-non-dismissible-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-cookie-non-dismissible.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Cookie Small Left Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-cookie-small-left-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-cookie-small-left.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Cookie Mini Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-cookie-mini-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-cookie-mini.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Age Verification Popup - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-age-verification-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-age-verification.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Video - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-video-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-video.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Application - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-application-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-application.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Address Extended - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-address-information-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-address-extended.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Cookie policy - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-cookie-policy-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-cookie.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Subscribe 1 - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-subscribe-1-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-subscribe-1.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Subscribe 2 - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-subscribe-2-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-subscribe-2.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Countdown - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-countdown-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-countdown.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup CTA - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-cta-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-cta.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Information - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-information-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-information.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Image - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-image-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-image.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Pricing - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-pricing-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-pricing.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Contact Extended - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-contact-extended-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-contact-extended.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Download - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-download-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-download.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Contact - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-contact-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-contact.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Address Simple - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-address-information-simple-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-address-simple.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);

		$demo = array(
			'import_file_name'             => 'Popup Creative - Elementor',
			'categories'                   => array('Popups'),
			'import_file_url'            	=> $import_url . 'demo-content/popups/popup-creative-elementor.xml',
			'import_preview_image_url'     => $import_image_url.'popup-creative.webp',
			'preview_url'                  => 'https://core.pixfort.com/popup-builder/#pix_section_normal_popups',
		);
		array_push($data, $demo);
	}
	return $data;
}
