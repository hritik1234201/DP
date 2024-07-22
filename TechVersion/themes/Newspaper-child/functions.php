<?php
/*  ----------------------------------------------------------------------------
  Newspaper V9.0+ Child theme - Please do not use this child theme with older versions of Newspaper Theme

  What can be overwritten via the child theme:
  - everything from /parts folder
  - all the loops (loop.php loop-single-1.php) etc
  - please read the child theme documentation: http://forum.tagdiv.com/the-child-theme-support-tutorial/

 */




/*  ----------------------------------------------------------------------------
  add the parent style + style.css from this folder
 */
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 11);
//include_once( get_stylesheet_directory() . '/inc/email-preview.php');
include_once( get_stylesheet_directory() . '/inc/email-preview1.php');
include( get_stylesheet_directory() .'/inc/mp-settings.php');


function theme_enqueue_styles() {
    wp_enqueue_style('td-theme', get_template_directory_uri() . '/style.css', '', TD_THEME_VERSION, 'all');
    wp_enqueue_style('td-theme-child', get_stylesheet_directory_uri() . '/style.css', array('td-theme'), TD_THEME_VERSION . 'c', 'all');

    wp_enqueue_style('fontawesome-all', get_stylesheet_directory_uri() . '/templates/css/all.min.css');
    wp_enqueue_style('custom', get_stylesheet_directory_uri() . '/templates/css/custom.css', array(), '1.15');
    //wp_enqueue_script('stylescss', get_stylesheet_directory_uri() . '/templates/css/styles.css',array(), '1.0');
    wp_enqueue_style('jquery-chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css');
    wp_enqueue_script('customjs', get_stylesheet_directory_uri() . '/templates/js/custom.js', '1.15');
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css');

    wp_enqueue_script('validate', 'https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js');

    wp_enqueue_style('toastr', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
    wp_enqueue_script('jquery.datatables.min', 'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', array('jquery'), '1.0.2', true);
    wp_enqueue_script('toastr', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js');
    wp_enqueue_script('jquery-chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js');
}

/*
 * END - Enqueue style and scripts
 */


/*
 * START - Custom Taxonomy for Marketing Collaterals
 */

function themename_custom_taxonomies() {
    // Post Content Type
//    $type = array(
//        'name' => _x('Marketing Collaterals', 'marketing_collaterals'),
//        'singular_name' => _x('Marketing Collateral', 'marketing_collateral'),
//        'search_items' => __('Search in Marketing Collateral'),
//        'all_items' => __('All Marketing Collaterals'),
//        'most_used_items' => null,
//        'parent_item' => null,
//        'parent_item_colon' => null,
//        'edit_item' => __('Edit Marketing Collateral'),
//        'update_item' => __('Update Marketing Collateral'),
//        'add_new_item' => __('Add new Marketing Collateral'),
//        'new_item_name' => __('New Marketing Collateral'),
//        'menu_name' => __('Marketing Collateral'),
//    );
//    $args = array(
//        'hierarchical' => true,
//        'labels' => $type,
//        'show_ui' => true,
//        'query_var' => true,
//        'rewrite' => array('slug' => 'marketing-collateral'),
//        'show_in_rest' => TRUE,
//        'show_admin_column' => true,
//        'show_in_nav_menus' => true
//    );
//    register_taxonomy('marketing-collateral', array('post'), $args);
    //Post Country
    $type = array(
        'name' => _x('Geo Locations', 'geo_locationss'),
        'singular_name' => _x('Geo Location', 'geo_location'),
        'search_items' => __('Search in Geo Locations'),
        'all_items' => __('All Geo Locations'),
        'most_used_items' => null,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Geo Location'),
        'update_item' => __('Update Geo Location'),
        'add_new_item' => __('Add new Geo Location'),
        'new_item_name' => __('New Geo Location'),
        'menu_name' => __('Geo Location'),
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $type,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'geo-location'),
        'show_in_rest' => TRUE,
//        'show_in_nav_menus' => true
//        'show_admin_column' => true,
    );
    register_taxonomy('geo-location', array('post'), $args);
}

add_action('init', 'themename_custom_taxonomies', 0);
/*
 * END - Custom Taxonomy for Marketing Collaterals
 */

/*
 * START - WP-ADMIN - Graph and Charts Dashboard widget
 * Description: Graph and Charts widget on wp-admin
 */

function register_my_dashboard_widget() {
    global $wp_meta_boxes;

    wp_add_dashboard_widget(
            'my_dashboard_widget', 'Subscribers in 2021', 'my_dashboard_widget_display'
    );

    $dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

    $my_widget = array('my_dashboard_widget' => $dashboard['my_dashboard_widget']);
    unset($dashboard['my_dashboard_widget']);

    $sorted_dashboard = array_merge($my_widget, $dashboard);
    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

function my_dashboard_widget_display() {
    $users = get_users('role=subscriber');
    // Array of WP_User objects.
    $user_arr = array();
    foreach ($users as $user) {
        $time = strtotime($user->user_registered);
        $month = date("M", $time);
        $year = date("Y", $time);
        $user_arr[$month][] = $user->user_email;
    }
    $months = array();
    for ($i = 0; $i < 12; $i++) {
        $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
        $months[date('n', $timestamp)] = date('M', $timestamp);
    }
    ksort($months);
    $user_data = array();
    foreach ($months as $month) {
        $user_data[] = array(
            'name' => $month,
            'y' => (isset($user_arr[$month])) ? count($user_arr[$month]) : 0,
        );
    }
    $user_data = json_encode($user_data);
    ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
    <script type="text/javascript">
        // Create the chart
        var user_data = <?php echo $user_data; ?>;
        var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        console.log(user_data);
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Number of subscribers in 2021'
            },
            //            subtitle: {
            //                text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
            //            },
            xAxis: {
                categories: month_arr,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of subscribers',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [
                {
                    name: "Subscribers",
                    colorByPoint: true,
                    data: user_data
                }
            ]
        });
    </script>
    <?php
}

add_action('wp_dashboard_setup', 'register_my_dashboard_widget');

function register_my_dashboard_widget1() {
    global $wp_meta_boxes;

    wp_add_dashboard_widget(
            'my_dashboard_widget1', 'Leads Generated in 2019', 'my_dashboard_widget_display1'
    );

    $dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

    $my_widget = array('my_dashboard_widget' => $dashboard['my_dashboard_widget']);
    unset($dashboard['my_dashboard_widget']);

    $sorted_dashboard = array_merge($my_widget, $dashboard);
    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

function my_dashboard_widget_display1() {
    global $wpdb;
    $users = get_users('role=subscriber');
    // Array of WP_User objects.
    $user_arr = array();
    foreach ($users as $user) {
//        echo '<span>' . esc_html( $user->user_email ) . '</span>';
        $time = strtotime($user->user_registered);
        $month = date("M", $time);
        $year = date("Y", $time);
        $user_arr[$month][] = $user->user_email;
    }
    $months = array();
    for ($i = 0; $i < 12; $i++) {
        $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
        $months[date('n', $timestamp)] = date('M', $timestamp);
    }
    ksort($months);
    $user_data = array();
    foreach ($months as $month) {
        $user_data[] = array(
            'name' => $month,
            'y' => (isset($user_arr[$month])) ? count($user_arr[$month]) : 0,
        );
    }
    $user_data = json_encode($user_data);
    ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <div id="container1" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
    <script type="text/javascript">
        // Create the chart
        var user_data = <?php echo $user_data; ?>;
        var month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        //        console.log(user_data);
        Highcharts.chart('container1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Leads generated in 2019'
            },
            xAxis: {
                categories: month_arr,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of Leads',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [
                {
                    name: "Leads",
                    colorByPoint: true,
                    data: user_data
                }
            ]
        });
    </script>
    <?php
}

add_action('wp_dashboard_setup', 'register_my_dashboard_widget1');

/*
 * END - WP-ADMIN - Graph and Charts Dashboard widget
 */

/*
 * START -- WP-ADMIN - Role-wise User Aaccess Control
 */
add_action('admin_init', 'my_remove_menu_pages');

function my_remove_menu_pages() {
    global $user_ID;

    if (current_user_can('author') || current_user_can('editor')) {
        remove_menu_page('jetpack');
        remove_menu_page('vc-welcome');
        remove_menu_page('wpcf7');
        remove_menu_page('edit.php?post_type=news'); /* for custom post type */
        remove_menu_page('edit.php?post_type=popupbuilder');
        remove_menu_page('admin.php?page=jetpack#/dashboard');
        remove_menu_page('edit-comments.php');
        remove_menu_page('edit.php?post_type=portfolio');
        remove_menu_page('edit.php?post_type=staff');
        remove_menu_page('edit.php?post_type=testimonial');
        remove_menu_page('admin.php?page=wpcf7');

        remove_menu_page('tools.php');
        remove_menu_page('admin.php?page=vc-welcome');
        remove_menu_page('edit.php?post_type=slide');
    }
}

/*
 * END -- WP-ADMIN - Role-wise User Aaccess Control
 */

function post_data_meta_box() {
    add_meta_box('global-notice', __('Other Post Details', 'other_posts_details'), 'post_data_meta_box_callback', array('post', 'white_papers', 'tech_news'), 'side');
}

add_action('add_meta_boxes', 'post_data_meta_box');

function post_data_meta_box_callback($post) {
    // Add a nonce field so we can check for it later.
    wp_nonce_field('premium_regular_nonce', 'premium_regular_nonce');
    $premium_regular_post = get_post_meta($post->ID, '_premium_regular', true);
    $author_name_post = get_post_meta($post->ID, '_author_name', true);
    $sponsored_by_post = get_post_meta($post->ID, '_sponsored_by', true);
    $source_name_post = get_post_meta($post->ID, '_source_name', true);
    $source_url_post = get_post_meta($post->ID, '_source_url', true);
    $image_courtesy_name_post = get_post_meta($post->ID, '_image_courtesy_name', true);
    $image_courtesy_url_post = get_post_meta($post->ID, '_image_courtesy_url', true);
	
	$blog_sponsored_title = get_post_meta($post->ID, '_blog_sponsored_title', true);
	$blog_sponsored_desc = get_post_meta($post->ID, '_blog_sponsored_desc', true);
	
	$blog_sponsored_name = get_post_meta($post->ID, '_blog_sponsored_name', true);
    $blog_sponsored_url = get_post_meta($post->ID, '_blog_sponsored_url', true);

    $types = array(
        'regular' => 'Regular',
        'premium' => 'Premium'
    );
    ?>
    <div class='inside'>
        <h3><?php _e('Premium or Regular', 'other_posts_details'); ?></h3>
        <p>
            <?php
            foreach ($types as $key => $type) {
                ?>
                <input type="radio" name="premium_regular" id="<?php echo $key; ?>_radio" value="<?php echo $key; ?>" <?php echo isset($premium_regular_post) ? ($premium_regular_post == $key ? 'checked' : '') : ('regular' == $key ? 'checked' : ''); ?>  /> 
                <label for="<?php echo $key; ?>_radio"><?php echo $type; ?></label><br />
                <?php
            }
            ?>
        </p>
    </div>
    <div class='inside'>
        <h3><?php _e('Author Name', 'author_name_text'); ?></h3>
        <p>
            <input type="text" name="author_name" id="author_name" value="<?php echo $author_name_post; ?>" /> 
        </p>
    </div>

    <div class='inside'>
        <h3><?php _e('Sponsored by', 'sponsered_by_text'); ?></h3>
        <p>
            <input type="text" name="sponsored_by" id="sponsored_by" value="<?php echo $sponsored_by_post; ?>" /> 
        </p>
    </div>

    <div class='inside'>
        <h3><?php _e('Source Name', 'source_name_text'); ?></h3>
        <p>
            <input type="text" name="source_name" id="source_name" value="<?php echo $source_name_post; ?>" /> 
        </p>
    </div>

    <div class='inside'>
        <h3><?php _e('Source URL', 'source_url_text'); ?></h3>
        <p>
            <input type="text" name="source_url" id="source_url" value="<?php echo $source_url_post; ?>" /> 
        </p>
    </div>
    <div class='inside'>
        <h3><?php _e('Image Courtesy', 'image_courtesy_name_text'); ?></h3>
        <p>
            <input type="text" name="image_courtesy_name" id="image_courtesy_name" value="<?php echo $image_courtesy_name_post; ?>" /> 
        </p>
    </div>

    <div class='inside'>
        <h3><?php _e('Image Courtesy URL', 'image_courtesy_url_text'); ?></h3>
        <p>
            <input type="text" name="image_courtesy_url" id="image_courtesy_url" value="<?php echo $image_courtesy_url_post; ?>" /> 
        </p>
    </div>
	
	
	<div class='inside'>
        <h3><?php _e('Blog Sponsored Title', 'blog_sponsored_title_text'); ?></h3>
        <p>
            <input type="text" name="blog_sponsored_title" id="blog_sponsored_title" value="<?php echo $blog_sponsored_title; ?>" /> 
        </p>
    </div>
	
	<div class='inside'>
        <h3><?php _e('Blog Sponsored Description', 'blog_sponsored_desc_text'); ?></h3>
        <p>
            <input type="text" name="blog_sponsored_desc" id="blog_sponsored_desc" value="<?php echo $blog_sponsored_desc; ?>" /> 
        </p>
    </div>
	
	 <div class='inside'>
        <h3><?php _e('Blog Sponsored Name', 'blog_sponsored_name_text'); ?></h3>
        <p>
            <input type="text" name="blog_sponsored_name" id="blog_sponsored_name" value="<?php echo $blog_sponsored_name; ?>" /> 
        </p>
    </div>

    <div class='inside'>
        <h3><?php _e('Blog Sponsored URL', 'blog_sponsored_url_text'); ?></h3>
        <p>
            <input type="text" name="blog_sponsored_url" id="blog_sponsored_url" value="<?php echo $blog_sponsored_url; ?>" /> 
        </p>
    </div>
	
	
    <?php
}

function save_meta_boxes_data($post_id) {
    // Check if our nonce is set.
//    if (!isset($_POST['premium_regular'])) {
//        return;
//    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['premium_regular_nonce'], 'premium_regular_nonce')) {
        return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
//    if (!isset($_POST['premium_regular'])) {
//        return;
//    }
    // Sanitize user input.
    $premium_regular = sanitize_text_field($_POST['premium_regular']);
    $author_name = sanitize_text_field($_POST['author_name']);
    $sponsored_by = sanitize_text_field($_POST['sponsored_by']);
    $source_name = sanitize_text_field($_POST['source_name']);
    $source_url = sanitize_text_field($_POST['source_url']);
    $image_courtesy_name = sanitize_text_field($_POST['image_courtesy_name']);
    $image_courtesy_url = sanitize_text_field($_POST['image_courtesy_url']);
	
	$blog_sponsored_title = sanitize_text_field($_POST['blog_sponsored_title']);
	$blog_sponsored_desc = sanitize_text_field($_POST['blog_sponsored_desc']);
	
	$blog_sponsored_name = sanitize_text_field($_POST['blog_sponsored_name']);
    $blog_sponsored_url = sanitize_text_field($_POST['blog_sponsored_url']);


    // Update the meta field in the database.
    update_post_meta($post_id, '_premium_regular', $premium_regular);
    update_post_meta($post_id, '_author_name', $author_name);
    update_post_meta($post_id, '_sponsored_by', $sponsored_by);
    update_post_meta($post_id, '_source_name', $source_name);
    update_post_meta($post_id, '_source_url', $source_url);
    update_post_meta($post_id, '_image_courtesy_name', $image_courtesy_name);
    update_post_meta($post_id, '_image_courtesy_url', $image_courtesy_url);
	
	update_post_meta($post_id, '_blog_sponsored_title', $blog_sponsored_title);
	update_post_meta($post_id, '_blog_sponsored_desc', $blog_sponsored_desc);
	
	update_post_meta($post_id, '_blog_sponsored_name', $blog_sponsored_name);
	update_post_meta($post_id, '_blog_sponsored_url', $blog_sponsored_url);
}

add_action('save_post', 'save_meta_boxes_data', 10, 1);

add_action('init', 'start_session', 1);

function start_session() {
    if (!session_id()) {
        session_start();
    }
}

add_action('sdm_process_download_request', 'custom_download', 10, 2);

function custom_download($download_id, $download_link) {

    global $wpdb;
//    require('templates/Mailin.php');
//    $mailin = new Mailin('https://api.sendinblue.com/v2.0','PSRXJmCncQNpzBUs', 5000);
//    
    $download = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}custom_sdm_downloads WHERE post_id = {$download_id} ORDER BY id DESC;");
