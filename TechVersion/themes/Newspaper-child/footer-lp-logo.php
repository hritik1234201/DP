    <div class="td-sub-footer-container td-container-wrap td_stretch_container td_stretch_content_1200">
        <div class="td-sub-footer-container td-container-wrap">
            <div class=""><!--td-container-->
                <div class="td-pb-row">
                    <div class="td-pb-span td-sub-footer-menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-menu',
                            'menu_class'=> 'td-subfooter-menu',
                            'fallback_cb' => 'tagdiv_wp_no_footer_menu',
                        ));

                        // if no menu
                        function tagdiv_wp_no_footer_menu() {
                            if ( current_user_can( 'switch_themes' ) ) {
                                echo '<ul class="td-subfooter-menu">';
                                echo '<li class="menu-item-first"><a href="' . esc_url(home_url('/')) . 'wp-admin/nav-menus.php?action=locations">Add menu</a></li>';
                                echo '</ul>';
                            }
                        }
                        ?>
                    </div>

                    <div class="td-pb-span td-sub-footer-copy">
<!--                        &copy;<?php echo date('Y');?>  Techversions. All rights reserved.-->
                        <img src="https://techversions.com/wp-content/uploads/2021/01/TV-Logo-243-x-22-White.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!--close td-outer-wrap-->

<?php wp_footer(); ?>

</body>
</html>