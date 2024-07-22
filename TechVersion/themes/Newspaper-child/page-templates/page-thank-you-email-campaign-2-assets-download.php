<?php
/* Template Name: Thank you page Template - Email Campaign 2 Assets Download */

get_header();

$pdf_link = get_post_meta($post->ID, 'pdf_link', true);
$redirect_url =  get_post_meta($post->ID, 'thankyoupage-redirecturl', true);
$resource_title = get_post_meta($post->ID, 'resource_title', true);
?>
<style>
.td-module-thumb .entry-thumb{
	margin:0 auto;
}
.cta-button{
	display:flex;
	justify-content: center;
	padding:30px 10px;
}
.cta-button a{
	display: inline-block;
    background: #292929;
    padding: 10px 20px;
    color: #ffffff;
	font-weight:bold;
}
</style>
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
                                        Thanks for your interest in <br />"<?php echo $resource_title; ?>"
                                    </h1>
                                    <p style="margin:0 0 10px 0;padding-bottom:0;color:#465760;font-size: 13px; text-align: center"> Your download will start automatically in <span id="timer">0 seconds</span>...<br>
                                        If your download does not start automatically, <a href="<?php echo $pdf_link; ?>" target="_blank" style="text-decoration:underline">click here</a> to start your download. </p>
                                </div>
                                <div class="row2 " style="">
                                    <div class="clearfix"></div>
                                </div>
                                <!-- END -  Row 2-->

                                <!-- START -  Row 3-->
                                <div class="single-whitepaper track-links" style="width:1068px;margin: 0 auto;">
                                    <div class="td_block_wrap td_block_related_posts tdi_12_89f td_with_ajax_pagination td-pb-border-top td_block_template_12">
                                        <!-- <div style="max-width: 300px;text-align: center;margin: 0 auto;">
											<?php $related = get_posts(array('post_type' => 'white_papers', 'numberposts' => 1, 'post__not_in' => array(5985))); ?>
											<?php if ($related) {
												foreach ($related as $single_post) {
													?>
													<div>
														<div>
															<div class="td-module-image">
																<div class="td-module-thumb">
																	<a target="_blank" href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" class="td-image-wrap" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal">
																		<img class="entry-thumb td-animation-stack-type0-2" src="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" alt="<?php echo $single_post->post_title; ?>" title="<?php echo $single_post->post_title; ?>" data-type="image_tag" data-img-url="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" width="218" height="150">
																	</a>
																</div>
															</div>
															<div class="item-details">
																<h3 class="entry-title td-module-title" style="text-align: center;"><a target="_blank" href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal"><?php echo $single_post->post_title; ?></a></h3>
															</div>
														</div>
													</div>
													<span style="display:none;" id="pdfUrl"><?php echo $download->file_url; ?></span> 
													<span id="timer" style="display:none;">0 seconds</span>
												<?php }
											}
											?>
                                        </div> -->
										<div class="cta-button">
											<div style="padding: 20px 25px;box-shadow: 0px 0px 3px 3px #eee;width:50%;float:left;">
												<?php echo do_shortcode('[Form id="158"]'); ?>
											</div>
											<div style="padding: 20px 25px;box-shadow: 0px 0px 3px 3px #eee;width:50%;float:left;margin-left:10px;">
												<img src="https://staging.digiinfluence.com/wp-content/uploads/2021/08/Image20210809110424.jpg" style="padding: 5px;width: 150px;float:left;">
												<div style="float: left;width: 50%;">
													<b>Manage Hybrid IT with AIOps to Increase Financial Transparency</b>	
													<p>
														To move your business forward, technology transformation is imperative. Most importantly,  maintaining agility and innovation while transferring data to hybrid is top of mind for many IT leaders.
														However, only 38% have the processes in place to manage a hybrid IT environment.
														Therefore to simplify the complex hybrid IT environments, this guide outlines how IBM Multi-Cloud Management Platform (MCMP) can help scale your business with its open, security-rich experience that maximizes ROI.
													</p>
													<a href="https://techversions.com/wp-content/uploads/2021/08/IBM-Multicloud-Management-Platform_-Overview.pdf">Download this guide now</a>
												</div>
											</div>
											<!-- <a id="my_link" name="my_link" target="_blank" href="https://influenceb2bintent.com/july-2021-summit.html?utm_source=leadership&amp;utm_medium=pballa">Go to event</a> -->
										</div>
										
                                    </div>
                                </div>
                                <!-- END -  Row 3-->
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
                        src = (src == '') ? '<?php echo $pdf_link; ?>' : src;
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
			else {
                            <?php if(!empty($redirect_url)) { ?>
                                location.href= '<?php echo $redirect_url; ?>';
                            <?php } else { ?>
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
	
	
	jQuery( document ).ready(function() {
		var email = '<?php echo $_GET["email"]; ?>';
		jQuery( ".track-links a" ).on( "click", function() {
			
			console.log('Clicked me');
			var href_link = jQuery(this).attr('href');
			jQuery.ajax({
				url: '/fetch/action.php',
				type: 'POST',
				dataType: 'json',
				data: { email:email, href_link },
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                traditional: true,
				success: function(data) {  
					console.log(data);
				}  
			});  

		});
	});
	</script> 
<!-- Download pdf --> 
<span style="display:none;" id="pdfUrl"><?php echo $pdf_link; ?></span>

<?php
get_footer();