//    if(!empty($download)) {
//        $user = $wpdb->get_row("SELECT * FROM wp_users WHERE user_login = '{$download->visitor_name}';");
//        $all_meta_for_user = get_user_meta( $user->ID );
//
//        $download_data = array(
//            $download->post_id,//Order ID
//            (isset($all_meta_for_user['user_registration_user_company'])) ? $all_meta_for_user['user_registration_user_company'][0] : '',//Company Name
//            '',//Domain
//            $all_meta_for_user['first_name'][0],//First Name
//            $all_meta_for_user['last_name'][0],//Last Name
//            (isset($all_meta_for_user['user_registration_job_title'])) ? $all_meta_for_user['user_registration_job_title'][0] : '',//Title
//            $user->user_email,//Email
//            '',//Work Phone
//            '',//Alternate Phone
//            '',//Street
//            '',//City
//            '',//State
//            '',//Zip Code
//            $download->visitor_country,//Country
//            '',//Company Employees
//            '',//Company Revenue
//            '',//Industry
//            $download->file_url,//Asset Name
//            '',//Comments
//            $download->visitor_ip,//IP
//        );
//        
//        $source_file = fopen(get_stylesheet_directory_uri()."/templates/PublisherLeadUploadTemplate.csv","r");
//        
//        while (($line = fgetcsv($source_file)) !== FALSE) {
//            $header_data = $line;
//        }
//
//        copy(TAGDIV_ROOT_DIR."/templates/PublisherLeadUploadTemplate.csv", TAGDIV_ROOT_DIR."/templates/publisher_leads/PublisherLead-user_id-{$user->ID}.csv");
//
//        $file = fopen(TAGDIV_ROOT_DIR."/templates/publisher_leads/PublisherLead-user_id-{$user->ID}.csv","w");
//
//        //Header Row
//        fputcsv($file, $header_data);
//
//        //Data Row
//        fputcsv($file, $download_data);
//
//        fclose($file);
//
//        $email_template = file_get_contents("wp-content/themes/Newspaper/templates/email-template.html");
//        $email_body = '<table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
//        <tbody>
//        <tr>
//        <td style="padding: 40px 40px 20px 40px; text-align: left;">
//        <h1 style="margin: 0; font-family: "Montserrat", sans-serif; font-size: 20px; line-height: 26px; color: #333333; font-weight: bold;">New Lead!</h1>
//        </td>
//        </tr>
//        <tr>
//        <td style="padding: 0px 40px 20px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: left; font-weight: normal;">
//            Hello!<br />
//
//            We have received a new lead please check the document attached. <br/>
//        </td>
//        </tr>
//        <tr>
//        <td style="padding: 0px 40px 20px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: left; font-weight: normal;">
//        <p style="margin: 0;">Best Regards,</p>
//        <p style="margin: 0;">The Admin Team
//        Insights Today</p>
//        </td>
//        </tr>
//        </tbody>
//        </table>';
//
//        $replaced_email_template = str_replace('{email-body}', $email_body, $email_template);
//
//        $data = array(
//            "to" => array("svyas@trueinfluence.us" => "Shilpi Vyas"),
//            "from" => array("info@techversions.com","TechVersions"),
//            "replyto" => array("info@techversions.com","TechVersions"),
//            "subject" => "Publisher Leads",
////            "text" => "This is the text",
//            "html" => $replaced_email_template,
//            "attachment" => array(get_stylesheet_directory_uri()."/templates/publisher_leads/PublisherLead-user_id-{$user->ID}.csv"),
//            "headers" => array(
//                "Content-Type" => "text/html; charset=iso-8859-1",
//                "MIME-Version" => "1.0"
//            ),
//        );
//
//        $mailin->send_email($data);
//    }
    if (isset($_GET['r_id']) && !empty($_GET['r_id'])) {
        $pdf_tracker = (isset($_GET['pdftracking']) && $_GET['pdftracking'] === 'true') ? 'true' : 'false';
        $thankyoupage_asset = (isset($_GET['thankyoupage_asset']) && !empty($_GET['thankyoupage_asset'])) ? $_GET['thankyoupage_asset'] : 'false';

        if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
            $_SESSION['form_submission'] = 'true';
        }

        if ($pdf_tracker === 'true') {
            wp_redirect(site_url('thank-you-pdf?success=true&r_id=' . urlencode(base64_encode($_GET['r_id']))));
        } else if ($thankyoupage_asset !== 'false') {
//            echo '<pre>';
//            print_r($thankyoupage_asset);
//            echo '</pre>';
//            die();
            // $url = site_url('thank-you-page-asset?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])) . '&r_url=' . urlencode(base64_encode($_GET['thankyou_redirect_url'])).'&thankyoupage_asset='.urlencode(base64_encode($thankyoupage_asset)));
            $url = site_url('thank-you-resource?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])) . '&r_url=' . urlencode(base64_encode($_GET['thankyou_redirect_url'])) . '&thankyoupage_asset=' . urlencode(base64_encode($thankyoupage_asset)));
            wp_redirect($url);
        } else {
            $redirect_url = '';
            if (isset($_GET['thankyoupage_redirecturl']) && !empty($_GET['thankyoupage_redirecturl'])) {
                $redirect_url = $_GET['thankyoupage_redirecturl'];
            }

            if (!empty($redirect_url)) {
                wp_redirect(site_url('thank-you-resource?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])) . '&redirect_url=' . urlencode(base64_encode($redirect_url))));
            } else {
                wp_redirect(site_url('thank-you-resource?success=true&r_id=' . urlencode(base64_encode($_GET['r_id']))));
            }
        }
    } else {
        $resource_name = $download->post_title;
        global $wpdb;
        $chr_map = array(
            // Windows codepage 1252
            "\xC2\x82" => "'", // U+0082?U+201A single low-9 quotation mark
            "\xC2\x84" => '"', // U+0084?U+201E double low-9 quotation mark
            "\xC2\x8B" => "'", // U+008B?U+2039 single left-pointing angle quotation mark
            "\xC2\x91" => "'", // U+0091?U+2018 left single quotation mark
            "\xC2\x92" => "'", // U+0092?U+2019 right single quotation mark
            "\xC2\x93" => '"', // U+0093?U+201C left double quotation mark
            "\xC2\x94" => '"', // U+0094?U+201D right double quotation mark
            "\xC2\x9B" => "'", // U+009B?U+203A single right-pointing angle quotation mark
            // Regular Unicode // U+0022 quotation mark (")
            // U+0027 apostrophe (')
            "\xC2\xAB" => '"', // U+00AB left-pointing double angle quotation mark
            "\xC2\xBB" => '"', // U+00BB right-pointing double angle quotation mark
            "\xE2\x80\x98" => "'", // U+2018 left single quotation mark
            "\xE2\x80\x99" => "'", // U+2019 right single quotation mark
            "\xE2\x80\x9A" => "'", // U+201A single low-9 quotation mark
            "\xE2\x80\x9B" => "'", // U+201B single high-reversed-9 quotation mark
            "\xE2\x80\x9C" => '"', // U+201C left double quotation mark
            "\xE2\x80\x9D" => '"', // U+201D right double quotation mark
            "\xE2\x80\x9E" => '"', // U+201E double low-9 quotation mark
            "\xE2\x80\x9F" => '"', // U+201F double high-reversed-9 quotation mark
            "\xE2\x80\xB9" => "'", // U+2039 single left-pointing angle quotation mark
            "\xE2\x80\xBA" => "'", // U+203A single right-pointing angle quotation mark
        );
        $char_val = array_keys($chr_map); // but: for efficiency you should
        $rpl = array_values($chr_map); // pre-calculate these two arrays
        $str = str_replace($char_val, $rpl, html_entity_decode($resource_name, ENT_QUOTES, "UTF-8"));

        $sql = 'SELECT * FROM ' . $wpdb->posts . ' WHERE post_title LIKE "' . $str . '" AND (post_type NOT LIKE "attachment" AND post_type NOT LIKE "sdm_downloads" AND post_type NOT LIKE "revision");';

//        $sql = 'SELECT * FROM ' . $wpdb->posts . ' WHERE post_title LIKE "' . wp_specialchars_decode($resource_name) . '" AND post_status LIKE "publish" AND (post_type NOT LIKE "attachment" AND post_type NOT LIKE "sdm_downloads" AND post_type NOT LIKE "revision");';
        $myposts = $wpdb->get_row($sql);

        $post_link = apply_filters('post_type_link', get_permalink($myposts->ID), $myposts);

        wp_redirect($post_link . '?download=thank-you&data-id=' . $download->post_id);
        exit;
    }
}

add_filter('post_type_link', 'tv_post_type_link', 1, 3);

function tv_post_type_link($link, $post = 0) {
    if ($post->post_type == 'white_papers') {
        return home_url('white-papers/' . $post->post_name);
    } else if ($post->post_type == 'infographics') {
        return home_url('infographics/' . $post->post_name);
    } else if ($post->post_type == 'e_books') {
        return home_url('ebooks/' . $post->post_name);
    } else {
        return $link;
    }
}

/**
 * Rewrite WordPress URLs to Include /blog/ in Post Permalink Structure
 *
 */
function tv_blog_generate_rewrite_rules($wp_rewrite) {
    $new_rules = array(
        '(([^/]+/)*blogs)/page/?([0-9]{1,})/?$' => 'index.php?pagename=$matches[1]&paged=$matches[3]',
        'blogs/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]',
        'blogs/[^/]+/attachment/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
        'blogs/[^/]+/attachment/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
        'blogs/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blogs/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blogs/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',
        'blogs/[^/]+/attachment/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
        'blogs/[^/]+/embed/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
        'blogs/([^/]+)/embed/?$' => 'index.php?post_type=post&name=$matches[1]&embed=true',
        'blogs/[^/]+/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
        'blogs/([^/]+)/trackback/?$' => 'index.php?post_type=post&name=$matches[1]&tb=1',
        'blogs/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
        'blogs/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
        'blogs/page/([0-9]{1,})/?$' => 'index.php?post_type=post&paged=$matches[1]',
        'blogs/[^/]+/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
        'blogs/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
        'blogs/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&cpage=$matches[2]',
        'blogs/([^/]+)(/[0-9]+)?/?$' => 'index.php?post_type=post&name=$matches[1]&page=$matches[2]',
        'blogs/[^/]+/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
        'blogs/[^/]+/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
        'blogs/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blogs/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
        'blogs/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

add_action('generate_rewrite_rules', 'tv_blog_generate_rewrite_rules');

function tv_update_post_link($post_link, $id = 0) {
    $post = get_post($id);
    if (is_object($post) && $post->post_type == 'post') {
        return home_url('/blogs/' . $post->post_name);
    }
    return $post_link;
}

add_filter('post_link', 'tv_update_post_link', 1, 3);

/* Taxonomy Single page */
//add_filter( 'taxonomy_archive ', 'slug_tax_page_one' );
//function slug_tax_page_one( $template ) {
////        die('Hello');
//    if ( is_tax( 'white-papers' ) ) {
//        global $wp_query;
//        $page = $wp_query->query_vars['paged'];
//        if ( $page = 0 ) {
//            $template = get_stylesheet_directory(). '/taxonomy-page-one.php';
//        }
//    }
//
//    return $template;
//
//}

add_action('widgets_init', 'my_register_sidebars');

function my_register_sidebars() {

    /* Register dynamic sidebar 'new_sidebar' */
    register_sidebar(
            array(
                'id' => 'new_sidebar',
                'name' => __('New Sidebar'),
                'description' => __('A short description of the sidebar.'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );
    register_sidebar(
            array(
                'id' => 'ebooks_sidebar',
                'name' => __('E-Books Sidebar'),
//            'description' => __( 'A short description of the sidebar.' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );
    register_sidebar(
            array(
                'id' => 'infographics_sidebar',
                'name' => __('Infographics Sidebar'),
//            'description' => __( 'A short description of the sidebar.' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );
    register_sidebar(
            array(
                'id' => 'events_sidebar',
                'name' => __('Events Sidebar'),
//            'description' => __( 'A short description of the sidebar.' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );
    register_sidebar(
            array(
                'id' => 'blogpost_sidebar',
                'name' => __('Blogs Sidebar'),
//            'description' => __( 'A short description of the sidebar.' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );
    register_sidebar(
            array(
                'id' => 'news_sidebar',
                'name' => __('News Sidebar'),
//            'description' => __( 'A short description of the sidebar.' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );

    /* Repeat the code pattern above for additional sidebars. */
    register_sidebar(
            array(
                'id' => 'social_sharing_widget',
                'name' => __('Social Sharing'),
                'description' => __('In-Post Social Sharing'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );

    /* Single News Sidebar */
    register_sidebar(
            array(
                'id' => 'single_news_sidebar',
                'name' => __('Single News Sidebar'),
                'description' => __('Sidebar for the individual news page. Create on 22-10-2020'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
    );
}

function ajax_check_user_logged_in() {
    echo is_user_logged_in() ? 'yes' : 'no';
    exit;
}

add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');


//add_filter('show_admin_bar', '__return_false');
//Hide admin topbar only for subscribers
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !current_user_can('editor') && !current_user_can('author') && !is_admin()) {
        show_admin_bar(false);
    }
}

add_action('wp_ajax_nopriv_validate_email', 'validate_email');
add_action('wp_ajax_validate_email', 'validate_email');

function validate_email() {
    $msg = '';
    $email = $_REQUEST['email_id'];
    if (!isset($_REQUEST['lp_var']) || $_REQUEST['lp_var'] === 'false') {
        $exists = email_exists($email);
        if ($exists)
            $msg = "E-mail already exists.";
    }
    $err = '';
    if ($msg == '' && $email != '') {
        /* Method 3 */
        //This is a free API available. Referred from https://gist.github.com/adamloving/4401361
        $url = 'https://disify.com/api/email/' . $email;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 150);
        $err = curl_error($ch);
        $response = curl_exec($ch);
        curl_close($ch);

        //decode the json response
        $json = json_decode($response, true);
        $domain_arr = explode('.', $json['domain']);
        if (in_array(strtolower($domain_arr[0]), array('yahoo', 'gmail', 'outlook', 'rediffmail', 'earthlink', 'att', 'livemore', 'protonmail', 'bellsouth', 'aol', 'zoho', 'mail', 'icloud', 'thunderbird', 'yandex', 'gmx','ymail','yahoomail'))) {
            $msg = "We only accept business emails.";
        } else if ((isset($json['whitelist']) && $json['whitelist'] == 1) || (isset($json['disposable']) && $json['disposable'] == 1)) {
            $msg = "We only accept business e-mails.";
        } else {
            $msg = "";
        }
    }

    echo json_encode(array(
        'msg' => $msg,
        'curl_error' => $err
    ));
    exit();
}

//add_filter('pp_login_redirect', 'after_login_redirect', 10, 0);

add_filter('user_registration_login_redirect', 'after_login_redirect', 10, 0);

function after_login_redirect() {
    global $redirect_to;
    if (!isset($_GET['redirect_to']) || empty($_GET['redirect_to'])) {
        $redirect_to = home_url();
    } else {
        $redirect_to = $_GET['redirect_to'];
    }
    return $redirect_to;
}

add_filter('user_registration_registration_redirect', 'after_register_redirect', 10, 0);

function after_register_redirect() {
    return site_url('sign-in');
}

/* START -- Custom Post Types */

function cptui_register_my_cpts() {


   $labels = [
        "name" => __("Resources", "newspaper"),
        "singular_name" => __("Resource", "newspaper"),
        "menu_name" => __("My Resources", "newspaper"),
        "all_items" => __("All Resources", "newspaper"),
        "add_new" => __("Add new", "newspaper"),
        "add_new_item" => __("Add new Resource", "newspaper"),
        "edit_item" => __("Edit Resource", "newspaper"),
        "new_item" => __("New Resource", "newspaper"),
        "view_item" => __("View Resource", "newspaper"),
        "view_items" => __("View Resources", "newspaper"),
        "search_items" => __("Search Resources", "newspaper"),
        "not_found" => __("No Resources found", "newspaper"),
        "not_found_in_trash" => __("No Resources found in trash", "newspaper"),
        "parent" => __("Parent Resource:", "newspaper"),
        "featured_image" => __("Featured image for this Resource", "newspaper"),
        "set_featured_image" => __("Set featured image for this Resource", "newspaper"),
        "remove_featured_image" => __("Remove featured image for this Resource", "newspaper"),
        "use_featured_image" => __("Use as featured image for this Resource", "newspaper"),
        "archives" => __("Resources", "newspaper"),
        "insert_into_item" => __("Insert into Resource", "newspaper"),
        "uploaded_to_this_item" => __("Upload to this Resource", "newspaper"),
        "filter_items_list" => __("Filter Resources list", "newspaper"),
        "items_list_navigation" => __("Resources list navigation", "newspaper"),
        "items_list" => __("Resources list", "newspaper"),
        "attributes" => __("Resources attributes", "newspaper"),
        "name_admin_bar" => __("Resource", "newspaper"),
        "item_published" => __("Resource published", "newspaper"),
        "item_published_privately" => __("Resource published privately.", "newspaper"),
        "item_reverted_to_draft" => __("Resource reverted to draft.", "newspaper"),
        "item_scheduled" => __("Resource scheduled", "newspaper"),
        "item_updated" => __("Resource updated.", "newspaper"),
        "parent_item_colon" => __("Parent Resource:", "newspaper"),
    ];

    $args = [
        "label" => __("Resources", "newspaper"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "resources", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes", "post-attributes", "author"],
        "taxonomies" => ["post_tag", "geo-location", "resource_types", "category", "sponsored_by"],
    ];

    register_post_type("resources", $args);

    /**
     * Post Type: Videos.
     */
    $labels = [
        "name" => __("Videos", "newspaper"),
        "singular_name" => __("Video", "newspaper"),
        "menu_name" => __("My Videos", "newspaper"),
        "all_items" => __("All Videos", "newspaper"),
        "add_new" => __("Add new", "newspaper"),
        "add_new_item" => __("Add new Video", "newspaper"),
        "edit_item" => __("Edit Video", "newspaper"),
        "new_item" => __("New Video", "newspaper"),
        "view_item" => __("View Video", "newspaper"),
        "view_items" => __("View Videos", "newspaper"),
        "search_items" => __("Search Videos", "newspaper"),
        "not_found" => __("No Videos found", "newspaper"),
        "not_found_in_trash" => __("No Videos found in trash", "newspaper"),
        "parent" => __("Parent Video:", "newspaper"),
        "featured_image" => __("Featured image for this Video", "newspaper"),
        "set_featured_image" => __("Set featured image for this Video", "newspaper"),
        "remove_featured_image" => __("Remove featured image for this Video", "newspaper"),
        "use_featured_image" => __("Use as featured image for this Video", "newspaper"),
        "archives" => __("Video archives", "newspaper"),
        "insert_into_item" => __("Insert into Video", "newspaper"),
        "uploaded_to_this_item" => __("Upload to this Video", "newspaper"),
        "filter_items_list" => __("Filter Videos list", "newspaper"),
        "items_list_navigation" => __("Videos list navigation", "newspaper"),
        "items_list" => __("Videos list", "newspaper"),
        "attributes" => __("Videos attributes", "newspaper"),
        "name_admin_bar" => __("Video", "newspaper"),
        "item_published" => __("Video published", "newspaper"),
        "item_published_privately" => __("Video published privately.", "newspaper"),
        "item_reverted_to_draft" => __("Video reverted to draft.", "newspaper"),
        "item_scheduled" => __("Video scheduled", "newspaper"),
        "item_updated" => __("Video updated.", "newspaper"),
        "parent_item_colon" => __("Parent Video:", "newspaper"),
    ];

    $args = [
        "label" => __("Videos", "newspaper"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "videos", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "author", "page-attributes", "post-formats"],
        "taxonomies" => ["post_tag", "geo-location", "videos_categories", "sdm_categories", "sdm_tags"],
    ];

    register_post_type("videos", $args);

    /**
     * Post Type: White Papers.
     */
    $labels = [
        "name" => __("White Papers", "newspaper"),
        "singular_name" => __("White Paper", "newspaper"),
        "menu_name" => __("My White Papers", "newspaper"),
        "all_items" => __("All White Papers", "newspaper"),
        "add_new" => __("Add new", "newspaper"),
        "add_new_item" => __("Add new White Paper", "newspaper"),
        "edit_item" => __("Edit White Paper", "newspaper"),
        "new_item" => __("New White Paper", "newspaper"),
        "view_item" => __("View White Paper", "newspaper"),
        "view_items" => __("View White Papers", "newspaper"),
        "search_items" => __("Search White Papers", "newspaper"),
        "not_found" => __("No White Papers found", "newspaper"),
        "not_found_in_trash" => __("No White Papers found in trash", "newspaper"),
        "parent" => __("Parent White Paper:", "newspaper"),
        "featured_image" => __("Featured image for this White Paper", "newspaper"),
        "set_featured_image" => __("Set featured image for this White Paper", "newspaper"),
        "remove_featured_image" => __("Remove featured image for this White Paper", "newspaper"),
        "use_featured_image" => __("Use as featured image for this White Paper", "newspaper"),
        "archives" => __("White Paper archives", "newspaper"),
        "insert_into_item" => __("Insert into White Paper", "newspaper"),
        "uploaded_to_this_item" => __("Upload to this White Paper", "newspaper"),
        "filter_items_list" => __("Filter White Papers list", "newspaper"),
        "items_list_navigation" => __("White Papers list navigation", "newspaper"),
        "items_list" => __("White Papers list", "newspaper"),
        "attributes" => __("White Papers attributes", "newspaper"),
        "name_admin_bar" => __("White Paper", "newspaper"),
        "item_published" => __("White Paper published", "newspaper"),
        "item_published_privately" => __("White Paper published privately.", "newspaper"),
        "item_reverted_to_draft" => __("White Paper reverted to draft.", "newspaper"),
        "item_scheduled" => __("White Paper scheduled", "newspaper"),
        "item_updated" => __("White Paper updated.", "newspaper"),
        "parent_item_colon" => __("Parent White Paper:", "newspaper"),
    ];

    $args = [
        "label" => __("White Papers", "newspaper"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "white-papers", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "author", "page-attributes", "post-formats"],
        "taxonomies" => ["post_tag", "geo-location", "white_paper_categories", "sdm_categories", "sdm_tags", "sponsored_by"],
    ];

    register_post_type("white_papers", $args);  

    /**
     * Post Type: eBooks.
     */
    $labels = [
        "name" => __("eBooks", "newspaper"),
        "singular_name" => __("eBook", "newspaper"),
        "menu_name" => __("My eBooks", "newspaper"),
        "all_items" => __("All eBooks", "newspaper"),
        "add_new" => __("Add new", "newspaper"),
        "add_new_item" => __("Add new eBook", "newspaper"),
        "edit_item" => __("Edit eBook", "newspaper"),
        "new_item" => __("New eBook", "newspaper"),
        "view_item" => __("View eBook", "newspaper"),
        "view_items" => __("View eBooks", "newspaper"),
        "search_items" => __("Search eBooks", "newspaper"),
        "not_found" => __("No eBooks found", "newspaper"),
        "not_found_in_trash" => __("No eBooks found in trash", "newspaper"),
        "parent" => __("Parent eBook:", "newspaper"),
        "featured_image" => __("Featured image for this eBook", "newspaper"),
        "set_featured_image" => __("Set featured image for this eBook", "newspaper"),
        "remove_featured_image" => __("Remove featured image for this eBook", "newspaper"),
        "use_featured_image" => __("Use as featured image for this eBook", "newspaper"),
        "archives" => __("eBook archives", "newspaper"),
        "insert_into_item" => __("Insert into eBook", "newspaper"),
        "uploaded_to_this_item" => __("Upload to this eBook", "newspaper"),
        "filter_items_list" => __("Filter eBooks list", "newspaper"),
        "items_list_navigation" => __("eBooks list navigation", "newspaper"),
        "items_list" => __("eBooks list", "newspaper"),
        "attributes" => __("eBooks attributes", "newspaper"),
        "name_admin_bar" => __("eBook", "newspaper"),
        "item_published" => __("eBook published", "newspaper"),
        "item_published_privately" => __("eBook published privately.", "newspaper"),
        "item_reverted_to_draft" => __("eBook reverted to draft.", "newspaper"),
        "item_scheduled" => __("eBook scheduled", "newspaper"),
        "item_updated" => __("eBook updated.", "newspaper"),
        "parent_item_colon" => __("Parent eBook:", "newspaper"),
    ];

    $args = [
        "label" => __("eBooks", "newspaper"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "ebooks", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "author", "page-attributes", "post-formats"],
        "taxonomies" => ["post_tag", "geo-location", "e_book_categories", "sponsored_by"],
    ];

    register_post_type("e_books", $args);

    /**
     * Post Type: Infographics.
     */
    $labels = [
        "name" => __("Infographics", "newspaper"),
        "singular_name" => __("Infographic", "newspaper"),
        "menu_name" => __("My Infographics", "newspaper"),
        "all_items" => __("All Infographics", "newspaper"),
        "add_new" => __("Add new", "newspaper"),
        "add_new_item" => __("Add new Infographic", "newspaper"),
        "edit_item" => __("Edit Infographic", "newspaper"),
        "new_item" => __("New Infographic", "newspaper"),
        "view_item" => __("View Infographic", "newspaper"),
        "view_items" => __("View Infographics", "newspaper"),
        "search_items" => __("Search Infographics", "newspaper"),
        "not_found" => __("No Infographics found", "newspaper"),
        "not_found_in_trash" => __("No Infographics found in trash", "newspaper"),
        "parent" => __("Parent Infographic:", "newspaper"),
        "featured_image" => __("Featured image for this Infographic", "newspaper"),
        "set_featured_image" => __("Set featured image for this Infographic", "newspaper"),
        "remove_featured_image" => __("Remove featured image for this Infographic", "newspaper"),
        "use_featured_image" => __("Use as featured image for this Infographic", "newspaper"),
        "archives" => __("Infographic archives", "newspaper"),
        "insert_into_item" => __("Insert into Infographic", "newspaper"),
        "uploaded_to_this_item" => __("Upload to this Infographic", "newspaper"),
        "filter_items_list" => __("Filter Infographics list", "newspaper"),
        "items_list_navigation" => __("Infographics list navigation", "newspaper"),
        "items_list" => __("Infographics list", "newspaper"),
        "attributes" => __("Infographics attributes", "newspaper"),
        "name_admin_bar" => __("Infographic", "newspaper"),
        "item_published" => __("Infographic published", "newspaper"),
        "item_published_privately" => __("Infographic published privately.", "newspaper"),
        "item_reverted_to_draft" => __("Infographic reverted to draft.", "newspaper"),
        "item_scheduled" => __("Infographic scheduled", "newspaper"),
        "item_updated" => __("Infographic updated.", "newspaper"),
        "parent_item_colon" => __("Parent Infographic:", "newspaper"),
    ];

    $args = [
        "label" => __("Infographics", "newspaper"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "rewrite" => ["slug" => "infographics", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "author", "page-attributes", "post-formats"],
        "taxonomies" => ["post_tag", "geo-location", "infographic_categories", "sponsored_by"],
    ];

    register_post_type("infographics", $args);

    /**
     * Post Type: News.
     */
    $labels = [
        "name" => __("News", "newspaper"),
        "singular_name" => __("New", "newspaper"),
        "menu_name" => __("My News", "newspaper"),
        "all_items" => __("All News", "newspaper"),
        "add_new" => __("Add new", "newspaper"),
        "add_new_item" => __("Add new New", "newspaper"),
        "edit_item" => __("Edit New", "newspaper"),
        "new_item" => __("New New", "newspaper"),
        "view_item" => __("View New", "newspaper"),
        "view_items" => __("View News", "newspaper"),
        "search_items" => __("Search News", "newspaper"),
        "not_found" => __("No News found", "newspaper"),
        "not_found_in_trash" => __("No News found in trash", "newspaper"),
        "parent" => __("Parent New:", "newspaper"),
        "featured_image" => __("Featured image for this New", "newspaper"),
        "set_featured_image" => __("Set featured image for this New", "newspaper"),
        "remove_featured_image" => __("Remove featured image for this New", "newspaper"),
        "use_featured_image" => __("Use as featured image for this New", "newspaper"),
        "archives" => __("New archives", "newspaper"),
        "insert_into_item" => __("Insert into New", "newspaper"),
        "uploaded_to_this_item" => __("Upload to this New", "newspaper"),
        "filter_items_list" => __("Filter News list", "newspaper"),
        "items_list_navigation" => __("News list navigation", "newspaper"),
        "items_list" => __("News list", "newspaper"),
        "attributes" => __("News attributes", "newspaper"),
        "name_admin_bar" => __("New", "newspaper"),
        "item_published" => __("New published", "newspaper"),
        "item_published_privately" => __("New published privately.", "newspaper"),
        "item_reverted_to_draft" => __("New reverted to draft.", "newspaper"),
        "item_scheduled" => __("New scheduled", "newspaper"),
        "item_updated" => __("New updated.", "newspaper"),
        "parent_item_colon" => __("Parent New:", "newspaper"),
    ];

    $args = [
        "label" => __("News", "newspaper"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "news", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "author"],
        "taxonomies" => ["post_tag", "geo-location", "new_categories"],
    ];

    register_post_type("tech_news", $args);
}

add_action('init', 'cptui_register_my_cpts');

//function cptui_register_my_cpts_white_papers() {
//
//	/**
//	 * Post Type: White Papers.
//	 */
//
//	$labels = [
//		"name" => __( "White Papers", "newspaper" ),
//		"singular_name" => __( "White Paper", "newspaper" ),
//		"menu_name" => __( "My White Papers", "newspaper" ),
//		"all_items" => __( "All White Papers", "newspaper" ),
//		"add_new" => __( "Add new", "newspaper" ),
//		"add_new_item" => __( "Add new White Paper", "newspaper" ),
//		"edit_item" => __( "Edit White Paper", "newspaper" ),
//		"new_item" => __( "New White Paper", "newspaper" ),
//		"view_item" => __( "View White Paper", "newspaper" ),
//		"view_items" => __( "View White Papers", "newspaper" ),
//		"search_items" => __( "Search White Papers", "newspaper" ),
//		"not_found" => __( "No White Papers found", "newspaper" ),
//		"not_found_in_trash" => __( "No White Papers found in trash", "newspaper" ),
//		"parent" => __( "Parent White Paper:", "newspaper" ),
//		"featured_image" => __( "Featured image for this White Paper", "newspaper" ),
//		"set_featured_image" => __( "Set featured image for this White Paper", "newspaper" ),
//		"remove_featured_image" => __( "Remove featured image for this White Paper", "newspaper" ),
//		"use_featured_image" => __( "Use as featured image for this White Paper", "newspaper" ),
//		"archives" => __( "White Paper archives", "newspaper" ),
//		"insert_into_item" => __( "Insert into White Paper", "newspaper" ),
//		"uploaded_to_this_item" => __( "Upload to this White Paper", "newspaper" ),
//		"filter_items_list" => __( "Filter White Papers list", "newspaper" ),
//		"items_list_navigation" => __( "White Papers list navigation", "newspaper" ),
//		"items_list" => __( "White Papers list", "newspaper" ),
//		"attributes" => __( "White Papers attributes", "newspaper" ),
//		"name_admin_bar" => __( "White Paper", "newspaper" ),
//		"item_published" => __( "White Paper published", "newspaper" ),
//		"item_published_privately" => __( "White Paper published privately.", "newspaper" ),
//		"item_reverted_to_draft" => __( "White Paper reverted to draft.", "newspaper" ),
//		"item_scheduled" => __( "White Paper scheduled", "newspaper" ),
//		"item_updated" => __( "White Paper updated.", "newspaper" ),
//		"parent_item_colon" => __( "Parent White Paper:", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "White Papers", "newspaper" ),
//		"labels" => $labels,
//		"description" => "",
//		"public" => true,
//		"publicly_queryable" => true,
//		"show_ui" => true,
//		"show_in_rest" => true,
//		"rest_base" => "",
//		"rest_controller_class" => "WP_REST_Posts_Controller",
//		"has_archive" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"delete_with_user" => false,
//		"exclude_from_search" => false,
//		"capability_type" => "post",
//		"map_meta_cap" => true,
//		"hierarchical" => false,
//		"rewrite" => [ "slug" => "white-papers", "with_front" => true ],
//		"query_var" => true,
//		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes" ],
//		"taxonomies" => [ "post_tag", "geo-location", "white_paper_categories", "sdm_categories", "sdm_tags" ],
//	];
//
//	register_post_type( "white_papers", $args );
//}
//
//add_action( 'init', 'cptui_register_my_cpts_white_papers' );
//function cptui_register_my_cpts_e_books() {
//
//	/**
//	 * Post Type: eBooks.
//	 */
//
//	$labels = [
//		"name" => __( "eBooks", "newspaper" ),
//		"singular_name" => __( "eBook", "newspaper" ),
//		"menu_name" => __( "My eBooks", "newspaper" ),
//		"all_items" => __( "All eBooks", "newspaper" ),
//		"add_new" => __( "Add new", "newspaper" ),
//		"add_new_item" => __( "Add new eBook", "newspaper" ),
//		"edit_item" => __( "Edit eBook", "newspaper" ),
//		"new_item" => __( "New eBook", "newspaper" ),
//		"view_item" => __( "View eBook", "newspaper" ),
//		"view_items" => __( "View eBooks", "newspaper" ),
//		"search_items" => __( "Search eBooks", "newspaper" ),
//		"not_found" => __( "No eBooks found", "newspaper" ),
//		"not_found_in_trash" => __( "No eBooks found in trash", "newspaper" ),
//		"parent" => __( "Parent eBook:", "newspaper" ),
//		"featured_image" => __( "Featured image for this eBook", "newspaper" ),
//		"set_featured_image" => __( "Set featured image for this eBook", "newspaper" ),
//		"remove_featured_image" => __( "Remove featured image for this eBook", "newspaper" ),
//		"use_featured_image" => __( "Use as featured image for this eBook", "newspaper" ),
//		"archives" => __( "eBook archives", "newspaper" ),
//		"insert_into_item" => __( "Insert into eBook", "newspaper" ),
//		"uploaded_to_this_item" => __( "Upload to this eBook", "newspaper" ),
//		"filter_items_list" => __( "Filter eBooks list", "newspaper" ),
//		"items_list_navigation" => __( "eBooks list navigation", "newspaper" ),
//		"items_list" => __( "eBooks list", "newspaper" ),
//		"attributes" => __( "eBooks attributes", "newspaper" ),
//		"name_admin_bar" => __( "eBook", "newspaper" ),
//		"item_published" => __( "eBook published", "newspaper" ),
//		"item_published_privately" => __( "eBook published privately.", "newspaper" ),
//		"item_reverted_to_draft" => __( "eBook reverted to draft.", "newspaper" ),
//		"item_scheduled" => __( "eBook scheduled", "newspaper" ),
//		"item_updated" => __( "eBook updated.", "newspaper" ),
//		"parent_item_colon" => __( "Parent eBook:", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "eBooks", "newspaper" ),
//		"labels" => $labels,
//		"description" => "",
//		"public" => true,
//		"publicly_queryable" => true,
//		"show_ui" => true,
//		"show_in_rest" => true,
//		"rest_base" => "",
//		"rest_controller_class" => "WP_REST_Posts_Controller",
//		"has_archive" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"delete_with_user" => false,
//		"exclude_from_search" => false,
//		"capability_type" => "post",
//		"map_meta_cap" => true,
//		"hierarchical" => false,
//		"rewrite" => [ "slug" => "ebooks", "with_front" => true ],
//		"query_var" => true,
//		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields" ],
//		"taxonomies" => [ "post_tag", "geo-location", "e_book_categories" ],
//	];
//
//	register_post_type( "e_books", $args );
//}
//
//add_action( 'init', 'cptui_register_my_cpts_e_books' );
//function cptui_register_my_cpts_infographics() {
//
//	/**
//	 * Post Type: Infographics.
//	 */
//
//	$labels = [
//		"name" => __( "Infographics", "newspaper" ),
//		"singular_name" => __( "Infographic", "newspaper" ),
//		"menu_name" => __( "My Infographics", "newspaper" ),
//		"all_items" => __( "All Infographics", "newspaper" ),
//		"add_new" => __( "Add new", "newspaper" ),
//		"add_new_item" => __( "Add new Infographic", "newspaper" ),
//		"edit_item" => __( "Edit Infographic", "newspaper" ),
//		"new_item" => __( "New Infographic", "newspaper" ),
//		"view_item" => __( "View Infographic", "newspaper" ),
//		"view_items" => __( "View Infographics", "newspaper" ),
//		"search_items" => __( "Search Infographics", "newspaper" ),
//		"not_found" => __( "No Infographics found", "newspaper" ),
//		"not_found_in_trash" => __( "No Infographics found in trash", "newspaper" ),
//		"parent" => __( "Parent Infographic:", "newspaper" ),
//		"featured_image" => __( "Featured image for this Infographic", "newspaper" ),
//		"set_featured_image" => __( "Set featured image for this Infographic", "newspaper" ),
//		"remove_featured_image" => __( "Remove featured image for this Infographic", "newspaper" ),
//		"use_featured_image" => __( "Use as featured image for this Infographic", "newspaper" ),
//		"archives" => __( "Infographic archives", "newspaper" ),
//		"insert_into_item" => __( "Insert into Infographic", "newspaper" ),
//		"uploaded_to_this_item" => __( "Upload to this Infographic", "newspaper" ),
//		"filter_items_list" => __( "Filter Infographics list", "newspaper" ),
//		"items_list_navigation" => __( "Infographics list navigation", "newspaper" ),
//		"items_list" => __( "Infographics list", "newspaper" ),
//		"attributes" => __( "Infographics attributes", "newspaper" ),
//		"name_admin_bar" => __( "Infographic", "newspaper" ),
//		"item_published" => __( "Infographic published", "newspaper" ),
//		"item_published_privately" => __( "Infographic published privately.", "newspaper" ),
//		"item_reverted_to_draft" => __( "Infographic reverted to draft.", "newspaper" ),
//		"item_scheduled" => __( "Infographic scheduled", "newspaper" ),
//		"item_updated" => __( "Infographic updated.", "newspaper" ),
//		"parent_item_colon" => __( "Parent Infographic:", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "Infographics", "newspaper" ),
//		"labels" => $labels,
//		"description" => "",
//		"public" => true,
//		"publicly_queryable" => true,
//		"show_ui" => true,
//		"show_in_rest" => true,
//		"rest_base" => "",
//		"rest_controller_class" => "WP_REST_Posts_Controller",
//		"has_archive" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"delete_with_user" => false,
//		"exclude_from_search" => false,
//		"capability_type" => "post",
//		"map_meta_cap" => true,
//		"hierarchical" => true,
//		"rewrite" => [ "slug" => "infographics", "with_front" => true ],
//		"query_var" => true,
//		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "author", "page-attributes", "post-formats" ],
//		"taxonomies" => [ "post_tag", "geo-location", "infographic_categories" ],
//	];
//
//	register_post_type( "infographics", $args );
//}
//
//add_action( 'init', 'cptui_register_my_cpts_infographics' );
//function cptui_register_my_cpts_tech_news() {
//
//	/**
//	 * Post Type: News.
//	 */
//
//	$labels = [
//		"name" => __( "News", "newspaper" ),
//		"singular_name" => __( "New", "newspaper" ),
//		"menu_name" => __( "My News", "newspaper" ),
//		"all_items" => __( "All News", "newspaper" ),
//		"add_new" => __( "Add new", "newspaper" ),
//		"add_new_item" => __( "Add new New", "newspaper" ),
//		"edit_item" => __( "Edit New", "newspaper" ),
//		"new_item" => __( "New New", "newspaper" ),
//		"view_item" => __( "View New", "newspaper" ),
//		"view_items" => __( "View News", "newspaper" ),
//		"search_items" => __( "Search News", "newspaper" ),
//		"not_found" => __( "No News found", "newspaper" ),
//		"not_found_in_trash" => __( "No News found in trash", "newspaper" ),
//		"parent" => __( "Parent New:", "newspaper" ),
//		"featured_image" => __( "Featured image for this New", "newspaper" ),
//		"set_featured_image" => __( "Set featured image for this New", "newspaper" ),
//		"remove_featured_image" => __( "Remove featured image for this New", "newspaper" ),
//		"use_featured_image" => __( "Use as featured image for this New", "newspaper" ),
//		"archives" => __( "New archives", "newspaper" ),
//		"insert_into_item" => __( "Insert into New", "newspaper" ),
//		"uploaded_to_this_item" => __( "Upload to this New", "newspaper" ),
//		"filter_items_list" => __( "Filter News list", "newspaper" ),
//		"items_list_navigation" => __( "News list navigation", "newspaper" ),
//		"items_list" => __( "News list", "newspaper" ),
//		"attributes" => __( "News attributes", "newspaper" ),
//		"name_admin_bar" => __( "New", "newspaper" ),
//		"item_published" => __( "New published", "newspaper" ),
//		"item_published_privately" => __( "New published privately.", "newspaper" ),
//		"item_reverted_to_draft" => __( "New reverted to draft.", "newspaper" ),
//		"item_scheduled" => __( "New scheduled", "newspaper" ),
//		"item_updated" => __( "New updated.", "newspaper" ),
//		"parent_item_colon" => __( "Parent New:", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "News", "newspaper" ),
//		"labels" => $labels,
//		"description" => "",
//		"public" => true,
//		"publicly_queryable" => true,
//		"show_ui" => true,
//		"show_in_rest" => true,
//		"rest_base" => "",
//		"rest_controller_class" => "WP_REST_Posts_Controller",
//		"has_archive" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"delete_with_user" => false,
//		"exclude_from_search" => false,
//		"capability_type" => "post",
//		"map_meta_cap" => true,
//		"hierarchical" => false,
//		"rewrite" => [ "slug" => "news", "with_front" => true ],
//		"query_var" => true,
//		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "author" ],
//		"taxonomies" => [ "post_tag", "geo-location", "new_categories" ],
//	];
//
//	register_post_type( "tech_news", $args );
//}
//
//add_action( 'init', 'cptui_register_my_cpts_tech_news' );


/* END -- Custom Post Types */

/* START -- Custom Taxonomies */
// Taxonomy: Sponsered By.
$labels = [
    "name" => __("Sponsored By", "newspaper"),
    "singular_name" => __("Sponsored By", "newspaper"),
    "menu_name" => __("Sponsored By", "newspaper"),
    "all_items" => __("All Sponsored By", "newspaper"),
    "edit_item" => __("Edit Sponsored By", "newspaper"),
    "view_item" => __("View Sponsored By", "newspaper"),
    "update_item" => __("Update Sponsored By name", "newspaper"),
    "add_new_item" => __("Add new Sponsored By", "newspaper"),
    "new_item_name" => __("New Sponsored By name", "newspaper"),
    "parent_item" => __("Parent Sponsored By", "newspaper"),
    "parent_item_colon" => __("Parent Type Category:", "newspaper"),
    "search_items" => __("Search Sponsored By", "newspaper"),
    "popular_items" => __("Popular Sponsored By", "newspaper"),
    "separate_items_with_commas" => __("Separate Sponsored By with commas", "newspaper"),
    "add_or_remove_items" => __("Add or remove Sponsored By", "newspaper"),
    "choose_from_most_used" => __("Choose from the most used Sponsored By", "newspaper"),
    "not_found" => __("No Sponsored By found", "newspaper"),
    "no_terms" => __("No Sponsored By", "newspaper"),
    "items_list_navigation" => __("Sponsored By list navigation", "newspaper"),
    "items_list" => __("Sponsored By list", "newspaper"),
];

$args = [
    "label" => __("Sponsored By", "newspaper"),
    "labels" => $labels,
    "public" => true,
    "publicly_queryable" => true,
    "hierarchical" => true,
    "show_ui" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "query_var" => true,
    "rewrite" => ['slug' => 'sponsored_by', 'with_front' => true, 'hierarchical' => true,],
    "show_admin_column" => false,
    "show_in_rest" => true,
    "rest_base" => "sponsored_by",
    "rest_controller_class" => "WP_REST_Terms_Controller",
    "show_in_quick_edit" => false,
];
register_taxonomy("sponsored_by", [ "page", "resources","white_papers", "e_books","posts", "tech_news", "events"], $args);
function cptui_register_my_taxes() {

    /**
     * Taxonomy: White Paper Categories.
     */
    $labels = [
        "name" => __("White Paper Categories", "newspaper"),
        "singular_name" => __("White Paper Category", "newspaper"),
        "menu_name" => __("White Paper Categories", "newspaper"),
        "all_items" => __("All White Paper Categories", "newspaper"),
        "edit_item" => __("Edit White Paper Category", "newspaper"),
        "view_item" => __("View White Paper Category", "newspaper"),
        "update_item" => __("Update White Paper Category name", "newspaper"),
        "add_new_item" => __("Add new White Paper Category", "newspaper"),
        "new_item_name" => __("New White Paper Category name", "newspaper"),
        "parent_item" => __("Parent White Paper Category", "newspaper"),
        "parent_item_colon" => __("Parent White Paper Category:", "newspaper"),
        "search_items" => __("Search White Paper Categories", "newspaper"),
        "popular_items" => __("Popular White Paper Categories", "newspaper"),
        "separate_items_with_commas" => __("Separate White Paper Categories with commas", "newspaper"),
        "add_or_remove_items" => __("Add or remove White Paper Categories", "newspaper"),
        "choose_from_most_used" => __("Choose from the most used White Paper Categories", "newspaper"),
        "not_found" => __("No White Paper Categories found", "newspaper"),
        "no_terms" => __("No White Paper Categories", "newspaper"),
        "items_list_navigation" => __("White Paper Categories list navigation", "newspaper"),
        "items_list" => __("White Paper Categories list", "newspaper"),
    ];

    $args = [
        "label" => __("White Paper Categories", "newspaper"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'white_paper_categories', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "white_paper_categories",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("white_paper_categories", ["white_papers"], $args);

    /**
     * Taxonomy: News Categories.
     */
    $labels = [
        "name" => __("News Categories", "newspaper"),
        "singular_name" => __("News Category", "newspaper"),
        "menu_name" => __("News Categories", "newspaper"),
        "all_items" => __("All News Categories", "newspaper"),
        "edit_item" => __("Edit News Category", "newspaper"),
        "view_item" => __("View News Category", "newspaper"),
        "update_item" => __("Update News Category name", "newspaper"),
        "add_new_item" => __("Add new News Category", "newspaper"),
        "new_item_name" => __("New News Category name", "newspaper"),
        "parent_item" => __("Parent News Category", "newspaper"),
        "parent_item_colon" => __("Parent News Category:", "newspaper"),
        "search_items" => __("Search News Categories", "newspaper"),
        "popular_items" => __("Popular News Categories", "newspaper"),
        "separate_items_with_commas" => __("Separate News Categories with commas", "newspaper"),
        "add_or_remove_items" => __("Add or remove News Categories", "newspaper"),
        "choose_from_most_used" => __("Choose from the most used News Categories", "newspaper"),
        "not_found" => __("No News Categories found", "newspaper"),
        "no_terms" => __("No News Categories", "newspaper"),
        "items_list_navigation" => __("News Categories list navigation", "newspaper"),
        "items_list" => __("News Categories list", "newspaper"),
    ];

    $args = [
        "label" => __("News Categories", "newspaper"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'new_categories', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "new_categories",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("new_categories", ["tech_news"], $args);

    /**
     * Taxonomy: E-Book Categories.
     */
    $labels = [
        "name" => __("E-Book Categories", "newspaper"),
        "singular_name" => __("E-Book Category", "newspaper"),
        "menu_name" => __("E-Book Categories", "newspaper"),
        "all_items" => __("All E-Book Categories", "newspaper"),
        "edit_item" => __("Edit E-Book Category", "newspaper"),
        "view_item" => __("View E-Book Category", "newspaper"),
        "update_item" => __("Update E-Book Category name", "newspaper"),
        "add_new_item" => __("Add new E-Book Category", "newspaper"),
        "new_item_name" => __("New E-Book Category name", "newspaper"),
        "parent_item" => __("Parent E-Book Category", "newspaper"),
        "parent_item_colon" => __("Parent E-Book Category:", "newspaper"),
        "search_items" => __("Search E-Book Categories", "newspaper"),
        "popular_items" => __("Popular E-Book Categories", "newspaper"),
        "separate_items_with_commas" => __("Separate E-Book Categories with commas", "newspaper"),
        "add_or_remove_items" => __("Add or remove E-Book Categories", "newspaper"),
        "choose_from_most_used" => __("Choose from the most used E-Book Categories", "newspaper"),
        "not_found" => __("No E-Book Categories found", "newspaper"),
        "no_terms" => __("No E-Book Categories", "newspaper"),
        "items_list_navigation" => __("E-Book Categories list navigation", "newspaper"),
        "items_list" => __("E-Book Categories list", "newspaper"),
    ];

    $args = [
        "label" => __("E-Book Categories", "newspaper"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'e_book_categories', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "e_book_categories",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("e_book_categories", ["e_books"], $args);


    $labels = [
        "name" => __("Resource Types", "newspaper"),
        "singular_name" => __("Resource Type", "newspaper"),
        "menu_name" => __("Resource Types", "newspaper"),
        "all_items" => __("All Resource Types", "newspaper"),
        "edit_item" => __("Edit Resource Type", "newspaper"),
        "view_item" => __("View Resource Type", "newspaper"),
        "update_item" => __("Update Resource Type name", "newspaper"),
        "add_new_item" => __("Add new Resource Type", "newspaper"),
        "new_item_name" => __("New Resource Type name", "newspaper"),
        "parent_item" => __("Parent Resource Type", "newspaper"),
        "parent_item_colon" => __("Parent Type Category:", "newspaper"),
        "search_items" => __("Search Resource Types", "newspaper"),
        "popular_items" => __("Popular Resource Types", "newspaper"),
        "separate_items_with_commas" => __("Separate Resource Types with commas", "newspaper"),
        "add_or_remove_items" => __("Add or remove Resource Types", "newspaper"),
        "choose_from_most_used" => __("Choose from the most used Resource Types", "newspaper"),
        "not_found" => __("No Resource Types found", "newspaper"),
        "no_terms" => __("No Resource Types", "newspaper"),
        "items_list_navigation" => __("Resource Types list navigation", "newspaper"),
        "items_list" => __("Resource Types list", "newspaper"),
    ];

    $args = [
        "label" => __("Resource Types", "newspaper"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'resource_types', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "resource_types",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("resource_types", ["resources"], $args);

    /**
     * Taxonomy: Infographic Categories.
     */
    $labels = [
        "name" => __("Infographic Categories", "newspaper"),
        "singular_name" => __("Infographic Category", "newspaper"),
    ];

    $args = [
        "label" => __("Infographic Categories", "newspaper"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'infographic_categories', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "infographic_categories",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("infographic_categories", ["infographics"], $args);
}

add_action('init', 'cptui_register_my_taxes');


//function cptui_register_my_taxes_white_paper_categories() {
//
//	/**
//	 * Taxonomy: White Paper Categories.
//	 */
//
//	$labels = [
//		"name" => __( "White Paper Categories", "newspaper" ),
//		"singular_name" => __( "White Paper Category", "newspaper" ),
//		"menu_name" => __( "White Paper Categories", "newspaper" ),
//		"all_items" => __( "All White Paper Categories", "newspaper" ),
//		"edit_item" => __( "Edit White Paper Category", "newspaper" ),
//		"view_item" => __( "View White Paper Category", "newspaper" ),
//		"update_item" => __( "Update White Paper Category name", "newspaper" ),
//		"add_new_item" => __( "Add new White Paper Category", "newspaper" ),
//		"new_item_name" => __( "New White Paper Category name", "newspaper" ),
//		"parent_item" => __( "Parent White Paper Category", "newspaper" ),
//		"parent_item_colon" => __( "Parent White Paper Category:", "newspaper" ),
//		"search_items" => __( "Search White Paper Categories", "newspaper" ),
//		"popular_items" => __( "Popular White Paper Categories", "newspaper" ),
//		"separate_items_with_commas" => __( "Separate White Paper Categories with commas", "newspaper" ),
//		"add_or_remove_items" => __( "Add or remove White Paper Categories", "newspaper" ),
//		"choose_from_most_used" => __( "Choose from the most used White Paper Categories", "newspaper" ),
//		"not_found" => __( "No White Paper Categories found", "newspaper" ),
//		"no_terms" => __( "No White Paper Categories", "newspaper" ),
//		"items_list_navigation" => __( "White Paper Categories list navigation", "newspaper" ),
//		"items_list" => __( "White Paper Categories list", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "White Paper Categories", "newspaper" ),
//		"labels" => $labels,
//		"public" => true,
//		"publicly_queryable" => true,
//		"hierarchical" => true,
//		"show_ui" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"query_var" => true,
//		"rewrite" => [ 'slug' => 'white_paper_categories', 'with_front' => true,  'hierarchical' => true, ],
//		"show_admin_column" => false,
//		"show_in_rest" => true,
//		"rest_base" => "white_paper_categories",
//		"rest_controller_class" => "WP_REST_Terms_Controller",
//		"show_in_quick_edit" => false,
//		];
//	register_taxonomy( "white_paper_categories", [ "white_papers" ], $args );
//}
//add_action( 'init', 'cptui_register_my_taxes_white_paper_categories' );
//function cptui_register_my_taxes_new_categories() {
//
//	/**
//	 * Taxonomy: News Categories.
//	 */
//
//	$labels = [
//		"name" => __( "News Categories", "newspaper" ),
//		"singular_name" => __( "News Category", "newspaper" ),
//		"menu_name" => __( "News Categories", "newspaper" ),
//		"all_items" => __( "All News Categories", "newspaper" ),
//		"edit_item" => __( "Edit News Category", "newspaper" ),
//		"view_item" => __( "View News Category", "newspaper" ),
//		"update_item" => __( "Update News Category name", "newspaper" ),
//		"add_new_item" => __( "Add new News Category", "newspaper" ),
//		"new_item_name" => __( "New News Category name", "newspaper" ),
//		"parent_item" => __( "Parent News Category", "newspaper" ),
//		"parent_item_colon" => __( "Parent News Category:", "newspaper" ),
//		"search_items" => __( "Search News Categories", "newspaper" ),
//		"popular_items" => __( "Popular News Categories", "newspaper" ),
//		"separate_items_with_commas" => __( "Separate News Categories with commas", "newspaper" ),
//		"add_or_remove_items" => __( "Add or remove News Categories", "newspaper" ),
//		"choose_from_most_used" => __( "Choose from the most used News Categories", "newspaper" ),
//		"not_found" => __( "No News Categories found", "newspaper" ),
//		"no_terms" => __( "No News Categories", "newspaper" ),
//		"items_list_navigation" => __( "News Categories list navigation", "newspaper" ),
//		"items_list" => __( "News Categories list", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "News Categories", "newspaper" ),
//		"labels" => $labels,
//		"public" => true,
//		"publicly_queryable" => true,
//		"hierarchical" => true,
//		"show_ui" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"query_var" => true,
//		"rewrite" => [ 'slug' => 'new_categories', 'with_front' => true,  'hierarchical' => true, ],
//		"show_admin_column" => false,
//		"show_in_rest" => true,
//		"rest_base" => "new_categories",
//		"rest_controller_class" => "WP_REST_Terms_Controller",
//		"show_in_quick_edit" => false,
//		];
//	register_taxonomy( "new_categories", [ "tech_news" ], $args );
//}
//add_action( 'init', 'cptui_register_my_taxes_new_categories' );
//function cptui_register_my_taxes_e_book_categories() {
//
//	/**
//	 * Taxonomy: E-Book Categories.
//	 */
//
//	$labels = [
//		"name" => __( "E-Book Categories", "newspaper" ),
//		"singular_name" => __( "E-Book Category", "newspaper" ),
//		"menu_name" => __( "E-Book Categories", "newspaper" ),
//		"all_items" => __( "All E-Book Categories", "newspaper" ),
//		"edit_item" => __( "Edit E-Book Category", "newspaper" ),
//		"view_item" => __( "View E-Book Category", "newspaper" ),
//		"update_item" => __( "Update E-Book Category name", "newspaper" ),
//		"add_new_item" => __( "Add new E-Book Category", "newspaper" ),
//		"new_item_name" => __( "New E-Book Category name", "newspaper" ),
//		"parent_item" => __( "Parent E-Book Category", "newspaper" ),
//		"parent_item_colon" => __( "Parent E-Book Category:", "newspaper" ),
//		"search_items" => __( "Search E-Book Categories", "newspaper" ),
//		"popular_items" => __( "Popular E-Book Categories", "newspaper" ),
//		"separate_items_with_commas" => __( "Separate E-Book Categories with commas", "newspaper" ),
//		"add_or_remove_items" => __( "Add or remove E-Book Categories", "newspaper" ),
//		"choose_from_most_used" => __( "Choose from the most used E-Book Categories", "newspaper" ),
//		"not_found" => __( "No E-Book Categories found", "newspaper" ),
//		"no_terms" => __( "No E-Book Categories", "newspaper" ),
//		"items_list_navigation" => __( "E-Book Categories list navigation", "newspaper" ),
//		"items_list" => __( "E-Book Categories list", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "E-Book Categories", "newspaper" ),
//		"labels" => $labels,
//		"public" => true,
//		"publicly_queryable" => true,
//		"hierarchical" => true,
//		"show_ui" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"query_var" => true,
//		"rewrite" => [ 'slug' => 'e_book_categories', 'with_front' => true,  'hierarchical' => true, ],
//		"show_admin_column" => false,
//		"show_in_rest" => true,
//		"rest_base" => "e_book_categories",
//		"rest_controller_class" => "WP_REST_Terms_Controller",
//		"show_in_quick_edit" => false,
//		];
//	register_taxonomy( "e_book_categories", [ "e_books" ], $args );
//}
//add_action( 'init', 'cptui_register_my_taxes_e_book_categories' );
//function cptui_register_my_taxes_infographic_categories() {
//
//	/**
//	 * Taxonomy: Infographics Categories.
//	 */
//
//	$labels = [
//		"name" => __( "Infographic Categories", "newspaper" ),
//		"singular_name" => __( "Infographic Category", "newspaper" ),
//	];
//
//	$args = [
//		"label" => __( "Infographic Categories", "newspaper" ),
//		"labels" => $labels,
//		"public" => true,
//		"publicly_queryable" => true,
//		"hierarchical" => true,
//		"show_ui" => true,
//		"show_in_menu" => true,
//		"show_in_nav_menus" => true,
//		"query_var" => true,
//		"rewrite" => [ 'slug' => 'infographic_categories', 'with_front' => true,  'hierarchical' => true, ],
//		"show_admin_column" => false,
//		"show_in_rest" => true,
//		"rest_base" => "infographic_categories",
//		"rest_controller_class" => "WP_REST_Terms_Controller",
//		"show_in_quick_edit" => false,
//		];
//	register_taxonomy( "infographic_categories", [ "infographics" ], $args );
//}
//add_action( 'init', 'cptui_register_my_taxes_infographic_categories' );

/* END -- Custom Taxonomies */
/* START -- Users List - Registration Date field and sorting */
/*
 * Create a column. And maybe remove some of the default ones
 * @param array $columns Array of all user table columns {column ID} => {column Name} 
 */
add_filter('manage_users_columns', 'rudr_modify_user_table');

function rudr_modify_user_table($columns) {

    // unset( $columns['posts'] ); // maybe you would like to remove default columns
    $columns['registration_date'] = 'Registration date'; // add new

    return $columns;
}

/*
 * Fill our new column with the registration dates of the users
 * @param string $row_output text/HTML output of a table cell
 * @param string $column_id_attr column ID
 * @param int $user user ID (in fact - table row ID)
 */
add_filter('manage_users_custom_column', 'rudr_modify_user_table_row', 10, 3);

function rudr_modify_user_table_row($row_output, $column_id_attr, $user) {

    $date_format = 'j M, Y H:i';

    switch ($column_id_attr) {
        case 'registration_date' :
            return date($date_format, strtotime(get_the_author_meta('registered', $user)));
            break;
        default:
    }

    return $row_output;
}

/*
 * Make our "Registration date" column sortable
 * @param array $columns Array of all user sortable columns {column ID} => {orderby GET-param} 
 */
add_filter('manage_users_sortable_columns', 'rudr_make_registered_column_sortable');

function rudr_make_registered_column_sortable($columns) {
    return wp_parse_args(array('registration_date' => 'registered'), $columns);
}

/* END -- Users List - Registration Date field and sorting */

/* START -- Get Thank You page LINKS of all resources */

function fetch_thankyou_links($post_types = array()) {
    global $wpdb;
    $query_str = implode('\' OR wp1.post_type LIKE \'', $post_types);
    $myposts = $wpdb->get_results("SELECT wp1.ID,wp1.post_title,wp1.post_status,wp1.post_name,wp1.post_type,wp2.ID as download_id FROM $wpdb->posts wp1 "
            . "JOIN $wpdb->posts wp2 ON wp1.post_title = wp2.post_title AND wp2.post_type = 'sdm_downloads' "
            . "WHERE 1=1 AND wp1.post_status LIKE 'publish' AND (wp1.post_type LIKE '$query_str');");
    foreach ($myposts as $post) {
        $post_link = apply_filters('post_type_link', get_permalink($post->ID), $post);
        echo $post_link . '?download=thank-you&data-id=' . $post->download_id . '<br>';
    }
//    die();
}

//fetch_thankyou_links(array('white_papers','infographics','e_books'));

/* END -- Get Thank You page LINKS of all resources */


//if( !function_exists( 'plugin_prefix_unregister_post_type' ) ) {
//    function plugin_prefix_unregister_post_type(){
//        unregister_post_type( 'events' );
//    }
//}
//add_action('init','plugin_prefix_unregister_post_type');
//function custom_unregister_theme_post_types() {
//    global $wp_post_types;
//
//      if ( isset( $wp_post_types["events"] ) ) {
//         unset( $wp_post_types[ "events" ] ); //UPDATED
//      }
//
//}
//add_action( 'init', 'custom_unregister_theme_post_types', 20 );

function tradingview_stock_ticker_shortcode($atts) {
    return '<div class="home-line-height"><iframe scrolling="no" allowtransparency="true" frameborder="0" src="https://s.tradingview.com/embed-widget/ticker-tape/?locale=in#%7B%22symbols%22%3A%5B%7B%22description%22%3A%22Peloton%22%2C%22proName%22%3A%22NASDAQ%3APTON%22%7D%2C%7B%22description%22%3A%22Farfetch%20Limited%22%2C%22proName%22%3A%22NYSE%3AFTCH%22%7D%2C%7B%22description%22%3A%22Crowdstrike%22%2C%22proName%22%3A%22NASDAQ%3ACRWD%22%7D%2C%7B%22description%22%3A%22Datadog%22%2C%22proName%22%3A%22NASDAQ%3ADDOG%22%7D%2C%7B%22description%22%3A%22Zoom%20Video%22%2C%22proName%22%3A%22NASDAQ%3AZM%22%7D%2C%7B%22description%22%3A%22Alteryx%22%2C%22proName%22%3A%22NYSE%3AAYX%22%7D%2C%7B%22description%22%3A%22Cloudera%22%2C%22proName%22%3A%22NYSE%3ACLDR%22%7D%2C%7B%22description%22%3A%22Lyft%22%2C%22proName%22%3A%22NASDAQ%3ALYFT%22%7D%2C%7B%22description%22%3A%22Twilio%22%2C%22proName%22%3A%22NYSE%3ATWLO%22%7D%2C%7B%22description%22%3A%22Lightspeed%20POS%22%2C%22proName%22%3A%22TSX%3ALSPD%22%7D%2C%7B%22description%22%3A%22Elastic%20N.V.%22%2C%22proName%22%3A%22NYSE%3AESTC%22%7D%2C%7B%22description%22%3A%22The%20RealReal%22%2C%22proName%22%3A%22NASDAQ%3AREAL%22%7D%2C%7B%22description%22%3A%22Cloudflare%22%2C%22proName%22%3A%22NYSE%3ANET%22%7D%2C%7B%22description%22%3A%22Coupa%20Software%22%2C%22proName%22%3A%22NASDAQ%3ACOUP%22%7D%2C%7B%22description%22%3A%22Smile%20Direct%20Club%22%2C%22proName%22%3A%22NASDAQ%3ASDC%22%7D%2C%7B%22description%22%3A%22Bill.com%22%2C%22proName%22%3A%22CURRENCYCOM%3ABILL%22%7D%2C%7B%22description%22%3A%22Shopify%22%2C%22proName%22%3A%22NYSE%3ASHOP%22%7D%2C%7B%22description%22%3A%22Okta%22%2C%22proName%22%3A%22NASDAQ%3AOKTA%22%7D%2C%7B%22description%22%3A%22MongoDB%22%2C%22proName%22%3A%22NASDAQ%3AMDB%22%7D%2C%7B%22description%22%3A%22Fastly%22%2C%22proName%22%3A%22NYSE%3AFSLY%22%7D%2C%7B%22description%22%3A%22Anaplan%22%2C%22proName%22%3A%22NYSE%3APLAN%22%7D%2C%7B%22description%22%3A%22Fiverr%22%2C%22proName%22%3A%22NYSE%3AFVRR%22%7D%2C%7B%22description%22%3A%222U%22%2C%22proName%22%3A%22NASDAQ%3ATWOU%22%7D%2C%7B%22description%22%3A%22Square%22%2C%22proName%22%3A%22NYSE%3ASQ%22%7D%2C%7B%22description%22%3A%22Avalara%22%2C%22proName%22%3A%22NYSE%3AAVLR%22%7D%2C%7B%22description%22%3A%22DocuSign%22%2C%22proName%22%3A%22NASDAQ%3ADOCU%22%7D%2C%7B%22description%22%3A%22PagerDuty%22%2C%22proName%22%3A%22NYSE%3APD%22%7D%2C%7B%22description%22%3A%22Atlassian%20%22%2C%22proName%22%3A%22NASDAQ%3ATEAM%22%7D%2C%7B%22description%22%3A%22Everbridge%22%2C%22proName%22%3A%22NASDAQ%3AEVBG%22%7D%2C%7B%22description%22%3A%22Zscaler%22%2C%22proName%22%3A%22NASDAQ%3AZS%22%7D%2C%7B%22description%22%3A%22Stichfix%22%2C%22proName%22%3A%22NASDAQ%3ASFIX%22%7D%2C%7B%22description%22%3A%22Salesforce.com%22%2C%22proName%22%3A%22NYSE%3ACRM%22%7D%2C%7B%22description%22%3A%22The%20Trade%20Desk%22%2C%22proName%22%3A%22NASDAQ%3ATTD%22%7D%2C%7B%22description%22%3A%22Veeva%20Systems%22%2C%22proName%22%3A%22NYSE%3AVEEV%22%7D%2C%7B%22description%22%3A%22Ringcentral%22%2C%22proName%22%3A%22NYSE%3ARNG%22%7D%2C%7B%22description%22%3A%22AppFolio%22%2C%22proName%22%3A%22NASDAQ%3AAPPF%22%7D%2C%7B%22description%22%3A%22Zendesk%22%2C%22proName%22%3A%22NYSE%3AZEN%22%7D%2C%7B%22description%22%3A%22Rapid7%22%2C%22proName%22%3A%22NASDAQ%3ARPD%22%7D%2C%7B%22description%22%3A%22ServiceNow%22%2C%22proName%22%3A%22NYSE%3ANOW%22%7D%2C%7B%22description%22%3A%22Pluralsight%22%2C%22proName%22%3A%22NASDAQ%3APS%22%7D%2C%7B%22description%22%3A%22Xero%22%2C%22proName%22%3A%22ASX%3AXRO%22%7D%2C%7B%22description%22%3A%228x8%22%2C%22proName%22%3A%22NYSE%3AEGHT%22%7D%2C%7B%22description%22%3A%22Netflix%22%2C%22proName%22%3A%22NASDAQ%3ANFLX%22%7D%2C%7B%22description%22%3A%22UBER%20TECHNOLOGIES%22%2C%22proName%22%3A%22NYSE%3AUBER%22%7D%2C%7B%22description%22%3A%22HubSpot%22%2C%22proName%22%3A%22NYSE%3AHUBS%22%7D%2C%7B%22description%22%3A%22Q2%20Holdings%22%2C%22proName%22%3A%22NYSE%3AQTWO%22%7D%2C%7B%22description%22%3A%22Tenable%20Holdings%22%2C%22proName%22%3A%22NASDAQ%3ATENB%22%7D%2C%7B%22description%22%3A%22BlackLine%22%2C%22proName%22%3A%22NASDAQ%3ABL%22%7D%2C%7B%22description%22%3A%22Paycom%20Software%22%2C%22proName%22%3A%22NYSE%3APAYC%22%7D%2C%7B%22description%22%3A%22Spotify%22%2C%22proName%22%3A%22NYSE%3ASPOT%22%7D%2C%7B%22description%22%3A%22LiveRamp%20Holdings%22%2C%22proName%22%3A%22NYSE%3ARAMP%22%7D%2C%7B%22description%22%3A%22Yext%22%2C%22proName%22%3A%22NYSE%3AYEXT%22%7D%2C%7B%22description%22%3A%22FIVN%22%2C%22proName%22%3A%22NASDAQ%3AFIVN%22%7D%2C%7B%22description%22%3A%22SPLK%22%2C%22proName%22%3A%22NASDAQ%3ASPLK%22%7D%2C%7B%22description%22%3A%22Medallia%22%2C%22proName%22%3A%22NYSE%3AMDLA%22%7D%2C%7B%22description%22%3A%22Mimecast%20Limited%22%2C%22proName%22%3A%22NASDAQ%3AMIME%22%7D%2C%7B%22description%22%3A%22Dynatrace%22%2C%22proName%22%3A%22NYSE%3ADT%22%7D%2C%7B%22description%22%3A%22WIX.COM%22%2C%22proName%22%3A%22NASDAQ%3AWIX%22%7D%2C%7B%22description%22%3A%22Workiva%22%2C%22proName%22%3A%22NYSE%3AWK%22%7D%2C%7B%22description%22%3A%22Teladoc%22%2C%22proName%22%3A%22NYSE%3ATDOC%22%7D%2C%7B%22description%22%3A%22Survey%20Monkey%22%2C%22proName%22%3A%22NASDAQ%3ASVMK%22%7D%2C%7B%22description%22%3A%22Workday%22%2C%22proName%22%3A%22NASDAQ%3AWDAY%22%7D%2C%7B%22description%22%3A%22Instructure%22%2C%22proName%22%3A%22SWB%3A1IN%22%7D%2C%7B%22description%22%3A%22Amazon%22%2C%22proName%22%3A%22NASDAQ%3AAMZN%22%7D%2C%7B%22description%22%3A%22Paylocity%20Holding%20Corporation%22%2C%22proName%22%3A%22NASDAQ%3APCTY%22%7D%2C%7B%22description%22%3A%22New%20Relic%22%2C%22proName%22%3A%22NYSE%3ANEWR%22%7D%2C%7B%22description%22%3A%22Proofpoint%22%2C%22proName%22%3A%22NASDAQ%3APFPT%22%7D%2C%7B%22description%22%3A%22Match%20Group%22%2C%22proName%22%3A%22NASDAQ%3AMTCH%22%7D%2C%7B%22description%22%3A%22Autodesk%22%2C%22proName%22%3A%22NASDAQ%3AADSK%22%7D%2C%7B%22description%22%3A%22Domo%22%2C%22proName%22%3A%22NASDAQ%3ADOMO%22%7D%2C%7B%22description%22%3A%22Adobe%22%2C%22proName%22%3A%22NASDAQ%3AADBE%22%7D%2C%7B%22description%22%3A%22Talend%20S.A.%22%2C%22proName%22%3A%22NASDAQ%3ATLND%22%7D%2C%7B%22description%22%3A%22Upwork%22%2C%22proName%22%3A%22NASDAQ%3AUPWK%22%7D%2C%7B%22description%22%3A%22Dropbox%22%2C%22proName%22%3A%22NASDAQ%3ADBX%22%7D%2C%7B%22description%22%3A%22Bandwidth%22%2C%22proName%22%3A%22NASDAQ%3ABAND%22%7D%2C%7B%22description%22%3A%22Paypal%22%2C%22proName%22%3A%22NASDAQ%3APYPL%22%7D%2C%7B%22description%22%3A%22J2%20Global%22%2C%22proName%22%3A%22NASDAQ%3AJCOM%22%7D%2C%7B%22description%22%3A%22Appian%20Corporation%22%2C%22proName%22%3A%22NASDAQ%3AAPPN%22%7D%2C%7B%22description%22%3A%22Zuora%22%2C%22proName%22%3A%22NYSE%3AZUO%22%7D%2C%7B%22description%22%3A%22Palo%20Alto%20Networks%22%2C%22proName%22%3A%22NYSE%3APANW%22%7D%2C%7B%22description%22%3A%22PING%20IDENTITY%22%2C%22proName%22%3A%22NYSE%3APING%22%7D%2C%7B%22description%22%3A%22Qualys%22%2C%22proName%22%3A%22NASDAQ%3AQLYS%22%7D%2C%7B%22description%22%3A%22Ceridian%20HCM%20Holding%22%2C%22proName%22%3A%22NYSE%3ACDAY%22%7D%2C%7B%22description%22%3A%22Intuit%22%2C%22proName%22%3A%22NASDAQ%3AINTU%22%7D%2C%7B%22description%22%3A%22RealPage%22%2C%22proName%22%3A%22NASDAQ%3ARP%22%7D%2C%7B%22description%22%3A%22GoDaddy%22%2C%22proName%22%3A%22NYSE%3AGDDY%22%7D%2C%7B%22description%22%3A%22Box%22%2C%22proName%22%3A%22NYSE%3ABOX%22%7D%2C%7B%22description%22%3A%22SolarWinds%22%2C%22proName%22%3A%22NYSE%3ASWI%22%7D%2C%7B%22description%22%3A%22SAILPOINT%20TECHNOLOGIES%22%2C%22proName%22%3A%22NYSE%3ASAIL%22%7D%2C%7B%22description%22%3A%22Eventbrite%22%2C%22proName%22%3A%22NYSE%3AEB%22%7D%2C%7B%22description%22%3A%22Expedia%22%2C%22proName%22%3A%22NASDAQ%3AEXPE%22%7D%2C%7B%22description%22%3A%22FireEye%22%2C%22proName%22%3A%22NASDAQ%3AFEYE%22%7D%2C%7B%22description%22%3A%22Blackbaud%22%2C%22proName%22%3A%22NASDAQ%3ABLKB%22%7D%2C%7B%22description%22%3A%22Black%20Knight%22%2C%22proName%22%3A%22NYSE%3ABKI%22%7D%2C%7B%22description%22%3A%22Shutterstock%22%2C%22proName%22%3A%22NYSE%3ASSTK%22%7D%2C%7B%22description%22%3A%22LogMein%22%2C%22proName%22%3A%22NASDAQ%3ALOGM%22%7D%2C%7B%22description%22%3A%22Bookings%22%2C%22proName%22%3A%22NASDAQ%3ABKNG%22%7D%2C%7B%22description%22%3A%22Check%20Point%20Software%22%2C%22proName%22%3A%22NASDAQ%3ACHKP%22%7D%2C%7B%22description%22%3A%22Nutanix%22%2C%22proName%22%3A%22NASDAQ%3ANTNX%22%7D%2C%7B%22description%22%3A%22Guidewire%20Software%22%2C%22proName%22%3A%22NYSE%3AGWRE%22%7D%2C%7B%22description%22%3A%22Ebay%22%2C%22proName%22%3A%22NASDAQ%3AEBAY%22%7D%2C%7B%22description%22%3A%22TripAdvisor%22%2C%22proName%22%3A%22NASDAQ%3ATRIP%22%7D%2C%7B%22description%22%3A%22Blue%20Apron%22%2C%22proName%22%3A%22NYSE%3AAPRN%22%7D%2C%7B%22description%22%3A%22Facebook%22%2C%22proName%22%3A%22NASDAQ%3AFB%22%7D%5D%2C%22colorTheme%22%3A%22light%22%2C%22isTransparent%22%3Afalse%2C%22displayMode%22%3A%22regular%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A46%2C%22utm_source%22%3A%22techversions.com%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22ticker-tape%22%7D" style="box-sizing: border-box; height: 46px; width: 100%;padding: 0;margin: 0;display:block;border:none;overflow:hidden;"></iframe></div>';
}

function tradingview_stock_ticker_shortcodeold($atts) {
    return '<div class="tradingview-widget-container">
<div class="tradingview-widget-container__widget"></div>        
<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
  {
  "symbols": [
    {
      "description": "Peloton",
      "proName": "NASDAQ:PTON"
    },
    {
      "description": "Farfetch Limited",
      "proName": "NYSE:FTCH"
    },
    {
      "description": "Crowdstrike",
      "proName": "NASDAQ:CRWD"
    },
    {
      "description": "Datadog",
      "proName": "NASDAQ:DDOG"
    },
    {
      "description": "Zoom Video",
      "proName": "NASDAQ:ZM"
    },
    {
      "description": "Alteryx",
      "proName": "NYSE:AYX"
    },
    {
      "description": "Cloudera",
      "proName": "NYSE:CLDR"
    },
    {
      "description": "Lyft",
      "proName": "NASDAQ:LYFT"
    },
    {
      "description": "Twilio",
      "proName": "NYSE:TWLO"
    },
    {
      "description": "Lightspeed POS",
      "proName": "TSX:LSPD"
    },
    {
      "description": "Elastic N.V.",
      "proName": "NYSE:ESTC"
    },
    {
      "description": "The RealReal",
      "proName": "NASDAQ:REAL"
    },
    {
      "description": "Cloudflare",
      "proName": "NYSE:NET"
    },
    {
      "description": "Coupa Software",
      "proName": "NASDAQ:COUP"
    },
    {
      "description": "Smile Direct Club",
      "proName": "NASDAQ:SDC"
    },
    {
      "description": "Bill.com",
      "proName": "CURRENCYCOM:BILL"
    },
    {
      "description": "Shopify",
      "proName": "NYSE:SHOP"
    },
    {
      "description": "Okta",
      "proName": "NASDAQ:OKTA"
    },
    {
      "description": "MongoDB",
      "proName": "NASDAQ:MDB"
    },
    {
      "description": "Fastly",
      "proName": "NYSE:FSLY"
    },
    {
      "description": "Anaplan",
      "proName": "NYSE:PLAN"
    },
    {
      "description": "Fiverr",
      "proName": "NYSE:FVRR"
    },
    {
      "description": "2U",
      "proName": "NASDAQ:TWOU"
    },
    {
      "description": "Square",
      "proName": "NYSE:SQ"
    },
    {
      "description": "Avalara",
      "proName": "NYSE:AVLR"
    },
    {
      "description": "DocuSign",
      "proName": "NASDAQ:DOCU"
    },
    {
      "description": "PagerDuty",
      "proName": "NYSE:PD"
    },
    {
      "description": "Atlassian ",
      "proName": "NASDAQ:TEAM"
    },
    {
      "description": "Everbridge",
      "proName": "NASDAQ:EVBG"
    },
    {
      "description": "Zscaler",
      "proName": "NASDAQ:ZS"
    },
    {
      "description": "Stichfix",
      "proName": "NASDAQ:SFIX"
    },
    {
      "description": "Salesforce.com",
      "proName": "NYSE:CRM"
    },
    {
      "description": "The Trade Desk",
      "proName": "NASDAQ:TTD"
    },
    {
      "description": "Veeva Systems",
      "proName": "NYSE:VEEV"
    },
    {
      "description": "Ringcentral",
      "proName": "NYSE:RNG"
    },
    {
      "description": "AppFolio",
      "proName": "NASDAQ:APPF"
    },
    {
      "description": "Zendesk",
      "proName": "NYSE:ZEN"
    },
    {
      "description": "Rapid7",
      "proName": "NASDAQ:RPD"
    },
    {
      "description": "ServiceNow",
      "proName": "NYSE:NOW"
    },
    {
      "description": "Pluralsight",
      "proName": "NASDAQ:PS"
    },
    {
      "description": "Xero",
      "proName": "ASX:XRO"
    },
    {
      "description": "8x8",
      "proName": "NYSE:EGHT"
    },
    {
      "description": "Netflix",
      "proName": "NASDAQ:NFLX"
    },
    {
      "description": "UBER TECHNOLOGIES",
      "proName": "NYSE:UBER"
    },
    {
      "description": "HubSpot",
      "proName": "NYSE:HUBS"
    },
    {
      "description": "Q2 Holdings",
      "proName": "NYSE:QTWO"
    },
    {
      "description": "Tenable Holdings",
      "proName": "NASDAQ:TENB"
    },
    {
      "description": "BlackLine",
      "proName": "NASDAQ:BL"
    },
    {
      "description": "Paycom Software",
      "proName": "NYSE:PAYC"
    },
    {
      "description": "Spotify",
      "proName": "NYSE:SPOT"
    },
    {
      "description": "LiveRamp Holdings",
      "proName": "NYSE:RAMP"
    },
    {
      "description": "Yext",
      "proName": "NYSE:YEXT"
    },
    {
      "description": "FIVN",
      "proName": "NASDAQ:FIVN"
    },
    {
      "description": "SPLK",
      "proName": "NASDAQ:SPLK"
    },
    {
      "description": "Medallia",
      "proName": "NYSE:MDLA"
    },
    {
      "description": "Mimecast Limited",
      "proName": "NASDAQ:MIME"
    },
    {
      "description": "Dynatrace",
      "proName": "NYSE:DT"
    },
    {
      "description": "WIX.COM",
      "proName": "NASDAQ:WIX"
    },
    {
      "description": "Workiva",
      "proName": "NYSE:WK"
    },
    {
      "description": "Teladoc",
      "proName": "NYSE:TDOC"
    },
    {
      "description": "Survey Monkey",
      "proName": "NASDAQ:SVMK"
    },
    {
      "description": "Workday",
      "proName": "NASDAQ:WDAY"
    },
    {
      "description": "Instructure",
      "proName": "SWB:1IN"
    },
    {
      "description": "Amazon",
      "proName": "NASDAQ:AMZN"
    },
    {
      "description": "Paylocity Holding Corporation",
      "proName": "NASDAQ:PCTY"
    },
    {
      "description": "New Relic",
      "proName": "NYSE:NEWR"
    },
    {
      "description": "Proofpoint",
      "proName": "NASDAQ:PFPT"
    },
    {
      "description": "Match Group",
      "proName": "NASDAQ:MTCH"
    },
    {
      "description": "Autodesk",
      "proName": "NASDAQ:ADSK"
    },
    {
      "description": "Domo",
      "proName": "NASDAQ:DOMO"
    },
    {
      "description": "Adobe",
      "proName": "NASDAQ:ADBE"
    },
    {
      "description": "Talend S.A.",
      "proName": "NASDAQ:TLND"
    },
    {
      "description": "Upwork",
      "proName": "NASDAQ:UPWK"
    },
    {
      "description": "Dropbox",
      "proName": "NASDAQ:DBX"
    },
    {
      "description": "Bandwidth",
      "proName": "NASDAQ:BAND"
    },
    {
      "description": "Paypal",
      "proName": "NASDAQ:PYPL"
    },
    {
      "description": "J2 Global",
      "proName": "NASDAQ:JCOM"
    },
    {
      "description": "Appian Corporation",
      "proName": "NASDAQ:APPN"
    },
    {
      "description": "Zuora",
      "proName": "NYSE:ZUO"
    },
    {
      "description": "Palo Alto Networks",
      "proName": "NYSE:PANW"
    },
    {
      "description": "PING IDENTITY",
      "proName": "NYSE:PING"
    },
    {
      "description": "Qualys",
      "proName": "NASDAQ:QLYS"
    },
    {
      "description": "Ceridian HCM Holding",
      "proName": "NYSE:CDAY"
    },
    {
      "description": "Intuit",
      "proName": "NASDAQ:INTU"
    },
    {
      "description": "RealPage",
      "proName": "NASDAQ:RP"
    },
    {
      "description": "GoDaddy",
      "proName": "NYSE:GDDY"
    },
    {
      "description": "Box",
      "proName": "NYSE:BOX"
    },
    {
      "description": "SolarWinds",
      "proName": "NYSE:SWI"
    },
    {
      "description": "SAILPOINT TECHNOLOGIES",
      "proName": "NYSE:SAIL"
    },
    {
      "description": "Eventbrite",
      "proName": "NYSE:EB"
    },
    {
      "description": "Expedia",
      "proName": "NASDAQ:EXPE"
    },
    {
      "description": "FireEye",
      "proName": "NASDAQ:FEYE"
    },
    {
      "description": "Blackbaud",
      "proName": "NASDAQ:BLKB"
    },
    {
      "description": "Black Knight",
      "proName": "NYSE:BKI"
    },
    {
      "description": "Shutterstock",
      "proName": "NYSE:SSTK"
    },
    {
      "description": "LogMein",
      "proName": "NASDAQ:LOGM"
    },
    {
      "description": "Bookings",
      "proName": "NASDAQ:BKNG"
    },
    {
      "description": "Check Point Software",
      "proName": "NASDAQ:CHKP"
    },
    {
      "description": "Nutanix",
      "proName": "NASDAQ:NTNX"
    },
    {
      "description": "Guidewire Software",
      "proName": "NYSE:GWRE"
    },
    {
      "description": "Ebay",
      "proName": "NASDAQ:EBAY"
    },
    {
      "description": "TripAdvisor",
      "proName": "NASDAQ:TRIP"
    },
    {
      "description": "Blue Apron",
      "proName": "NYSE:APRN"
    },
    {
      "description": "Facebook",
      "proName": "NASDAQ:FB"
    }
  ],
  "colorTheme": "light",
  "isTransparent": false,
  "displayMode": "regular",
  "locale": "in"
}
  </script></div>
<!-- TradingView Widget END -->';
}

add_shortcode('tradingview_stock_ticker', 'tradingview_stock_ticker_shortcode');


/*
 * START - Add a custom field in WP-Admin -> Settings - General Page
 */
add_action('admin_init', 'register_fields');

function register_fields() {
    register_setting('general', 'total_followers', 'esc_attr');
    add_settings_field('fav_color', '<label for="total_followers">' . __('Total Followers', 'total_followers') . '</label>', 'fields_html', 'general');
}

function fields_html() {
    $value = get_option('total_followers', '');
    echo '<input type="text" id="total_followers" name="total_followers" value="' . $value . '" />';
}

function home_total_followers_func() {
    $value = get_option('total_followers', '');
    return $value;
}

add_shortcode('home_total_followers', 'home_total_followers_func');

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'years',
        'm' => 'months',
        'w' => 'weeks',
        'd' => 'days',
        'h' => 'hours',
        'i' => 'minutes',
        's' => 'seconds',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
//            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            $v = ($diff->$k <= 1) ? rtrim($v, 's') : $v;
            $v = $diff->$k . ' ' . $v . '';
        } else {
            unset($string[$k]);
        }
    }

    if (isset($string['y'])) {
        $string['hide'] = 'true';
    } else if (isset($string['m'])) {
        unset($string['m']);
        $string['hide'] = 'true';
    } else if (isset($string['w'])) {
        unset($string['w']);
        $string['hide'] = 'true';
    }
    $before_slice = $string;

    if (!$full)
        $string = array_slice($string, 0, 1);
    $output = 'just now';
    if ($string) {
        if (!isset($before_slice['hide'])) {
            $output = implode(',', $string) . ' ago';
        } else {
            $output = '';
        }
    }
    return $output;
    //    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

//add_filter('user_registration_account_menu_items', 'ur_custom_menu_items', 10, 1);
//
//function ur_custom_menu_items($items) {
////    $items['login-history'] = __('Login History', 'user-registration');
////    $items['my-downloads'] = __('My Downloads', 'user-registration');
//    $items['email-preferences'] = __('Email Preferences', 'user-registration');
//    return $items;
//}
//
//add_action('init', 'user_registration_add_new_my_account_endpoint');
//
//function user_registration_add_new_my_account_endpoint() {
////    add_rewrite_endpoint('login-history', EP_PAGES);
////    add_rewrite_endpoint('my-downloads', EP_PAGES);
//    add_rewrite_endpoint('email-preferences', EP_PAGES);
//}
//
//function user_registration_email_preferences_endpoint_content() {
//    ur_get_template('myaccount/my-email-preferences.php');
//}
//
//add_action('user_registration_account_email-preferences_endpoint', 'user_registration_email_preferences_endpoint_content');

add_filter('user_registration_account_menu_items', 'ur_custom_menu_items', 10, 1);

function ur_custom_menu_items($items) {
    $items['login-history'] = __('Login History', 'user-registration');
    $items['my-downloads'] = __('My Downloads', 'user-registration');
    $items['email-preferences'] = __('Email Preference Center', 'user-registration');
    return $items;
}

add_action('init', 'user_registration_add_new_my_account_endpoint');

function user_registration_add_new_my_account_endpoint() {
    add_rewrite_endpoint('login-history', EP_PAGES);
    add_rewrite_endpoint('my-downloads', EP_PAGES);
    add_rewrite_endpoint('email-preferences', EP_PAGES);
}

function user_registration_login_history_endpoint_content() {
    ur_get_template('myaccount/my-login-history.php');
}

add_action('user_registration_account_login-history_endpoint', 'user_registration_login_history_endpoint_content');

function user_registration_my_downloads_endpoint_content() {
    ur_get_template('myaccount/my-downloads.php');
}

add_action('user_registration_account_my-downloads_endpoint', 'user_registration_my_downloads_endpoint_content');

function user_registration_email_preferences_endpoint_content() {
    ur_get_template('myaccount/my-email-preferences.php');
}

add_action('user_registration_account_email-preferences_endpoint', 'user_registration_email_preferences_endpoint_content');



add_action('user_registration_check_token_complete', 'ur_auto_login', 10, 2);

function ur_auto_login($user_id, $status) {

    if ($status === true) {
        $_SESSION['registered'] = 'true';
//        wp_set_auth_cookie($user_id, true);
        //Add in SendGrid Contact List
        $user_info = get_userdata($user_id);
        $user_meta = get_user_meta($user_id);

        //Unsubscribe the user from all groups by default except the DAILY ALERT
        $user_groups = sendgridController::fetch_groups();
        $user_groups = json_decode($user_groups);

        foreach ($user_groups as $single_grp) {
            if (!in_array($single_grp->id, array(sendgridController::SG_UNSUBSCRIBE_GROUPS['daily'], sendgridController::SG_UNSUBSCRIBE_GROUPS['TV_Email_Marketing']))) {
                $unsubscribe_from_group = sendgridController::add_user_suppression_group(array(
                            'group_id' => $single_grp->id,
                            'email_id' => $user_info->data->user_email,
                ));
            }
        }

        $data = array(
            'list_ids' => array(
                sendgridController::SG_REGISTRATION_LISTID
            ),
            'contacts' => array(array(
                    "country" => (isset($user_meta['country'])) ? $user_meta['country'][0] : '',
                    "email" => $user_info->data->user_email,
                    "first_name" => $user_meta['first_name'][0],
                    "last_name" => $user_meta['last_name'][0],
                ))
        );
        $response = sendgridController::add_to_list($data);
        wp_safe_redirect('/sign-in/?msg=verified'); // Redirect URL after login.
        exit();
    }
}

function update_suppression_group_func($data = array()) {
    $group_id = $_POST['group_id'];
    $curr_user = wp_get_current_user();
    $recipient_emails = array(
        "recipient_emails" => array(
            $curr_user->data->user_email,
    ));

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sendgrid.com/v3/asm/groups/$group_id/suppressions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($recipient_emails),
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . sendgridController::SG_API_KEY,
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    $msg = array();
    if ($err) {
        $msg = array(
            'status' => 'error',
            'message' => "cURL Error #:" . $err,
        );
    } else {
        $msg = array(
            'status' => 'success',
        );
    }

    return json_encode($msg);
}

add_action('wp_ajax_update_suppression_group_func', 'update_suppression_group_func');
add_action('wp_ajax_nopriv_update_suppression_group_func', 'update_suppression_group_func');

function remove_receipient_func($data = array()) {
    $group_id = $_POST['group_id'];
    $curr_user = wp_get_current_user();
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sendgrid.com/v3/asm/groups/$group_id/suppressions/" . $curr_user->data->user_email,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS => "null",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . sendgridController::SG_API_KEY,
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    $msg = array();
    if ($err) {
        $msg = array(
            'status' => 'error',
            'message' => "cURL Error #:" . $err,
        );
    } else {
        $msg = array(
            'status' => 'success',
        );
    }

    return json_encode($msg);
}

add_action('wp_ajax_remove_receipient_func', 'remove_receipient_func');
add_action('wp_ajax_nopriv_remove_receipient_func', 'remove_receipient_func');

function subscribe_to_all($data = array()) {
    $group_id = $_POST['group_id'];
    $curr_user = wp_get_current_user();

    /* $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sendgrid.com/v3/asm/suppressions/global/" . $curr_user->data->user_email,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS => "null",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . sendgridController::SG_API_KEY,
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl); */

    $user_groups = sendgridController::get_supression_group();
    $user_groups = json_decode($user_groups['response']);
    $groups = $user_groups->suppressions;

    foreach ($groups as $user_group) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sendgrid.com/v3/asm/groups/{$user_group->id}/suppressions/" . $curr_user->data->user_email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => "null",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . sendgridController::SG_API_KEY,
                "content-type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    }

    $msg = array();
    if ($err) {
        $msg = array(
            'status' => 'error',
            'message' => "cURL Error #:" . $err,
        );
    } else {
        $msg = array(
            'status' => 'success',
        );
    }

    echo json_encode($msg);
    exit(0);
}

add_action('wp_ajax_subscribe_to_all', 'subscribe_to_all');
add_action('wp_ajax_nopriv_subscribe_to_all', 'subscribe_to_all');



function unsubscribe_from_all($data = array()) {
    $group_id = $_POST['group_id'];
    $curr_user = wp_get_current_user();

	
	$user_groups = sendgridController::get_supression_group();
    $user_groups = json_decode($user_groups['response']);
    $groups = $user_groups->suppressions;	

    foreach ($groups as $user_group) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sendgrid.com/v3/asm/groups/{$user_group->id}/suppressions",
			CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_POSTFIELDS => json_encode(array(
				'recipient_emails' => array(
					$curr_user->data->user_email
				)
			)),
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . sendgridController::SG_API_KEY,
                "content-type: application/json"
            ),
        ));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
    }
	
	
	
	

    /* curl_setopt_array($curl, array(
        //CURLOPT_URL => "https://api.sendgrid.com/v3/asm/suppressions/global",
		CURLOPT_URL => "https://api.sendgrid.com/v3/asm/groups/{$group_id}/suppressions" . $curr_user->data->user_email,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode(array(
            'recipient_emails' => array(
                $curr_user->data->user_email
            )
        )),
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . sendgridController::SG_API_KEY,
            "content-type: application/json"
        ),
    )); */

    //$response = curl_exec($curl);
    //$err = curl_error($curl);

    //curl_close($curl);

    $msg = array();
    if ($err) {
        $msg = array(
            'status' => 'error',
            'message' => "cURL Error #:" . $err,
        );
    } else {
        $msg = array(
            'status' => 'success',
        );
    }

    echo json_encode($msg);
    exit(0);
}

add_action('wp_ajax_unsubscribe_from_all', 'unsubscribe_from_all');
add_action('wp_ajax_nopriv_unsubscribe_from_all', 'unsubscribe_from_all');












add_action('wp_ajax_nopriv_save_subscribe_form', 'save_subscribe_form');
add_action('wp_ajax_save_subscribe_form', 'save_subscribe_form');

function save_subscribe_form() {
    global $wpdb;
    $unsubscribe_groups = $_REQUEST['data'];
    $r_data = array();
    $email = $ip_address = '';
    $my_groups = array();

    foreach ($unsubscribe_groups as $group) {
        if ($group['name'] === 'all_groups') {
            $all_groups = unserialize(base64_decode($group['value']));
        } else if ($group['name'] === 'email') {
            $email = $group['value'];
        } else if ($group['name'] === 'ip_address') {
            $ip_address = $group['value'];
        } else {
            $group_data = sendgridController::get_group_data($group['name']);
            $new_group_data = json_decode($group_data);
            $my_groups[$new_group_data->id] = $new_group_data->name;
        }
    }

    $query = "SELECT id FROM {$wpdb->prefix}users WHERE user_email LIKE '$email'";

    $user_table = $wpdb->get_row($query);

    if (!empty($user_table)) {
        $r_data = array(
            'status' => 'registered',
            //'subscribe_url' => site_url('my-account/email-preferences'),
            'subscribe_url' => site_url('sign-in?') . 'redirect_to=' . home_url('my-account/email-preferences'),
        );

        echo json_encode($r_data);
        exit();
    }

    $query = "SELECT id,verified FROM subscriptions WHERE email_id LIKE '$email'";

    $result = $wpdb->get_row($query);

    if (empty($result)) {

        /* START - Insert into a table */
        $length = 50;
        $token = '';
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        $secret_key = 'ur_secret_key';
        $secret_iv = 'ur_secret_iv';

        $output = false;
        $encrypt_method = 'AES-256-CBC';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($email, $encrypt_method, $key, 0, $iv));
        } elseif ($action == 'd') {
            $output = openssl_decrypt(base64_decode($email), $encrypt_method, $key, 0, $iv);
        }

        $table = 'subscriptions';
        $data = array(
            'email_id' => $email,
            'ip_address' => $ip_address,
            'hash' => $token,
            'group_ids' => serialize(array_keys($my_groups)),
            'created_on' => date('Y-m-d H:i:s'),
            'modified_on' => date('Y-m-d H:i:s')
        );
        $wpdb->insert($table, $data);
        $my_id = $wpdb->insert_id;

        /* END - Insert into a table */

//        foreach ($all_groups as $single_grp) {
//            $unsubscribe_from_group = sendgridController::add_user_suppression_group(array(
//                        'group_id' => $single_grp->id,
//                        'email_id' => $email,
//            ));
//        }
////
//        foreach ($my_groups as $key => $single_grp) {
//            $subscribe_to_group = sendgridController::remove_user_suppression_group(array(
//                        'group_id' => $key,
//                        'email_id' => $email,
//            ));
//        }
//
//        $data = array(
//            'list_ids' => array(
//                sendgridController::SG_SUBSCRIPTIONS_LISTID,
//            ),
//            'contacts' => array(array(
//                    "email" => $email,
////                "custom_fields" => array(
//////                    "ip_address" => $ip_address,
////                    'ip_address' => '12346'
////                )
//                )),
//        );
//        $response = sendgridController::add_to_list($data);
//        $output = json_decode($response);

        $r_data = array(
            'message' => 'error',
        );
//        if ($output->job_id) {
        if (!empty($my_id)) {
            $dynamic_template_email_confirmation_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['new_subscriber_email_confirmation'];
            $response = sendgridController::send_dynamic_email($dynamic_template_email_confirmation_id, 0, array(), array(
                        array(
                            'to' => array(
                                array(
                                    'name' => $email,
                                    'email' => $email,
                                )), 'dynamic_template_data' => array(
                                'verification_link' => site_url("subscribe-thank-you?verify_email=true&verification_token=$token&email_id=" . base64_encode($email)),
                                'curr_year' => date('Y'),
                            ))
            ));

            $r_data = array(
                'status' => 'success',
                'message' => 'success',
            );
        }
    } else {
        $r_data = array(
            'status' => 'error',
            'subscribe_url' => site_url('subscribe?email_id=' . base64_encode($email)),
        );
    }

    echo json_encode($r_data);
    exit();
}

add_action('wp_ajax_nopriv_update_subscribe_form', 'update_subscribe_form');
add_action('wp_ajax_update_subscribe_form', 'update_subscribe_form');

function update_subscribe_form() {
    global $wpdb;
    $unsubscribe_groups = $_REQUEST['data'];
    $r_data = array();
    $email = $ip_address = '';
    $my_groups = array();

    foreach ($unsubscribe_groups as $group) {
        if ($group['name'] === 'all_groups') {
            $all_groups = unserialize(base64_decode($group['value']));
        } else if ($group['name'] === 'email') {
            $email = $group['value'];
        } else if ($group['name'] === 'ip_address') {
            $ip_address = $group['value'];
        } else if ($group['name'] === 'subscription_id') {
            $subscription_id = $group['value'];
        } else {
            $group_data = sendgridController::get_group_data($group['name']);
            $new_group_data = json_decode($group_data);
            $my_groups[$new_group_data->id] = $new_group_data->name;
        }
    }

    $table = 'subscriptions';
    $data = array(
        'group_ids' => serialize(array_keys($my_groups)),
        'modified_on' => date('Y-m-d H:i:s')
    );
    $wpdb->update($table, $data, array(
        'id' => $subscription_id
    ));

    /* END - Insert into a table */

    foreach ($all_groups as $single_grp) {
        $unsubscribe_from_group = sendgridController::add_user_suppression_group(array(
                    'group_id' => $single_grp->id,
                    'email_id' => $email,
        ));
    }

    foreach ($my_groups as $key => $single_grp) {
        $subscribe_to_group = sendgridController::remove_user_suppression_group(array(
                    'group_id' => $key,
                    'email_id' => $email,
        ));
    }


    echo json_encode(array(
        'status' => 'success',
    ));
    exit();
}

add_action('wp_ajax_nopriv_subscribe_resend_verification_link', 'subscribe_resend_verification_link');
add_action('wp_ajax_subscribe_resend_verification_link', 'subscribe_resend_verification_link');

function subscribe_resend_verification_link() {
    global $wpdb;
    $ip_address = '';
    $email = '';
    $unsubscribe_groups = $_REQUEST['data'];
    $r_data = array();
    $email = $ip_address = '';
    $my_groups = array();

    foreach ($unsubscribe_groups as $group) {
        if ($group['name'] === 'all_groups') {
            $all_groups = unserialize(base64_decode($group['value']));
        } else if ($group['name'] === 'email') {
            $email = $group['value'];
        } else if ($group['name'] === 'ip_address') {
            $ip_address = $group['value'];
        } else if ($group['name'] === 'subscription_id') {
            $subscription_id = $group['value'];
        } else {
            $group_data = sendgridController::get_group_data($group['name']);
            $new_group_data = json_decode($group_data);
            $my_groups[$new_group_data->id] = $new_group_data->name;
        }
    }

    /* START - Insert into a table */
    $length = 50;
    $token = '';
    $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
    $codeAlphabet .= '0123456789';
    $max = strlen($codeAlphabet);

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max - 1)];
    }

    $secret_key = 'ur_secret_key';
    $secret_iv = 'ur_secret_iv';

    $output = false;
    $encrypt_method = 'AES-256-CBC';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($email, $encrypt_method, $key, 0, $iv));
    } elseif ($action == 'd') {
        $output = openssl_decrypt(base64_decode($email), $encrypt_method, $key, 0, $iv);
    }

    $table = 'subscriptions';
    $data = array(
        'email_id' => $email,
        'ip_address' => $ip_address,
        'hash' => $token,
        'created_on' => date('Y-m-d H:i:s'),
        'modified_on' => date('Y-m-d H:i:s')
    );
    $wpdb->insert($table, $data);
    $my_id = $wpdb->insert_id;

    /* END - Insert into a table */

    $r_data = array(
        'message' => 'error',
    );

    $dynamic_template_email_confirmation_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['new_subscriber_email_confirmation'];

    $response = sendgridController::send_dynamic_email($dynamic_template_email_confirmation_id, 0, array(), array(
                array(
                    'to' => array(
                        array(
                            'name' => $email,
                            'email' => $email,
                        )), 'dynamic_template_data' => array(
                        'verification_link' => site_url("subscribe?verify_email=true&verification_token=$token&email_id=" . base64_encode($email)),
                        'curr_year' => date('Y'),
                    ))
    ));

    $r_data = array(
        'status' => 'success',
        'message' => 'success',
    );

    echo json_encode($r_data);
    exit();
}

/*
add_action('template_redirect', function() {
    if (is_user_logged_in() || !is_page()) {
        return;
    }

    $restricted = array(3520); // all your restricted pages

    if (in_array(get_queried_object_id(), $restricted)) {
        global $wp;
        wp_redirect(site_url('sign-in?') . 'redirect_to=' . home_url($wp->request));
        exit();
    }
});
*/



/*add_action('template_redirect', function() {
    if (is_user_logged_in()) {
        $restricted = array(4578); // all your restricted pages

        if (in_array(get_queried_object_id(), $restricted)) {
            global $wp;
            wp_redirect(site_url('my-account'));
            exit();
        }
    }
});*/

add_action('newsletter_daily', 'newsletter_daily_func');

function newsletter_daily_func() {

    global $wpdb;
    $top_news = '';

    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-30 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 1";

    // $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date < '" . date('Y-m-d') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 1";
    //$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 1";
    $result = $wpdb->get_row($query, OBJECT);

    if (!empty($result)) {
        if ($top_news === '') {
            $top_news = $result->post_title;
        }
        $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style=" margin: 0px 40px;">
                                               
                                                <tr>
                                                    <td style="position: relative;">
                                                        <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                                        <span class="cat_featured"><a href="#" style="color:#fff;font-size: 18px;">Featured</a></span>
                                                    </td>
                                                </tr>';

        $email_content .= '<tr>
                                <td style="padding: 10px 0">
                                    <p><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: bold;font-size: 28px;li" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                    <p style="font-size: 16px;line-height: 19px;">';

        if (!empty($result->post_excerpt)) {
            $paragraph = $result->post_excerpt;
        } else {
            $paragraph = '';
            $str = $result->post_content;
            $str = strip_tags($str);
            $paragraph = substr($str, 0, 300);
            $paragraph = rtrim($paragraph, '.') . '...';
        }
        $para = $paragraph;
        $email_content .= $para . '</p>
                                                    <p><a class="link-btn" style="background-color: #04a353;color: #FFF;font-size: 18px !important;line-height: 35px !important;width: 160px;text-align: center;letter-spacing: 1px !important;height: auto;border-radius: 20px;padding: 5px 0px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                                </td>
                                            </tr>
                                        </table>';
    }
    //Second Row
    //$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d 11:00', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d 10:59') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 4";
    // $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 4";
     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 5, 4";
    $results = $wpdb->get_results($query, OBJECT);

    if (!empty($results)) {
        foreach ($results as $result) {

            $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:90px;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;border-radius: 10px;object-fit: cover;" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:75%">
                                                <p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: bold;font-size: 20px;line-height: 24px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                                <p style="margin-top: 0">';
            if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 100);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
            $email_content .= $para . ' <a style="color:#0D0128;text-decoration:none;font-size:16px;font-weight:500;float:left" href="' . get_the_permalink($result->ID) . '">Read Now <img style="width:20px;float: right;padding-left: 10px;padding-top: 5px;"src="https://techversions.com/assets/Arrow-icon1.png"></a>';
            $email_content .= '</p>
                                                </td>
                                            </tr>
                                        </table>';
        }
    }

    // $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 5, 3";
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 9, 4";
    $results = $wpdb->get_results($query, OBJECT);

    if (!empty($results)) {

        $email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;">
                                <tbody>
                                    <tr>
                                        <td style="width:100%;padding: 0 0 10px 33px;font-weight: bold;font-size: 28px; color: #0D0128;">In case you missed it</td>
                                    </tr>
                                </tbody>
                            </table>';
        foreach ($results as $result) {
            $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                        <tr style="vertical-align: top;">
                                            <td style="width: 10%;padding: 5px 0px 5px 34px;vertical-align: top;">
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="https://techversions.com/assets/increase.png" alt="increase" title="increase" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:90%">
                                                <p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                                <p style="margin-top: 0">';
            if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 100);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            // $para = $paragraph;
            // $email_content .= $para . ' <a style="color:#04a353;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
            $email_content .= '</p>
                                                </td>
                                            </tr>
                                        </table>';
        }
    }

    $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_daily'];
//    echo '<pre>';
//    print_r($email_content);
//    echo '</pre>';
//    echo '<pre>';
//    print_r($dynamic_template_id);
//    echo '</pre>';
//    die();
//    wp_mail('svyas@trueinfluence.com', 'Daily - WP Crontrol', 'Daily - WP Crontrol just ran at ' . date('Y-m-d H:i:s') . '!');
    if (!empty($top_news)) {
        $response = sendgridController::send_newsletter($dynamic_template_id, '15684', array(
                    'email_content' => $email_content,
                    'current_date' => date('l, F j, Y'),
                    'home_url' => home_url(),
                    'top_news' => $top_news,
                    'privacy_policy_url' => site_url('privacy-policy'),
                    'terms_of_service_url' => site_url('terms-of-service'),
                    'contact_us_url' => site_url('contact-us'),
                    'news_url' => site_url('news'),
                    'curr_year' => date('Y'),
                    'manage_your_preferences_link' => site_url('my-account/email-preferences'),
                        ), 'daily');
    }
    exit();
}

add_action('newsletter_weekly', 'newsletter_weekly_func');

function newsletter_weekly_func() {
   

		global $wpdb;
        
		//$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 0, 1";
        
		$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 0, 1";
		
		$result = $wpdb->get_row($query, OBJECT);
        $todays_post = $result;
	
	    if(!empty($result)){
		
		    $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
								<tr>
									<td>
									   <h3 style="margin: 0 0 5px 0;font-size: 20px;">Top Blogs</h3>
									</td>
								</tr>
								<tr>
									<td>
										<a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
									</td>
								</tr>';
			$email_content .= '<tr>
									<td style="padding: 10px 0">
										<p><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;">' . $result->post_title . '</a></strong></p>';

            if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 300);
                $paragraph = rtrim($paragraph, '.') . '...';
		    }
            $para = $paragraph;
            $email_content .= '<p>' . $para . '</p>
                                                <p><a class="link-btn" style="background-color: #04a353;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 20px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                            </td>
                                        </tr>
                                    </table>';
	}

    //Second Row
    //$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-3 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 2";
	
	
	$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 2";
	
    $results = $wpdb->get_results($query, OBJECT);

    if(!empty($results)){
        
        foreach ($results as $result) {
            $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
                                            <tr style="height: 140px; vertical-align: top;">
                                                <td style="width: 40%;padding: 0 20px 0 0;vertical-align: top;">
                                                    <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                                </td>
                                                <td style="padding: 0 0 10px 10px; width:60%">
                                                    <p style="margin: 0 0 5px 0"><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;">' . $result->post_title . '</a></strong></p>
                                                    <p style="margin-top: 0">';
            if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 100);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
            $email_content .= $para . ' <a style="color:#04a353;font-weight:600;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
            $email_content .= '</p>
                                                </td>
                                            </tr>
                                        </table>';
        }
    
        $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center">
                                        <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . site_url('blog') . '">  Click here for more blogs  </a></p></td></tr>
                                    </table>';
    }


    //START -- Resource ROw
    //$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 3";
	
	
	$query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 0, 2";
	
	
    $results = $wpdb->get_results($query, OBJECT);
	
    if(count($results) < 3){
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 2";
        $results = $wpdb->get_results($query, OBJECT);
    }

    if(!empty($results)){
		
		$email_content .= '<table width = 100% border = 0 style = "margin: 30px 0;margin-bottom: 20px;">
						<tbody>
						<tr>
						<td style = "width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Top Resources</td>
						</tr>
						</tbody>
					</table>';
	
		$email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
											<tr style="height: 140px; vertical-align: top;">';
		$i = 0;
		foreach ($results as $result) {
           $email_content .= '<td style="width: 33%;margin-right:10px;padding: 0 10px">'
					. '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
					. '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
					. '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . get_the_permalink($result->ID) . '">Download Now</a></p>'
					. '</td>';
			$i++;
		}
		$email_content .= ' </tr>
						</table>';
										
	}

   
	/*Ends newsletter_weekly_func*/



    $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_weekly'];
//    echo '<pre>';
//    print_r($email_content);
//    echo '</pre>';
//    die();
//    wp_mail('svyas@trueinfluence.com', 'Weekly - WP Crontrol', 'Weekly - WP Crontrol just ran at ' . date('Y-m-d H:i:s') . '!');
    if (!empty($todays_post)) {
        $response = sendgridController::send_newsletter($dynamic_template_id, '15685', array(
                    'email_content' => $email_content,
                    'home_url' => home_url(),
                    'privacy_policy_url' => site_url('privacy-policy'),
                    'terms_of_service_url' => site_url('terms-of-service'),
                    'contact_us_url' => site_url('contact-us'),
                    'blogs_url' => site_url('blogs'),
                    'curr_year' => date('Y'),
                    'manage_your_preferences_link' => site_url('my-account/email-preferences'),
                        ), 'weekly');
    }
    exit();
}

//add_action('newsletter_monthly', 'newsletter_monthly_func');

// function newsletter_monthly_func() {
//     if (date('Y-m-d') !== date('Y-m-t')) {
//         exit(0);
//     }
//     $start_date = date('Y-m-01');

//     global $wpdb;
//         $top_news = '';
   
//         $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-30 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 1";
//         $result = $wpdb->get_row($query, OBJECT);

//         if(!empty($result)){
            
//             if ($top_news === '') {
//                 $top_news = $result->post_title;
//             }
//             $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style=" margin: 0px 40px;">
                                               
//                                                 <tr>
//                                                     <td style="position: relative;">
//                                                         <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                                         <span class="cat_featured"><a href="#" style="color:#fff;font-size: 18px;">Featured</a></span>
//                                                     </td>
//                                                 </tr>';

//             $email_content .= '<tr>
//                                 <td style="padding: 10px 0">
//                                     <p><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: bold;font-size: 28px;li" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
//                                     <p style="font-size: 16px;line-height: 19px;">';

//             if (!empty($result->post_excerpt)) {
//                 $paragraph = $result->post_excerpt;
//             } else {
//                 $paragraph = '';
//                 $str = $result->post_content;
//                 $str = strip_tags($str);
//                 $paragraph = substr($str, 0, 300);
//                 $paragraph = rtrim($paragraph, '.') . '...';
//             }
//             $para = $paragraph;
//             $email_content .= $para . '</p>
//                                                     <p style="text-align:center;"><a class="link-btn" style="background-color: #04a353;color: #FFF;font-size: 18px !important;line-height: 35px !important;width: 160px;text-align: center;letter-spacing: 1px !important;height: auto;border-radius: 20px;padding: 5px 0px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
//                                                 </td>
//                                             </tr>
//                                         </table>';

//         }
        
//         //START -- Resource ROw
//     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 3";
//     $results = $wpdb->get_results($query, OBJECT);
    
//     if(count($results) < 3){
//         $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
//         $results = $wpdb->get_results($query, OBJECT);
//     }

//     if(!empty($results)){
        
//         $email_content .= '<table width = 100% border = 0 style = "background-color:#F2F2F2;margin: 30px 0;margin-bottom: -1px;">
//                         <tbody>
                       
//                         <tr>
//                         <td style = "width:100%;font-weight: bold;font-size: 28px;padding: 30px 25px 25px;color:#12A555;">Top Resources</td>
//                         </tr>
//                         </tbody>
//                     </table>';
    
//         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;background-color:#F2F2F2;">
//                                             <tr style="height: 140px; vertical-align: top;">';
//         $i = 0;
//         foreach ($results as $result) {
//            $email_content .= '<td style="width: 33%;margin-right:10px;padding: 0 20px">'
//                     . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
//                     . '<p style="margin-top: 0px;height:90px;"><strong><a class="text-para" style="text-decoration: none;font-weight: inherit;font-size: inherit;margin-left:0px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
//                     . '<p><a class="link-btn" style="width:150px;text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #12A555;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : flex;" href="' . get_the_permalink($result->ID) . '"> <img src="https://techversions.com/assets/Arrow-Icon-White.png" style="margin-left: -9%;
//     width: 20px;height: 20px;margin-top: 5%;"><span style="margin-left: 7%;color:#FFFFFF;font-size:14px;">Download</span></a></p>'
//                     . '<p style="padding-bottom:20px;"></p>'
//                     . '</td>';
//             $i++;
//         }
//         $email_content .= ' </tr>
//                         </table>';
                                        
//     }

//     //blogs
//     //START -- Resource ROw
//     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 2";
//     $results = $wpdb->get_results($query, OBJECT);
    
//     // if(count($results) < 3){
//     //     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
//     //     $results = $wpdb->get_results($query, OBJECT);
//     // }

//     if(!empty($results)){
        
//         $email_content .= '<table width = 100% border = 0 style = "background-color:#FFFFFF;margin: 30px 0;margin-bottom: -1px;">
//                         <tbody>
//                         <tr>
//                         <td style = "width:100%;padding: 0 0 10px 0;font-weight: bold;font-size: 28px;padding: 20px 25px;text-align: left;font-size: 28px;letter-spacing: 0px;color: #12A555;opacity: 1;">Must Read Blogs</td>
//                         </tr>
//                         </tbody>
//                     </table>';
    
//         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#FFFFFF;">
//                                             <tr style="height: 140px; vertical-align: top;">';
//         $i = 0;
//         foreach ($results as $result) {
//            $email_content .= '<td style="width:50%;margin-right:10px;padding: 0 25px">'
//                     . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
//                     . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: 20px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

//                     if (!empty($result->post_excerpt)) {
//                 $paragraph = $result->post_excerpt;
//             } else {
//                 $paragraph = '';
//                 $str = $result->post_content;
//                 $str = strip_tags($str);
//                 $paragraph = substr($str, 0, 70);
//                 $paragraph = rtrim($paragraph, '.') . '...';
//             }
//             $para = $paragraph;
           
//             $email_content .= $para . '</p>
//                                                     <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
//                                                 </td>';

//             $i++;
//         }
//         $email_content .= ' </tr>
//                         </table>';
                                        
//     }

// //START -- Resource ROw
//     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 2, 2";



//     // SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 2";
//     $results = $wpdb->get_results($query, OBJECT);
    
//     // if(count($results) < 3){
//     //     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
//     //     $results = $wpdb->get_results($query, OBJECT);
//     // }

//     if(!empty($results)){
        
       
    
//         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#FFFFFF;">
//                                             <tr style="height: 140px; vertical-align: top;">';
//         $i = 0;
//         foreach ($results as $result) {
//            $email_content .= '<td style="width:50%;margin-right:10px;padding: 0 25px">'
//                     . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
//                     . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: 20px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

//                     if (!empty($result->post_excerpt)) {
//                 $paragraph = $result->post_excerpt;
//             } else {
//                 $paragraph = '';
//                 $str = $result->post_content;
//                 $str = strip_tags($str);
//                 $paragraph = substr($str, 0, 70);
//                 $paragraph = rtrim($paragraph, '.') . '...';
//             }
//             $para = $paragraph;
           
//             $email_content .= $para . '</p>
//                                                     <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
//                                                 </td>';

//             $i++;
//         }
//         $email_content .= ' </tr>
//                         </table>';
                                        
//     }
        

//         $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 9, 4";
//         $results = $wpdb->get_results($query, OBJECT);
        
//         if(!empty($results)){
//             $email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;background-color:#F2F2F2;">
//                                 <tbody>
//                                     <tr>
//                                         <td style="width:100%;padding: 20px 0 30px 33px;font-weight: bold;font-size: 28px; color: #0D0128;">In case you missed it</td>
//                                     </tr>
//                                 </tbody>
//                             </table>';
        
        
//             foreach ($results as $result) {
//                 $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#F2F2F2;margin-top: -3%;">
//                                         <tr style="vertical-align: top;">
//                                             <td style="width: 10%;padding: 5px 0px 25px 45px;vertical-align: top;">
//                                                 <a href="' . get_the_permalink($result->ID) . '"><img src="https://techversions.com/assets/increase.png" alt="increase" title="increase" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                             </td>
//                                             <td style="padding: 0 0 20px 10px; width:90%">
//                                                 <p style="margin: 0 0 25px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: 400;font-size: 20px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
//                                                 <p style="margin-top: 0">';
//                 if (!empty($result->post_excerpt)) {
//                     $paragraph = $result->post_excerpt;
//                 } else {
//                     $paragraph = '';
//                     $str = $result->post_content;
//                     $str = strip_tags($str);
//                     $paragraph = substr($str, 0, 100);
//                     $paragraph = rtrim($paragraph, '.') . '...';
//                     ;
//                 }
//                 //$para = $paragraph;
//                 //$email_content .=  ' <a style="color:#04a353;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
//                 $email_content .= '</p>
//                                                     </td>
//                                                 </tr>
//                                             </table>';
//             }
//         }

// //     global $wpdb;

// //     //START -- Resources -- Row 1
// //     $query = "SELECT * FROM {$wpdb->prefix}posts as p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY p.`post_date` ASC LIMIT 0, 4";



// //     $results = $wpdb->get_results($query, OBJECT);

// //     if (!empty($results)) {

// //         $email_content .= '<table width=100% border=0 style="margin: 0 0 20px 0;background-color:#ebeeef;border-top: 2px solid #04a353;">
// //                                         <tbody>
// //                                             <tr>
// //                                                 <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Most Downloaded Resources</td>
// //                                             </tr>
// //                                         </tbody>
// //                                     </table>';

// //         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
// //                                             ';
// //         $i = 0;
// //         foreach ($results as $result) {
// //             if ($i == 0 || $i == 2) {
// //                 $padding = 'padding: 0 15px 0 0';
// //                 $email_content .= '<tr style="height: 140px; vertical-align: top;">';
// //             }
// //             if ($i == 1 || $i == 3) {
// //                 $padding = 'padding: 0 0 0 15px';
// //             }

// //             $email_content .= '<td style="width: 50%;margin-right:15px;' . $padding . '">'
// //                     . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;box-shadow: 1px 1px 6px 2px #eee;border:1px solid #eee;" /></a></p>'
// //                     . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
// //                     . '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:5px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
// //                     . '</td>';
// //             if ($i == 1 || $i == 3) {
// //                 $email_content .= '</tr>';
// //             }
// //             $i++;
// //         }
// //         $email_content .= '</table>';
// //     }
// //     //END -- Resource ROw -- Row 1
// //     //START -- ROW 2 -- BLOGS
// //     //
// //     $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 4";
// //     $result1 = $wpdb->get_results($query, OBJECT);

// //     $blogs_available = TRUE;

// //     if (!empty($result1)) {

// //         $email_content .= '<table width=100% border=0 style="margin: 0px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #04a353;">
// //                     <tbody>
// //                         <tr>
// //                             <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Popular Blogs</td>
// //                         </tr>
// //                     </tbody>
// //                 </table>';
// //     } else {
// //         $blogs_available = FALSE;
// //     }

// //     //START -- Blogs - Leadership - Row 2
// //     if (!empty($result1)) {

// //         foreach ($result1 as $single_result) {
// //             $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom:10px;">
// //                                         <tr style="height: 140px; vertical-align: top;">
// //                                             <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">';

// //             $email_content .= '<a href="' . get_the_permalink($single_result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($single_result->ID, 'full')) . '" alt="' . $single_result->post_title . '>" title="' . $single_result->post_title . '" /></a>
// //                                             </td>';

// //             $email_content .= '<td style="padding: 0 0 10px 10px; width:75%">
// //                                                 <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($single_result->ID) . '">' . $single_result->post_title . '</a></strong></p>
// //                                                 <p>';

// //             if (!empty($single_result->post_excerpt)) {
// //                 $paragraph = $single_result->post_excerpt;
// //             } else {
// //                 $paragraph = '';
// //                 $str = $single_result->post_content;
// //                 $str = strip_tags($str);
// //                 $paragraph = substr($str, 0, 200);
// //                 $paragraph = rtrim($paragraph, '.') . '...';
// //             }
// //             $para = $paragraph;
// //             $email_content .= $para . ' <a style="color:#95CA06;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($single_result->ID) . '">Read More</a>';

// //             $email_content .= "</p>
// //                                             </td>
// //                                         </tr>
// //                                     </table>";
// //         }
// //     }

// //     //START -- Blogs - Learning & Development - Row 2
// //     if (!empty($result2)) {
// //         $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0;">
// //                                     <tbody>
// //                                         <tr>
// //                                             <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Learning & Development</td>
// //                                         </tr>
// //                                     </tbody>
// //                                 </table>';

// // //    $i = 0;
// // //    $total_count = count($results);
// // //    $shown_sponsored = 'false';
// //         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
// //                                     <tr style="height: 140px; vertical-align: top;">';

// //         $email_content .= '<td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;"><a href="' . get_the_permalink($result2->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($result2->ID, 'full')) . '" alt="' . $result2->post_title . '>" title="' . $result2->post_title . '" /></a></td>';

// //         $email_content .= '<td style=" width:75%;padding: 0 0 10px 10px">
// //                                             <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result2->ID) . '">' . $result2->post_title . '</a></strong></p>
// //                                             <p>';

// //         if (!empty($result2->post_excerpt)) {
// //             $paragraph = $result2->post_excerpt;
// //         } else {
// //             $paragraph = '';
// //             $str = $result2->post_content;
// //             $str = strip_tags($str);
// //             $paragraph = substr($str, 0, 200);
// //             $paragraph = rtrim($paragraph, '.') . '...';
// //         }
// //         $para = $paragraph;
// //         $email_content .= $para . ' <a style="color:#04a353;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result2->ID) . '">Read More</a>';

// //         $email_content .= "</p>
// //                                         </td>";

// //         $email_content .= "</tr>
// //                                 </table>";
// //     }

// //     //START -- Blogs - HR Tech - Row 2
// //     if (!empty($result3)) {
// //         $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0">
// //                                     <tbody>
// //                                         <tr>
// //                                             <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">HR Tech</td>
// //                                         </tr>
// //                                     </tbody>
// //                                 </table>';


// // //    $i = 0;
// // //    $total_count = count($results);
// // //    $shown_sponsored = 'false';
// //         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
// //                                     <tr style="height: 140px; vertical-align: top;">
// //                                         <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">';

// //         $email_content .= '<a href="' . get_the_permalink($result3->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($result3->ID, 'full')) . '" alt="' . $result3->post_title . '>" title="' . $result3->post_title . '" /></a>
// //                                         </td>';

// //         $email_content .= '<td style="padding: 0 0 10px 10px; width:75%">
// //                                             <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result3->ID) . '">' . $result3->post_title . '</a></strong></p>
// //                                             <p>';

// //         if (!empty($result3->post_excerpt)) {
// //             $paragraph = $result3->post_excerpt;
// //         } else {
// //             $paragraph = '';
// //             $str = $result3->post_content;
// //             $str = strip_tags($str);
// //             $paragraph = substr($str, 0, 200);
// //             $paragraph = rtrim($paragraph, '.') . '...';
// //         }
// //         $para = $paragraph;
// //         $email_content .= $para . ' <a style="color:#04a353;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result3->ID) . '">Read More</a>';

// //         $email_content .= "</p>
// //                                         </td>
// //                                     </tr>
// //                                 </table>";
// //     }

// //     //START -- Blogs - HR Legal - Row 3
// //     if (!empty($result4)) {
// //         $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0;">
// //                                     <tbody>
// //                                         <tr>
// //                                             <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">HR Legal</td>
// //                                         </tr>
// //                                     </tbody>
// //                                 </table>';


// // //    $i = 0;
// // //    $total_count = count($results);
// // //    $shown_sponsored = 'false';
// //         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
// //                                     <tr style="height: 140px; vertical-align: top;">';

// //         $email_content .= '<td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;"><a href="' . get_the_permalink($result4->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($result4->ID, 'full')) . '" alt="' . $result4->post_title . '>" title="' . $result4->post_title . '" /></a></td>';

// //         $email_content .= '<td style=" width:75%;padding: 0 0 10px 10px">
// //                                             <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result4->ID) . '">' . $result4->post_title . '</a></strong></p>
// //                                             <p>';

// //         if (!empty($result4->post_excerpt)) {
// //             $paragraph = $result4->post_excerpt;
// //         } else {
// //             $paragraph = '';
// //             $str = $result4->post_content;
// //             $str = strip_tags($str);
// //             $paragraph = substr($str, 0, 200);
// //             $paragraph = rtrim($paragraph, '.') . '...';
// //         }
// //         $para = $paragraph;
// //         $email_content .= $para . ' <a style="color:#04a353;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result4->ID) . '">Read More</a>';

// //         $email_content .= "</p>
// //                                         </td>";

// //         $email_content .= "</tr>
// //                                 </table>";
// //     }

// //     if ($blogs_available) {
// //         $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;">
// //                                     <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('reading-list') . '"> Read more Blogs </a></p></td></tr>
// //                                 </table>';
// //     }

// //     //END -- ROW 2 -- Blogs
// //     //START -- ROW 3 -- News
// //     $email_content .= '<table width=100% border=0 style="margin: 30px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #04a353;">
// //                                     <tbody>
// //                                         <tr>
// //                                             <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Top News</td>
// //                                         </tr>
// //                                     </tbody>
// //                                 </table>';

// //     $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_date >= '" . $start_date . "' AND post_date <= '" . date('Y-m-t') . "' AND post_type IN ('tech_news') AND post_status = 'publish'  ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 3, 5";
// //     $results = $wpdb->get_results($query);

// //     $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">';

// //     foreach ($results as $result) {
// //         $email_content .= '<tr style="vertical-align: top;"><td style=" width:100%;padding: 0"><p style="margin-top: 0;font-size:20px;color:#04a353"><strong><a class="text-para" style="color: #04a353;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p></td></tr>';
// //     }

// //     $email_content .= '</table>';

// //     $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
// //                                     <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('news') . '">  More News </a></p></td></tr>
// //                                 </table>';

//     //END -- ROW3 -- News

//     $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_monthly'];

//     $response = sendgridController::send_newsletter($dynamic_template_id, '15686', array(
//                 'email_content' => $email_content,
//                 'home_url' => home_url(),
//                 'privacy_policy_url' => site_url('privacy-policy'),
//                 'terms_of_service_url' => site_url('terms-of-service'),
//                 'contact_us_url' => site_url('contact-us'),
//                 'blogs_url' => site_url('blogs'),
//                 'month' => date('F', strtotime('-1 month')) . ', ' . date('Y', strtotime('-1 month')),
//                 'curr_year' => date('Y'),
//                 'manage_your_preferences_link' => site_url('my-account/email-preferences'),
//                     ), 'monthly');

//     exit();
// }

// Activate WordPress Maintenance Mode
function wp_maintenance_mode() {
    if (!current_user_can('edit_themes') || !is_user_logged_in()) {
        wp_die('<h1>Under Maintenance <span style="float:right"><img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837.png" /></span></h1><br />TechVersions is under planned maintenance. Please check back later.');
    }
}

//add_action('get_header', 'wp_maintenance_mode');

//add_filter('jpeg_quality', create_function('', 'return 50;'));

function wpse28145_add_custom_types($query) {
    if (is_tag() && $query->is_main_query()) {

        // this gets all post types:
        $post_types = get_post_types();

        // alternately, you can add just specific post types using this line instead of the above:
        // $post_types = array( 'post', 'your_custom_type' );

        $query->set('post_type', $post_types);
    }
}

add_filter('pre_get_posts', 'wpse28145_add_custom_types');

function news_reader_func() {

    $option_name = 'newsjacking_data';
    $new_cron_arr = array();
    if (get_option($option_name)) {
        $data_arr = unserialize(get_option($option_name));
    } else {
        $data_arr = array();
        $deprecated = ' ';
        $autoload = 'no';
        add_option($option_name, '', $deprecated, $autoload);
    }

    if (date('Y-m-d H:i') >= date('Y-m-d 12:00') && date('Y-m-d H:i') <= date('Y-m-d 12:16')) {
        update_option($option_name, serialize(array()));
        $data_arr = array();
    }

    $email_content = '<style>td img {width:100%;}</style><div style="width: 80%; text-align: center; padding-top: 10px;margin: 0 auto;">
<table class="email-container" style="max-width: 680px; margin: auto;" role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" align="center"><!-- HEADER : BEGIN --></p>
<tbody>
<tr>
<td bgcolor="#ffffff">
<table style="width: 100%;" role="presentation" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding: 30px 40px 30px 40px; text-align: center;"><a href="#"><img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837-1.png" alt="" width="243" height="22" /></a></td>
</tr>
</tbody>
</table>
</td>
</tr><tr><td><table border="1" cellspacing="0" cellpadding="10" style="margin:10px auto 10px auto"><tr><th style="color:#FFF;background-color:#000;">News Title</th></tr>';

    $show_title = true;
    $rss_feed = simplexml_load_file("https://www.techmeme.com/feed.xml");


    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From Tech Meme</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }

                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';
                $new_cron_arr[] = $news;
                $data_arr[$news] = $news;
            }
            $i++;
        }
    }

    /*
     * From LiveMint
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("https://www.livemint.com/rss/technology");

    if (!empty($rss_feed)) {

        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;
            if (!empty($feed_item)) {

                $news = '<span>' . $feed_item->title . '</span>';
                if (!isset($data_arr[$news])) {
                    if ($show_title) {
                        $email_content .= '<tr>'
                                . '<td style="text-align:center;background-color:#ccc;"><b>From LiveMint</b></td>'
                                . '</tr>';
                        $show_title = FALSE;
                    }
                    $data_arr[$news] = $news;
                    $email_content .= '<tr>'
                            . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                            . '<td style="width:40%"></td>'
                            . '</tr>';
                    $new_cron_arr[] = $news;
                }
            }
            $i++;
        }
    }

    /*
     * From theVerge
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("https://www.theverge.com/rss/index.xml");

    if (!empty($rss_feed)) {

        $i = 0;
        foreach ($rss_feed->entry as $feed_item) {
            if ($i >= 10)
                break;

            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From The Verge</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%"></td>'
                        . '</tr>';
                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From Mashable
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("http://feeds.mashable.com/mashable/tech");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From Mashable</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%"></td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }


    /*
     * From Engadget
     * 
     * https://www.engadget.com/rss.xml
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("https://www.engadget.com/rss.xml");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From Engadget</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From CNBC
     * https://www.cnbc.com/id/19854910/device/rss/rss.html
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("https://www.cnbc.com/id/19854910/device/rss/rss.html");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From CNBC</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From CNBC
     * http://feeds.arstechnica.com/arstechnica/technology-lab
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("http://feeds.arstechnica.com/arstechnica/technology-lab");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From Arstechnica</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From CNN.com
     * http://rss.cnn.com/rss/edition_technology.rss
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("http://rss.cnn.com/rss/edition_technology.rss");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From CNN.com</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From Gadgets.NDTV
     * https://gadgets.ndtv.com/rss/news
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("https://gadgets.ndtv.com/rss/news");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From Gadgets.NDTV</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From TechCrunch/startups
     * http://feeds.feedburner.com/TechCrunch/startups
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("http://feeds.feedburner.com/TechCrunch/startups");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From TechCrunch/startups</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From TechCrunch/greentech
     * http://feeds.feedburner.com/TechCrunch/greentech
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("http://feeds.feedburner.com/TechCrunch/greentech");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From TechCrunch/greentech</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From TechCrunch/TechCrunchIT
     * http://feeds.feedburner.com/TechCrunch/TechCrunchIT
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("http://feeds.feedburner.com/TechCrunch/TechCrunchIT");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From TechCrunch/TechCrunchIT</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    /*
     * From CIO.com
     * https://www.cio.com/in/index.rss
     * 
     */
    $show_title = true;
    $rss_feed = simplexml_load_file("https://www.cio.com/in/index.rss");
    if (!empty($rss_feed)) {
        $i = 0;
        foreach ($rss_feed->channel->item as $feed_item) {
            if ($i >= 10)
                break;

            $news = '<span>' . $feed_item->title . '</span>';
            if (!isset($data_arr[$news])) {
                if ($show_title) {
                    $email_content .= '<tr>'
                            . '<td style="text-align:center;background-color:#ccc;"><b>From CIO.com</b></td>'
                            . '</tr>';
                    $show_title = FALSE;
                }
                $data_arr[$news] = $news;
                $email_content .= '<tr>'
                        . '<td style="text-align:left;"><a class="feed_title" href="' . $feed_item->link . '">' . $feed_item->title . '</a></td>'
//                        . '<td style="width:40%">' . implode(' ', array_slice(explode(' ', $feed_item->description), 0, 14)) . '</td>'
                        . '</tr>';

                $new_cron_arr[] = $news;
            }
            $i++;
        }
    }

    if (!empty($new_cron_arr)) {
        update_option($option_name, serialize($data_arr));
        $headers[] = 'From: TechVersions News Reader <info@techversions.com>';
        wp_mail('webservices@trueinfluence.com, tiproduction-content@trueinfluence.com', 'News Flash', $email_content, $headers);
    }
}

add_action('news_reader', 'news_reader_func');

function wpse27856_set_content_type() {
    return "text/html";
}

add_filter('wp_mail_content_type', 'wpse27856_set_content_type');

function register_my_menus() {
    register_nav_menus(
            array(
                'lp-header-menu' => __('LP Header Menu'),
            )
    );
}

add_action('init', 'register_my_menus');

function quadlayers_redirect() {

    if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }
    $currenturl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $currenturl_relative = wp_make_link_relative($currenturl);

    switch ($currenturl_relative) {

        case '/california-consumer-rights-do-not-sell-my-personal-information/':
            $urlto = home_url('/california-do-not-sell-my-personal-information/');
            break;

        default:
            return;
    }

    if ($currenturl != $urlto)
        exit(wp_redirect($urlto));
}

add_action('template_redirect', 'quadlayers_redirect');

function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count . ' Views';
}

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//Newspaper Theme

function hide_menu() {
// Use this for specific user role. Change site_admin part accordingly
    if (current_user_can('editor')) {
        remove_menu_page('themes.php'); // Appearance
        remove_menu_page('options-general.php'); //Settings
        remove_menu_page('edit-comments.php');
        remove_menu_page('edit.php?post_type=cookielawinfo');
        remove_menu_page('profile.php');
        remove_menu_page('tools.php');
        remove_menu_page('edit.php?post_type=tdb_templates');
        remove_menu_page('manage_fm');
        remove_menu_page('wpseo_workouts');
        remove_menu_page('vc-general');
        remove_menu_page('vc-welcome');
        remove_menu_page('essb_options');
        remove_menu_page('pdf-tracker');
    }
}

add_action('admin_head', 'hide_menu');

function login_with_email_address($username) {

    $user = get_user_by_email($username);

    if (!empty($user->user_login))
        $username = $user->user_login;

    return $username;
}

add_action('wp_authenticate', 'login_with_email_address');

/*function check_attempted_login($user, $username, $password) {

    if (get_transient('attempted_login')) {

        $datas = get_transient('attempted_login');




        if ($datas['tried'] >= 3) {

            $until = get_option('_transient_timeout_' . 'attempted_login');

            $time = time_to_go($until);




            return new WP_Error('too_many_tried', sprintf(__('<strong>ERROR</strong>: You have reached authentication limit, you will be able to try again in %1$s.'), $time));
        }
    }




    return $user;
}

add_filter('authenticate', 'check_attempted_login', 30, 3);*/

function login_failed($username) {

    if (get_transient('attempted_login')) {

        $datas = get_transient('attempted_login');

        $datas['tried'] ++;




        if ($datas['tried'] <= 3)
            set_transient('attempted_login', $datas, 300);
    } else {

        $datas = array(
            'tried' => 1
        );

        set_transient('attempted_login', $datas, 300);
    }
}

add_action('wp_login_failed', 'login_failed', 10, 1);

function time_to_go($timestamp) {




    // converting the mysql timestamp to php time 

    $periods = array(
        "second",
        "minute",
        "hour",
        "day",
        "week",
        "month",
        "year"
    );

    $lengths = array(
        "60",
        "60",
        "24",
        "7",
        "4.35",
        "12"
    );

    $current_timestamp = time();

    $difference = abs($current_timestamp - $timestamp);

    for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i ++) {

        $difference /= $lengths[$i];
    }

    $difference = round($difference);

    if (isset($difference)) {

        if ($difference != 1)
            $periods[$i] .= "s";

        $output = "$difference $periods[$i]";

        return $output;
    }
}

/*
  function remove_category( $string, $type )  {
  if ( $type != 'single' && $type == 'category' && ( strpos( $string, 'category' ) !== false ) )  {
  $url_without_category = str_replace( "/category/", "/", $string );
  return trailingslashit( $url_without_category );
  }
  return $string;
  }

  add_filter( 'user_trailingslashit', 'remove_category', 100, 2);

 */

//function initCors($value) {
//
//    header('Access-Control-Allow-Origin: ' . esc_url_raw(site_url()));
//    header('Access-Control-Allow-Methods: GET');
//    header('Access-Control-Allow-Credentials: true');
//    return $value;
//}
//
//add_action('init', function() {
//
//    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
//
//    add_filter('rest_pre_serve_request', initCors);
//}, 15);


//wp_register_script(
//        'my-admin', plugins_url('_scripts/admin.js', dirname(dirname(__FILE__))), array('jquery')
//);
//
//wp_enqueue_style(
//        'my-admin'
//);


add_action('save_post', 'assign_parent_terms', 10, 2);

function assign_parent_terms($post_id, $post){
    // get all assigned terms   
    $cats = get_the_category($post_id);
     
    foreach($cats as $cat){
        while($cat->parent != 0 && !has_term( $cat->parent, 'category', $post )){
            // move upward until we get to 0 level terms
            wp_set_post_terms($post_id, array($cat->parent), 'category', true);
        }
    }
}
/*if ( strlen( $q['s'] ) ) {
    $search = $this->parse_search( $q );
}*/
/**
 * Halt the main query in the case of an empty search 
 */
add_filter( 'posts_search', function( $search, \WP_Query $q )
{
    if( ! is_admin() && empty( $search ) && $q->is_search() && $q->is_main_query() )
        $search .=" AND 0=1 ";

    return $search;
}, 10, 2 );
function remove_post_type_page_from_search() {
    global $wp_post_types;
    $wp_post_types['sdm_downloads']->exclude_from_search = true;
    $wp_post_types['page']->exclude_from_search = true;
    }
    
    add_action('init', 'remove_post_type_page_from_search');



    /* Cron Job */

   // If a cron job interval does not already exist, create one.
/* add_filter( 'cron_schedules', 'check_every_2_hours' );
function check_every_2_hours( $schedules ) {
   $schedules['every_two_hours'] = array(
       //'interval' => 7200,
       'interval' => 60,
       'display'  => __( 'Every 2 hours' ),
   );
   return $schedules;
}
// Unless an event is already scheduled, create one.
add_action( 'wp', 'bbloomer_custom_cron_job' );
function bbloomer_custom_cron_job() {
  if ( ! wp_next_scheduled( 'send_email_two_hours' ) ) {
     wp_schedule_event( time(), 'every_two_hours', 'send_email_two_hours' );
  }
}
// Trigger email when hook runs
add_action( 'send_email_two_hours', 'custom_send_email' );
// Send email
function custom_send_email() {
     $email_subject = "Testing a New cron event";
     $email_content = "This is an automatic WordPress email for testing a cron event.";
     wp_mail( 'test@domain.com', $email_subject, $email_content );
}

*/

/* Sponsored By - Custom Field Code */

// A callback function to add a custom field to our "presenters" taxonomy
function sponsoredby_taxonomy_custom_fields($tag) {
    // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check
    ?>

    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="client_url"><?php _e('Client Privacy Policy URL'); ?></label>
        </th>
        <td>
            <input type="text" name="term_meta[client_url]" id="term_meta[client_url]" value="<?php echo $term_meta['client_url'] ? $term_meta['client_url'] : ''; ?>"><br />

        </td>
    </tr>

    <?php
}

// A callback function to save our extra taxonomy field(s)
function save_taxonomy_custom_fields($term_id) {
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option("taxonomy_term_$t_id", $term_meta);
    }
}

// Add the fields to the "presenters" taxonomy, using our callback function
add_action('sponsored_by_edit_form_fields', 'sponsoredby_taxonomy_custom_fields', 10, 2);

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action('edited_sponsored_by', 'save_taxonomy_custom_fields', 10, 2);

add_shortcode('image_courtesy_shortcode', 'image_courtesy');

function image_courtesy() {

    $post_id = url_to_postid(get_permalink());


    
    //$image_courtesy123 = (get_post_meta($post_id, '_image_courtesy_name', true) != '') ? get_post_meta($post_id, '_image_courtesy_name', true) : 'source';
    //$image_courtesy_url = (get_post_meta($post_id, '_image_courtesy_url', true) != '') ? get_post_meta($post_id, '_image_courtesy_url', true) : home_url();


    $image_courtesy123 = (get_post_meta($post_id, '_image_courtesy_name', true) != '') ? get_post_meta($post_id, '_image_courtesy_name', true) : '';
    $image_courtesy_url = (get_post_meta($post_id, '_image_courtesy_url', true) != '') ? get_post_meta($post_id, '_image_courtesy_url', true) : home_url();

    if(get_post_meta($post_id, '_image_courtesy_name', true)){
    return "Image Courtesy: " . "<a href='$image_courtesy_url' target='_blank'>" . $image_courtesy123 . '</a>';
    }
    else{
        return "";
    }

}




add_shortcode('blog_sponsored_shortcode', 'blog_sponsored');

function blog_sponsored() {

    $post_id = url_to_postid(get_permalink());


    
    //$image_courtesy123 = (get_post_meta($post_id, '_image_courtesy_name', true) != '') ? get_post_meta($post_id, '_image_courtesy_name', true) : 'source';
    //$image_courtesy_url = (get_post_meta($post_id, '_image_courtesy_url', true) != '') ? get_post_meta($post_id, '_image_courtesy_url', true) : home_url();

	
	$blog_sponsored_title = (get_post_meta($post_id, '_blog_sponsored_title', true) != '') ? get_post_meta($post_id, '_blog_sponsored_title', true) : '';
	$blog_sponsored_desc = (get_post_meta($post_id, '_blog_sponsored_desc', true) != '') ? get_post_meta($post_id, '_blog_sponsored_desc', true) : '';


    $blog_sponsored_name = (get_post_meta($post_id, '_blog_sponsored_name', true) != '') ? get_post_meta($post_id, '_blog_sponsored_name', true) : '';
    $blog_sponsored_url = (get_post_meta($post_id, '_blog_sponsored_url', true) != '') ? get_post_meta($post_id, '_blog_sponsored_url', true) : home_url();

   
	if(get_post_meta($post_id, '_blog_sponsored_title', true)){
    return "<h3>" . $blog_sponsored_title . "</h3>" . $blog_sponsored_desc . "<br><br>" . "<b>" . "Sponsored By " . "</b>" . "<a href='$blog_sponsored_url' target='_blank'>" . $blog_sponsored_name . '</a>' . "<br>" . "<a href='$blog_sponsored_url' target='_blank'>"  . "<img src='https://anteriad.com/hubfs/Logos/Anteriad-FC-Pos-RGB.svg' style='width:8%;margin-left:-8px;' /> </a>";
    }
    else{
        return "";
    }
	
	
	//if(get_post_meta($post_id, '_blog_sponsored_name', true)){
    //return "Sponsered By: " . "<a href='$blog_sponsored_url' target='_blank'>" . $blog_sponsored_name . '</a>';
    //}
    //else{
        //return "";
    //}

}



/* Start Server Side Pagination */



/* Start Login History */

add_shortcode('login_history', 'login_history_shortcode');

// Handle AJAX request for login history
function login_history_ajax_handler() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'fa_user_logins';

	// DataTables configuration
	$draw = $_POST['draw']; // Get the draw counter
	$start = $_POST['start']; // Get the starting point
	$length = $_POST['length']; // Get the number of records per page
	$orderBy = $_POST['order'][0]['column']; // Get the column to order by
	$orderDir = $_POST['order'][0]['dir']; // Get the order direction
	$search = $_POST['search']['value']; // Get the search keyword
	// Query to get the total number of records
	$totalQuery = "SELECT COUNT(*) AS total FROM $table_name";

	// Apply search filter if a keyword is provided
	if (!empty($search)) {
		$totalQuery .= " WHERE time_login LIKE '%$search%' OR login_status LIKE '%$search%' OR ip_address LIKE '%$search%'";
	}

	$totalRecords = $wpdb->get_var($totalQuery);

	// Query to fetch the login history records with pagination and search filter
	$loginHistoryQuery = "SELECT time_login,operating_system,ip_address,login_status FROM $table_name";
	//$results = $wpdb->get_results($loginHistoryQuery);
	// Apply search filter if a keyword is provided
	if (!empty($search)) {
		$loginHistoryQuery .= " WHERE time_login LIKE '%$search%' OR login_status LIKE '%$search%' OR ip_address LIKE '%$search%'";
	}

	$loginHistoryQuery .= " ORDER BY id DESC LIMIT $length OFFSET $start";
	$loginHistory = $wpdb->get_results($loginHistoryQuery);


	// Prepare response
	$response = array(
		'draw' => intval($draw),
		'recordsTotal' => intval($totalRecords),
		'recordsFiltered' => intval($totalRecords),
		'data' => $loginHistory
	);

	// Send JSON response
	wp_send_json($response);
}

add_action('wp_ajax_login_history_ajax', 'login_history_ajax_handler');
add_action('wp_ajax_nopriv_login_history_ajax', 'login_history_ajax_handler');

/* End login  History */

/* Start Download History */

add_shortcode('download_history', 'download_history_shortcode');

// Handle AJAX request for login history


	function download_history_ajax_handler() {
        global $wpdb;
    
        $table_name = $wpdb->prefix . 'custom_sdm_downloads';
        //$table_name1 = $wpdb->prefix . 'posts';
        // DataTables configuration
        $draw = $_POST['draw']; // Get the draw counter
        $start = $_POST['start']; // Get the starting point
        $length = $_POST['length']; // Get the number of records per page
        $orderBy = $_POST['order'][0]['column']; // Get the column to order by
        $orderDir = $_POST['order'][0]['dir']; // Get the order direction
        $search = $_POST['search']['value']; // Get the search keyword
        $curr_user = wp_get_current_user();
    
        // Query to get the total number of records
        $totalQuery = "SELECT COUNT(*) AS download_count FROM $table_name WHERE visitor_name = '{$curr_user->user_login}'";
        $totalRecords = $wpdb->get_var($totalQuery);
        //print_r( $totalRecords);
        $downloadsQuery = "SELECT d.id, d.post_title, d.visitor_name, d.visitor_ip,d.date_time,d.visitor_country, t1.name AS category_name, t2.name AS resource_type
        FROM {$wpdb->prefix}custom_sdm_downloads AS d
        INNER JOIN {$wpdb->prefix}posts AS p ON d.post_id = p.ID AND p.post_type = 'sdm_downloads'
        INNER JOIN {$wpdb->prefix}posts AS p2 ON p.post_title = p2.post_title AND p2.post_type = 'resources'
        INNER JOIN {$wpdb->prefix}term_relationships tr on tr.object_id = p2.ID
        INNER JOIN {$wpdb->prefix}terms t1 ON tr.term_taxonomy_id = t1.term_id
        INNER JOIN {$wpdb->prefix}term_taxonomy tax1 ON tax1.term_taxonomy_id = tr.term_taxonomy_id AND tax1.taxonomy = 'category'
        INNER JOIN {$wpdb->prefix}term_relationships tr2 ON tr.object_id = tr2.object_id
        INNER JOIN {$wpdb->prefix}terms t2 ON tr2.term_taxonomy_id = t2.term_id
        INNER JOIN {$wpdb->prefix}term_taxonomy tax2 ON tax2.term_taxonomy_id = tr2.term_taxonomy_id AND tax2.taxonomy = 'resource_types'
        WHERE d.visitor_name = '{$curr_user->user_login}' AND p2.post_status = 'publish'";
    
        $downloadsQuery .= " ORDER BY id DESC LIMIT $length OFFSET $start";
        $downloads = $wpdb->get_results($downloadsQuery);
        // Prepare response
        $response = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords),
            'datetime' => $result,
            'data' => $downloads
        );
    
        // Send JSON response
        wp_send_json($response);
    
    
    print_r($response);
    
    }

