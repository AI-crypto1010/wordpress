window.headerScrollPreview = (isScroll = false) => {
    
	if ($('.header-preview').length) return;
	const adminBarHeight = $('#wpadminbar').length && window.innerWidth > 600 ? $('#wpadminbar').outerHeight() : 0;
	const stickyAreas = [];
	let lastScrollTop = $(window).scrollTop();
	let adjustTop = 0;

	/*
	 *  Boxed Header related variables
	 */
	let isTopbarTransparent = !!$('.pix-transparent-topbar').length;
	let isTopbarVisibleSticky = false;
	if($('[data-area="topbar"].is-sticky').length){
		isTopbarVisibleSticky = true;
	}
	/*
	 * End boxed header variables
	 */

	$('.is-sticky, .is-smart-sticky').each(function () {
		const $this = $(this);
		const areaHeight = $this.outerHeight();
		const placeholder = $('<div></div>').css({
			width: $this.outerWidth(),
			height: areaHeight,
			display: 'none'
		});
		$this.after(placeholder);
		let initialTop = $this.offset().top;
		let marginTop = 0;
		let isMobile = false;
		if ($this.hasClass('pix-header-mobile')) {
			isMobile = true;
		}

		/*
		*  Boxed Header related functions
		*/
		if ($this.hasClass('pix-header-box-1')) {
			initialTop -= 20;
			marginTop = 20;
			if (initialTop < 0) {
				initialTop = 0;
			}
			if($('[data-area="topbar"].is-sticky').length && $this.hasClass('pix-transparent-topbar')){
				marginTop = 0;
			} else {
				if (!$this.hasClass('pix-no-topbar')) {
					$this.addClass('pix-with-topbar');
				}
			}
		}
		/*
		* End boxed header functions
		*/
		stickyAreas.push({
			element: $this,
			placeholder: placeholder,
			initialTop,
			marginTop,
			isMobile,
			height: areaHeight,
			isSticky: false,
			isSmartSticky: $this.hasClass('is-smart-sticky'),
			name: $this.attr('data-area'),
			isVisible: true
		});
	});
	// console.log(stickyAreas);
	
	function updateStickyPositions() {
		let offsetTop = adminBarHeight;
		const scrollTop = $(window).scrollTop();
		const scrollingDown = scrollTop > lastScrollTop;
	
		stickyAreas.forEach((area) => {
			if (window.innerWidth < PIX_JS_OPTIONS.mobileBreakPoint) {
				if (!area.isMobile) return;
			} else {
				if (area.isMobile) return;
			}
			// let shouldBeSticky = scrollTop + offsetTop > area.initialTop;
			let shouldBeSticky = isScroll;
			// const shouldBeSmartSticky = scrollTop + offsetTop  > area.initialTop + area.height + area.marginTop;
			const shouldBeSmartSticky = false;
			// if(!area.isSticky){
			// 	if(area.isSmartSticky){
			// 		shouldBeSticky = scrollTop + offsetTop > area.initialTop + area.marginTop + 200;
			// 	}
			// }
			// if(area.name === 'header'){
			// 	console.log({shouldBeSticky, shouldBeSmartSticky});
			// }
			
			if (shouldBeSmartSticky && area.isSmartSticky) {
				if (scrollingDown) {
					if (area.isVisible) {
						area.element.attr('data-visible', 'false');
						area.isVisible = false;
						if(area.name === 'topbar'){
							isTopbarVisibleSticky = false;
						}
					}
				} else {
					if (!area.isVisible) {
						area.element.attr('data-visible', 'sticky');
						area.isVisible = true;
						if(area.name === 'topbar'){
							isTopbarVisibleSticky = true;
						}
					}
				}
			}
			if (shouldBeSticky && !area.isSticky) {
				let index = stickyAreas.indexOf(area);
				index = 2000 - index;
				// if(area.isSmartSticky){
				// 	index = 1000 - index;
				// } else {
				// 	index = 2000 - index;
				// }
				area.element.addClass('is-scroll');
				area.element.css({
					position: 'fixed',
					top: offsetTop,
					zIndex: index
				});

				area.placeholder.show();
				area.isSticky = true;
				if (area.isVisible) {
					offsetTop += area.element.outerHeight();
					if(area.marginTop && (!isTopbarTransparent || !isTopbarVisibleSticky) ){
						offsetTop += area.marginTop;
					}
				}
			} else if (!shouldBeSticky && area.isSticky) {
				area.placeholder.hide();
				area.element.removeClass('is-scroll');
				area.element.css({
					position: '',
					top: '',
					// zIndex: ''
				});
				area.isSticky = false;
			} else if (shouldBeSticky && area.isVisible) {
				area.element.css({
					top: offsetTop
				});
				offsetTop += area.element.outerHeight();
				if(area.marginTop && (!isTopbarTransparent || !isTopbarVisibleSticky) ){
					offsetTop += area.marginTop;
				}
			} else if (shouldBeSticky && !area.isVisible) {
				area.element.css({
					top: offsetTop
				});
			}
		});

		lastScrollTop = scrollTop;
		if (offsetTop + 20 !== adjustTop) {
			adjustTop = offsetTop + 20;
			$('.pix-sticky-top-adjust').css({ top: adjustTop });
		}
	}

	updateStickyPositions();
	$(window).on('scroll resize', updateStickyPositions);
	// $(window).on('scroll', updateStickyPositions);

	/*
	 * Header placeholder
	 */
	if ($('.pix-header-transparent, .pix-header-boxed').length > 0) {
		if($('.pix-main-intro-placeholder').height() < 1){
			let tran_height = $('[data-area="header"]').height();
			if ($('[data-area="topbar"]').length) tran_height += $('[data-area="topbar"]').height();
			if ($('[data-area="stack"]').length) tran_height += $('[data-area="stack"]').height();
			$('.pix-main-intro-placeholder').addClass('d-block w-100').height(tran_height);
			$('.pix-main-intro-placeholder').css('min-height', 'auto');
		}
	}
}

