<?php
/* Template Name: Subscribe Thank you page*/

global $current_user;
get_header();



//if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
//    $_SESSION['typ_redirect'] = 'true';
//    wp_redirect(get_the_permalink($resource_id));
//}
//$_SESSION['form_submission'] = 'false';
if (isset($_GET['email_id']) && !empty($_GET['email_id'])) {
    $email_id = base64_decode($_GET['email_id']);
    $my_groups = sendgridController::get_supression_group($email_id);
    $my_groups = json_decode($my_groups['response']);
    $updated_groups = array();
    foreach ($my_groups->suppressions as $my_group) {
        $updated_groups[$my_group->id] = $my_group;
    }
}
$user_groups = sendgridController::fetch_groups();
$user_groups = json_decode($user_groups);

$global_unsubscribe = json_decode($response);
$global_suppressed = 0;
if (isset($global_unsubscribe->recipient_email)) {
    $global_suppressed = 1;
}

$sub_query = array();
$email_verified = 'false';
$show_form = 'true';
$my_groups = array();
if (isset($_GET['verification_token']) && !empty($_GET['verification_token'])) {
    $email_id = base64_decode($_GET['email_id']); // Set email variable
    $hash = $_GET['verification_token']; // Set hash variable

    $query = "SELECT id,verified,group_ids FROM subscriptions WHERE email_id LIKE '$email_id' AND hash LIKE '$hash' ORDER BY id DESC";

    $sub_query = $wpdb->get_row($query);

    $my_groups = unserialize($sub_query->group_ids);

    if ((int) $sub_query->verified !== 1) {
        // START -- Add user to the SendGrid Subscription List
        foreach ($user_groups as $single_grp) {
            $unsubscribe_from_group = sendgridController::add_user_suppression_group(array(
                        'group_id' => $single_grp->id,
                        'email_id' => $email_id,
            ));
        }



        foreach ($my_groups as $key => $single_grp) {
            if (!empty($single_grp)) {
                $subscribe_to_group = sendgridController::remove_user_suppression_group(array(
                            'group_id' => $single_grp,
                            'email_id' => $email_id,
                ));
            }
        }

        $updated = $wpdb->update('subscriptions', array(
            'verified' => 1
                ), array(
            'id' => $sub_query->id
        ));

        $data = array(
            'list_ids' => array(
                sendgridController::SG_SUBSCRIPTIONS_LISTID,
            ),
            'contacts' => array(array(
                    "email" => $email_id,
                )),
        );

        $response = sendgridController::add_to_list($data);
        // END -- Add user to the SendGrid Subscription List
        //Update my groups with the details and updated groups

        $updated_groups = array();
        $my_groups_new = sendgridController::get_supression_group($email_id);
        $my_groups_new = json_decode($my_groups_new['response']);
        foreach ($my_groups_new->suppressions as $my_group) {
            if ((!empty($my_groups) && in_array($my_group->id, $my_groups)) || empty($my_groups)) {
                $updated_groups[$my_group->id] = $my_group;
            }
        }

//        $email_content = '<ul>';
//        foreach ($updated_groups as $my_group) {
//            $email_content .= "<li style='color:#333'><b>$my_group->name</b></li>";
//        }
//
//        $email_content .= '</ul>';

        $email_content = '';
        foreach ($updated_groups as $my_group) {
            $email_content .= "<div><span style='font-weight: 400; letter-spacing: normal; text-align: left;font-size: 15px; font-family: helvetica, sans-serif; color: #333;display: inline-block;padding: 10px 20px;border: 1px solid #333;margin-bottom: 10px;min-width: 250px;'>&#9745; {$my_group->name}</span></div>";
        }

        $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['new_subscriber'];
        $response = sendgridController::send_dynamic_email($dynamic_template_id, 0, array(
                        ), array(array('to' => array(array(
                                'name' => $email_id,
                                'email' => $email_id,
                            )), 'dynamic_template_data' => array(
                            'subscription_link' => site_url("subscribe?email_id=" . base64_encode($email_id)),
                            'email_content' => $email_content,
                            'curr_year' => date('Y'),                                    
                            'privacy_policy_url' => site_url('privacy-policy'),
                            'terms_of_service_url' => site_url('terms-of-service'),
                            'contact_us_url' => site_url('contact-us'),
                        ))
        ));
    } else {
        $query = "SELECT id,verified,group_ids FROM subscriptions WHERE email_id LIKE '$email_id' ORDER BY id DESC";
        $fetch_groups_from_email = $wpdb->get_row($query);
        if (!empty($fetch_groups_from_email->group_ids)) {
            $updated_groups = array();
            $my_groups = unserialize($fetch_groups_from_email->group_ids);
            $my_groups_new = sendgridController::get_supression_group($email_id);
            $my_groups_new = json_decode($my_groups_new['response']);
            foreach ($my_groups_new->suppressions as $my_group) {
                if ((!empty($my_groups) && in_array($my_group->id, $my_groups)) || empty($my_groups)) {
                    $updated_groups[$my_group->id] = $my_group;
                }
            }
        }
    }
}

