//POpup - when user try to close the tab
jQuery("html").bind("mouseleave", function () {
    /* Remove this condition if you want to test the popup as the popup will appear 
     * every time you hover around the browser tab
     */
    if (jQuery(window).width() > 580) {
        setTimeout(function () {
            if (jQuery('#exit-modal').data('popup-displayed') === 'hidden' && !jQuery('#resource-modal').hasClass('show')) {
                jQuery.ajax({
                    type: "get",
                    dataType: "json",
                    url: td_ajax_url,
                    data: {'action': "save_exit_modal_data"},
                    beforeSend: function () {
                    }, success: function (response) {
                        if (response.msg === 'success') {
                            jQuery('#exit-modal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            jQuery('#exit-modal').data('popup-displayed', 'shown');
                        }
                    }, error: function () {
                    }
                });
            }
        }, 50 * 1000);
    }
});
function resource_filter_func(curr_ele) {
    var category = jQuery('.js-category').val();
    var resource_type = jQuery('.js-resource-type').val();
    var resource_type = '';
    if (jQuery('.js-resource-type').length > 0) {
        resource_type = jQuery('.js-resource-type').val();

    } else {
        if (typeof jQuery(curr_ele).attr('slug') !== 'undefined') {
            resource_type = jQuery(curr_ele).attr('slug');
        } else {
            resource_type = jQuery('.head-filter').attr('data-curr-rtype');
        }

    }

    if (resource_type === '' || typeof resource_type === 'undefined') {
        resource_type = jQuery('.head-filter').attr('data-curr-rtype');
    }
    var date = jQuery('.js-date').val();
    var page = (typeof curr_ele.data('current-page') !== 'undefined') ? (curr_ele.data('current-page') + 1) : '1';

    data = {
        'action': 'filterposts',
        'category': category,
        'resource_type': resource_type,
        'date': date,
        'page': page
    };

    jQuery.ajax({
        url: td_ajax_url,
        data: data,
        type: 'POST',
        beforeSend: function (xhr) {

            jQuery('#resources-ajax-load-more').remove();
            var loading_btn = '<div class="text-center clearfix loading-btn"><img src="https://thehrempire.com/wp-content/plugins/td-composer/legacy/common/wp_booster/wp-admin/images/panel/loading.gif" class="text-center"></div>';
            if (page > 1) {
                jQuery('.filtered-posts').append(loading_btn);
            } else {
                jQuery('.filtered-posts').html(loading_btn);
            }
        },
        success: function (data) {
            jQuery('.loading-btn').remove();
            if (data) {
                if (data.append === 'true') {
                    jQuery('.filtered-posts').append(data.posts);
                } else {
                    jQuery('.filtered-posts').html(data.posts);
                }
                jQuery('.js-category').removeAttr('disabled');
                jQuery('.js-date').removeAttr('disabled');
            } else {
                jQuery('.filtered-posts').html('No posts found.');
            }
        }
    });
}
jQuery(document).ready(function () {
    jQuery(".js-category, .js-date, .js-resource-type").on("change", function () {
        resource_filter_func(jQuery(this));
    });
});
jQuery( document ).ready(function(){ 

    jQuery('#privacy_policy').insertBefore(jQuery('.button-submit').parent()); 
    jQuery('.button-submit').prop('disabled', true);
    jQuery('#privacy_policy').css('display', 'block');
    }); 
    jQuery(document).on("click", "#privacy_policy > input", function () {
        if (jQuery(this).is(":checked")) {
            
            //Start -- Updated on 26/07/2023
            if (jQuery('.wdform_section').find('.fm-not-filled').length > 0 && jQuery('.fm-not-filled').is(":visible")) {
                jQuery('.button-submit').prop('disabled', true);

            } else {
                jQuery('.button-submit').prop('disabled', false);
            }

jQuery("#agree_chk_error").hide();
//            console.log('privacy_policy > input');
//            var error_field = 'false';
//            jQuery('.wdform_section').each(function (i, obj) {
//                console.log(jQuery(obj).find('.validate_email_error_1').length);
//                if (obj.find('.validate_email_error_1').length > 0) {
//                    error_field = 'true';
//                }
//            });
//
//            if (error_field === 'false') {
//                jQuery('.button-submit').prop('disabled', true);
//                jQuery('.fm-submit-loading').hide();
//            } else {
//                jQuery("#agree_chk_error").hide();
//                jQuery('.button-submit').prop('disabled', false);
//            }
        } else {
            jQuery("#agree_chk_error").show();
            jQuery('.button-submit').prop('disabled', true);
        }
    });
    jQuery(document).on("click", "#privacy_policy > input", function () {
        if (jQuery(this).is(":checked")) {
            
            //Start -- Updated on 26/07/2023
            if (jQuery('.wdform_section').find('.fm-not-filled').length > 0 && jQuery('.fm-not-filled').is(":visible")) {
                jQuery('.button-submit').prop('disabled', true);

            } else {
                jQuery('.button-submit').prop('disabled', false);
            }

jQuery("#agree_chk_error").hide();
//            console.log('privacy_policy > input');
//            var error_field = 'false';
//            jQuery('.wdform_section').each(function (i, obj) {
//                console.log(jQuery(obj).find('.validate_email_error_1').length);
//                if (obj.find('.validate_email_error_1').length > 0) {
//                    error_field = 'true';
//                }
//            });
//
//            if (error_field === 'false') {
//                jQuery('.button-submit').prop('disabled', true);
//                jQuery('.fm-submit-loading').hide();
//            } else {
//                jQuery("#agree_chk_error").hide();
//                jQuery('.button-submit').prop('disabled', false);
//            }
        } else {
            jQuery("#agree_chk_error").show();
            jQuery('.button-submit').prop('disabled', true);
        }
    });


    jQuery(document).on("click", ".checkbox-div > input", function () {
        if (jQuery(this).is(":checked")) {
            if (jQuery('.wdform_section').find('.fm-not-filled').length > 0 && jQuery('.fm-not-filled').is(":visible")) {
                jQuery('.button-submit').prop('disabled', true);

            } else {
                jQuery('.button-submit').prop('disabled', false);
            }

            jQuery("#agree_chk_error").hide();

        } else {
            jQuery("#agree_chk_error").show();
            jQuery('.button-submit').prop('disabled', true);
        }
    });
    
    jQuery(".button-submit").click(function (e) {
        if (jQuery("#privacy_policy > input").is(":checked")) {

            jQuery("#agree_chk_error").hide();
            jQuery('.button-submit').prop('disabled', false);
        } else {
            jQuery("#agree_chk_error").show();
            jQuery('.button-submit').prop('disabled', true);
            e.preventDefault();
            e.stopPropagation();
            return false;

        }
    });

