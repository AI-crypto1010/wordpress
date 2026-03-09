!(function ($) {

    $('body').on('click', '.vc-c-icon-content_copy, .vc_param_group-add_content', function(e){
        setTimeout(() => {
            pix_init_gradient_picker();    
        }, 1000);
    });
    
    $(document).on("change", ".items_item_color.custom-gradient", function(){
        setTimeout(() => {
            pix_init_gradient_picker();    
        }, 1000);
    });
    
    function pix_init_gradient_picker(){
        $('.pix-gradient-picker-el').each(function (i, el) {
            let $el = $(el);
    
            let $preview = $(el)
                .closest('.pix-gradient-picker-container')
                .find('.pix-gradient-picker-preview');
            var swType = $(el)
                .closest('.pix-gradient-picker-container')
                .find('.switch-type:first');
            var swAngle = $(el)
                .closest('.pix-gradient-picker-container')
                .find('.switch-angle:first');
            var res = $(el)
                .closest('.pix_param_block')
                .find('.pix_param_val:first');
    
            const gp = new Grapick({
                el: el,
                colorEl: '<input class="pix-colorpicker"/>',
            });
            gp.setValue(res.val());
            if (gp.getDirection()) {
                let dirVal = gp.getDirection();
                dirVal = pixCleanGradientDirection(dirVal);
                swAngle.val(dirVal);
            }
            if (gp.getType()) {
                swType.val(gp.getType());
            }
    
            let hs = gp.getHandlers();
            hs.forEach(function (handler) {
                const el = handler.el;
                const $el = $(el).find(".pix-colorpicker");
                $el.spectrum({
                    color: handler.getColor(),
                    showAlpha: true,
                    showInput: true,
                    preferredFormat: 'hex3',
                    change(color) {
                        handler.setColor(color.toRgbString());
                    },
                    move(color) {
                        handler.setColor(color.toRgbString(), 0);
                    },
                });
            });
    
            gp.setColorPicker((handler) => {
                const el = $(handler.getEl()).find(".pix-colorpicker:first");
                const $el = $(el);
    
                $el.spectrum({
                    color: handler.getColor(),
                    showAlpha: true,
                    showInput: true,
                    preferredFormat: 'hex3',
                    change(color) {
                        handler.setColor(color.toRgbString());
                    },
                    move(color) {
                        handler.setColor(color.toRgbString(), 0);
                    },
                });
                // return a function in order to destroy the custom color picker
                return () => {
                    $el.spectrum('destroy');
                };
            });
    
            $preview.css({
                background: gp.getValue(),
            });
    
            // Do stuff on change of the gradient
            gp.on('change', (complete) => {
                res.val(gp.getValue());
                $preview.css({
                    background: gp.getValue(),
                });
            });
            
            res.on('change keydown paste input', function (e) {
                let cVal = gp.getValue();
                let self = this;
                setTimeout(() => {
                    let newVal = $(self).val();
                    if(cVal!=newVal){
                        gp.setValue(newVal);
                    }
                }, 200);
            });
    
            swType.on('change keydown paste input', function (e) {
                gp && gp.setType(this.value || 'linear');
            });
    
            swAngle.on('change keydown paste input', function (e) {
                let newVal = this.value;
                newVal = pixCleanGradientDirection(newVal);
                gp && gp.setDirection(newVal || 'right');
            });
        });
    }
    

    function pixCleanGradientDirection(dirVal){
        if(dirVal=='circle at center'){
            dirVal = 'center';
        }else if(dirVal.startsWith('to ')){
            dirVal = dirVal.replace('to ','');
        }
        return dirVal;
    }

    pix_init_gradient_picker();

})(window.jQuery);
