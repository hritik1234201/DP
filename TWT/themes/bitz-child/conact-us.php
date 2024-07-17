<?php
/* Template Name: Contact Us   */
get_header();
global $content_width;
$content_width = 1068;
$current_user = wp_get_current_user();
?> 

<style>
.fm-form-container.fm-theme1{
	width:100% !important;
}

input#wdform_2_element13 {
    border-right: 0px solid grey !important;
    border-left: 0px solid grey !important;
    border-top: 0px solid grey !important;
}


input#wdform_3_element13 {
    border-right: 0px solid grey !important;
    border-left: 0px solid grey !important;
    border-top: 0px solid grey !important;
}

textarea#wdform_4_element13 {
    border-right: 0px solid grey !important;
    border-left: 0px solid grey !important;
    border-top: 0px solid grey !important;
}
.fm-form-container.fm-theme1 .fm-form .wdform_footer {
    margin: 0px 0 0 0 !important;
}
</style>


<div class="td-main-content-wrap td-container-wrap contact-us">
    <!--<div class="td-container">-->
    <!--<div class="td-crumb-container">-->
    <?php
//            echo tagdiv_page_generator::get_breadcrumbs(array(
//                'template' => 'single',
//                'title' => get_the_title(),
//            ));
    ?>
    <!--</div>-->

    <div class="td-pb-row">
        <div class="td-pb-span12 td-main-content landing-page-2">
            <div class="td-ss-main-content">
            <div class="heading_wrapper">
		<h2>Contact Us</h2> 
		<div class="heading-line" style="background-color:#e2e2e2"><span style="background-color:#009eed"></span></div>	
		</div>
                <!-- START -  Row 2-->
		<div class="wpb_wrapper">
			<p style="margin-bottom: 15px;"><span style="font-weight: 400; font-size: 18px;">Have a tip, idea, or suggestion for us?</span></p>
<p style="margin-bottom: 25px;"><span style="font-weight: 400; font-size: 18px;">Use the form below to contact us and we will get in touch with you shortly. </span></p>
		</div>
	

                <div class="row2 wpb_column vc_column_container vc_col-sm-12" style="border: 1px solid #ccc;margin-bottom: 30px;">
                   
                          
							<span style="display: none;" id="get_user_email"><?php echo $current_user->user_email; ?></span>
                            <span style="display: none;" id="get_user_name"><?php echo $current_user->user_login; ?></span>
                            <?php echo do_shortcode('[Form id="1"]'); ?>
                        
                    
                </div>
                <!-- END -  Row 2-->
				
				
				<div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-8"><div class="vc_column-inner"><div class="wpb_wrapper">
	
		<!--<div class="wpb_wrapper">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3008.892310466369!2d-73.69030728511565!3d41.049484024838016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c297c7c4df953f%3A0xe9d1fbb99ac157ac!2s2%20International%20Dr%2C%20Port%20Chester%2C%20NY%2010573%2C%20USA!5e0!3m2!1sen!2sin!4v1663304466752!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	
	</div>-->
    <div class="wpb_wrapper" style="display:none">
			<div><strong>WORKING HOURS:</strong></div>
<div>Monday – Friday: 09:00 – 17:00</div><br>
<div><strong> OUR OFFICE:</strong></div>
<div>2 International Drive
Rye Brook, </div>
<div>New York 10573, USA</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-4"><div class="vc_column-inner"><div class="wpb_wrapper">
	<div class="wpb_text_column wpb_content_element ">
		

		</div>
	</div>
</div></div></div></div>

               
                

            </div>
        </div>
    </div>
    <!--</div>-->
</div>

<?php
get_footer();
