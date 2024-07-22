<?php

if( isset($_GET['preview']) && $_GET['preview'] == 'yes' ){
    add_action( 'wp_loaded','preview2_email_template' );
    
    add_filter( 'wp_mail_content_type', 'set_content_type' );
 
    function set_content_type( $content_type ) {
        return 'text/html';
    }
}


function preview2_email_template(){
    
    /*Change this variables accordingly : comments*/
    $tester_email = 'araspaile@trueinfluence.com';
    $daily_subject = 'Daily Shots';
    $weekly_subject = 'Weekly Bytes';
    $monthly_subject = 'Monthly Brief';
    
    /*Starts newsletter_daily_func : comments*/
    if(isset($_GET['newsletter']) && $_GET['newsletter'] == 'daily'){
        
        global $wpdb;
        $top_news = '';
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 1";
        $result = $wpdb->get_row($query, OBJECT);

        if(!empty($result)){
            
            if ($top_news === '') {
                $top_news = $result->post_title;
            }
            $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="margin:0px 25px;">
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
                                                    <p><a class="link-btn" style="background-color: #04a353;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                                </td>
                                            </tr>
                                        </table>';

        }
    
        //Second Row
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d 11:00', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d 10:59') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 4";
        $results = $wpdb->get_results($query, OBJECT);

        if(!empty($results)){
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
                $email_content .= $para . ' <a  style="color:#04a353;text-decoration:none;font-size:15px;font-weight:400;"  href="' . get_the_permalink($result->ID) . '">Read More</a>';
                $email_content .= '</p>
                                        </td>
                                    </tr>
                                </table>';
            }
        }

        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 5, 3";
        $results = $wpdb->get_results($query, OBJECT);
        
        if(!empty($results)){
            $email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;">
                                <tbody>
                                    <tr>
                                        <td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">In case you missed it</td>
                                    </tr>
                                </tbody>
                            </table>';
        
        
            foreach ($results as $result) {
                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#F2F2F2 !important;">
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
                $email_content .= $para . ' <a style="color:#04a353;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
                $email_content .= '</p>
                                                    </td>
                                                </tr>
                                            </table>';
            }
        }
        /*Ends newsletter_daily_func : comments*/
    
        /*Starts daily newsletter above content HTML : comments*/
        $above_content = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
                            color : #04a353;
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
                            background-color : #04a353;
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
                        .footerlink a {
                            padding-right: 6px;
                        }
                            .footerlink a:after {
                            content: "";
                            position: relative;
                            z-index: 1;
                            border-right: 2px solid #3cac93;
                            /* display: block; */
                            top: 0%;
                            right: 0%;
                            height: 100%;
                            left: 5px !important;
                        }
                        .footerlink a:last-child:after {
                            content: "";
                            border: none;
                        }
                        .social-icon-column a {
                            display: inline-block;  
                            padding-left: 10px;
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

                        <div lang="en" style="" role="article" aria-label="An email from "'.get_bloginfo('name').'">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from '.get_bloginfo('name').'" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 20px 40px 20px;color: #333333;">

                            <table width=100% border=0 style="margin-bottom: 30px;">
                            <tbody>
                                <tr>
                                    <td height=50 style="width:100%;padding: 0 0 0px 0;width:100%;text-align:center"><a href="https://techversions.com/"><img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837.png" alt="TechVersions" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: inline-block;" /></a>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <table width=100% border=0 style="margin-bottom: 30px;border-bottom: 1px solid #ddd">
                        <tbody>
                            <tr>
                                <td height=40 style="width:100%;padding: 0 0 0px 0;width:100%;text-align:center; background:#12a555">
                                <p style="color: #FFFFFF;">08th June Newsletter</p>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                        ';
                /*Ends daily newsletter above content HTML : comments*/
                                
                /*Starts daily newsletter below content HTML : comments*/
                $below_content ='<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 13px !important;color:#FFF;margin-top:20px;padding:5px 40px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 0.5px !important ;height : auto;border-radius : 3px;box-sizing : border-box;text-decoration : none;display : inline-block;font-weight:600" href="{{{news_url}}}">  Read More News   </a></p></td></tr>
                                </table>
                                <!--START - FOOTER-->
                                <table border=0  width="100%" style="table-layout: fixed;background-color: #3c4c41;margin-top:20px">
                                <tbody>
                                    <tr>
                                        <td height=50 style="width:100%;padding: 20px 0 0px 0;width:60%"><a href="https://techversions.com/"><img src="https://techversions.com/assets/TV-Logo-white.png" alt="TechVersions" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;margin:auto" /></a>
                                        </td>
                                       
                                        <td valign="top" style="padding:30px 0 0px 0px" align="center">
                                            <table align="center" style="-webkit-margin-start:auto;-webkit-margin-end:auto;">
                                                <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
                                                            <a role="social-icon-link" href="https://www.facebook.com/techversions" target="_blank" alt="Facebook" title="Facebook" style="">
                                                                <img role="social-icon" alt="Facebook" title="Facebook" src="https://techversions.com/assets/facebook-white.png" />
                                                            </a>
                                                             <a role="social-icon-link" href="https://twitter.com/tech_versions" target="_blank" alt="Twitter" title="Twitter">
                                                                <img role="social-icon" alt="Twitter" title="Twitter" src="https://techversions.com/assets/twitter-white.png" />
                                                            </a>
                                                            <a role="social-icon-link" href="https://www.linkedin.com/company/tech-versions/" target="_blank" alt="LinkedIn" title="LinkedIn">
                                                                <img role="social-icon" alt="LinkedIn" title="LinkedIn" src="https://techversions.com/assets/linkedin-white.png" />
                                                            </a>
                                                        </td></tr></tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tr>
                                </tbody>
                            </table>
                            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#3c4c41;width: 100%">
                            <tr>
                              <td style="padding-top: 0px;padding-bottom: 0px;"><hr style="border: 0;border-top: 2px solid #3CD2B5;    width: 600px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;color:#04a353">

                                    <p class="footerlink">
                                        <a style="font-size: 13px;color : #cdd2cf;font-weight : 600;text-decoration : none;" href="https://techversions.com/contact-us/">Contact Us</a>
                                      
                                        <a style="font-size: 13px;color : #cdd2cf;font-weight : 600;text-decoration : none;" href="https://techversions.com/terms-of-service/">Terms of service</a>

                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="https://anteriad.com/privacy-policy/">Privacy Policy</a>
                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="{{{manage_your_preferences_link}}}" >Manage Your Preferences</a>
                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="<%asm_group_unsubscribe_raw_url%>" >Unsubscribe</a>
                                    </p>
                                    <address style="font-size: 13px; font-style: normal; font-weight: 400; line-height: 24px; color:#cdd2cf;;width: 70%;margin: 30px auto 20px auto;">&copy; {{{curr_year}}} TechVersions c/o Anteriad. All rights reserved.<br/>2 International Drive, Rye Brook, New York 10573, USA</address>
                                    <address style="font-size: 12px; font-style: normal; font-weight: 400; line-height: 24px; color:#cdd2cf;">This newsletter cannot be copied, distributed, or displayed without prior written permission from TechVersions c/o Anteriad.</address>
                                </td>
                            </tr>
                        </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </div>
                    </body>
                </html>';
                /*Ends daily newsletter below content HTML : comments*/
                
            $body = $above_content.$email_content.$below_content;
            
            echo $body;
    
            if(isset($_GET['sendgrid']) && $_GET['sendgrid'] == 'send'){
                
                $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_daily'];
                
                if (!empty($top_news)) {
                    
                    $response = sendgridController::send_newsletter_test($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['daily'], array(
                                'email_content' => $email_content,
                                'current_date' => date('l, F j, Y'),
                                'curr_year' => date('Y'),
                                'brand_name' => get_bloginfo('name'),
                                'newsletter_title' => $daily_subject,
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
            }else{  
                // wp_mail( $tester_email, get_bloginfo('name').' | '.$daily_subject, $body);
            }
        
    }else if(isset($_GET['newsletter']) && $_GET['newsletter'] == 'weekly'){
        
        /*Starts newsletter_weekly_func*/
        
        global $wpdb;
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 0, 1";
        $result = $wpdb->get_row($query, OBJECT);
        $todays_post = $result;


    
        if(!empty($result)){
        
            $email_content .= ' <table width=100% border=0 style="margin-bottom: 30px;border-bottom: 1px solid #ddd">
                        <tbody>
                            <tr>
                                <td height=40 style="width:100%;padding: 0 0 0px 0;width:100%;text-align:center; background:#12a555;box-shadow: 0px 3px 6px #00000029;">
                                <p style="font-size:19px;color:#FFFFFF;font-weight:400;margin:0;padding:10px 0px;">Weekly Round-Up</p>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>';

                    $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="margin:0px 25px;">
                                <tr>
                                    <td>
                                       <h3 style="margin: 0 0 30px 0;text-align: left;font-size: 28px;font-weight:bold;letter-spacing: 0px;color: #12A555;opacity: 1;">Most Happening</h3>
                                    </td>
                                </tr>
                                ';
            $email_content .= '<tr>
                                    <td>
                                        <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                    </td>
                                </tr>

            <tr>
                                    <td style="padding: 10px 0">
                                        <p><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="letter-spacing: 0px;color: #3C4C41;opacity: 1;text-decoration: none;font-weight: inherit;font-size: 24px;">' . $result->post_title . '</a></strong></p>';

            
            $email_content .= '<p>' . $para . '</p>
                                                <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
                                            </td>
                                        </tr>
                                    </table>';
    }

    //Second Row
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 2";
    $results = $wpdb->get_results($query, OBJECT);

    if(!empty($results)){
        
        foreach ($results as $result) {
            $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="margin:0px 25px;">
                                <tr>
                                   
                                </tr>
                                ';
           $email_content .= '<tr>
                                    <td>
                                        <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                    </td>
                                </tr>

            <tr>
                                    <td style="padding: 10px 0">
                                        <p><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="letter-spacing: 0px;color: #3C4C41;opacity: 1;text-decoration: none;font-weight: inherit;font-size: 24px;">' . $result->post_title . '</a></strong></p>';

            
            $email_content .= '<p>' . $para . '</p>
                                                <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
                                            </td>
                                        </tr>
                                    </table>';
        }
    
        // $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center">
        //                                 <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . site_url('news') . '">  Click here for more news  </a></p></td></tr>
        //                             </table>';
    }


    //START -- Resource ROw
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 3";
    $results = $wpdb->get_results($query, OBJECT);
    
    if(count($results) < 3){
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
        $results = $wpdb->get_results($query, OBJECT);
    }

    if(!empty($results)){
        
        $email_content .= '<table width = 100% border = 0 style = "background-color:#F2F2F2;margin: 30px 0;margin-bottom: -1px;">
                        <tbody>
                       
                        <tr>
                        <td style = "width:100%;font-weight: bold;font-size: 28px;padding: 30px 25px 25px;color:#12A555;">Top Resources</td>
                        </tr>
                        </tbody>
                    </table>';
    
        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;background-color:#F2F2F2;">
                                            <tr style="height: 140px; vertical-align: top;">';
        $i = 0;
        foreach ($results as $result) {
           $email_content .= '<td style="width: 33%;margin-right:10px;padding: 0 20px">'
                    . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
                    . '<p style="margin-top: 0px"><strong><a class="text-para" style="text-decoration: none;font-weight: inherit;font-size: inherit;margin-left:0px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
                    . '<p><a class="link-btn" style="width:150px;text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #12A555;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : flex;" href="' . get_the_permalink($result->ID) . '"> <img src="https://techversions.com/assets/Arrow-Icon-White.png" style="margin-left: -9%;
    width: 20px;height: 20px;margin-top: 5%;"><span style="margin-left: 7%;">Download</span></a></p>'
                    . '<p style="padding-bottom:20px;"></p>'
                    . '</td>';
            $i++;
        }
        $email_content .= ' </tr>
                        </table>';
                                        
    }


    //blogs
    //START -- Resource ROw
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 2";
    $results = $wpdb->get_results($query, OBJECT);
    
    // if(count($results) < 3){
    //     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
    //     $results = $wpdb->get_results($query, OBJECT);
    // }

    if(!empty($results)){
        
        $email_content .= '<table width = 100% border = 0 style = "background-color:#FFFFFF;margin: 30px 0;margin-bottom: -1px;">
                        <tbody>
                        <tr>
                        <td style = "width:100%;padding: 0 0 10px 0;font-weight: bold;font-size: 28px;padding: 20px 25px;text-align: left;font-size: 28px;letter-spacing: 0px;color: #12A555;opacity: 1;">Must Read Blogs</td>
                        </tr>
                        </tbody>
                    </table>';
    
        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#FFFFFF;">
                                            <tr style="height: 140px; vertical-align: top;">';
        $i = 0;
        foreach ($results as $result) {
           $email_content .= '<td style="width:50%;margin-right:10px;padding: 0 25px">'
                    . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
                    . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

                    if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 70);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
           
            $email_content .= $para . '</p>
                                                    <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
                                                </td>';

            $i++;
        }
        $email_content .= ' </tr>
                        </table>';
                                        
    }

//START -- Resource ROw
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 2, 2";



    // SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 2";
    $results = $wpdb->get_results($query, OBJECT);
    
    // if(count($results) < 3){
    //     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
    //     $results = $wpdb->get_results($query, OBJECT);
    // }

    if(!empty($results)){
        
       
    
        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#FFFFFF;">
                                            <tr style="height: 140px; vertical-align: top;">';
        $i = 0;
        foreach ($results as $result) {
           $email_content .= '<td style="width:50%;margin-right:10px;padding: 0 25px">'
                    . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
                    . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

                    if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 70);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
           
            $email_content .= $para . '</p>
                                                    <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
                                                </td>';

            $i++;
        }
        $email_content .= ' </tr>
                        </table>';
                                        
    }
    // Must Read Blogs
    // $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "'  AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 0, 3";

    
    /*Ends newsletter_weekly_func*/
    
    /*Starts weekly newsletter above content HTML : comments*/
    $above_content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
                            color : #04a353;
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
                            background-color : #04a353;
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
                        .footerlink a {
                            padding-right: 6px;
                        }
                            .footerlink a:after {
                            content: "";
                            position: relative;
                            z-index: 1;
                            border-right: 2px solid #3cac93;
                            /* display: block; */
                            top: 0%;
                            right: 0%;
                            height: 100%;
                            left: 5px !important;
                        }
                        .social-icon-column a {
                            display: inline-block;  
                            padding-left: 10px;
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

                        <div lang="en" style="" role="article" aria-label="An email from '.get_bloginfo('name').'">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from Your '.get_bloginfo('name').'" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 0px 40px 0px;color: #333333;box-shadow: 0px 3px 6px #00000029;">

                                <table width=100% border=0 style="margin-bottom: 30px;">
                                    <tbody>
                                        <tr>
                                           <td height=50 style="width:100%;padding: 0 0 0px 0;width:100%;text-align:center"><a href="https://techversions.com/"><img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837.png" alt="TechVersions" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: inline-block;" /></a>
                                    </td>
                                        </tr>
                                    </tbody>
                                </table>';
        /*Ends weekly newsletter above content HTML : comments*/
                                
                                
        /*Starts weekly newsletter below content HTML : comments*/
        $below_content = '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                    
                                </table>
                                <!--START - FOOTER-->
                                <table border=0  width="100%" style="table-layout: fixed;background-color: #3c4c41;margin-top:20px">
                                <tbody>
                                    <tr>
                                        <td height=50 style="width:100%;padding: 20px 0px 0px 40px;width:60%"><a href="https://techversions.com/"><img src="https://techversions.com/assets/TV-Logo-white.png" alt="TechVersions" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                        </td>
                                       
                                        <td valign="top" style="padding:30px 0 0px 40px" align="center">
                                            <table align="center" style="-webkit-margin-start:auto;-webkit-margin-end:auto;">
                                                <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
                                                            <a role="social-icon-link" href="https://www.facebook.com/techversions" target="_blank" alt="Facebook" title="Facebook" style="">
                                                                <img role="social-icon" alt="Facebook" title="Facebook" src="https://techversions.com/assets/facebook-white.png" />
                                                            </a>
                                                             <a role="social-icon-link" href="https://twitter.com/tech_versions" target="_blank" alt="Twitter" title="Twitter">
                                                                <img role="social-icon" alt="Twitter" title="Twitter" src="https://techversions.com/assets/twitter-white.png" />
                                                            </a>
                                                            <a role="social-icon-link" href="https://www.linkedin.com/company/tech-versions/" target="_blank" alt="LinkedIn" title="LinkedIn">
                                                                <img role="social-icon" alt="LinkedIn" title="LinkedIn" src="https://techversions.com/assets/linkedin-white.png" />
                                                            </a>
                                                        </td></tr></tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tr>
                                </tbody>
                            </table>
                            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#3c4c41;width: 100%">
                            <tr>
                              <td ><hr style="border: 0;border-top: 2px solid #3CD2B5;    width: 640px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;color:#04a353;padding: 0px 40px 30px;">

                                    <p class="footerlink">
                                        <a style="font-size: 13px;color : #cdd2cf;font-weight : 600;text-decoration : none;" href="https://techversions.com/contact-us/">Contact Us</a>
                                      
                                        <a style="font-size: 13px;color : #cdd2cf;font-weight : 600;text-decoration : none;" href="https://techversions.com/terms-of-service/">Terms of service</a>

                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="https://anteriad.com/privacy-policy/">Privacy Policy</a>
                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="{{{manage_your_preferences_link}}}" >Manage Your Preferences</a>
                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="<%asm_group_unsubscribe_raw_url%>" >Unsubscribe</a>
                                    </p>
                                    <address style="font-size: 14px; font-style: normal; font-weight: bold; line-height: 24px; color:#cdd2cf;;width: 70%;margin: 30px auto 3px auto;">&copy; {{{curr_year}}} TechVersions c/o Anteriad. All rights reserved.</address>
                                    <address style="font-size: 12px; font-style: normal; font-weight: 400; line-height: 24px; color:#cdd2cf;;width: 70%;margin: 0px auto 20px auto;">2 International Drive, Rye Brook, New York 10573, USA</address>
                                    <address style="font-size: 11px; font-style: normal; font-weight: 400; line-height: 24px; color:#cdd2cf;">This newsletter cannot be copied, distributed, or displayed without prior written permission from TechVersions c/o Anteriad.</address>
                                </td>
                            </tr>
                        </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </div>
                    </body>
                </html>';
            /*Ends weekly newsletter below content HTML : comments*/
                    
        $body = $above_content.$email_content.$below_content;
        
        echo $body;
        
        if(isset($_GET['sendgrid']) && $_GET['sendgrid'] == 'send'){
        
        $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_weekly'];

        if (!empty($todays_post)) {
            $response = sendgridController::send_newsletter_test($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['weekly'], array(
                        'email_content' => $email_content,
                        'curr_year' => date('Y'),
                        'brand_name' => get_bloginfo('name'),
                        'newsletter_title' => $weekly_subject,
                        'home_url' => home_url(),
                        'top_news' => $top_news,
                        'privacy_policy_url' => site_url('privacy-policy'),
                        'terms_of_service_url' => site_url('terms-of-service'),
                        'contact_us_url' => site_url('contact-us'),
                        'blogs_url' => site_url('blog'),
                        'facebook_link' => esc_attr(get_option('facebook_link')),
                        'twitter_link' => esc_attr(get_option('twitter_link')),
                        'linkedin_link' =>  esc_attr(get_option('linkedin_link')),
                        'instagram_link' =>  esc_attr(get_option('instagram_link')),
                        "manage_your_preferences_link" => site_url('my-account/email-preferences'),
                            ), 'weekly');
        }
        exit();
        
        }else{
        
            // wp_mail( $tester_email, get_bloginfo('name').' | '.$weekly_subject, $body);
        
        }
    
    }else if(isset($_GET['newsletter']) && $_GET['newsletter'] == 'monthly'){
        
        /*Starts newsletter_monthly_func : comments*/
    
    /*uncomment below 'if' statement when you are putting in functions.php file : comments*/
    /* if (date('Y-m-d') !== date('Y-m-t')) {
        exit(0);
    } */
    
    $start_date = date('Y-m-01');

    global $wpdb;

    //START -- Resources -- Row 1
    $query = "SELECT * FROM {$wpdb->prefix}posts as p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY p.`post_date` ASC LIMIT 0, 4";
    $results = $wpdb->get_results($query, OBJECT);
    
    if(!empty($results)){
        
        $email_content .= '<table width=100% border=0 style="margin: 0 0 20px 0;background-color:#ebeeef;border-top: 2px solid #04a353;">
                            <tbody>
                                <tr>
                                    <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Most Downloaded Resources</td>
                                </tr>
                            </tbody>
                        </table>';

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
                    . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;box-shadow: 1px 1px 6px 2px #eee;border:1px solid #eee;" /></a></p>'
                    . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
                    . '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:5px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . get_the_permalink($result->ID) . '">Download</a></p>'
                    . '</td>';
            if ($i == 1 || $i == 3) {
                $email_content .= '</tr>';
            }
            $i++;
        }
        $email_content .= '</table>';
    //END -- Resource ROW -- Row 1
    
    }
    
    //START -- ROW 2 -- Blogs
    $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 4";
    $result1 = $wpdb->get_results($query, OBJECT);

    $blogs_available = TRUE;
    if (!empty($result1)) {
        $email_content .= '<table width=100% border=0 style="margin: 0px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #04a353;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Popular Blogs</td>
                                        </tr>
                                    </tbody>
                                </table>';
    } else {
        $blogs_available = FALSE;
    }

    if (!empty($result1)) {
        foreach ($result1 as $single_result) {
            $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom:10px;">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">';

            $email_content .= '<a href="' . get_the_permalink($single_result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($single_result->ID, 'one-large')) . '" alt="' . $single_result->post_title . '>" title="' . $single_result->post_title . '" /></a>
                                            </td>';

            $email_content .= '<td style="padding: 0 0 10px 10px; width:75%">
                                                <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($single_result->ID) . '">' . $single_result->post_title . '</a></strong></p>
                                                <p>';

            if (!empty($single_result->post_excerpt)) {
                $paragraph = $single_result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $single_result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 200);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
            $email_content .= $para . ' <a style="color:#04a353;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($single_result->ID) . '">Read More</a>';

            $email_content .= "</p>
                                            </td>
                                        </tr>
                                    </table>";
        }
    }

    if ($blogs_available) {

        $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('reading-list') . '">  Read more Blogs   </a></p></td></tr>
                                </table>';
    }

    $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_date >= '" . $start_date . "' AND post_date <= '" . date('Y-m-t') . "' AND post_type IN ('news') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 0, 5";
    $results = $wpdb->get_results($query);
    
    if(!empty($results)){
        
        $email_content .= '<table width=100% border=0 style="margin: 30px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #04a353;">
                        <tbody>
                            <tr>
                                <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Top News</td>
                            </tr>
                        </tbody>
                    </table>';

        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">';

        foreach ($results as $result) {
            $email_content .= '<tr style="vertical-align: top;"><td style=" width:100%;padding: 0"><p style="margin-top: 0;font-size:20px;color:#04a353"><strong><a class="text-para" style="color: #04a353;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p></td></tr>';
        }

        $email_content .= '</table>';

        $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('news') . '">  More News </a></p></td></tr>
                            </table>';
                        
    }
    
    /*Ends newsletter_monthly_func : comments*/

    /*Starts monthly newsletter above content HTML : comments*/
    
        $above_content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
                            color : #04a353;
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
                            background-color : #04a353;
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
                        .footerlink a {
                            padding-right: 6px;
                        }
                            .footerlink a:after {
                            content: "";
                            position: relative;
                            z-index: 1;
                            border-right: 2px solid #3cac93;
                            /* display: block; */
                            top: 0%;
                            right: 0%;
                            height: 100%;
                            left: 5px !important;
                        }
                        .social-icon-column a {
                            display: inline-block;  
                            padding-left: 10px;
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
                        .cat_featured {
    padding: 15px 40px;
    position: absolute;
    color: #FFF;
    background: #12A555;
    top: 25px;
    z-index: 9;
    left: -12px;
}
.cat_featured:after {
    content: " ";
    position: absolute;
    display: block;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: -1;
    background: #12A555;
    transform-origin: bottom left;
    -ms-transform: skew(-30deg, 0deg);
    -webkit-transform: skew(-30deg, 0deg);
    transform: skew(-30deg, 0deg);
}
                    </style>
                    <!--user entered Head Start-->

                    <!--End Head user entered-->
                    </head>
                    <body style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;max-width:720px;margin: 0 auto;font-size: 15px;line-height: 28px;color: #333333;">

                        <div lang="en" role="article" aria-label="An email from '.get_bloginfo('name').'">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from '.get_bloginfo('name').'" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 0px 40px 0px;color: #333333;box-shadow: 0px 3px 6px #00000029;">


                                <table width=100% border=0 style="margin-bottom: 0;">
                                    <tbody>
                                        <tr>
                                            <td class="head-col1" height=50 style="width:100%;padding: 0 0 0px 0;"><center><img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837-1.png" alt="'.get_bloginfo('name').'" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;margin-bottom: 15px;" /></center>
                                            </td>
                                           
                                        </tr>
                                    </tbody>
                                </table>

                                <table width=100% border=0 style="margin-bottom: 30px;border-bottom: 1px solid #ddd">
                        <tbody>
                            <tr>
                                <td height=40 style="width:100%;padding: 0 0 0px 0;width:100%;text-align:center; background:#12a555;box-shadow: 0px 3px 6px #00000029;">
                                <p style="font-size:19px;color:#FFFFFF;font-weight:400;margin:0;padding:10px 0px;">Monthly</p>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>';
        /*Ends monthly newsletter above content HTML : comments*/

        global $wpdb;
        $top_news = '';
   
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 1";
        $result = $wpdb->get_row($query, OBJECT);

        if(!empty($result)){
            
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
                                                    <p style="text-align:center;"><a class="link-btn" style="background-color: #04a353;color: #FFF;font-size: 18px !important;line-height: 35px !important;width: 160px;text-align: center;letter-spacing: 1px !important;height: auto;border-radius: 20px;padding: 5px 0px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                                </td>
                                            </tr>
                                        </table>';

        }
        
        //START -- Resource ROw
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 3";
    $results = $wpdb->get_results($query, OBJECT);
    
    if(count($results) < 3){
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
        $results = $wpdb->get_results($query, OBJECT);
    }

    if(!empty($results)){
        
        $email_content .= '<table width = 100% border = 0 style = "background-color:#F2F2F2;margin: 30px 0;margin-bottom: -1px;">
                        <tbody>
                       
                        <tr>
                        <td style = "width:100%;font-weight: bold;font-size: 28px;padding: 30px 25px 25px;color:#12A555;">Top Resources</td>
                        </tr>
                        </tbody>
                    </table>';
    
        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;background-color:#F2F2F2;">
                                            <tr style="height: 140px; vertical-align: top;">';
        $i = 0;
        foreach ($results as $result) {
           $email_content .= '<td style="width: 33%;margin-right:10px;padding: 0 20px">'
                    . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
                    . '<p style="margin-top: 0px"><strong><a class="text-para" style="text-decoration: none;font-weight: inherit;font-size: inherit;margin-left:0px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
                    . '<p><a class="link-btn" style="width:150px;text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #12A555;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : flex;" href="' . get_the_permalink($result->ID) . '"> <img src="https://techversions.com/assets/Arrow-Icon-White.png" style="margin-left: -9%;
    width: 20px;height: 20px;margin-top: 5%;"><span style="margin-left: 7%;">Download</span></a></p>'
                    . '<p style="padding-bottom:20px;"></p>'
                    . '</td>';
            $i++;
        }
        $email_content .= ' </tr>
                        </table>';
                                        
    }

    //blogs
    //START -- Resource ROw
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 2";
    $results = $wpdb->get_results($query, OBJECT);
    
    // if(count($results) < 3){
    //     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
    //     $results = $wpdb->get_results($query, OBJECT);
    // }

    if(!empty($results)){
        
        $email_content .= '<table width = 100% border = 0 style = "background-color:#FFFFFF;margin: 30px 0;margin-bottom: -1px;">
                        <tbody>
                        <tr>
                        <td style = "width:100%;padding: 0 0 10px 0;font-weight: bold;font-size: 28px;padding: 20px 25px;text-align: left;font-size: 28px;letter-spacing: 0px;color: #12A555;opacity: 1;">Must Read Blogs</td>
                        </tr>
                        </tbody>
                    </table>';
    
        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#FFFFFF;">
                                            <tr style="height: 140px; vertical-align: top;">';
        $i = 0;
        foreach ($results as $result) {
           $email_content .= '<td style="width:50%;margin-right:10px;padding: 0 25px">'
                    . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
                    . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

                    if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 70);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
           
            $email_content .= $para . '</p>
                                                    <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
                                                </td>';

            $i++;
        }
        $email_content .= ' </tr>
                        </table>';
                                        
    }

//START -- Resource ROw
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 2, 2";



    // SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 2";
    $results = $wpdb->get_results($query, OBJECT);
    
    // if(count($results) < 3){
    //     $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
    //     $results = $wpdb->get_results($query, OBJECT);
    // }

    if(!empty($results)){
        
       
    
        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#FFFFFF;">
                                            <tr style="height: 140px; vertical-align: top;">';
        $i = 0;
        foreach ($results as $result) {
           $email_content .= '<td style="width:50%;margin-right:10px;padding: 0 25px">'
                    . '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
                    . '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>';

                    if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 70);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
           
            $email_content .= $para . '</p>
                                                    <p><a class="link-btn" style="background-color: #FFFFFF;color: #0D0128;font-size: 16px !important;padding:0px;letter-spacing: 0px !important;font-weight:400;line-height: 35px !important;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More <img src="https://techversions.com/assets/Arrow-icon1.png" style="width:20px;float: right;padding-left: 10px;padding-top: 8px;"></a></p>
                                                </td>';

            $i++;
        }
        $email_content .= ' </tr>
                        </table>';
                                        
    }
        

        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 9, 4";
        $results = $wpdb->get_results($query, OBJECT);
        
        if(!empty($results)){
            $email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;background-color:#F2F2F2;">
                                <tbody>
                                    <tr>
                                        <td style="width:100%;padding: 20px 0 30px 33px;font-weight: bold;font-size: 28px; color: #0D0128;">In case you missed it</td>
                                    </tr>
                                </tbody>
                            </table>';
        
        
            foreach ($results as $result) {
                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color:#F2F2F2;margin-top: -3%;">
                                        <tr style="vertical-align: top;">
                                            <td style="width: 10%;padding: 5px 0px 25px 45px;vertical-align: top;">
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="https://techversions.com/assets/increase.png" alt="increase" title="increase" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                            </td>
                                            <td style="padding: 0 0 20px 10px; width:90%">
                                                <p style="margin: 0 0 25px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: 400;font-size: 20px;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
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
                //$para = $paragraph;
                //$email_content .=  ' <a style="color:#04a353;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
                $email_content .= '</p>
                                                    </td>
                                                </tr>
                                            </table>';
            }
        }
        /*Starts monthly newsletter below content HTML : comments*/                             
        $below_content = ' <table border="0" width="100%" style="margin-top: -7%;width:100%; text-align: center;background-color:#F2F2F2;padding-bottom:20px;">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 18px !important;color:#FFF;margin-top:20px;padding:10px 60px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 0.5px !important ;height : auto;border-radius : 50px;box-sizing : border-box;text-decoration : none;display : inline-block;font-weight:600" href="{{{news_url}}}">  Explore More   </a></p></td></tr>
                                </table>

                                <table border="0" width="100%" style="width:100%; text-align: center;background-color:#F2F2F2;padding-bottom:20px;">
                                    <tr><td><p></p></td></tr>
                                </table>

         <!--START - FOOTER-->
        <!--START - FOOTER-->
                               
                                <table border=0  width="100%" style="table-layout: fixed;background-color: #3c4c41;">
                                <tbody>
                                    <tr>
                                        <td height=50 style="width:100%;padding: 20px 0px 0px 40px;width:60%"><a href="https://techversions.com/"><img src="https://techversions.com/assets/TV-Logo-white.png" alt="TechVersions" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                        </td>
                                       
                                        <td valign="top" style="padding:30px 0 0px 40px" align="center">
                                            <table align="center" style="-webkit-margin-start:auto;-webkit-margin-end:auto;">
                                                <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
                                                            <a role="social-icon-link" href="https://www.facebook.com/techversions" target="_blank" alt="Facebook" title="Facebook" style="">
                                                                <img role="social-icon" alt="Facebook" title="Facebook" src="https://techversions.com/assets/facebook-white.png" />
                                                            </a>
                                                             <a role="social-icon-link" href="https://twitter.com/tech_versions" target="_blank" alt="Twitter" title="Twitter">
                                                                <img role="social-icon" alt="Twitter" title="Twitter" src="https://techversions.com/assets/twitter-white.png" />
                                                            </a>
                                                            <a role="social-icon-link" href="https://www.linkedin.com/company/tech-versions/" target="_blank" alt="LinkedIn" title="LinkedIn">
                                                                <img role="social-icon" alt="LinkedIn" title="LinkedIn" src="https://techversions.com/assets/linkedin-white.png" />
                                                            </a>
                                                        </td></tr></tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tr>
                                </tbody>
                            </table>
                            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#3c4c41;width: 100%">
                            <tr>
                              <td ><hr style="border: 0;border-top: 2px solid #3CD2B5;    width: 640px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;color:#04a353;padding: 0px 40px 30px;">

                                    <p class="footerlink">
                                        <a style="font-size: 13px;color : #cdd2cf;font-weight : 600;text-decoration : none;" href="https://techversions.com/contact-us/">Contact Us</a>
                                      
                                        <a style="font-size: 13px;color : #cdd2cf;font-weight : 600;text-decoration : none;" href="https://techversions.com/terms-of-service/">Terms of service</a>

                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="https://anteriad.com/privacy-policy/">Privacy Policy</a>
                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="{{{manage_your_preferences_link}}}" >Manage Your Preferences</a>
                                        <a style="font-size: 13px;color :#cdd2cf;font-weight : 600;text-decoration : none;" href="<%asm_group_unsubscribe_raw_url%>" >Unsubscribe</a>
                                    </p>
                                    <address style="font-size: 14px; font-style: normal; font-weight: bold; line-height: 24px; color:#cdd2cf;;width: 70%;margin: 30px auto 3px auto;">&copy; {{{curr_year}}} TechVersions c/o Anteriad. All rights reserved.</address>
                                    <address style="font-size: 12px; font-style: normal; font-weight: 400; line-height: 24px; color:#cdd2cf;;width: 70%;margin: 0px auto 20px auto;">2 International Drive, Rye Brook, New York 10573, USA</address>
                                    <address style="font-size: 11px; font-style: normal; font-weight: 400; line-height: 24px; color:#cdd2cf;">This newsletter cannot be copied, distributed, or displayed without prior written permission from TechVersions c/o Anteriad.</address>
                                </td>
                            </tr>
                        </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </div>
                    </body>
                    </html>';
                    
        /*Ends monthly newsletter above content HTML : comments*/
        
        $body = $above_content.$email_content.$below_content;
        
        echo $body;
        
        if(isset($_GET['sendgrid']) && $_GET['sendgrid'] == 'send'){
                
            $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_monthly'];
            $response = sendgridController::send_newsletter_test($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['monthly'], array(
                    'email_content' => $email_content,
                    'brand_name' => get_bloginfo('name'),
                    'home_url' => home_url(),
                    'newsletter_title' => $monthly_subject,
                    'top_news' => $top_news,
                    'privacy_policy_url' => site_url('privacy-policy'),
                    'terms_of_service_url' => site_url('terms-of-service'),
                    'contact_us_url' => site_url('contact-us'),
                    'blogs_url' => site_url('blogs'),
                    'facebook_link' => esc_attr(get_option('facebook_link')),
                    'twitter_link' => esc_attr(get_option('twitter_link')),
                    'linkedin_link' =>  esc_attr(get_option('linkedin_link')),
                    'instagram_link' =>  esc_attr(get_option('instagram_link')),
                    'month' => date('F') . ', ' . date('Y'),
                    'curr_year' => date('Y'),
                    'manage_your_preferences_link' => site_url('my-account/email-preferences'),
                ), 'monthly');

            exit();
        
        }else{
        
            // wp_mail( $tester_email, get_bloginfo('name').' | '.$monthly_subject, $body );
        
        }
        
    }else{
        
        echo '<h2>Please select a newsletter to preview and send</h2><br>';
        
    }   
    
    exit;
}

?>