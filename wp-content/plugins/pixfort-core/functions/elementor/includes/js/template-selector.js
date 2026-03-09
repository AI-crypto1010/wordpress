(function ($) {
    $(document).ready(function () {
        if (typeof elementor !== 'undefined') {
            var pixTemplate = elementor.modules.controls.BaseData.extend({
                onReady() {
                    var self = this;
                    let urls = PIX_TEMPLATE_SELECTOR_VALUES.resultsURLs;
                    let templatesLink = PIX_TEMPLATE_SELECTOR_VALUES.templatesLink;
                    let val = this.$el.find('.pixfort-elementor-select2:first :selected').val();
                    let dataVal = this.$el.find('.pixfort-elementor-select2:first').attr('data-value');

                    if (dataVal) {
                        let valID = dataVal;
                        if (valID in urls) {
                            let btn = '<a target="_blank" class="elementor-button elementor-button-default pix-edit-template" href="' + urls[valID] + '">';
                            btn += '<i class="eicon-pencil"></i> Edit Template</a>';
                            this.$el.find('.pix-template-edit-area').html(btn);
                        }
                    }

                    $.ajax({
                        url: templatesLink,
                        method: 'get'
                    }).done(function (response) {
                        let resp = JSON.parse(response);
                        let data = resp.results;
                        let urls = resp.resultsURLs;
                        $.each(data, function (i, val) {
                            let check = self.$el.find('.pixfort-elementor-select2:first option[value="' + i + '"]');
                            if (!check.length) {
                                if (parseInt(dataVal) == i) {
                                    console.log('Selected');
                                    self.$el.find('.pixfort-elementor-select2:first :selected').removeAttr('selected');
                                    self.$el.find('.pixfort-elementor-select2:first').append(`<option selected value="${i}">${val}</option>`);
                                } else {
                                    self.$el.find('.pixfort-elementor-select2:first').append(`<option value="${i}">${val}</option>`);
                                }
                            }
                        });
                        if (dataVal) {
                            let valID = dataVal;
                            if (valID in urls) {
                                let btn = '<a target="_blank" class="elementor-button elementor-button-default pix-edit-template" href="' + urls[valID] + '">';
                                btn += '<i class="eicon-pencil"></i> Edit Template</a>';
                                self.$el.find('.pix-template-edit-area').html(btn);
                            }
                        }
                    });

                    this.$el.find('.pixfort-elementor-select2').on('change keydown paste input', function (e) {
                        self.saveValue();
                    });
                },
                saveValue() {
                    let urls = PIX_TEMPLATE_SELECTOR_VALUES.resultsURLs;
                    let val = this.$el.find('.pixfort-elementor-select2:first :selected').val();
                    if (val) {
                        let valID = val;
                        if (valID in urls) {
                            let btn = '<a target="_blank" class="elementor-button elementor-button-default pix-edit-template" href="' + urls[valID] + '">';
                            btn += '<i class="eicon-pencil"></i> Edit Template</a>';
                            this.$el.find('.pix-template-edit-area').html(btn);
                        }
                    }
                    this.setValue(val);
                },
                onBeforeDestroy() {
                    this.saveValue();
                }
            });

            // Add the control view
            elementor.addControlView('pix_template_selector', pixTemplate);
        } else {
            console.error('Elementor is not defined');
        }
    });
})(jQuery);
