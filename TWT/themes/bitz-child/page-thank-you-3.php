<?php
/* Template Name: Thank you page - 3 Template */

get_header('download');
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">


<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- JQuery -->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>-->


<!-- START Modal: modalPoll -->
<?php // if(!$_GET['succes']) {     
//    echo '<pre>';
//     print_r($_REQUEST);
//     echo '</pre>';
//     echo '<pre>';
//     print_r($_SESSION);
//     echo '</pre>';  
     
//} ?>
<!-- END Modal: modalPoll -->


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
                                <!-- START -  Row 1-->
                                <div class="row1" style="
                                     border-bottom: 1px solid #ededed;
                                     box-shadow: 0px 3px 3px #ededed;
                                     border-radius: 10px;">
                                    <div style="max-width: 80%;margin: 0 auto;display: flex">
                                        <div class="row1-col1" style="width: 50%"><img class="head-logo-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161652.png" /></div>
                                        <div class="row1-col2 a2a_kit" style="width: 50%;padding: 2% 0;text-align: right">
                                            <span>
                                                <a class="a2a_button_facebook"><img class="social-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161715.png" /></a>
                                            </span>
                                            <span>
                                                <a class="a2a_button_linkedin"><img class="social-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161720.png" /></a>
                                            </span>
                                            <span>
                                                <a class="a2a_button_twitter"><img class="social-img" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161723.png" /></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- END -  Row 1-->
                                
                                <!-- START -  Row 2-->
                                <div style="margin: 0 auto;width:100%;    border-bottom: 1px solid #e1e1e1;
    box-shadow: 0px 3px 4px #e1e1e1;
}"><h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:Muli;">
                                        Thanks for your interest in our White Paper titled<br />"The Employee Experience Platform Has Arrived"</h1></div>
                                
                                <div id='iframe-parent'>
                                    <?php 
//                                    echo do_shortcode('[flipbook pdf="https://resource.thehrempire.com/assets/The_Employee_Experience_Imperative.pdf" height="800"]');
//                                    echo do_shortcode('[pdf id=159]');
                                    echo do_shortcode('[pdf-embedder url="https://resource.thehrempire.com/assets/The_Employee_Experience_Imperative.pdf"]');
//                                    echo do_shortcode('[ipages id="1"]');
                                    ?>
                                </div>
<!--                                <div class="row2" style="max-width: 80%;margin: 2% auto 6% auto;display: flex;">
                                    <div class="row2-col1" style="width:40%">
                                        <img style="padding-top: 21px;margin-bottom:0;" src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416165358.png" />
                                    </div>
                                    <div class="row2-col2" style="width:60%;padding-left:3%">
                                        <h1 style="color:#0353A3;font-size: 46px;"><b>Become a FREE Subscriber</b></h1>
                                        <h4 style="text-transform:uppercase;color:#0353A3"><b>Your free membership is on the way!</b></h4>
                                        <p style="color:#0353A3">Access to all our premium and latest Human Resource blogs, news, resources and many more for FREE. Simply signup below and get the FREE subscription TODAY!</p>
                                        <?php echo do_shortcode('[Form id="8"]'); ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>-->
                                <!-- END -  Row 2-->
                        
                                <!-- START -  Row 3-->
                                <div class="row3" style="background-color: #0353A3;
    /*position: fixed;*/
    bottom: 0;
    width: 100%;
    color: white;
    text-align: center;
    display: flex;
"> 
                                    <div class="row3-col1" style="width: 50%;padding: 2% 0;text-align: left;margin-left: 10%;">
                                        <?php
//                                        wp_nav_menu(array(
//                                            'menu' => 'td-demo-custom-menu',
//                                            'menu_class'=> 'td-subfooter-menu landing-page-menus',
//                                        ));
//
//                                        // if no menu
//                                        function tagdiv_wp_no_footer_menu() {
//                                            if ( current_user_can( 'switch_themes' ) ) {
//                                                echo '<ul class="td-subfooter-menu landing-page-menus">';
//                                                echo '<li class="menu-item-first"><a href="' . esc_url(home_url('/')) . 'wp-admin/nav-menus.php?action=locations">Add menu</a></li>';
//                                                echo '</ul>';
//                                            }
//                                        }
                                        ?>
                                        
                                        &copy; 2020 All Rights Reserved. The HR Empire.
                                    </div>
                                    <div class="row3-col2" style="width: 50%;text-align: right"><img src="https://resource.thehrempire.com/wp-content/uploads/2020/04/Image20200416161727.png" class="footer-logo" style="" /></div>
                                        
                                    <div class="clearfix"></div>
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
    var count=1; 
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

//			document.getElementById("timer").innerHTML="0 seconds"; 
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
                            <?php if($_GET['succes']) { ?>
//				fireEvent(link,'click');
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
<span style="display:none;" id="pdfUrl">https://resource.thehrempire.com/assets/The_Employee_Experience_Imperative.pdf</span>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<?php
get_footer('download');