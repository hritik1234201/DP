<?php
/* Template Name: New Thank you page Template */

global $current_user;
get_header();

$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';

if((isset($_SESSION['form_submission']) && $_SESSION['form_submission']== 'false') || !isset($_SESSION['form_submission'])) {
    $_SESSION['typ_redirect'] = 'true';
    wp_redirect(get_the_permalink($resource_id));
}
$_SESSION['form_submission'] = 'false';

global $wpdb;
$myposts = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE ID = $resource_id AND post_status LIKE 'publish' AND (post_type NOT LIKE 'attachment' AND post_type NOT LIKE 'sdm_downloads' AND post_type NOT LIKE 'revision');");

$download_resource_id = get_post_meta($myposts->ID, 'sdm_description', true);
if(!empty($download_resource_id)) {
    $download = $wpdb->get_row("SELECT * FROM wp_o0gCImmh0o00eqjs_custom_sdm_downloads WHERE post_id = {$download_resource_id} ORDER BY id DESC;");
}

$categories = get_the_terms($myposts->ID, 'resource_types');
$category = array_pop($categories);

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
    #top-bar-wrapper, #top-bar, #mobile-site-header, #site-header{
        display:none;
    }
    #footer{
        display:none;
    }
</style> 
<?php }

$pdf_link = (isset($_GET['thankyoupage_pdflink']) && !empty($_GET['thankyoupage_pdflink'])) ? base64_decode(urldecode($_GET['thankyoupage_pdflink'])) : '';
$thankyoupage_asset = (isset($_GET['thankyoupage_asset']) && !empty($_GET['thankyoupage_asset'])) ? base64_decode(urldecode($_GET['thankyoupage_asset'])) : '';
$thankyoupage_redirecturl = (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) ? base64_decode(urldecode($_GET['redirect_url'])) : '';
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
								
								    <img src="https://techwebtrends.com/assets/like-icon.gif" class="img-responsive" style="width:100px"/>
									<div class="thanks-msg-div" style="">
                                        <div class="inner-div">
                                            <h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:'lato';margin-bottom:0px;"> Thanks for downloading the <?php echo $category->name; ?></h1>
                                                <p style="font-size:28px;text-align: center;padding: 10px 0;color: #052F85;font-weight:600">"<?php echo $myposts->post_title; ?>"</p>
                                        </div>
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
                                </div>
								<!-- End of Row 2 -->
                                <!-- Start Row 3 -->
                                <div class="clearfix related-parent-row" id="td-related-row">
								
								    <div style="margin-bottom: 30px !important;margin-top: 30px !important;" class="heading_wrapper"><h2>RELATED RESOURCES</h2><div class="heading-line" style="background-color:#e2e2e2"><span style="background-color:#052F85"></span></div></div>
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
								
                                <?php if($current_user->user_email != '') { ?>
                                <!--<div style="display: block;width: 100%"><h4>Related Resources</h4></div>-->
                                <?php } ?>
                                <div class="row2 " style="">
                                    <?php if(empty($current_user) || $current_user->user_email == '') { ?>
                                    <!-- <div class="wpb_column vc_column_container vc_col-sm-6 row2-col1 column" style="padding:10px;">
                                        <img style="padding-top: 21px;margin-bottom:0;" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416165358.png" />
                                    </div> -->
                                </div>
                                    <div class="clearfix"></div>
                                    <?php } else {
                                        ?>                                   
                                    <?php } ?>
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