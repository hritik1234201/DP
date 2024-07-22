<?php
/**
 * Class tdb_menu
 * v 1.0  18 oct 2018
 */

class tdb_menu {

	private static $instance;
    private static $atts;

    var $is_header_menu_mobile = false;

    function __construct($atts) {
        self::$atts = $atts;
    }

	static function get_instance($atts) {

		if ( !isset( self::$instance ) ) {
			self::$instance = new tdb_menu($atts);
		}

        self::$atts = $atts;
		return self::$instance;
	}

    /**
     * adds mega menu support
     * @param $items - sorted menu items array
     * @param string $args - (stdClass) an object containing wp_nav_menu() arguments.
     * @return array
     */
    function hook_wp_nav_menu_objects( $items, $args ) {

        if ( strpos( $args->menu_class, 'tdb-block-menu' ) === false ) {
            return $items;
        }

        /**
         * Internal array to keep the references of the items (ID item is the key -> item itself)
         * This helps to not look for an item into the $items list
         */
	    $_items_ref      = array();
	    $items_buffy     = array();
        $td_is_firstMenu = true;
        $td_is_firstMegamenu = true;
        $td_is_firstMegamenuCats = true;
        $td_has_subMenu = false;

        foreach( $items as $menu_item ) {
            if( $menu_item->menu_item_parent == 0 && in_array('menu-item-has-children', $menu_item->classes ) ) {
                $td_has_subMenu = true;
            }
        }

        if ( $td_has_subMenu === false && !empty($items[1]) ) {
        	$items[1]->classes[] = 'tdb-cur-menu-item';
        }

        foreach ( $items as &$item ) {

	        $_items_ref[$item->ID] = $item;

            if ( !isset( $item->classes ) ) {
                $item->classes = array();
            }

            $item->is_mega_menu = false; // all items should have this property, we just init it here - when an item has this flag on it means that the item is the mega menu dropdown!

            // first menu fix
            if ( $td_is_firstMenu ) {
                $item->classes[] = 'menu-item-first';
                $td_is_firstMenu = false;
            }

            // add the menu item pull down class on top menu items
            if ( $item->menu_item_parent == 0 ) {
                $item->classes[] = 'tdb-menu-item-button';
            }

            // fix the down arrows + shortcodes
            if ( strpos( $item->title,'[') === false ) {

            } else {
                // on shortcodes [home] etc.. do not show down arrow
                $item->classes[] = 'tdb-no-down-arrow';
            }

            // run shortcodes
            $item->title = do_shortcode($item->title);

            // read mega menu and mega page menu settings
            $mm_cat = get_post_meta( $item->ID, 'td_mega_menu_cat', true );
            $td_mega_menu_page_id = get_post_meta( $item->ID, 'td_mega_menu_page_id', true );

            // mega menu loading type
            $p_mm_loading = !empty( self::$atts['mm_ajax_preloading'] ) ? self::$atts['mm_ajax_preloading'] : '';

	        // an item with a page - page mega menu
            if ( $td_mega_menu_page_id != '' && td_api_features::is_enabled('page_mega_menu') === true ) {

                // the parent item (the one that appears in the main menu)
                $item->classes[] = 'tdb-menu-item';
                $item->classes[] = 'tdb-mega-menu tdb-mega-menu-inactive';
                $item->classes[] = 'tdb-mega-menu-page';
                $items_buffy[] = $item;

                // create a new mega menu item: - this is just the dropdown menu / not the parent
                $new_item = $this->generate_wp_post();
                $new_item->is_mega_menu = true; // this is sent to the menu walkers
                $new_item->menu_item_parent = $item->ID;
                $new_item->url = '';

                // read the page content
                $content_post = get_post($td_mega_menu_page_id);

				// page mm id
	            $new_item->p_mm_id = '';

				// cat mm id
	            $new_item->cat_mm_id = '';

                if ( null !== $content_post ) {

	                // add mega menu page id to td_global::$mega_menu_pages_ids array (used to load google fonts used on a mega menu page @see td_util::check_mega_menu_pages())
	                if ( !in_array( $td_mega_menu_page_id, td_global::$mega_menu_pages_ids ) ) {
		                td_global::$mega_menu_pages_ids[] = $td_mega_menu_page_id;
	                }

					// set page mm page id
	                $new_item->p_mm_id = $td_mega_menu_page_id;

					// check loading type
	                if ( $p_mm_loading === 'ui_delayed' && !( tdc_state::is_live_editor_ajax() || tdc_state::is_live_editor_iframe() ) ) {
                        // do nothing, the page mm content will be loaded on user interaction events

		                //$new_item->title .= '<pre class="p_mm_ui_delayed" style="background-color: orangered; color: white;">';
		                //$new_item->title .= print_r( $p_mm_loading, true );
		                //$new_item->title .= '</pre>';

	                } else {

		                $content = $content_post->post_content;

		                $has_content_filter = false;

		                if ( is_plugin_active('td-subscription/td-subscription.php' ) && has_filter('the_content', array( tds_email_locker::instance(), 'lock_content' ) ) ) {
			                $has_content_filter = true;
			                remove_filter( 'the_content', array( tds_email_locker::instance(), 'lock_content' ) );
		                }

		                $content = apply_filters( 'the_content', $content );
		                $content = str_replace(']]>', ']]&gt;', $content );

		                //if ( tdc_state::is_live_editor_ajax() || tdc_state::is_live_editor_iframe() ) {
		                //    $content = 'Content not shown in composer';
		                //} else {
		                //    $content = $content_post->post_content;
		                //    $content = apply_filters( 'the_content', $content );
		                //    $content = str_replace( ']]>', ']]&gt;', $content );
		                //}

		                if ( !empty( $has_content_filter ) ) {
			                add_filter( 'the_content', array( tds_email_locker::instance(), 'lock_content' ) );
		                }

		                // the has_filter check is made for plugins, like bbpress, who think it's okay to remove all filters on 'the_content'
		                if ( !has_filter( 'the_content', 'do_shortcode' ) ) {
			                $new_item->title .= do_shortcode($content);
		                } else {
			                $new_item->title .= $content;
		                }

	                }

                }

	            $items_buffy[] = $new_item;

            } elseif ( $mm_cat != '' ) {

                // an item with a category mega menu
                $has_subcategories = get_categories( array(
                    'child_of' => $mm_cat
                ));

                // the parent item (the one that appears in the main menu)
                $item->classes[] = 'tdb-menu-item';
                $item->classes[] = 'tdb-mega-menu tdb-mega-menu-inactive';
                $item->classes[] = 'tdb-mega-menu-cat';

                // first mega menu regular class
                if ( $td_is_firstMegamenu ) {
                    if( empty($has_subcategories) ) {
                        $item->classes[] = 'tdb-mega-menu-first';
                        $td_is_firstMegamenu = false;
                    }
                }

                // first mega menu with sub cats class
                if ( $td_is_firstMegamenuCats ) {
                    if( !empty( $has_subcategories ) ) {
                        $item->classes[] = 'tdb-mega-menu-cats-first';
                        $td_is_firstMegamenuCats = false;
                    }
                }

                $items_buffy[] = $item;

                // create a new mega menu item: - this is just the dropdown menu / not the parent
                $new_item = $this->generate_wp_post();

                /*
                 * it's a mega menu,
                 * - set the is_mega_menu flag
                 * - alter the last item classes  $last_item
                 * - change the title and url of the current item
                 */
                $new_item->is_mega_menu = true; //this is sent to the menu walkers
                $new_item->menu_item_parent = $item->ID;
                $new_item->url = '';

                self::$atts['category_id'] = $mm_cat;
                unset(self::$atts['class']);
                unset(self::$atts['tdc_css']);

                // check loading type
                if ( $p_mm_loading === 'ui_delayed' && !( tdc_state::is_live_editor_ajax() || tdc_state::is_live_editor_iframe() ) ) {

                    // save tdb_header_mega_menu atts
                    $new_item->td_atts = json_encode(self::$atts);

                    // set cat mm page id
                    $new_item->cat_mm_id = $mm_cat;

                    // do nothing, the mega menu category content will be loaded on user interaction events

                    //$new_item->title .= '<pre class="cat_mm_ui_delayed" style="background-color: #ff4500c2; color: white; margin: 20px; font-weight: bold; text-transform: uppercase; text-align: center;">';
                    //$new_item->title .= print_r( $p_mm_loading, true );
                    //$new_item->title .= '</pre>';

                } else {
                    $new_item->title = td_global_blocks::get_instance('tdb_header_mega_menu')->render(self::$atts);
                }

                $items_buffy[] = $new_item;

            } else {
                // normal menu item
                $item->classes[] = 'tdb-menu-item';
                $item->classes[] = 'tdb-normal-menu';

                $items_buffy[] = $item;
            }

	        /**
	         * - Because 'current_item_parent' (true/false) item property is not set by wp,
	         * we use an additional flag 'td_is_parent' to mark the parent elements of the tree menu
	         * - For the moment, the 'td_is_parent' flag is used just by the 'td_walker_mobile_menu'
	         * walker of the mobile theme version @see td_walker_mobile_menu
	         */
	        if ( isset( $item->menu_item_parent ) && 0 !== intval( $item->menu_item_parent ) && array_key_exists( intval( $item->menu_item_parent ), $_items_ref ) ) {
		        $_items_ref[intval($item->menu_item_parent)]->td_is_parent = true;

	        // WPML FIX! >>> When WPML language switcher is set in menu, on mobile it didn't render right (the first level element did not allow to open its submenu)
	        } else if (strpos( $item->ID, 'wpml') === 0 && in_array('menu-item-has-children', $item->classes )) {
                if (array_key_exists($item->ID, $_items_ref)) {
                    $_items_ref[$item->ID]->td_is_parent = true;
                }
            }
        }

        return $items_buffy;
    }

