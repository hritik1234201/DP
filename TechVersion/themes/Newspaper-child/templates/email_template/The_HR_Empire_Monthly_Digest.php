<?php
require_once ('../../../../../wp-config.php');
//die('Hello');
//newsletter_monthly_func();
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
                    <style type="text/css">

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

                            .head-col1 {
                                width: 100% !important;
                                display: block !important;
                            }
                            .head-col2 {
                                width: 100% !important;
                                display: block !important;
                                text-align: left !important;
                                padding-bottom: 10px !important;
                            }
                            .head-col2 span {
                                left: 0 !important;
                                top: 25px !important;
                            }
                        }
                    </style>
                    <!--End Head user entered-->
                    </head>
                    <body style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;max-width:720px;margin: 0 auto;font-size: 15px;line-height: 28px;color: #333333;font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;">

                        <div lang="en" style="" role="article" aria-label="An email from Your Brand Name">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from Your Brand Name" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 20px 40px 20px;color: #333333;">

                                <table width=100% border=0 style="margin-bottom: 0;">
                                    <tbody>
                                        <tr>
                                            <td class="head-col1" height=50 style="width:100%;padding:10px 0 0 0;width:60%"><img src="https://staging.thehrempire.com/wp-content/uploads/2020/08/TheHREmpire-purpleblack-logo-2.png" alt="The HR Empire" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;margin-bottom: 15px;" />
                                            </td>
                                            <td class="head-col2" height=50 style="width:100%;padding: 0 0 10px 0;width:40%;text-align:right;position: relative;margin: 0;"><h2 class="newsletter-head" style='color:#7F8182;font-size:30px;font-family:Gelasio;margin:0;'>Monthly Digest</h2>
                                                <span style="position: absolute; top:40px;right:0;color: #7F8182;font-size: 12px;" class="float-date">September, 2020</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <?php
                                $email_content = '';
                                //START -- Resources -- Row 2
                                $email_content .= '<table width=100% border=0 style="margin: 0 0 20px 0;background-color:#ebeeef;border-top: 2px solid #4c4084;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Most Downloaded Resources</td>
                                        </tr>
                                    </tbody>
                                </table>';
                                $query = "SELECT * FROM `wp_bnv0rGfv3VUz1uZPDMKp_posts` as p LEFT JOIN wp_bnv0rGfv3VUz1uZPDMKp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . date('Y-m-01') . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('resources') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY p.`post_date` ASC LIMIT 0, 4";

                                $results = $wpdb->get_results($query, OBJECT);

                                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
                                        ';
                                $i = 0;
                                foreach ($results as $result) {
                                    if ($i == 0 || $i == 2) {
                                        $padding = 'padding: 0 15px 0 0';
                                        $email_content .= '<tr style="height: 140px; vertical-align: top;">';
                                    }
                                    if ($i == 1 || $i == 3) {
                                        $padding = 'padding: 0 0 0 15px';
                                    }

                                    $email_content .= '<td style="width: 50%;margin-right:15px;' . $padding . '">'
                                            . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;box-shadow: 1px 1px 6px 2px #eee;" /></a></p>'
                                            . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
                                            . '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:5px;padding:5px 30px;background-color : #4c4084;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
                                            . '</td>';
                                    if ($i == 1 || $i == 3) {
                                        $email_content .= '</tr>';
                                    }
                                    $i++;
                                }
                                $email_content .= '</table>';
                                //END -- Resource ROw -- Row 2

                                $email_content .= '<table width=100% border=0 style="margin: 0px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #4C4084;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Popular Blogs</td>
                                        </tr>
                                    </tbody>
                                </table>';
                                $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Leadership</td>
                                        </tr>
                                    </tbody>
                                </table>';
                                //START -- Blogs - Leadership - Row 3
                                $query = "SELECT * FROM wp_bnv0rGfv3VUz1uZPDMKp_posts p LEFT JOIN wp_bnv0rGfv3VUz1uZPDMKp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' JOIN wp_bnv0rGfv3VUz1uZPDMKp_term_relationships tr ON p.id = tr.object_id AND term_taxonomy_id = 42 WHERE post_date >= '" . date('Y-m-01') . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 1";

                                $result = $wpdb->get_row($query, OBJECT);
                                $i = 0;
                                $total_count = count($results);
                                $shown_sponsored = 'false';

                                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                    <tr style="height: 140px; vertical-align: top;">
                                        <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">';

                                $email_content .= '<a href="' . get_the_permalink($result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '>" title="' . $result->post_title . '" /></a>
                                        </td>';

                                $email_content .= '<td style="padding: 0 0 10px 10px; width:75%">
                                            <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                            <p>';

                                if (!empty($result->post_excerpt)) {
                                    $paragraph = $result->post_excerpt;
                                } else {
                                    $paragraph = '';
                                    $str = $result->post_content;
                                    $str = strip_tags($str);
                                    $paragraph = substr($str, 0, 200);
                                    $paragraph = rtrim($paragraph, '.') . '...';
                                }
                                $para = $paragraph;
                                $email_content .= $para . ' <a style="color:#4C4084;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';

                                $email_content .= "</p>
                                        </td>
                                    </tr>
                                </table>";

                                //START -- Blogs - Learning & Development - Row 3
                                $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Learning & Development</td>
                                        </tr>
                                    </tbody>
                                </table>';
                                $query = "SELECT * FROM wp_bnv0rGfv3VUz1uZPDMKp_posts p LEFT JOIN wp_bnv0rGfv3VUz1uZPDMKp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' JOIN wp_bnv0rGfv3VUz1uZPDMKp_term_relationships tr ON p.id = tr.object_id AND term_taxonomy_id = 43 WHERE post_date >= '" . date('Y-m-01') . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 1";
                                $result = $wpdb->get_row($query, OBJECT);
                                $i = 0;
                                $total_count = count($results);
                                $shown_sponsored = 'false';
                                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                    <tr style="height: 140px; vertical-align: top;">';

                                $email_content .= '<td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;"><a href="' . get_the_permalink($result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '>" title="' . $result->post_title . '" /></a></td>';

                                $email_content .= '<td style=" width:75%;padding: 0 0 10px 10px">
                                            <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                            <p>';

                                if (!empty($result->post_excerpt)) {
                                    $paragraph = $result->post_excerpt;
                                } else {
                                    $paragraph = '';
                                    $str = $result->post_content;
                                    $str = strip_tags($str);
                                    $paragraph = substr($str, 0, 200);
                                    $paragraph = rtrim($paragraph, '.') . '...';
                                }
                                $para = $paragraph;
                                $email_content .= $para . ' <a style="color:#4C4084;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';

                                $email_content .= "</p>
                                        </td>";

                                $email_content .= "</tr>
                                </table>";

                                //START -- Blogs - HR Tech - Row 3
                                $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">HR Tech</td>
                                        </tr>
                                    </tbody>
                                </table>';
                                $query = "SELECT * FROM wp_bnv0rGfv3VUz1uZPDMKp_posts p LEFT JOIN wp_bnv0rGfv3VUz1uZPDMKp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' JOIN wp_bnv0rGfv3VUz1uZPDMKp_term_relationships tr ON p.id = tr.object_id AND term_taxonomy_id = 41 WHERE post_date >= '" . date('Y-m-01') . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 1";
                                $result = $wpdb->get_row($query, OBJECT);
                                $i = 0;
                                $total_count = count($results);
                                $shown_sponsored = 'false';
                                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                    <tr style="height: 140px; vertical-align: top;">
                                        <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">';

                                $email_content .= '<a href="' . get_the_permalink($result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '>" title="' . $result->post_title . '" /></a>
                                        </td>';

                                $email_content .= '<td style="padding: 0 0 10px 10px; width:75%">
                                            <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                            <p>';

                                if (!empty($result->post_excerpt)) {
                                    $paragraph = $result->post_excerpt;
                                } else {
                                    $paragraph = '';
                                    $str = $result->post_content;
                                    $str = strip_tags($str);
                                    $paragraph = substr($str, 0, 200);
                                    $paragraph = rtrim($paragraph, '.') . '...';
                                }
                                $para = $paragraph;
                                $email_content .= $para . ' <a style="color:#4C4084;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';

                                $email_content .= "</p>
                                        </td>
                                    </tr>
                                </table>";

                                //START -- Blogs - HR Legal - Row 3
                                $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">HR Legal</td>
                                        </tr>
                                    </tbody>
                                </table>';
                                $query = "SELECT * FROM wp_bnv0rGfv3VUz1uZPDMKp_posts p LEFT JOIN wp_bnv0rGfv3VUz1uZPDMKp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' JOIN wp_bnv0rGfv3VUz1uZPDMKp_term_relationships tr ON p.id = tr.object_id AND term_taxonomy_id = 44 WHERE post_date >= '" . date('Y-m-01') . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 1";
                                $result = $wpdb->get_row($query, OBJECT);
                                $i = 0;
                                $total_count = count($results);
                                $shown_sponsored = 'false';
                                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                    <tr style="height: 140px; vertical-align: top;">';

                                $email_content .= '<td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;"><a href="' . get_the_permalink($result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'full')) . '" alt="' . $result->post_title . '>" title="' . $result->post_title . '" /></a></td>';

                                $email_content .= '<td style=" width:75%;padding: 0 0 10px 10px">
                                            <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                            <p>';

                                if (!empty($result->post_excerpt)) {
                                    $paragraph = $result->post_excerpt;
                                } else {
                                    $paragraph = '';
                                    $str = $result->post_content;
                                    $str = strip_tags($str);
                                    $paragraph = substr($str, 0, 200);
                                    $paragraph = rtrim($paragraph, '.') . '...';
                                }
                                $para = $paragraph;
                                $email_content .= $para . ' <a style="color:#4C4084;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';

                                $email_content .= "</p>
                                        </td>";

                                $email_content .= "</tr>
                                </table>";
                                $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;padding:5px 30px;background-color : #4c4084;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('reading-list') . '">  Read more Blogs   </a></p></td></tr>
                                </table>';

                                $email_content .= '<table width=100% border=0 style="margin: 30px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #4C4084;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Top News</td>
                                        </tr>
                                    </tbody>
                                </table>';
//                                $email_content .= '<table width=100% border=0 style="margin: 0px 0 20px 0;margin-top:30px">
//                                    <tbody>
//                                        <tr>
//                                            <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Top News</td>
//                                        </tr>
//                                    </tbody>
//                                </table>';
                                $query = "SELECT * FROM wp_bnv0rGfv3VUz1uZPDMKp_posts p LEFT JOIN wp_bnv0rGfv3VUz1uZPDMKp_postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_date >= '" . date('Y-m-01') . "' AND post_date <= '" . date('Y-m-t') . "' AND post_type IN ('news') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 0, 5";
                                $results = $wpdb->get_results($query);

                                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">';

                                foreach ($results as $result) {
                                    $email_content .= '<tr style="vertical-align: top;"><td style=" width:100%;padding: 0">
                                            <p style="margin-top: 0;font-size:20px;color:#4C4084"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p></td></tr>';
//                                    $email_content .= '<tr style="vertical-align: top;"><td style=" width:100%;padding: 0">
//                                            <p style="margin-top: 0;font-size:15px;">Full Story: <a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">Here</a></p></td></tr>';
                                }

                                $email_content .= '</table>';

                                $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #4c4084;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('news') . '">  More News </a></p></td></tr>
                                </table>';

                                echo $email_content;
                                ?>
                                <!-- START --  FOOTER -->

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
                                                <a href="<% asm_group_unsubscribe_raw_url %>" style='color:#4c4084;font-size: 13px;color : #4C4084;font-weight : 600;text-decoration : none;'>Unsubscribe</a>
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