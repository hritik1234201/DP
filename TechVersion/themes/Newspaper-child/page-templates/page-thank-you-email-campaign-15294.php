<?php
/* Template Name: Thank you page Template - 15294 */

global $current_user;
get_header();

$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';

$pdf_link = get_post_meta($post->ID, 'pdf_link', true);
$redirect_url = get_post_meta($post->ID, 'thankyoupage_redirecturl', true);
$resource_title = get_post_meta($post->ID, 'resource_title', true);
$thankyoupage_asset = get_post_meta($post->ID, 'thankyoupage_asset', true);
?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<style>
    button.btn.button.ur-submit-button{
        font-family: 'Noto Sans JP' !important;
    }
    .td-module-thumb .entry-thumb{
        margin:0 auto;
    }
    .cta-button{
        display:flex;
        /*justify-content: center;*/
        /*padding:10px 10px;*/
    }
    .cta-button a{
        display: inline-block;
        background: #04a353;
        padding: 10px 20px;
        color: #ffffff;
        font-weight:bold;
    }

    .swal2-popup {
        width: 650px;
    }
    .swal2-html-container p {
        margin: 0;
        text-align: left;
        font-size: 1.5em;
    }

    .swal2-title {
        text-align: left;
        font-size: 2.7em;
        padding: 10px 20px 0 20px;
    }

    .swal2-actions .swal2-styled {
        font-size: 1.5em;
    }

    .wdform-label-section .wdform-label {
        color: #000 !important;
        font-size: 17px;
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
                                <div style="margin: 0 auto;width:100%; border-bottom: 1px solid #e1e1e1; box-shadow: 0px 1px 4px #e1e1e1;">

                                                                                                                                                                                    <!--<img src="https://thesalesmark.com/wp-content/uploads/2020/08/Thank-you.png" class="img-responsive" />-->									
                                    <!--                                    <h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:'Noto Sans JP';margin-bottom:0px;">
                                                                            Thanks for your interest in
                                                                        </h1>-->

                                                                                                                                                <!--                                    <p style="font-size:28px;text-align: center;padding: 10px 0;color: #052F85;">
                                                                                                                                                                                        "<?php echo $resource_title; ?>"
                                                                                                                                                                                    </p>-->

                                    <div class="single-whitepaper track-links" style="width:1140px;margin: 0 auto;padding-bottom:30px;">
                                        <div class="td_block_wrap td_block_related_posts tdi_12_89f td_with_ajax_pagination td-pb-border-top td_block_template_12">
                                            <div style="margin-top: 40px;padding: 10px 5px;">
                                                <div class="row3-child1" style="display: flex; padding: 20px 5px; box-shadow: 0px 0px 3px 3px #ddd;">
                                                    <!--<div>-->
                                                    <div class="td-module-image" style="width:40%;margin: 0 20px 0 20px; background-image: url(https://techversions.com/wp-content/uploads/2021/10/Image20210927132244.jpg);background-size: cover;">

                                                    </div>
                                                    <div class="item-details" style="width:60%;">

                                                        <div class="" style='padding: 0 20px;'>

                                                            <h3 style="font-weight: 900;margin-top:0;">Patch What Matters with Risk-Based Vulnerability Management, See How</h3>
                                                            <br />
                                                            <p>Hello there,<br /><br />

                                                                Thank you for showing interest in our resource! We request you to read this insightful paper "Patch What Matters with Risk-Based Vulnerability Management" to uncover the best way to protect your organization's valuable data and assets.
                                                            </p>
                                                            <p>Did you know? 60% of breaches have been linked to a vulnerability where a patch was available but not applied. And identifying which vulnerabilities are a priority is difficult, and relying on CVSS scores alone won't do the job. What if we tell you there is a better way to protect your organization against all the vulnerabilities?</p>
                                                            <p>Read this paper to learn more about this solution.</p>

                                                            <div class="cta-button">
                                                                <a id="my_link" href="#open-custom-questions" name="my_link" target="_blank" rel="modal:open">Get your copy now!</a>
                                                            </div>
                                                        </div>


                                                        <h3 class="entry-title td-module-title" style="text-align: center;"><a target="_blank" href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal"><?php echo $single_post->post_title; ?></a></h3>
                                                    </div>
                                                    <!--</div>-->
                                                </div>

                                                <span style="display:none;" id="pdfUrl"><?php echo $download->file_url; ?></span> 
                                                <span id="timer" style="display:none;">0 seconds</span>
                                                <?php
                                                //}
                                                //}
                                                ?>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                        <!--<div style="margin-bottom: 30px !important;margin-top: 30px !important;" class="container"><h3 style="margin-left: 10px;">Related Resources</h3><div class="heading-line" style="background-color:#e2e2e2"><span style="background-color:#052F85"></span></div></div>-->


                                <!--                                <div class="container clearfix related-parent-row">
                                <?php
                                $related = get_posts(array('post_type' => 'white_papers', 'numberposts' => 4, 'exclude' => array($resource_id)));
                                if ($related) {
                                    foreach ($related as $single_post) {
                                        ?>
                                                                                    <div class="td-related-span3 bit-4">
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
                                                                                                <h5 class="entry-title td-module-title" style="margin-top:20px;">
                                                                                                    <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" 
                                                                                                       title="<?php echo $single_post->post_title; ?>" 
                                                                                                       data-wpel-link="internal"><?php echo $single_post->post_title; ?></a>
                                                                                                </h5>
                                                                                                <p class="entry-title td-module-title" style="text-align: left;"></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                        <?php
                                    }
                                }
                                ?>
                                                                </div>-->

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

<div id="open-custom-questions" class="modal">
    <h3 style="font-size: 20px; margin: 20px 10px;"><?php echo $resource_title; ?></h3>
    <!--<h4 style="font-size: 18px; margin: 20px 10px;"></h4>-->
    <?php echo do_shortcode('[Form id="163"]'); ?>
</div>

<script type="text/javascript">

    jQuery(document).ready(function () {

        jQuery('html, body').animate({
            scrollTop: jQuery(".single-whitepaper").offset().top - 50
        }, 2000);

<?php if (!isset($_GET['form_sub'])) { ?>
            setTimeout(function () {
                jQuery('#open-custom-questions').modal('show');
            }, 2000);
<?php } ?>

        var email = '<?php echo $_GET["email"]; ?>';
<?php if (isset($_GET["email"]) && !empty($_GET["email"]) && $_GET["email"] !== '{{email}}') { ?>
            jQuery(".track-links a, .track-link-form-btn .button-submit").on("click", function () {

                console.log('Clicked me');
                var href_link = jQuery(this).attr('href');
                jQuery.ajax({
                    url: '/fetch/action.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {email: email, href_link},
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    traditional: true,
                    success: function (data) {
                        console.log(data);
                    }
                });

            });

            console.log('Before check_success_message()');
            check_success_message();
<?php } ?>
    });



    function download_asset() {
        if (jQuery(".fm-form-container div").hasClass('fm-message') == true) {
            console.log('testing once');
            //window.open('https://thetechaffair.com/wp-content/uploads/2015/09/IBM-Multicloud-Management-Platform_-Overview.pdf', '_blank');
            window.location.href = "<?php echo $pdf_link; ?>";

            setTimeout(function () {
                window.location.href = "https://techversions.com/thank-you-page-patch-what-matters-with-risk-based-vulnerability-management/?email=svyas@trueinfluence.com&form_sub=true";
//                window.location.href = window.location.pathname + "?" + jQuery.param({'email': '<?php echo $_GET['email']; ?>','form_sub': 'true'});
            }, 3000);
            stop_checking();
        }
    }
    function check_success_message() {
        console.log('check_success_message()');
//        setTimeout(download_asset(), 3000);
        t = setInterval(download_asset, 3000);

    }
    function stop_checking() {
        clearInterval(t);
    }

</script> 

<?php
get_footer();
