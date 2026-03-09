(function($) {
	function toggleCollapse($button, target) {
		let $collapseElement = $(target);

		if ($collapseElement.hasClass('show')) {
			$collapseElement.css('height', $collapseElement[0].scrollHeight + 'px');
			$collapseElement[0].offsetHeight; // Force reflow
			$collapseElement.css('height', '0');

			$collapseElement.addClass('collapsing');

			$collapseElement.one('transitionend', function () {
				$collapseElement.removeClass('collapsing').addClass('collapse');
				// $collapseElement.css('height', '');
				$collapseElement.removeClass('show');
			});
			$button.attr('aria-expanded', false);
			// if($button.hasClass('hamburger')) {
			// 	$button.removeClass('is-active');
			// }
		} else {
			let $accordion = $button.closest('.accordion');
			setTimeout(function () {
				$accordion.find('.collapse.show').each(function () {
					let $otherCollapse = $(this);
					$otherCollapse.css('height', $otherCollapse[0].scrollHeight + 'px');
					$otherCollapse[0].offsetHeight; // Force reflow
					$otherCollapse.css('height', '0');

					$otherCollapse.addClass('collapsing');

					$otherCollapse.one('transitionend', function () {
						$otherCollapse.removeClass('collapsing').addClass('collapse');
						$otherCollapse.css('height', '');
						$otherCollapse.removeClass('show');
					});
				});
			}, 10);

			// $collapseElement.removeClass('collapse').addClass('collapsing').css('display', 'block');
			$collapseElement.removeClass('collapse').addClass('collapsing');
			$collapseElement.css('height', '0');

			setTimeout(function () {
				$collapseElement.css('height', $collapseElement[0].scrollHeight + 'px');
			}, 10);
			$collapseElement.one('transitionend', function () {
				$collapseElement.css('height', '');
				$collapseElement.removeClass('collapsing').addClass('collapse show');
			});
			$button.attr('aria-expanded', true);
			// if($button.hasClass('hamburger')) {
			// 	$button.addClass('is-active');
			// }
		}

		// $button.attr('aria-expanded', $collapseElement.hasClass('show'));
	}

	// Add click event listeners to buttons with data-toggle="collapse"
    $('body').on('click', '[data-toggle="collapse"]', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		let target = $(this).attr('data-target');
		toggleCollapse($(this), target);
	});

	// Handle transition for already open collapsible elements
	$('.collapse.show').each(function () {
		let $collapseElement = $(this);
		$collapseElement.css('height', $collapseElement[0].scrollHeight + 'px');
	});




    $('.pix-nav-link.dropdown-toggle.nav-link, .menu-item.menu-item-has-children.dropdown.nav-item > a').unbind('click');
	$('.pix-nav-link.dropdown-toggle.nav-link, .menu-item.menu-item-has-children.dropdown.nav-item > a').on('click', function (e) {
        
		if ($(this).attr('href')) {
			let link = $(this).attr('href');
			let target = $(this).attr('target');
			if (link) {
				if (link.indexOf('#pix_section') == -1 && !link.startsWith('#')) {
					if (!$(this).hasClass('pix-item-clicked') && window.innerWidth < 992) {
                        e.preventDefault();
                        e.stopPropagation();
						$('.pix-item-clicked').removeClass('pix-item-clicked');
						$(this).addClass('pix-item-clicked');
                        $(this).closest('.menu-item.dropdown.nav-item').find('> .dropdown-menu').toggleClass('show');
                        return false;
					} else {
						if (target == '_blank') {
							e.preventDefault();
							e.stopPropagation();
							window.open(link);
							return false;
						} else {
							window.location = link;
						}
					}
				} else {
					if (window.innerWidth < 992) {
						if (!$(this).hasClass('pix-item-clicked')) {
							e.preventDefault();
							e.stopPropagation();
							$('.pix-item-clicked').removeClass('pix-item-clicked');
							$(this).addClass('pix-item-clicked');
							$(this).closest('.menu-item.dropdown.nav-item').find('> .dropdown-menu').toggleClass('show');
							return false;
						} else {
							if (link === '#') {
								e.preventDefault();
								e.stopPropagation();
								$(this).removeClass('pix-item-clicked');
								$(this).closest('.menu-item.dropdown.nav-item').find('> .dropdown-menu').toggleClass('show');
								return false;
							}
						}
					}
                    
				}
			}
		}

	});
})(jQuery);