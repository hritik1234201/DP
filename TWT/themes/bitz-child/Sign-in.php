<?php
/* Template Name: Signin Page */

if (is_user_logged_in()){
    wp_redirect( home_url() );
    exit;
}
get_header();
global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));
$link_array = explode('/', $current_url);
$currpage = end($link_array); 
 ?>
 
 <style>
 #magic-link-div{
	 margin-left:20px;
 }
 </style>


<div class="vc_col-lg-12 vc_col-sm-12" style="margin-top:0px;margin-bottom:50px;padding-left:0px;padding-right:0px; background: #f9f9f9 !important;">
<div class="vc_col-lg-6 vc_col-sm-6 left-container" style="box-shadow: 1px 0px #8888880f;background:#ffffff !important">
<div class="page-header1">
<h1>Sign In</h1>
</div>

 <?php if(isset($_GET['msg']) && $_GET['msg'] == 'registered') { ?>
                                            <div class="regsiter-success alert alert-success">Please check your email for verification</div>
                                            <?php } 
                                            if((isset($_SESSION['registered']) && $_SESSION['registered'] == 'true')|| (isset($_GET['msg']) && $_GET['msg'] == 'verified')) { ?>
                                            <div class="regsiter-success alert alert-success">Your email is successfully verified. Continue to login with your chosen password to explore Techweb Trends</div>
                                            <?php 
                                                unset($_SESSION['registered']);
                                            } ?>
<?php echo do_shortcode('[user_registration_my_account]'); ?>
 <div id="magic-link-div">
                                            <!--<button id="passwordless-login-btn" class="magic-link-btn"><i class="fa fa-magic"></i> Login with Magic Link</button>-->
                                                <!--<div id="passwordless-login-div" style="display: none;">-->
                                                <p>
                                                    <b>Long password? Hard to type? </b><br />
                                                    <span style="font-size: 12px">Worry not! Save time with our magic link and sign in instantly.</span>
                                                </p>
                                                <?php echo do_shortcode('[passwordless-login]'); ?></div>
</div> 


<div class="vc_col-lg-6 vc_col-sm-6 right-container" style="margin-top:20px;padding-bottom:20px;">
<p style="font-size:22px;margin-left:15px;font-weight: 500;margin-bottom: 15px;">Free Access to Unlimited <br> eBooks, White Papers, Infographics </p>
<ul>
<li>Free access to unlimited eBooks, White Papers, Infographics</li>
<li>Uncover new Tips and Tricks via weekly Blogs</li>
<li>Stream unlimited Videos to stay inspired and spot-on</li>
<!-- <li>Track sales Events happening across the world</li> -->
<li>Catch News specific to the industry - refreshed daily</li>
</ul>
<a href="../register"><p style="padding: 10px;margin-left: 15px;background: transparent;text-align: center;color: #c53f45;
    border-radius: 20px;border: 3px solid #c53f45;font-weight: bold;width: 50%;font-size: 15px;">Create Account</p></a>

</div>


</div>

<?php
get_footer();