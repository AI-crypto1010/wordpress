!function($) {

    $('.pix_res_css_val').each(function(i, el){
        let values = $(el).val();
        if(values){
            console.log(values);
            values = JSON.parse(values);

            let main = $(this).closest('.pix_param_block');
            $.each(values,function(i, o){
                main.find('input[name='+i+']').val(o);
            });
        }
    });

    $(".pix_responsive_nav_item").on('click', function(e){
        e.preventDefault();
        let tab = $(this).attr('data-link');
        if(tab){
            $(this).closest('.pix_responsive_css_param').find('.pix_responsive_tab').removeClass('show');
            $(this).closest('.pix_responsive_css_param').find('.pix_responsive_nav_item').removeClass('is-active');
            $(this).addClass('is-active');
            $(tab).addClass('show');
        }

    });
    $.fn.serializeDivArray = function() {
        var dataArray = [];
        $(this).find(':input').each(function() {
            // Check if the element has a name, is not disabled, and is not a button or file input
            if (this.name && !this.disabled && this.type !== 'submit' && this.type !== 'reset' && this.type !== 'button' && this.type !== 'file') {
                // Check if it's a checkbox or radio button; if so, only add it if it is checked
                if (this.type !== 'checkbox' && this.type !== 'radio' || this.checked) {
                    dataArray.push({ name: this.name, value: $(this).val() });
                }
            }
        });
        return dataArray;
    };
    $(".pix_responsive_css_field").on('change keydown paste input', function(){
        let main = $(this).closest('.pix_param_block');
        let param = $(this).closest('.pix_responsive_css_param');
        if(param){
            let data = param.serializeDivArray();
            let res = {};
            jQuery.each( data, function( i, field ) {
              if(field.value&&field.value!==''){
                  res[field.name] = field.value;
              }
            });

            main.find('.pix_res_css_val').val(JSON.stringify(res));
        }


    });

}(window.jQuery);
