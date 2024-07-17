<?php
/* 	
 * 	---------------------------------------------------------------------
 * 	Bitz child functions
 * 	--------------------------------------------------------------------- 
 */

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'includes/sendgrid-controller.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'includes/email-preview.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'includes/mp-settings.php';
//require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'includes/newsletter-crons.php';

// Theme setup
add_action('wp_enqueue_scripts', 'bitz_child_enqueue_styles');

function bitz_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');
}

//add_filter('wp_nav_menu_items', 'ur_add_loginout_link', 10, 2); 
//add_filter('wp_nav_menu_items', 'add_login_logout_register_menu', 10, 2);

function add_login_logout_register_menu($items, $args) {

    // if (is_user_logged_in() && $args->theme_location == 'primary') {
    if (is_user_logged_in() && $args->menu->slug == 'top-bar-menu') {

        global $wp;

        $items .= '<ul class="navbar-nav navbar-right myaccount"><li class="menu-item menu-item-type-custom new-class-mobile menu-item-object-custom menu-item-has-children"><a class="myaccount" style="href="' . get_home_url() . '/my-account"><span>MY ACCOUNT</span></a><span></span>
			<ul class="sub-menu">
			<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_home_url() . '/my-account/edit-profile">Profile Details</a></li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_home_url() . '/my-account/edit-password">Change Password</a></li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_home_url() . '/my-account/login-history">Login History</a></li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_home_url() . '/my-account/my-downloads">My Downloads</a></li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_home_url() . '/my-account/email-preferences">Email Preferences</a></li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="' . wp_logout_url(home_url($wp->request)) . "&_wpnonce=" . wp_create_nonce('log-out') . '">' . __("Log Out.") . '</a></li>
			</ul>
			</li></ul>';
    }

    return $items;
}
add_action('wp_logout','auto_redirect_after_logout');

