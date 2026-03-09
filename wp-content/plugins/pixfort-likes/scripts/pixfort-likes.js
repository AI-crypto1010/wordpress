jQuery(function ($) {
		$('.pixfort-likes-count').each(function (i, elem) {
				var count = $(elem).data('count');
				if (!count) count = 0;
				od = new Odometer({
						el: elem,
						duration: 500,
				});
				od.update(count);
		});

		$('body').on('click', '.pixfort-likes', function (e) {
				var link = $(this);

				if (link.hasClass('pix-waiting')) return false;
				link.addClass('pix-waiting');

				var id = $(this).attr('id'),
						postfix = link.find('.pixfort-likes-postfix').text();

				$.ajax({
						type: 'POST',
						url: pixfort_likes.ajaxurl,
						data: {
								action: 'pixfort-likes',
								likes_id: id,
								postfix: postfix,
						},
						xhrFields: {
								withCredentials: true,
						},
						dataType: 'JSON',
						success: function (data) {
								link.find('.pixfort-likes-icon').html(data.icon);
								if (data.action == 'like') {
										link.find('.pixfort-likes-small').addClass(
												'pixfort-likes-liked'
										);
								} else {
										link.find('.pixfort-likes-small').removeClass(
												'pixfort-likes-liked'
										);
								}
								var el = link.find('.pixfort-likes-count')[0];
								od = new Odometer({
										el: el,
										duration: 500,
								});
								od.update(data.count);
								link.removeClass('pix-waiting');
						},
				});

				return false;
		});
		
		if ($('body.ajax-pixfort-likes').length) {
				$('.pixfort-likes').each(function () {
						let $this = $(this);
						var id = $(this).attr('id');
						$(this).load(
								pixfort_likes.ajaxurl,
								{
										action: 'pixfort-likes',
										post_id: id,
								},
								function () {
										var el = $this.find('.pixfort-likes-count')[0];
										let elCount = $(el).attr('data-count');
										od = new Odometer({
												el: el,
												duration: 500,
										});
										od.update(elCount);
								}
						);
				});
		}
});