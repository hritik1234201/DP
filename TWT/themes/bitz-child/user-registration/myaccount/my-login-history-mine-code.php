<style>
a:hover{
	text-decoration:none !important;
}
</style>    

<h2 style="margin-bottom: 20px;margin-left:15px;font-weight:700">Login History</h2>


<?php
//echo get_option('timezone_string');




global $wpdb;
$customers = $wpdb->get_results("SELECT * FROM wp_fa_user_logins");
?>


<div class="container table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

<thead><tr>
<th>Log In</th>
<th>Logout</th>
<th>Browser</th>
<th>Ip Address</th>
<th>Operating System</th>
<th>Login & Logout Status</th>
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
 
  if($customer->user_id == $current_user->ID  ){
 
 ?>


<tr>
 <td><?php echo $customer->time_login; ?></td>
 <td><?php echo $customer->time_logout; ?></td>
 <td><?php echo $customer->browser; ?></td>
 <td><?php echo $customer->browser_version; ?></td>
 <td><?php echo $customer->operating_system; ?></td>
 <td><?php echo $customer->login_status; ?></td>
 
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