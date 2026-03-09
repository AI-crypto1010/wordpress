<?php

/*
    *   API Keys
    */
	$pixfortBuilder->addOption(
		'google-api-key',
		[
			'type' => 'text',
			'label' => __('Google API Key', 'pixfort-core'),
			'tab'             => 'apiKeys',
			'description' => __('Google API Key is required for Google Maps elements.', 'pixfort-core'),
			'tooltipText'     => __('For detailed information about setting up Google maps check this article from our knowledge base: ', 'pixfort-core') . '<br/><a target="_blank" href="'.\PixfortCore::instance()->adminCore->getParam('docs_google_maps').'" target="_blank" class="text-primary font-semibold">'.\PixfortCore::instance()->adminCore->getParam('docs_google_maps').'</a>',
			'hideBorderBottom'   => true,
			'placeholder'		 => 'Google API Key'
		]
	);