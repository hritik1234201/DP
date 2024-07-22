<!--
Header style multipurpose 2
-->

<?php
$header_bg_img_class = '';
if ( !td_util::get_option('tds_header_background_image') == '' ) {
    $header_bg_img_class = 'td-header-background-image';
}
?>

<div class="td-header-wrap tdm-header tdm-header-style-2 <?php echo $header_bg_img_class ?>">
    <?php if(!td_util::get_option('tds_header_background_image') == '') { ?>
        <div class="td-header-bg td-container-wrap <?php echo td_util::get_option('td_full_header_background'); ?>"></div>
    <?php } ?>

    <?php if(td_util::get_option('tds_top_bar') == '') { ?>
        <div class="td-header-top-menu-full td-container-wrap <?php echo td_util::get_option('td_full_top_bar'); ?>">
            <div class="td-container td-header-row td-header-top-menu">
                <?php td_api_top_bar_template::_helper_show_top_bar() ?>
            </div>
        </div>
    <?php } ?>

    <div class="td-header-menu-wrap-full td-container-wrap <?php echo td_util::get_option('td_full_menu'); ?>">
        <div class="td-header-menu-wrap td-header-gradient td-header-menu-no-search">
            <div class="td-container td-header-row td-header-main-menu">
                <?php require_once('tdm-header-menu-h1.php');?>
            </div>
        </div>
    </div>

    <?php if (td_util::is_ad_spot_enabled('header')) { ?>
        <div class="td-banner-wrap-full td-container-wrap <?php echo td_util::get_option('td_full_header'); ?>">
            <div class="td-container-header td-header-row td-header-header">
                <div class="td-header-sp-recs">
                    <?php
                        if( defined( 'TD_STANDARD_PACK' ) ) {
                            require_once( TDSP_THEME_PATH . '/parts/header/ads.php');
                        } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
//$token = $_GET['ur_token'];
if(isset($_GET['ur_token']) && !empty($_GET['ur_token'])) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
//        jQuery('.td-login-modal-js').click();

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-top-full-width",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "5000",
              "hideDuration": "5000",
              "timeOut": "20000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            };
            
            toastr["success"]("Your email has been successfully verified. Please Sign-In to access our premium content.");
        });
    </script>
    <?php
}
if(isset($_GET['msg']) && !empty($_GET['msg'])) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-top-full-width",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "5000",
              "hideDuration": "5000",
              "timeOut": "20000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            };
            
            toastr["success"]("You have been successfully registered. Please check your email for confirmation.");
        });
    </script>
    <?php
}
?>
<script type="text/javascript">
    var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<!--<div class="alert alert-primary">Hello WOrld</div>-->