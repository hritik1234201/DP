<?php
/* Template Name: Sign-In Page Template */

if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}
get_header('landingpage');
global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));
$link_array = explode('/', $current_url);
$currpage = end($link_array);
?>
<style>
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

    #wpa-submit{
        height:40px !important;
        text-transform: capitalize !important;
        border-radius: 5px !important;
    }

    #login-block{
        background-color: rgba(215, 215, 215, 0.33);
        padding: 10px 50px 50px 50px;
        border-radius: 10px;	
        transition-duration: 0.50s;
        transition-property: filter, box-shadow, background, border-radius, border-color;
        border-radius: 1px;
        box-shadow: 0px 0px 30px 0px rgb(60 60 60 / 35%);

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

    a {
        color:#000000;
    }

    p.user-registration-register.register {
        text-align: center;
        font-size: 15px;
        font-weight: 600;
    }



    .login-form-col-1{
        /* text-align: center; */
        padding: 14% 5%;
    }

    .login-form-row.second-login {
        background-repeat: no-repeat; 
        background-size: cover;
        height: 100vh;
    }

    .login-form-col-1 h1, .login-form-col-1 h2{
        color: #FFF;
    }

    .login-form-col-2 {
        /* background-color: #F0F0F0;
         padding: 1% 8%; */
        padding: 3% 5%;
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
        background-color: #052F85;
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
        padding: 14px;
        border: #000000 2px solid;
        border-radius: 10px;
        font-size: 18px;
        color: #000000;
        background-color: #FFF;
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

    .pull-on-left {
        color: #052F85;
        font-family: Kanit, sans-serif;
        font-weight: 400;
        font-size: 14px;
        line-height: 1.8;
        letter-spacing: 1px;
        border: 1px solid #052F85;
        border-radius: 5px;                   
        padding: 12px 20px;
        white-space: nowrap;
    }

    .pull-on-right {
        color: #fff;
        font-family: Kanit, sans-serif;
        font-weight: 400;
        font-size: 11px;
        line-height: 1.5;
        letter-spacing: 1px;
        padding: 12px 15px;
        white-space: normal;
        background-color: #009eed;
        margin-right: 0;
        border-radius: 3px;
        cursor: pointer;
        text-transform: uppercase;
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
        background-color: #052F85 !important;
    }

    /*END -- Login Page*/


    @media (max-width: 979px) {
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

        .pull-on-left {
            padding: 12px 2px !important;
        }

        .span-pull-left {
            margin-left: -20px;
        }

        .pull-on-right {
            margin-top: 38px;
            left: 130px;
            position: absolute;
        }

        #login-block{
            padding: 10px 50px 80px 50px;
        }

        span .pull-right .lost-password-span {
            padding: 12px 40px;
        }
    }

    @media (max-width: 767px) {
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
        color: #052F85;
        text-decoration: underline;
    }
	
	.pull-on-left123 {
	/* color: #052F85;
    font-family: Kanit, sans-serif;
    font-weight: 400;
    font-size: 14px;
    line-height: 1.8;
    letter-spacing: 1px; 
    border: 1px solid #052F85;
    border-radius: 5px;
    padding: 10px 10px; */
	
	color: #052F85;
    font-family: Kanit, sans-serif;
    font-weight: 400;
    border: 1px solid grey;
    padding: 1px 5px;
    border-radius: 5px; 
	}
	
</style>

