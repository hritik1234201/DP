<?php
/**
 * this is the default block template
 * Class td_block_header_18
 */
class td_block_template_18 extends td_block_template {



    /**
     * renders the CSS for each block, each template may require a different css generated by the theme
     * @return string CSS the rendered css and <style> block
     */
    function get_css() {


        // $unique_block_class - the unique class that is on the block. use this to target the specific instance via css
        $unique_block_class =  $this->get_unique_block_class();

        // the css that will be compiled by the block, <style> - will be removed by the compiler
        $raw_css = "
        <style>
            
            /* @style_general_template_18 */
            .td_block_template_18 {
                padding-top: 20px;
            }
            .td_block_template_18.td_block_mega_menu {
                padding-top: 0;
            }
            .td_block_template_18 .td-block-title {
                font-family: var(--td_default_google_font_1, 'Open Sans', 'Open Sans Regular', sans-serif);
                font-size: 55px;
                font-weight: bold;
                letter-spacing: -4px;
                line-height: 1;
                text-align: center;
                overflow: hidden;
                margin-bottom: 25px;
                text-transform: lowercase;
                margin-top: 0;
            }
            @media (min-width: 768px) and (max-width: 1018px) {
                .td_block_template_18 .td-block-title {
                    font-size: 35px;
                    margin-bottom: 18px;
                }
            }
            @media (max-width: 767px) {
                .td_block_template_18 .td-block-title {
                    font-size: 45px;
                    margin-bottom: 18px;
                }
            }
            .td_block_template_18 .td-block-title > span,
            .td_block_template_18 .td-block-title > a {
                padding: 0 20px 10px;
                display: inline-block;
                background: #06d3d5;
                background: -webkit-linear-gradient(-68deg, #06d3d5 30%,#2a81cb 80%);
                background: linear-gradient(156deg, #06d3d5 30%,#2a81cb 80%);
                color: #fff;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent;
            }
            @media (min-width: 768px) and (max-width: 1018px) {
                .td_block_template_18 .td-block-title > span,
                .td_block_template_18 .td-block-title > a {
                    padding: 0 20px 4px;
                }
            }
            @media (max-width: 767px) {
                .td_block_template_18 .td-block-title > span,
                .td_block_template_18 .td-block-title > a {
                    padding: 2px 10px;
                }
            }
            .td_block_template_18 .td-block-title-wrap .td-block-title .td-block-speech-bubble {
                font-family: var(--td_default_google_font_1, 'Open Sans', 'Open Sans Regular', sans-serif) !important;
                font-size: 12px !important;
                font-weight: 600;
                line-height: 1;
                letter-spacing: -0.6px !important;
                padding: 4px 8px;
                background-color: #2a81cb;
                color: #fff;
                -webkit-text-fill-color: #fff;
                position: absolute;
                border-radius: 3px 3px 3px 0;
                margin-left: 6px;
                top: -4px;
                text-transform: uppercase;
            }
            @media (min-width: 768px) and (max-width: 1018px) {
                .td_block_template_18 .td-block-title .td-block-speech-bubble {
                    font-size: 10px;
                    padding: 3px 6px;
                    border-radius: 2px 2px 2px 0;
                    top: 0;
                }
            }
            @media (max-width: 767px) {
                .td_block_template_18 .td-block-title .td-block-speech-bubble {
                    font-size: 10px;
                    padding: 3px 6px;
                    border-radius: 2px 2px 2px 0;
                    top: 0;
                }
            }
            .td_block_template_18 .td-block-title .td-block-speech-bubble:before {
                content: '';
                position: absolute;
                top: 100%;
                left: 0;
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 6px 6px 0 0;
                border-color: #2a81cb transparent transparent transparent;
            }
            .td_block_template_18 .td-block-title .td-block-subtitle {
                display: table;
                font-family: var(--td_default_google_font_1, 'Open Sans', 'Open Sans Regular', sans-serif);
                font-size: 15px;
                line-height: 1;
                font-style: italic;
                font-weight: normal;
                letter-spacing: normal;
                color: #808080;
                position: relative;
                margin: 2px auto;
                text-transform: none;
                max-width: 80%;
            }
            @media (max-width: 767px) {
                .td_block_template_18 .td-block-title .td-block-subtitle {
                    font-size: 13px;
                }
            }
            .td_block_template_18 .td-block-title .td-block-subtitle:before,
            .td_block_template_18 .td-block-title .td-block-subtitle:after {
                content: '';
                position: absolute;
                height: 1px;
                width: 1500px;
                top: 3px;
                bottom: 0;
                background-color: #e3e3e3;
            }
            .td_block_template_18 .td-block-title .td-block-subtitle:before {
                left: 100%;
                margin: auto 0 auto 20px;
            }
            @media (min-width: 768px) and (max-width: 1018px) {
                .td_block_template_18 .td-block-title .td-block-subtitle:before {
                    margin: auto 0 auto 15px;
                }
            }
            @media (max-width: 767px) {
                .td_block_template_18 .td-block-title .td-block-subtitle:before {
                    margin: auto 0 auto 10px;
                }
            }
            .td_block_template_18 .td-block-title .td-block-subtitle:after {
                right: 100%;
                margin: auto 20px auto 0;
            }
            @media (min-width: 768px) and (max-width: 1018px) {
                .td_block_template_18 .td-block-title .td-block-subtitle:after {
                    margin: auto 15px auto 0;
                }
            }
            @media (max-width: 767px) {
                .td_block_template_18 .td-block-title .td-block-subtitle:after {
                    margin: auto 10px auto 0;
                }
            }
            .td_block_template_18 .td-pulldown-filter-display-option:before {
                display: none;
            }
            
            
        
            /* @header_color_a */
            .$unique_block_class .td-block-title > span,
            .$unique_block_class .td-block-title > a {
                background: #06d3d5 !important;
                background: -moz-linear-gradient(-68deg, @header_color_a 30%, @header_color_b 80%) !important;
                background: -webkit-linear-gradient(-68deg, @header_color_a 30%,@header_color_b 80%) !important;
                background: linear-gradient(156deg, @header_color_a 30%,@header_color_b 80%) !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent;
            }
            
            
            /* @speech_bubble_text_size */
            body .$unique_block_class .td-block-title-wrap .td-block-title .td-block-speech-bubble {
                font-size: @speech_bubble_text_size !important;
            }
            /* @subtitle_text_size */
            body .$unique_block_class .td-block-title .td-block-subtitle {
                font-size: @subtitle_text_size;
            }
            


            /* @speech_bubble_color */
            .$unique_block_class .td-block-speech-bubble {
                background-color: @speech_bubble_color !important;
            }
            .$unique_block_class .td-block-speech-bubble:before {
                border-color: @speech_bubble_color transparent transparent transparent !important;
            }

            /* @subtitle_text_color */
            .$unique_block_class .td-block-subtitle {
                color: @subtitle_text_color !important;
            }

            /* @subtitle_border_color */
            .$unique_block_class .td-block-subtitle:before,
            .$unique_block_class .td-block-subtitle:after {
                background-color: @subtitle_border_color !important;
            }

            /* @accent_text_color */
            .$unique_block_class .td_module_wrap:hover .entry-title a,
            .$unique_block_class .td_quote_on_blocks,
            .$unique_block_class .td-opacity-cat .td-post-category:hover,
            .$unique_block_class .td-opacity-read .td-read-more a:hover,
            .$unique_block_class .td-opacity-author .td-post-author-name a:hover,
            .$unique_block_class .td-instagram-user a,
            .$unique_block_class .td-pulldown-filter-item .td-cur-simple-item,
            .$unique_block_class .td-pulldown-filter-link:hover {
                color: @accent_text_color !important;
            }

            .$unique_block_class .td-next-prev-wrap a:hover,
            .$unique_block_class .td-load-more-wrap a:hover {
                background-color: @accent_text_color !important;
                border-color: @accent_text_color !important;
            }

            .$unique_block_class .td-read-more a,
            .$unique_block_class .td-weather-information:before,
            .$unique_block_class .td-weather-week:before,
            .$unique_block_class .td-exchange-header:before,
            .td-footer-wrapper .$unique_block_class .td-post-category,
            .$unique_block_class .td-post-category:hover {
                background-color: @accent_text_color !important;
            }
        </style>
    ";

        $td_css_compiler = new td_css_compiler(self::get_common_css() . $raw_css );

        /*-- GENERAL -- */
        $td_css_compiler->load_setting_raw( 'style_general_template_18', 1 );

        // check if we have pulldown categories for css
        $td_pull_down_items = $this->get_td_pull_down_items();
        if (!empty($td_pull_down_items)) {
            $td_css_compiler->load_setting_raw('style_general_pulldown', 1);
        }

        $td_css_compiler->load_setting_raw('header_color', $this->get_att('header_color'));
        $td_css_compiler->load_setting_raw('header_text_color', $this->get_att('header_text_color'));
        $td_css_compiler->load_setting_raw('header_color_a', $this->get_att('header_text_color_a'));
        $td_css_compiler->load_setting_raw('header_color_b', $this->get_att('header_text_color_b'));

        //color one is empty
        if (empty($td_css_compiler->settings['header_color_a']) && !empty($td_css_compiler->settings['header_color_b'])) {
            $td_css_compiler->load_setting_raw('header_color_a', '#06d3d5');
        }
        //color two is empty
        if (!empty($td_css_compiler->settings['header_color_a']) && empty($td_css_compiler->settings['header_color_b'])) {
            $td_css_compiler->load_setting_raw('header_color_b', '#2a81cb');
        }

        $speech_bubble_text_size = $this->get_att('speech_bubble_text_size');
        $td_css_compiler->load_setting_raw('speech_bubble_text_size', $speech_bubble_text_size);
        if( $speech_bubble_text_size != '' && is_numeric( $speech_bubble_text_size ) ) {
            $td_css_compiler->load_setting_raw('speech_bubble_text_size', $speech_bubble_text_size . 'px');
        }

        $subtitle_text_size = $this->get_att('subtitle_text_size');
        $td_css_compiler->load_setting_raw('subtitle_text_size', $subtitle_text_size);
        if( $subtitle_text_size != '' && is_numeric( $subtitle_text_size ) ) {
            $td_css_compiler->load_setting_raw('subtitle_text_size', $subtitle_text_size . 'px');
        }

        $td_css_compiler->load_setting_raw('speech_bubble_color', $this->get_att('speech_bubble_color'));
        $td_css_compiler->load_setting_raw('subtitle_text_color', $this->get_att('subtitle_text_color'));
        $td_css_compiler->load_setting_raw('subtitle_border_color', $this->get_att('subtitle_border_color'));
        $td_css_compiler->load_setting_raw('accent_text_color', $this->get_att('accent_text_color'));

        $compiled_style = $td_css_compiler->compile_css();


        return $compiled_style;
    }


    /**
     * renders the block title
     * @return string HTML
     */
    function get_block_title() {

        $custom_title = $this->get_att('custom_title');
        $custom_url = $this->get_att('custom_url');

        $title_tag = 'h4';

        $block_title_tag = $this->get_att('title_tag');
        if(!empty($block_title_tag)) {
            $title_tag = $block_title_tag ;
        }

        if (empty($custom_title)) {
            $td_pull_down_items = $this->get_td_pull_down_items();
            if (empty($td_pull_down_items)) {
                //no title selected and we don't have pulldown items
                return '';
            }
            // we don't have a title selected BUT we have pull down items! we cannot render pulldown items without a block title
            $custom_title = 'Block title';
        }

        // speech bubble text
        $speech_bubble = '';
        $speech_bubble_text = $this->get_att('speech_bubble_text');
        if (!empty($speech_bubble_text)) {
            $speech_bubble = '<span class="td-block-speech-bubble">' . esc_html($speech_bubble_text) . '</span>';
        }

        // subtitle text
        $subtitle = '';
        $subtitle_text = $this->get_att('subtitle_text');
        if (!empty($subtitle_text)) {
            $subtitle = '<div class="td-block-subtitle">' . esc_html($subtitle_text) . '</div>';
        }

        // there is a custom title
        $buffy = '';
        $buffy .= '<' . $title_tag . ' class="td-block-title">';
        if (!empty($custom_url)) {
            $buffy .= '<a href="' . esc_url($custom_url) . '">' . esc_html($custom_title) . '' . $speech_bubble . '</span></a>';
        } else {
            $buffy .= '<span>' . esc_html($custom_title) . '' . $speech_bubble . '</span>';
        }
        $buffy .= $subtitle;
        $buffy .= '</' . $title_tag . '>';
        return $buffy;
    }


    /**
     * renders the filter of the block
     * @return string
     */
    function get_pull_down_filter() {
        $buffy = '';

        $td_pull_down_items = $this->get_td_pull_down_items();

        if (empty($td_pull_down_items)) {
            return '';
        }

        $buffy .= '<div class="td-wrapper-pulldown-filter">';
        $buffy .= '<div class="td-pulldown-filter-display-option">';


        //show the default display value
        $buffy .= '<div id="td-pulldown-' . $this->get_block_uid() . '-val"><span>';
        $buffy .=  $td_pull_down_items[0]['name'] . ' </span><i class="td-icon-down"></i>';
        $buffy .= '</div>';

        //builde the dropdown
        $buffy .= '<ul class="td-pulldown-filter-list">';
        foreach ($td_pull_down_items as $item) {
            $buffy .= '<li class="td-pulldown-filter-item"><a class="td-pulldown-filter-link" id="' . td_global::td_generate_unique_id() . '" data-td_filter_value="' . $item['id'] . '" data-td_block_id="' . $this->get_block_uid() . '" href="#">' . $item['name'] . '</a></li>';
        }
        $buffy .= '</ul>';

        $buffy .= '</div>';  // /.td-pulldown-filter-display-option
        $buffy .= '</div>';

        return $buffy;
    }
}
