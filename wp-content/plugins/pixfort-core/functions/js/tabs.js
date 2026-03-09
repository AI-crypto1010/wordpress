(function ( $ ) {
	'use strict';

	window.InlineShortcodeView_pix_tabs = window.InlineShortcodeView_vc_tta_accordion.extend( {
		render: function () {
			window.InlineShortcodeView_pix_tabs.__super__.render.call( this );
			_.bindAll( this, 'buildSortableNavigation', 'updateSortingNavigation' );
			this.createTabs();
			_.defer( this.buildSortableNavigation );
			return this;
		},
		createTabs: function () {
			var models = _.sortBy( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
				function ( model ) {
					return model.get( 'order' );
				} );
			_.each( models, function ( model ) {
				this.sectionUpdated( model, true );
			}, this );
		},
		defaultSectionTitle: window.i18nLocale.tab,
		addIcon: function ( model, html ) {
			var icon, icon_class, icon_html;
			if ( 'true' === model.getParam( 'add_icon' ) ) {
				icon = model.getParam( 'i_icon_' + model.getParam( 'i_type' ) );
				if ( !_.isUndefined( icon ) ) {
					icon_class = 'vc_tta-icon' + ' ' + icon;
					icon_html = '<i class="' + icon_class + '"></i>';
				}
				if ( 'right' === model.getParam( 'i_position' ) ) {
					html += icon_html;
				} else {
					html = icon_html + html;
				}
			}
			return html;
		},
		/**
		 *
		 * @param {Backbone.Model}model
		 */
		sectionUpdated: function ( model, justAppend ) {
			// update build tabs, remove/add check orders and title/target

			var $tabEl,
				$navigation,
				sectionId,
				html, title, models, index, tabAdded;
			tabAdded = false;
			sectionId = model.get( 'id' );
			$navigation = this.$el.find( '.vc_tta-tabs-container .vc_tta-tabs-list' );
			$tabEl = $navigation.find( '[data-vc-target="[data-model-id=' + sectionId + ']"]' );
			title = model.getParam( 'title' );

			if ( $tabEl.length ) {
				html = '<span class="vc_tta-title-text">' + title + '</span>';
				html = this.addIcon( model, html );

				$tabEl.html( html );
			} else {
				var $element;
				html = '<span class="vc_tta-title-text">' + title + '</span>';

				html = this.addIcon( model, html );
				$element = $( '<li class="vc_tta-tab" data-vc-target-model-id="' + sectionId + '" data-vc-tab><a href="javascript:;" data-vc-use-cache="false" data-vc-tabs data-vc-target="[data-model-id=' + sectionId + ']" data-vc-container=".vc_tta">' + html + '</a></li>' );
				if ( true !== justAppend ) {
					models = _.pluck( _.sortBy( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
						function ( childModel ) {
							return childModel.get( 'order' );
						} ), 'id' );
					index = models.indexOf( model.get( 'id' ) ) - 1;
					if ( index > - 1 && $navigation.find( '[data-vc-tab]:eq(' + index + ')' ).length ) {
						$element.insertAfter( $navigation.find( '[data-vc-tab]:eq(' + index + ')' ) );
						tabAdded = true;
					}
				}
				if ( !tabAdded ) {
					$element.appendTo( $navigation );
				}
				if ( model.get( 'isActiveSection' ) ) {
					$element.addClass( this.activeClass );
				}
			}
			this.buildPagination();
		},
		getNextTab: function ( $viewTab ) {
			var lastIndex, viewTabIndex, $nextTab, $navigationSections;

			$navigationSections = this.$el.find( '.vc_tta-tabs-container .vc_tta-tabs-list' ).children();
			lastIndex = $navigationSections.length - 1; // -1 because length starts from 1
			viewTabIndex = $viewTab.index();

			if ( viewTabIndex !== lastIndex ) {
				$nextTab = $navigationSections.eq( viewTabIndex + 1 );
			} else {
				// If we are the last tab in in navigation lets make active previous
				$nextTab = $navigationSections.eq( viewTabIndex - 1 );
			}
			return $nextTab;
		},
		removeSection: function ( modelId ) {
			var $viewTab, $nextTab, tabIsActive;

			$viewTab = this.$el.find( '.vc_tta-tabs-container .vc_tta-tabs-list [data-vc-target="[data-model-id=' + modelId + ']"]' ).parent();
			tabIsActive = $viewTab.hasClass( this.activeClass );

			// Make next tab active if needed
			if ( tabIsActive ) {
				$nextTab = this.getNextTab( $viewTab );
				vc.frame_window.jQuery( $nextTab ).find( '[data-vc-target]' ).trigger( 'click' );
			}
			// Remove tab from navigation
			$viewTab.remove();
			this.buildPagination();
		},
		buildSortableNavigation: function () {
			if ( !vc_user_access().shortcodeEdit( this.model.get( 'shortcode' ) ) ) {
				return;
			}
			// this should be called when new tab added/removed/changed.
			this.$el.find( '.vc_tta-tabs-container .vc_tta-tabs-list' ).sortable( {
				items: '.vc_tta-tab',
				forcePlaceholderSize: true,
				placeholder: 'vc_tta-tab vc_placeholder-tta-tab',
				helper: this.renderSortingHelper,
				start: function ( event, ui ) {
					ui.placeholder.width( ui.item.width() );
				},
				over: function ( event, ui ) {
					ui.placeholder.css( { maxWidth: ui.placeholder.parent().width() } );
					ui.placeholder.removeClass( 'vc_hidden-placeholder' );
				},
				update: this.updateSortingNavigation
			} );
		},
		updateSorting: function ( event, ui ) {
			window.InlineShortcodeView_pix_tabs.__super__.updateSorting.call( this, event, ui );
			this.updateTabsPositions( this.getPanelsList() );
		},
		updateSortingNavigation: function () {
			var $tabs, self;
			self = this;
			$tabs = this.$el.find( '.vc_tta-tabs-list' );
			// we are sorting a tabs navigation
			$tabs.find( '> .vc_tta-tab' ).each( function () {
				var shortcode, modelId, $li;

				$li = $( this ).removeAttr( 'style' ); // TODO: Attensiton maybe e need to create method with filter
				modelId = $li.data( 'vcTargetModelId' );
				shortcode = vc.shortcodes.get( modelId );
				shortcode.save( { 'order': self.getIndex( $li ) }, { silent: true } );
				// now we need to sort panels
			} );
			this.updatePanelsPositions( $tabs );
		},
		updateTabsPositions: function ( $panels ) {
			var $tabs, $elements, tabSortableData;
			$tabs = this.$el.find( '.vc_tta-tabs-list' );
			if ( $tabs.length ) {
				$elements = [];
				tabSortableData = $panels.sortable( 'toArray', { attribute: 'data-model-id' } );
				_.each( tabSortableData, function ( value ) {
					$elements.push( $tabs.find( '[data-vc-target-model-id="' + value + '"]' ) );
				}, this );
				$tabs.prepend( $elements );
			}
			this.buildPagination();
		},
		updatePanelsPositions: function ( $tabs ) {
			var $elements, tabSortableData, $panels;
			$panels = this.getPanelsList();
			$elements = [];
			tabSortableData = $tabs.sortable( 'toArray', { attribute: 'data-vc-target-model-id' } );
			_.each( tabSortableData, function ( value ) {
				$elements.push( $panels.find( '[data-model-id="' + value + '"]' ) );
			}, this );
			$panels.prepend( $elements );
			this.buildPagination();
		},
		renderSortingHelper: function ( event, currentItem ) {
			var helper, currentItemWidth, currentItemHeight;
			helper = currentItem;
			currentItemWidth = currentItem.width() + 1;
			currentItemHeight = currentItem.height();
			helper.width( currentItemWidth );
			helper.height( currentItemHeight );
			return helper;
		},
		buildPagination: function () {
			var params;
			this.removePagination();
			// If tap-pos top append:
			params = this.model.get( 'params' );
			if ( !_.isUndefined( params.pagination_style ) && params.pagination_style.length ) {
				if ( 'top' === params.tab_position ) {
					this.$el.find( '.vc_tta-panels-container' ).append( this.getPaginationList() );
				} else {
					this.getPaginationList().insertBefore( this.$el.find( '.vc_tta-container .vc_tta-panels' ) );
				}
			}
		}
	} );
})( window.jQuery );





