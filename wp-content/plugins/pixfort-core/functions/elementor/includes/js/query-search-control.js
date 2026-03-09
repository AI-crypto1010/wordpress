(function ($) {
    $(document).ready(function () {
        if (typeof elementor !== 'undefined') {
            var pixQuerySearch = elementor.modules.controls.BaseData.extend({
                onReady() {
                    var self = this;
                    let searchLink = PIX_QUERY_SEARCH_VALUES.searchLink;
                    let $select = this.$el.find('.pixfort-query-search-select2:first');
                    let objectType = $select.attr('data-object-type');
                    let queryData = $select.attr('data-query');
                    let dataValue = $select.attr('data-value');
                    let isMultiple = $select.attr('data-multiple') === 'true';

                    // Parse query data
                    let query = {};
                    try {
                        query = JSON.parse(queryData);
                    } catch (e) {
                        query = {};
                    }

                    // Get control value from Elementor first (this has the saved data)
                    let controlValue = self.getControlValue();
                    let initialValues = [];
                    
                    // Priority: controlValue from Elementor > data-value attribute
                    if (controlValue !== null && controlValue !== undefined && controlValue !== '') {
                        if (Array.isArray(controlValue)) {
                            initialValues = controlValue.filter(v => v !== null && v !== undefined && v !== '').map(String);
                        } else {
                            initialValues = [String(controlValue)];
                        }
                    } else if (dataValue && dataValue !== '') {
                        // Try to parse data-value attribute
                        try {
                            let parsed = JSON.parse(dataValue);
                            if (Array.isArray(parsed)) {
                                initialValues = parsed.filter(v => v !== null && v !== undefined && v !== '').map(String);
                            } else if (parsed !== null && parsed !== undefined) {
                                initialValues = [String(parsed)];
                            }
                        } catch (e) {
                            // Not JSON, treat as single value
                            initialValues = [dataValue];
                        }
                    }

                    // Initialize Select2 first
                    $select.select2({
                        multiple: isMultiple,
                        ajax: {
                            url: searchLink,
                            dataType: 'json',
                            type: 'POST',
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: params.term,
                                    object_type: objectType,
                                    query: query,
                                    page: params.page || 1
                                };
                            },
                            processResults: function (data, params) {
                                params.page = params.page || 1;
                                
                                let results = [];
                                if (data.success && data.results) {
                                    results = data.results.map(function(item) {
                                        return {
                                            id: String(item.id),
                                            text: item.text
                                        };
                                    });
                                }

                                return {
                                    results: results,
                                    pagination: {
                                        more: data.more || false
                                    }
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 0,
                        placeholder: 'Search and select...',
                        allowClear: true
                    });

                    // If there are initial values, load their data and populate Select2
                    if (initialValues.length > 0) {
                        $.ajax({
                            url: searchLink,
                            method: 'POST',
                            data: {
                                object_type: objectType,
                                query: query,
                                ids: initialValues
                            }
                        }).done(function (response) {
                            try {
                                let resp = typeof response === 'string' ? JSON.parse(response) : response;
                                if (resp.success && resp.results && resp.results.length > 0) {
                                    // Clear existing options and add loaded ones
                                    $select.empty();
                                    resp.results.forEach(function(item) {
                                        let option = new Option(item.text, String(item.id), true, true);
                                        $select.append(option);
                                    });
                                    // Trigger change to update Select2 display
                                    $select.trigger('change.select2');
                                }
                            } catch (e) {
                                console.error('Error parsing initial value response:', e);
                            }
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX error loading initial values:', textStatus, errorThrown);
                        });
                    }

                    // Handle change event
                    $select.on('change', function (e) {
                        self.saveValue();
                    });
                },
                
                saveValue() {
                    let $select = this.$el.find('.pixfort-query-search-select2:first');
                    let isMultiple = $select.attr('data-multiple') === 'true';
                    let val = $select.val();
                    
                    // For multiple selection, ensure we save as array
                    if (isMultiple) {
                        if (!val) {
                            val = [];
                        } else if (!Array.isArray(val)) {
                            val = [val];
                        }
                    }
                    
                    this.setValue(val);
                },
                
                onBeforeDestroy() {
                    let $select = this.$el.find('.pixfort-query-search-select2:first');
                    if ($select.data('select2')) {
                        $select.select2('destroy');
                    }
                }
            });

            // Add the control view
            elementor.addControlView('pix_query_search', pixQuerySearch);
        } else {
            console.error('Elementor is not defined');
        }
    });
})(jQuery);