    function generate_wp_post() {
        $post = new stdClass;
        $post->ID = 0;
        $post->post_author = '';
        $post->post_date = '';
        $post->post_date_gmt = '';
        $post->post_password = '';
        $post->post_type = 'menu_tds';
        $post->post_status = 'draft';
        $post->to_ping = '';
        $post->pinged = '';
        $post->comment_status = '';
        $post->ping_status = '';
        $post->post_pingback = '';
        //$post->post_category = '';
        $post->page_template = 'default';
        $post->post_parent = 0;
        $post->menu_order = 0;
        return new WP_Post($post);
    }

}

// this walker is used to remove a wrapping <a> around the megamenu
class tdb_tagdiv_walker_nav_menu extends Walker_Nav_Menu {
    private static $atts;
    private static $td_is_firstSubmenu;
    private static $td_is_firstSubSubmenu;
    private static $td_is_firstSubmenuItem;
    private static $td_firstSubmenuParentID;

    public function __construct($atts) {
        self::$atts = $atts;
        self::$td_is_firstSubmenu = true;
        self::$td_is_firstSubSubmenu = true;
        self::$td_is_firstSubmenuItem = true;
        self::$td_firstSubmenuParentID = null;
    }

    function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		if ( !isset($depth) ) {
    		$depth = 0;
	    }

