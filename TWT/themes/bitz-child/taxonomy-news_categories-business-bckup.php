<?php get_header(); ?>



<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://thesalesmark.com/wp-content/themes/bitz-child/template/css/load-more-button.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://thesalesmark.com/wp-content/themes/bitz-child/template/js/load-more-button.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <style>
        .body-container-video{
            margin-top: 30px;
            margin-left: -20px;
            margin-right: -20px;
        }

        .body-container-video .wpb_column12.vc_column_container.latestmoreBox123.latestblogBox123.vc_col-lg-4.vc_col-xs-12.vc_col-md-4.vc_col-sm-4:nth-child(3n+1) {
            clear: both;
        }

        time.entry-date.updated.td-module-date {
            text-transform: capitalize !important;
            color: #c53f45 !important;
            font-style: italic !important;
            font-size: 11px;
        }

        #menu1 .wpb_column12.vc_column_container.blogBox.moreBox.vc_col-lg-12.vc_col-xs-12.vc_col-md-12.vc_col-sm-12:nth-child(1n+1){
            clear: both;
        }
    </style>

    <style>
        .nav123 {
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }
        .nav-pills>li {
            float: left;
        }
        .nav123>li {
            position: relative;
            display: block;
        }

        .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
            background-color: transparent !important;
            color: #1f1f1f !important;
        }


        .nav-pills>li>a {
            border-radius: 4px;
        }

        .nav123>li>a {
            position: relative;
            display: block;
            padding: 10px 15px;
            color: #1f1f1f !important;
        }
        .fade.in {
            opacity: 1;
        }
        .tab-content>.tab-pane{display:none}.tab-content>.active{display:block}

        .td-post-date{
            font-size: 11px;
            text-transform: capitalize !important;
            color: #c53f45 !important;
            font-style: italic !important;	
        }
    </style>

    <script>





        $(function () {
            $('.popup-youtube, .popup-vimeo').magnificPopup({
                //disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: true,
                fixedContentPos: true
            });
        });
    </script>

    <style>


        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .container123 {
            position: relative;
            /* text-align: center; */
            color: white;
        }



        .container-video {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
        }

        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            border: none;
        }


        .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover{
            background-color: transparent !important;
            color:#1f1f1f !important;
        }

        li.heading-category.active {
            border-top: 1px solid #c53f45 !important;
            top: -5px !important;
        }

        li.heading-category{
            color:#999 !important;
        }


        .td-image-container123 .td-module-thumb img{
            border-radius:10px;
        }


        .heading_wrapper_video {
            padding:20px 0px 0px 0px !important
        }
    </style>














    <!-- FEATURED INSIGHTS -->

    <!--	<div class="heading_wrapper_video">
            
            <h1 style="margin-bottom:10px;" class="tdb-title-text">Latest Audios</h1>

            </div> -->

    <div class="body-container-video">




        <?php
        ?>
<!--  <a href="<?php //echo get_term_link($category->term_id);  ?>" class="resource-category  td-post-category"><?php //echo $category->name;  ?></a> -->

        <?php
        $query = get_queried_object();
        $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
//        echo '<pre>';
//        print_r($query);
//        echo '</pre>';
        $args = array(
            'post_type' => 'news',
            'posts_per_page' => -1,
            'paged' => $page,
//            'cat'   => 2,
//            's' => $keywords, 
            'taxonomy' => $query->taxonomy,
            'term' => $query->slug,
        );
        query_posts($args);
        if (have_posts()) {
            while (have_posts()) : the_post();

//                $categories = get_the_terms($post->ID, 'audios_types');

//                foreach ($categories as $category) {

                    $cat = $category->term_id;

                    $post_thumbnail_url = '';

                    if (get_the_post_thumbnail_url(null, 'medium_large') != false) {
                        $post_thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large');
                    } else {
                        $post_thumbnail_url = get_template_directory_uri() . '/images/no-thumb/medium_large.png';
                    }
                    ?>

                    <?php
                    $custom = get_post_custom();
                    $test = array($custom);


                    $cats = get_post_meta(get_the_ID(), 'Custom_Tag', TRUE);
                    ?>


                    <div class="wpb_column12 vc_column_container latestmoreBox latestblogBox vc_col-lg-12 vc_col-xs-12 vc_col-md-12 vc_col-sm-12" style="padding-left: 20px;padding-right: 20px;">

                        <div class="td-image-container123 container123 vc_col-lg-3 vc_col-xs-12 vc_col-md-3 vc_col-sm-3">

                            <div class="td-module-thumb img-thumb"><img src="<?php echo esc_url($post_thumbnail_url) ?>" alt="<?php the_title_attribute() ?>" class="img-responsive"  /></div>





                        </div>

                        <div class="td-module-meta-info1234 vc_col-lg-9 vc_col-xs-9 vc_col-md-9 vc_col-sm-8" style="padding: 0px 15px 15px;">
                            <?php
//                            $categories = get_the_terms($post->ID, 'audios_types');
//                            foreach ($categories as $category) {
                                ?>
                                <!--<div class="resource-category123  td-post-category"><?php //echo $category->name;  ?></div>--> 
                            <?php // } ?> 

                            <h3 class="entry-title td-module-title new-title" style="font-weight:bold;font-size:16px;margin-bottom:10px;">




                                <?php //the_title_attribute()  ?><?php the_title() ?><br>



                            </h3>

                            <?php the_excerpt() ?>

                        </div>
                    </div>

                    <?php
//															}
//                }
            endwhile;
        }
        ?>



        <div id="latestloadMore" style="">
            <a href="#">Load More</a>
        </div>		 




    </div> 

    <!-- FEATURED INSIGHTS -->










    <?php
    get_footer();
    