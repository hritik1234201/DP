<?php
// See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules

function isa_add_every_five_minutes( $schedules ) {
    $schedules['every_five_minutes'] = array(
            'interval'  => 60 * 5,
            'display'   => __( 'Every 5 Minutes', 'textdomain' )
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'isa_add_every_five_minutes' ) ) {
    wp_schedule_event( time(), 'every_five_minutes', 'isa_add_every_five_minutes' );
}

// Hook into that action that'll fire every five minutes
add_action( 'isa_add_every_five_minutes', 'every_five_minutes_event_func' );
function every_five_minutes_event_func() {
    // do something here you can perform anything
    wp_mail( 'ramkiran@anteriad.com', 'testing', 'check next five Visit my blog for wordpress tutorial ...!');
}
?>