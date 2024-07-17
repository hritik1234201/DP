function validate_subscribe_email(email_field, lp_var = true, btn_submit = false) {
    jQuery.ajax({
        type: "get",
        dataType: "json",
        url: td_ajax_url,
        data: {'action': "validate_email", 'email_id': email_field.val(), 'lp_var': lp_var},
        beforeSend: function () {
            jQuery('#validate_email_error_1').hide();
            if (email_field.parents('form').find('#subscribe-btn').length > 0) {
                email_field.parents('form').find('#subscribe-btn').attr('disabled', true);
            }
        }, success: function (response) {

            if (response.msg !== '') {
                if (email_field.parents('.wdform_row').find('#validate_email_error_1').length > 0) {
                    jQuery('#validate_email_error_1').html(response.msg);
                    jQuery('#validate_email_error_1').show();
                } else {
                    email_field.parents('.wdform_row').append('<div id="validate_email_error_1" class="fm-not-filled">' + response.msg + '</div>');
                }
                if (email_field.parents('form').find('#subscribe-btn').length > 0) {
                    email_field.parents('form').find('#subscribe-btn').attr('disabled', true);
                }
            } else {
                jQuery('#validate_email_error_1').hide();
                email_field.parents('form').find('.button-submit').removeAttr('disabled');
                if (email_field.parents('form').find('#subscribe-btn').length > 0) {
                    email_field.parents('form').find('#subscribe-btn').removeAttr('disabled');
                }

                if (btn_submit) {
                    // Call the Button submit AJAX here in the Success event, to make it sequential
                    if (btn_submit.parents('#form').find('.validate_email').val() !== '') {
                        var form = jQuery('form#subscription-form');
                        jQuery.ajax({
                            type: "get",
                            dataType: "json",
                            url: td_ajax_url,
                            data: {'action': "save_subscribe_form", 'data': form.serializeArray()},
                            beforeSend: function () {
                                btn_submit.attr('disabled', true);
                            }, success: function (response) {

                                btn_submit.removeAttr('disabled');
                                if (response.status === 'success') {
                                    jQuery('.subscribe-form-block').html('<p class="alert alert-success">Thanks for signing up. To get started, please check your mail to confirm your subscription.</p>');
                                } else if (response.status === 'registered') {
                                    jQuery('.subscribe-form-block').html('<p class="alert alert-danger">You\'re already registered with us. Please check and update your newsletter preferences <a href="' + response.subscribe_url + '" style="color:inherit;text-decoration:underline">HERE</a></p>');
                                } else {
                                    jQuery('.subscribe-form-block').html('<p class="alert alert-danger">You\'re already subscribed to our newsletter. Please check and update your newsletter preferences <a href="' + response.subscribe_url + '" style="color:inherit;text-decoration:underline">HERE</a></p>');
                                }
                            }, error: function () {
                            }
                        });
                    } else {
                        btn_submit.attr('disabled', true);
                    }
                }
            }
        }, error: function () {
            email_field.parents('form').find('.button-submit').removeAttr('disabled');
        }
    });
}
jQuery(document).on('keyup', '.subs_validate_email', function () {
    var curr_ele = jQuery(this);
    jQuery(this).parents('form').find('.button-submit').attr('disabled', true);
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test(curr_ele.val())) {
        curr_ele.parents('form').find('#subscribe-btn').attr('disabled', true);
        jQuery('#validate_email_error_1').html('Invalid Email');
        jQuery('#validate_email_error_1').show();
    } else {
        var lp_var = 'false';
        if (jQuery(this).parent().hasClass('subscribe-fields')) {
            var lp_var = 'true';
        }
        jQuery.ajax({
            type: "get",
            dataType: "json",
            url: td_ajax_url,
            data: {'action': "validate_email", 'email_id': curr_ele.val(), 'lp_var': lp_var},
            beforeSend: function () {
                jQuery('#validate_email_error_1').hide();
                if (curr_ele.parents('form').find('#subscribe-btn').length > 0) {
                    curr_ele.parents('form').find('#subscribe-btn').attr('disabled', true);
                }

            }, success: function (response) {
                if (response.msg !== '') {
                    if (curr_ele.parents('.wdform_row').find('#validate_email_error_1').length > 0) {
                        jQuery('#validate_email_error_1').html(response.msg);
                        jQuery('#validate_email_error_1').show();
                    } else {
                        curr_ele.parents('.wdform_row').append('<div id="validate_email_error_1" class="fm-not-filled">' + response.msg + '</div>');
                    }
                    if (curr_ele.parents('form').find('#subscribe-btn').length > 0) {
                        curr_ele.parents('form').find('#subscribe-btn').attr('disabled', true);
                    }
                } else {
                    jQuery('#validate_email_error_1').hide();
                    //curr_ele.parents('form').find('.button-submit').removeAttr('disabled');
                    if (curr_ele.parents('form').find('#subscribe-btn').length > 0) {
                        curr_ele.parents('form').find('#subscribe-btn').removeAttr('disabled');
                    }
                }
            }, error: function () {
                //curr_ele.parents('form').find('.button-submit').removeAttr('disabled');
            }
        });
    }
});
jQuery(document).on('change', '.validate_email', function () {
    var lp_var = 'false';
    if (jQuery(this).parent().hasClass('email-validator')) {
        var lp_var = 'true';
    }
    if (jQuery(this).parent().hasClass('subscribe-fields')) {
        var lp_var = 'true';
    }

    var curr_ele = jQuery(this);
    if (curr_ele.val().length > 3 || (curr_ele.parents('form').find('#subscribe-btn').length > 0 && curr_ele.parents('form').find('edit-subscribe-btn').length === 0)) {
        jQuery.ajax({
            type: "get",
            dataType: "json",
            url: td_ajax_url,
            data: {'action': "validate_email", 'email_id': curr_ele.val(), 'lp_var': lp_var},
            beforeSend: function () {
                //curr_ele.parents('form').find('.button-submit').attr('disabled', true);
                jQuery('#validate_email_error_1').parents('.wdform_row').find('.wdform-label').removeClass('error_label');
                jQuery('#validate_email_error_1').hide();
                if (jQuery('.button-submit').length > 0) {
                    jQuery('.button-submit').attr('disabled', true);
                    jQuery('.fm-submit-loading').show();
                }
                if (curr_ele.parents('form').find('#subscribe-btn').length > 0) {
                    curr_ele.parents('form').find('#subscribe-btn').attr('disabled', true);
                }
            }, success: function (response) {
                //start - Updated on 26-07-2023
                jQuery('.fm-submit-loading').hide();
                //end - Updated on 26-07-2023
                if (response.msg !== '') {
                    
                   if (curr_ele.parents('.wdform_row').find('#validate_email_error_1').length > 0) {
                        jQuery('#validate_email_error_1').html(response.msg);
                        jQuery('#validate_email_error_1').show();
                        //start - Updated on 26-07-2023
                        jQuery('#validate_email_error_1').parents('.wdform_row').find('.wdform-label').addClass('error_label');
                        //end - Updated on 26-07-2023
                    } else {
                        curr_ele.parents('.wdform_row').append('<div id="validate_email_error_1" class="fm-not-filled">' + response.msg + '</div>');
                    }
                    curr_ele.parents('form').find('.button-submit').attr('disabled', true);
                    jQuery('#check_email_4_9').hide();
                    jQuery('#check_email_2_7').hide();
                    jQuery('#check_email_3_12').hide();

                    if (curr_ele.parents('form').find('#subscribe-btn').length > 0) {
                        curr_ele.parents('form').find('#subscribe-btn').attr('disabled', true);
                    }
                } else {
                    //Updated on 24/07
                    if (jQuery("#privacy_policy > input").is(":checked")) {
                        curr_ele.parents('form').find('.button-submit').removeAttr('disabled');
                    } else {
                        curr_ele.parents('form').find('.button-submit').attr('disabled', true);
                    }

                    jQuery('#validate_email_error_1').hide();

                    if (curr_ele.parents('form').find('#subscribe-btn').length > 0) {
                        curr_ele.parents('form').find('#subscribe-btn').removeAttr('disabled');
                    }
                }
            }, error: function () {
                //Commented on 24/07
                //curr_ele.parents('form').find('.button-submit').removeAttr('disabled');
            }
        });
    }
});
jQuery(document).on('click', '#save_form', function () {
    if (jQuery(".user-registration form.register").valid()) {
        jQuery('.ur-form-row-1').hide();
        jQuery('.ur-form-row-2').attr("style", "display: flex !important");
        jQuery('#register_button').show();
        jQuery('#save_form').hide();
        jQuery('.go-back').show();

        jQuery('#save_form').removeAttr('disabled');

        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: td_ajax_url,
            data: {action: "validate_email", email_id: jQuery(this).val()},
            success: function (response) {
                if (response.msg != "") {
                    jQuery('.td_display_err').html(response.msg).show();
                    jQuery('#save_form').attr('disabled', 'true');
                } else {
                    jQuery('.td_display_err').hide();
                    jQuery('#save_form').removeAttr('disabled');

                    if (jQuery(".chosen-select").length > 0) {
                        jQuery(".chosen-container").css('width', '100%');
                    }
                }
            }
        });
    } else {
        jQuery('.td_display_err').html('(*) Mandatory fields.');
        jQuery('.td_display_err').show();
    }
});
jQuery(document).on('click', '.go-back', function () {
    jQuery('.ur-form-row-1').show();
    jQuery('.ur-form-row-2').hide();
    jQuery('#register_button').hide();
    jQuery('#save_form').show();
    jQuery('.go-back').hide();
    jQuery('.td_display_err').hide();
});
jQuery(document).on('blur', '#user_email', function () {
    var curr_val = jQuery(this).val();
    if (curr_val != '') {
        jQuery.ajax({
            type: "get",
            dataType: "json",
            url: td_ajax_url,
            data: {'action': "validate_email", 'email_id': jQuery(this).val()},
            beforeSend: function () {
                jQuery('#email-spinner').show();
                jQuery('#save_form').attr('disabled', 'true');
                jQuery('#submit-button').attr('disabled', 'true');
                jQuery('.register-submit-button').attr('disabled', 'true');
                jQuery('#register_button').removeAttr('disabled');
                jQuery('#user_email_field').find('.user-registration-error').remove();
            },
            success: function (response) {
                if (response.msg != "") {
                    jQuery('#save_form').attr('disabled', 'true');
                    jQuery('#submit-button').attr('disabled', 'true');
                    jQuery('.register-submit-button').attr('disabled', 'true');
                    jQuery('#register_button').attr('disabled', 'true');
                    jQuery('#user_email_field').append('<label id="" class="user-registration-error" for="">' + response.msg + '</label>');

                } else {
                    jQuery('#save_form').removeAttr('disabled');
                    jQuery('#submit-button').removeAttr('disabled');
                    jQuery('.register-submit-button').removeAttr('disabled');
                    jQuery('#register_button').removeAttr('disabled');
                    jQuery('#user_email_field').find('.user-registration-error').remove();
                }
                jQuery('#email-spinner').hide();
            }
        });
    }
});
jQuery(document).ready(function () {

    jQuery('.post-template-default').find('.a2a_floating_style,.addtoany_share_save_container').hide();

    jQuery(".chosen-select").chosen();

    if (jQuery(".chosen-select").length > 0) {
        jQuery(".chosen-container").css('width', '100%');
    }
//    jQuery(".chosen-select").chosen({disable_search_threshold: 10});
    //ARIA-LABEL for Search Button
    if (jQuery('.tdb-head-search-btn').length > 0) {
        jQuery('.tdb-head-search-btn').attr('aria-label', 'Search Button');
    }

    if (jQuery('.tdb-head-usr-avatar').length > 0) {
        jQuery('.head-subscribe-btn').hide();
    }
//    if(jQuery('.ctis-load-more').length > 0) {
//        jQuery('.ctis-load-more button').append('<i class="td-icon-font td-icon-menu-down"></i>');
//    }
//    
//    jQuery('.ctis-load-more').load(function() {
//        alert('hello');
//        jQuery('.ctis-load-more button').append('<i class="td-icon-font td-icon-menu-down"></i>');
//    });

    if (jQuery('.user-registration-MyAccount-navigation').length > 0) {
        jQuery('.user-registration-MyAccount-navigation-link--user-logout').remove();
    }

    jQuery('#create-acc').click(function () {
        jQuery("#register-block").show();
        //login-block
        jQuery("#login-block").hide();
    });

    jQuery('#go-login').click(function () {
        jQuery("#register-block").hide();
        //login-block
        jQuery("#login-block").show();
    });

    jQuery('#passwordless-login-btn').click(function () {
        jQuery('#passwordless-login-div').show();
        jQuery(this).hide();
    });

    if (jQuery('#landing-page1-modal').length > 0) {
        jQuery(window).scroll(function () {
            if (jQuery(document).height() <= (jQuery(window).height() + jQuery(window).scrollTop())) {
                jQuery('#landing-page1-modal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
        jQuery('#get-details-btn').click(function () {
            jQuery('#landing-page1-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    }

    jQuery('.download-btn').click(function () {
        if (jQuery(window).width() > 979) {
            jQuery('.download-form').show('slow');
        } else {
            jQuery('.mobile-download-form').show('slow');
        }
        jQuery('.download-btn').hide();
    });

    if (jQuery('.thank-you-page').length > 0) {
        if (jQuery(window).width() > 979) {
            jQuery('#subscription-form').show('slow');
        } else {
            jQuery('#mobile-subscription-form').show('slow');
        }
    }

    jQuery('.custom-control-input').click(function () {
        var curr_ele = jQuery(this);
        var chkEmail = jQuery('.subs_validate_email').val();
        var box_checked = 'false';
        jQuery('.custom-control-input').each(function () {
            if (jQuery(this).is(":checked")) {
//                alert('hello');
                box_checked = 'true';
            }
        });

        if (box_checked === 'false' || chkEmail === '') {
            jQuery('#subscribe-btn').attr('disabled', true);
        } else {
            jQuery('#subscribe-btn').removeAttr('disabled');
        }
    });

    jQuery('#subscribe-btn').click(function (e) {
        var curr_ele = jQuery(this);
        var email_ele = curr_ele.parents('.btn-row').find('.subs_validate_email');
        console.log('Hello');
//        console.log(email_ele.val());
//        console.log(email_ele.val() === '');
//        console.log(email_ele.val().length > 0);
        if (email_ele.val().length > 0) {
            validate_subscribe_email(email_ele, true, curr_ele);
        } else {
            jQuery('#validate_email_error_1').html('Please enter Email Address');
            jQuery('#validate_email_error_1').show();
        }

    });

    jQuery('#subscribe-update-btn').click(function (e) {
        var form = jQuery('form#subscription-form');
        jQuery.ajax({
            type: "get",
            dataType: "json",
            url: td_ajax_url,
            data: {'action': "update_subscribe_form", 'data': form.serializeArray()},
            beforeSend: function () {
            }, success: function (response) {
                if (response.status === 'success') {
                    jQuery('.subscribe-form-block').html('<p class="alert alert-success">Your preferences are successfully updated.</p>');
                }
            }, error: function () {
            }
        });
    });

    //Subscription - Resend verification link to user
    jQuery('#resend-subscribe-link').click(function (e) {
        var form = jQuery('form#subscription-form');
        jQuery.ajax({
            type: "get",
            dataType: "json",
            url: td_ajax_url,
            data: {'action': "subscribe_resend_verification_link", 'data': form.serializeArray()},
            beforeSend: function () {
            }, success: function (response) {
                if (response.status === 'success') {
                    jQuery('.subscribe-form-block').html('<p class="alert alert-success">Please check your email for the new verification link.</p>');
                }
            }, error: function () {
            }
        });
    });


    jQuery(function () {
        if (jQuery(window).width() > 580) {
            setTimeout(function () {
                if (jQuery('#resource-modal').data('popup-displayed') === 'hidden' && !jQuery('#exit-modal').hasClass('show')) {
                    jQuery.ajax({
                        type: "get",
                        dataType: "json",
                        url: td_ajax_url,
                        data: {'action': "save_resource_modal_data"},
                        beforeSend: function () {
                        }, success: function (response) {
                            if (response.msg === 'success') {
                                jQuery('#resource-modal').modal({
                                    //                                backdrop: 'static',
                                    keyboard: false
                                });
                                jQuery('#resource-modal').data('popup-displayed', 'shown');
                            }
                        }, error: function () {
                        }
                    });
                }
            }, 30 * 1000);
        }
    });


    // var timerID = setInterval(function () {
    //     jQuery.ajax({
    //         type: "get",
    //         dataType: "json",
    //         url: td_ajax_url,
    //         data: {'action': "fetch_posts", "shown_posts": JSON.stringify(glob_shown_posts)},
    //         beforeSend: function () {
    //         }, success: function (response) {
    //             if (response.status == 'success' && jQuery(window).width() > 580) {
    //                 toastr.options = {
    //                     "closeButton": true,
    //                     "debug": false,
    //                     "newestOnTop": true,
    //                     "progressBar": true,
    //                     "positionClass": "toast-bottom-left",
    //                     "preventDuplicates": true,
    //                     "onclick": function () {
    //                         window.location.replace(response.data.permalink);
    //                     },
    //                     "showDuration": "300",
    //                     "hideDuration": "1000",
    //                     "timeOut": 10 * 1000,
    //                     "extendedTimeOut": 0,
    //                     "showEasing": "swing",
    //                     "hideEasing": "linear",
    //                     "showMethod": "fadeIn",
    //                     "hideMethod": "fadeOut",
    //                     "tapToDismiss": false,
    //                     "maxOpened": 1,
    //                     "closeOnHover": false,
    //                 };
    //                 toastr["info"](response.data.user_name + ' from ' + response.data.user_state + ' has downloaded "' + response.data.post_title + '" ' + response.data.resource_type);
    //                 glob_shown_posts.push(response.data.id);
    //             }
    //         }, error: function () {
    //         }
    //     });
    // }, 150 * 1000);

    // START -- Increment the blog views by 100
    if (jQuery('.blog-views').length > 0) {
        jQuery(".blog-views").find(".td-fix-index span:last-child").addClass('blog-view_count');
        if (jQuery(".blog-view_count").html() != '') {
            var count = jQuery(".blog-view_count").html();
            jQuery(".blog-view_count").html((parseInt(count) + 100));
        }
    }
    // END -- Increment the blog views by 100



    if (jQuery(document).find('[data-toggle="tooltip"]').length > 0) {
        jQuery('[data-toggle="tooltip"]').tooltip();
    }
});
jQuery(".subscribers-title").ready(function () {
    jQuery('.count').each(function () {
        jQuery(this).prop('Counter', 0).animate({
            Counter: jQuery(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                jQuery(this).text(Math.ceil(now));
            }
        });
    });
});