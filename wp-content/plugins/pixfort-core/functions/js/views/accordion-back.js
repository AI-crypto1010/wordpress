(function ( $ ) {
	'use strict';


	if(vc.shortcode_view){
	    window.VcBackendTtaViewInterfacePixfortAcc = vc.shortcode_view.extend({
	            sortableSelector: !1,
	            $sortable: !1,
	            $navigation: !1,
	            defaultSectionTitle: window.i18nLocale.tab,
	            sortableUpdateModelIdSelector: "data-vc-target-model-id",
	            activeClass: "vc_active",
	            sortingPlaceholder: "vc_placeholder",
	            events: {vc_control column_delete
	                "click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
	                "click > .vc_controls .vc_control-btn-edit": "editElement",
	                "click > .vc_controls .column_edit": "editElement",
	                "click > .vc_controls .vc_control-btn-clone": "clone",
	                "click > .vc_controls .column_clone": "clone",
	                "click > .vc_controls .vc_control-btn-prepend": "clickPrependSection",
	                "click > .vc_controls .column_add": "clickPrependSection",
	                "click .vc_tta-section-append": "clickAppendSection"
	            },
	            initialize: function(params) {
	                window.VcBackendTtaViewInterfacePixfortAcc.__super__.initialize.call(this, params), _.bindAll(this, "updateSorting")
	            },
	            render: function() {
	                return window.VcBackendTtaViewInterfacePixfortAcc.__super__.render.call(this), this.$el.addClass("vc_tta-container vc_tta-o-non-responsive"), this
	            },
	            setContent: function() {
	                this.$content = this.$el.find("> .wpb_element_wrapper .vc_tta-panels")
	            },
	            clickAppendSection: function(e) {
	                e && e.preventDefault && e.preventDefault(), this.addSection()
	            },
	            clickPrependSection: function(e) {
	                e && e.preventDefault && e.preventDefault(), this.addSection(!0)
	            },
	            addSection: function(prepend) {
	                var params = {
	                    shortcode: "pix_accordion_tab",
	                    params: {
	                        title: this.defaultSectionTitle
	                    },
	                    parent_id: this.model.get("id"),
	                    order: _.isBoolean(prepend) && prepend ? vc.add_element_block_view.getFirstPositionIndex() : vc.shortcodes.getNextOrder(),
	                    prepend: prepend
	                };
	                return vc.shortcodes.create(params)
	            },
	            findSection: function(modelId) {
	                return this.$content.children('[data-model-id="' + modelId + '"]')
	            },
	            getIndex: function($element) {
	                return $element.index()
	            },
	            buildSortable: function($element) {
	                return !("edit" === vc_user_access().getState("shortcodes") || !vc_user_access().shortcodeAll("pix_accordion_tab")) && $element.sortable({
	                    forcePlaceholderSize: !0,
	                    placeholder: this.sortingPlaceholder,
	                    helper: this.renderSortingPlaceholder,
	                    scroll: !0,
	                    cursor: "move",
	                    cursorAt: {
	                        top: 20,
	                        left: 16
	                    },
	                    start: function(event, ui) {},
	                    over: function(event, ui) {},
	                    stop: function(event, ui) {
	                        ui.item.attr("style", "")
	                    },
	                    update: this.updateSorting,
	                    items: this.sortableSelector
	                })
	            },
	            updateSorting: function(event, ui) {
	                var self;
	                if (!vc_user_access().shortcodeAll("pix_accordion_tab")) return !1;
	                (self = this).$sortable.find(this.sortableSelector).each(function() {
	                    var $this = $(this),
	                        modelId = $this.attr(self.sortableUpdateModelIdSelector),
	                        shortcode = vc.shortcodes.get(modelId);
	                    vc.storage.lock(), shortcode.save({
	                        order: self.getIndex($this)
	                    })
	                }), vc.storage.unlock(), vc.storage.save()
	            },
	            makeFirstSectionActive: function() {
	                this.$content.children(":first-child").addClass(this.activeClass)
	            },
	            checkForActiveSection: function() {
	                this.$content.children("." + this.activeClass).length || this.makeFirstSectionActive()
	            },
	            changeActiveSection: function(modelId) {
	                this.$content.children(".vc_tta-panel." + this.activeClass).removeClass(this.activeClass), this.findSection(modelId).addClass(this.activeClass)
	            },
	            changedContent: function(view) {
	                var changedContent = window.VcBackendTtaViewInterfacePixfortAcc.__super__.changedContent.call(this, view);
	                return this.checkForActiveSection(), this.buildSortable(this.$sortable), changedContent
	            },
	            notifySectionChanged: function(model) {
	                var title, view = model.get("view");
	                _.isObject(view) && (title = model.getParam("title"), _.isString(title) && title.length || (title = this.defaultSectionTitle), view.$el.find(".vc_tta-panel-title a .vc_tta-title-text").text(title))
	            },
	            notifySectionRendered: function(model) {},
	            getNextTab: function($viewTab) {
	                var $navigationSections = this.$navigation.children(),
	                    lastIndex = $navigationSections.length - 2,
	                    viewTabIndex = $viewTab.index(),
	                    $nextTab = viewTabIndex !== lastIndex ? $navigationSections.eq(viewTabIndex + 1) : $navigationSections.eq(viewTabIndex - 1);
	                return $nextTab
	            },
	            renderSortingPlaceholder: function(event, element) {
	                return vc.app.renderPlaceholder(event, element)
	            }
	        });



		window.VcBackendTtaAccordionViewPixfort = window.VcBackendTtaViewInterfacePixfortAcc.extend({
	            sortableSelector: "> [data-vc-tab]",
	            sortableSelectorCancel: ".vc-non-draggable-container",
	            sortablePlaceholderClass: "vc_placeholder-tta-tab",
	            navigationSectionTemplate: null,
	            navigationSectionTemplateParsed: null,
	            $navigationSectionAdd: null,
	            sortingPlaceholder: "vc_placeholder-tab vc_tta-tab",
	            render: function() {
	                return window.VcBackendTtaAccordionViewPixfort.__super__.render.call(this), this.$navigation = this.$el.find("> .wpb_element_wrapper .vc_tta-tabs-list"), this.$sortable = this.$navigation, this.$navigationSectionAdd = this.$navigation.children(".vc_tta-tab:first-child"), this.setNavigationSectionTemplate(this.$navigationSectionAdd.prop("outerHTML")), vc_user_access().shortcodeAll("pix_accordion_tab") ? this.$navigationSectionAdd.addClass("vc_tta-section-append").removeAttr("data-vc-target-model-id").removeAttr("data-vc-tab").find("[data-vc-target]").html('<i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>').removeAttr("data-vc-tabs").removeAttr("data-vc-target").removeAttr("data-vc-target-model-id").removeAttr("data-vc-toggle") : this.$navigationSectionAdd.hide(), this
	            },
	            setNavigationSectionTemplate: function(html) {
	                this.navigationSectionTemplate = html, this.navigationSectionTemplateParsed = vc.template(this.navigationSectionTemplate, vc.templateOptions.custom)
	            },
	            getNavigationSectionTemplate: function() {
	                return this.navigationSectionTemplate
	            },
	            getParsedNavigationSectionTemplate: function(data) {
	                return this.navigationSectionTemplateParsed(data)
	            },
	            changeNavigationSectionTitle: function(modelId, title) {
	                this.findNavigationTab(modelId).find("[data-vc-target]").text(title)
	            },
	            changeActiveSection: function(modelId) {
	                window.VcBackendTtaAccordionViewPixfort.__super__.changeActiveSection.call(this, modelId), this.$navigation.children("." + this.activeClass).removeClass(this.activeClass), this.findNavigationTab(modelId).addClass(this.activeClass)
	            },
	            notifySectionRendered: function(model) {
	                var $element, title, $insertAfter, clonedFrom;
	                window.VcBackendTtaAccordionViewPixfort.__super__.notifySectionRendered.call(this, model), title = model.getParam("title"), $element = $(this.getParsedNavigationSectionTemplate({
	                    model_id: model.get("id"),
	                    section_title: _.isString(title) && 0 < title.length ? title : this.defaultSectionTitle
	                })), model.get("cloned") ? (clonedFrom = model.get("cloned_from"), _.isObject(clonedFrom) && (($insertAfter = this.$navigation.children('[data-vc-target-model-id="' + clonedFrom.id + '"]')).length ? $element.insertAfter($insertAfter) : $element.insertBefore(this.$navigation.children(".vc_tta-section-append")))) : model.get("prepend") ? $element.insertBefore(this.$navigation.children(":first-child")) : $element.insertBefore(this.$navigation.children(":last-child"))
	            },
	            notifySectionChanged: function(model) {
	                var title;
	                window.VcBackendTtaAccordionViewPixfort.__super__.notifySectionChanged.call(this, model), title = model.getParam("title"), _.isString(title) && title.length || (title = this.defaultSectionTitle), this.changeNavigationSectionTitle(model.get("id"), title), model.view.$el.find("> .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_element-name").removeClass("vc_element-move"), model.view.$el.find("> .wpb_element_wrapper > .vc_tta-panel-body > .vc_controls .vc_element-name .vc-c-icon-dragndrop").hide()
	            },
	            makeFirstSectionActive: function() {
	                var $tab = this.$navigation.children(":first-child:not(.vc_tta-section-append)").addClass(this.activeClass);
	                $tab.length && this.findSection($tab.data("vc-target-model-id")).addClass(this.activeClass)
	            },
	            findNavigationTab: function(modelId) {
	                return this.$navigation.children('[data-vc-target-model-id="' + modelId + '"]')
	            },
	            removeSection: function(model) {
	                var $nextTab, $viewTab = this.findNavigationTab(model.get("id"));
	                $viewTab.hasClass(this.activeClass) && (($nextTab = this.getNextTab($viewTab)).addClass(this.activeClass), this.changeActiveSection($nextTab.data("vc-target-model-id"))), $viewTab.remove()
	            },
	            renderSortingPlaceholder: function(event, currentItem) {
	                var helper = currentItem,
	                    currentItemWidth = currentItem.width() + 1,
	                    currentItemHeight = currentItem.height();
	                return helper.width(currentItemWidth), helper.height(currentItemHeight), helper
	            }
	        });

	}


})( window.jQuery );
