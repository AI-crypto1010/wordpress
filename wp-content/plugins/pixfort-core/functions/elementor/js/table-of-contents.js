jQuery(window).on('elementor/frontend/init', () => {
	const addHandler = ($element) => {		
		if (typeof window.pixfort_toc === 'function') {
			// Re-initialize the TOC
			window.pixfort_toc($element);
		}
	};

	elementorFrontend.hooks.addAction(
		'frontend/element_ready/pix-table-of-contents.default',
		addHandler
	);
});
