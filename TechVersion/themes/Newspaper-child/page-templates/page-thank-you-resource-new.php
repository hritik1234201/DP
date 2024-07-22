<?php
/* Template Name: Thank You Page - Resource - New */
global $current_user;

get_header();

$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';

if(!isset($_GET['r_id']) || empty($_GET['r_id'])) {
    wp_redirect(home_url());
}

if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
    $_SESSION['typ_redirect'] = 'true';
    wp_redirect(get_the_permalink($resource_id));
}
$_SESSION['form_submission'] = 'false';

global $wpdb;
$myposts = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = $resource_id AND post_status LIKE 'publish' AND (post_type NOT LIKE 'attachment' AND post_type NOT LIKE 'sdm_downloads' AND post_type NOT LIKE 'revision');");

$download_resource_id = get_post_meta($myposts->ID, 'sdm_description', true);
if (!empty($download_resource_id)) {
    $download = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}sdm_downloads WHERE post_id = {$download_resource_id} ORDER BY id DESC;");
}

$show_related_resources = get_post_meta($myposts->ID, 'show_related_resources', true);

if($show_related_resources == 'false'){ ?>
    <style type="text/css">
    #td-related-row{
        display:none;
    }
</style> 
<?php  }

$show_header_footer = get_post_meta($myposts->ID, 'show_header_footer', true);

if($show_header_footer == 'false'){?>
 <style type="text/css">
     /* check the class or id and add it here according to your theme */
    #header{
        display:none;
    }
    #footer{
        display:none;
    }
</style> 
<?php }
$post_types = get_post_type_object($myposts->post_type);
$post_type = $post_types->labels->singular_name;

$categories = get_the_terms($myposts->ID, 'resource_types');
$category = array_pop($categories);

$resource_title = $myposts->post_title;

$pdf_link = (isset($_GET['thankyoupage_pdflink']) && !empty($_GET['thankyoupage_pdflink'])) ? base64_decode(urldecode($_GET['thankyoupage_pdflink'])) : '';
$thankyoupage_asset = (isset($_GET['thankyoupage_asset']) && !empty($_GET['thankyoupage_asset'])) ? base64_decode(urldecode($_GET['thankyoupage_asset'])) : '';
$thankyoupage_redirecturl = (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) ? base64_decode(urldecode($_GET['redirect_url'])) : '';
?>

