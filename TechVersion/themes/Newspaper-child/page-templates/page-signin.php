<?php
/*
 * Template Name: SignIn Form
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
		
		#user-registration{
			background-color: transparent !important;
		}
		
		.user-registration-form__label-for-checkbox span {
    color: #3b4a3f;
}

.registration-form{
	    width: 100% !important;
    background-color: #edeff1;
     padding: 0px !important;
    margin: 0 !important; 
}

.td-page-content {
    width: 60% !important;
    margin: 0 auto !important;
}

input.user-registration-Button.button{
	background-color: #04a353;
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

        <div class="td-pb-row" style="text-align: center;display: block;min-height: 1px;float: none !important;padding-right: 24px;padding-left: 24px;position: relative;margin: 0 auto;">
            <div class="td-pb-span12 td-main-content">
                <div class="td-ss-main-content" style="margin: 0 auto;text-align: left">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) : the_post();
                            ?>
                            <div class="td-page-header">
                                <h1 class="entry-title td-page-title text-center">
                                    <span><?php // the_title() ?>Read What <?php echo $value; ?>+ IT Decision Makers Read Every Day.</span>                          <span><?php // the_title() ?>
                                </h1>
                                <h4 class="text-center">Welcome to TechVersions! Sign in to get full access.</h4>
                            </div>
                            <div class="td-page-content tagdiv-type">
                                <!--<div class="td_display_err" style="display: none; color: #fff; width: 60%; margin: 0 auto; padding: 10px; margin-bottom: 10px;"></div>-->
								
								
								

                                <?php do_action('user_registration_before_customer_login_form'); ?>

                                <div class="registration-form user-registration ur-frontend-form" id=""><!--ur-frontend-form-->
                                    <?php apply_filters('user_registration_login_form_before_notice', ur_print_notices()); ?>
                                    <?php if(isset($_GET['registered'])) { ?>
                                        <div class="user-registration-message">Registered Successfully. Verify your email by clicking on the link sent to your email.</div>
                                    <?php } ?>
                                        <?php if(isset($_GET['password-reset'])) { ?>
                                        <div class="user-registration-message">Password reset successful! Please Sign In</div>
                                    <?php } ?>
                                    <form class="user-registration-form user-registration-form-login" method="post"><!-- login -->

                                        <div class="ur-form-row">
                                            <div class="ur-form-grid">                                            
                                                <?php do_action('user_registration_login_form'); ?>

                                                 <?php if(isset($_GET['msg']) && $_GET['msg'] == 'registered') { ?>
                                           <div class="regsiter-success alert alert-success">Registration has been successful. Please check your email for verification.</div> 
                                            <?php } 
                                            if((isset($_SESSION['registered']) && $_SESSION['registered'] == 'true')|| (isset($_GET['msg']) && $_GET['msg'] == 'verified')) { ?>
                                             <div class="regsiter-success alert alert-success">Your email is successfully verified. Continue to login with your chosen password to explore The TechVersions</div> 
                                            <?php 
                                                unset($_SESSION['registered']);
                                            } ?>
<?php //echo do_shortcode('[user_registration_my_account]'); ?>
<?php echo  do_shortcode('[cr_login_form]'); ?>

<?php //echo do_shortcode('[passwordless-login]'); ?>
                                               

                                                <?php
//                                                $lost_password_enabled = get_option('user_registration_login_options_lost_password', 'yes');

//                                                if ('yes' === $lost_password_enabled) {
                                                    ?>
                                                   
                                                    <?php
//                                                }
                                                ?>

                           
                                                <?php do_action('user_registration_login_form_end'); ?>
												
												
												
                                            </div>
                                        </div>
                                    </form>

                                </div>

                                <?php do_action('user_registration_after_login_form'); ?>

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