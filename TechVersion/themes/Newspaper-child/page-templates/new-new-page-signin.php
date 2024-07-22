<?php
/*
 * Template Name: Signin Page Template Two
 */

 if (is_user_logged_in()) {
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));
    $url = parse_url($wp->request);
    $url_sections = explode('/', $url['path']);
    if($url_sections[0] === 'sign-in') {
        wp_redirect(home_url().'/my-account/'.$url_sections[1]);
    } else {
        wp_redirect(home_url());
        exit;
    }    
}

get_header('nomenu');
global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));
$link_array = explode('/', $current_url);
$currpage = end($link_array);
?>


<style>

    input#wpa-submit
    {
        margin-top: 0px !important;
    }
    /*START -- Login Page*/
    .login-form-row {
        display: flex;
        overflow-x: auto;
    }

    login-block{
        margin-top: 40px !important;
        margin-bottom: 40px !important;
    }

    .login-form-col-1, .login-form-col-2 {
        width: 50%;
    }

    /* 
    .login-form-col-1 {
        
            background-image: url("https://techversions.com/wp-content/uploads/2021/02/Login-Page-BG-Final.png"); 
        text-align: center;
        padding: 14% 10%;
            
        
    } */


    #wpa-submit{
        height:40px !important;
        text-transform: capitalize !important;
        border-radius: 5px !important;
    }
    .mobilelogo{display:none}
    #login-block{
        background-color: rgba(255, 255, 255, 1);
        padding: 10px 50px 10px 50px;
        border-radius: 10px;	

    }
    input::placeholder {
        color: #948c8c !important;
    }

    input#password {
        color: #2b2b2b;
    }

    input#username {
        color: #2b2b2b;
    }


    label.user-registration-form__label.user-registration-form__label-for-checkbox.inline span {
        color: #000000 !important;
    }

    a{
        color:#000000;
    }

    p.user-registration-register.register {
        text-align: center;
        font-size: 15px;
        font-weight: 600;
    }



    .login-form-col-1{
        /* text-align: center; */
        padding: 12% 12%;
    }

    .login-form-row.second-login{
        background-image: url("https://techversions.com/wp-content/uploads/2023/08/Login-Page-BG.jpg"); 
        background-repeat: no-repeat; 
        background-size: cover;
        height:100vh;
    }

    .login-form-col-1 h1, .login-form-col-1 h2{
        color: #FFF;
    }

    .login-form-col-2 {
        /* background-color: #F0F0F0;
         padding: 1% 8%; */
        padding: 2% 5%;
    }

    .login-form-col-2 h1 {
        color: #000000;
    }

    .login-form-col-2 #user-registration {
        background-color: transparent;
        margin-bottom: 0;
    }

    .login-form-col-2 .ur-frontend-form {
        border: none;
        padding: 0;
    }

    .login-form-col-2 .ur-frontend-form .ur-submit-button {
        width: 100%;
        margin: 0;
        background-color: #000000;
        border-color: #000000;
        border-radius: 5px;
        color: #FFF;
    }

    .login-form-col-2 .ur-frontend-form .ur-submit-button:focus {
        border-color: #000000;
    }

    .login-form-col-2 .ur-frontend-form .ur-button-container, .login-form-col-2 .ur-frontend-form .ur-form-row .ur-form-grid {
        padding: 0;
    }

    .login-form-col-2 .user-registration-Button {
        float: none;
        width: 100%;
    }

    .login-form-col-2 .ur-frontend-form input.input-text {
        border-radius: 5px !important;
        padding: 15px;
        font-size: 15px;
        color: #000000;
        height: 40px;

    }

    input {
        border: 1px solid #ccc !important;
    }

    .login-form-col-2 .ur-frontend-form input.input-text::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: #000000;
        opacity: 1; /* Firefox */
    }

    .login-form-col-2 .ur-frontend-form input.input-text:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #000000;
    }

    .login-form-col-2 .ur-frontend-form input.input-text::-ms-input-placeholder { /* Microsoft Edge */
        color: #000000;
    }

    .login-form-col-2 .create-account-btn {
        width: 100%;
        padding: 5px;
        border: #000000 2px solid;
        border-radius: 10px;
        font-size: 18px;
        color: #000000;
        background-color: #FFF;
		font-size:18px;
    }

    .magic-link-btn {
        width: 100% !important;
        margin: 0 !important;
        color: #FFF !important;
        max-width: 100% !important;
        height: 40px !important;
        width: 100%;
        padding: 14px;
        border: #000000 2px solid !important;;
        border-radius: 10px;
        font-size: 18px;
        /*color: #000000;*/
        background-color: #000000 !important;;
    }

    .go-back {
        text-decoration: underline;
        color: #000000;
        cursor: pointer;
        font-weight: bold;
    }

    /*Error Message*/
    .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid label, .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid legend {
        color: #f4000a;
        margin-left: 0;
        position: absolute;
        font-size: 10px;
    }

    .ur-frontend-form .ur-form-row .ur-form-grid label, .ur-frontend-form .ur-form-row .ur-form-grid legend {
        margin-bottom: 0; 
        margin-top: 0; 
    }

    .user-registration-error {
        color: #f4000a !important;
    /* border-top:none;
       background: transparent; */
		position:unset !important;
		
		background-color: #fee3e4 !important;
    border: 1px solid #f4000a !important;
    padding: 5px 10px !important;
    margin-bottom: 10px !important;
	display: flex !important;
    
    }
    .user-registration-error, .user-registration-info, .user-registration-message {
        margin: 0; 
        padding: 0; 
        border-top: none; 
        line-height: none; 
    }

    .user-registration-error::before, .user-registration-info::before, .user-registration-message::before {
        margin-right: 2px;
        font-size: calc(100% + 4px);
    }

    .field-user_pass, .field-user_pass p {
        /* margin-bottom: 0 !important; */
    }

    #user_pass-error {
        margin-top: -19px; 
    }

    /*.password-field {
        margin-bottom: 19px;
    }*/

    .ur-frontend-form .ur-form-row .ur-form-grid input[type=date], .ur-frontend-form .ur-form-row .ur-form-grid input[type=email], .ur-frontend-form .ur-form-row .ur-form-grid input[type=number], .ur-frontend-form .ur-form-row .ur-form-grid input[type=password], .ur-frontend-form .ur-form-row .ur-form-grid input[type=phone], .ur-frontend-form .ur-form-row .ur-form-grid input[type=text], .ur-frontend-form .ur-form-row .ur-form-grid input[type=timepicker], .ur-frontend-form .ur-form-row .ur-form-grid input[type=url], .ur-frontend-form .ur-form-row .ur-form-grid select, .ur-frontend-form .ur-form-row .ur-form-grid textarea {
        margin-bottom: 5px;
    }

    .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=date], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=email], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=number], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=password], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=text], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid input[type=url], .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid select, .ur-frontend-form.ur-frontend-form--bordered form .ur-form-row .ur-form-grid textarea {
        background-color: #FFF;
    }

    #td-outer-wrap.div-nomenu {
        overflow: hidden;
        position: relative;
        min-height: 100vh;
    }

    /*#td-outer-wrap.div-nomenu .td-main-content-wrap.td-container-wrap {
        padding-bottom: 2.5rem;
    }*/

    .td-sub-footer-container.td-container-wrap.td_stretch_container.td_stretch_content_1200 {
        position: fixed;
        bottom: 0;
        width: 100%;
        /*height: 2.5rem;*/
    }

    #go-login {
        float: left;
        margin-top: 3px;
        cursor: pointer;
    }

    .back-to-home {
        margin-top: 10px;
    }

    .lost-password-span {
        margin: 0;
    }

    .sub-row {
        display: flex;
    }

    .sub-row-col {
        width: 50%;
    }

    p.user-registration-form-row {
        margin-bottom: 23px;
        position: relative;

    }

    #login-block h4 {
        margin-top: 15px;
    }

    .or {
        display:flex;
        justify-content:center;
        align-items: center;
        color:grey;
    }

    .or:after,
    .or:before {
        content: "";
        display: block;
        background: grey;
        width: 50%;
        height:1px;
        margin: 0 10px;
        color: #fefefe;
    }

    #user_email_username {
        width: 100% !important;
        height: 40px !important;
        border-radius: 5px !important;
    }

    #magic-link-div {
        margin: 20px 0;
    }

    #passwordless-login-div p {
        margin-bottom: 0;
    }

    #magic-link-div p {
        margin-bottom: 8px;
    }

    #magic-link-div .wpa-success {
        /*    background: #00C89E !important;
            border: 1px solid #00C89E !important;*/
        background: rgba(0,200,158,0.5) !important;
        border: 1px solid #009978 !important;
    }

    .lost_reset_password .user-registration-Button, #register_button {
        background-color: #000000 !important;
        border-color: #000000 !important;
    }

    #register_button {
        color: #FFF !important;
        border-radius: 5px !important;
    }

    /*.chosen-container {
        width: 100%;
    }*/

    .chosen-container-single .chosen-single span {
        color: #676d8a !important;
    }

    .chosen-container-single .chosen-single div {
        top: 12px !important;
    }

    .chosen-container-single .chosen-single {
        padding: 10px !important;
        background-color: #fff !important;
        height: 45px !important;
        border: none !important;
        border-bottom: 1px solid #c0c4d4;
        color:#cecece !important;
        /*width: 97%;*/
        background-image: none !important;
        box-shadow: -4px 4px 8px 1px #D0D0D0 !important;

    }
    .chosen-container .chosen-drop {
        border-color: #FFF !important;
    }


    input.user-registration-Button.button{
        background-color: #04a353 !important;
    }

    /*END -- Login Page*/


    @media (max-width: 979px) {
        .mobilelogo{display:block;    margin: 10% auto;}
        .desktoplogo{display:none}
        .login-form-row.second-login{display: flex;
    flex-direction: column-reverse;}
        .second-login{text-align:center}
        .row2 {
            flex-direction: column-reverse !important;
        }

        .landing-page-2 .row2 {
            flex-direction: column !important;
        }

        .thank-you-page .row2 {
            flex-direction: column !important;
        }

        .row2 .column {
            flex-basis: auto;
            width: 100% !important;
        }
        .landing-page-2 .row2 .row2-col1 {
            text-align: center;
            border-right: none !important;
            padding-right: 0;
        }
        .landing-page-2 .row2 .row2-col2 {
            padding-left: 0;
        }
        .landing-page-2 .row2 .fm-form-container.fm-theme1 {
            width: 100%;
        }

        .thank-you-page .row2 .row2-col1 {
            text-align: center;
        }

        .thank-you-page .row2 .row2-col1 img {
            width: 50%;
        }

        #mobile-subscription-form {
            display: block !important;
        }

        /*  #subscription-form {
              display: none;
          } */

        .login-form-row {
            display: block;
        }

        .login-form-col-1, .login-form-col-2 {
            width: 100%;
        }

        #wpaloginform > p {
            display: block !important;
        }

        .td-sub-footer-container.td-container-wrap.td_stretch_container.td_stretch_content_1200 {
            position: relative;
        }
    }

    @media (max-width: 767px) {
        #login-block{padding: 10px 30px 10px 30px;}
        .login-form-col-1{    padding: 3% 12%;}
        .td-subfooter-menu li a{font-size: 14px !important;}
        h4 {
    font-size: 18px;
    line-height: 1.5;}
        .my-account-content-block {
            width: auto !important;
        }

        .child-unsub-group {
            min-height: auto;
        }

        .wdform_column .contact_form_message {
            width: 100% !important;
        }
        #feedback-form-div {
            display: none;
        }
        #feedback-form-mobile-div {
            display: block !important;
        }

        /*START -- Resource Page*/
        .resource-header-div {
            display: block;
        }
        .resource-header-div .resource-col1, .resource-header-div .resource-col2  {
            width: 100%;
            clear: both;
        }

        .resource-header-div .resource-col1 {
            margin-left: 0;
        }

        .resource-header-div .resource-col2 {
            margin-bottom: 0;
            padding: 25px 0;
            float: left;
            margin-left: 30px;
        }

        .resource-header-div .resource-col1 .resources-heading {
            /*margin-left: 0;*/
            margin-left: 30px;
        }

        .resource-header-div .resource-col2 .resources-filter {
            float: left;
        }

        #infinite-handle span {
            display: inline !important;
        }
        /*END -- Resource Page */

        /*START -- Feedback Form*/
        .feedback-form-inner-row .vc_column_inner {
            display: block !important;
            height: 100%;
            width: 100%;
        }
        .feedback-form-first-col {
            padding: 0 !important;
        }
        /*END -- Feedback Form*/


        /*START -- Author Page*/
        .author-profile-row .tdb_author_image  {
            text-align: center !important;
        }

        .author-profile-row .vc_column_container {
            width: 100% !important;
            text-align: center !important;
            border-left: 0 !important;
        }

        .author-profile-row .tdb-author-title, .author-profile-row .tdb_author_description {
            text-align: center !important;
        }
        /*END -- Author Page*/

        .ccpa-form {
            width: 100% !important;
            padding: 20px 10px;
        }
    }

    .ccpa-text-container {
        /* width: 70% !important; */
        margin: 30px auto 0 auto !important;    
        padding: 10px 0px;   
    }

    .dropdown-toggle::after{
        display:none !important;
    }

    @media only screen and (max-width: 767px) and (min-width: 581px)  {
        .tdi_66_ebc .td_module_wrap {
            width: 50% !important;
            float: left;
            padding-left: 30px !important;
            padding-right: 30px !important;
            padding-bottom: 30px !important;
            margin-bottom: 30px;
            padding-bottom: 30px !important;
            margin-bottom: 30px !important;
        }

        .subscribe-content-block{
            width:100% !important;
            padding-left:20px !important;
            padding-right:20px !important;
        }
    }

    @media only screen and (max-width: 1024px) and (min-width: 768px)  {
        .tdi_66_ebc .td_module_wrap {
            width: 33.33% !important;
            float: left;
            padding-left: 30px !important;
            padding-right: 30px !important;
            padding-bottom: 30px !important;
            padding-bottom: 30px !important;
            margin-bottom: 30px !important;
            min-height: 350px !important;
        }

        .tdi_66_ebc .entry-title{
            min-height: 65px !important;
        }
        #resource-posts-loop .td-image-wrap img.resources-img-wrap{
            height: auto !important;
        }
        .tdi_66_ebc .td-module-container {
            box-shadow: none !important; 
        }
        .tdi_66_ebc .td_module_wrap:hover .td-module-title a {
            box-shadow: none !important;
        }
    }

