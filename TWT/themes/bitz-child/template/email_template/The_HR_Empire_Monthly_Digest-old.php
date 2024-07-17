<?php
require_once ('../../../../../wp-config.php');
//newsletter_daily_func();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
                <!--[if !mso]><!-->
                <meta http-equiv="X-UA-Compatible" content="IE=Edge">
                    <!--<![endif]-->
                    <!--[if (gte mso 9)|(IE)]>
                    <xml>
                      <o:OfficeDocumentSettings>
                        <o:AllowPNG/>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                      </o:OfficeDocumentSettings>
                    </xml>
                    <![endif]-->
                    <!--[if (gte mso 9)|(IE)]>
                <style type="text/css">
                  body {width: 600px;margin: 0 auto;}
                  table {border-collapse: collapse;}
                  table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
                  img {-ms-interpolation-mode: bicubic;}
                </style>
              <![endif]-->
                    <!--user entered Head Start-->

                    <!--End Head user entered-->
                    </head>
                    <body style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;max-width:720px;margin: 0 auto;font-size: 15px;line-height: 28px;color: #333333;">

                        <div lang="en" style="" role="article" aria-label="An email from Your Brand Name">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from Your Brand Name" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 20px 40px 20px;color: #333333;">

                                <table width=100% border=0 style="margin-bottom: 30px;border-bottom: 1px solid #ddd">
                                    <tbody>
                                        <tr>
                                            <td height=50 style="width:100%;padding: 0 0 0px 0;width:60%"><img src="https://staging.thehrempire.com/wp-content/uploads/2020/08/TheHREmpire-purpleblack-logo-2.png" alt="The HR Empire" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" />
                                            </td>
                                            <td height=50 style="width:100%;padding: 0 0 0px 0;width:40%;text-align:right;"><h2 style='color:#7F8182;font-size:30px;font-family:Gelasio'>Monthly Digest</h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <!-- {{{email_content}}} -->
                                
                                <?php
                                
                                $email_content = '';
                                
                                $query = "SELECT * FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_date >= '" . date('Y-m-1',strtotime('-1 month')) . "' AND post_date <= '" . date('Y-m-1') . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 0, 1";
//                                SELECT * FROM `wp_posts` p LEFT JOIN wp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE "post_views_count" WHERE post_date >= '2020-08-24' AND post_date <= '2020-09-24' AND post_type IN ('news') AND post_status = 'publish' ORDER BY pm.meta_value DESC, post_date DESC LIMIT 0, 5
                                
                                $result = $wpdb->get_row($query, OBJECT);
//                                $todays_post = $result;
//                                foreach($results as $result) {
                                $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                    <tr>
                                        <td>
                                            <h3 style="margin: 0 0 5px 0;font-size: 20px;">Highlight of Month</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="'.get_the_permalink($result->ID).'"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="'.esc_url(get_the_post_thumbnail_url($result->ID, 'full')).'" alt="'.$result->post_title.'" title="'.$result->post_title.'" /></a>
                                        </td>
                                    </tr>';
                                    
                                    $email_content .= '<tr>
                                        <td style="padding: 10px 0">
                                            <p><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

                                    if (!empty($result->post_excerpt)) {
                                        $paragraph = $result->post_excerpt;
                                    } else {
                                        $paragraph = '';
                                        $str = wpautop($result->post_content);
                                        $str = substr($str, 0, strpos($str, '</p>') + 6);
                                        $str = strip_tags($str, '<a><strong><em><br><br/>');
                                        $paragraph = '<p>' . $str . '</p>';
                                    }
                                    $para = substr($paragraph, 0, 300);
                                    $para = (strlen($paragraph) == 300) ? $para : $para . '...';
                                    $email_content .= '<p>'.$para.'</p>';
                                               
                                    $email_content .= '<p><a class="link-btn" style="background-color: #4c4084;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="'.get_the_permalink($result->ID).'"> Read More </a></p>
                                        </td>
                                    </tr>
                                </table>';
//                                }
                                
                                $query = "SELECT * FROM wp_posts p LEFT JOIN wp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_date >= '" . date('Y-m-1',strtotime('-1 month')) . "' AND post_date <= '" . date('Y-m-1') . "' AND post_type IN ('resources') AND post_status = 'publish' ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 0, 4";
