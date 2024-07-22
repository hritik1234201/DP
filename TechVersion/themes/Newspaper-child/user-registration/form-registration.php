<?php
/**
 * User Registration Form
 *
 * Shows user registration form
 *
 * This template can be overridden by copying it to yourtheme/user-registration/form-registration.php.
 *
 * HOWEVER, on occasion UserRegistration will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.wpeverest.com/user-registration/template-structure/
 * @author  WPEverest
 * @package UserRegistration/Templates
 * @version 1.0.0
 */

/**
 * @var $form_data_array array
 * @var $form_id         int
 * @var $is_field_exists boolean
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$frontend       = UR_Frontend::instance();
$form_template  = ur_get_form_setting_by_key( $form_id, 'user_registration_form_template', 'Default' );
$custom_class   = ur_get_form_setting_by_key( $form_id, 'user_registration_form_custom_class', '' );
$redirect_url   = ur_get_form_setting_by_key( $form_id, 'user_registration_form_setting_redirect_options', '' );
$template_class = '';

if ( 'Bordered' === $form_template ) {
	$template_class = 'ur-frontend-form--bordered';

} elseif ( 'Flat' === $form_template ) {
	$template_class = 'ur-frontend-form--flat';

} elseif ( 'Rounded' === $form_template ) {
	$template_class = 'ur-frontend-form--rounded';

} elseif ( 'Rounded Edge' === $form_template ) {
	$template_class = 'ur-frontend-form--rounded ur-frontend-form--rounded-edge';
}

$custom_class = apply_filters( 'user_registration_form_custom_class', $custom_class, $form_id );

/**
 * @since 1.5.1
 */
do_action( 'user_registration_before_registration_form', $form_id );
?>

<style>



#user_pass-error{
	margin-top: 0px !important;
}
/*
label#user_email-error {
    margin-top: 6px !important;
}
*/


.login-form-col-2 .ur-frontend-form input.input-text{
	margin-bottom: 18px !important;
}

input::placeholder {
    color: #e4dddd !important;
}

.user-registration-form__label-for-checkbox span {
    color: #000000 !important;
}

.form-check-a {
    color: #12a555;
    text-decoration: underline;
}

input::placeholder {
    color: #948c8c !important;
}

input {
    border: 1px solid #ccc !important;
}

/*

label#company_name-error{
	margin-top: 6px !important;
}

label#first_name-error{
	margin-top: 6px !important;
}

label#last_name-error{
	margin-top: 6px !important;
}
 */
 
.lost_reset_password .user-registration-Button, #register_button {
    background-color: #12a555 !important;
    border-color: #12a555 !important;
}


