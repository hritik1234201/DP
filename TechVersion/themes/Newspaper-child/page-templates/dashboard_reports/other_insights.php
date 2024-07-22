<h2 style="display:none">Content Updates in <?php echo date('Y'); ?></h2>
<?php
$args = array(
    'fields' => 'id, post_type',
    'post_type' => array('post', 'news', 'white_papers', 'infographics', 'e_books', 'tech_news', 'videos', 'page'),
    'posts_per_page' => -1,
//        'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'date_query' => array(
        array(
            'after' => date('2022-m-d'),
            'before' => date('Y-m-d'),
            'inclusive' => true,
        )
    )
);
$posts = get_posts($args);
//    echo '<pre>';
//    print_r($posts->get_query(););
//    echo '</pre>';
$column_arr = array(
    'post' => array(
        'count' => 0,
        'title' => ' Blogs'
    ),
    'white_papers' => array(
        'count' => 0,
        'title' => ' Blogs'
    ),
    'e_books' => array(
        'count' => 0,
        'title' => ' Blogs'
    ),
    'infographics' => array(
        'count' => 0,
        'title' => ' Blogs'
    ),
    'videos' => array(
        'count' => 0,
        'title' => ' Blogs'
    ),
    'tech_news' => array(
        'count' => 0,
        'title' => ' Blogs'
    ),
//        'page'  => 'Thank You Pages'
);
$new_arr = $posts_array = array();

$post_arr = $typ_arr = $post_columns = array();
foreach ($posts as $post) {
    $time = strtotime($post->post_date);
    $month = date("n", $time); //date("M", $time);
    $year = date("Y", $time);
//        if ($post->post_type !== 'page') {
//        $post_arr[$month][$post->post_type][] = $post->post_title;
//        }
    if (isset($column_arr[$post->post_type])) {
        $posts_array[$post->post_type][$month] = $column_arr[$post->post_type]['count'] ++;
    }

//        if ($post->post_type == 'page') {
//            if (substr($post->post_title, 0, 14) === 'Thank You Page' || substr($post->post_title, 0, 9) === 'Thank You' || substr($post->post_title, 0, -3) === 'TYP') {
//                $post_arr[$month]['page'][] = $post->post_title;
//            }
//        }
}

foreach ($months as $key => $month) {
    $new_arr['post'][] = (isset($posts_array['post'][$key])) ? (int) $posts_array['post'][$key] : 0;
    $new_arr['tech_news'][] = (isset($posts_array['tech_news'][$key])) ? (int) $posts_array['tech_news'][$key] : 0;
    $new_arr['white_papers'][] = (isset($posts_array['white_papers'][$key])) ? (int) $posts_array['white_papers'][$key] : 0;
    $new_arr['e_books'][] = (isset($posts_array['e_books'][$key])) ? (int) $posts_array['e_books'][$key] : 0;
    $new_arr['infographics'][] = (isset($posts_array['infographics'][$key])) ? (int) $posts_array['infographics'][$key] : 0;
    $new_arr['videos'][] = (isset($posts_array['videos'][$key])) ? (int) $posts_array['videos'][$key] : 0;
//            $new_arr['white_papers'][] = (isset($posts_array['white_papers'][$key])) ? (int) $posts_array['white_papers'][$key] : 0;
}

$post_columns = array(array(
        'name' => 'Blogs',
        'data' => $new_arr['post'],
        'stack' => 'Blogs',
    ),
    array(
        'name' => 'News',
        'data' => $new_arr['tech_news'],
        'stack' => 'News',
    ),
    array(
        'name' => 'White Papers',
        'data' => $new_arr['white_papers'],
        'stack' => 'Resources',
    ), array(
        'name' => 'eBooks',
        'data' => $new_arr['e_books'],
        'stack' => 'Resources',
    ), array(
        'name' => 'Infographics',
        'data' => $new_arr['infographics'],
        'stack' => 'Resources',
    ), array(
        'name' => 'Videos',
        'data' => $new_arr['videos'],
        'stack' => 'Resources',
    ),
//        array(
//            'name' => 'Thank You Pages',
//            'data' => $new_arr['white_papers'],
//            'stack' => 'Pages',
//    )
);
?>
<div id="container_post_updates" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto;"></div>
<div style="width:100%;border-bottom: 1px solid #cecece;margin-bottom: 30px;"></div>

<!--<h2>User Registrations and Subscriptions</h2>-->
<?php
/* User Registrations */

$args = array(
    'date_query' => array(
        array(
            'after' => date('2022-m-1', strtotime('+1 month')),
            'before' => array(
                'year' => 2023,
                'month' => 2,
                'day' => 28,
            ),
            'inclusive' => true,
        ),
    ),
    'posts_per_page' => -1,
);
$registrations = new WP_User_Query($args);
$users = $registrations->get_results();

$user_arr = array();
foreach ($users as $user) {
    $time = strtotime($user->user_registered);
    $month = date("n", $time); //date("M", $time);
    $year = date("Y", $time);
    $user_arr[$month][] = $user->user_email;
}

/* Subscribers */
$results = $wpdb->get_results("SELECT Month(created_on) as month,YEAR(created_on) as year, COUNT(id) as subscribers FROM `subscriptions` WHERE verified=1 AND created_on BETWEEN '2022-01-01' AND '2023-01-01' GROUP BY YEAR(created_on), MONTH(created_on)");

$monthly_users = array();
foreach ($results as $result) {
    $monthly_users[$result->month] = $result->subscribers;
}
//    echo '<pre>';
//    print_r($monthly_users);
//    echo '</pre>';

$subscribers = $registers = array();
foreach ($months as $key => $month) {
    $subscribers[] = (isset($monthly_users[$key])) ? (int) $monthly_users[$key] : 0;
    $registers[] = (isset($user_arr[$key])) ? count($user_arr[$key]) : 0;
}

$subscribers_arr = array(array(
        'name' => 'Subscriptions',
        'data' => $subscribers,
        'stack' => 'Subscriptions',
    ), array(
        'name' => 'Registrations',
        'data' => $registers,
        'stack' => 'Registrations',
        ));

$subscribers_json = json_encode($subscribers_arr);
?>
<div id="container_users" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div style="width:100%;border-bottom: 1px solid #cecece;margin-bottom: 30px;"></div>


<script type="text/javascript">

    //Comparision Column Chart
    var subscribers_json = <?php echo $subscribers_json; ?>;
    Highcharts.chart('container_users', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'Subscriptions and Registrations of Year: 2022-2023',
            align: 'left'
        },

        xAxis: {
            categories: month_arr
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Count Users'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                        this.series.name + ': ' + this.y + '<br/>' +
                        'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },

        series: subscribers_json
    });


    //Comparision Column Chart
    var posts_json = <?php echo json_encode($post_columns); ?>;
    Highcharts.chart('container_post_updates', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'Content Updates for year 2022 - 2023',
            align: 'left'
        },

        xAxis: {
            categories: month_arr
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of Contents'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                        this.series.name + ': ' + this.y + '<br/>' +
                        'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },

        series: posts_json
    });


</script>