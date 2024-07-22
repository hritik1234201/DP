<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchPanes.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">-->
<!--<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>-->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/user-registration/myaccount/form-edit-profile.php.
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
if (!defined('ABSPATH')) {
    exit;
}
?>

<!--<div class="ur-frontend-form login" id="ur-frontend-form">-->
    <form class="user-registration-downloads my-downloads" action="" method="post" enctype="multipart/form-data">
        <div class="ur-form-row">
            <div class="ur-form-grid">
                <div class="user-registration-profile-fields">
                    <h2><?php _e('Login History', 'user-registration'); ?></h2>
                    <?php
                    global $wpdb;
                    $curr_user = wp_get_current_user();
                    $logins = $wpdb->get_results(""
                            . "SELECT * "
                            . "FROM wp_bnv0rGfv3VUz1uZPDMKp_fa_user_logins as logins "
                            . "WHERE user_id LIKE '{$curr_user->ID}' ORDER BY id DESC;"
                    );
//                    if($curr_user->ID == 138) {
//                        echo '<pre>';
//                        print_r($logins);
//                        echo '</pre>';
//                    }
                            
                    $registered = $wpdb->get_row(""
                            . "SELECT user_registered "
                            . "FROM wp_bnv0rGfv3VUz1uZPDMKp_users "
                            . "WHERE ID LIKE '{$curr_user->ID}';"
                    );
                    ?>
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th width="30%">Date & Time</th>
                                <th width="15%">Source</th>
                                <th width="10%">Status</th>
                                <th width="20%">IP Address</th>
                                <th width="25%">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($logins)) {
                            foreach($logins as $login) { 
//                                $url = "https://tools.keycdn.com/geo.json?host={$login->ip_address}";
                                $url = "http://ipwhois.app/json/{$login->ip_address}";
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
                            ?>
                                <tr>
                                    <td class="text-left"><?php 
                                        $userTimezone = new DateTimeZone($json['timezone']);
                                        $gmtTimezone = new DateTimeZone('UTC');
                                        $myDateTime = new DateTime($login->time_login, $gmtTimezone);
                                        $offset = $userTimezone->getOffset($myDateTime);
                                        $myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
                                        $myDateTime->add($myInterval);
                                        $result = $myDateTime->format('Y-m-d H:i:s');
                                        echo $result;
                                    ?></td>
                                    <td class="text-left"><?php 
                                    $os = (strtolower($login->operating_system) != 'android' && strtolower($login->operating_system) != 'ios' && strtolower($login->operating_system) != 'iphone') ? 'Web' : $login->operating_system;
                                    echo ($login->browser == $os) ? ((strpos($login->user_agent,"safari") >= 0) ? "Safari, {$os}" : $os) : $login->browser.', '.$os; ?></td>
                                    <td class="text-left"><?php echo ($login->login_status == 'login' || $login->login_status == 'logout') ? 'Login' : 'Logged Out'; ?></td>
                                    <td class="text-left"><?php echo $login->ip_address; ?></td>
                                    <td class="text-left"><?php echo $json['city'].', '.$json['region'].', '.$json['country']; ?></td>
                                </tr>
                            <?php }
                            } ?>
                                
                                <tr>
                                    <td class="text-left"><?php 
                                        $timezone = (isset($json['data'])) ? $json['timezone'] : 'UTC';
                                        $userTimezone = new DateTimeZone($timezone);
                                        $gmtTimezone = new DateTimeZone('UTC');
                                        $myDateTime = new DateTime($registered->user_registered, $gmtTimezone);
                                        $offset = $userTimezone->getOffset($myDateTime);
                                        $myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
                                        $myDateTime->add($myInterval);
                                        $result = $myDateTime->format('Y-m-d H:i:s');
                                        echo $result;
                                    ?></td>
                                    <td class="text-left"><?php 
                                    $os = (strtolower($login->operating_system) != 'android' || strtolower($login->operating_system) == 'ios') ? 'Web' : $login->operating_system;
                                    echo (isset($login->browser)) ? $login->browser.', '.$os : $os; ?></td>
                                    <td class="text-left"><?php echo 'Registered'; ?></td>
                                    <td class="text-left"><?php echo (isset($login->ip_address)) ? $login->ip_address : '-'; ?></td>
                                    <td class="text-left"><?php echo (isset($json['data'])) ? $json['city'].', '.$json['region'].', '.$json['country'] : '-'; ?></td>
                                </tr>
                        </tbody>
                    </table>
                    
                    <div style="margin-top: 30px;text-align: left">
                    <?php 
                    echo "<span style='font-size:14px;line-height:17px'><p style='margin-bottom:0;'>Please <a target='_blank' href='".site_url('contact-us')."'>contact us</a> if you have any policy-related (<a target='_blank' href='".site_url('gdpr-general-data-protection-regulation')."'>GDPR</a> or <a target='_blank' href='".site_url('california-do-not-sell-my-personal-information')."'>CCPA</a>) or your personal data-related questions or if you want us to delete your information.</p><p>We will respond within our standard policy guidelines.</p>"
                    ?>
                    </div>
                </div>
            </div>

        </div>
    </form>
<!--</div>-->
<!--<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#table_id').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>-->

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#table_id').DataTable({
            "responsive": true,
            "order": [[0, "desc"]],
            "fnDrawCallback": function () {
                if (jQuery('#table_id_paginate span a.paginate_button').size() > 1) {
                    jQuery('#table_id_paginate')[0].style.display = "block";
                } else {
                    jQuery('#table_id_paginate')[0].style.display = "none";
                }
            }
        });
    });
</script>