</style>

	<div class='user-registration ur-frontend-form <?php echo $template_class . ' ' . $custom_class; ?>' id='user-registration-form-<?php echo absint( $form_id ); ?>'>
		<form method='post' autocomplete="no" class='register' data-enable-strength-password="<?php echo $enable_strong_password; ?>" data-minimum-password-strength="<?php echo $minimum_password_strength; ?>" <?php echo apply_filters( 'user_registration_form_params', '' ); ?>>

			<?php
                        
			do_action( 'user_registration_before_form_fields', $form_data_array, $form_id );
                        ?>
						
						 <div class="td_display_err" style="display: none; color: #fff; margin: 0 auto; padding: 10px; margin-bottom: 10px;"></div>
						 
					

						
                        <div class="ur-form-row-1">
                            <div class="ur-form-grid">
                                <div class="ur-field-item field-user_email">
                                    <div class="form-row validate-required user-registration-validated td-login-inputs" id="user_email_field" data-priority="">
                                        <input data-rules="" data-id="user_email" placeholder="Business Email *" type="email" class="input-text input-email ur-frontend-field td-login-input" name="user_email" id="user_email" value="" required="required" data-label="User Email" aria-invalid="true">
                                        <i class="fas fa-spin fa-spinner hide-ele" id="email-spinner"></i>
                                      <!--  <label for="user_email" class="ur-label">Business Email <abbr class="required" title="required">*</abbr></label> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ur-form-row-1">
                            <div class="ur-form-grid set-relative">
                                <div class="ur-field-item field-user_pass">
                                    <div class="form-row validate-required user-registration-validated td-login-inputs set-relative" id="user_pass_field" data-priority="">
                                        <input data-rules="" data-id="user_pass" type="password" placeholder="Password *" class="input-text input-password ur-frontend-field td-login-input" name="user_pass" id="user_pass" value="" minlength="8" required="required" data-label="Password" aria-invalid="true">
                                   <!--     <label for="user_pass" class="ur-label">Password <abbr class="required" title="required">*</abbr></label> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="ur-form-row-1" id="" >
                            <div class="ur-form-grid">
                                <div class="ur-field-item field-select">
                                    <div class="form-row validate-required td-login-inputs" id="company_name_field" data-priority="">
                                        <input data-rules="" data-id="company_name" placeholder="Company Name *" type="text" class="input-text input-text ur-frontend-field td-login-input" name="company_name" id="company_name" value="" required="required" data-label="Company Name" maxlength="20" aria-invalid="true">
                                        <!-- <label for="company_name" class="ur-label">Company Name <abbr class="required" title="required">*</abbr></label> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        
						<div class="ur-form-row-1" id="" >
                            <div class="ur-form-grid">
                                <div class="ur-field-item field-first_name">
                                    <div class="form-row validate-required td-login-inputs" id="first_name_field" data-priority="">
                                        <input data-rules="" data-id="first_name" placeholder="First Name *" type="text" class="input-text input-text ur-frontend-field td-login-input" name="first_name" id="first_name" value="" required="required" data-label="First Name" aria-invalid="true">
                                        <!-- <label for="first_name" class="ur-label">First Name <abbr class="required" title="required">*</abbr></label> -->
                                    </div>
                                </div>
                            </div>
							</div>
							
							
							<div class="ur-form-row-1" id="" >
                            <div class="ur-form-grid">
                                <div class="ur-field-item field-last_name">
                                    <div class="form-row td-login-inputs" id="last_name_field" data-priority="">
                                        <input data-rules="" data-id="last_name" type="text" placeholder="Last Name *" class="input-text input-text ur-frontend-field td-login-input" name="last_name" id="last_name" value="" required="required" data-label="Last Name" aria-invalid="true">
                                      <!--  <label for="last_name" class="ur-label">Last Name <abbr class="required" title="required">*</abbr></label> -->
                                    </div>
                                </div>
                            </div>
							</div>
                        
                    
                        <?php
			do_action( 'user_registration_after_form_fields', $form_data_array, $form_id );
                        ?>
                        <div class="ur-form-row-2 check-text form-margin-top-10" id="">
                            <div class="ur-form-grid">
                                <div class="ur-field-item field-newsletter_check">
                                    <label class="user-registration-form__label user-registration-form__label-for-checkbox inline container-label set-relative">
                                        <input class="user-registration-form__input user-registration-form__input-checkbox register_check form-margin-top-0" name="newsletter_check" type="checkbox" id="newsletter_check" value="forever" /> <span><?php _e( 'Yes, I want to receive emails from TechVersions that may be of interest to me.', 'user-registration-terms' ); ?></span>
                                    <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                            
                        <div class="ur-form-row-2 check-text set-relative" id="">
                            <div class="ur-form-grid">
                                <div class="ur-field-item field-privacy_check">
                                        <label class="user-registration-form__label user-registration-form__label-for-checkbox inline container-label set-relative">
                                            <input class="user-registration-form__input user-registration-form__input-checkbox register_check form-margin-top-0" name="privacy_check" type="checkbox" id="privacy_check" value="forever" required="true" /> <span>

                                                By registering, I agree to TechVersion's (c/o Anteriad) <a class="form-check-a" target="_blank" href="<?php echo site_url('terms-of-service') ?>">Terms of Service</a> and <a class="form-check-a" href="https://anteriad.com/privacy-policy/" target="_blank">Privacy Policy</a>. I also understand that I can review and update my marketing preferences at any time.


                                                <!-- I understand by creating an account, I agree to TechVersion's <a class="form-check-a" href="<?php //echo site_url('terms-of-service') ?>">Terms of Use</a> and <a class="form-check-a" href="<?php //echo site_url('privacy-policy') ?>">Privacy Policy</a> and that I may review and update my marketing preferences at any time. Check this to turn on GDPR related features and enhancement. Read our <a class="form-check-a" href="<?php //echo site_url('gdpr-general-data-protection-regulation'); ?>">GDPR DOCUMENTATION</a> to learn more.
 -->

                                                <abbr class="required" title="required">*</abbr></span>
                                            <span class="checkmark"></span>
                                        </label>
                                    <!--</div>-->
                                </div>
                            </div>
                        </div>
                        <div class="ur-form-row-2 check-text captcha-block set-relative" id=""><!-- display:none; -->
                            <div class="ur-form-grid">