add_action('wp_ajax_download_history_ajax', 'download_history_ajax_handler');
add_action('wp_ajax_nopriv_download_history_ajax', 'download_history_ajax_handler'); // For non-logged-in users

/* End Downlaod History */



/* End Server Side Pagination */
add_action('wp_ajax_filterposts', 'ajax_filterposts_handler');
add_action('wp_ajax_nopriv_filterposts', 'ajax_filterposts_handler');

function ajax_filterposts_handler() {
    $category = esc_attr($_POST['category']);
    $resource_type = esc_attr($_POST['resource_type']);
    $date = esc_attr($_POST['date']);
    $current_page = (isset($_POST['page'])) ? $_POST['page'] : 1;
    $ppp = 8;
    $args = array(
        'post_type' => 'resources',
        'post_status' => 'publish',
        'posts_per_page' => $ppp,
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => ($current_page - 1) * $ppp
    );

    if ($category != 'all') {
        $args['cat'] = $category;
    }

    if ($resource_type != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'resource_types',
                'field' => 'slug',
                'terms' => $resource_type,
            )
        );
    }

    if ($date == 'old') {
        $args['order'] = 'ASC';
    } else {
        $args['order'] = 'DESC';
    }
    $posts = 'No posts found.';
    $the_query = new WP_Query($args);

    $total_pages = $the_query->max_num_pages;
    if ($the_query->have_posts()) :
        ob_start();
        while ($the_query->have_posts()) : $the_query->the_post();
            $post_thumbnail_url = '';

            if (get_the_post_thumbnail_url(null, 'medium_large') != false) {
                $post_thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large');
            } else {
                $post_thumbnail_url = get_template_directory_uri() . '/images/no-thumb/medium_large.png';
            }
            ?>
            <div class="td_module_flex td_module_flex_1 td_module_wrap td-animation-stack">
                <div class="td-module-container td-category-pos-above">
                    <div class="td-image-container">
                        <div class="td-module-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap " title="<?php the_title_attribute() ?>"><img src="<?php echo esc_url($post_thumbnail_url) ?>)" class="resource-img-resposnive" /></a></div>
                    </div>

                  
                     <div class="td-module-meta-info">
                        <?php
                                $sponsored_by = get_the_terms($post->ID, 'sponsored_by');
                                foreach ($sponsored_by as $sponsored_by_single) {
                                    ?>
                                    <span class="td-post-author-name"><a href="<?php echo get_term_link($sponsored_by_single->term_id); ?>"><?php echo $sponsored_by_single->name; ?></a> <span></span> </span>
                                <?php } ?> 
                        <?php
                        $categories = get_the_terms($post->ID, 'resource_types');
                        foreach ($categories as $category) {
                            ?>
                            <a href="<?php echo get_term_link($category->term_id); ?>" class="resource-category  td-post-category" style="text-transform: initial !important;"><?php echo $category->name; ?></a>
                        <?php } ?> 

                        <h3 class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h3>
                        <a style="border-color:#fff;"  class="read-more" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo "Download Now";//__herald('read_more'); ?></a>
                        <div class="td-excerpt"><?php the_excerpt(); ?></div>
                        <div class="td-editor-date">

                            <span class="td-author-date">
            <!--                                                                    <span class="td-post-author-name"><a href="<?php // echo esc_url(get_author_posts_url(get_the_author_meta('ID')))            ?>"><?php // the_author()            ?></a> <span>-</span> </span>-->
                                
                                <!--<span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>-->
                               
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        if ($total_pages > 1 && $current_page < $total_pages) {
            ?>
            <div id="resources-ajax-load-more" class="ajax-load-more-container"><span class="resources-load-more" data-total-pages="<?php echo $total_pages; ?>" data-current-page="<?php echo $current_page; ?>"><a>Load more   &nbsp;<i class="td-icon-font td-icon-menu-down"></i></a></span></div>
            <?php
        }
        $posts = ob_get_clean();
    endif;

    $return = array(
        'posts' => $posts,
        'append' => ($current_page > 1) ? 'true' : 'false'
    );

    wp_send_json($return);
    exit(0);
}

