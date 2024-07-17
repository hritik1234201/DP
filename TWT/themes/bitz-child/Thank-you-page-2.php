<?php
/* Template Name: Thank you page - 2 Template */

get_header();

$resource_id = (isset($_GET['r_id']) && !empty($_GET['r_id'])) ? base64_decode(urldecode($_GET['r_id'])) : '1';
global $wpdb;
$myposts = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE ID = $resource_id AND post_status LIKE 'publish' AND (post_type NOT LIKE 'attachment' AND post_type NOT LIKE 'sdm_downloads' AND post_type NOT LIKE 'revision');");

$download_resource_id = get_post_meta($myposts->ID, 'sdm_description', true);
if(!empty($download_resource_id)) {
    $download = $wpdb->get_row("SELECT * FROM wp_o0gCImmh0o00eqjs_sdm_downloads WHERE post_id = {$download_resource_id} ORDER BY id DESC;");
}
echo '<pre>';
print_r($file_url);
echo '</pre>';
$file_url = $download->file_url;

$categories = get_the_terms($myposts->ID, 'resource_types');
$category = array_pop($categories);
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
                                <div style="margin: 0 auto;width:100%;border-bottom: 1px solid #e1e1e1;box-shadow: 0px 3px 4px #e1e1e1;"><h1 style="font-size:35px;text-align: center;padding: 10px 0;font-family:Muli;">
                                        Thanks for your interest in our <?php echo $category->name; ?> titled<br />"<?php echo $myposts->post_title; ?>"</h1></div>
                                
                                <div id='iframe-parent' style="width: 90%; margin: 0 auto">
                                    <?php 
                                    echo do_shortcode('[pdf-embedder url="'.$download->file_url.'"]');
                                    ?>
                                </div>
                                
                                <div style="margin: 20px; text-align: center"><a href="<?php echo (isset($download)) ? $download->file_url : '#'; ?>" target="_blank" style="text-decoration:underline">Click here</a> to download the <?php echo $category->name; ?></div>
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
    var checkExist = setInterval(function() {
        if (jQuery('.pdfemb-next').length) {
           jQuery('.pdfemb-next').click(function(){
               jQuery.ajax({
                    type: "get",
                    dataType: "json",
                    url: td_ajax_url,
                    data: {'action': "save_in_user_meta",'read_pages': jQuery('.pdfemb-page-num').html(),'total_pages': jQuery('.pdfemb-page-count').html(),'file_url': '<?php echo $file_url; ?>','resource_id': <?php echo $resource_id; ?>},
                    beforeSend: function () {
                    }, success: function (response) {
                        console.log('Sucess');
                        console.log(response);
                    }, error: function () {
                        console.log('Error');
                    }
                });
           });
           clearInterval(checkExist);
        }
     }, 100);
	
</script> 
<!-- Download pdf --> 
<span style="display:none;" id="pdfUrl">https://resource.thehrempire.com/assets/The_Employee_Experience_Imperative.pdf</span>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<?php
get_footer();