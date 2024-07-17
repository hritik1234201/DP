<?php
/*
 * Template Name: Newsletter PreferencePage Template
 */
get_header();

//$groups = sendgridController::fetch_groups();
//$unsubscribe_group = json_decode($groups);

$user_groups = sendgridController::get_supression_group();
$user_groups = json_decode($user_groups['response']);
//echo '<pre>';
//print_r($user_groups);
//echo '</pre>';
//$my_groups = array();
//foreach($user_groups->suppressions as $single_group) {
//    $my_groups[$single_group->id] = $single_group->id;
//}

alert('New Page');

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
      <div class="td-main-content-wrap td-container-wrap">
    <div class="td-container">
        <div class="td-crumb-container">
            <?php
            echo tagdiv_page_generator::get_breadcrumbs(array(
                'template' => 'page',
                'page_title' => get_the_title(),
            ));
            ?>
        </div>

        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content">
                <div class="td-ss-main-content">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) : the_post();
                            ?>
                            <div class="td-page-header">
                                <h1 class="entry-title td-page-title">
                                    <span><?php the_title() ?></span>
                                </h1>
                            </div>
                            <div class="td-page-content tagdiv-type preference-block">
                                <?php
                                the_content();
                                foreach ($user_groups->suppressions as $single_group) {
                                    ?>
                                    <div class="unsub-group td-pb-span4">
                                        <div class="grp-row1">
                                            <h4><?php echo $single_group->name; ?></h4>
                                        </div>
                                        <div class="grp-row2"><p><?php echo $single_group->description; ?></p>
                                        </div>
                                        <div class="grp-row3">
                                            <!-- Default switch -->
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" <?php echo ($single_group->suppressed == 1) ? 'checked' : ''; ?> class="custom-control-input" id="customSwitches-<?php echo $single_group->id; ?>">
                                                <label class="custom-control-label" for="customSwitches-<?php echo $single_group->id; ?>">Toggle to Subscribe/Un-subscribe</label>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="clearfix"></div>
                            </div>
                            <?php
                        endwhile; //end loop
                        comments_template('', true);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery('.custom-control-input').change(function () {
        var curr_ele = jQuery(this);
        var get_id_arr = curr_ele.attr('id').split('-');
        var group_id = get_id_arr[1];
        if (jQuery(curr_ele).prop("checked") === true) {
            //Toggle ON
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: "https://staging.thehrempire.com/wp-admin/admin-ajax.php",
                data: {action:'update_suppression_group_func',group_id: group_id},
                success: function (msg) {
                    if(msg.status === 'error') {
                        
                    }
                }, error: function() {
                    console.log('Error');
                }
            });
        } else {
            //Toggle OFF
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: "https://staging.thehrempire.com/wp-admin/admin-ajax.php",
                data: {action:'remove_receipient_func',group_id: group_id},
                success: function (msg) {
                    if(msg.status === 'error') {
                        
                    }
                }, error: function() {
                    console.log('Error');
                }
            });
        }
    });
</script>
<?php
get_footer();