		$id_field = $this->db_fields['id'];
        if ( is_object($args[0]) ) {
            $args[0]->has_children = !empty( $children_elements[$element->$id_field] );
        }

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if( in_array('menu-item-has-children', $classes ) ) {
            $classes[] = 'tdb-menu-item-inactive';
        }

        // composer editor adjustments
        if ( tdc_state::is_live_editor_ajax() || tdc_state::is_live_editor_iframe() ) {

            // remove current item classes
            $current_item_classes = array( 'current-menu-ancestor', 'current-menu-parent', 'current-menu-item', 'current-category-ancestor' );
            $classes = str_replace( $current_item_classes, '', $classes );

            // add classes for the first sub menu & first sub sub menu
            if ( in_array('menu-item-has-children', $classes ) ) {
                if ( self::$td_is_firstSubmenu && $item->menu_item_parent == 0 ) {
                    $classes[] = 'tdb-first-submenu';
                    $classes[] = 'current-menu-ancestor';
                    $classes[] = 'current-menu-parent';
                    self::$td_is_firstSubmenu = false;
                    self::$td_firstSubmenuParentID = $item->ID;
                } else if ( self::$td_is_firstSubSubmenu && $item->menu_item_parent != 0 ) {
                    $classes[] = 'tdb-first-sub-submenu';
                    self::$td_is_firstSubSubmenu = false;
                }
            }

            // add current menu item class for first item in first submenu
            if( ( (int) $item->menu_item_parent === self::$td_firstSubmenuParentID ) && self::$td_is_firstSubmenuItem ) {
                $classes[] = 'current-menu-item';
                self::$td_is_firstSubmenuItem = false;
            }

            // if we have no submenus, add the current menu item class to the first top menu item
            // *** the 'tdb-cur-menu-item' class is added to teh first top menu item if the menu dose not have any submenus
            if ( in_array('tdb-cur-menu-item', $classes ) ) {
                $classes[] = 'current-menu-item';
            }

        }

        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         *
         * @since 3.0.0
         *
         * @param array  $classes The CSS classes that are applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of arguments. @see wp_nav_menu()
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's <li>.
         *
         * @since 3.0.1
         *
         * @param string The ID that is applied to the menu item's <li>.
         * @param object $item The current menu item.
         * @param array $args An array of arguments. @see wp_nav_menu()
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

