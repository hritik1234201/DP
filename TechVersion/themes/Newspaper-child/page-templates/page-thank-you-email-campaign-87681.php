<?php
/* Template Name: Thank you page Template - Email Campaign - Pop-up Only*/

get_header();

$pdf_link = get_post_meta($post->ID, 'pdf_link', true);
$redirect_url = get_post_meta($post->ID, 'thankyoupage-redirecturl', true);
$resource_title = get_post_meta($post->ID, 'resource_title', true);
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .swal2-popup {
        font-size: 1.5rem;
    }
    .swal2-title{
        font-size:18px;
    }
    .td-module-thumb .entry-thumb{
        margin:0 auto;
    }
    /*    .cta-button{
            display:flex;
            justify-content: center;
            padding:30px 10px;
        }*/
    .cta-button a{
        display: inline-block;
        background: #04a353;
        padding: 10px 20px !important;
        color: #ffffff;
        font-weight:bold;
    }
    p{
        font-size:16px;
    }
    .swal2-styled.swal2-confirm{
        font-size:18px;
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
                                <div style="margin: 0 auto;width:100%; border-bottom: 1px solid #e1e1e1; box-shadow: 0px 3px 4px #e1e1e1;">
                                    <h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:Muli;">
                                        Thanks for your interest in <br />"<?php echo $resource_title; ?>"
                                    </h1>
                                    <p style="margin:0 0 10px 0;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> Your download will start automatically in <span id="timer">0 seconds</span>...<br>
                                        If your download does not start automatically, <a href="<?php echo $pdf_link; ?>" target="_blank" style="text-decoration:underline">click here</a> to start your download. </p>
                                </div>
                              <!--  <div class="row2 " style="">
                                    <div class="clearfix"></div>
                                </div> -->
                                <!-- END -  Row 2-->

                                <!-- START -  Row 3-->
                                <div id="second-touch"></div>

                                <div class="single-whitepaper track-links" style="width:1068px;margin: 0 auto;padding-bottom:30px;">
                                    <div class="td_block_wrap td_block_related_posts tdi_12_89f td_with_ajax_pagination td-pb-border-top td_block_template_12">
                                        <div style="margin-top: 40px; padding: 20px 5px; box-shadow: 0px 0px 3px 3px #eee;">
                                            <?php //$related = get_posts(array('post_type' => 'resources', 'numberposts' => 1, 'post__not_in' => array(5985))); ?>
                                            <?php
                                            //if ($related) {
                                            //foreach ($related as $single_post) {
                                            ?>
                                            <div class="td-block-row">
                                                <div>
                                                    <div class="td-module-image">
                                                        <div class="td-block-span6 td-module-thumb" style="margin-bottom:30px;float:left;">
                                                            <a target="_blank" class="td-image-wrap" title="Will Remote Work Continue? What Trends Are Others Following?" href="https://techversions.com/wp-content/uploads/2022/05/1st-Touch-A-Asset_-The-Great-Resignation-why-you-contact-center-wont-survive-without-Automation.pdf">
                                                                <img class="entry-thumb td-animation-stack-type0-2" src="https://techversions.com/wp-content/uploads/2022/05/Why-Contact-Center-Wont-Survive-Without-Automation.jpg" alt="<?php echo $single_post->post_title; ?>" title="<?php echo $single_post->post_title; ?>" data-type="image_tag" data-img-url="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="item-details">

                                                        <div class="td-block-span6 entry-content herald-entry-content" style="font-size: 16px;font-family:Poppins;float:right !important; ">

                                                          <!--  <h3 style="font-weight: 900;margin-bottom:20px;font-size:26px;">The Great Resignation: Why Contact Center Wont Survive Without Automation</h3> -->
                                                            
                                                            <p>Thank you for showing interest in this eGuide from Replicant. 2021 was a difficult year to manage a contact center, and 2022 can be even more challenging. </p>
                                                            <p>Uncertainty abounds and contact center leaders are looking for ways to improve their customer service in 2022. But one thing is for sure. In 2022, automation will play a significant role in resolving customer issues, scaling effectively, and retaining agents.</p>
                                                            

                                                            <b>With this eGuide, explore today’s Workforce Management challenges and learn how conversational AI automation can transform your contact centers by :</b>
                                                            <ul>
                                                                <li>Evaluating different conversational AI automation solutions </li>
                                                                <li>Choosing the right use cases to start automating</li>
                                                                <li>Calculating the ROI of an AI implementation</li>
                                                                <li>Assessing your Contact Center technology stack</li>
                                                                
                                                            </ul>

                                                            <p>Are you ready to make an impact on your employees’ lives?</p>

                        <!--<p>Download Now!</p>-->

                                    <div class="cta-button">
                                        <a id="my_link" name="my_link" target="_blank" href="https://techversions.com/wp-content/uploads/2022/05/1st-Touch-A-Asset_-The-Great-Resignation-why-you-contact-center-wont-survive-without-Automation.pdf">Transform your Customer Service today!</a>
                                    </div>
                                </div>
                                <h3 class="entry-title td-module-title" style="text-align: center;"><a target="_blank" href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal"><?php echo $single_post->post_title; ?></a></h3>
                                </div>
                                </div>
                            </div>
                            <span style="display:none;" id="pdfUrl"><?php echo $download->file_url; ?></span> 
                            <span id="timer" style="display:none;">0 seconds</span>
                            <?php
                                            //}
                                            //}
                                            ?>
                                        </div>

                                        <!-- <div class="cta-button">
                                            <a id="my_link" name="my_link" target="_blank" href="https://thetechaffair.com/wp-content/uploads/2015/09/Forever-Changed_-Report-on-Remote-Work.pdf">Get this report on remote work now</a>
                                        </div> -->

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
            var email = '<?php echo $_GET["email"]; ?>';
            var href_link = '<?php echo $pdf_link; ?>';
            var email_campaign_title = '<?php echo $resource_title; ?>';
            // console.log(email);

            jQuery.ajax({
                        url: '/fetch/action.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {email: email, href_link, email_campaign_title},
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        traditional: true,
                        success: function (data) {
                            console.log(data);
                        }
                    });
                    
            //L fix for forced file download
            var src = document.getElementById('pdfUrl').innerHTML;
            src = (src == '') ? '<?php echo $pdf_link; ?>' : src;
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
<?php if (!empty($redirect_url)) { ?>
                    location.href = '<?php echo $redirect_url; ?>';
<?php } else { ?>
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


    jQuery(document).ready(function () {
        var delay = 1000 * 2;
        setTimeout(function () {
            Swal.fire({
                title: "What's the Best Way to Scale Your Call Center?",
                html: "<p>Additionally, you might be interested in this guide showing the best way to scale your call center. </p><p>Scaling your call center helps you to boost productivity and reduce costs. It also helps you to improve your customer experience. </p><p>However, you have a few options for scaling your call center. And what’s the best way to do so?</p><p>This is difficult to answer as you need to understand different call center types, weigh the pros and cons of different methods available, compare the pricing models, and evaluate all the possible risk factors.</p><p>In this guide, you’ll learn the difference between BPO, voice AI, and IVR. With Replicant, you can make the right decision for your contact center, and ultimately, take your customer experience to the next level.</p><p><i>Download this guide to know which scaling method is best for you!</i></p>",
                imageUrl: 'https://techversions.com/wp-content/uploads/2022/05/Whats-the-Best-Way-to-Scale-Your-Call-Center.jpg',
                imageWidth: 400,
                imageHeight: 200,
                confirmButtonText: "Choose the best scaling method",
                confirmButtonColor: '#04a353',
                showCancelButton: true,
                cancelButtonColor: '#ddd',
                backdrop: 'rgba(0,0,0,0.9) no-repeat',
                customClass: {
                    confirmButton: 'swal-btn',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('Clicked me - SWAL btn');
                    <?php if (isset($_GET["email"]) && !empty($_GET["email"]) && $_GET["email"] !== '{{email}}') { ?>
                    var href_link = '<?php echo $pdf_link; ?>';
                    var email_campaign_title = '<?php echo $resource_title; ?>';
                    jQuery.ajax({
                        url: '/fetch/action.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {email: email, href_link, email_campaign_title},
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        traditional: true,
                        success: function (data) {
                            console.log(data);
                        }
                    });
                     location.href = 'https://techversions.com/wp-content/uploads/2022/05/BPO-vs.-Voice-AI-vs.-IVR_-Whats-the-Best-Way-to-Scale-Your-Call-Center_-1.pdf';
                    // location.href = 'https://hrinterests.com/wp-content/uploads/2022/03/The-Value-and-Impact-of-MentalHealth-at-Work.pdf';

                    location.hash = "#second-touch";
                    <?php } ?>
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    location.hash = "#second-touch";
                }
            });
        }, delay);

            var email = '<?php echo $_GET["email"]; ?>';
            <?php if (isset($_GET["email"]) && !empty($_GET["email"]) && $_GET["email"] !== '{{email}}') { ?>
            jQuery(".track-links a").on("click", function () {

                console.log('Clicked me');
                var href_link = jQuery(this).attr('href');
                var email_campaign_title = '<?php echo $resource_title; ?>';
                jQuery.ajax({
                    url: '/fetch/action.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {email: email, href_link, email_campaign_title},
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    traditional: true,
                    success: function (data) {
                        console.log(data);
                    }
                });

            });
<?php } ?>
    });
</script> 
<!-- Download pdf --> 
<span style="display:none;" id="pdfUrl"><?php echo $pdf_link; ?></span>

<?php
get_footer();
