<?php
/* Template Name: Thank you page New Requirement Vivek */

global $current_user;
get_header();

$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';

//if ((isset($_SESSION['form_submission']) && $_SESSION['form_submission'] == 'false') || !isset($_SESSION['form_submission'])) {
//    $_SESSION['typ_redirect'] = 'true';
//    wp_redirect(get_the_permalink($resource_id));
//}
//$_SESSION['form_submission'] = 'false';

$pdf_link = get_post_meta($post->ID, 'pdf_link', true);
$thankyoupage_redirecturl = get_post_meta($post->ID, 'thankyoupage_redirecturl', true);
$custom_thankyou_message1 = get_post_meta($post->ID, 'custom_thankyou_message1', true);
$resource_title = get_post_meta($post->ID, 'resource_title', true);
$custom_thankyou_message2 = get_post_meta($post->ID, 'custom_thankyou_message2', true);
$thankyoupage_video = get_post_meta($post->ID, 'thankyoupage_video', true);
$after_download_redirect = get_post_meta($post->ID, 'after_download_redirect', true);

$show_related_resources = get_post_meta($myposts->ID, 'show_related_resources', true);

if ($show_related_resources == 'false') {
    ?>
    <style type="text/css">
        #td-related-row{
            display:none;
        }
    </style> 
    <?php
}

?>

<style>
    button.btn.button.ur-submit-button{
        font-family: 'Noto Sans JP' !important;
    }
    .page-header {
    padding: 60px 30px !important;
    display: none !important;
}
.heading-line {
    width: 80%;
    margin-top: 12px;
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

                                    <img src="https://thesalesmark.com/wp-content/uploads/2020/08/Thank-you.png" class="img-responsive" style="margin:0 auto;width: 100px;padding-top: 20px;">                                  

                                    <?php if(!empty($custom_thankyou_message1)){ ?>
                                            <h1 style="font-size:25px;text-align: center;padding: 10px 0;font-family:'Noto Sans JP';margin-bottom:0px;">
                                        <?php echo $custom_thankyou_message1; ?>
                                        
                                    </h1>

                                    <?php } else { ?>

                                        <h1 style="font-size:25px;text-align: center;padding: 10px 0;font-family:'Noto Sans JP';margin-bottom:0px;">
                                        Thanks for your interest in
                                    </h1>

                                            
                                   <?php }?>



                                    

                                    <p style="font-size:28px;text-align: center;padding: 10px 0 0px 0px;color: #052F85;margin-bottom: 0px;">
                                        <?php echo $resource_title; ?>
                                    </p>

                                    
                                    <?php if(isset($custom_thankyou_message2)){ ?>
                                    <p style="font-size:16px;text-align: center;padding: 5px 0;color: #333;">
                                        <?php echo $custom_thankyou_message2; ?>
                                    </p>
                                <?php } ?>

                                    <?php if (!empty($thankyoupage_redirecturl)) { ?>
                                            <p style="margin:0 0 10px 0;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> You will be redirected automatically in <span id="timer">0 seconds</span>...<br>
                                                If you are not redirected automatically, <a href="<?php echo $thankyoupage_redirecturl; ?>" target="_blank" style="text-decoration:underline">click here</a> to go to the page. </p>
                                        <?php } elseif ($thankyoupage_video !== '') { ?>
                                            <div style="margin:30px auto; text-align: center;">
                                                <iframe src = "<?php echo $thankyoupage_video; ?>" width="1000" height="560" style="background-color: #FFF;"/></iframe>
                                            </div>
                                         <?php } else { ?>
                                            <p style="margin:0 0 10px 0;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> Your download will start automatically in <span id="timer">0 seconds</span>...<br>
                                                If your download does not start automatically, <a href="<?php echo $pdf_link; ?>" target="_blank" style="text-decoration:underline">click here</a> to start your download. </p>
                                               <!-- <meta http-equiv="refresh" content="4;url=<?php //echo $after_download_redirect; ?>"> -->

                                                <script>
                                                //Using setTimeout to execute a function after 5 seconds.
                                                setTimeout(function () {
                                                //Redirect with JavaScript
                                                window.location.href= '<?php echo $after_download_redirect; ?>';
                                                }, 8000);
                                                </script>
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
                <?php } else if($thankyoupage_video !== '') {
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
<span style="display:none;" id="pdfUrl"><?php echo $pdf_link; ?></span>
<style type="text/css">
    @media (max-width: 1400px) {
        .td-related-row {
            width: 100%;
        }
    }
    @media (max-width: 767px) {
        .td-related-row [class*="td-related-span"] {
            float: left; 
            width: 42%;
            margin: 0 0 auto 20px;
        }
    }
    
    @media (max-width: 400px) {
        .td-related-row [class*="td-related-span"] {
            float: none; 
            width: 90%;
            /*margin: 0 0 auto 20px;*/
        }
    }
</style>
<?php
get_footer();
?>