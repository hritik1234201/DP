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

function register_mp_settings() {
	//register our settings
	register_setting( 'mp-settings-group', 'facebook_link' );
	register_setting( 'mp-settings-group', 'twitter_link' );
	register_setting( 'mp-settings-group', 'linkedin_link' );
	register_setting( 'mp-settings-group', 'instagram_link' );
	register_setting( 'mp-settings-group', 'logo_link' );
	register_setting( 'mp-settings-group', 'p_color1' );
	register_setting( 'mp-settings-group', 'p_color2' );
//	register_setting( 'mp-settings-group', 'daily_unsub_title' );
//	register_setting( 'mp-settings-group', 'daily_unsub_desc' );
//	register_setting( 'mp-settings-group', 'weekly_unsub_title' );
//	register_setting( 'mp-settings-group', 'weekly_unsub_desc' );
//	register_setting( 'mp-settings-group', 'monthly_unsub_title' );
//	register_setting( 'mp-settings-group', 'monthly_unsub_desc' );
}
function mp_settings_page_callback() {
    ?>
    <style>
        /*for admin settings page of resources*/
        .field-width-100{
            width:100%;
        }
		.field-width-50{
            width:50%;
        }
    </style>
    <div class="wrap form-fields-100">
        <h1><?php _e('Media Property Settings', 'newzmania'); ?></h1>
        <div class="wrap">

            <form method="post" action="options.php">
                <?php settings_fields('mp-settings-group'); ?>
                <?php do_settings_sections('mp-settings-group'); ?>
                <table class="form-table">
					
					<tr valign="top">
						<th scope="row"><h2>Social Media Links</h2></th>
					</tr>
					
                    <tr valign="top">
                        <th scope="row">Logo URL</th>
                        <td><input type="text" name="logo_link" class="field-width-100" value="<?php echo esc_attr(get_option('logo_link')); ?>" /></td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">Primary Color 1</th>
                        <td><input type="text" name="p_color1" class="field-width-100" value="<?php echo esc_attr(get_option('p_color1')); ?>" /></td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">Primary Color 2</th>
                        <td><input type="text" name="p_color2" class="field-width-100" value="<?php echo esc_attr(get_option('p_color2')); ?>" /></td>
                    </tr>
					
                    <tr valign="top">
                        <th scope="row">Facebook URL</th>
                        <td><input type="text" name="facebook_link" class="field-width-100" value="<?php echo esc_attr(get_option('facebook_link')); ?>" /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Twitter URL</th>
                        <td><input type="text" name="twitter_link" class="field-width-100" value="<?php echo esc_attr(get_option('twitter_link')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">LinkedIn URL</th>
                        <td><input type="text" name="linkedin_link" class="field-width-100" value="<?php echo esc_attr(get_option('linkedin_link')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Instagram URL</th>
                        <td><input type="text" name="instagram_link" class="field-width-100" value="<?php echo esc_attr(get_option('instagram_link')); ?>" /></td>
                    </tr>
					
<!--					<tr valign="top">
						<th scope="row"><h2>Sendgrid Settings</h2></th>
					</tr>-->

<!--                    <tr valign="top">
                        <th scope="row">Daily Unsubsribe Group Title</th>
                        <td><input type="text" name="daily_unsub_title" class="field-width-50" value="<?php echo esc_attr(get_option('daily_unsub_title')); ?>" /></td>
                    </tr>
					
                    <tr valign="top">
                        <th scope="row">Daily Unsubsribe Group Description</th>
                        <td><input type="text" name="daily_unsub_desc" class="field-width-100" value="<?php echo esc_attr(get_option('daily_unsub_desc')); ?>" /></td>
                    </tr>
					
                    <tr valign="top">
                        <th scope="row">Weekly Unsubsribe Group Title</th>
                        <td><input type="text" name="weekly_unsub_title" class="field-width-50" value="<?php echo esc_attr(get_option('weekly_unsub_title')); ?>" /></td>
                    </tr>
					
                    <tr valign="top">
                        <th scope="row">Weekly Unsubsribe Group Description</th>
                        <td><input type="text" name="weekly_unsub_desc" class="field-width-100" value="<?php echo esc_attr(get_option('weekly_unsub_desc')); ?>" /></td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">Monthly Unsubsribe Group Title</th>
                        <td><input type="text" name="monthly_unsub_title" class="field-width-50" value="<?php echo esc_attr(get_option('monthly_unsub_title')); ?>" /></td>
                    </tr>
					
                    <tr valign="top">
                        <th scope="row">Monthly Unsubsribe Group Description</th>
                        <td><input type="text" name="monthly_unsub_desc" class="field-width-100" value="<?php echo esc_attr(get_option('monthly_unsub_desc')); ?>" /></td>
                    </tr>-->
					
                </table>

                <?php submit_button(); ?>

            </form>
        </div>
    </div>
    <?php
}