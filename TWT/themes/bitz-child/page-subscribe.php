<?php
/*
 * Template Name: Subscribe Page Template
 */
if (is_user_logged_in() && !is_admin()) {
    wp_redirect(home_url());
    exit;
}

get_header();


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


<style>
input[type="checkbox"]{    margin-top: -3px;}
    .on {
        margin-top: 40px;
        color: black;
        text-align: center;
        font-weight:400;
    }

    .off {
        display: none;
        appearance: none;
        color: rgba(0, 0, 0, .8);
        font-weight:400;
    }

    input:checked ~ .on {
        display: none;
        font-weight:400;
    }

    input:checked ~ .off {
        display: contents;
        font-weight:400;
    }
    /* input::placeholder {
        padding-left: 25px;
    } */

    .subs_validate_email {
        padding-left: 15px;
    }

    @media only screen and (min-width:320px) and (max-width: 600px){

        #subscribe-same-col{
            display:block !important;
        }
        #textbox-field{
            width:100% !important;
            margin-bottom:20px !important;
        }
        #sub-button-filed{
            width:100% !important;
        }
    }

</style>













<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" /> -->
<div class="ur-form-row">
    <div class="ur-form-grid subscribe-content-block">
        <div class="text-center" style="">
            <h2 style="text-align: center;font-size: 32px;font-weight: 700;">Subscribe to TechWeb Trends Newsletter</h2>
            <!--<h5 style="text-align: center;font-size: 28px;font-weight: 500;margin-bottom: 10px;">The Unbelievably Easy Way To know about Top TechWeb Trends Regularly</h5>-->
            <p style='text-align:center;font-size:22px;'>To receive your personalized newsletter, manage your newsletter preference, here. </p>
        </div>
        <form id="subscription-form" class="" style="" >
            <div class="preference-block td-pb-row">
                <!--<p style='font-weight:bold;padding: 10px 24px;'>To receive your personalized newsletter, manage your newsletter preference, here.</p>-->
                <?php
                foreach ($user_groups as $single_group) {
                    ?>
                    <!-- <div class="vc_col-lg-8 vc_col-md-8 vc_col-sm-8 unsub-group td-pb-span12"> -->
                    <div class="unsub-group td-pb-span12">
                        <div class="child-unsub-group">
                            <div class="group-content">
                                <div class="grp-row1">
                                    <h3 style="margin-bottom: 0px;"><?php echo sendgridController::SG_UNSUBSCRIBE_TITLE[$single_group->id]; ?></h3>
                                </div>
                                <div class="grp-row2">
                                    <p style="margin-bottom:8px;"><?php echo sendgridController::SG_UNSUBSCRIBE_GROUP_DESC[$single_group->id]; ?></p>
                                </div>
                            </div>
                            <div class="custom-control custom-switch">
                                <!--<input type="checkbox" <?php //echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || ($suppressed != 1)) ? 'checked' : '';  ?> name="<?php //echo $single_group->id;  ?>" class="custom-control-input" id="customSwitches-<?php //echo $single_group->id;  ?>" >-->
								
								
								<!--<input type="checkbox" <?php echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || ($suppressed != 1)) ? 'checked' : ''; ?> name="<?php echo $single_group->id; ?>" class="custom-control-input" id="customSwitches-<?php echo $single_group->id; ?>" >-->



    <!-- <label class="custom-control-label switch" for="customSwitches-<?php //echo $single_group->id;  ?>">
    <input type="checkbox" <?php //echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || (isset($_GET['email_id']) && !empty($_GET['email_id']) && isset($updated_groups[$single_group->id]) && $updated_groups[$single_group->id]->suppressed != 1)) ? 'checked' : '';  ?> name="<?php //echo $single_group->id;  ?>" class="custom-control-input" id="customSwitches-<?php //echo $single_group->id;  ?>" /><span class="slider round"></span></label> <span style="margin-top:5px;">DELIVERY IS 
    <label for="permitted" class="side-label">I am legally permitted to submit forms</label>
    <div class="blocked">(you have to check the checkbox to continue)</div>
    <button>Submit</button> </span> -->



                                                            <!-- <input type="checkbox" <?php //echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || (isset($_GET['email_id']) && !empty($_GET['email_id']) && isset($updated_groups[$single_group->id]) && $updated_groups[$single_group->id]->suppressed != 1)) ? 'checked' : '';  ?> name="<?php //echo $single_group->id;  ?>" class="custom-control-input" id="customSwitches-<?php //echo $single_group->id;  ?>" /> <span style="margin-top:5px;">DELIVERY IS 
                                                            <label for="permitted" class="side-label">I am legally permitted to submit forms</label>
    <div class="blocked">(you have to check the checkbox to continue)</div>
    <button>Submit</button> </span> -->

                                <!-- <section class="custom-control custom-switch">

                                    <label><input type="checkbox" name="checkbox" <?php //echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || (isset($_GET['email_id']) && !empty($_GET['email_id']) && isset($updated_groups[$single_group->id]) && $updated_groups[$single_group->id]->suppressed != 1)) ? 'checked' : ''; ?> name="<?php //echo $single_group->id; ?>" class="custom-control-input" id="customSwitches-<?php //echo $single_group->id; ?>" value="value">Delivery is<span class="on"> OFF</span> <span class="off"> ON <span style="color:#c53f45">✔ YOU'RE SUBSCRIBED</span></span> </label><br>
								</section>	-->
									
									


    <!-- <input type="checkbox" <?php //echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || (isset($_GET['email_id']) && !empty($_GET['email_id']) && isset($updated_groups[$single_group->id]) && $updated_groups[$single_group->id]->suppressed != 1)) ? 'checked' : '';  ?> name="<?php //echo $single_group->id;  ?>" class="custom-control-input" id="customSwitches-<?php //echo $single_group->id;  ?>" />
    <label for="permitted" class="side-label">DELIVERY IS </label> <span class="on">OFF</span> <span class="off">ON <span style="color:#c53f45">✔ YOU'RE SUBSCRIBED</span></span> -->
                                


 <div class="custom-control custom-switch">
                                <!--<input type="checkbox" <?php echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || ($suppressed != 1)) ? 'checked' : ''; ?> name="<?php echo $single_group->id; ?>" class="custom-control-input" id="customSwitches-<?php echo $single_group->id; ?>" >-->
                                <input type="checkbox" <?php echo ((!isset($_GET['email_id']) && $single_group->is_default == 1) || (isset($_GET['email_id']) && !empty($_GET['email_id']) && isset($updated_groups[$single_group->id]) && $updated_groups[$single_group->id]->suppressed != 1)) ? 'checked' : ''; ?> name="<?php echo $single_group->id; ?>" class="custom-control-input" style="margin-right: 7px !important;" id="customSwitches-<?php echo $single_group->id; ?>" />Delivery is<span class="on"> Off</span> <span class="off"> On <!-- <span style="color:#c53f45">✔ YOU'RE SUBSCRIBED</span> --> </span>
                                <label class="custom-control-label" for="customSwitches-<?php echo $single_group->id; ?>"></label>
                            </div>



                            </div>



                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="clearfix"></div>
            </div>

            <!--	<div class="vc_col-lg-4 vc_col-md-4 vc_col-sm-4">
                    </div> -->


            <div class="subscribe-form-block wdform_row">
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
                            <div class="alert alert-success" class="subscribe-msg">Thank you for your confirmation. You have successfully subscribed to our newsletter(s). Please check your email for further details.</div>
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
                <div id="form" style="<?php echo ($show_form === 'true') ? '' : 'display:none;' ?> ">
                    <div style="" class="subscribe-btn-div">
