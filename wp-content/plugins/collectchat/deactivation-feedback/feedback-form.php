<?php
/**
 * Displays the content of the dialog box when the user clicks on the "Deactivate" link on the plugin settings page
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Displays a confirmation and feedback dialog box when the user clicks on the "Deactivate" link on the plugins
 * page.
 */
if ( ! function_exists( 'collectchat_add_deactivation_feedback_dialog_box' ) ) {
	function collectchat_add_deactivation_feedback_dialog_box() {
		global $collectchat_active_plugin;
		if ( empty( $collectchat_active_plugin ) ) {
			return;
		}

		$contact_support_template = __( 'Need help? We are ready to answer your questions.', 'collectchat' ) . ' <a href="https://help.collect.chat/form" target="_blank">' . __( 'Contact Support', 'collectchat' ) . '</a>';

		$reasons = array(
			array(
				'id'                => 'NOT_WORKING',
				'text'              => __( 'The plugin is not working', 'collectchat' ),
				'input_type'        => 'textarea',
				'input_placeholder' => esc_attr__( "Kindly share what didn't work so we can fix it in future updates.", 'collectchat' ),
			),
			array(
				'id'                => 'SUDDENLY_STOPPED_WORKING',
				'text'              => __( 'The plugin suddenly stopped working', 'collectchat' ),
				'input_type'        => '',
				'input_placeholder' => '',
				'internal_message'  => $contact_support_template,
			),
			array(
				'id'                => 'BROKE_MY_SITE',
				'text'              => __( 'The plugin broke my site', 'collectchat' ),
				'input_type'        => '',
				'input_placeholder' => '',
				'internal_message'  => $contact_support_template,
			),
			array(
				'id'                => 'COULDNT_MAKE_IT_WORK',
				'text'              => __( "I couldn't understand how to get it work", 'collectchat' ),
				'input_type'        => '',
				'input_placeholder' => '',
				'internal_message'  => $contact_support_template,
			),
			array(
				'id'                => 'FOUND_A_BETTER_PLUGIN',
				'text'              => __( 'I found a better plugin', 'collectchat' ),
				'input_type'        => 'textarea',
				'input_placeholder' => esc_attr__( 'Can you please name the plugin and why you liked that it more?', 'collectchat' ),
			),
			array(
				'id'                => 'GREAT_BUT_NEED_SPECIFIC_FEATURE',
				'text'              => __( "The plugin is great, but I need a specific feature", 'collectchat' ),
				'input_type'        => 'textarea',
				'input_placeholder' => esc_attr__( 'Can you share more details on the missing feature?', 'collectchat' ),
			),
			array(
				'id'                => 'TEMPORARY_DEACTIVATION',
				'text'              => __( "It's a temporary deactivation, I'm just debugging an issue", 'collectchat' ),
				'input_type'        => '',
				'input_placeholder' => '',
			),
			array(
				'id'                => 'OTHER',
				'text'              => __( 'Other', 'collectchat' ),
				'input_type'        => 'textarea',
				'input_placeholder' => '',
			),
		);

		$modal_html = '<div class="collectchat-modal collectchat-modal-deactivation-feedback">
	    	<div class="collectchat-modal-dialog">
	    		<div class="collectchat-modal-body">
	    			<h2>' . __( 'Quick Feedback', 'collectchat' ) . '</h2>
	    			<div class="collectchat-modal-panel active">
	    				<p>' . __( 'If you have a moment, please let us know why you are deactivating', 'collectchat' ) . ':</p><ul>';

		foreach ( $reasons as $reason ) {
			$list_item_classes = 'collectchat-modal-reason' . ( ! empty( $reason['input_type'] ) ? ' has-input' : '' );

			if ( ! empty( $reason['internal_message'] ) ) {
				$list_item_classes      .= ' has-internal-message';
				$reason_internal_message = $reason['internal_message'];
			} else {
				$reason_internal_message = '';
			}

			$modal_html .= '<li class="' . $list_item_classes . '" data-input-type="' . $reason['input_type'] . '" data-input-placeholder="' . $reason['input_placeholder'] . '">
				<label>
					<span>
						<input type="radio" name="selected-reason" value="' . $reason['id'] . '"/>
					</span>
					<span>' . $reason['text'] . '</span>
				</label>
				<div class="collectchat-modal-internal-message">' . $reason_internal_message . '</div>
			</li>';
		}
		$modal_html .= '</ul>
		    				<label class="collectchat-modal-anonymous-label">
			    				<input type="checkbox" checked/>' .
								__( 'Send website data and allow to contact me back', 'collectchat' ) .
							'</label>
						</div>
					</div>
					<div class="collectchat-modal-footer">
						<a href="#" class="button button-primary collectchat-modal-button-deactivate"></a>
						<div class="clear"></div>
					</div>
				</div>
			</div>';

		$script = '';

		foreach ( $collectchat_active_plugin as $basename => $plugin_data ) {

			$slug      = dirname( $basename );
			$plugin_id = sanitize_title( $plugin_data['Name'] );

			$script .= '(function($) {
					var modalHtml = ' . json_encode( $modal_html ) . ",
					    \$modal                = $( modalHtml ),
					    \$deactivateLink       = $( '#the-list .active[data-plugin=\"" . $basename . "\"] .deactivate a' ),
						\$anonymousFeedback    = \$modal.find( '.collectchat-modal-anonymous-label' ),
						selectedReasonID      = false;

					/* WP added data-plugin attr after 4.5 version/ In prev version was id attr */
					if ( 0 == \$deactivateLink.length )
						\$deactivateLink = $( '#the-list .active#" . $plugin_id . " .deactivate a' );

					\$modal.appendTo( $( 'body' ) );

					collectchatModalRegisterEventHandlers();
					
					function collectchatModalRegisterEventHandlers() {
						\$deactivateLink.click( function( evt ) {
							evt.preventDefault();

							/* Display the dialog box.*/
							collectchatModalReset();
							\$modal.addClass( 'active' );
							$( 'body' ).addClass( 'has-collectchat-modal' );
						});

						\$modal.on( 'input propertychange', '.collectchat-modal-reason-input input', function() {
							if ( ! collectchatModalIsReasonSelected( 'OTHER' ) ) {
								return;
							}

							var reason = $( this ).val().trim();

							/* If reason is not empty, remove the error-message class of the message container to change the message color back to default. */
							if ( reason.length > 0 ) {
								\$modal.find( '.message' ).removeClass( 'error-message' );
								collectchatModalEnableDeactivateButton();
							}
						});

						\$modal.on( 'blur', '.collectchat-modal-reason-input input', function() {
							var \$userReason = $( this );

							setTimeout( function() {
								if ( ! collectchatModalIsReasonSelected( 'OTHER' ) ) {
									return;
								}
							}, 150 );
						});

						\$modal.on( 'click', '.collectchat-modal-footer .button', function( evt ) {
							evt.preventDefault();

							if ( $( this ).hasClass( 'disabled' ) ) {
								return;
							}

							var _parent = $( this ).parents( '.collectchat-modal:first' ),
								_this =  $( this );

							if ( _this.hasClass( 'allow-deactivate' ) ) {
								var \$radio = \$modal.find( 'input[type=\"radio\"]:checked' );

								if ( 0 === \$radio.length ) {
									/* If no selected reason, just deactivate the plugin. */
									window.location.href = \$deactivateLink.attr( 'href' );
									return;
								}

								var \$selected_reason = \$radio.parents( 'li:first' ),
								    \$input = \$selected_reason.find( 'textarea, input[type=\"text\"]' ),
								    userReason = ( 0 !== \$input.length ) ? \$input.val().trim() : '';

								var is_anonymous = ( \$anonymousFeedback.find( 'input' ).is( ':checked' ) ) ? 0 : 1;

								$.ajax({
									url       : ajaxurl,
									method    : 'POST',
									data      : {
										'action'			: 'collectchat_submit_uninstall_reason_action',
										'plugin'			: '" . $basename . "',
										'reason_id'			: \$radio.val(),
										'reason_info'		: userReason,
										'is_anonymous'		: is_anonymous,
										'collectchat_ajax_nonce'	: '" . wp_create_nonce( 'collectchat_ajax_nonce' ) . "'
									},
									beforeSend: function() {
										_parent.find( '.collectchat-modal-footer .button' ).addClass( 'disabled' );
										_parent.find( '.collectchat-modal-footer .button-secondary' ).text( '" . __( 'Processing', 'collectchat' ) . "' + '...' );
									},
									complete  : function( message ) {
										/* Do not show the dialog box, deactivate the plugin. */
										window.location.href = \$deactivateLink.attr( 'href' );
									}
								});
							} else if ( _this.hasClass( 'collectchat-modal-button-deactivate' ) ) {
								/* Change the Deactivate button's text and show the reasons panel. */
								_parent.find( '.collectchat-modal-button-deactivate' ).addClass( 'allow-deactivate' );
								collectchatModalShowPanel();
							}
						});

						\$modal.on( 'click', 'input[type=\"radio\"]', function() {
							var \$selectedReasonOption = $( this );

							/* If the selection has not changed, do not proceed. */
							if ( selectedReasonID === \$selectedReasonOption.val() )
								return;

							selectedReasonID = \$selectedReasonOption.val();

							\$anonymousFeedback.show();

							var _parent = $( this ).parents( 'li:first' );

							\$modal.find( '.collectchat-modal-reason-input' ).remove();
							\$modal.find( '.collectchat-modal-internal-message' ).hide();
							\$modal.find( '.collectchat-modal-button-deactivate' ).text( '" . __( 'Submit and Deactivate', 'collectchat' ) . "' );

							collectchatModalEnableDeactivateButton();

							if ( _parent.hasClass( 'has-internal-message' ) ) {
								_parent.find( '.collectchat-modal-internal-message' ).show();
							}

							if (_parent.hasClass('has-input')) {
								var reasonInputHtml = '<div class=\"collectchat-modal-reason-input\"><span class=\"message\"></span>' + ( ( 'textfield' === _parent.data( 'input-type' ) ) ? '<input type=\"text\" />' : '<textarea rows=\"5\" maxlength=\"200\"></textarea>' ) + '</div>';

								_parent.append( $( reasonInputHtml ) );
								_parent.find( 'input, textarea' ).attr( 'placeholder', _parent.data( 'input-placeholder' ) ).focus();

								if ( collectchatModalIsReasonSelected( 'OTHER' ) ) {
									\$modal.find( '.message' ).text( '" . __( 'Please tell us the reason so we can improve it.', 'collectchat' ) . "' ).show();
								}
							}
						});

						/* If the user has clicked outside the window, cancel it. */
						\$modal.on( 'click', function( evt ) {
							var \$target = $( evt.target );

							/* If the user has clicked anywhere in the modal dialog, just return. */
							if ( \$target.hasClass( 'collectchat-modal-body' ) || \$target.hasClass( 'collectchat-modal-footer' ) ) {
								return;
							}

							/* If the user has not clicked the close button and the clicked element is inside the modal dialog, just return. */
							if ( ! \$target.hasClass( 'collectchat-modal-button-close' ) && ( \$target.parents( '.collectchat-modal-body' ).length > 0 || \$target.parents( '.collectchat-modal-footer' ).length > 0 ) ) {
								return;
							}

							/* Close the modal dialog */
							\$modal.removeClass( 'active' );
							$( 'body' ).removeClass( 'has-collectchat-modal' );

							return false;
						});
					}

					function collectchatModalIsReasonSelected( reasonID ) {
						/* Get the selected radio input element.*/
						return ( reasonID == \$modal.find('input[type=\"radio\"]:checked').val() );
					}

					function collectchatModalReset() {
						selectedReasonID = false;

						collectchatModalEnableDeactivateButton();

						/* Uncheck all radio buttons.*/
						\$modal.find( 'input[type=\"radio\"]' ).prop( 'checked', false );

						/* Remove all input fields ( textfield, textarea ).*/
						\$modal.find( '.collectchat-modal-reason-input' ).remove();

						\$modal.find( '.message' ).hide();

						/* Hide, since by default there is no selected reason.*/
						\$anonymousFeedback.hide();

						var \$deactivateButton = \$modal.find( '.collectchat-modal-button-deactivate' );

						\$deactivateButton.addClass( 'allow-deactivate' );
						collectchatModalShowPanel();
					}

					function collectchatModalEnableDeactivateButton() {
						\$modal.find( '.collectchat-modal-button-deactivate' ).removeClass( 'disabled' );
					}

					function collectchatModalDisableDeactivateButton() {
						\$modal.find( '.collectchat-modal-button-deactivate' ).addClass( 'disabled' );
					}

					function collectchatModalShowPanel() {
						\$modal.find( '.collectchat-modal-panel' ).addClass( 'active' );
						/* Update the deactivate button's text */
						\$modal.find( '.collectchat-modal-button-deactivate' ).text( '" . __( 'Skip and Deactivate', 'collectchat' ) . "' );
					}
				})(jQuery);";
		}

		/* add script in FOOTER */
		wp_register_script( 'collectchat-deactivation-feedback-dialog-boxes', '', array( 'jquery' ), false, true );
		wp_enqueue_script( 'collectchat-deactivation-feedback-dialog-boxes' );
		wp_add_inline_script( 'collectchat-deactivation-feedback-dialog-boxes', sprintf( $script ) );
	}
}

