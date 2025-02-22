<?php

class td_block_17 extends td_block {

    static function cssMedia( $res_ctx ) {

        // fonts
        $res_ctx->load_font_settings( 'f_header' );
        $res_ctx->load_font_settings( 'f_ajax' );
        $res_ctx->load_font_settings( 'f_more' );

        // module 4 fonts
        $res_ctx->load_font_settings( 'm4f_title' );
        $res_ctx->load_font_settings( 'm4f_cat' );
        $res_ctx->load_font_settings( 'm4f_meta' );
        $res_ctx->load_font_settings( 'm4f_ex' );
        // module 8 fonts
        $res_ctx->load_font_settings( 'm8f_title' );
        $res_ctx->load_font_settings( 'm8f_cat' );
        $res_ctx->load_font_settings( 'm8f_meta' );

    }

    public function get_custom_css() {
        // $unique_block_class - the unique class that is on the block. use this to target the specific instance via css
        $unique_block_class = $this->block_uid;

        $compiled_css = '';

        $raw_css =
            "<style>

				/* @f_header */
				.$unique_block_class .td-block-title a,
				.$unique_block_class .td-block-title span {
					@f_header
				}
				/* @f_ajax */
				.$unique_block_class .td-subcat-list a,
				.$unique_block_class .td-subcat-dropdown span,
				.$unique_block_class .td-subcat-dropdown a {
					@f_ajax
				}
				/* @f_more */
				.$unique_block_class .td-load-more-wrap a {
					@f_more
				}
				/* @m4f_title */
				.$unique_block_class .td_module_4 .entry-title {
					@m4f_title
				}
				/* @m4f_cat */
				.$unique_block_class .td_module_4 .td-post-category {
					@m4f_cat
				}
				/* @m4f_meta */
				.$unique_block_class .td_module_4 .td-module-meta-info,
				.$unique_block_class .td_module_4 .td-module-comments a {
					@m4f_meta
				}
				/* @m4f_ex */
				.$unique_block_class .td_module_4 .td-excerpt {
					@m4f_ex
				}
				/* @m8f_title */
				.$unique_block_class .td_module_8 .entry-title {
					@m8f_title
				}
				/* @m8f_cat */
				.$unique_block_class .td_module_8 .td-post-category {
					@m8f_cat
				}
				/* @m8f_meta */
				.$unique_block_class .td_module_8 .td-module-meta-info,
				.$unique_block_class .td_module_8 .td-module-comments a {
					@m8f_meta
				}
			</style>";


        $td_css_res_compiler = new td_css_res_compiler( $raw_css );
        $td_css_res_compiler->load_settings( __CLASS__ . '::cssMedia', $this->get_all_atts() );

        $compiled_css .= $td_css_res_compiler->compile_css();

        return $compiled_css;
    }

    function render($atts, $content = null) {

        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        if (empty($td_column_number)) {
            $td_column_number = td_global::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $limit = $this->get_att('limit');

        $buffy = ''; //output buffer

        $buffy .= '<div class="' . $this->get_block_classes() . ' td-column-' . $td_column_number . '" ' . $this->get_block_html_atts() . '>';

		    //get the block js
		    $buffy .= $this->get_block_css();

		    //get the js for this block
		    $buffy .= $this->get_block_js();

            // block title wrap
            $buffy .= '<div class="td-block-title-wrap">';
                $buffy .= $this->get_block_title(); //get the block title
                $buffy .= $this->get_pull_down_filter(); //get the sub category filter for this block
            $buffy .= '</div>';

	        $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner td-column-' . $td_column_number . '">';
	        $buffy .= $this->inner($this->td_query->posts, $td_column_number, $limit); //inner content of the block
	        $buffy .= '</div>';

	        //get the ajax pagination for this block
	        $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $limit, $td_column_number = '') {

        $buffy = '';

        $td_block_layout = new td_block_layout();
        $td_post_count = 0; // the number of posts rendered

        if( $limit > 5 ) {
            if( $limit % 2 != 0 ) {
                $limit = $limit+1;
            }
            $limit = $limit / 2;
        }

        if (!empty($posts)) {
            foreach ($posts as $post) {

                $td_module_4 = new td_module_4($post, $this->get_all_atts());
                $td_module_8 = new td_module_8($post, $this->get_all_atts());

                switch ($td_column_number) {

                    case '1': //one column layout
                        $buffy .= $td_block_layout->open12(); //added in 010 theme - span 12 doesn't use rows
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_module_4->render();
                        } else {
                            $buffy .= $td_module_8->render();
                        }
                        $buffy .= $td_block_layout->close12();
                        break;

                    case '2': //two column layout
                        $buffy .= $td_block_layout->open_row();
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_block_layout->open6();
                            $buffy .= $td_module_4->render();
                            $buffy .= $td_block_layout->close6();
                        } else { //the rest
                            $buffy .= $td_block_layout->open6();
                            $buffy .= $td_module_8->render();
                        }
                        break;

                    case '3': //three column layout
                        $buffy .= $td_block_layout->open_row();
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_block_layout->open4();
                            $buffy .= $td_module_4->render();
                            $buffy .= $td_block_layout->close4();
                        } else { //2-3 cols
                            $buffy .= $td_block_layout->open4();
                            $buffy .= $td_module_8->render();

                            if ( $td_post_count == $limit ) { //make new column
                                $buffy .= $td_block_layout->close4();
                            }
                        }
                        break;
                }
                $td_post_count++;
            }
        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}