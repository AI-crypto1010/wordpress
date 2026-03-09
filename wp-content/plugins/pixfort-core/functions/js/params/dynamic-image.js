!function ($) {
	const imageKeyLabels = {
		post_featured_image: 'Featured Image',
		category_image: 'Category Image',
		author_profile_picture: 'Author Profile Picture',
		acf_image: 'ACF Image'
	};

	const unescapeVcValue = (value) => {
		if (!value) return '';
		return String(value)
			.replace(/`{`/g, '[')
			.replace(/`}`/g, ']')
			.replace(/``/g, '"')
			.replace(/&quot;/g, '"');
	};

	const parseStoredValue = (value) => {
		if (!value) return null;
		if (typeof value !== 'string') return null;
		const trimmed = unescapeVcValue(value).trim();
		if (!trimmed) return null;
		if (trimmed[0] === '{') {
			try {
				const parsed = JSON.parse(trimmed);
				if (parsed && parsed.key) return parsed;
			} catch (e) {}
		}
		const match = trimmed.match(/key="([^"]+)"/i);
		if (match) {
			return { key: match[1], label: '' };
		}
		return null;
	};

	const humanizeKey = (key) => {
		if (!key) return '';
		return key
			.replace(/_/g, ' ')
			.replace(/\b\w/g, (char) => char.toUpperCase());
	};

	const getLabelFromValue = (value) => {
		const parsed = parseStoredValue(value);
		if (!parsed || !parsed.key) return '';
		if (parsed.label) return parsed.label;
		return imageKeyLabels[parsed.key] || humanizeKey(parsed.key);
	};

	const updateDisplay = ($block) => {
		const $input = $block.find('.pix_param_val');
		const value = $input.val();
		const $selected = $block.find('.pix-dynamic-image-selected');
		const emptyLabel = $selected.data('empty-label') || 'No selection';
		const $label = $block.find('.pix-dynamic-image-label');

		if (value) {
			const storedLabel = $block.data('selected-label') || '';
			const label = storedLabel || getLabelFromValue(value) || emptyLabel;
			$label.text(label);
			$block.addClass('has-selection');
		} else {
			$label.text(emptyLabel);
			$block.removeClass('has-selection');
		}
	};

	const openPicker = ($block) => {
		const input = $block.find('.pix_param_val').get(0);
		if (!window.pixDynamicOpenPicker) return;

		window.pixDynamicOpenPicker(input, {
			keyFilter: 'image',
			onSelect: (data) => {
				if (!data || !data.key) return;
				const payload = {
					key: data.key,
					label: data.label || '',
					options: data.options || {}
				};
				$block.data('selected-label', payload.label || '');
				$(input).val(JSON.stringify(payload));
				$(input).trigger('change');
				updateDisplay($block);
			}
		});
	};

	$('body').on('click', '.pix-dynamic-image-trigger', function (event) {
		event.preventDefault();
		openPicker($(this).closest('.pix-dynamic-image-param'));
	});

	$('body').on('click', '.pix-dynamic-image-selected', function (event) {
		if ($(event.target).closest('.pix-dynamic-image-clear').length) return;
		openPicker($(this).closest('.pix-dynamic-image-param'));
	});

	$('body').on('click', '.pix-dynamic-image-clear', function (event) {
		event.preventDefault();
		const $block = $(this).closest('.pix-dynamic-image-param');
		const $input = $block.find('.pix_param_val');
		$block.data('selected-label', '');
		$input.val('');
		$input.trigger('change');
		updateDisplay($block);
	});

	$('body').on('change input', '.pix-dynamic-image-param .pix_param_val', function () {
		updateDisplay($(this).closest('.pix-dynamic-image-param'));
	});

	$(function () {
		$('.pix-dynamic-image-param').each(function () {
			updateDisplay($(this));
		});
	});
}(window.jQuery);