<?php
$query = "SELECT id,verified FROM subscriptions WHERE email_id LIKE '{$email_id}' ORDER BY id DESC";

$sub_query = $wpdb->get_row($query);
?>
                        <p style='margin-bottom: 20px;'>Be the first one to access all the latest updates and insights of the Tech world.
                        </p>
                        <div class='btn-row' id="subscribe-same-col">
                            <div id="textbox-field" class="subscribe-fields">
                                <input type="email" name="email" placeholder="Enter your business mail address" style="width:100%" class="subs_validate_email" value="<?php echo (isset($_GET['email_id']) && !empty($_GET['email_id'])) ? $email_id : ''; ?>" <?php echo (isset($_GET['email_id'])) ? 'readonly=readonly' : ''; ?> />
<?php
//                                                        echo '<pre>';
//                                                        print_r($_SERVER);
//                                                        echo '</pre>';
//                                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
////check ip from share internet
//                                    $ip = $_SERVER['HTTP_CLIENT_IP'];
//                                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
////to check ip is pass from proxy
//                                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//                                } else {
//                                    $ip = $_SERVER['REMOTE_ADDR'];
//                                }     



$ip = getenv('HTTP_CLIENT_IP') ?:
                                        getenv('HTTP_X_FORWARDED_FOR') ?:
                                        getenv('HTTP_X_FORWARDED') ?:
                                        getenv('HTTP_FORWARDED_FOR') ?:
                                        getenv('HTTP_FORWARDED') ?:
                                        getenv('REMOTE_ADDR');

                               
                                ?>
                                <input type="hidden" name="ip_address" value="<?php echo $ip; ?>" />
                                <input type="hidden" name="subscription_id" value="<?php echo $sub_query->id; ?>" />
                                <div id="validate_email_error_1" class="subscribe-error" style="display:none;"></div>
                            </div>
							
							<div id="sub-button-filed">
<?php if (isset($_GET['email_id'])) { ?>
                                    <button type="button" style="width: 100%;" id="subscribe-update-btn" class="edit-subscribe-btn"><i class="fa fa-envelope-open-o"></i>&nbsp; Update my preferences</button>
                                <?php } else { ?>
                                    <button type="button" style="width: 100%;" class="for-hide" id="subscribe-btn" class=""><i class="fa fa-envelope-open-o"></i>&nbsp; Subscribe Now</button>
                                <?php } ?>
                            </div>
                        </div>
                        <input type="hidden" name="all_groups" value="<?php echo base64_encode(serialize($user_groups)); ?>" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
  fbq('track', 'Subscribe');
</script>

<script>
    var checkBoxes = jQuery('.custom-control-input');
    checkBoxes.change(function () {
        jQuery('#sub-button-filed').prop('disabled', checkBoxes.filter(':checked').length < 1);
        jQuery('.subs_validate_email').prop('readonly', checkBoxes.filter(':checked').length < 1);
    });
    jQuery('.custom-control-input').change();


    if(jQuery( ".custom-control-input:checked" ).length > 1)
    {
        jQuery('#subscribe-btn').prop('disabled', false);
    }

</script>

<?php
get_footer();
