<?php
/*
 * Template Name: Register Form Ram
 */
get_header();
$value = get_option( 'total_followers', '' );
?>
<style type="text/css">
    /*    @media only screen and (max-width: 600px) {
            .td-ss-main-content {
                width: 100%
            }
        }
        @media only screen and (min-width: 601px) {
            .td-ss-main-content {
                width: 60%
            }
        }*/
		
		
		.ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=date], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=email], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=number], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=password], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=text], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=url], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid select, .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid textarea{
			
			color:#000 !important;
			border-bottom:0px !important;
			    background: #fff !important;
		}
		
		.ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid label, .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid legend{
			color: #333;
			font-weight: 400 !important;
			margin-left:0px !important;
		}
		
		
	p label	{
		color: #333;
		}
		
		.user-registration-form__label-for-checkbox {
    font-size: 12px;
}

.user-registration-form__label-for-checkbox span{
	color: #333;
}

a.form-check-a {
    color: #04a353;
}
		
</style>
<div class="td-main-content-wrap td-container-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php
            
            // echo tagdiv_page_generator::get_breadcrumbs(array(
//                    'template' => 'page',
//                    'page_title' => get_the_title(),
//                )); 
            ?>
        </div>
        <?php
        $form_id = (isset($form_id) && !empty($form_id)) ? $form_id : 3312;

        $redirect_url = ur_get_form_setting_by_key($form_id, 'user_registration_form_setting_redirect_options', '');
        ?>
        <div class="td-pb-row" style="text-align: center;display: block;min-height: 1px;float: none !important;padding-right: 24px;padding-left: 24px;position: relative;margin: 0 auto;">
            <div class="td-pb-span12 td-main-content">
                <div class="td-ss-main-content" style="margin: 0 auto;text-align: left">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) : the_post();
                            ?>
                            <div class="td-page-header">
                                <!--                                        
-->                                <h1 class="entry-title td-page-title text-center">
                                    <span>JOIN <?php echo $value; ?>+ IT DECISION MAKERS FOR FREE.</span>
                                </h1>
                                <!--<h1 class="text-center"></h1>-->
                                
                                <h4 class="text-center">Access our premium content on the latest technology trends worldwide. We carefully analyze and produce fresh content to keep our audience engaged and happy.</h4>
                            </div>
                            <div class="td-page-content tagdiv-type">

                                <div id="user-registration-form-3312" class="registration-form user-registration ur-frontend-form ur-frontend-form--bordered ">
                                    <!--<p class="text-center"><b>Access our premium content on the latest technology trends worldwide. We carefully analyze and produce fresh content to keep our audience engaged and happy.</b></p>-->
                                    <div class="td_display_err" style="display: none; color: #fff; margin: 0 auto; padding: 10px; margin-bottom: 10px;"></div>
                                        <?php apply_filters('user_registration_login_form_before_notice', ur_print_notices()); ?>

                                    
									
									<form method='post' autocomplete="off" class='register' data-enable-strength-password="<?php echo $enable_strong_password; ?>" data-minimum-password-strength="<?php echo $minimum_password_strength; ?>" <?php echo apply_filters('user_registration_form_params', ''); ?>>

        <?php
        do_action('user_registration_before_form_fields', $form_data_array, $form_id);
        ?>
		
		
		 
            <div class="ur-form-grid">
                <label class="ur-label">Business Email * </label>
                    <p class="user-registration-form-row user-registration-form-row--wide form-row form-row-wide" id="user_email_field" data-priority="">					
                        <input data-rules="" data-id="user_email" type="email" class="input-text input-email ur-frontend-field td-login-input" name="user_email" id="user_email" value="" required="required" data-label="User Email" aria-invalid="true">
                        <!--<i class="fas fa-spin fa-spinner hide-ele" id="email-spinner"></i>-->
                    </p>
        </div>
		
		
		
            <div class="ur-form-grid">        
				<label class="ur-label"> Password * </label>
                    <p class="user-registration-form-row user-registration-form-row--wide form-row form-row-wide" id="user_pass_field" data-priority="">
                        <input data-rules="" data-id="user_pass" type="password" class="input-text input-password ur-frontend-field td-login-input" name="user_pass" id="user_pass" value="" required="required" data-label="Password" aria-invalid="true">
                    </p>                
        </div>
		
		
            <div class="ur-form-grid">
        		<label class="ur-label"> Company Name * </label>
                    <p class="user-registration-form-row user-registration-form-row--wide form-row form-row-wide" id="company_name_field" data-priority="">
                        <input data-rules="" data-id="company_name" type="text" class="input-text input-text ur-frontend-field td-login-input" name="company_name" id="company_name" value="" required="required" data-label="Company Name" maxlength="20" aria-invalid="true">
                    </p>
                </div>
        
       
		    <div class="ur-form-grid">
                <label class="ur-label">First Name * </label>
                    <p class="user-registration-form-row user-registration-form-row--wide form-row form-row-wide" id="first_name_field" data-priority="">
                        <input data-rules="" data-id="first_name" type="text" class="input-text input-text ur-frontend-field td-login-input" name="first_name" id="first_name" value="" required="required" data-label="First Name" aria-invalid="true" >
                    </p>
                </div>
            
			<div class="ur-form-grid">
                <label class="ur-label">Last Name * </label>
                    <p class="user-registration-form-row user-registration-form-row--wide form-row form-row-wide" id="last_name_field" data-priority="">
                        <input data-rules="" data-id="last_name" type="text" class="input-text input-text ur-frontend-field td-login-input" name="last_name" id="last_name" value="" required="required" data-label="Last Name" aria-invalid="true">
                    </p>
                </div>
            

       
         
		
       