?>

<div class="subscribe-form-block wdform_row td-container">
                <?php
//                $sub_query = array();
//                $email_verified = 'false';
//                $show_form = 'true';
                if (isset($_GET['verification_token']) && !empty($_GET['verification_token'])) {

//					print "dfgdfg";
//                    if (isset($email_id)) {
//                        $email_id = base64_decode($_GET['email_id']); // Set email variable
//                    }
//                    $hash = $_GET['verification_token']; // Set hash variable
//
//                    $query = "SELECT id,verified,group_ids FROM subscriptions WHERE email_id LIKE '$email_id' AND hash LIKE '$hash' ORDER BY id DESC";
//
//                    $sub_query = $wpdb->get_row($query);
                    if (!empty($sub_query)) {
                        if ($sub_query->verified == 0) {
                            $email_verified = 'true';
                            $show_form = 'false';
                            //Status is InActive
//                        $updated = $wpdb->update('subscriptions', array(
//                            'verified' => 1
//                                ), array(
//                            'id' => $sub_query->id
//                        ));
//
//                        // START -- Add user to the SendGrid Subscription List
//                        foreach ($user_groups as $single_grp) {
//                            $unsubscribe_from_group = sendgridController::add_user_suppression_group(array(
//                                        'group_id' => $single_grp->id,
//                                        'email_id' => $email_id,
//                            ));
//                        }
//
//
//
//                        foreach ($my_groups as $key => $single_grp) {
//                            if (!empty($single_grp)) {
//                                $subscribe_to_group = sendgridController::remove_user_suppression_group(array(
//                                            'group_id' => $single_grp,
//                                            'email_id' => $email_id,
//                                ));
//                            }
//                        }
//                        $data = array(
//                            'list_ids' => array(
//                                sendgridController::SG_SUBSCRIPTIONS_LISTID,
//                            ),
//                            'contacts' => array(array(
//                                    "email" => $email_id,
//                                )),
//                        );
//
//                        $response = sendgridController::add_to_list($data);
//                            $output = json_decode($response);
                            // END -- Add user to the SendGrid Subscription List
                            ?>
                            <div class="alert alert-success" style="display:none">Thank you for your confirmation. You have successfully subscribed to our newsletter(s). Please check your email for further details.</div>
                            <?php
                        } else {
                            $show_form = 'false';
                            //Status is Active
                            ?>
                            <div class="alert alert-danger" class="subscribe-msg">You're already subscribed to our newsletter. Please check and update your newsletter preferences <a href="<?php echo site_url('subscribe?email_id=' . base64_encode($email_id)) ?>" style="color:inherit;text-decoration:underline;">HERE</a></div>
                            <?php
                        }
                    } else {

                        $show_form = 'false';
                        ?>
                        <div class="alert alert-danger" class="subscribe-msg">Facing a problem in verifying your email ID? <a href="#" id="resend-subscribe-link" style="color:inherit;text-decoration: underline;">Click here</a> to receive the link again.</div>
                        <?php
                    }
                } else if (isset($_GET['verify_email'])) {
                    $show_form = 'false';
                    ?>
                    <div class="alert alert-danger" class="subscribe-msg">Facing a problem in verifying your email ID? <a href="#" id="resend-subscribe-link" style="color:inherit;text-decoration: underline;">Click here</a> to receive the link again.</div>
                    <?php
                }
                ?>
                </div>

<div class="td-main-content-wrap td-container">
    <div class="tdc-content-wrap <?php echo $td_sidebar_position; ?>">
        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content" role="main">
                <div class="td-ss-main-content">

                    <div class="td-page-content tagdiv-type thank-you-page" style="margin:1% auto 0 auto;">
                        <h1>Congratulations!! You have subscribed for TechVersions Newsletter.  </h1>
                        <p style="font-family: helvetica, sans-serif;font-size:15px;color:#333;margin-top:20px;">You can always manage your newsletter preferences<a href="https://techversions.com/sign-in?redirect_to=https://techversions.com/my-account/email-preferences/"> here.</a></p>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<?php
get_footer();
