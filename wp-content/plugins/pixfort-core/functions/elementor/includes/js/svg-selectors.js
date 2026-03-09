!function($) {
    
    $("body").on('mouseover', '.elementor-due-icons', function(){
        if(!$(this).hasClass('is-loaded')){
            $(this).addClass('is-loaded');
            $(this).find('.due-temp-icon').each(function(i, elem){
                let url = $(elem).attr('data-url');
                let alt = $(elem).attr('data-alt');
                $(elem).parent().append('<img loading="lazy" height="34" width="34" src="'+url+'" alt="'+alt+'">');
                $(elem).remove();
            });
        }
    });

    $("body").on('change keydown paste input', '.pix_param_icons_search', function(){
        let search = $(this).val();

        // $(this).closest('.elementor-control-field').find(".elementor-icon-selector-label").show().filter(function () {
        //     return $(this).data('tooltip').indexOf(search) < 0;
        // }).hide();
        if(search){
            $(this).closest('.elementor-control-field').find(".elementor-icon-selector-label").each(function(i, elem){
                if($(elem).attr('tooltip').includes(search)){
                    $(elem).show();
                }else{
                    $(elem).hide();
                }
            });
        }else{
            $(this).closest('.elementor-control-field').find(".elementor-icon-selector-label").show();
        }

    });

}(window.jQuery);