/* Create Custom Endpoint */
add_action( 'rest_api_init', 'create_custon_endpoint' );
 
function create_custon_endpoint(){
    register_rest_route(
        'wp/v2',
        '/custom-ep',
        array(
            'methods' => 'GET',
            'callback' => 'get_response',
        )
    );
}
 
function get_response() {
    // your code

    return 'This is your data!';
}

/*add_action( 'rest_api_init', 'create_get_user_count' );
function create_get_user_count(){
    register_rest_route(
        'wp/v2',
        '/get-user-count',
        array(
            'methods' => 'GET',
            'callback' => 'get_user_count',
        )
    );
}

function get_user_count() {
    $result = count_users();
    print_r($result);
    die();
    echo 'There are ', $result['total_users'], ' total users';

    foreach( $result['avail_roles'] as $role => $count )
        echo ', ', $count, ' are ', $role, 's';
    echo '.';
}*/


/*

add_action('admin_init', 'remove_cat_tags');

function remove_cat_tags() {
    global $user_ID;

    if (current_user_can('author') || current_user_can('editor')) {		?>
	
	<style>
	.editor-post-taxonomies__hierarchical-terms-add{
	display:none !important;
	}
	</style>
	
	<?php
       
    }
}

*/

function remove_quick_edit( $actions ) {
    unset($actions['inline hide-if-no-js']);
    return $actions;
}
 