<!--                                <div class="google-captcha-notice">This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.</div>-->
                            </div>
                        </div>



                        
                        <!--</div>-->
                        <?php
			if ( $is_field_exists ) {
				?>
					<?php
					if ( ! empty( $recaptcha_node ) ) {
						echo '<div id="ur-recaptcha-node" style="width:100px;max-width: 100px;"> ' . $recaptcha_node . '</div>';
					}

					$btn_container_class = apply_filters( 'user_registration_form_btn_container_class', array(), $form_id );
					?>
					<div class="ur-button-container <?php echo esc_html( implode( ' ', $btn_container_class ) ); ?>" >
						<?php
						do_action( 'user_registration_before_form_buttons', $form_id );

						$submit_btn_class = apply_filters( 'user_registration_form_submit_btn_class', array(), $form_id );
						?>

                                            <button type="submit" disabled="true" class="btn button ur-submit-button <?php echo esc_html( implode( ' ', $submit_btn_class ) ); ?>">
							<span></span>
							<?php
							$submit = ur_get_form_setting_by_key( $form_id, 'user_registration_form_setting_form_submit_label' );
								echo ur_string_translation( $form_id, 'user_registration_form_setting_form_submit_label', $submit );
							?>
						</button>

						<?php do_action( 'user_registration_after_form_buttons', $form_id ); ?>
					</div>
					<?php
			}

			if ( count( $form_data_array ) == 0 ) {
				?>
						<h2><?php echo esc_html__( 'Form not found, form id :' . $form_id, 'user-registration' ); ?></h2>
					<?php
			}
			?>
                        <div class="ur-button-container ur-form-row-2 form-no-padding-margin">
                            <button type="submit" class="wpb_button btn td-login-button ur-submit-button " id="register_button">
                                <span></span>Register
                            </button>
                        </div>
						
                        <!-- <div class="ur-button-container save-form-btn form-padding-0">
                            <button type="button" class="wpb_button btn td-login-button ur-submit-button" id="save_form">
                                <span></span>Submit
                            </button>
                        </div> -->
			<div class="clearfix"></div>
                        <div class="ur-form-grid">
			<input type="hidden" name="ur-user-form-id" value="<?php echo absint( $form_id ); ?>"/>
                        <input type="hidden" name="ur-redirect-url" class="ur-frontend-field" value="<?php echo site_url('sign-in') . '?msg=registered'; ?>"/>
			<?php wp_nonce_field( 'ur_frontend_form_id-' . $form_id, 'ur_frontend_form_nonce', false ); ?>
                        </div>
                        
			<?php do_action( 'user_registration_form_registration_end', $form_id ); ?>
		</form>
		
		
		<div class="back-to-home">
                                                    <a href="https://techversions.com/sign-in"><i class="fa fa-chevron-left" aria-hidden="true"></i>  Go Back</a>
                                                </div>

		<div class="clearfix"></div>
	</div>
<?php

/**
 * User registration form template.
 *
 * @since 1.0.0
 */
do_action( 'user_registration_form_registration', $form_id );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
