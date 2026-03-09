!function($) {

    $('body').on('click', '.pix_param_icon', function(e){
        e.preventDefault();
        $(this).closest('.pix_param_block').find('.pix_param_icon').removeClass('selected');
        $(this).addClass('selected');
        var input = $(this).closest('.pix_param_block').find('.pix_param_val');
        var val = $(this).data('val');
        input.each(function(i, el){
            $(el).val(val);
            $(el).change();
            $(el).trigger("change");;
        });
    });
    $('.pix_param_val').each(function(i, el){
        $(el).closest('.pix_param_block').find('.pix_param_icon').removeClass('selected');
        $(el).closest('.pix_param_block').find('.pix_param_icon[data-val="'+$(el).val()+'"]').addClass('selected');
        $(el).change();
    });

    $(".pix_param_icons_search").on('change keydown paste input', function(){
        let search = $(this).val();
        $(this).closest('.pix_param_block').find(".pix_param_icon").show().filter(function () {
            return $(this).data('val').indexOf(search) < 0;
        }).hide();

    });

}(window.jQuery);