(function () {
	'use strict';

	function ttaMapChildEvents( model ) {
		var child_tag = 'vc_tta_section';
		window.vc.events.on(
			'shortcodes:' + child_tag + ':add:parent:' + model.get( 'id' ),
			function ( model ) {
				var active_tab_index, models, parent_model;
				parent_model = window.vc.shortcodes.get( model.get( 'parent_id' ) );
				active_tab_index = parseInt( parent_model.getParam( 'active_section' ), 10 );
				if ( 'undefined' === typeof (active_tab_index) ) {
					active_tab_index = 1;
				}
				models = _.pluck( _.sortBy( window.vc.shortcodes.where( { parent_id: parent_model.get( 'id' ) } ),
					function ( model ) {
						return model.get( 'order' );
					} ), 'id' );
				if ( models.indexOf( model.get( 'id' ) ) === active_tab_index - 1 ) {
					model.set( 'isActiveSection', true );
				}
				return model;
			}
		);
		window.vc.events.on(
			'shortcodes:' + child_tag + ':clone:parent:' + model.get( 'id' ),
			function ( model ) {
				if ( window.vc.ttaSectionActivateOnClone ) {
					model.set( 'isActiveSection', true );
				}
				window.vc.ttaSectionActivateOnClone = false;
			}
		);
	}
	window.vc.events.on( 'shortcodes:vc_tta_accordion:add', ttaMapChildEvents );
	window.vc.events.on( 'shortcodes:pix_tabs:add', ttaMapChildEvents );
	window.vc.events.on( 'shortcodes:vc_tta_tour:add', ttaMapChildEvents );
	window.vc.events.on( 'shortcodes:vc_tta_pageable:add', ttaMapChildEvents );
})();
