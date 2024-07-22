
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/user-registration/myaccount/form-edit-profile.php.
 *
 * HOWEVER, on occasion UserRegistration will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.wpeverest.com/user-registration/template-structure/
 * @author  WPEverest
 * @package UserRegistration/Templates
 * @version 1.0.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>


<?php
// Add shortcode to display the login history
function login_history_shortcode($atts) {
    ob_start();
    ?>
    <table id="loginHistoryTable" class="display" style="width:100%">
        <thead>
            <tr>
                                <th width="30%">Date & Time</th>
                                <th width="15%">Source</th>
                                <th width="10%">Status</th>
                                <th width="20%">IP Address</th>
            </tr>
        </thead>
    </table>

    <script>
        jQuery(document).ready(function($) {
            $('#loginHistoryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        'action': 'login_history_ajax',
                    }
                },
                columns: [
                    { data: 'time_login'},
                    { data: 'operating_system'},
                    { data: 'login_status'},
                    { data: 'ip_address'}
                ]
                
            });
        });
    </script>
    <?php
    return ob_get_clean();
}




?>

<?php echo  do_shortcode('[login_history]'); ?>
    
<!--</div>-->
<!-- <script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#table_id').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script> -->

