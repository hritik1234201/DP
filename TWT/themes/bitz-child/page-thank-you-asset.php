<?php
/* Template Name: Thank you page Template - Asset */

global $current_user;
get_header();

$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';
$thankyoupage_asset = (isset($_GET['thankyoupage_asset']) && !empty($_GET['thankyoupage_asset'])) ? base64_decode(urldecode($_GET['thankyoupage_asset'])) : '';

if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
    $_SESSION['typ_redirect'] = 'true';
    wp_redirect(get_the_permalink($resource_id));
}
$_SESSION['form_submission'] = 'false';

global $wpdb;
$myposts = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = $resource_id AND post_status LIKE 'publish' AND (post_type NOT LIKE 'attachment' AND post_type NOT LIKE 'sdm_downloads' AND post_type NOT LIKE 'revision');");

$download_resource_id = get_post_meta($myposts->ID, 'sdm_description', true);
if (!empty($download_resource_id)) {
    $download = $wpdb->get_row("SELECT * FROM wp_o0gCImmh0o00eqjs_sdm_downloads WHERE post_id = {$download_resource_id} ORDER BY id DESC;");
}

//$categories = get_the_terms($myposts->ID, 'resource_types');
//$category = array_pop($categories);
?>

<style>
    button.btn.button.ur-submit-button{
        font-family: 'Noto Sans JP' !important;
    }
</style>


<div class="td-main-content-wrap td-container-wrap">
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
                                <div style="margin: 0 auto;width:100%;text-align:center; border-bottom: 1px solid #e1e1e1; box-shadow: 0px 1px 4px #e1e1e1;">

                                    <img src="https://thesalesmark.com/wp-content/uploads/2020/08/Thank-you.png" class="img-responsive" />
                                    <h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:'Noto Sans JP';margin-bottom:0px;">
                                        Thanks for interest in "<?php echo $myposts->post_title; ?>"
                                    </h1>

                                </div>
                                <div style="margin:30px auto; text-align: center;">
                                    <iframe src = "<?php echo $thankyoupage_asset; ?>" width="1000" height="560" style="background-color: #FFF;"/>
                                </div>

                                <div style="margin-bottom: 30px !important;margin-top: 30px !important;" class="heading_wrapper"><h2>RELATED RESOURCES</h2><div class="heading-line" style="background-color:#e2e2e2"><span style="background-color:#052F85"></span></div></div>


                                <div class="clearfix related-parent-row">
                                    <?php $related = get_posts(array('post_type' => 'resources', 'numberposts' => 4, 'exclude' => array($resource_id))); ?>

                                    <?php
                                    if ($related) {
                                        foreach ($related as $single_post) {
                                            ?>
                                            <div class="td-related-span3 vc_col-sm-3">
                                                <div class="td_module_related_posts td-animation-stack td_mod_related_posts"><div class="td-module-image">
                                                        <div class="td-module-thumb">
                                                            <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" class="td-image-wrap" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal">
                                                                <img class="img-responsive entry-thumb td-animation-stack-type0-2" 
                                                                     src="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" 
                                                                     alt="<?php echo $single_post->post_title; ?>" 
                                                                     title="<?php echo $single_post->post_title; ?>" 
                                                                     data-type="image_tag" 
                                                                     data-img-url="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" 
                                                                     />
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="item-details">
                                                        <h3 class="entry-title td-module-title">
                                                            <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" 
                                                               title="<?php echo $single_post->post_title; ?>" 
                                                               data-wpel-link="internal"><?php echo $single_post->post_title; ?></a>
                                                        </h3>
                                                        <!--<p class="entry-title td-module-title" style="text-align: left;"></p>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                               
                            </div>
                            <!-- END -  Row 2-->
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
<?php if ($_GET['success']) { ?>
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