/**
 * Called after the user has submitted his reason for deactivating the plugin.
 *
 * @since  2.1.3
 */
if ( ! function_exists( 'collectchat_submit_uninstall_reason_action' ) ) {
	function collectchat_submit_uninstall_reason_action() {
		global $collectchat_options, $wp_version, $collectchat_active_plugin, $current_user;

		wp_verify_nonce( $_REQUEST['collectchat_ajax_nonce'], 'collectchat_ajax_nonce' );

		$reason_id = isset( $_REQUEST['reason_id'] ) ? stripcslashes( sanitize_text_field( $_REQUEST['reason_id'] ) ) : '';
		$basename  = isset( $_REQUEST['plugin'] ) ? stripcslashes( sanitize_text_field( $_REQUEST['plugin'] ) ) : '';

		if ( empty( $reason_id ) || empty( $basename ) ) {
			exit;
		}

		$reason_info = isset( $_REQUEST['reason_info'] ) ? stripcslashes( sanitize_textarea_field( $_REQUEST['reason_info'] ) ) : '';
		if ( ! empty( $reason_info ) ) {
			$reason_info = substr( $reason_info, 0, 255 );
		}
		$is_anonymous = isset( $_REQUEST['is_anonymous'] ) && 1 == $_REQUEST['is_anonymous'];

		$options = array(
			'product'     =>'WP_PLUGIN',
			'reason_id'   => $reason_id,
			'reason_info' => $reason_info,
		);

		if ( ! $is_anonymous ) {
			if ( ! isset( $collectchat_settings ) ) {
				$collectchat_settings = ( is_multisite() ) ? get_site_option( 'collectchat_settings' ) : get_option( 'collectchat_settings' );
			}

			$options['url']                  = get_bloginfo( 'url' );
			$options['wp_version']           = $wp_version;
			$options['plugin_version']              = $collectchat_active_plugin[ $basename ]['Version'];

			$options['email'] = $current_user->data->user_email;
		}

		/* send data */
		$raw_response = wp_remote_post(
			'https://dashboard.collect.chat/wordpress-churn',
			array(
				'method'  => 'POST',
				'body'    => $options,
				'timeout' => 15,
			)
		);

		if ( ! is_wp_error( $raw_response ) && 200 == wp_remote_retrieve_response_code( $raw_response ) ) {
			if ( ! $is_anonymous ) {
				$response = maybe_unserialize( wp_remote_retrieve_body( $raw_response ) );
			}
			echo 'done';
		} else {
			echo $response->get_error_code() . ': ' . $response->get_error_message();
		}
		exit;
	}
}

add_action( 'wp_ajax_collectchat_submit_uninstall_reason_action', 'collectchat_submit_uninstall_reason_action' );