<div class="form-group">
            <div class="ur-form-grid">
                <div class="ur-field-item field-newsletter_check" style="font-size:14px;">
                    <label class="user-registration-form__label user-registration-form__label-for-checkbox inline container-label set-relative">
                        <input class="user-registration-form__input user-registration-form__input-checkbox register_check form-margin-top-0" name="newsletter_check" type="checkbox" id="newsletter_check" value="forever" /> <span><?php _e(' Yes, I want to receive emails from TechVersions that may be of interest to me.'); ?></span>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 40px;">
            <div class="ur-form-grid">
                <div class="ur-field-item field-privacy_check" style="font-size:14px;">
                    <label class="user-registration-form__label user-registration-form__label-for-checkbox inline container-label set-relative">
                        <input class="user-registration-form__input user-registration-form__input-checkbox register_check form-margin-top-0" name="privacy_check" type="checkbox" id="privacy_check" required="true" value="checked"/> <span> I understand by creating an account, I agree to TechVersion's <a target="_blank" class="form-check-a" href="<?php echo site_url('terms-of-service') ?>">Terms of Use</a> and <a target="_blank" class="form-check-a" href="<?php echo site_url('privacy-policy') ?>">Privacy Policy</a>  and that I may review and update my marketing preferences at any time. Check this to turn on GDPR related features and enhancement. Read our  <a target="_blank" class="form-check-a" href="<?php echo site_url('gdpr-general-data-protection-regulation'); ?>">GDPR DOCUMENTATION</a> to learn more.<abbr class="required" title="required">*</abbr></span>
                        <span class="checkmark"></span>
                    </label>
                    <!--</div>-->
                </div>
            </div>
        </div>
       

     
        <div class="ur-button-container ur-form-row-2" style="padding: 0; margin-top: 0;" >
            <button type="submit" style="color:#ffffff;border-color: #04a353;background:#04a353;width: 100%" class="button wpb_button btn td-login-button ur-submit-button" id="register_button" disabled="disabled">
                <span></span>Register
            </button>
        </div>
       
       <div class="clearfix"></div>
        <div class="ur-form-grid">
            <input type="hidden" name="ur-user-form-id" value="<?php echo absint($form_id); ?>"/>
            <input type="hidden" name="ur-redirect-url" class="ur-frontend-field" value="<?php echo site_url('sign-in') . '?msg=registered'; ?>"/>
            <?php wp_nonce_field('ur_frontend_form_id-' . $form_id, 'ur_frontend_form_nonce', false); ?>
        </div>

         <?php
        if (!empty($recaptcha_node)) {
            echo '<div id="ur-recaptcha-node" style="width:100px;max-width: 100px;"> ' . $recaptcha_node . '</div>';
        }
        ?>
        <?php do_action('user_registration_form_registration_end', $form_id); ?>
    </form>
									
									
									</div>
                                <div style="clear: both;"></div>
                            </div>
                        <?php
                        endwhile; //end loop
//                                comments_template('', true);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>