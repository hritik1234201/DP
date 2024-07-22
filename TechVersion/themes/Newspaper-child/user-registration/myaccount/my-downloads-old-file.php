<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
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
                    <h2><?php _e('My Downloads', 'user-registration'); ?></h2>
                    <?php
                    global $wpdb;
                    $curr_user = wp_get_current_user();
                    $downloads = $wpdb->get_results(""
                            . "SELECT sdm.post_id as smd_post_id,p.id as post_id,sdm.post_title,date_time,p.post_type,sdm.visitor_ip "
                            . "FROM wp_bnv0rGfv3VUz1uZPDMKp_sdm_downloads as sdm "
                            . "LEFT JOIN wp_bnv0rGfv3VUz1uZPDMKp_posts p ON sdm.post_title = p.post_title "
                            . "WHERE visitor_name LIKE '{$curr_user->user_login}' AND post_status LIKE 'publish' AND post_type NOT LIKE 'sdm_downloads' "
                            . "GROUP BY sdm.id "
                            . "ORDER BY sdm.id DESC;"
                    );
                    ?>
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th width="30%">Asset Name</th>
                                <th width="15%" title="Marketing Collaterals" alt="Marketing Collaterals">Asset Type</th>
                                <th width="15%">Category</th>
                                <th width="15%">IP Address</th>
                                <th width="15%">Location</th>
                                <th width="10%">Downloaded On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($downloads as $download) {
//                                $url = "https://tools.keycdn.com/geo.json?host={$login->ip_address}";
                                $url = "http://ipwhois.app/json/{$download->visitor_ip}";
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
                                
                                $post_types = get_post_type_object( $download->post_type );
                                $categories = get_the_terms($download->post_id, rtrim($post_types->name,'s')."_categories");
                                $cat_arr = array();
                                foreach ($categories as $category) {
                                    $cat_arr[$category->name] = $category->name;
                                }
                            ?>
                                <tr>
                                    <td class="text-left"><a href="<?php the_permalink($download->post_id); ?>"><?php echo $download->post_title; ?></a></td>
                                    <td class="text-left"><?php echo $post_types->labels->singular_name ?></td>
                                    <td class="text-left"><?php echo (isset($categories) && !empty($categories)) ? implode(', ',$cat_arr) : '-'; ?></td>
                                    <td class="text-left"><?php echo $download->visitor_ip ?></td>
                                    <td class="text-left"><?php echo $json['city'].', '.$json['region'].', '.$json['country']; ?></td>
                                    <td class="text-left"><?php 
                                        $userTimezone = new DateTimeZone($json['timezone']);
                                        $gmtTimezone = new DateTimeZone('UTC');
                                        $myDateTime = new DateTime($download->date_time, $gmtTimezone);
                                        $offset = $userTimezone->getOffset($myDateTime);
                                        $myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
                                        $myDateTime->add($myInterval);
                                        $result = $myDateTime->format('F d, Y H:i');
                                        echo $result;
//                                    echo date('F d, Y H:i',strtotime($download->date_time)); ?>
                                    </td>
                                </tr>
                            <?php } ?>
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
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#table_id').DataTable({
            "order": [[ 5, "desc" ]]
        });
    });
</script>