<div class="vc_col-lg-12 vc_col-sm-12 login-form-row second-login">
    <div class="vc_col-lg-6 vc_col-sm-6 right-container login-form-col-2" style="margin-top:20px;padding-bottom:20px;">
    <!--<div id="login-block" style="<?php echo ((isset($_GET['page']) && $_GET['page'] !== 'register') || !isset($_GET['page']) || $currpage != 'register') ? 'display:block;' : 'display:none;'; ?>">-->
        <div id="login-block" style="<?php echo ($currpage != 'register') ? 'display:block;' : 'display:none;'; ?>">
            <h1 class="text-center" style='margin-top: 30px;margin-bottom: 5px;'>Sign in to get full access</h1>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'registered') { ?>
                <div class="alert alert-success">Please check your email for verification</div>
                <?php
            }
            if ((isset($_SESSION['registered']) && $_SESSION['registered'] == 'true') || (isset($_GET['msg']) && $_GET['msg'] == 'verified')) {
                ?>
                <div class="alert alert-success">Your email is successfully verified. Continue to login with your chosen password to explore TechWeb Trends</div>
                <?php
                unset($_SESSION['registered']);
            }
            
            $magiclink_login_div = 'display: block;';
            if(isset($_GET['magic-link']) && $_GET['magic-link'] === 'true') {
                $magiclink_login_div = 'display: none;';
            }
            ?>

            <div id="login-div" class="tab1" style="<?php echo $magiclink_login_div; ?>">
                <?php echo do_shortcode('[user_registration_my_account]'); ?>
            </div>
			
			<div class="vc_col-lg-12 vc_col-sm-12 vc_col-md-12 vc_col-xs-12" style="padding:0px;margin-top:25px;">
			<div class="vc_col-lg-8 vc_col-sm-8 vc_col-md-8 vc_col-xs-12" style="padding:0px;">
			<div class="pull-on-left1234" style="margin-bottom:15px;">
                                <a style="text-decoration:underline;" href="https://techwebtrends.com/register">Not a member yet?  Register Now</a>
            </div>
			</div>
            <div class="vc_col-lg-4 vc_col-sm-4 vc_col-md-4 vc_col-xs-12" style="padding:0px;">
			<div class="pull-on-left123" style="float:right;">
                                <a class="pull-on-left1243" href="https://techwebtrends.com">Return to Home</a>
            </div>
			</div>
            </div> 


            <!--<div class="or">OR</div>-->
            <?php
            $magic_link_hideshow = 'display: none;';
            if(isset($_GET['magic-link']) && $_GET['magic-link'] === 'true') {
                $magic_link_hideshow = 'display: block;';
            }
            ?>
            <div id="magic-link-div" class="tab2" style="<?php echo $magic_link_hideshow; ?>">
               <!-- <p style="color:#000000;">
                    <b style="font-size: 15px;font-weight: 600;">Long password? Hard to type? </b><br />
                    <span style="font-size: 12px">Worry not! Save time with our magic link and sign in instantly.</span>
                </p>-->
                <?php echo do_shortcode('[magiclink-login]'); ?>
                <div style="text-align:center;margin-top:20px;">
                    <a href='#' id="hide-magic-link-btn" style='color: #FFF;
                       font-family: Kanit, sans-serif;
                       font-weight: 400;
                       font-size: 14px;
                       line-height: 1.8;
                       letter-spacing: 1px;
                       border: 0px solid #052F85;
                       border-radius: 5px;
                       background-color: rgba(0, 158, 237, 1);
                       padding: 12px 20px;
                       white-space: nowrap;'><i class="fa fa-long-arrow-alt-left"></i> &nbsp;Go Back to Login</a>
                </div>
            </div>
			
			                
                  
			
			
            <div style="text-align: center">
                <hr style='height: 0px;'>
              <!--  <a href='<?php //echo site_url('register'); ?>' style='color: #FFF;
                   font-family: Kanit, sans-serif;
                   font-weight: 400;
                   font-size: 14px;
                   line-height: 1.8;
                   letter-spacing: 1px;
                   border: 0px solid #052F85;
                   border-radius: 5px;
                   background-color: #052F85;
                   padding: 12px 20px;
                   white-space: nowrap;'>Not a member yet?  Register Now</a> -->
				   
				   
				   
				   
				   
				 <!--  <span style="float:left" class="span-pull-left">
                        <a href="https://techwebtrends.com/register" class="pull-on-left">Not a member yet?  Register Now</a>
                    </span>
                    <span style="float:right">
                        <a class="pull-on-right" href="https://techwebtrends.com">Home</a>
                    </span> -->
            </div>

        </div>

    </div>

    <div class="vc_col-lg-6 vc_col-sm-6 left-container login-form-col-1" style='text-align: center;'>
        <!--<div class="page-header1">
        <h1>Sign In</h1>
        </div>-->
        <!--<div>-->
        <a href="<?php echo home_url(); ?>"><img src="https://techwebtrends.com/wp-content/uploads/2015/09/Logo-Desktop.png" class="img-responsive" /></a>
        <!--</div>-->
        <!-- <h1 style="font-size: 35px;margin-top:55px;">Welcome to the Tech World!</h1> -->
        <?php $value = get_option('total_followers', ''); ?>

        <!-- <h4 style="color:#ffffff;font-size: 28px;line-height: 2em;">READ WHAT <span style="font-size:40px;"> <?php //echo $value;          ?> + </span> IT Deci	sion Makers Read Every Day </h4> -->

        <h4 style="font-size: 25px;line-height: 1.5em;text-transform: uppercase;margin-top:20px;">JOIN OUR EXCLUSIVE COMMUNITY OF TECH-SAVVY PROFESSIONALS FROM AROUND THE GLOBE</h4>

        <h4 style="">Sign in now to gain exclusive access to daily tech trends, popular articles, the latest product offerings, and recently trending blogs. </h4> 
<!--        <a href='<?php echo site_url(); ?>' style='color: #FFF;
                   font-family: Kanit, sans-serif;
                   font-weight: 400;
                   font-size: 14px;
                   line-height: 1.8;
                   letter-spacing: 1px;
                   border: 0px solid #052F85;
                   border-radius: 5px;
                   background-color: #052F85;
                   padding: 12px 20px;
                   white-space: nowrap;'>Go to Home</a>-->
    </div> 

</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#magic-link-btn').click(function () {
//            alert('hello');
            jQuery('#magic-link-div').show('slow');
            jQuery('#login-div').hide('slow');
        });

        jQuery('#hide-magic-link-btn').click(function () {
//            alert('hello');
            jQuery('#magic-link-div').hide('slow');
            jQuery('#login-div').show('slow');
        });
    });
</script>
<?php
get_footer('login');
