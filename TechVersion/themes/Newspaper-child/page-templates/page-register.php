<?php
/*
 * Template Name: Register Form
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

                                    <form class="register" autocomplete="no" method="post" novalidate="novalidate" data-enable-strength-password="" data-minimum-password-strength="3">
                                        <?php the_content(); ?>
                                        <input type="hidden" name="ur-user-form-id" value="<?php echo absint($form_id); ?>"/>
                                        <input type="hidden" name="ur-redirect-url" value="<?php echo $redirect_url; ?>"/>
        <?php wp_nonce_field('ur_frontend_form_id-' . $form_id, 'ur_frontend_form_nonce', false); ?>

                                    </form></div>
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