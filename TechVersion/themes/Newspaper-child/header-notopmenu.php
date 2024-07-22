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
                            <div class="td-container td-header-row td-header-main-menu">
                                <div class="tdm-menu-btns-socials">
                                                                         
                                </div>
                                <div id="td-header-menu" role="navigation">
                                    <div id="td-top-mobile-toggle"><a href="#"><i class="td-icon-font td-icon-mobile"></i></a></div><div class="td-main-menu-logo td-logo-in-menu td-logo-sticky"> <a class="td-mobile-logo td-sticky-header" href="https://techversions.com/" data-wpel-link="internal"> <img src="https://techversions.com/wp-content/uploads/2021/01/TV-Logo-243-x-22-White.png" alt="TechVersions" title="TechVersions"> </a> <a class="td-header-logo td-sticky-header" href="https://techversions.com/" data-wpel-link="internal"> <img src="https://techversions.com/wp-content/uploads/2021/01/TV-Logo-243-x-22.png" alt="TechVersions" title="TechVersions"> <span class="td-visual-hidden">Tech Versions</span> </a></div>
                                    <?php
                                    wp_nav_menu(array(
                'theme_location' => 'lp-header-menu',
                'fallback_cb' => 'tagdiv_wp_page_menu',
                'menu_class' => 'sf-menu tagdiv-small-theme-menu lp-header-menu-ul',
            ));

            //if no menu
            function tagdiv_wp_page_menu() {
                if (current_user_can('switch_themes')) {
                    echo '<ul class="sf-menu">';
                    echo '<li class="menu-item-first"><a href="' . esc_url(home_url('/')) . 'wp-admin/nav-menus.php?action=locations">Add menu</a></li>';
                    echo '</ul>';
                }
            }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="td-banner-wrap-full td-container-wrap td_stretch_container td_stretch_content_1200">
                        <div class="td-container-header td-header-row td-header-header">
                            <div class="td-header-sp-recs">
                                <div class="td-header-rec-wrap">
                                    <div class="td-a-rec td-a-rec-id-header tdi_1_066 td_block_template_4">
                                        <style>.tdi_1_066.td-a-rec{text-align:center;}.tdi_1_066 .td-element-style{z-index:-1;}.tdi_1_066.td-a-rec-img{text-align:left;}.tdi_1_066.td-a-rec-img img{margin:0 auto 0 0;}@media(max-width:767px){
                                                .tdi_1_066.td-a-rec-img{text-align:center;}
                                            }</style><div class="td-all-devices"><a href="#" target="_blank"><img src="https://techversions.com/wp-content/uploads/2020/02/rec-header.jpg"></a></div></div></div></div></div></div>-->
                </div>
            </div>