p.user-registration-register.register a {
    color: #04a353;
    text-decoration: underline;
}



</style>

<div class="td-main-content-wrap td-container-wrap">
    <div class=""><!--td-container-->
        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content">
                <div class="td-ss-main-content">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) : the_post();
                            ?>
                            <div class=""><!--td-page-content tagdiv-type preference-block-->

                                <div class="login-form-row second-login">
                                    <div class="login-form-col-1">
                                        <a href="<?php echo home_url(); ?>"><img src="https://techversions.com/wp-content/uploads/2021/02/TV-Logo-500-x-44-White.png" class="img-responsive desktoplogo" /></a>
                                        <!-- <h1 style="font-size: 35px;margin-top:55px;">Welcome to the Tech World!</h1> -->
                                        <?php $value = get_option('total_followers', ''); ?>

        <!-- <h4 style="color:#ffffff;font-size: 28px;line-height: 2em;">READ WHAT <span style="font-size:40px;"> <?php //echo $value;  ?> + </span> IT Deci	sion Makers Read Every Day </h4> -->

                                        <h4 style="color:#ffffff;font-size: 24px;line-height: 1.5em;text-transform: uppercase;" >READ WHAT <span style="font-size: 40px;"> <?php echo $value; ?>+ </span> IT Decision Makers Read Every Day </h4>

                                        <h4 style="color:#ffffff" >Access our premium content on the latest technology trends worldwide. Get exclusive insight into <span style="font-size: 30px;">5000+</span> freshly curated tech feeds, articles, and expert pieces. </h4> 


                                    </div>
                                   
                                    <div class="login-form-col-2">
                                    <a href="<?php echo home_url(); ?>"><img src="https://techversions.com/wp-content/uploads/2021/02/TV-Logo-500-x-44-White.png" class="img-responsive mobilelogo" /></a>
                                        <div id="login-block" style="<?php echo ((isset($_GET['page']) && $_GET['page'] !== 'register') || !isset($_GET['page']) || $currpage != 'register') ? 'display:block;' : 'display:none;'; ?>">
                                        <div id="login-block" style="<?php echo ($currpage != 'register') ? 'display:block;' : 'display:none;'; ?>">
                                            <h1 class="text-center">Sign in to get full access</h1>
                                            <!-- <h4 class="text-center" style="color:#000000">Join The Techversions Legacy Now! Sign in to get full access.</h4> -->

                                            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'registered') { ?>
                                                <div class="alert alert-success">Registration has been successful. Please check your email for verification.</div>
                                            <?php }
                                            if ((isset($_SESSION['registered']) && $_SESSION['registered'] == 'true') || (isset($_GET['msg']) && $_GET['msg'] == 'verified')) {
                                                ?>
                                                <div class="alert alert-success">Your email is successfully verified. Continue to login with your chosen password to explore Techversions</div>
                                                <?php
                                                unset($_SESSION['registered']);
                                            }
                                            ?>
        <?php echo do_shortcode('[user_registration_my_account]'); ?>
        <?php //echo  do_shortcode('[cr_login_form]'); ?>
  <!-- register cta btn -->
                                                    <?php
                                            if ($currpage != 'lost-password') { ?>
                                               <a href="<?php echo site_url('register'); ?>" style=""> <input type="button" value="New here? Register now. "  class="create-account-btn" /></a>
                                            <?php } ?>
                                            <div class="or" style="margin-top:15px;">OR</div>
                                            <div id="magic-link-div">
                                            <!--<button id="passwordless-login-btn" class="magic-link-btn"><i class="fa fa-magic"></i> Login with Magic Link</button>-->
                                                <!--<div id="passwordless-login-div" style="display: none;">-->
                                               <!--  <p style="color:#000000;text-align:center">
                                                    <b style="font-size: 15px;font-weight: 600;">Long password? Hard to type? </b><br /><br />
                                                    <span style="font-size: 12px">Worry not! Save time with our magic link and sign in instantly.</span>
                                                </p> -->
        <?php echo do_shortcode('[magiclink-login]'); ?></div>
                                            <!--</div>-->

                                                    <!-- <p>Don't have an account? Join the hub of Techversions!</p> -->
                                            <?php //if ($currpage != 'lost-password') { ?>
                                                        <!-- <input type="button" value="Create an Account" id="create-acc" class="create-account-btn" /> -->
        <?php //}  ?>
                                        </div>


                                    </div>
                                </div>
                                <?php
//                                the_content();
                                ?>
                                <div class="clearfix"></div>
                            </div>
                            <?php
                        endwhile; //end loop
                        comments_template('', true);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer('nomenu');
