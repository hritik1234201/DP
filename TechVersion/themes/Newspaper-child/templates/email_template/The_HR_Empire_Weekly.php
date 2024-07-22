<?php
require_once ('../../../../../wp-config.php');
//newsletter_weekly_func();
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
                    <style type="text/css">
                        * {
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                            color : #333333;
                        }
                        h3 {
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                        }
                        body {
                            max-width : 720px;
                            margin : 0 auto;
                        }
                        body, table, td, a {
                            font-size : 15px;
                            line-height : 28px;
                        }
                        img {
                            border : 0;
                            height : auto;
                            line-height : 100%;
                            outline : 0;
                            text-decoration : none;
                        }
                        table {
                            border-collapse : collapse !important ;
                        }
                        a[x-apple-data-detectors] {
                            color : inherit !important ;
                            text-decoration : none !important ;
                            font-size : inherit !important ;
                            font-family : inherit !important ;
                            font-weight : inherit !important ;
                            line-height : inherit !important ;
                        }
                        a {
                            color : #4C4084;
                            font-weight : 600;
                            text-decoration : none;
                        }
                        a:hover {
                            color : #000000;
                            text-decoration : underline !important ;
                        }
                        .main-div {
                            color : #2b2b2b;
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                            font-size : 18px;
                            font-weight : 400;
                            line-height : 28px;
                            margin : 0 auto;
                            padding : 0 20px 40px 20px;
                        }
                        .main-div, table {
                            max-width : 720px;
                        }
                        .main-div .email-title {
                            text-align : center;
                            color : #2b2b2b;
                            font-family : serif;
                        }
                        img {
                            max-width : 100%;
                            max-height : 100%;
                            display : block;
                        }
                        .link-btn {
                            background-color : #4c4084;
                            color : #FFF;
                            font-size : 11px !important ;
                            line-height : 35px !important ;
                            letter-spacing : 1px !important ;
                            height : auto;
                            border-radius : 1px;
                            padding : 0 16px;
                            box-sizing : border-box;
                            text-decoration : none;
                            display : inline-block;
                        }
                        .link-btn:hover {
                            color : #FFF;
                        }
                        a.text-para {
                            color : inherit;
                            text-decoration : none;
                            font-weight : inherit;
                            font-size : inherit;
                        }
                        @media screen and (min-width: 600px) {
                            h1 {
                                font-size : 48px !important ;
                                line-height : 48px !important ;
                            }
                            .intro {
                                font-size : 24px !important ;
                                line-height : 36px !important ;
                            }
                        }
                        @media screen and (max-width: 600px) {
                            .single-row-news td {
                                width : 100% !important ;
                                display : block;
                                padding : 0 !important ;
                            }
                            .single-row-news {
                                margin-bottom : 20px;
                            }
                        }
                    </style>
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
                                            <td height=50 style="width:100%;padding: 0 0 0px 0;width:40%;text-align:right;"><h2 style='color:#7F8182;font-size:25px;font-family:Gelasio'>Weekly Round-up</h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- {{{email_content}}} -->
                                <?php
                                $query = "SELECT * FROM `wp_bnv0rGfv3VUz1uZPDMKp_posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_bnv0rGfv3VUz1uZPDMKp_posts`.`post_date` DESC LIMIT 0, 1";
                                $result = $wpdb->get_row($query, OBJECT);

                                $todays_post = $result;
                                $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