<div class="td-main-content-wrap td-container-wrap" style="font-family:Muli !important">
    <div class="tdc-content-wrap <?php echo $td_sidebar_position; ?>">
        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content" role="main">
                <div class="td-ss-main-content">

                    <div class="td-page-content tagdiv-type thank-you-page" style="margin:1% auto 2% auto;">
                        <?php
                        if (have_posts()) {
                            while (have_posts()) : the_post();
                                ?>

                                <!-- START -  Row 2-->
                                <div style="margin: 0 auto;width:100%; border-bottom: 1px solid #e1e1e1; box-shadow: 0px 3px 4px #e1e1e1;">
                                    <!-- <h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:Muli;">
                                        Thanks for your interest in our <?php echo $post_type; ?> titled<br />"<?php echo $myposts->post_title; ?>"
                                    </h1> -->

                                    <div class="thanks-msg-div" style="">
                                        <div class="inner-div">
                                            <p class="msg-interest" style="">
                                                Thanks for your interest in our <?php echo $category->name; ?> titled</p>
                                            <p class="msg-resource-title" class="" style="">
                                                "<?php echo $myposts->post_title; ?>"</p>
                                        </div>
                                        <!-- <p style="margin:0 0 10px 0;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> Your download will start automatically in <span id="timer">0 seconds</span>...<br>
                                        If your download does not start automatically, <a href="<?php echo (isset($download)) ? $download->file_url : '#'; ?>" target="_blank" style="text-decoration:underline">click here</a> to start your download. </p> -->
                                    <?php if (!empty($thankyoupage_redirecturl)) { ?>
                                        <p style="margin:0 0 10px 0;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> You will be redirected automatically in <span id="timer">0 seconds</span>...<br>
                                            If you are not redirected automatically, <a href="<?php echo $thankyoupage_redirecturl; ?>" target="_blank" style="text-decoration:underline">click here</a> to go to the page. </p>
                                        <?php }elseif ($thankyoupage_asset !== '') { ?>
                                        <div style="margin:30px auto; text-align: center;">
                                            <iframe src = "<?php echo $thankyoupage_asset; ?>" width="1000" height="560" style="background-color: #FFF;"/>
                                        </div>
                                    <?php } else { ?>
                                        <p style="margin:0 0 10px 0;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> Your download will start automatically in <span id="timer">0 seconds</span>...<br>
                                            If your download does not start automatically, <a href="<?php echo (isset($download)) ? $download->file_url : '#'; ?>" target="_blank" style="text-decoration:underline">click here</a> to start your download. </p>
                                    <?php } ?>                                    
                                </div>
                                <!-- END -  Row 2-->
                                <!-- START -  Row 3-->
                                <div class="td-related-row" id="td-related-row">
                                    <!--<h4>Related Posts</h4>-->
                                    <div class="tdb-block-inner td-fix-index resources-heading">
                                        <h4 class="tdb-title-text">Related Resources</h4>
                                        <div></div>
                                        <div class="tdb-title-line"></div>   
                                    </div>

                                    <div class="clearfix related-parent-row">
                                        <?php $related = get_posts(array('post_type' => 'resources', 'numberposts' => 3, 'exclude' => array($resource_id))); ?>
                                        <style type="text/css">
                                            .td-related-row {
                                                width: 1400px;
                                                margin: 30px auto 20px auto;
                                            }
                                            .row2 {
                                                margin-top: 50px;
                                            }
                                            .td-related-row .resources-heading {
                                                margin-left: 24px;
                                                margin-bottom: 20px;
                                            }
                                            .td-related-row .td-related-span3 img {
                                                width: 100%;
                                                height: 180px;
                                                margin-bottom: 0;
                                            }
                                            .td-related-row .td-related-span3 h3 {
                                                font-size: 20px;
                                            }

                                            /*                                .td-related-row .td-related-span3 p a{
                                                                                color: #37393A;
                                                                            }
                                            
                                                                            .td-related-row .td-related-span3 p a:hover{
                                                                                color: #4c4084;
                                                                            }*/
                                        </style>
                                        <?php
                                        if ($related) {
                                            foreach ($related as $single_post) {
                                                ?>
                                                <div class="td-related-span3">
                                                    <div class="td_module_related_posts td-animation-stack td_mod_related_posts"><div class="td-module-image">
                                                            <div class="td-module-thumb">
                                                                <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" class="td-image-wrap" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal">
                                                                    <img class="entry-thumb td-animation-stack-type0-2" 
                                                                         src="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" 
                                                                         alt="<?php echo $single_post->post_title; ?>" 
                                                                         title="<?php echo $single_post->post_title; ?>" 
                                                                         data-type="image_tag" 
                                                                         data-img-url="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" 
                                                                         width="218" height="150" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="item-details">
                                                            <h3 class="entry-title td-module-title">
                                                                <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" 
                                                                   title="<?php echo $single_post->post_title; ?>" 
                                                                   data-wpel-link="internal"><?php echo $single_post->post_title; ?></a>
                                                            </h3>
                                                            <!--<p class="entry-title td-module-title" style="text-align: left;"><a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal"><?php echo $single_post->post_title; ?></a></p>-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- END -  Row 3-->
                                <?php
                            endwhile; //end loop
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div> <!-- /.td-pb-row -->
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->
</div> <!-- /.td-main-content-wrap -->

<script type="text/javascript">
    var count = 4;
    var counter = setInterval(timer, 1000);

    function timer() {
        count = count - 1;
        if (count < 0) {
            clearInterval(counter);
            return;
        }

        if (count > 0) {
            document.getElementById("timer").innerHTML = count + " seconds";
        } else {
            //L fix for forced file download
            var src = document.getElementById('pdfUrl').innerHTML;
            var fileName = src.substring(src.lastIndexOf("/") + 1, src.length);

            document.getElementById("timer").innerHTML = "0 seconds";
            var meta = document.createElement('meta');
            meta.httpEquiv = "Refresh";
            meta.content = "0; url=" + src;
            var link = document.createElement('a');
            link.href = src;
            link.download = fileName;
            if (window.navigator.msPointerEnabled === true) {
                window.location.href = src;
            }

            if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
                document.getElementsByTagName('head')[0].appendChild(meta);
            } else {
                <?php if (!empty($thankyoupage_redirecturl)) { ?>
                    location.href = '<?php echo $thankyoupage_redirecturl; ?>';
                <?php } else if($thankyoupage_asset !== '') {
                    //do nothing
                } else { ?>
                        fireEvent(link, 'click');
                <?php } ?>
            }
        }
    }

    function fireEvent(obj, evt) {
        if (document.createEvent) {
            var evObj = document.createEvent('MouseEvents');
            evObj.initEvent(evt, true, false);
            obj.dispatchEvent(evObj);

        } else if (document.createEventObject) {
            location.href = obj.href;
        }
    }

</script> 
<!-- Download pdf --> 
<span style="display:none;" id="pdfUrl"><?php echo (isset($download)) ? $download->file_url : '#'; ?></span>
<?php
get_footer();
