<?php require_once ('../../../../../wp-config.php'); ?>
<div lang="en" style="background-color: white; color: #2b2b2b; font-family: 'Source Sans Pro',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 28px; margin: 0 auto; max-width: 720px; padding: 40px 20px 40px 20px;" role="article" aria-label="An email from Your Brand Name">

        <style type=text/css>
            body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
            table, td{mso-table-lspace:0;mso-table-rspace:0}
            img{-ms-interpolation-mode:bicubic}
            img{border:0;height:auto;line-height:100%;outline:0;text-decoration:none}
            table{border-collapse:collapse!important}
            body{height:100%!important;margin:0!important;padding:0!important;width:100%!important}
            a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
            u+#body a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}
            #MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}a{color:#4C4084;font-weight:600;text-decoration:underline}
            a:hover{color:#000000;text-decoration:none!important}
            @media screen and (min-width:600px){
                h1{font-size:48px!important;line-height:48px!important}
                .intro{font-size:24px!important;line-height:36px!important}
            }
            .h-resize20px {height:20px !important; }
            .lh40 {line-height:40px !important}
            .text32 {font-size:32px !important}
            .w-resize85 {width:85% !important; }
            .main-div {
                color:#2b2b2b;
                font-family:Source Sans Pro,Roboto,Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
                font-size:18px;
                font-weight:400;
                line-height:28px;
                margin:0 auto;
                padding:40px 20px 40px 20px;
            }

            .main-div, table {                
                max-width:720px;
            }

            .brand-logo {

                text-align:center;
            }
            .main-div .email-title{
                text-align:center;
                color:#2b2b2b;font-family: serif;
            }
            .main-div img {
                max-width: 100%;
            }
            .link-btn {
                background-color: #4c4084;
                color: #FFF;
                /*font-family: Source Sans Pro !important;*/
                font-size: 11px !important;
                line-height: 35px !important;
                letter-spacing: 1px !important;
                height: auto;
                border-radius: 1px;
                padding: 0 16px;
                box-sizing: border-box;
                text-decoration: none;
                display: inline-block;
            }
            .link-btn:hover {
                color: #FFF;
            }
            
            a.text-para {
                color: inherit;
                text-decoration: none;
                font-weight: inherit;
                font-size: inherit;
            }

        </style>
        <?php
        global $wpdb;
//$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options WHERE option_id = 1", OBJECT );
////        $wpdb->query( 
////            $wpdb->prepare( 
////                "SELECT * FROM $wpdb->posts WHERE post_type IN (posts, news, resources) WHERE post_date = '%s'",
////                date('Y-m-d'),
////            );
////        );
        $query = "SELECT * FROM `wp_posts` WHERE post_date >= '" . date('Y-m-d') . "' AND post_date < '" . date('Y-m-d', strtotime('+1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `wp_posts`.`post_date` DESC";
        $results = $wpdb->get_results($query, OBJECT);
//        echo '<pre>';
//        print_r("SELECT * FROM {$wpdb->prefix}posts WHERE post_type IN (posts, news, resources)");
//        echo '</pre>';
//        echo '<pre>';
//        print_r($query);
//        echo '</pre>';
//        echo '<pre>';
//        print_r($results);
//        echo '</pre>';
//        die();
        ?>

        <!--[if (gte mso 9)|(IE)]>
        <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
        <![endif]-->
        <div role=article aria-label="An email from Your Brand Name" lang=en class="main-div">

            <table width=100% border=0>
                <tbody>
                    <tr>
                        <td height=30 class="brand-logo"><img src="https://staging.thehrempire.com/wp-content/uploads/2020/08/TheHREmpire-purpleblack-logo-2.png" width="278" height="56" alt="The HR Empire"/></td>
                    </tr>
                    <tr>
                        <td height=15><h2 class="email-title" style="margin-bottom: 5px;">The HR Daily</h2></td>
                    </tr>
                    <tr>
                        <td><h3 class="email-title" style="margin-top: 0"><?php echo date('l, F j, Y'); ?></h3></td>
                    </tr>
                    <tr>
                        <td height=0></td>
                    </tr>
                </tbody>
            </table>
            <?php
            $i = 0;
            $total_count = count($results);
            $shown_sponsored = 'false';
            foreach ($results as $result) {
                ?>
                <table border="0" cellspacing="0" cellpadding="0" style="background-color:#eee; width: 100%">

                    <tr>
                        <td>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url($result->ID, 'full')) ?>" alt="<?php echo $result->post_title; ?>" title="<?php echo $result->post_title; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 30px">
                            <p><strong><?php echo '<a class="text-para" href="'.get_the_permalink($result->ID).'">'.$result->post_title.'</a>'; ?></strong></p>
                            <p><?php
                                if (!empty($result->post_excerpt)) {
                                    echo '<a class="text-para" href="'.get_the_permalink($result->ID).'">'.$result->post_excerpt.'</a>';
                                } else {
                                    $paragraph = '';
                                    $str = wpautop($result->post_content);
                                    $str = substr($str, 0, strpos($str, '</p>') + 6);
                                    $str = strip_tags($str, '<a><strong><em>');
                                    $paragraph .= '<p>' . $str . '</p>';

                                    echo '<a class="text-para" href="'.get_the_permalink($result->ID).'">'.$paragraph.'</a>';
                                }
                                ?></p>
                            <p><a class="link-btn" href="<?php echo get_the_permalink($result->ID); ?>"> Read More </a></p>
                        </td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;">
                    <tr>
                        <td>&nbsp;
                        </td>
                    </tr>
                </table>
                <?php
                $i++;
                if (($total_count / 2 == $i || $i == $total_count) && $shown_sponsored == 'false') {
                    $query = new WP_Query(array('post_type' => 'resources', 'tax_query' => array(
                            array(
                                'taxonomy' => 'post_tag',
                                'field' => 'slug',
                                'terms' => 'coronavirus',
                            ),
                            'posts_per_page' => 1
                    )));
                    $post = $query->posts[0];
                    ?>
                    <table border="0" cellspacing="0" cellpadding="0" style="background-color:#eee;width: 100%">
                        <tr>
                            <td style="">
                                <h2 style="font-size:25px;font-weight:bold;color:#fff;padding: 30px;background-color: #4c4084;margin: 0"">
                                    Sponsored Content
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 30px;display: flex;align-items: center;">
                                <!--<p style="background-color: #4c4084; color: #FFF;">Sponsored Content</p>-->
                                <p style="width: 30%;"><a class="text-para" href="<?php echo get_the_permalink($post->ID); ?>"> <img src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')) ?>" /></a></p>
                                <p style="padding: 0 20px;width: 65%"><strong><?php echo '<a class="text-para" href="'.get_the_permalink($post->ID).'">'.$post->post_title.'</a>'; ?></strong></p>

                            </td>
                        </tr>
                    </table>

                    <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;">
                        <tr>
                            <td>&nbsp;
                            </td>
                        </tr>
                    </table>
                    <?php
                    $shown_sponsored = 'true';
                }
            }
            ?>
            <!--Read more stories on TechCrunch.coma-->
            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;width: 100%">
                <tr>
                    <td style="text-align: center;"><a href="<?php echo home_url(); ?>">Read More on thehrempire.com</a></td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;">
                <tr>
                    <td>&nbsp;
                    </td>
                </tr>
            </table>
            <table border="0" width="100%" bgcolor="#EBEEEF">
                <tbody>
                    <tr>
                        <td>
                            <table border="0" width="96%" align="center">
                                <tbody>
                                    <tr>
                                        <td><footer style="color: #373939;margin-top: 20px"><!-- This link uses descriptive text to inform the user what will happen with the link is tapped. -->
                                                <!-- It also uses inline styles since some email clients won't render embedded styles from the head. -->
                                                <p style="font-size: 14px; font-weight: 400; line-height: 24px; margin-top: 0px; font-family: 'Source Sans Pro'; text-align: left;"><a style="color: #373939; text-decoration: underline;" href="https://thehrempire.com/privacy-policy/">Privacy Policy</a> | <a style="color: #373939; text-decoration: underline;" href="https://thehrempire.com/terms-of-service/">Terms of service</a> | <a style="color: #373939; text-decoration: underline;" href="https://thehrempire.com/contact-us/">Contact Us</a></p>
                                                <!-- The address element does exactly what it says. By default, it is block-level and italicizes text. You can override this behavior inline. -->

                                                <address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; font-family: Source Sans Pro;">Copyright &copy; 2020 The HR Empire. All rights reserved.</address><address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; font-family: 'Source Sans Pro';">Our address is 8000 Towers Crescent Drive, 13th Floor, Vienna,VA 22182, USA</address><address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; padding-top: 10px; font-family: 'Source Sans Pro';">This cannot be copied, distributed, or displayed without prior written permission from The HR Empire</address></footer></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--[if (gte mso 9)|(IE)]>
        </td></tr></table>
        <![endif]-->
</div>