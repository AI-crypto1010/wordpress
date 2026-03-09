jQuery(document).ready(function(){
    var ajax_url = fmbackupparams.ajaxurl;
    var wpfmbackup = fmbackupparams.wpfmbackup;
    jQuery(document).on("click", "#wpfm-backupnow-button", function(){
        jQuery(".fmbkp_console h3").removeAttr('style');
        var fm_bkp_database = jQuery('#fm_bkp_database').prop('checked');
        var fm_bkp_files = jQuery('#fm_bkp_files').prop('checked');
        var fm_bkp_plugins = jQuery('#fm_bkp_plugins').prop('checked');
        var fm_bkp_themes = jQuery('#fm_bkp_themes').prop('checked');
        var fm_bkp_uploads = jQuery('#fm_bkp_uploads').prop('checked');
        var fm_bkp_other = jQuery('#fm_bkp_other').prop('checked');
        var fm_bkp_id = ''; // empty
        var flag = 1;
        if(fm_bkp_files === true && fm_bkp_plugins === false && fm_bkp_themes === false  && fm_bkp_uploads === false  && fm_bkp_other === false ){
            alert(fmbackupparams.backup_empty_error);
            flag = 0;
        }
        if(flag == 1){
            jQuery(".fmbkp_console_popup .close_fm_console").hide();
            jQuery('.fmbkp_console_popup').show();
            jQuery('#fmbkp_console').show().html('<p class="backup_wait">'+fmbackupparams.backup_running+'</p><ul></ul>');
            wp_fm_backup(ajax_url, fm_bkp_database,fm_bkp_files,fm_bkp_plugins,fm_bkp_themes,fm_bkp_uploads,fm_bkp_other,fm_bkp_id);
        }
    });
    function wp_fm_backup(ajax_url, fm_bkp_database,fm_bkp_files,fm_bkp_plugins,fm_bkp_themes,fm_bkp_uploads,fm_bkp_other,fm_bkp_id){
        jQuery.ajax({
            url : ajax_url,
            type : 'post',
            data : {
                action : 'mk_file_manager_backup',
                database : fm_bkp_database,
                files: fm_bkp_files,
                plugins: fm_bkp_plugins,
                themes: fm_bkp_themes,
                uploads: fm_bkp_uploads,
                others: fm_bkp_other,
                bkpid: fm_bkp_id,
                nonce: wpfmbackup,
            },
            success : function( response ) {
                var res = JSON.parse(response);
                var next_step = res.step;
                jQuery('.fmbkp_console_popup').show();
                if(next_step == '0') {
                    jQuery('.fmbkp_console_loader').hide();              
                    jQuery('#fmbkp_console').show().find("ul").append(res.msg);
                    setTimeout(function(){
                        location.reload();
                    }, 600);
                } else {
                    jQuery('#fmbkp_console').show().find("ul").append(res.msg);
                    wp_fm_backup(ajax_url,res.database,res.files,res.plugins,res.themes,res.uploads,res.others,res.bkpid);
                }            
            }
        });
    } 
    jQuery(".backupids").click(function(){
        if(jQuery(".backupids:checked").length == jQuery(".backupids").length){
            jQuery(".bkpchkCheckAll").prop("checked",true);
            jQuery('.bkpCheckAll').addClass('disabled_btn');
            jQuery('.bkpUnCheckAll').removeClass('disabled_btn');
            jQuery('.bkpDelete').removeClass('disabled_btn');
        }
        else{
            jQuery(".bkpchkCheckAll").prop("checked",false);
            jQuery('.bkpUnCheckAll').addClass('disabled_btn');
            jQuery('.bkpCheckAll').removeClass('disabled_btn');
            jQuery('.bkpDelete').removeClass('disabled_btn');
            if(jQuery(".backupids:checked").length == 0){
                jQuery('.bkpDelete').addClass('disabled_btn');
            }
            if(jQuery(".backupids:checked").length > 0){
                jQuery('.bkpUnCheckAll').removeClass('disabled_btn');
            }
        }
    });
    // select all -> backups
    jQuery(".bkpchkCheckAll").click(function () {
        jQuery(".backupids").prop('checked', jQuery(this).prop('checked'));
        if(jQuery(this).prop('checked')) {
        jQuery('.bkpDelete,.bkpUnCheckAll').removeClass('disabled_btn');
        jQuery('.bkpCheckAll').addClass('disabled_btn');
        } else {
            jQuery('.bkpDelete,.bkpUnCheckAll').addClass('disabled_btn');
            jQuery('.bkpCheckAll').removeClass('disabled_btn');
        }
    });
    jQuery(".bkpCheckAll").click(function () {
        jQuery(".backupids,.bkpchkCheckAll").prop('checked', true);
        jQuery('.bkpDelete,.bkpUnCheckAll').removeClass('disabled_btn');
        jQuery(this).addClass('disabled_btn');
    });
    jQuery(".bkpUnCheckAll").click(function () {
        jQuery(".backupids,.bkpchkCheckAll").prop('checked', false);
        jQuery('.bkpDelete,.bkpUnCheckAll').addClass('disabled_btn');
        jQuery('.bkpCheckAll').removeClass('disabled_btn');
        
    });
    // for toggle backup options
    jQuery("#fm_open_files_option").click(function () {
        jQuery("#fm_open_files_options").slideToggle();
    });
    //close console popup
    jQuery(".close_fm_console").click(function () {
        jQuery(".fmbkp_console_popup").hide();
    });

    // on delete - ajax
    jQuery(".bkpDelete").click(function () {
        var delarr = new Array();

        jQuery(".backupids").each(function () {
            if(jQuery(this).is(':checked')) {
            delarr.push(jQuery(this).val());
            }
        }); //each

        if(delarr == '') {
            alert(fmbackupparams.delete_backup);
        } else {
            var r = confirm(fmbackupparams.confirm_del)
            if (r == true) {
                jQuery.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: {
                            action : 'mk_file_manager_backup_remove',
                            delarr: delarr,
                            nonce: fmbackupparams.wpfmbackupremove,
                        },
                    cache: false,

                success: function(response) {   
                    alert(response);
                    location.reload();
                }
                });//ajax
            }
    }
    }); //click



    //open DELETE popup
    jQuery('.bkpDeleteID').on("click",function(){
        jQuery(".dlt_backup_popup").show();
        var bkpId = jQuery(this).attr('id');
        jQuery('.dlt_confirmed').attr("id", bkpId);    
    });
    //close DELETE popup 
    jQuery(".close_dlt_backup, .dlt_cancel").click(function () {
        jQuery(".dlt_backup_popup").hide();
    });
    // on delete - ajax
    jQuery(".dlt_confirmed").click(function () {
        var bkpId = jQuery(this).attr('id')
            jQuery.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                        action : 'mk_file_manager_single_backup_remove',
                        id: bkpId,
                        nonce: fmbackupparams.wpfmbackupremove,
                    },
                cache: false,

            success: function(response) {
                if(response == "1"){
                    jQuery(".fmbkp_console h3").css('text-transform','uppercase !important');
                    jQuery(".dlt_backup_popup").hide();
                    jQuery(".dlt_success_popup").show();
                }
            }
            });//ajax
    }); //click
    jQuery(".close_dlt_success, .dlt_confirmed_success").click(function () {
        jQuery(".dlt_success_popup").hide();
        location.reload();    
    });



    // backup - ajax
    jQuery(".bkpViewLog").click(function () {
        jQuery('.fmbkp_console_popup').show();
        jQuery('#fmbkp_console').html('');
        var bkpId = jQuery(this).attr('id')
            jQuery.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                        action : 'mk_file_manager_single_backup_logs',
                        id: bkpId,
                        nonce: fmbackupparams.wpfmbackuplogs
                    },
                cache: false,

            success: function(response) {
                jQuery('.fmbkp_console_loader').hide();      
                jQuery('#fmbkp_console').show().html(response);
            }
            });//ajax
    }); //click

    //open restore popup
    jQuery('.bkpRestoreID').on("click",function(){
        var check_db = jQuery(this).parent().prev('.bck_action').text();
        var packet = fmbackupparams.default_packet_value
        if( check_db.indexOf('Database') >= 0 && parseInt(packet) < 9999360){
            alert(fmbackupparams.packet_error_msg);
        }else{
            jQuery(".restore_backup_popup").show();
            var bkpId = jQuery(this).attr('id');
            jQuery('.restore_confirmed').attr("id", bkpId);
        }
        
    });
    //close restore popup 
    jQuery(".close_restore_backup, .restore_cancel").click(function () {
        jQuery(".restore_backup_popup").hide();
    });
    // on delete - ajax
    
    jQuery(".restore_confirmed").click(function () {
        jQuery(this).addClass('disabled_btn');
        var bkpId = jQuery(this).attr('id');
        jQuery(this).attr('disabled', true);
        var fm_res_database = true;
        var fm_res_plugins = true;
        var fm_res_themes = true;
        var fm_res_uploads = true;
        var fm_res_other =true;
        jQuery(".fmbkp_console_popup .close_fm_console").hide();
        jQuery('.restore_backup_popup').hide();
        jQuery('.fmbkp_console_popup').show();
        jQuery('#fmbkp_console').show().html('<p class="backup_wait">'+fmbackupparams.restore_running+'</p><ul></ul>');
        wp_fm_restore(ajax_url, bkpId, fm_res_database,fm_res_plugins,fm_res_themes,fm_res_uploads,fm_res_other);
    });
    function wp_fm_restore(ajax_url, bkpId,fm_res_database,fm_res_plugins,fm_res_themes,fm_res_uploads,fm_res_other){
        jQuery.ajax({
            url : ajax_url,
            type : 'post',
            data : {
                action : 'mk_file_manager_single_backup_restore',
                id: bkpId,
                nonce: fmbackupparams.wpfmbackuprestore,
                database : fm_res_database,
                plugins: fm_res_plugins,
                themes: fm_res_themes,
                uploads: fm_res_uploads,
                others: fm_res_other,
            },
            cache: false,
            success : function( response ) {
                var res = JSON.parse(response);
                var next_step = res.step;
                jQuery('.fmbkp_console_popup').show();
                if(next_step == '0') {
                    jQuery('.fmbkp_console_loader').hide();              
                    jQuery('#fmbkp_console').show().find("ul").append(res.msg+' '+res.msgg);
                    location.reload();
                } else {
                    if(res.msg != ''){
                        jQuery('#fmbkp_console').show().find("ul").append(res.msg);
                    }
                    wp_fm_restore(ajax_url, bkpId, res.database,res.plugins,res.themes,res.uploads,res.others);
                }            
            }
        });
    } 

});

jQuery(document).on('click','#fm_bkp_files', function(){
    var status = this.checked;
    jQuery(".chk-files").each( function() {
        jQuery(this).prop("checked",status);
    });
});

jQuery(document).on("click",".bck-icon", function(){
    var key = jQuery(this).attr('data-token');
    window.open(fmbackupparams.backup_baseurl+key);
});

jQuery(document).on("click",".fm-download-all", function(){
    var selector = jQuery(this).parents('.bck_action').find('a');
    var key = jQuery(selector).attr('data-token');
    key = key+'/yes';
    window.open(fmbackupparams.backupall_baseurl+key);
});