	    // if item is a mega menu maybe add the page mm id
	    if ( $item->is_mega_menu && !empty( $item->p_mm_id ) ) {
		    $p_mm_id_data = 'data-p-mm-id="' . $item->p_mm_id . '"';
		    $output .= $indent . '<li' . $id . $value . $class_names . $p_mm_id_data . '>';
        // if item is a mega menu maybe add the cat mm id
	    } elseif ( $item->is_mega_menu && !empty( $item->cat_mm_id ) ) {
		    $cat_mm_id_data = 'data-cat-mm-id="' . $item->cat_mm_id . '"';
		    $output .= $indent . '<li' . $id . $value . $class_names . $cat_mm_id_data . '>';
	    } else {
		    $output .= $indent . '<li' . $id . $value . $class_names .'>';
	    }

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's <a>.
         *
         * @since 3.6.0
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
         *
         *     @type string $title  The title attribute.
         *     @type string $target The target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item The current menu item.
         * @param array  $args An array of arguments. @see wp_nav_menu()
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        //tagdiv - megamenu disable link from from includes/wp_booster/td_menu.php  hook_wp_nav_menu_objects
        if ($item->is_mega_menu == false) {
            $item_output .= '<a'. $attributes .'>';
        }

        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . '<div class="tdb-menu-item-text">' . ( $item->is_mega_menu ? $item->title : apply_filters( 'the_title', $item->title, $item->ID ) ) . '</div>' . $args->link_after;

        //tagdiv - megamenu disable link from includes/wp_booster/td_menu.php   hook_wp_nav_menu_objects
        $svg_list = td_global::$svg_theme_font_list;
        $main_sub_menu_icon = isset(self::$atts['main_sub_tdicon']) ? self::$atts['main_sub_tdicon'] : '';
        $main_sub_menu_icon_data = '';
        if( td_util::tdc_is_live_editor_iframe() || td_util::tdc_is_live_editor_ajax() ) {
            $main_sub_menu_icon_data = 'data-td-svg-icon="' . $main_sub_menu_icon . '"';
        }
        $sub_menu_icon = isset(self::$atts['sub_tdicon']) ? self::$atts['sub_tdicon'] : '';
        $sub_menu_icon_data = '';
        if( td_util::tdc_is_live_editor_iframe() || td_util::tdc_is_live_editor_ajax() ) {
            $sub_menu_icon_data = 'data-td-svg-icon="' . $sub_menu_icon_data . '"';
        }
        if ($item->is_mega_menu == false) {
            if( $args->has_children ) {
                if( $item->menu_item_parent == 0 ) {
                    if( $main_sub_menu_icon != '' ) {
                        if( array_key_exists( $main_sub_menu_icon, $svg_list ) ) {
                            $item_output .= '<span class="tdb-sub-menu-icon tdb-sub-menu-icon-svg tdb-main-sub-menu-icon" ' . $main_sub_menu_icon_data . '>' . base64_decode($svg_list[$main_sub_menu_icon]) . '</span>';
                        } else {
                            $item_output .= '<i class="tdb-sub-menu-icon ' . $main_sub_menu_icon . ' tdb-main-sub-menu-icon"></i>';
                        }
                    }
                } else {
                    if( $sub_menu_icon != '' ) {
                        if( array_key_exists( $sub_menu_icon, $svg_list ) ) {
                            $item_output .= '<span class="tdb-sub-menu-icon tdb-sub-menu-icon-svg" ' . $sub_menu_icon_data . '>' . base64_decode($svg_list[$sub_menu_icon]) . '</span>';
                        } else {
                            $item_output .= '<i class="tdb-sub-menu-icon ' . $sub_menu_icon . '"></i>';
                        }
                    }
                }
            }
            $item_output .= '</a>';
        }

        if( $item->menu_item_parent == 0 ) {
            $sep_icon = isset(self::$atts['sep_tdicon']) ? self::$atts['sep_tdicon'] : '';
            if( $sep_icon != '' ) {
                if( array_key_exists( $sep_icon, $svg_list ) ) {
                    $item_output .= '<span class="tdb-menu-sep tdb-menu-sep-svg">' . base64_decode($svg_list[$sep_icon]) . '</span>';
                } else {
                    $item_output .= '<i class="tdb-menu-sep ' . $sep_icon . '"></i>';
                }
            }
        } else {
            $item_output .= '';
        }

        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes $args->before, the opening <a>,
         * the menu item's title, the closing </a>, and $args->after. Currently, there is
         * no filter for modifying the opening and closing <li> for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of arguments. @see wp_nav_menu()
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


class tdb_walker_mobile_menu extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		/** This filter is documented in wp-includes/post-template.php */
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );


		// TAGDIV: The $link_after of args is added for parent items
		if (isset($item->td_is_parent) && true === $item->td_is_parent) {
			$item_output .= $args->link_after;
		}

		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}





