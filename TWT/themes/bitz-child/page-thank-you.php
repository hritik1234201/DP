<?php
/* Template Name: Thank you page Template */
global $current_user;
//echo '<pre>';
//print_r($current_user);
//echo '</pre>';
get_header();

$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';

global $wpdb;
$myposts = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE ID = $resource_id AND post_status LIKE 'publish' AND (post_type NOT LIKE 'attachment' AND post_type NOT LIKE 'sdm_downloads' AND post_type NOT LIKE 'revision');");


$download_resource_id = get_post_meta($myposts->ID, 'sdm_description', true);
if(!empty($download_resource_id)) {
    $download = $wpdb->get_row("SELECT * FROM wp_sdm_downloads WHERE post_id = {$download_resource_id} ORDER BY id DESC;");
}
//echo '<pre>';
//print_r("SELECT * FROM wp_sdm_downloads WHERE post_id = {$download_resource_id} ORDER BY id DESC;");
//echo '</pre>';
//echo '<pre>';
//print_r($download);
//echo '</pre>';
//die();

$categories = get_the_terms($myposts->ID, 'resource_types');
$category = array_pop($categories);
?>

<div class="td-main-content-wrap td-container-wrap" style="font-family:Muli !important">
    <div class="tdc-content-wrap <?php echo $td_sidebar_position; ?>">
        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content" role="main">
                <div class="td-ss-main-content">

                    <div class="td-page-content tagdiv-type thank-you-page" style="margin:1% auto 0 auto;">
                        <?php
                        if (have_posts()) {
                            while (have_posts()) : the_post();
                                ?>
                                
                                <!-- START -  Row 2-->
                                <div style="margin: 0 auto;width:100%; border-bottom: 1px solid #e1e1e1; box-shadow: 0px 3px 4px #e1e1e1;">
                                    <h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:Muli;">
                                        Thanks for your interest in our <?php echo $category->name; ?> titled<br />"<?php echo $myposts->post_title; ?>"
                                    </h1>
                                    <p style="margin:10px 10px 10px 10px;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> Your download will start automatically in <span id="timer">0 seconds</span>...<br>
                                        If your download does not start automatically, <a href="<?php echo (isset($download)) ? $download->file_url : '#'; ?>" target="_blank" style="text-decoration:underline">click here</a> to start your download. </p>
                                </div>
                                <?php if($current_user->user_email != '') { ?>
                                <!--<div style="display: block;width: 100%"><h4>Related Resources</h4></div>-->
                                <?php } ?>
                                <div class="row2 " style="">
                                    <?php if(empty($current_user) || $current_user->user_email == '') { ?>
                                    <div class="row2-col1 column" style="">
                                        <img style="padding-top: 21px;margin-bottom:0;" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416165358.png" />
                                    </div>
                                    <div class="row2-col2 column" style="">
                                        <h1 style="color:#0353A3;font-size: 46px;"><b>Become a FREE Subscriber</b></h1>
                                        <!--<h4 style="text-transform:uppercase;color:#0353A3"><b>Your free membership is on the way!</b></h4>-->
                                        <p style="color:#0353A3">Access to all our premium and latest Human Resource blogs, news, resources and many more for FREE. Simply signup below and get the FREE subscription TODAY!</p>
                                        <div id='subscription-form'>
                                        <?php echo do_shortcode('[Form id="15"]'); ?>
                                        </div>
                                        <div id='mobile-subscription-form' style="display: none;">
                                        <?php echo do_shortcode('[Form id="16"]'); ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php } else {
                                        ?>
                                    
                                    <?php // $related = get_posts(array('post_type' => 'resources', 'numberposts' => 4, 'post__not_in' => array(5985))); ?>
                                                <?php // if ($related) {
//                                                    foreach ($related as $single_post) {
                                                        ?>
<!--                                                        <div class="td-related-span3">
                                                            <div class="td_module_related_posts td-animation-stack td_mod_related_posts"><div class="td-module-image">
                                                                    <div class="td-module-thumb">
                                                                        <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" class="td-image-wrap" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal">
                                                                            <img class="entry-thumb td-animation-stack-type0-2" src="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" alt="<?php echo $single_post->post_title; ?>" title="<?php echo $single_post->post_title; ?>" data-type="image_tag" data-img-url="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" width="218" height="150">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="item-details">
                                                                    <h3 class="entry-title td-module-title" style="text-align: left;"><a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal"><?php echo $single_post->post_title; ?></a></h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span style="display:none;" id="pdfUrl"><?php echo $download->file_url; ?></span> 
                                                        <span id="timer" style="display:none;">0 seconds</span>-->
                                                    <?php // }
//                                                }
                                                ?>
                                    <?php } ?>
                                </div>
                                <!-- END -  Row 2-->
                                <?php
                            endwhile; //end loop
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div> <!-- /.td-pb-row -->
    </div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<script type="text/javascript">
    var count=4; 
	var counter=setInterval(timer, 1000); 
	
	function timer(){
		count=count-1;
		if (count < 0){   
			clearInterval(counter);   
			return;
		} 
		
		if(count>0){ 
			document.getElementById("timer").innerHTML=count + " seconds";
		} 
		else {	
			//L fix for forced file download
			var src = document.getElementById('pdfUrl').innerHTML;
			var fileName = src.substring(src.lastIndexOf("/") + 1, src.length);

			document.getElementById("timer").innerHTML="0 seconds"; 
			var meta = document.createElement('meta');
			meta.httpEquiv = "Refresh";
			meta.content = "0; url="+src;
			var link = document.createElement('a');
			link.href = src;
			link.download = fileName;
			if(window.navigator.msPointerEnabled === true){
				window.location.href = src;
			}
			
			if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
				document.getElementsByTagName('head')[0].appendChild(meta);
			}
			else{
                            <?php if($_GET['success']) { ?>
				fireEvent(link,'click');
                            <?php } ?>
			}
		} 
	}
	
	function fireEvent(obj,evt){
	    if( document.createEvent ) {
	      var evObj = document.createEvent('MouseEvents');
	      evObj.initEvent( evt, true, false );
	      obj.dispatchEvent( evObj );

	    } else if( document.createEventObject ) {
	    	location.href=obj.href;
	    }
	}
	
</script> 
<!-- Download pdf --> 
<span style="display:none;" id="pdfUrl"><?php echo (isset($download)) ? $download->file_url : '#'; ?></span>
<?php
get_footer();