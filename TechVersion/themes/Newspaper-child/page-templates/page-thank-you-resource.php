<?php
/* Template Name: Thank You Page - Resource */
//global $current_user;

get_header();

//if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
//    $_SESSION['typ_redirect'] = 'true';
//    wp_redirect(get_the_permalink($resource_id));
//}
//$_SESSION['form_submission'] = 'false';


$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';
//$thankyoupage_redirecturl = (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) ? base64_decode(urldecode($_GET['redirect_url'])) : '';

global $wpdb;
$myposts = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = $resource_id AND post_status LIKE 'publish' AND (post_type NOT LIKE 'attachment' AND post_type NOT LIKE 'sdm_downloads' AND post_type NOT LIKE 'revision');");

$download_resource_id = get_post_meta($myposts->ID, 'sdm_description', true);
if (!empty($download_resource_id)) {
    $download = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}custom_sdm_downloads WHERE post_id = {$download_resource_id} ORDER BY id DESC;");
}

$post_types = get_post_type_object($myposts->post_type);
$post_type = $post_types->labels->singular_name;

$resource_title = $myposts->post_title;

$pdf_link = (isset($_GET['thankyoupage_pdflink']) && !empty($_GET['thankyoupage_pdflink'])) ? base64_decode(urldecode($_GET['thankyoupage_pdflink'])) : '';
$thankyoupage_asset = (isset($_GET['thankyoupage_asset']) && !empty($_GET['thankyoupage_asset'])) ? base64_decode(urldecode($_GET['thankyoupage_asset'])) : '';
$thankyoupage_redirecturl = (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) ? base64_decode(urldecode($_GET['redirect_url'])) : '';

$show_related_resources = get_post_meta($myposts->ID, 'show_related_resources', true);
if($show_related_resources == 'false'){ ?>
    <style type="text/css">
    #td-related-row{
        display:none;
    }
</style> <?php }

$show_header_footer = get_post_meta($myposts->ID, 'show_header_footer', true);

if($show_header_footer == 'false'){?>
 <style type="text/css">
     /* check the class or id and add it here according to your theme */
    .tdc-header-wrap {
        display:none;
    }
    .tdc-footer-wrap {
        display:none;
    }

</style> <?php }?>




<style>

.td_block_template_4 .td-related-title .td-cur-simple-item {
    background-color: #4db2ec;
}

.td_block_template_4 .td-block-title > * {
    background-color: #000;
    color: #fff;
    padding: 0 12px;
    position: relative;
}

.td_block_template_4 .td-related-title .td-cur-simple-item:before {
    border-color: #4db2ec transparent transparent transparent !important;
}
.thksimg{height: 250px;
    width: 100%;
    object-fit: cover;
    object-position: top;}

    .td-page-content{
        padding-bottom:0px !important;
    }
    </style>

