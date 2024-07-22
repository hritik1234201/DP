<?php

/**
 * Adds a Setting Page for Social Media Links and Logo URL
 * 
 */
function dbi_add_settings_page() {
    add_options_page('Media Property Settings', 'Media Property Settings', 'manage_options', 'media-properties-settings', 'mp_settings_page_callback');
    //call register settings function
    add_action( 'admin_init', 'register_mp_settings' );
}

add_action('admin_menu', 'dbi_add_settings_page');



//add_action('admin_menu', 'resources_register_ref_page');
//function mp_settings_page() {
//    add_menu_page(
//        'edit.php?post_type=resources',
//        __( 'Resource Settings', text_Domain ),
//        __( 'Resource Settings', text_Domain ),
//        'manage_options',
//        'resources-settings',
//        'resources_ref_page_callback'
//    );
//	
//	//call register settings function
//	add_action( 'admin_init', 'register_resources_settings' );
//}
//
function register_mp_settings() {
	//register our settings
	register_setting( 'mp-settings-group', 'facebook_link' );
	register_setting( 'mp-settings-group', 'twitter_link' );
	register_setting( 'mp-settings-group', 'linkedin_link' );
	register_setting( 'mp-settings-group', 'instagram_link' );
	register_setting( 'mp-settings-group', 'email_logo_url' );
}

/**
 * Display callback for the submenu page.
 */
function mp_settings_page_callback() {
    ?>
    <style>
        /*for admin settings page of resources*/
        .field-width-100{
            width:100%;
        }
    </style>
    <div class="wrap form-fields-100">
        <h1><?php _e('Media Property - Settings', text_Domain); ?></h1>
        <div class="wrap">

            <form method="post" action="options.php">
                <?php settings_fields('mp-settings-group'); ?>
                <?php do_settings_sections('mp-settings-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Social Media Links - Facebook</th>
                        <td><input type="text" name="facebook_link" class="field-width-100" value="<?php echo esc_attr(get_option('facebook_link')); ?>" /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Social Media Links - Twitter</th>
                        <td><input type="text" name="twitter_link" class="field-width-100" value="<?php echo esc_attr(get_option('twitter_link')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Social Media Links - LinkedIn</th>
                        <td><input type="text" name="linkedin_link" class="field-width-100" value="<?php echo esc_attr(get_option('linkedin_link')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Social Media Links - Instagram</th>
                        <td><input type="text" name="instagram_link" class="field-width-100" value="<?php echo esc_attr(get_option('instagram_link')); ?>" /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Email Template - Logo URL</th>
                        <td><input type="text" name="email_logo_url" class="field-width-100" value="<?php echo esc_attr(get_option('email_logo_url')); ?>" /></td>
                    </tr>

                </table>

                <?php submit_button(); ?>

            </form>
        </div>
    </div>
    <?php
}