function auto_redirect_after_logout(){
  wp_safe_redirect( home_url() );
  exit;
}
function theme_register_global_styles() {

    wp_enqueue_style('toastr', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
    wp_enqueue_style('jquery-chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css');

    wp_enqueue_style('custom', get_stylesheet_directory_uri() . '/template/css/custom.css');
    wp_enqueue_script('toastr', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js');

    wp_enqueue_script('jquery-cookie', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js');
    wp_enqueue_script('jquery-chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js');

//    wp_enqueue_script('customjs', get_stylesheet_directory_uri() . '/template/js/custom.js');
    wp_enqueue_script('customjs', get_stylesheet_directory_uri() . '/template/js/custom.js', array('jquery'));


    wp_localize_script('customjs', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

    //wp_enqueue_style('toastr', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');

    //wp_enqueue_script('toastr', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js');
}

add_action('wp_enqueue_scripts', 'theme_register_global_styles');

/*

  function ur_add_loginout_link($items, $args) {
  if (is_user_logged_in()) {


  $items .= '<li id="menu-item-147" class="menu-item menu-item-type-custom new-class-mobile menu-item-object-custom menu-item-has-children"><a class="myaccount" style="color:#ffffff" href="' . get_home_url() . '/my-account"><span>My Account</span></a><span></span>
  <ul class="sub-menu" id="mobile-css">
  <li><a href="' . get_home_url() . '/my-account/edit-profile">Profile Details</a></li>
  <li><a href="' . get_home_url() . '/my-account/edit-password">Change Password</a></li>
  <li><a href="' . get_home_url() . '/my-account/login-history">Login History</a></li>
  <li><a href="' . get_home_url() . '/my-account/my-downloads">My Downloads</a></li>
  <li><a href="' . get_home_url() . '/my-account/email-preferences">Email Preferences</a></li>
  <li><a href="' . get_home_url() . '/my-account/user-logout">Log Out</a></li>
  </ul>
  </li>';


  } elseif (!is_user_logged_in()) {

  $items .= '<li class="new-class-mobile-sigin"><a style="color:#ffffff" href="' . get_home_url() . '/sign-in"><span>Log In</span></a></li>';
  $items .= '<li class="new-class-mobile-sub"><a style="color:#ffffff" href="' . get_home_url() . '/subscribe"><span>Subscribe</span></a></li>';
  }
  return $items;
  } */

//add_filter('wp_nav_menu_items', 'ur_add_loginout_link', 10, 2);


/* Custom Code for user registration menu item */


add_filter('wpa_after_login_redirect', 'after_login_redirect', 10, 0);
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
            if ($single_grp->id != 15859) {
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

add_filter('user_registration_account_menu_items', 'ur_custom_menu_items', 10, 1);

function ur_custom_menu_items($items) {
    $items['login-history'] = __('Login History', 'user-registration');
    $items['my-downloads'] = __('My Downloads', 'user-registration');
    $items['email-preferences'] = __('Email Preferences', 'user-registration');
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

function my_account_menu_order() {
    $menuOrder = array(
        'edit-profile' => __('Profile Details', 'user-registration'),
        'edit-password' => __('Change Password', 'user-registration'),
        'login-history' => __('Login History', 'user-registration'),
        'my-downloads' => __('Downloads', 'user-registration'),
        'email-preferences' => __('Email Preferences', 'user-registration'),
        'user-logout' => __('Log Out', 'user-registration'),
            //wp_logout_url()  => __('Logout', 'user-registration'),		
    );
    return $menuOrder;
}

add_filter('user_registration_account_menu_items', 'my_account_menu_order');


/* Start Login History */
/*

  add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items', 10, 1 );
  function ur_custom_menu_items( $items ) {
  $items['login-history'] = __( 'Login History', 'user-registration' );
  return $items;
  }

  add_action( 'init', 'user_registration_add_new_my_account_endpoint' );
  function user_registration_add_new_my_account_endpoint() {
  add_rewrite_endpoint( 'login-history', EP_PAGES );
  }


  function user_registration_new_item_endpoint_content() {
  ur_get_template( 'myaccount/login-history.php');

  }
  add_action( 'user_registration_account_login-history_endpoint', 'user_registration_new_item_endpoint_content' ); */

/* End Login History */

/* Start Downloads */

/*
  add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items_Downloads', 10, 1 );
  function ur_custom_menu_items_Downloads( $items ) {
  $items['Downloads'] = __( 'Downloads', 'user-registration' );
  return $items;
  }

  add_action( 'init', 'user_registration_add_new_my_account_endpoint_Downloads' );
  function user_registration_add_new_my_account_endpoint_Downloads() {
  add_rewrite_endpoint( 'Downloads', EP_PAGES );
  }


  function user_registration_new_item_endpoint_content_Downloads() {
  ur_get_template( 'myaccount/Downloads.php');

  }
  add_action( 'user_registration_account_Downloads_endpoint', 'user_registration_new_item_endpoint_content_Downloads' ); */


/* End Downloads */

/* Start Email Preferences */

/*

  add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items_email', 10, 1 );
  function ur_custom_menu_items_email( $items ) {
  $items['email-preferences'] = __( 'Email Preferences', 'user-registration' );
  return $items;
  }

  add_action( 'init', 'user_registration_add_new_my_account_endpoint_email' );
  function user_registration_add_new_my_account_endpoint_email() {
  add_rewrite_endpoint( 'email-preferences', EP_PAGES );
  }


  function user_registration_new_item_endpoint_content_email() {
  ur_get_template( 'myaccount/email-preferences.php');

  }
  add_action( 'user_registration_account_email-preferences_endpoint', 'user_registration_new_item_endpoint_content_email' ); */



/* End Email Preferences */


/*


  add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items', 2, 1 );

  function ur_custom_menu_items( $items ) { $items['new-item'] = __( 'Test', 'user-registration' ); return $items; }


  add_action( 'init', 'user_registration_add_new_my_account_endpoint' );

  function user_registration_add_new_my_account_endpoint() { add_rewrite_endpoint( 'new-item', EP_PAGES ); }


  function user_registration_new_item_endpoint_content() {  echo "do_shortcode('[user_login_history]')";

  $current_user = wp_get_current_user();

  printf( __( 'Username: %s', 'textdomain' ), esc_html( $current_user->user_login ) ) . '<br />';
  printf( __( 'User email: %s', 'textdomain' ), esc_html( $current_user->user_email ) ) . '<br />';
  printf( __( 'User first name: %s', 'textdomain' ), esc_html( $current_user->user_firstname ) ) . '<br />';
  printf( __( 'User last name: %s', 'textdomain' ), esc_html( $current_user->user_lastname ) ) . '<br />';
  printf( __( 'User display name: %s', 'textdomain' ), esc_html( $current_user->display_name ) ) . '<br />';
  printf( __( 'User ID: %s', 'textdomain' ), esc_html( $current_user->ID ) );



  if ( 0 == $current_user->ID ) {
  echo "Not logged in.";
  } else {

  echo 'user-re';


  }

  } add_action( 'user_registration_account_new-item_endpoint', 'user_registration_new_item_endpoint_content' ); */

/* Download */


/* add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items123', 2, 1 );

  function ur_custom_menu_items123( $items ) { $items['download-test'] = __( 'Download', 'user-registration' ); return $items; }


  add_action( 'init', 'user_registration_add_new_my_account_endpoint123' );

  function user_registration_add_new_my_account_endpoint123() { add_rewrite_endpoint( 'download-test', EP_PAGES ); }


  function user_registration_new_item_endpoint_content123() { echo 'Your new content'; } add_action( 'user_registration_account_new-item_endpoint123', 'user_registration_new_item_endpoint_content123' ); */


/*
  if ( is_user_logged_in() ) {
  echo '<li class="menu-item menu-item-type-taxonomy menu-item-object-category"><a href="'.wp_logout_url( get_permalink() ).'">get out of here (logout)</a></li>';
  } else {
  echo '<li class="menu-item menu-item-type-taxonomy menu-item-object-category"><a href="'.wp_login_url( get_permalink() ).'">get back in here (login)</a></li>';
  } */

/*
  $current_user = wp_get_current_user();


  printf( __( 'Username: %s', 'textdomain' ), esc_html( $current_user->user_login ) ) . '<br />';
  printf( __( 'User email: %s', 'textdomain' ), esc_html( $current_user->user_email ) ) . '<br />';
  printf( __( 'User first name: %s', 'textdomain' ), esc_html( $current_user->user_firstname ) ) . '<br />';
  printf( __( 'User last name: %s', 'textdomain' ), esc_html( $current_user->user_lastname ) ) . '<br />';
  printf( __( 'User display name: %s', 'textdomain' ), esc_html( $current_user->display_name ) ) . '<br />';
  printf( __( 'User ID: %s', 'textdomain' ), esc_html( $current_user->ID ) );

  function wpdocs_check_logged_in() {
  $current_user = wp_get_current_user();
  if ( 0 == $current_user->ID ) {
  echo "Not logged in.";
  } else {
  echo do_shortcode('[user_login_history]');
  }
  }
  add_action( 'init', 'wpdocs_check_logged_in' );


  add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items', 2, 1 );

  function ur_custom_menu_items( $items ) { $items['new-item'] = __( 'Test', 'user-registration' ); return $items; }


  add_action( 'init', 'user_registration_add_new_my_account_endpoint' );

  function user_registration_add_new_my_account_endpoint() { add_rewrite_endpoint( 'new-item', EP_PAGES ); }


  function user_registration_new_item_endpoint_content() {  echo "do_shortcode('[user_login_history]')";

  $current_user = wp_get_current_user();

  printf( __( 'Username: %s', 'textdomain' ), esc_html( $current_user->user_login ) ) . '<br />';
  printf( __( 'User email: %s', 'textdomain' ), esc_html( $current_user->user_email ) ) . '<br />';
  printf( __( 'User first name: %s', 'textdomain' ), esc_html( $current_user->user_firstname ) ) . '<br />';
  printf( __( 'User last name: %s', 'textdomain' ), esc_html( $current_user->user_lastname ) ) . '<br />';
  printf( __( 'User display name: %s', 'textdomain' ), esc_html( $current_user->display_name ) ) . '<br />';
  printf( __( 'User ID: %s', 'textdomain' ), esc_html( $current_user->ID ) );



  if ( 0 == $current_user->ID ) {
  echo "Not logged in.";
  } else {

  echo 'user-re';


  }

  } add_action( 'user_registration_account_new-item_endpoint', 'user_registration_new_item_endpoint_content' ); */

/* Download */

/*
  add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items123', 2, 1 );

  function ur_custom_menu_items123( $items ) { $items['download-test'] = __( 'Download', 'user-registration' ); return $items; }


  add_action( 'init', 'user_registration_add_new_my_account_endpoint123' );

  function user_registration_add_new_my_account_endpoint123() { add_rewrite_endpoint( 'download-test', EP_PAGES ); }


  function user_registration_new_item_endpoint_content123() { echo 'Your new content'; } add_action( 'user_registration_account_new-item_endpoint123', 'user_registration_new_item_endpoint_content123' ); /



  /* New Code */

add_action('sdm_process_download_request', 'custom_download', 10, 2);

function custom_download($download_id, $download_link) {
    // global $wpdb;
    // $download = $wpdb->get_row("SELECT * FROM wp_o0gCImmh0o00eqjs_sdm_downloads WHERE post_id = {$download_id} ORDER BY id DESC;");

    // $pdf_tracker = (isset($_GET['pdftracking']) && $_GET['pdftracking'] === 'true') ? 'true' : 'false';
    // $thankyou_redirect_url = (isset($_GET['thankyou_redirect_url']) && !empty($_GET['thankyou_redirect_url'])) ? $_GET['thankyou_redirect_url'] : 'false';
    // $thankyoupage_asset = (isset($_GET['thankyoupage_asset']) && !empty($_GET['thankyoupage_asset'])) ? $_GET['thankyoupage_asset'] : 'false';
    // if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
    //     $_SESSION['form_submission'] = 'true';
    // }

    // if ($pdf_tracker === 'true') {
    //     $url = site_url('thank-you-pdf?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])));
    // } else if ($thankyou_redirect_url !== 'false') {
    //     $url = site_url('thank-you-redirect?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])) . '&r_url=' . urlencode(base64_encode($_GET['thankyou_redirect_url'])));
    // } else if ($thankyoupage_asset !== 'false') {
    //     $url = site_url('thank-you-page-asset?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])) . '&r_url=' . urlencode(base64_encode($_GET['thankyou_redirect_url'])) . '&thankyoupage_asset=' . urlencode(base64_encode($thankyoupage_asset)));
    // } else {
    //     $url = site_url('thank-you?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])));
    // }

    // wp_redirect($url);
    // exit;

    global $wpdb;
    $download = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}custom_sdm_downloads WHERE post_id = {$download_id} ORDER BY id DESC;");

    $pdf_tracker = (isset($_GET['pdftracking']) && $_GET['pdftracking'] === 'true') ? 'true' : 'false';
    $thankyou_redirect_url = (isset($_GET['thankyou_redirect_url']) && !empty($_GET['thankyou_redirect_url'])) ? $_GET['thankyou_redirect_url'] : 'false';
    $thankyoupage_asset = (isset($_GET['thankyoupage_asset']) && !empty($_GET['thankyoupage_asset'])) ? $_GET['thankyoupage_asset'] : 'false';
    if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
        $_SESSION['form_submission'] = 'true';
    }

    if ($pdf_tracker === 'true') {
        wp_redirect(site_url('thank-you-pdf?success=true&r_id=' . urlencode(base64_encode($_GET['r_id']))));
    } else if ($thankyoupage_asset !== 'false') {
        $url = site_url('thank-you-page-resource?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])) . '&r_url=' . urlencode(base64_encode($_GET['thankyou_redirect_url'])) . '&thankyoupage_asset=' . urlencode(base64_encode($thankyoupage_asset)));
        wp_redirect($url);
    } else {
        $redirect_url = '';
        if (isset($_GET['thankyoupage_redirecturl']) && !empty($_GET['thankyoupage_redirecturl'])) {
            $redirect_url = $_GET['thankyoupage_redirecturl'];
        }

        if (!empty($redirect_url)) {
            wp_redirect(site_url('thank-you-page-resource?success=true&r_id=' . urlencode(base64_encode($_GET['r_id'])) . '&redirect_url=' . urlencode(base64_encode($redirect_url))));
        } else {
            wp_redirect(site_url('thank-you-page-resource?success=true&r_id=' . urlencode(base64_encode($_GET['r_id']))));
        }
    }
    wp_redirect($url);
    exit;
}

add_action('wp_ajax_nopriv_save_in_user_meta', 'save_in_user_meta');
add_action('wp_ajax_save_in_user_meta', 'save_in_user_meta');

function save_in_user_meta() {
    global $wpdb;
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $last_updated_row = $wpdb->get_row("SELECT * FROM visitor_pdfviews WHERE user_ip_address = '$ip' AND resource_id = '{$_GET['resource_id']}' ORDER BY id DESC ");
    if (!isset($last_updated_row->id) || $last_updated_row->id == '') {
        $wpdb->insert('visitor_pdfviews', array(
            'ip_address' => $ip,
            'file_id' => 0,
            'file_url' => $_GET['file_url'],
            'read_pages' => $_GET['read_pages'],
            'total_pages' => $_GET['total_pages'],
            'resource_id' => $_GET['resource_id'],
        ));
    } else {
        $wpdb->update('visitor_pdfviews', array(
            'ip_address' => $ip,
            'file_url' => $_GET['file_url'],
            'read_pages' => $_GET['read_pages'],
            'total_pages' => $_GET['total_pages'],
            'created_on' => date('Y-m-d H:i:s'),
                ), array(
            'id' => $last_updated_row->id
        ));
    }

    exit();
}

/* New Code */


//Hide admin topbar only for subscribers
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !current_user_can('editor') && !current_user_can('author') && !is_admin()) {
        show_admin_bar(false);
    }
}

//New Code Resource Page 


/* START -- Post and CPT other details */

function post_data_meta_box() {
    add_meta_box('global-notice', __('Other Post Details', 'other_posts_details'), 'post_data_meta_box_callback', array('post', 'resources', 'news'), 'side');
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
    $read_time_post = get_post_meta($post->ID, '_read_time', true);
    $image_courtesy_name_post = get_post_meta($post->ID, '_image_courtesy_name', true);
    $image_courtesy_url_post = get_post_meta($post->ID, '_image_courtesy_url', true);


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
        <h3><?php _e('Read Time', 'read_time_text'); ?></h3>
        <p>
            <input type="text" name="read_time" id="read_time" value="<?php echo $read_time_post; ?>" /> 
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

    <?php
}

/*

  add_filter('wpa_after_login_redirect', 'after_login_redirect', 10, 0);
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
  } */

//START -- Logout Redirection
//function wpse_44020_logout_redirect( $logouturl, $redir )
//{
//    return $logouturl . '&amp;redirect_to=' . get_permalink();
//}
//add_filter( 'logout_url', 'wpse_44020_logout_redirect', 10, 2 );
//END -- Logout Redirection

function save_meta_boxes_data($post_id) {
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

    // OK, it's safe for us to save the data now.
    // Sanitize user input.
    $premium_regular = sanitize_text_field($_POST['premium_regular']);
    $author_name = sanitize_text_field($_POST['author_name']);
    $sponsored_by = sanitize_text_field($_POST['sponsored_by']);
    $source_name = sanitize_text_field($_POST['source_name']);
    $source_url = sanitize_text_field($_POST['source_url']);
    $read_time = sanitize_text_field($_POST['read_time']);
    $image_courtesy_name = sanitize_text_field($_POST['image_courtesy_name']);
    $image_courtesy_url = sanitize_text_field($_POST['image_courtesy_url']);


    // Update the meta field in the database.
    update_post_meta($post_id, '_premium_regular', $premium_regular);
    update_post_meta($post_id, '_author_name', $author_name);
    update_post_meta($post_id, '_sponsored_by', $sponsored_by);
    update_post_meta($post_id, '_source_name', $source_name);
    update_post_meta($post_id, '_source_url', $source_url);
    update_post_meta($post_id, '_read_time', $read_time);
    update_post_meta($post_id, '_image_courtesy_name', $image_courtesy_name);
    update_post_meta($post_id, '_image_courtesy_url', $image_courtesy_url);
}

add_action('save_post', 'save_meta_boxes_data', 10, 1);
/* END -- Post and CPT other details */

//function add_manage_cat_to_author_role() 
//{
//    if ( ! current_user_can( 'author' ) )
//        return;
//
//    // here you should check if the role already has_cap already and if so, abort/return;
//
//    if ( current_user_can( 'author' ) ) 
//    {
//        $GLOBALS['wp_roles']->add_cap( 'author','manage_categories' );
//    }
//}
//add_action( 'admin_init', 'add_manage_cat_to_author_role', 10, 0 );

function remove_manage_categories() {
	if(current_user_can( 'administrator' )){
		return;
	}
	$roles = wp_roles();
	foreach( $roles->role_names as $slug => $name ) {
		if( $slug != 'administrator' ){
			$role = get_role( $slug );
			$role->add_cap( 'manage_categories', false );
		}
	}
}
// add_action( 'admin_init', 'remove_manage_categories', 10, 0 );
/* START -- Custom Taxonomy - GEO LOCATION */

function themename_geo_taxonomies() {
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
    );
    register_taxonomy('geo-location', array('post'), $args);
}

add_action('init', 'themename_geo_taxonomies', 0);
/* END -- Custom Taxonomy - GEO LOCATION */

/* START -- Custom Post Types */

function cptui_register_my_cpts() {

    /**
     * Post Type: Events.
     */
    $labels = [
        "name" => __("Resources", "bitz"),
        "singular_name" => __("Resource", "bitz"),
        "menu_name" => __("My Resources", "bitz"),
        "all_items" => __("All Resources", "bitz"),
        "add_new" => __("Add new", "bitz"),
        "add_new_item" => __("Add new Resource", "bitz"),
        "edit_item" => __("Edit Resource", "bitz"),
        "new_item" => __("New Resource", "bitz"),
        "view_item" => __("View Resource", "bitz"),
        "view_items" => __("View Resources", "bitz"),
        "search_items" => __("Search Resources", "bitz"),
        "not_found" => __("No Resources found", "bitz"),
        "not_found_in_trash" => __("No Resources found in trash", "bitz"),
        "parent" => __("Parent Resource:", "bitz"),
        "featured_image" => __("Featured image for this Resource", "bitz"),
        "set_featured_image" => __("Set featured image for this Resource", "bitz"),
        "remove_featured_image" => __("Remove featured image for this Resource", "bitz"),
        "use_featured_image" => __("Use as featured image for this Resource", "bitz"),
        "archives" => __("Resources", "bitz"),
        "insert_into_item" => __("Insert into Resource", "bitz"),
        "uploaded_to_this_item" => __("Upload to this Resource", "bitz"),
        "filter_items_list" => __("Filter Resources list", "bitz"),
        "items_list_navigation" => __("Resources list navigation", "bitz"),
        "items_list" => __("Resources list", "bitz"),
        "attributes" => __("Resources attributes", "bitz"),
        "name_admin_bar" => __("Resource", "bitz"),
        "item_published" => __("Resource published", "bitz"),
        "item_published_privately" => __("Resource published privately.", "bitz"),
        "item_reverted_to_draft" => __("Resource reverted to draft.", "bitz"),
        "item_scheduled" => __("Resource scheduled", "bitz"),
        "item_updated" => __("Resource updated.", "bitz"),
        "parent_item_colon" => __("Parent Resource:", "bitz"),
    ];

    $args = [
        "label" => __("Resources", "bitz"),
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

    // Post Type: Audios
    $labels = [
        "name" => __("Audios", "bitz"),
        "singular_name" => __("Audios", "bitz"),
        "menu_name" => __("Audios", "bitz"),
        "all_items" => __("All Audios", "bitz"),
        "add_new" => __("Add Audios", "bitz"),
        "add_new_item" => __("Add new Audios", "bitz"),
        "edit_item" => __("Edit Audios", "bitz"),
        "new_item" => __("New Audios", "bitz"),
        "view_item" => __("View Audios", "bitz"),
        "view_items" => __("View Audios", "bitz"),
        "search_items" => __("Search Audios", "bitz"),
        "not_found" => __("No Audios found", "bitz"),
        "not_found_in_trash" => __("No Audios found in trash", "bitz"),
        "parent" => __("Parent Audios:", "bitz"),
        "featured_image" => __("Featured image for this Audios", "bitz"),
        "set_featured_image" => __("Set featured image for this Audios", "bitz"),
        "remove_featured_image" => __("Remove featured image for this Audios", "bitz"),
        "use_featured_image" => __("Use as featured image for this Audios", "bitz"),
        "archives" => __("Audios archives", "bitz"),
        "insert_into_item" => __("Insert into Audios", "bitz"),
        "uploaded_to_this_item" => __("Upload to this Audios", "bitz"),
        "filter_items_list" => __("Filter Audios list", "bitz"),
        "items_list_navigation" => __("Audios list navigation", "bitz"),
        "items_list" => __("Audios list", "bitz"),
        "attributes" => __("Audios attributes", "bitz"),
        "name_admin_bar" => __("Audios", "bitz"),
        "item_published" => __("Audios published", "bitz"),
        "item_published_privately" => __("Audios published privately.", "bitz"),
        "item_reverted_to_draft" => __("Audios reverted to draft.", "bitz"),
        "item_scheduled" => __("Audios scheduled", "bitz"),
        "item_updated" => __("Audios updated.", "bitz"),
        "parent_item_colon" => __("Parent Audios:", "bitz"),
    ];

    $args = [
        "label" => __("Audios", "bitz"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => TRUE,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "audios", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "author"],
        //"taxonomies" => ["post_tag", "geo-location", "new_categories", "category", "sponsored_by"],
        "taxonomies" => ["post_tag", "geo-location", "resource_types", "category", "sponsored_by"],
    ];

    register_post_type("audios", $args);


    /** 	
      Post Type: Videos
     */
    $labels = [
        "name" => __("Videos", "bitz"),
        "singular_name" => __("Videos", "bitz"),
        "menu_name" => __("Videos", "bitz"),
        "all_items" => __("All Videos", "bitz"),
        "add_new" => __("Add Videos", "bitz"),
        "add_new_item" => __("Add new Videos", "bitz"),
        "edit_item" => __("Edit Videos", "bitz"),
        "new_item" => __("New Videos", "bitz"),
        "view_item" => __("View Videos", "bitz"),
        "view_items" => __("View Videos", "bitz"),
        "search_items" => __("Search Videos", "bitz"),
        "not_found" => __("No Videos found", "bitz"),
        "not_found_in_trash" => __("No Videos found in trash", "bitz"),
        "parent" => __("Parent Videos:", "bitz"),
        "featured_image" => __("Featured image for this Videos", "bitz"),
        "set_featured_image" => __("Set featured image for this Videos", "bitz"),
        "remove_featured_image" => __("Remove featured image for this Videos", "bitz"),
        "use_featured_image" => __("Use as featured image for this Videos", "bitz"),
        "archives" => __("Videos archives", "bitz"),
        "insert_into_item" => __("Insert into Videos", "bitz"),
        "uploaded_to_this_item" => __("Upload to this Videos", "bitz"),
        "filter_items_list" => __("Filter Videos list", "bitz"),
        "items_list_navigation" => __("Videos list navigation", "bitz"),
        "items_list" => __("Videos list", "bitz"),
        "attributes" => __("Videos attributes", "bitz"),
        "name_admin_bar" => __("Videos", "bitz"),
        "item_published" => __("Videos published", "bitz"),
        "item_published_privately" => __("Videos published privately.", "bitz"),
        "item_reverted_to_draft" => __("Videos reverted to draft.", "bitz"),
        "item_scheduled" => __("Videos scheduled", "bitz"),
        "item_updated" => __("Videos updated.", "bitz"),
        "parent_item_colon" => __("Parent Videos:", "bitz"),
    ];

    $args = [
        "label" => __("Videos", "bitz"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => TRUE,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "videos", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "author", "post-formats"],
        //"taxonomies" => ["post_tag", "geo-location", "new_categories", "category", "sponsored_by"],
        "taxonomies" => ["post_tag", "geo-location", "resource_types", "category", "sponsored_by"],
    ];

    register_post_type("videos", $args);

    /**
     * Post Type: Events
     */
    $labels = [
        "name" => __("Events", "bitz"),
        "singular_name" => __("Event", "bitz"),
        "menu_name" => __("My Events", "bitz"),
        "all_items" => __("All Events", "bitz"),
        "add_new" => __("Add new", "bitz"),
        "add_new_item" => __("Add new Event", "bitz"),
        "edit_item" => __("Edit Event", "bitz"),
        "new_item" => __("New Event", "bitz"),
        "view_item" => __("View Event", "bitz"),
        "view_items" => __("View Events", "bitz"),
        "search_items" => __("Search Events", "bitz"),
        "not_found" => __("No Events found", "bitz"),
        "not_found_in_trash" => __("No Events found in trash", "bitz"),
        "parent" => __("Parent Event:", "bitz"),
        "featured_image" => __("Featured image for this Event", "bitz"),
        "set_featured_image" => __("Set featured image for this Event", "bitz"),
        "remove_featured_image" => __("Remove featured image for this Event", "bitz"),
        "use_featured_image" => __("Use as featured image for this Event", "bitz"),
        "archives" => __("Event archives", "bitz"),
        "insert_into_item" => __("Insert into Event", "bitz"),
        "uploaded_to_this_item" => __("Upload to this Event", "bitz"),
        "filter_items_list" => __("Filter Events list", "bitz"),
        "items_list_navigation" => __("Events list navigation", "bitz"),
        "items_list" => __("Events list", "bitz"),
        "attributes" => __("Events attributes", "bitz"),
        "name_admin_bar" => __("Event", "bitz"),
        "item_published" => __("Event published", "bitz"),
        "item_published_privately" => __("Event published privately.", "bitz"),
        "item_reverted_to_draft" => __("Event reverted to draft.", "bitz"),
        "item_scheduled" => __("Event scheduled", "bitz"),
        "item_updated" => __("Event updated.", "bitz"),
        "parent_item_colon" => __("Parent Event:", "bitz"),
    ];

    $args = [
        "label" => __("Events", "bitz"),
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
        "rewrite" => ["slug" => "events", "with_front" => true],
        "query_var" => true,
        "supports" => ["title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes", "post-attributes", "author"],
        "taxonomies" => ["post_tag", "geo-location", "event_types", "category", "sponsored_by"],
    ];

    register_post_type("events", $args);
}

add_action('init', 'cptui_register_my_cpts');
/* END - Custom Post Types */

/* START -- Custom Taxonomies */

function cptui_register_my_taxes() {
    // Taxonomy: Resource Categories.
//    $labels = [
//        "name" => __("Resource Categories", "bitz"),
//        "singular_name" => __("Resource Category", "bitz"),
//        "menu_name" => __("Resource Categories", "bitz"),
//        "all_items" => __("All Resource Categories", "bitz"),
//        "edit_item" => __("Edit Resource Category", "bitz"),
//        "view_item" => __("View Resource Category", "bitz"),
//        "update_item" => __("Update Resource Category name", "bitz"),
//        "add_new_item" => __("Add new Resource Category", "bitz"),
//        "new_item_name" => __("New Resource Category name", "bitz"),
//        "parent_item" => __("Parent Resource Category", "bitz"),
//        "parent_item_colon" => __("Parent Resource Category:", "bitz"),
//        "search_items" => __("Search Resource Categories", "bitz"),
//        "popular_items" => __("Popular Resource Categories", "bitz"),
//        "separate_items_with_commas" => __("Separate Resource Categories with commas", "bitz"),
//        "add_or_remove_items" => __("Add or remove Resource Categories", "bitz"),
//        "choose_from_most_used" => __("Choose from the most used Resource Categories", "bitz"),
//        "not_found" => __("No Resource Categories found", "bitz"),
//        "no_terms" => __("No Resource Categories", "bitz"),
//        "items_list_navigation" => __("Resource Categories list navigation", "bitz"),
//        "items_list" => __("Resource Categories list", "bitz"),
//    ];
//
//    $args = [
//        "label" => __("Resource Categories", "bitz"),
//        "labels" => $labels,
//        "public" => true,
//        "publicly_queryable" => true,
//        "hierarchical" => true,
//        "show_ui" => true,
//        "show_in_menu" => true,
//        "show_in_nav_menus" => true,
//        "query_var" => true,
//        "rewrite" => ['slug' => 'resource_categories', 'with_front' => true, 'hierarchical' => true,],
//        "show_admin_column" => false,
//        "show_in_rest" => true,
//        "rest_base" => "resource_categories",
//        "rest_controller_class" => "WP_REST_Terms_Controller",
//        "show_in_quick_edit" => false,
//    ];
//    register_taxonomy("resource_categories", ["resources"], $args);
    // Taxonomy: Resource Types.
    $labels = [
        "name" => __("Resource Types", "bitz"),
        "singular_name" => __("Resource Type", "bitz"),
        "menu_name" => __("Resource Types", "bitz"),
        "all_items" => __("All Resource Types", "bitz"),
        "edit_item" => __("Edit Resource Type", "bitz"),
        "view_item" => __("View Resource Type", "bitz"),
        "update_item" => __("Update Resource Type name", "bitz"),
        "add_new_item" => __("Add new Resource Type", "bitz"),
        "new_item_name" => __("New Resource Type name", "bitz"),
        "parent_item" => __("Parent Resource Type", "bitz"),
        "parent_item_colon" => __("Parent Type Category:", "bitz"),
        "search_items" => __("Search Resource Types", "bitz"),
        "popular_items" => __("Popular Resource Types", "bitz"),
        "separate_items_with_commas" => __("Separate Resource Types with commas", "bitz"),
        "add_or_remove_items" => __("Add or remove Resource Types", "bitz"),
        "choose_from_most_used" => __("Choose from the most used Resource Types", "bitz"),
        "not_found" => __("No Resource Types found", "bitz"),
        "no_terms" => __("No Resource Types", "bitz"),
        "items_list_navigation" => __("Resource Types list navigation", "bitz"),
        "items_list" => __("Resource Types list", "bitz"),
    ];

    $args = [
        "label" => __("Resource Types", "bitz"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'resource', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "resource_types",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("resource_types", ["resources"], $args);

    /* Audios */

    $labels = [
        "name" => __("Audios Types", "bitz"),
        "singular_name" => __("Audios Type", "bitz"),
        "menu_name" => __("Audios Types", "bitz"),
        "all_items" => __("All Audios Types", "bitz"),
        "edit_item" => __("Edit Audios Type", "bitz"),
        "view_item" => __("View Audios Type", "bitz"),
        "update_item" => __("Update Audios Type name", "bitz"),
        "add_new_item" => __("Add new Audios Type", "bitz"),
        "new_item_name" => __("New Audios Type name", "bitz"),
        "parent_item" => __("Parent Audios Type", "bitz"),
        "parent_item_colon" => __("Parent Type Category:", "bitz"),
        "search_items" => __("Search Audios Types", "bitz"),
        "popular_items" => __("Popular Audios Types", "bitz"),
        "separate_items_with_commas" => __("Separate Audios Types with commas", "bitz"),
        "add_or_remove_items" => __("Add or remove Audios Types", "bitz"),
        "choose_from_most_used" => __("Choose from the most used Audios Types", "bitz"),
        "not_found" => __("No Audios Types found", "bitz"),
        "no_terms" => __("No Audios Types", "bitz"),
        "items_list_navigation" => __("Audios Types list navigation", "bitz"),
        "items_list" => __("Audios Types list", "bitz"),
    ];

    $args = [
        "label" => __("Audios Types", "bitz"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'audios_types', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "audios_types",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("audios_types", ["audios"], $args);


    /* Audios */


    /* Videos */

    $labels = [
        "name" => __("Videos Types", "bitz"),
        "singular_name" => __("Videos Type", "bitz"),
        "menu_name" => __("Videos Types", "bitz"),
        "all_items" => __("All Videos Types", "bitz"),
        "edit_item" => __("Edit Videos Type", "bitz"),
        "view_item" => __("View Videos Type", "bitz"),
        "update_item" => __("Update Videos Type name", "bitz"),
        "add_new_item" => __("Add new Videos Type", "bitz"),
        "new_item_name" => __("New Videos Type name", "bitz"),
        "parent_item" => __("Parent Videos Type", "bitz"),
        "parent_item_colon" => __("Parent Type Category:", "bitz"),
        "search_items" => __("Search Videos Types", "bitz"),
        "popular_items" => __("Popular Videos Types", "bitz"),
        "separate_items_with_commas" => __("Separate Videos Types with commas", "bitz"),
        "add_or_remove_items" => __("Add or remove Videos Types", "bitz"),
        "choose_from_most_used" => __("Choose from the most used Videos Types", "bitz"),
        "not_found" => __("No Videos Types found", "bitz"),
        "no_terms" => __("No Videos Types", "bitz"),
        "items_list_navigation" => __("Videos Types list navigation", "bitz"),
        "items_list" => __("Videos Types list", "bitz"),
    ];

    $args = [
        "label" => __("Videos Types", "bitz"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'videos_types', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "videos_types",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("videos_types", ["videos"], $args);


    /* Videos */


    // Post Type: News
    $labels = [
        "name" => __("News", "bitz"),
        "singular_name" => __("News", "bitz"),
        "menu_name" => __("News", "bitz"),
        "all_items" => __("All News", "bitz"),
        "add_new" => __("Add news", "bitz"),
        "add_new_item" => __("Add new News", "bitz"),
        "edit_item" => __("Edit News", "bitz"),
        "new_item" => __("New News", "bitz"),
        "view_item" => __("View News", "bitz"),
        "view_items" => __("View News", "bitz"),
        "search_items" => __("Search News", "bitz"),
        "not_found" => __("No News found", "bitz"),
        "not_found_in_trash" => __("No News found in trash", "bitz"),
        "parent" => __("Parent News:", "bitz"),
        "featured_image" => __("Featured image for this News", "bitz"),
        "set_featured_image" => __("Set featured image for this s", "bitz"),
        "remove_featured_image" => __("Remove featured image for this News", "bitz"),
        "use_featured_image" => __("Use as featured image for this News", "bitz"),
        "archives" => __("News archives", "bitz"),
        "insert_into_item" => __("Insert into News", "bitz"),
        "uploaded_to_this_item" => __("Upload to this News", "bitz"),
        "filter_items_list" => __("Filter News list", "bitz"),
        "items_list_navigation" => __("News list navigation", "bitz"),
        "items_list" => __("News list", "bitz"),
        "attributes" => __("News attributes", "bitz"),
        "name_admin_bar" => __("News", "bitz"),
        "item_published" => __("News published", "bitz"),
        "item_published_privately" => __("News published privately.", "bitz"),
        "item_reverted_to_draft" => __("News reverted to draft.", "bitz"),
        "item_scheduled" => __("News scheduled", "bitz"),
        "item_updated" => __("News updated.", "bitz"),
        "parent_item_colon" => __("Parent News:", "bitz"),
    ];

    $args = [
        "label" => __("News", "bitz"),
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
        "taxonomies" => ["post_tag", "geo-location", "new_categories", "sponsored_by", 'category'],
    ];

    register_post_type("news", $args);


    $labels = [
        "name" => __("News Categories", "bitz"),
        "singular_name" => __("News Category", "bitz"),
        "menu_name" => __("News Categories", "bitz"),
        "all_items" => __("All News Categories", "bitz"),
        "edit_item" => __("Edit News Category", "bitz"),
        "view_item" => __("View News Category", "bitz"),
        "update_item" => __("Update News Category name", "bitz"),
        "add_new_item" => __("Add new News Category", "bitz"),
        "new_item_name" => __("New News Category name", "bitz"),
        "parent_item" => __("Parent News Category", "bitz"),
        "parent_item_colon" => __("Parent News Category:", "bitz"),
        "search_items" => __("Search News Categories", "bitz"),
        "popular_items" => __("Popular News Categories", "bitz"),
        "separate_items_with_commas" => __("Separate News Categories with commas", "bitz"),
        "add_or_remove_items" => __("Add or remove News Categories", "bitz"),
        "choose_from_most_used" => __("Choose from the most used News Categories", "bitz"),
        "not_found" => __("No News Categories found", "bitz"),
        "no_terms" => __("No News Categories", "bitz"),
        "items_list_navigation" => __("News Categories list navigation", "bitz"),
        "items_list" => __("News Categories list", "bitz"),
    ];

    $args = [
        "label" => __("News Categories", "bitz"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'news-categories', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "news_categories",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("news_categories", ["news"], $args);


    // News
    // Taxonomy: Sponsered By.
    $labels = [
        "name" => __("Sponsored By", "bitz"),
        "singular_name" => __("Sponsored By", "bitz"),
        "menu_name" => __("Sponsored By", "bitz"),
        "all_items" => __("All Sponsored By", "bitz"),
        "edit_item" => __("Edit Sponsored By", "bitz"),
        "view_item" => __("View Sponsored By", "bitz"),
        "update_item" => __("Update Sponsored By name", "bitz"),
        "add_new_item" => __("Add new Sponsored By", "bitz"),
        "new_item_name" => __("New Sponsored By name", "bitz"),
        "parent_item" => __("Parent Sponsored By", "bitz"),
        "parent_item_colon" => __("Parent Type Category:", "bitz"),
        "search_items" => __("Search Sponsored By", "bitz"),
        "popular_items" => __("Popular Sponsored By", "bitz"),
        "separate_items_with_commas" => __("Separate Sponsored By with commas", "bitz"),
        "add_or_remove_items" => __("Add or remove Sponsored By", "bitz"),
        "choose_from_most_used" => __("Choose from the most used Sponsored By", "bitz"),
        "not_found" => __("No Sponsored By found", "bitz"),
        "no_terms" => __("No Sponsored By", "bitz"),
        "items_list_navigation" => __("Sponsored By list navigation", "bitz"),
        "items_list" => __("Sponsored By list", "bitz"),
    ];

    $args = [
        "label" => __("Sponsored By", "bitz"),
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
    register_taxonomy("sponsored_by", ["resources", "posts", "news", "events","page"], $args);


    // Taxonomy: Event Types.
    $labels = [
        "name" => __("Event Types", "bitz"),
        "singular_name" => __("Event Type", "bitz"),
        "menu_name" => __("Event Types", "bitz"),
        "all_items" => __("All Event Types", "bitz"),
        "edit_item" => __("Edit Event Type", "bitz"),
        "view_item" => __("View Event Type", "bitz"),
        "update_item" => __("Update Event Type name", "bitz"),
        "add_new_item" => __("Add new Event Type", "bitz"),
        "new_item_name" => __("New Event Type name", "bitz"),
        "parent_item" => __("Parent Event Type", "bitz"),
        "parent_item_colon" => __("Parent Event Type:", "bitz"),
        "search_items" => __("Search Event Types", "bitz"),
        "popular_items" => __("Popular Event Types", "bitz"),
        "separate_items_with_commas" => __("Separate Event Types with commas", "bitz"),
        "add_or_remove_items" => __("Add or remove Event Types", "bitz"),
        "choose_from_most_used" => __("Choose from the most used Event Types", "bitz"),
        "not_found" => __("No Event Types found", "bitz"),
        "no_terms" => __("No Event Types", "bitz"),
        "items_list_navigation" => __("Event Types list navigation", "bitz"),
        "items_list" => __("Event Types list", "bitz"),
    ];

    $args = [
        "label" => __("Event Types", "bitz"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'event_types', 'with_front' => true, 'hierarchical' => true,],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "event_types",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    ];
    register_taxonomy("event_types", ["events"], $args);
}

add_action('init', 'cptui_register_my_taxes');

function filter_archive_title($title) {

    if (is_post_type_archive()) {
        return post_type_archive_title('', false);
    }
}

add_filter('get_the_archive_title', 'filter_archive_title');

//End Code Resource Page

add_action('init', 'start_session', 1);

function start_session() {
    if (!session_id()) {
        session_start();
    }
}

/* SendGrid */

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



   /* $group_id = $_POST['group_id'];
    $curr_user = wp_get_current_user();

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sendgrid.com/v3/asm/suppressions/global",
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
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl); */

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



/*

  add_action('user_registration_check_token_complete', 'ur_auto_login', 10, 2);

  function ur_auto_login($user_id, $status) {

  if ($status === true) {
  $_SESSION['registered'] = 'true';
  $user_info = get_userdata($user_id);
  $user_meta = get_user_meta($user_id);

  $user_groups = sendgridController::fetch_groups();
  $user_groups = json_decode($user_groups);

  foreach ($user_groups as $single_grp) {
  $unsubscribe_from_group = sendgridController::add_user_suppression_group(array(
  'group_id' => $single_grp->id,
  'email_id' => $user_info->data->user_email,
  ));
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
  wp_safe_redirect('/sign-in/?msg=verified');
  exit();
  }
  } */

function test() {
    $user_id = 10;
    $user_info = get_userdata($user_id);
    $user_meta = get_user_meta($user_id);
    $data = array(
        'list_ids' => array(
            'c3bf0f95-890f-4370-99dd-6b8ff4d67d6d'
        ),
        'contacts' => array(array(
                "country" => (isset($user_meta['country'])) ? $user_meta['country'][0] : '',
                "Sender_Name" => get_bloginfo('name'),
                "Sender_Address" => "8000 Towers Crescent Drive, 13th Floor ",
                "Sender_City" => "Vienna",
                "Sender_State" => "Virginia",
                "Sender_Zip" => "22182",
                "email" => $user_info->data->user_email,
                "first_name" => $user_meta['first_name'][0],
                "last_name" => $user_meta['last_name'][0],
            ))
    );

    $response = sendgridController::add_to_list($data);
    echo '<pre>';
    print_r($response);
    echo '</pre>';
    exit();
}

//test();


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
    if ($msg == '' && $email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            $msg = "Invalid E-mail";            
//        }
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
        if (in_array(strtolower($domain_arr[0]), array('yahoo', 'gmail', 'outlook', 'rediffmail','ymail','yahoomail'))) {
            $msg = "We only accept business emails.";
        } else if ((isset($json['whitelist']) && $json['whitelist'] == 1) || (isset($json['disposable']) && $json['disposable'] == 1)) {
            $msg = "We only accept business e-mails.";
        } else {
            $msg = "";
        }
    } /*else {
        $msg = "Invalid business e-mail. Please check again.";
    }*/

    echo json_encode(array(
        'msg' => $msg,
        'curl_error' => $err
    ));
    exit();
}

add_action('wp_ajax_nopriv_fetch_user_details', 'fetch_user_details');
add_action('wp_ajax_fetch_user_details', 'fetch_user_details');

function fetch_user_details() {
    $msg = '';
    $email = $_REQUEST['email_id'];
    $exists = email_exists($email);
    $response = array(
        'status' => 'error',
        'msg' => $msg
    );

    if ($exists) {
        $user_id = $exists;
        $user_data = get_user_by('id', $user_id);
        $job_title = get_user_meta($user_id, 'user_registration_job_title', true);
        $company_name = get_user_meta($user_id, 'user_registration_company_name', true);

        $user_details = array(
            'name' => $user_data->first_name . ' ' . $user_data->last_name,
            'company_name' => $company_name,
            'job_title' => $job_title,
        );
        $response = array(
            'status' => 'success',
            'user_details' => $user_details,
            'msg' => $msg,
        );
    }

    echo json_encode($response);
    exit();
}

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

    $query = "SELECT id FROM wp_o0gCImmh0o00eqjs_users WHERE user_email LIKE '$email'";

    $user_table = $wpdb->get_row($query);

    if (!empty($user_table)) {
        $r_data = array(
            'status' => 'registered',
            'subscribe_url' => site_url('my-account/email-preferences'),
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
                                'privacy_policy_url' => site_url('privacy-policy'),
                                'terms_of_service_url' => site_url('terms-of-service'),
                                'contact_us_url' => site_url('contact-us'),
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
                        'verification_link' => site_url("subscribe-thank-you?verify_email=true&verification_token=$token&email_id=" . base64_encode($email)),
                        'curr_year' => date('Y'),
                        'privacy_policy_url' => site_url('privacy-policy'),
                        'terms_of_service_url' => site_url('terms-of-service'),
                        'contact_us_url' => site_url('contact-us'),
                    ))
    ));

    $r_data = array(
        'status' => 'success',
        'message' => 'success',
    );

    echo json_encode($r_data);
    exit();
}

function wpb_sender_name($original_email_from) {
    return 'Techweb Trends';
}

add_filter('wp_mail_from_name', 'wpb_sender_name');


/*

function newsletter_daily_func() {

    global $wpdb;
    $top_news = '';
    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` DESC LIMIT 0, 1";
    $result = $wpdb->get_row($query, OBJECT);

	if(!empty($result)){
		
		if ($top_news === '') {
			$top_news = $result->post_title;
		}
		$email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
											<tr>
												<td>
												   <h3 style="margin: 0 0 5px 0;font-size: 20px;">Today\'s highlights</h3>
												</td>
											</tr>
											<tr>
												<td>
													<a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
												</td>
											</tr>';

		$email_content .= '<tr>
							<td style="padding: 10px 0">
								<p><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
								<p>';

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
                                                <p><a class="link-btn" style="background-color: #ff7500;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                            </td>
                                        </tr>
                                    </table>';

	}
	
//Second Row
    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_date >= '" . date('Y-m-d 11:00', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d 10:59') . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` DESC LIMIT 1, 4";
    $results = $wpdb->get_results($query, OBJECT);

    foreach ($results as $result) {

        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:75%">
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
        $para = $paragraph;
        $email_content .= $para . ' <a  style="color:#ff7500;text-decoration:none;font-size:15px;font-weight:400;"  href="' . get_the_permalink($result->ID) . '">Read More</a>';
        $email_content .= '</p>
                                            </td>
                                        </tr>
                                    </table>';
    }

    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` DESC LIMIT 5, 3";
    $results = $wpdb->get_results($query, OBJECT);
	
	if(!empty($results)){
		$email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">In case you missed it</td>
									</tr>
								</tbody>
							</table>';
	}
    foreach ($results as $result) {
        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:75%">
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
            ;
        }
        $para = $paragraph;
        $email_content .= $para . ' <a style="color:#ff7500;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
        $email_content .= '</p>
                                            </td>
                                        </tr>
                                    </table>';
    }

    $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_daily'];

    //wp_mail('ramkiran@anteriad.com', 'Daily - WP Crontrol', 'Daily - WP Crontrol just ran at ' . date('Y-m-d H:i:s') . '!');
	
    if (!empty($top_news)) {
        $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['daily'], array(
                    'email_content' => $email_content,
                    'current_date' => date('l, F j, Y'),
					'curr_year' => date('Y'),
					'brand_name' => get_bloginfo('name'),
					'newsletter_title' => ti_daily_unsub_title,
                    'home_url' => home_url(),
                    'top_news' => $top_news,
                    'privacy_policy_url' => site_url('privacy-policy'),
                    'terms_of_service_url' => site_url('terms-of-service'),
                    'contact_us_url' => site_url('contact-us'),
                    'news_url' => site_url('news'),
					'facebook_link' => esc_attr(get_option('facebook_link')),
					'twitter_link' => esc_attr(get_option('twitter_link')),
					'linkedin_link' =>  esc_attr(get_option('linkedin_link')),
					'instagram_link' =>  esc_attr(get_option('instagram_link')),
                    'manage_your_preferences_link' => site_url('my-account/email-preferences'),
                        ), 'daily');
    }

    exit();
}
add_action('newsletter_daily', 'newsletter_daily_func');


*/













// add_action('newsletter_daily', 'newsletter_daily_func');

// function newsletter_daily_func() {

//     global $wpdb;
//     //    print_r($wpdb->prefix);
//     $top_news = '';
//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_o0gCImmh0o00eqjs_posts`.`post_date` DESC LIMIT 0, 1";
//     $result = $wpdb->get_row($query, OBJECT);

//     if ($top_news === '') {
//         $top_news = $result->post_title;
//     }
//     $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
//                         <tr>
//                                             <td>
//                                                <h3 style="margin: 0 0 5px 0;font-size: 20px;">Today\'s highlights</h3>
//                                             </td>
//                                         </tr>
//                                         <tr>
//                                             <td>
//                                                 <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                             </td>
//                                         </tr>';

//     $email_content .= '<tr>
//                                             <td style="padding: 10px 0">
//                                                 <p><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
//                                                 <p>';

//     if (!empty($result->post_excerpt)) {
//         $paragraph = $result->post_excerpt;
//     } else {
//         $paragraph = '';
//         $str = $result->post_content;
//         $str = strip_tags($str);
//         $paragraph = substr($str, 0, 300);
//         $paragraph = rtrim($paragraph, '.') . '...';
//     }
//     $para = $paragraph;
//     $email_content .= $para . '</p>
//                                                 <p><a class="link-btn" style="background-color: #009eed;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
//                                             </td>
//                                         </tr>
//                                     </table>';

// //Second Row
//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` WHERE post_date >= '" . date('Y-m-d 11:00', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d 10:59') . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_o0gCImmh0o00eqjs_posts`.`post_date` DESC LIMIT 1, 4";
//     $results = $wpdb->get_results($query, OBJECT);

//     foreach ($results as $result) {

//         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
//                                         <tr style="height: 140px; vertical-align: top;">
//                                             <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
//                                                 <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                             </td>
//                                             <td style="padding: 0 0 10px 10px; width:75%">
//                                                 <p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
//                                                 <p style="margin-top: 0">';
//         if (!empty($result->post_excerpt)) {
//             $paragraph = $result->post_excerpt;
//         } else {
//             $paragraph = '';
//             $str = $result->post_content;
//             $str = strip_tags($str);
//             $paragraph = substr($str, 0, 100);
//             $paragraph = rtrim($paragraph, '.') . '...';
//         }
//         $para = $paragraph;
//         $email_content .= $para . ' <a  style="color:#009eed;text-decoration:none;font-size:15px;font-weight:400;"  href="' . get_the_permalink($result->ID) . '">Read More</a>';
//         $email_content .= '</p>
//                                             </td>
//                                         </tr>
//                                     </table>';
//     }

//     $email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;">
//                                     <tbody>
//                                         <tr>
//                                             <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">In case you missed it</td>
//                                         </tr>
//                                     </tbody>
//                                 </table>';

//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` WHERE post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_o0gCImmh0o00eqjs_posts`.`post_date` DESC LIMIT 5, 3";
//     $results = $wpdb->get_results($query, OBJECT);
//     foreach ($results as $result) {
//         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
//                                         <tr style="height: 140px; vertical-align: top;">
//                                             <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
//                                                 <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                             </td>
//                                             <td style="padding: 0 0 10px 10px; width:75%">
//                                                 <p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
//                                                 <p style="margin-top: 0">';
//         if (!empty($result->post_excerpt)) {
//             $paragraph = $result->post_excerpt;
//         } else {
//             $paragraph = '';
//             $str = $result->post_content;
//             $str = strip_tags($str);
//             $paragraph = substr($str, 0, 100);
//             $paragraph = rtrim($paragraph, '.') . '...';
//             ;
//         }
//         $para = $paragraph;
//         $email_content .= $para . ' <a style="color:#009eed;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
//         $email_content .= '</p>
//                                             </td>
//                                         </tr>
//                                     </table>';
//     }

//     //print $email_content;
// //    echo '<pre>';
// //    print_r($email_content);
// //    echo '</pre>';
//     $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_daily'];
// //    echo '<pre>';
// //    print_r($dynamic_template_id);
// //    echo '</pre>';
// //    echo '<pre>';
// //    print_r($top_news);
// //    echo '</pre>';
// //    die();
// //    echo '<pre>';
// //    print_r($email_content);
// //    echo '</pre>';
// //    die();
//     //wp_mail('ramkiran@trueinfluence.com', 'Daily - WP Crontrol', 'Daily - WP Crontrol just ran at ' . date('Y-m-d H:i:s') . '!');
//     if (!empty($top_news)) {
//         $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['daily'], array(
//                     'email_content' => $email_content,
//                     'current_date' => date('l, F j, Y'),
//                     'home_url' => home_url(),
//                     'top_news' => $top_news,
//                     'privacy_policy_url' => site_url('privacy-policy'),
//                     'terms_of_service_url' => site_url('terms-of-service'),
//                     'contact_us_url' => site_url('contact-us'),
//                     'news_url' => site_url('news'),
//                     "manage_your_preferences_link" => site_url('my-account/email-preferences'),
//                         ), 'daily');
//     }

//     exit();
// }

// add_action('newsletter_weekly', 'newsletter_weekly_func');

// function newsletter_weekly_func() {
//     global $wpdb;

//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_o0gCImmh0o00eqjs_posts`.`post_date` ASC LIMIT 0, 1";
//     $result = $wpdb->get_row($query, OBJECT);

//     $todays_post = $result;
//     $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
// <tr>
//                                             <td>
//                                                <h3 style="margin: 0 0 5px 0;font-size: 20px;">Top News</h3>
//                                             </td>
//                                         </tr>
//                                         <tr>
//                                             <td>
//                                                 <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                             </td>
//                                         </tr>';

//     $email_content .= '<tr>
//                                             <td style="padding: 10px 0">
//                                                 <p><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;">' . $result->post_title . '</a></strong></p>';

//     if (!empty($result->post_excerpt)) {
//         $paragraph = $result->post_excerpt;
//     } else {
//         $paragraph = '';
//         $str = $result->post_content;
//         $str = strip_tags($str);
//         $paragraph = substr($str, 0, 300);
//         $paragraph = rtrim($paragraph, '.') . '...';
//     }
//     $para = $paragraph;
//     $email_content .= '<p>' . $para . '</p>
//                                                 <p><a class="link-btn" style="background-color: #009eed;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
//                                             </td>
//                                         </tr>
//                                     </table>';


// //Second Row
//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_o0gCImmh0o00eqjs_posts`.`post_date` ASC LIMIT 1, 4";
//     $results = $wpdb->get_results($query, OBJECT);

//     foreach ($results as $result) {
//         $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
//                                         <tr style="height: 140px; vertical-align: top;">
//                                             <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
//                                                 <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                             </td>
//                                             <td style="padding: 0 0 10px 10px; width:75%">
//                                                 <p style="margin: 0 0 5px 0"><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;">' . $result->post_title . '</a></strong></p>
//                                                 <p style="margin-top: 0">';
//         if (!empty($result->post_excerpt)) {
//             $paragraph = $result->post_excerpt;
//         } else {
//             $paragraph = '';
//             $str = $result->post_content;
//             $str = strip_tags($str);
//             $paragraph = substr($str, 0, 100);
//             $paragraph = rtrim($paragraph, '.') . '...';
//         }
//         $para = $paragraph;
//         $email_content .= $para . ' <a style="color:#009eed;font-weight:600;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
//         $email_content .= '</p>
//                                             </td>
//                                         </tr>
//                                     </table>';
//     }

//     $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center">
//                                     <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #009eed;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . site_url('news') . '">  Click here for more news  </a></p></td></tr>
//                                 </table>';


// //START -- Resource ROw
//     $email_content .= '<table width = 100% border = 0 style = "margin: 30px 0;margin-bottom: 20px;">
//                                     <tbody>
//                                     <tr>
//                                     <td style = "width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Top Resources</td>
//                                     </tr>
//                                     </tbody>
//                                     </table>';


//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('resources') AND post_status = 'publish' ORDER BY `wp_o0gCImmh0o00eqjs_posts`.`post_date` ASC LIMIT 1, 3";
//     $results = $wpdb->get_results($query, OBJECT);
//     $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
//                                         <tr style="height: 140px; vertical-align: top;">';
//     $i = 0;
//     foreach ($results as $result) {
//         $email_content .= '<td style="width: 33%;margin-right:10px;padding: 0 10px">'
//                 . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
//                 . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
//                 . '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #009eed;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
//                 . '</td>';
//         $i++;
//     }
//     $email_content .= ' </tr>
//                                     </table>';

//     $email_content .= '<table width = 100% border = 0 style = "margin: 30px 0;margin-bottom: 20px;">
//                                     <tbody>
//                                     <tr>
//                                     <td style = "width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Must read Blogs</td>
//                                     </tr>
//                                     </tbody>
//                                     </table>';

//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` WHERE post_type IN ('post') AND post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "'  AND post_status = 'publish' ORDER BY `wp_o0gCImmh0o00eqjs_posts`.`post_date` ASC LIMIT 0, 3";
//     $results = $wpdb->get_results($query, OBJECT);
//     foreach ($results as $result) {
//         $email_content .= '<table class = "single-row-news" border = "0" cellspacing = "0" cellpadding = "0" style = "width: 100%">
//                                     <tr style = "height: 140px; vertical-align: top;">
//                                     <td style = "width: 25%;padding: 0 20px 0 0;vertical-align: top;">
//                                     <a href = "' . get_the_permalink($result->ID) . '"><img src = "' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt = "' . $result->post_title . '" title = "' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
//                                     </td>
//                                     <td style = "padding: 0 0 10px 10px; width:75%">
//                                     <p style = "margin: 0 0 5px 0"><strong><a class = "text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href = "' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
//                                     <p style = "margin-top: 0">';
//         if (!empty($result->post_excerpt)) {
//             $paragraph = $result->post_excerpt;
//         } else {
//             $paragraph = '';
//             $str = $result->post_content;
//             $str = strip_tags($str);
//             $paragraph = substr($str, 0, 100);
//             $paragraph = rtrim($paragraph, '.') . '...';
//         }
//         $para = $paragraph;
//         $email_content .= $para . ' <a style="color:#009eed;text-decoration:none;font-size:15px;font-weight:400;" href = "' . get_the_permalink($result->ID) . '">Read More</a>';
//         $email_content .= '</p>
//                                     </td>
//                                     </tr>
//                                     </table>';
//     }

//     $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_weekly'];

// //    wp_mail('svyas@trueinfluence.com', 'Daily - WP Crontrol', 'Daily - WP Crontrol just ran at ' . date('Y-m-d H:i:s') . '!');
//     if (!empty($todays_post)) {
//         $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['weekly'], array(
//                     'email_content' => $email_content,
//                     'home_url' => home_url(),
//                     'privacy_policy_url' => site_url('privacy-policy'),
//                     'terms_of_service_url' => site_url('terms-of-service'),
//                     'contact_us_url' => site_url('contact-us'),
//                     'blogs_url' => site_url('blog'),
//                     "manage_your_preferences_link" => site_url('my-account/email-preferences'),
//                         ), 'weekly');
//     }
//     exit();
// }

// add_action('newsletter_monthly', 'newsletter_monthly_func');

// function newsletter_monthly_func() {
//     if (date('Y-m-d') !== date('Y-m-t')) {
//         exit(0);
//     }
//     $start_date = date('Y-m-01');

//     global $wpdb;

//     //START -- Resources -- Row 1
//     $email_content .= '<table width=100% border=0 style="margin: 0 0 20px 0;background-color:#ebebeb;border-top: 2px solid #009eed;">
//                                     <tbody>
//                                         <tr>
//                                             <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Most Downloaded Resources</td>
//                                         </tr>
//                                     </tbody>
//                                 </table>';
//     $query = "SELECT * FROM `wp_o0gCImmh0o00eqjs_posts` as p LEFT JOIN wp_o0gCImmh0o00eqjs_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('resources') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY p.`post_date` ASC LIMIT 0, 4";
//     $results = $wpdb->get_results($query, OBJECT);

//     $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
//                                         ';
//     $i = 0;
//     foreach ($results as $result) {
//         if ($i == 0 || $i == 2) {
//             $padding = 'padding: 0 15px 0 0';
//             $email_content .= '<tr style="height: 140px; vertical-align: top;">';
//         }
//         if ($i == 1 || $i == 3) {
//             $padding = 'padding: 0 0 0 15px';
//         }

//         $email_content .= '<td style="width: 50%;margin-right:15px;' . $padding . '">'
//                 . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;box-shadow: 1px 1px 6px 2px #eee;border:1px solid #eee;" /></a></p>'
//                 . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
//                 . '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:5px;padding:5px 30px;background-color : #009eed;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
//                 . '</td>';
//         if ($i == 1 || $i == 3) {
//             $email_content .= '</tr>';
//         }
//         $i++;
//     }
//     $email_content .= '</table>';
//     //END -- Resource ROW -- Row 1
//     //START -- Blogs Row -- ROW 2
//     $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 4";
//     $result1 = $wpdb->get_results($query, OBJECT);

//     $email_content .= '<table width=100% border=0 style="margin: 0px 0 30px 0;background-color:#ebebeb;border-top: 2px solid #009eed;">
//                                     <tbody>
//                                         <tr>
//                                             <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Popular Blogs</td>
//                                         </tr>
//                                     </tbody>
//                                 </table>';

//     //START -- Blogs - Sales Training - Row 3

//     if (!empty($result1)) {
//         foreach ($result1 as $single_result) {
//             $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom:10px;">
//                                         <tr style="height: 140px; vertical-align: top;">
//                                             <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">';

//             $email_content .= '<a href="' . get_the_permalink($single_result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($single_result->ID, 'full')) . '" alt="' . $single_result->post_title . '>" title="' . $single_result->post_title . '" /></a>
//                                             </td>';

//             $email_content .= '<td style="padding: 0 0 10px 10px; width:75%">
//                                                 <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($single_result->ID) . '">' . $single_result->post_title . '</a></strong></p>
//                                                 <p>';

//             if (!empty($single_result->post_excerpt)) {
//                 $paragraph = $single_result->post_excerpt;
//             } else {
//                 $paragraph = '';
//                 $str = $single_result->post_content;
//                 $str = strip_tags($str);
//                 $paragraph = substr($str, 0, 200);
//                 $paragraph = rtrim($paragraph, '.') . '...';
//             }
//             $para = $paragraph;
//             $email_content .= $para . ' <a style="color:#009eed;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($single_result->ID) . '">Read More</a>';

//             $email_content .= "</p>
//                                             </td>
//                                         </tr>
//                                     </table>";
//         }
//     }

//     if ($blogs_available) {
//         $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;">
//                                     <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;padding:5px 30px;background-color : #009eed;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('blog') . '">  Read more Blogs   </a></p></td></tr>
//                                 </table>';
//     }

//     $email_content .= '<table width=100% border=0 style="margin: 30px 0 30px 0;background-color:#ebebeb;border-top: 2px solid #009eed;">
//                                     <tbody>
//                                         <tr>
//                                             <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Top News</td>
//                                         </tr>
//                                     </tbody>
//                                 </table>';

//     $query = "SELECT * FROM wp_o0gCImmh0o00eqjs_posts p LEFT JOIN wp_o0gCImmh0o00eqjs_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_type = 'news' AND post_date >= '" . $start_date . "' AND post_date <= '" . date('Y-m-t') . "' AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 0, 5";
//     $results = $wpdb->get_results($query);

//     $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">';

//     foreach ($results as $result) {
//         $email_content .= '<tr style="vertical-align: top;"><td style=" width:100%;padding: 0"><p style="margin-top: 0;font-size:20px;color:#009eed"><strong><a class="text-para" style="color: #009eed;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p></td></tr>';
//     }

//     $email_content .= '</table>';

//     $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
//                                     <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #009eed;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('news') . '">  More News </a></p></td></tr>
//                                 </table>';

//     $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_monthly'];
//     $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['monthly'], array(
//                 'email_content' => $email_content,
//                 'home_url' => home_url(),
//                 'privacy_policy_url' => site_url('privacy-policy'),
//                 'terms_of_service_url' => site_url('terms-of-service'),
//                 'contact_us_url' => site_url('contact-us'),
//                 'blogs_url' => site_url('blog'),
//                 'month' => date('F', strtotime('-1 month')) . ', ' . date('Y', strtotime('-1 month')),
//                 "manage_your_preferences_link" => site_url('my-account/email-preferences'),
//                     ), 'monthly');

//     exit();
// }

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
                        $categories = get_the_terms(get_the_ID(), 'resource_types');
                        foreach ($categories as $category) {
                            ?>
                            <a href="<?php echo get_term_link($category->term_id); ?>" class="resource-category  td-post-category"><?php echo $category->name; ?></a>
                        <?php } ?> 

                        <h3 class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h3>
                        <div class="td-excerpt"><?php the_excerpt(); ?></div>
                        <div class="td-editor-date">

                            <span class="td-author-date">
                                <?php
                                $sponsored_by = get_the_terms(get_the_ID(), 'sponsored_by');
                                foreach ($sponsored_by as $sponsored_by_single) {
                                    ?>
                                    <span class="td-post-author-name"><a href="<?php echo get_term_link($sponsored_by_single->term_id); ?>"><?php echo $sponsored_by_single->name; ?></a> <span>-</span> </span>
                                <?php } ?> 
                                <span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>
                            </span>
                        </div>

                        <div class="td-read-more">
                            <a href="<?php the_permalink() ?>">Read more</a>
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

function vComp() {
    $value = get_option('total_followers', '');
    return $value;
}

add_shortcode('vShortcode', 'vComp');

add_action('template_redirect', function() {
    if (is_user_logged_in() || !is_page()) {
        return;
    }
    if (!is_user_logged_in() && is_page('my-account')) {
        global $wp;

        wp_redirect(site_url('sign-in?') . 'redirect_to=' . home_url($wp->request));
        exit();
    }

    $restricted = array(16); // all your restricted pages

    if (in_array(get_queried_object_id(), $restricted)) {
        global $wp;
        wp_redirect(site_url('sign-in?') . 'redirect_to=' . home_url($wp->request));
        exit();
    }
});


/* SendGrid */

/* Read Time */

add_shortcode('post-read-time', 'post_read_time');

function post_read_time() {
    $post_id = url_to_postid(get_permalink());

    $read_time = (get_post_meta($post_id, '_read_time', true) != '') ? get_post_meta($post_id, '_read_time', true) : '';
    return $read_time;
}

/* Read Time */


/* START -- Stock Ticker */

function tradingview_stock_ticker_shortcode($atts) {
    return '<div class="home-line-height"><iframe scrolling="no" allowtransparency="true" frameborder="0" src="https://s.tradingview.com/embed-widget/ticker-tape/?locale=in#%7B%22symbols%22%3A%5B%7B%22description%22%3A%22Peloton%22%2C%22proName%22%3A%22NASDAQ%3APTON%22%7D%2C%7B%22description%22%3A%22Farfetch%20Limited%22%2C%22proName%22%3A%22NYSE%3AFTCH%22%7D%2C%7B%22description%22%3A%22Crowdstrike%22%2C%22proName%22%3A%22NASDAQ%3ACRWD%22%7D%2C%7B%22description%22%3A%22Datadog%22%2C%22proName%22%3A%22NASDAQ%3ADDOG%22%7D%2C%7B%22description%22%3A%22Zoom%20Video%22%2C%22proName%22%3A%22NASDAQ%3AZM%22%7D%2C%7B%22description%22%3A%22Alteryx%22%2C%22proName%22%3A%22NYSE%3AAYX%22%7D%2C%7B%22description%22%3A%22Cloudera%22%2C%22proName%22%3A%22NYSE%3ACLDR%22%7D%2C%7B%22description%22%3A%22Lyft%22%2C%22proName%22%3A%22NASDAQ%3ALYFT%22%7D%2C%7B%22description%22%3A%22Twilio%22%2C%22proName%22%3A%22NYSE%3ATWLO%22%7D%2C%7B%22description%22%3A%22Lightspeed%20POS%22%2C%22proName%22%3A%22TSX%3ALSPD%22%7D%2C%7B%22description%22%3A%22Elastic%20N.V.%22%2C%22proName%22%3A%22NYSE%3AESTC%22%7D%2C%7B%22description%22%3A%22The%20RealReal%22%2C%22proName%22%3A%22NASDAQ%3AREAL%22%7D%2C%7B%22description%22%3A%22Cloudflare%22%2C%22proName%22%3A%22NYSE%3ANET%22%7D%2C%7B%22description%22%3A%22Coupa%20Software%22%2C%22proName%22%3A%22NASDAQ%3ACOUP%22%7D%2C%7B%22description%22%3A%22Smile%20Direct%20Club%22%2C%22proName%22%3A%22NASDAQ%3ASDC%22%7D%2C%7B%22description%22%3A%22Bill.com%22%2C%22proName%22%3A%22CURRENCYCOM%3ABILL%22%7D%2C%7B%22description%22%3A%22Shopify%22%2C%22proName%22%3A%22NYSE%3ASHOP%22%7D%2C%7B%22description%22%3A%22Okta%22%2C%22proName%22%3A%22NASDAQ%3AOKTA%22%7D%2C%7B%22description%22%3A%22MongoDB%22%2C%22proName%22%3A%22NASDAQ%3AMDB%22%7D%2C%7B%22description%22%3A%22Fastly%22%2C%22proName%22%3A%22NYSE%3AFSLY%22%7D%2C%7B%22description%22%3A%22Anaplan%22%2C%22proName%22%3A%22NYSE%3APLAN%22%7D%2C%7B%22description%22%3A%22Fiverr%22%2C%22proName%22%3A%22NYSE%3AFVRR%22%7D%2C%7B%22description%22%3A%222U%22%2C%22proName%22%3A%22NASDAQ%3ATWOU%22%7D%2C%7B%22description%22%3A%22Square%22%2C%22proName%22%3A%22NYSE%3ASQ%22%7D%2C%7B%22description%22%3A%22Avalara%22%2C%22proName%22%3A%22NYSE%3AAVLR%22%7D%2C%7B%22description%22%3A%22DocuSign%22%2C%22proName%22%3A%22NASDAQ%3ADOCU%22%7D%2C%7B%22description%22%3A%22PagerDuty%22%2C%22proName%22%3A%22NYSE%3APD%22%7D%2C%7B%22description%22%3A%22Atlassian%20%22%2C%22proName%22%3A%22NASDAQ%3ATEAM%22%7D%2C%7B%22description%22%3A%22Everbridge%22%2C%22proName%22%3A%22NASDAQ%3AEVBG%22%7D%2C%7B%22description%22%3A%22Zscaler%22%2C%22proName%22%3A%22NASDAQ%3AZS%22%7D%2C%7B%22description%22%3A%22Stichfix%22%2C%22proName%22%3A%22NASDAQ%3ASFIX%22%7D%2C%7B%22description%22%3A%22Salesforce.com%22%2C%22proName%22%3A%22NYSE%3ACRM%22%7D%2C%7B%22description%22%3A%22The%20Trade%20Desk%22%2C%22proName%22%3A%22NASDAQ%3ATTD%22%7D%2C%7B%22description%22%3A%22Veeva%20Systems%22%2C%22proName%22%3A%22NYSE%3AVEEV%22%7D%2C%7B%22description%22%3A%22Ringcentral%22%2C%22proName%22%3A%22NYSE%3ARNG%22%7D%2C%7B%22description%22%3A%22AppFolio%22%2C%22proName%22%3A%22NASDAQ%3AAPPF%22%7D%2C%7B%22description%22%3A%22Zendesk%22%2C%22proName%22%3A%22NYSE%3AZEN%22%7D%2C%7B%22description%22%3A%22Rapid7%22%2C%22proName%22%3A%22NASDAQ%3ARPD%22%7D%2C%7B%22description%22%3A%22ServiceNow%22%2C%22proName%22%3A%22NYSE%3ANOW%22%7D%2C%7B%22description%22%3A%22Pluralsight%22%2C%22proName%22%3A%22NASDAQ%3APS%22%7D%2C%7B%22description%22%3A%22Xero%22%2C%22proName%22%3A%22ASX%3AXRO%22%7D%2C%7B%22description%22%3A%228x8%22%2C%22proName%22%3A%22NYSE%3AEGHT%22%7D%2C%7B%22description%22%3A%22Netflix%22%2C%22proName%22%3A%22NASDAQ%3ANFLX%22%7D%2C%7B%22description%22%3A%22UBER%20TECHNOLOGIES%22%2C%22proName%22%3A%22NYSE%3AUBER%22%7D%2C%7B%22description%22%3A%22HubSpot%22%2C%22proName%22%3A%22NYSE%3AHUBS%22%7D%2C%7B%22description%22%3A%22Q2%20Holdings%22%2C%22proName%22%3A%22NYSE%3AQTWO%22%7D%2C%7B%22description%22%3A%22Tenable%20Holdings%22%2C%22proName%22%3A%22NASDAQ%3ATENB%22%7D%2C%7B%22description%22%3A%22BlackLine%22%2C%22proName%22%3A%22NASDAQ%3ABL%22%7D%2C%7B%22description%22%3A%22Paycom%20Software%22%2C%22proName%22%3A%22NYSE%3APAYC%22%7D%2C%7B%22description%22%3A%22Spotify%22%2C%22proName%22%3A%22NYSE%3ASPOT%22%7D%2C%7B%22description%22%3A%22LiveRamp%20Holdings%22%2C%22proName%22%3A%22NYSE%3ARAMP%22%7D%2C%7B%22description%22%3A%22Yext%22%2C%22proName%22%3A%22NYSE%3AYEXT%22%7D%2C%7B%22description%22%3A%22FIVN%22%2C%22proName%22%3A%22NASDAQ%3AFIVN%22%7D%2C%7B%22description%22%3A%22SPLK%22%2C%22proName%22%3A%22NASDAQ%3ASPLK%22%7D%2C%7B%22description%22%3A%22Medallia%22%2C%22proName%22%3A%22NYSE%3AMDLA%22%7D%2C%7B%22description%22%3A%22Mimecast%20Limited%22%2C%22proName%22%3A%22NASDAQ%3AMIME%22%7D%2C%7B%22description%22%3A%22Dynatrace%22%2C%22proName%22%3A%22NYSE%3ADT%22%7D%2C%7B%22description%22%3A%22WIX.COM%22%2C%22proName%22%3A%22NASDAQ%3AWIX%22%7D%2C%7B%22description%22%3A%22Workiva%22%2C%22proName%22%3A%22NYSE%3AWK%22%7D%2C%7B%22description%22%3A%22Teladoc%22%2C%22proName%22%3A%22NYSE%3ATDOC%22%7D%2C%7B%22description%22%3A%22Survey%20Monkey%22%2C%22proName%22%3A%22NASDAQ%3ASVMK%22%7D%2C%7B%22description%22%3A%22Workday%22%2C%22proName%22%3A%22NASDAQ%3AWDAY%22%7D%2C%7B%22description%22%3A%22Instructure%22%2C%22proName%22%3A%22SWB%3A1IN%22%7D%2C%7B%22description%22%3A%22Amazon%22%2C%22proName%22%3A%22NASDAQ%3AAMZN%22%7D%2C%7B%22description%22%3A%22Paylocity%20Holding%20Corporation%22%2C%22proName%22%3A%22NASDAQ%3APCTY%22%7D%2C%7B%22description%22%3A%22New%20Relic%22%2C%22proName%22%3A%22NYSE%3ANEWR%22%7D%2C%7B%22description%22%3A%22Proofpoint%22%2C%22proName%22%3A%22NASDAQ%3APFPT%22%7D%2C%7B%22description%22%3A%22Match%20Group%22%2C%22proName%22%3A%22NASDAQ%3AMTCH%22%7D%2C%7B%22description%22%3A%22Autodesk%22%2C%22proName%22%3A%22NASDAQ%3AADSK%22%7D%2C%7B%22description%22%3A%22Domo%22%2C%22proName%22%3A%22NASDAQ%3ADOMO%22%7D%2C%7B%22description%22%3A%22Adobe%22%2C%22proName%22%3A%22NASDAQ%3AADBE%22%7D%2C%7B%22description%22%3A%22Talend%20S.A.%22%2C%22proName%22%3A%22NASDAQ%3ATLND%22%7D%2C%7B%22description%22%3A%22Upwork%22%2C%22proName%22%3A%22NASDAQ%3AUPWK%22%7D%2C%7B%22description%22%3A%22Dropbox%22%2C%22proName%22%3A%22NASDAQ%3ADBX%22%7D%2C%7B%22description%22%3A%22Bandwidth%22%2C%22proName%22%3A%22NASDAQ%3ABAND%22%7D%2C%7B%22description%22%3A%22Paypal%22%2C%22proName%22%3A%22NASDAQ%3APYPL%22%7D%2C%7B%22description%22%3A%22J2%20Global%22%2C%22proName%22%3A%22NASDAQ%3AJCOM%22%7D%2C%7B%22description%22%3A%22Appian%20Corporation%22%2C%22proName%22%3A%22NASDAQ%3AAPPN%22%7D%2C%7B%22description%22%3A%22Zuora%22%2C%22proName%22%3A%22NYSE%3AZUO%22%7D%2C%7B%22description%22%3A%22Palo%20Alto%20Networks%22%2C%22proName%22%3A%22NYSE%3APANW%22%7D%2C%7B%22description%22%3A%22PING%20IDENTITY%22%2C%22proName%22%3A%22NYSE%3APING%22%7D%2C%7B%22description%22%3A%22Qualys%22%2C%22proName%22%3A%22NASDAQ%3AQLYS%22%7D%2C%7B%22description%22%3A%22Ceridian%20HCM%20Holding%22%2C%22proName%22%3A%22NYSE%3ACDAY%22%7D%2C%7B%22description%22%3A%22Intuit%22%2C%22proName%22%3A%22NASDAQ%3AINTU%22%7D%2C%7B%22description%22%3A%22RealPage%22%2C%22proName%22%3A%22NASDAQ%3ARP%22%7D%2C%7B%22description%22%3A%22GoDaddy%22%2C%22proName%22%3A%22NYSE%3AGDDY%22%7D%2C%7B%22description%22%3A%22Box%22%2C%22proName%22%3A%22NYSE%3ABOX%22%7D%2C%7B%22description%22%3A%22SolarWinds%22%2C%22proName%22%3A%22NYSE%3ASWI%22%7D%2C%7B%22description%22%3A%22SAILPOINT%20TECHNOLOGIES%22%2C%22proName%22%3A%22NYSE%3ASAIL%22%7D%2C%7B%22description%22%3A%22Eventbrite%22%2C%22proName%22%3A%22NYSE%3AEB%22%7D%2C%7B%22description%22%3A%22Expedia%22%2C%22proName%22%3A%22NASDAQ%3AEXPE%22%7D%2C%7B%22description%22%3A%22FireEye%22%2C%22proName%22%3A%22NASDAQ%3AFEYE%22%7D%2C%7B%22description%22%3A%22Blackbaud%22%2C%22proName%22%3A%22NASDAQ%3ABLKB%22%7D%2C%7B%22description%22%3A%22Black%20Knight%22%2C%22proName%22%3A%22NYSE%3ABKI%22%7D%2C%7B%22description%22%3A%22Shutterstock%22%2C%22proName%22%3A%22NYSE%3ASSTK%22%7D%2C%7B%22description%22%3A%22LogMein%22%2C%22proName%22%3A%22NASDAQ%3ALOGM%22%7D%2C%7B%22description%22%3A%22Bookings%22%2C%22proName%22%3A%22NASDAQ%3ABKNG%22%7D%2C%7B%22description%22%3A%22Check%20Point%20Software%22%2C%22proName%22%3A%22NASDAQ%3ACHKP%22%7D%2C%7B%22description%22%3A%22Nutanix%22%2C%22proName%22%3A%22NASDAQ%3ANTNX%22%7D%2C%7B%22description%22%3A%22Guidewire%20Software%22%2C%22proName%22%3A%22NYSE%3AGWRE%22%7D%2C%7B%22description%22%3A%22Ebay%22%2C%22proName%22%3A%22NASDAQ%3AEBAY%22%7D%2C%7B%22description%22%3A%22TripAdvisor%22%2C%22proName%22%3A%22NASDAQ%3ATRIP%22%7D%2C%7B%22description%22%3A%22Blue%20Apron%22%2C%22proName%22%3A%22NYSE%3AAPRN%22%7D%2C%7B%22description%22%3A%22Facebook%22%2C%22proName%22%3A%22NASDAQ%3AFB%22%7D%5D%2C%22colorTheme%22%3A%22light%22%2C%22isTransparent%22%3Afalse%2C%22displayMode%22%3A%22regular%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A46%2C%22utm_source%22%3A%22techversions.com%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22ticker-tape%22%7D" style="box-sizing: border-box; height: 46px; width: 100%;padding: 0;margin: 0;display:block;border:none;overflow:hidden;"></iframe></div>';
}

add_shortcode('tradingview_stock_ticker', 'tradingview_stock_ticker_shortcode');
/* END -- Stock Ticker */

function tsm_sub_footer_widget() {
    register_sidebar(array(
        'name' => __('Sub Footer', 'textdomain'),
        'id' => 'sub-footer',
        'description' => __('Widgets in this area will be shown on all posts and pages.', 'textdomain'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'tsm_sub_footer_widget');

//Gets the  number of Post Views to be used later.
function get_PostViews($post_ID) {
//    $count_key = 'post_views_count';
    $count_key = 'mnky_post_views_count';
//    $count = get_post_meta($postID, $count_key, true);
    $count = get_post_meta($post_ID, $count_key, true);
//    print $count;

    if ($count == '') {
//        delete_post_meta($postID, $count_key);
//        add_post_meta($postID, $count_key, '0');

        delete_post_meta($post_ID, $count_key);
        add_post_meta($post_ID, $count_key, '0');
        return "0 View";
    }
    return $count . ' Views';
}

//Function that Adds a 'Views' Column to your Posts tab in WordPress Dashboard.
function post_column_views($newcolumn) {
    //Retrieves the translated string, if translation exists, and assign it to the 'default' array.
    $newcolumn['post_views'] = __('Views');
    return $newcolumn;
}

//Function that Populates the 'Views' Column with the number of views count.
function post_custom_column_views($column_name, $id) {

    if ($column_name === 'post_views') {
        // Display the Post View Count of the current post.
        // get_the_ID() - Returns the numeric ID of the current post.
        echo get_PostViews(get_the_ID());
    }
}

//Hooks a function to a specific filter action.
//applied to the list of columns to print on the manage posts screen.
add_filter('manage_posts_columns', 'post_column_views');

//Hooks a function to a specific action. 
//allows you to add custom columns to the list post/custom post type pages.
//'10' default: specify the function's priority.
//and '2' is the number of the functions' arguments.
add_action('manage_posts_custom_column', 'post_custom_column_views', 10, 2);

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

add_filter('wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2);

function wti_loginout_menu_link($items, $args) {
    if ($args->theme_location == 'top_bar_menu') {
        if (is_user_logged_in()) {
            $itens .= '<li class="right"><a href="' . wp_logout_url() . '">' . __("Log Out") . '</a></li>';
        }
    }
    return $items;
}
/* 
function add_php_data() {

    ?>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<?php

}
add_filter('admin_head', 'add_php_data');
 */

function hide_menu() {



// Use this for specific user role. Change site_admin part accordingly
if (current_user_can('editor')) {
remove_menu_page( 'themes.php' ); // Appearance
remove_menu_page( 'options-general.php' ); //Settings
remove_menu_page( 'edit-comments.php' );
remove_menu_page( 'edit.php?post_type=cookielawinfo' );
remove_menu_page( 'profile.php' );
remove_menu_page( 'tools.php' );
remove_menu_page( 'manage_fm' );
remove_menu_page( 'wpseo_workouts' );
remove_menu_page( 'envato-market' );
remove_menu_page( 'tdb_cloud_templates' );
remove_menu_page( 'tds_email' );
remove_menu_page( 'vc-welcome' );
remove_menu_page( 'custom_headers' );
remove_menu_page( 'revslider' );
remove_menu_page( 'essb_options' );
remove_menu_page( 'vc-general' );
remove_menu_page( 'post_type=custom_headers' );
remove_menu_page( 'kinsta-tools' );
remove_menu_page( 'ads' );
remove_menu_page( 'edit.php?post_type=custom_headers' );
remove_menu_page( 'edit.php?post_type=ads' );
}
}
add_action('admin_head', 'hide_menu');



  
function login_with_email_address($username) {
    $user = get_user_by_email($username);
    if(!empty($user->user_login))
        $username = $user->user_login;
    return $username;
}
add_action('wp_authenticate','login_with_email_address');


function check_attempted_login( $user, $username, $password ) {
    if ( get_transient( 'attempted_login' ) ) {
        $datas = get_transient( 'attempted_login' );

        if ( $datas['tried'] >= 3 ) {
            $until = get_option( '_transient_timeout_' . 'attempted_login' );
            $time = time_to_go( $until );

            return new WP_Error( 'too_many_tried',  sprintf( __( '<strong>ERROR</strong>: You have reached authentication limit, you will be able to try again in %1$s.' ) , $time ) );
        }
    }

    return $user;
}
add_filter( 'authenticate', 'check_attempted_login', 30, 3 ); 
function login_failed( $username ) {
    if ( get_transient( 'attempted_login' ) ) {
        $datas = get_transient( 'attempted_login' );
        $datas['tried']++;

        if ( $datas['tried'] <= 3 )
            set_transient( 'attempted_login', $datas , 300 );
    } else {
        $datas = array(
            'tried'     => 1
        );
        set_transient( 'attempted_login', $datas , 300 );
    }
}
add_action( 'wp_login_failed', 'login_failed', 10, 1 ); 

function time_to_go($timestamp)
{

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

function remove_post_type_page_from_search() {
    global $wp_post_types;
    $wp_post_types['sdm_downloads']->exclude_from_search = true;
    $wp_post_types['page']->exclude_from_search = true;
}


add_action('init', 'remove_post_type_page_from_search');


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

// function wp_maintenance_mode() {

//     if (!current_user_can('edit_themes') || !is_user_logged_in()) {

//         $html = '<!doctype html>

// <head>

// <title>Site Under Maintenance</title>

// <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

// <body style="width:100%;max-width:100%;padding:0;margin:0">

// <iframe name="myframe" src="https://learningtechedu.com/maintenance-page/" style="width:100%; height:100vh;padding: 0px;"></iframe>

// </body>

// </html>';

//         echo $html;

//         wp_die();

//     }

// }

// add_action('get_header', 'wp_maintenance_mode');

add_action('init', 'prevent_wp_login');

function prevent_wp_login() {
    // WP tracks the current page - global the variable to access it
    global $pagenow;
    // Check if a $_GET['action'] is set, and if so, load it into $action variable
    $action = (isset($_GET['action'])) ? $_GET['action'] : '';
    // Check if we're on the login page, and ensure the action is not 'logout'
    if( $pagenow == 'wp-login.php' && ( ! $action || ( $action && ! in_array($action, array('logout', 'lostpassword', 'rp', 'resetpass'))))) {
        // Load the home page url
        $page = 'https://techwebtrends.com/sign-in/';
        // Redirect to the home page
        wp_redirect($page);
        // Stop execution to prevent the page loading for any reason
        exit();
    }
}
function remove_quick_edit( $actions ) {
    unset($actions['inline hide-if-no-js']);
    return $actions;
}
 
add_filter('page_row_actions','remove_quick_edit',10,1);
add_filter('post_row_actions','remove_quick_edit',10,1);