//                                SELECT * FROM `wp_posts` p LEFT JOIN wp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE "post_views_count" WHERE post_date >= '2020-08-24' AND post_date <= '2020-09-24' AND post_type IN ('news') AND post_status = 'publish' ORDER BY pm.meta_value DESC, post_date DESC LIMIT 0, 5
                                
                                $results = $wpdb->get_results($query, OBJECT);
                                $todays_post = $result;
                                $i = 1;
                                foreach($results as $result) {
                                $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                    <tr>
                                        <td>
                                            <h3 style="margin: 0 0 5px 0;font-size: 20px;">Highlight of Week '.$i.'</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="'.get_the_permalink($result->ID).'"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="'.esc_url(get_the_post_thumbnail_url($result->ID, 'full')).'" alt="'.$result->post_title.'" title="'.$result->post_title.'" /></a>
                                        </td>
                                    </tr>';
                                    
                                    $email_content .= '<tr>
                                        <td style="padding: 10px 0">
                                            <p><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

                                    if (!empty($result->post_excerpt)) {
                                        $paragraph = $result->post_excerpt;
                                    } else {
                                        $paragraph = '';
                                        $str = wpautop($result->post_content);
                                        $str = substr($str, 0, strpos($str, '</p>') + 6);
                                        $str = strip_tags($str, '<a><strong><em><br><br/>');
                                        $paragraph = '<p>' . $str . '</p>';
                                    }
                                    $para = substr($paragraph, 0, 300);
                                    $para = (strlen($paragraph) == 300) ? $para : $para . '...';
                                    $email_content .= '<p>'.$para.'</p>';
                                               
                                    $email_content .= '<p><a class="link-btn" style="background-color: #4c4084;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="'.get_the_permalink($result->ID).'"> Read More </a></p>
                                        </td>
                                    </tr>
                                </table>';
                                    $i++;
                                }
                                echo $email_content;
                                
                                $query = "SELECT * FROM `wp_posts` WHERE post_date >= '" . date('Y-m-d') . "' AND post_date < '" . date('Y-m-d', strtotime('+1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_posts`.`post_date` DESC LIMIT 1, 4";
                                $results = $wpdb->get_results($query, OBJECT);
                                $i = 0;
                                $total_count = count($results);
                                $shown_sponsored = 'false';
                                foreach ($results as $result) {
                                    ?>
                                    <table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                <a href="<?php echo get_the_permalink($result->ID); ?>"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="<?php echo esc_url(get_the_post_thumbnail_url($result->ID, 'full')) ?>" alt="<?php echo $result->post_title; ?>" title="<?php echo $result->post_title; ?>" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:75%">
                                                <p style="margin-top: 0"><strong><?php echo '<a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a>'; ?></strong></p>
                                                <p><?php
                                                    if (!empty($result->post_excerpt)) {
                                                        $paragraph = $result->post_excerpt;
                                                    } else {
                                                        $paragraph = '';
                                                        $str = wpautop($result->post_content);
                                                        $str = substr($str, 0, strpos($str, '</p>') + 6);
                                                        $str = strip_tags($str, '<a><strong><em>');
                                                        $paragraph = '<p>' . $str . '</p>';
                                                    }
                                                    $para = substr($paragraph, 0, 50);
                                                    echo (strlen($paragraph) == 50) ? $para . ' <a style="color:#4C4084;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>' : $para . '...' . ' <a style="font-size:16px;font-weight:400;color:#4C4084;font-weight:600;text-decoration:none; href="' . get_the_permalink($result->ID) . '">Read More</a>';
                                                    ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                ?>

                                <table width=100% border=0 style="margin: 30px 0;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">In case you missed it</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                $query = "SELECT * FROM `wp_posts` WHERE post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_posts`.`post_date` DESC LIMIT 5, 3";
                                $results = $wpdb->get_results($query, OBJECT);
                                $i = 0;
                                $total_count = count($results);
                                $shown_sponsored = 'false';
                                foreach ($results as $result) {
                                    ?>
                                    <table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                <a href="<?php echo get_the_permalink($result->ID); ?>"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="<?php echo esc_url(get_the_post_thumbnail_url($result->ID, 'full')) ?>" alt="<?php echo $result->post_title; ?>" title="<?php echo $result->post_title; ?>" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:75%">
                                                <p style="margin-top: 0"><strong><?php echo '<a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a>'; ?></strong></p>
                                                <p><?php
                                                    if (!empty($result->post_excerpt)) {
                                                        $paragraph = $result->post_excerpt;
                                                    } else {
                                                        $paragraph = '';
                                                        $str = wpautop($result->post_content);
                                                        $str = substr($str, 0, strpos($str, '</p>') + 6);
                                                        $str = strip_tags($str, '<a><strong><em>');
                                                        $paragraph = '<p>' . $str . '</p>';
                                                    }
                                                    $para = substr($paragraph, 0, 50);
                                                    echo (strlen($paragraph) == 50) ? $para . ' <a style="color:#4C4084;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>' : $para . '...' . ' <a style="color:#4C4084;font-weight:600;text-decoration:none;font-size:16px;font-weight:400" href="' . get_the_permalink($result->ID) . '">Read More</a>';
                                                    ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                ?>
                                <!-- START --  FOOTER -->
                                <table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #4c4084;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="{{{home_url}}}">  Read more news   </a></p></td></tr>
                                </table>
                                <table class="module" role="module" data-type="social" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;background-color: #ebeeef;margin-top:20px " data-muid="74ca2758-9d56-4d9f-971a-e02b9cc8d326">
                                    <tbody>
                                    
                                        <tr>
                                        <td><h3 style="text-align:center;color:#4C4084;margin:10px 0 20px 0;padding:20px 0px 0px 0px;">Follow us on</h3></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="" align="center">
                                                <table align="center" style="-webkit-margin-start:auto;-webkit-margin-end:auto;">
                                                    <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://www.facebook.com/thehrempire/" target="_blank" alt="Facebook" title="Facebook" style="">
                                                                    <img role="social-icon" alt="Facebook" title="Facebook" src="https://thehrempire.com/assets/facebook.png" />
                                                                </a>
                                                            </td><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://twitter.com/thehrempire" target="_blank" alt="Twitter" title="Twitter">
                                                                    <img role="social-icon" alt="Twitter" title="Twitter" src="https://thehrempire.com/assets/twitter.png" />
                                                                </a>
                                                            </td><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://www.linkedin.com/company/thehrempire" target="_blank" alt="LinkedIn" title="LinkedIn">
                                                                    <img role="social-icon" alt="LinkedIn" title="LinkedIn" src="https://thehrempire.com/assets/linkedin.png" />
                                                                </a>
                                                            </td></tr></tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table border="0" cellspacing="0" cellpadding="10" style="background-color:#ebeeef;width: 100%">
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;color:#4c4084">

                                            <p>
                                                <a style="color:#4c4084;font-size: 13px;color : #4C4084;font-weight : 600;text-decoration : none;" href="{{{contact_us_url}}}">Contact Us</a>
                                                <br />
                                                <a style="color:#4c4084;font-size: 13px;color : #4C4084;font-weight : 600;text-decoration : none;" href="{{{terms_of_service_url}}}">Terms of service</a>
                                                <br/>
                                                <a style="color:#4c4084;font-size: 13px;color : #4C4084;font-weight : 600;text-decoration : none;" href="{{{privacy_policy_url}}}">Privacy Policy</a>
                                                <br/>
                                                <a href='{{{manage_your_preferences_link}}}' style='color:#4c4084;font-size: 13px;color : #4C4084;font-weight : 600;text-decoration : none;'>Manage Your Preferences</a>
                                                <br/>
                                                <a href="<%asm_group_unsubscribe_raw_url%>" style='color:#4c4084;font-size: 13px;color : #4C4084;font-weight : 600;text-decoration : none;'>Unsubscribe</a>
                                            </p>
                                            <address style="font-size: 13px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182;width: 70%;margin: 30px auto 20px auto;">&copy; 2020 The HR Empire. All rights reserved.<br/> 8000 Towers Crescent Drive, 13th Floor, Vienna,VA 22182, USA</address>
                                            <address style="font-size: 12px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182">This newsletter cannot be copied, distributed, or displayed without prior written permission from The HR Empire.</address>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </div>
                    </body>
                    </html>