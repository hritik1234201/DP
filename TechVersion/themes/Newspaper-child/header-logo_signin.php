<?php
//do_action( 'tdc_header' );
//if ( has_action( 'tdc_header' ) ) {
//    return;
//}
?>
<!doctype html >
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php wp_head(); ?>
        <style>
            .td-header-menu-wrap #lp-header-btn {
                padding: 1.8% 0 1% 1%;
            }
            .td-header-menu-wrap.td-affix #lp-header-btn {
                padding: 0.4% 0 1% 1%;
            }
        </style>
    </head>

    <body <?php body_class('tagdiv-small-theme') ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">
        <?php wp_body_open() ?>


        <!-- Mobile Search -->
        <div class="td-search-background"></div>
        <div class="td-search-wrap-mob">
            <div class="td-drop-down-search" aria-labelledby="td-header-search-button">
                <form method="get" class="td-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="td-search-close">
                        <a href="#"><i class="td-icon-close-mobile"></i></a>
                    </div>
                    <div role="search" class="td-search-input">
                        <span><?php esc_attr_e('Search', 'newspaper') ?></span>
                        <label for="td-header-search-mob">
                            <input id="td-header-search-mob" type="text" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                        </label>
                    </div>
                </form>
                <div id="td-aj-search-mob"></div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="td-menu-background"></div>
        <div id="td-mobile-nav">
            <div class="td-mobile-container">
                <!-- mobile menu top section -->
                <div class="td-menu-socials-wrap">
                    <!-- close button -->
                    <div class="td-mobile-close">
                        <a href="#"><i class="td-icon-close-mobile"></i></a>
                    </div>
                </div>

                <!-- menu section -->
                <div class="td-mobile-content">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'menu_class' => 'td-mobile-main-menu',
                        'fallback_cb' => 'tagdiv_wp_no_mobile_menu',
                        'link_after' => '<i class="td-icon-menu-right td-element-after"></i>'
                    ));

                    // if no menu
                    function tagdiv_wp_no_mobile_menu() {
                        if (current_user_can('switch_themes')) {
                            echo '<ul class="">';
                            echo '<li class="menu-item-first"><a href="' . esc_url(home_url('/')) . 'wp-admin/nav-menus.php?action=locations">Add menu</a></li>';
                            echo '</ul>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div id="td-outer-wrap" class="td-theme-wrap">
            <div class="tdc-header-wrap">
                <div class="td-header-wrap tdm-header tdm-header-style-2">
                    <div class="td-header-menu-wrap-full td-container-wrap td_stretch_container td_stretch_content_1200" style="height: 70px;">
                        <div class="td-header-menu-wrap td-header-gradient td-header-menu-no-search">
                            <div class="td-header-row td-header-main-menu" style="max-width: 93%;margin:0 auto;">
                                <div class="tdm-menu-btns-socials">
<!--                                    <div class="header-search-wrap">
                                        <div class="td-search-btns-wrap"> <a id="td-header-search-button" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="td-icon-search"></i></a> <a id="td-header-search-button-mob" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="td-icon-search"></i></a></div>
                                        <div class="td-drop-down-search">
                                            <form method="get" class="td-search-form" action="https://techversions.com/">
                                                <div role="search" class="td-head-form-search-wrap"> <input id="td-header-search" type="text" value="" name="s" autocomplete="off"><input class="wpb_button wpb_btn-inverse btn" type="submit" id="td-header-search-top" value="Search"></div></form>
                                        <div id="td-aj-search"></div></div>
                                    </div>-->
                                </div>
                                <div id="td-header-menu" role="navigation">
                                    
                                    <div id="td-top-mobile-toggle"><a href="#"><i class="td-icon-font td-icon-mobile"></i></a></div><div class="td-main-menu-logo td-logo-in-menu td-logo-sticky"> <a class="td-mobile-logo td-sticky-header" href="https://techversions.com/" data-wpel-link="internal"> <img src="https://techversions.com/wp-content/uploads/2021/01/TV-Logo-243-x-22-White.png" alt="TechVersions" title="TechVersions"> </a> <a class="td-header-logo td-sticky-header" href="https://techversions.com/" data-wpel-link="internal"> <img src="https://techversions.com/wp-content/uploads/2021/01/TV-Logo-243-x-22.png" alt="TechVersions" title="TechVersions"> <span class="td-visual-hidden">Tech Versions</span> </a></div>
                                    <div class="menu-menu-container">
                                        
                                        <div id="lp-header-btn" style="float: right;"><button class="button-submit">Subscribe</button></div>
                                        <ul id="menu-menu-1" class="sf-menu sf-js-enabled" style="float: right;">
                                            <li class="menu-item"><a class="td-login-modal-js menu-item" href="#login-form" data-effect="mpf-td-login-effect" style="display:none">Sign In popup</a><a class="menu-item" href="https://techversions.com/sign-in" data-effect="mpf-td-login-effect" data-wpel-link="internal">Sign in / Register</a><span class="td-sp-ico-login td_sp_login_ico_style"></span></li>
<!--                                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-first td-menu-item td-normal-menu menu-item-3952"><a href="https://techversions.com/" data-wpel-link="internal">Home</a></li> <li class="menu-item menu-item-type-post_type_archive menu-item-object-tech_news td-menu-item td-normal-menu menu-item-3784"><a href="https://techversions.com/news/" data-wpel-link="internal">News</a></li> <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children td-menu-item td-normal-menu menu-item-3214"><a class="sf-with-ul">Resources<i class="td-icon-menu-down"></i></a> <ul class="sub-menu" style="float: none; width: 11.5714em; display: none;"> <li class="menu-item menu-item-type-post_type_archive menu-item-object-white_papers td-menu-item td-normal-menu menu-item-3441" style="white-space: normal; float: left; width: 100%;"><a href="https://techversions.com/white-papers/" data-wpel-link="internal" style="float: none; width: auto;">White Papers</a></li> <li class="menu-item menu-item-type-post_type_archive menu-item-object-e_books td-menu-item td-normal-menu menu-item-3442" style="white-space: normal; float: left; width: 100%;"><a href="https://techversions.com/ebooks/" data-wpel-link="internal" style="float: none; width: auto;">EBooks</a></li> <li class="menu-item menu-item-type-post_type_archive menu-item-object-infographics td-menu-item td-normal-menu menu-item-3443" style="white-space: normal; float: left; width: 100%;"><a href="https://techversions.com/infographics/" data-wpel-link="internal" style="float: none; width: auto;">Infographics</a></li> </ul> </li> <li class="menu-item menu-item-type-post_type menu-item-object-page td-menu-item td-normal-menu menu-item-2365"><a href="https://techversions.com/blogs/" data-wpel-link="internal">Blogs</a></li> <li class="menu-item menu-item-type-post_type menu-item-object-page td-menu-item td-normal-menu menu-item-14159"><a href="https://techversions.com/covid-19/" data-wpel-link="internal">Covid-19</a></li> <li class="menu-item menu-item-type-post_type menu-item-object-page td-menu-item td-normal-menu menu-item-17152"><a href="https://techversions.com/subscribe/" data-wpel-link="internal">Subscribe</a></li>-->
<!--                                            <li class="menu-item menu-item-type-post_type menu-item-object-page td-menu-item td-normal-menu menu-item-17152"><a href="https://techversions.com/subscribe/" data-wpel-link="internal">Subscribe</a></li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div></div></div><div class="td-banner-wrap-full td-container-wrap td_stretch_container td_stretch_content_1200">
                        <div class="td-container-header td-header-row td-header-header">
                            <div class="td-header-sp-recs">
                                <div class="td-header-rec-wrap">
                                    <div class="td-a-rec td-a-rec-id-header tdi_1_066 td_block_template_4">
                                        <style>.tdi_1_066.td-a-rec{text-align:center;}.tdi_1_066 .td-element-style{z-index:-1;}.tdi_1_066.td-a-rec-img{text-align:left;}.tdi_1_066.td-a-rec-img img{margin:0 auto 0 0;}@media(max-width:767px){
                                                .tdi_1_066.td-a-rec-img{text-align:center;}
                                            }</style><div class="td-all-devices"><a href="#" target="_blank"><img src="https://techversions.com/wp-content/uploads/2020/02/rec-header.jpg"></a></div></div></div></div></div></div></div>
            </div>