add_filter('page_row_actions','remove_quick_edit',10,1);
add_filter('post_row_actions','remove_quick_edit',10,1);

function insert_smart_tags($args){

    $content = $args['message'];
    $brand_name = get_bloginfo('name');
    $home_url = home_url();
    $facebook_link = esc_attr(get_option('facebook_link'));
    $twitter_link = esc_attr(get_option('twitter_link'));
    $linkedin_link = esc_attr(get_option('linkedin_link'));
    $instagram_link = esc_attr(get_option('instagram_link'));
    $curr_year = date('Y');
   // User information
     $current_user = wp_get_current_user();
    $username = $current_user->user_login;
    $user_email = $current_user->user_email;
    $content    = str_replace( '{{facebook_link}}', $facebook_link, $content );
    $content    = str_replace( '{{twitter_link}}', $twitter_link, $content );
    $content    = str_replace( '{{linkedin_link}}', $linkedin_link, $content );
    $content    = str_replace( '{{instagram_link}}', $instagram_link, $content );
    $content    = str_replace( '{{curr_year}}', $curr_year, $content );
    $content    = str_replace( '{{brand_name}}', $brand_name, $content );
    $content    = str_replace( '{{home_url}}', $home_url, $content );
    $content = str_replace('{{username}}', $username, $content);
    $content = str_replace('{{user_email}}', $user_email, $content);
    $args['message'] = $content;
  
    return $args;
  
    }
    add_filter('wp_mail','insert_smart_tags', 10,1);


/** Remove Canonical URL **/
/*remove_action('embed_head', 'rel_canonical');
add_filter('wpseo_canonical', '__return_false');*/

//add_action('init','get_supression_group');

/*
*
Created on 26-06-2024
Created By Shilpi

Description: To Test Send_Newsletter function
*/
function test_sendgrid_email() {
    $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_daily'];
    print_r($dynamic_template_id);

        $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['daily'], array(
                    'email_content' => 'Test Email',
                    'home_url' => home_url(),
                    'privacy_policy_url' => site_url('privacy-policy'),
                    'terms_of_service_url' => site_url('terms-of-service'),
                    'contact_us_url' => site_url('contact-us'),
                    'blogs_url' => site_url('blogs'),
                    'curr_year' => date('Y'),
                    'manage_your_preferences_link' => site_url('my-account/email-preferences'),
                        ), 'daily','true');
    

    return $response;
}

// Redirect users to the home page after logout
add_action('wp_logout', 'auto_redirect_after_logout');
function auto_redirect_after_logout(){
    wp_safe_redirect( home_url() );
    exit();
}