<div class="td-main-content-wrap td-container-wrap" style="font-family:Muli !important">
    <div class="tdc-content-wrap <?php echo $td_sidebar_position; ?>">
        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content" role="main">
                <div class="td-ss-main-content">

                    <div class="td-page-content tagdiv-type thank-you-page" style="margin:1% auto 0 auto;">
                        <?php
                        if (have_posts()) {
                            while (have_posts()) : the_post();
                                ?>

                                <!-- START -  Row 2-->
                                <div style="margin: 0 auto;width:100%; border-bottom: 1px solid #e1e1e1; box-shadow: 0px 3px 4px #e1e1e1;text-align:center">
                                    <img src="https://techversions.com/wp-content/uploads/2023/02/like.png" style="text-align:center;width:80px;padding-top:10px;" />

                                    <h1 style="font-size:28px;text-align: center;padding: 0px 0px 0px 0;font-family:lato;margin-top:0px;color:#3c4c41">
                                        Thanks for your interest in <?php //echo $post_type; ?></h1>
                                        <h3 style="font-size:32px;font-weight:600;text-align: center;font-family:lato;">
                                        "<?php echo $myposts->post_title; ?>"
                                        </h3>

                                    <?php if (!empty($thankyoupage_redirecturl)) { ?>
                                        <p style="margin:0 0 10px 0;padding-bottom:0px;color:#465760;font-size: 13px; text-align: center"> You will be redirected automatically in <span id="timer">0 seconds</span>...<br>
                                            If you are not redirected automatically, <a href="<?php echo $thankyoupage_redirecturl; ?>" target="_blank" style="text-decoration:underline">click here</a> to go to the page. </p>
                                    <?php } else { ?>
                                        <p style="margin:0 0 10px 0;padding-bottom:20px;color:#465760;font-size: 13px; text-align: center"> Your download will start automatically in <span id="timer">0 seconds</span>...<br>
                                            If your download does not start automatically, <a href="<?php echo (isset($download)) ? $download->file_url : '#'; ?>" target="_blank" style="text-decoration:underline">click here</a> to start your download. </p>
                                    <?php } ?>
                                    <?php if ($thankyoupage_asset !== '') { ?>
                                        <div style="margin:30px auto; text-align: center;">
                                            <iframe src = "<?php echo $thankyoupage_asset; ?>" width="1000" height="560" style="background-color: #FFF;"/>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- END -  Row 2-->
                                <!-- START -  Row 3-->
                                <div class="single-whitepaper  single-thankyou td-container"  id="td-related-row">
                                    <div class="td_block_wrap td_block_related_posts tdi_3_89f td_with_ajax_pagination td-pb-border-top td_block_template_4" data-td-block-uid="tdi_3_89f">
                                        <!-- <h4 class="td-related-title td-block-title"><a id="tdi_4_2e5" class="td-related-left td-cur-simple-item" data-td_filter_value="" data-td_block_id="tdi_3_89f" href="#">Most Downloaded </a><a id="tdi_5_b88" class="td-related-right" data-td_filter_value="td_related_more_from_author" data-td_block_id="tdi_3_89f" href="#"><?php //echo $post_type . 's'; ?></a></h4> -->

                                        <h4 class="td-related-title td-block-title"><span id="tdi_4_2e5" class="td-related-left td-cur-simple-item" data-td_filter_value="" data-td_block_id="tdi_3_89f">Most Downloaded <?php echo $post_type . 's'; ?></span></h4>



                                        <div id="tdi_3_89f" class="td_block_inner"><div class="td-related-row" >
                                                <?php $related = get_posts(array('post_type' => 'white_papers', 'numberposts' => 4, 'post__not_in' => array($myposts->ID))); ?>
                                                <?php
                                                if ($related) {
                                                    foreach ($related as $single_post) {
                                                        ?>
                                                        <div class="td-related-span3">
                                                            <div class="td_module_related_posts td-animation-stack td_mod_related_posts"><div class="td-module-image">
                                                                    <div class="td-module-thumb">
                                                                        <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" class="td-image-wrap" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal">
                                                                            <img class="entry-thumb thksimg" src="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" alt="<?php echo $single_post->post_title; ?>" title="<?php echo $single_post->post_title; ?>" data-type="image_tag" data-img-url="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" >
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="item-details">
                                                                    <h3 class="entry-title td-module-title" style="text-align: left;line-height: 20px !important;"><a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal"><?php echo $single_post->post_title; ?></a></h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span style="display:none;" id="pdfUrl"><?php echo $download->file_url; ?></span> 
                                                        <span id="timer" style="display:none;">0 seconds</span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
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


if($resource_title == "Five Essentials of Modern IT Infrastructure Management"){ ?>

 <script src="https://js.adsrvr.org/up_loader.1.1.0.js" type="text/javascript"></script>
        <script type="text/javascript">
            ttd_dom_ready( function() {
                if (typeof TTDUniversalPixelApi === 'function') {
                    var universalPixelApi = new TTDUniversalPixelApi();
                    universalPixelApi.init("veme4uw", ["q7ldulc"], "https://insight.adsrvr.org/track/up");
                }
            });
        </script>
<?php
}
get_footer();




