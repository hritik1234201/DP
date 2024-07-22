<?php
/* Template Name: Landing Page - 2 Template */

get_header();
?>
<!-- Conversion Pixel - KPMG_PBCQ_PilotTest_Pixel1_Q320_08122020 - DO NOT MODIFY -->
<script src="https://secure.adnxs.com/px?id=1355059&t=1" type="text/javascript"></script>
<!-- End of Conversion Pixel -->
<!-- Conversion Pixel - KPMG_PBCQ_PilotTest_Pixel2_Q320_08122020 - DO NOT MODIFY -->
<script src="https://secure.adnxs.com/px?id=1305400&t=1" type="text/javascript"></script>
<!-- End of Conversion Pixel -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-164058429-1"></script>
<script>
//  window.dataLayer = window.dataLayer || [];
//  function gtag(){dataLayer.push(arguments);}
//  gtag('js', new Date());
//
//  gtag('config', 'UA-164058429-1');
</script>

<div class="td-main-content-wrap td-container-wrap landing-page2-template" style="font-family:Muli !important">
    <div class="tdc-content-wrap <?php echo $td_sidebar_position; ?>">
        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content" role="main">
                <div class="td-ss-main-content">

                    <div class="td-page-content tagdiv-type landing-page landing-page-2">
                        <?php
                        if (have_posts()) {
                            while (have_posts()) : the_post();
                                ?>
                                <!-- START -  Row 1-->
                                <!--                                <div class="row1" style="
                                                                     border-bottom: 1px solid #ededed;
                                                                     box-shadow: 0px 3px 3px #ededed;
                                                                     border-radius: 10px;">
                                                                    <div style="max-width: 80%;margin: 0 auto;display: flex">
                                                                        <div class="row1-col1" style="width: 50%"><img class="head-logo-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161652.png" /></div>
                                                                        <div class="row1-col2 a2a_kit" style="width: 50%;padding: 2% 0;text-align: right">
                                                                            <span>
                                                                                <a class="a2a_button_facebook"><img class="social-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161715.png" /></a>
                                                                            </span>
                                                                            <span>
                                                                                <a class="a2a_button_linkedin"><img class="social-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161720.png" /></a>
                                                                            </span>
                                                                            <span>
                                                                                <a class="a2a_button_twitter"><img class="social-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161723.png" /></a>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                <!-- END -  Row 1-->

                                <!-- START -  Row 2-->
                                <div style="width:1068px;margin: 30px auto 10px auto;"><span class="resource-tag">WHITE PAPER</span></div>
                                <h1 class="page-h1-head row2-head" style="">The Path to Intelligent Self-Service</h1>
                                <div class="row2" style="">
                                    <div class="row2-col1 column" style="">
                                        <img src="https://techversions.com/wp-content/uploads/2020/05/Image20200529185142.png" style='width: 75%;' />
                                        <div class='row2-content' style="">
                                            <!--<p><b>Making work easier for employees</b></p>-->
                                            <p style="margin-bottom:10px"><b>Explore the 11 best and proven strategies to power your self-service model.</b></p>
                                            
                                            <p>Interaction of your customers, employees, and partners with your brand needs to be easy, personalized, and independent. Although self-service models abound, the accurate and relevant information is barely available at your user's fingertips.</p>
                                            <p>Great self-service models go way beyond pleasing your users. From instantly answering queries of a fast-growing user base to saving the organization millions of dollars every year, they offer significant advantages. </p>
                                            <p>This guide offers 11 best and proven strategies to power your self-service model.</p>
                                            <?php echo do_shortcode('[addtoany]'); ?>
                                        </div>
                                    </div>
                                    <div class="row2-col2 column" style="">
                                        <h4 style='font-weight: bold'>Grab Your FREE White Paper</h4>
                                        <?php echo do_shortcode('[Form id="9"]'); ?>
                                    </div>
                                </div>
                                <!-- END -  Row 2-->

                                <!-- START -  Row 3-->
                                <!--                                <div class="row3" style="background-color: #0353A3;
                                    /*position: fixed;*/
                                    bottom: 0;
                                    width: 100%;
                                    color: white;
                                    text-align: center;
                                    display: flex;
                                "> 
                                                                    <div class="row3-col1" style="width: 50%;padding: 2% 0;text-align: left;margin-left: 10%;">
                                                                        &copy; 2020 All Rights Reserved. The HR Empire.
                                                                    </div>
                                                                    <div class="row3-col2" style="width: 50%;text-align: right"><img src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161727.png" class="footer-logo" style="" /></div>
                                                                </div>
                                                                        
                                                                    <div class="clearfix"></div>
                                                                </div>-->
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
<script async src="https://static.addtoany.com/menu/page.js"></script>
<?php
get_footer();