<tr>
                                            <td>
                                               <h3 style="margin: 0 0 5px 0;font-size: 20px;">Top News</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" /></a>
                                            </td>
                                        </tr>';

                                $email_content .= '<tr>
                                            <td style="padding: 10px 0">
                                                <p><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                                <p>';

                                if (!empty($result->post_excerpt)) {
                                    $paragraph = $result->post_excerpt;
                                } else {
                                    $paragraph = '';
                                    $str = wpautop($result->post_content);
                                    $str = substr($str, 0, strpos($str, '</p>') + 6);
                                    $str = strip_tags($str, '<a><strong><em>');
                                    $paragraph = $str;
                                    $paragraph = substr($paragraph, 0, 300);
                                }
                                $para = $paragraph;
                                $email_content .= (strlen($paragraph) == 300) ? $para : $para . '...' . '</p>
                                                <p><a class="link-btn" style="color:#FFF;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                            </td>
                                        </tr>
                                    </table>';

                                //Second Row
                                $query = "SELECT * FROM `wp_bnv0rGfv3VUz1uZPDMKp_posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_bnv0rGfv3VUz1uZPDMKp_posts`.`post_date` DESC LIMIT 1, 4";
                                $results = $wpdb->get_results($query, OBJECT);

                                foreach ($results as $result) {
                                    $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:75%">
                                                <p style="margin: 0 0 5px 0"><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                                <p style="margin-top: 0">';
                                    if (!empty($result->post_excerpt)) {
                                        $paragraph = $result->post_excerpt;
                                    } else {
                                        $paragraph = '';
                                        $str = $result->post_content;
//                                        $str = substr($str, 0, strpos($str, '</p>') + 6);
                                        $str = strip_tags($str, '<a><strong><em>');
                                        $paragraph = $str;
                                    }
                                    $para = (strlen($paragraph) == 100) ? substr($paragraph, 0, 100) : substr($paragraph, 0, 100) . '...';
                                    $email_content .= $para . ' <a style="font-size:16px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
                                    $email_content .= '</p>
                                            </td>
                                        </tr>
                                    </table>';
                                }                                
                                
                                $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;" href="{{{news_url}}}">  Click here for more news  </a></p></td></tr>
                                </table>';

                                //START -- Resource ROw
                                $email_content .= '<table width = 100% border = 0 style = "margin: 30px 0;margin-bottom: 20px;">
                                    <tbody>
                                    <tr>
                                    <td style = "width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Top Resources</td>
                                    </tr>
                                    </tbody>
                                    </table>';

                                $query = "SELECT * FROM `wp_bnv0rGfv3VUz1uZPDMKp_posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('resources') AND post_status = 'publish' ORDER BY `wp_bnv0rGfv3VUz1uZPDMKp_posts`.`post_date` DESC LIMIT 1, 3";
                                $results = $wpdb->get_results($query, OBJECT);
                                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
                                        <tr style="height: 140px; vertical-align: top;">';
                                $i = 0;
                                foreach ($results as $result) {
//                                    $style = ($i === 1) ? '' : '';
                                    $email_content .= '<td style="width: 33%;margin-right:10px;padding: 0 10px' . $style . '">'
                                            . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" /></a></p>'
                                            . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
                                            . '<p><a class="link-btn" href="' . get_the_permalink($result->ID) . '">Download Now</a></p>'
                                            . '</td>';
                                    $i++;
                                }
                                $email_content .= ' </tr>
                                    </table>';
                                
//                                $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center">
//                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;" href="{{{resources_url}}}">  For more such Resources visit us on thehrempire.com  </a></p></td></tr>
//                                </table>';

                                //END -- Resource ROw

                                $email_content .= '<table width = 100% border = 0 style = "margin: 30px 0;margin-bottom: 20px;">
                                    <tbody>
                                    <tr>
                                    <td style = "width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Must read Blogs</td>
                                    </tr>
                                    </tbody>
                                    </table>';
                                
                                
                                ?>

                                <?php
//                                $email_content = '';
                                $query = "SELECT * FROM `wp_bnv0rGfv3VUz1uZPDMKp_posts` WHERE post_type IN ('post') AND post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "'  AND post_status = 'publish' ORDER BY `wp_bnv0rGfv3VUz1uZPDMKp_posts`.`post_date` DESC LIMIT 0, 3";
                                $results = $wpdb->get_results($query, OBJECT);
                                foreach ($results as $result) {
                                    $email_content .= '<table class = "single-row-news" border = "0" cellspacing = "0" cellpadding = "0" style = "width: 100%">
                                    <tr style = "height: 140px; vertical-align: top;">
                                    <td style = "width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                    <a href = "' . get_the_permalink($result->ID) . '"><img src = "' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt = "' . $result->post_title . '" title = "' . $result->post_title . '" /></a>
                                    </td>
                                    <td style = "padding: 0 0 10px 10px; width:75%">
                                    <p style = "margin: 0 0 5px 0"><strong><a class = "text-para" href = "' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                    <p style = "margin-top: 0">';
                                    if (!empty($result->post_excerpt)) {
                                        $paragraph = $result->post_excerpt;
                                    } else {
                                        $paragraph = '';
                                        $str = wpautop($result->post_content);
                                        $str = substr($str, 0, strpos($str, '</p>') + 6);
                                        $str = strip_tags($str, '<a><strong><em>');
                                        $paragraph = $str;
                                    }
                                    $para = (strlen($paragraph) == 100) ? substr($paragraph, 0, 100) : substr($paragraph, 0, 100) . '...';
                                    $email_content .= $para . ' <a style = "font-size:16px;font-weight:400;" href = "' . get_the_permalink($result->ID) . '">Read More</a>';
                                    $email_content .= '</p>
                                    </td>
                                    </tr>
                                    </table>';
                                }
                                echo $email_content;
                                ?>

                                <!-- START --  FOOTER -->
                                <table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #4c4084;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="{{{blogs_url}}}">  Check out more blogs  </a></p></td></tr>
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