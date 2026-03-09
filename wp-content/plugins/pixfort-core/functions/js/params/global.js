!function($) {

  // $('.pix_param_val').each(function(i, el){
  //     $(el).closest('.pix_param_block').find('.pix_param_img').removeClass('selected');
  //     $(el).closest('.pix_param_block').find('.pix_param_img[data-val="'+$(el).val()+'"]').addClass('selected');
  //     $(el).change();
  // });

  console.log("Global");
  var classes = '';
  classes += '.bottom_layers, .b_has_animation, .b_1_color, .b_1_color_2, .b_2_color, .b_2_color_2, .b_3_color, .b_3_color_2';
  classes += ', .b_1_animation, .b_1_delay, .b_2_animation, .b_2_delay, .b_3_animation, .b_3_delay';
  classes += ', .top_layers, .t_has_animation, .t_1_color, .t_1_color_2, .t_2_color, .t_2_color_2, .t_3_color, .t_3_color_2';
  classes += ', .t_1_animation, .t_1_delay, .t_2_animation, .t_2_delay, .t_3_animation, .t_3_delay ';
  $(classes).each(function(i, el){
      $(el).closest('.vc_shortcode-param').addClass('pix_param_50');
  });
  setTimeout(function(){
      $('button[data-vc-ui-element-target="#vc_edit-form-tab-4"]').click();
      $('button[data-vc-ui-element-target="#vc_edit-form-tab-3"]').click();
      $('button[data-vc-ui-element-target="#vc_edit-form-tab-2"]').click();
      $('button[data-vc-ui-element-target="#vc_edit-form-tab-1"]').click();
      $('button[data-vc-ui-element-target="#vc_edit-form-tab-0"]').click();
  }, 50);

}(window.jQuery);
