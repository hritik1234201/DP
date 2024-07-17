<style>
a:hover{
	text-decoration:none !important;
}
</style>    

<h2 style="margin-bottom: 20px;margin-left:15px;font-weight:700">Downloads</h2>

<?php
global $wpdb;
$customers = $wpdb->get_results("SELECT * FROM wp_sdm_downloads");
?>

<div class="container table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
<thead><tr>
<th>Title</th>
<th>Asset Type</th>
<th>Download On</th>
</tr>
</thead>


<?php 
$current_user = wp_get_current_user();

//printf( __( 'Username: %s', 'textdomain' ), esc_html( $current_user->user_login ) ) . '<br />';
//printf( __( 'User email: %s', 'textdomain' ), esc_html( $current_user->user_email ) ) . '<br />';
//printf( __( 'User first name: %s', 'textdomain' ), esc_html( $current_user->user_firstname ) ) . '<br />';
//printf( __( 'User last name: %s', 'textdomain' ), esc_html( $current_user->user_lastname ) ) . '<br />';
//printf( __( 'User display name: %s', 'textdomain' ), esc_html( $current_user->display_name ) ) . '<br />';
//printf( __( 'User ID: %s', 'textdomain' ), esc_html( $current_user->ID ) );

 
    if ( 0 == $current_user->ID ) {
        echo "Not logged in.";
    
	


} else  {
	
	
	
	  
	
 foreach($customers as $customer){ 
 
 print $current_user->visitor_name;
 
  if($customer->visitor_name == $current_user->user_login  ){
	  
	  
	  
 ?>


<tr>
 <td><a href="<?php echo $customer->file_url; ?>"><?php echo $customer->post_title; ?></a></td>
 <td>Resources<?php //echo $customer->time_logout; ?></td>
 <td><?php echo $customer->date_time; ?></td>
 <!-- <td><center><?php //echo $customer->visitor_name; ?></center></td> -->
 
 
</tr>

<?php } 
 }
	//echo 'user-re';


    } ?>

</table>
</div>

 <link href="https://thesalesmark.com/wp-content/themes/bitz/assets/custom-bootstrap.css" rel="stylesheet">

    <link href="https://thesalesmark.com/wp-content/themes/bitz/assets/datatables.bootstrap4.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="https://thesalesmark.com/wp-content/themes/bitz/assets/jquery.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="https://thesalesmark.com/wp-content/themes/bitz/assets/jquery.datatables.min.js"></script>

    <script src="https://thesalesmark.com/wp-content/themes/bitz/assets/datatables.bootstrap4.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>