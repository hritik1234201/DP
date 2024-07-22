<?php
//global fb_access_token = "EAAMZCKEprZBWgBACLy1khvUEoZCk6OMP5tZB7T668brANxSWGfSmvQZBRWtxZBLxiZCmy8lOTb5zxgdzQS6ZCCnOeALvqE1lITjAOHLDJmA6bUJV8XDLU7JkirAdqQLWdVp1Bcn7X3r9QGX2UNfYdzZBilQNlNpKyq3uvZBJ5JS4zMCegMAwvEmiMvulvtCsIfRzLUWeFqqk74cAZDZD";
function get_access_token() {
    return "EAAMZCKEprZBWgBACLy1khvUEoZCk6OMP5tZB7T668brANxSWGfSmvQZBRWtxZBLxiZCmy8lOTb5zxgdzQS6ZCCnOeALvqE1lITjAOHLDJmA6bUJV8XDLU7JkirAdqQLWdVp1Bcn7X3r9QGX2UNfYdzZBilQNlNpKyq3uvZBJ5JS4zMCegMAwvEmiMvulvtCsIfRzLUWeFqqk74cAZDZD";
}

function get_engaged_user() {
    //Last Year
    $fb_access_token = get_access_token();
    $months = fetch_months("months");
    $month_total = fetch_months("total");
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://graph.facebook.com/v16.0/techversions/insights?metric=page_engaged_users&date_preset=last_year&period=day&access_token=$fb_access_token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{}",
    ));

    $err = curl_error($curl);
    if(!empty($err)) {
        return 0;
    }

    $response = curl_exec($curl);
    $engagements = json_decode($response);
    $engagement_arr = $engagements->data[0]->values;

    foreach ($engagement_arr as $engagement) {

        $month = date('n', strtotime($engagement->end_time));
        if ($month > date('n')) {
            $month_total[$month] += (int) $engagement->value;
        }
    }

//Get Data for other pending CURR Year
//if ($month_key < 12) {
    $curl1 = curl_init();

    curl_setopt_array($curl1, array(
        CURLOPT_URL => "https://graph.facebook.com/v16.0/techversions/insights?metric=page_engaged_users&date_preset=last_year&period=day&access_token=$fb_access_token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{}",
    ));

    $err1 = curl_error($curl1);
    if(!empty($err1)) {
        return 0;
    }

    $response1 = curl_exec($curl1);
    $engagements1 = json_decode($response1);
    $engagement_arr1 = $engagements1->data[0]->values;

    foreach ($engagement_arr1 as $engagement) {

        $month = date('n', strtotime($engagement->end_time));
        if ($month <= date('n')) {
            $month_total[$month] += (int) $engagement->value;
        }
    }

    $user_engagement = array();
    foreach ($months as $key => $month) {
        $user_engagement[] = (isset($month_total[$key])) ? (int) $month_total[$key] : 0;
    }

    $engagements_arr = array(array(
            'name' => 'Page Engaged Users',
            'data' => $user_engagement,
            'stack' => 'Page Engaged Users',
    ));


    $engagement_json = json_encode($engagements_arr);
    return $engagement_json;
}

$engaged_user_json = get_engaged_user();
?>


<div id="container_facebook" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div style="width:100%;border-bottom: 1px solid #cecece;margin-bottom: 30px;"></div>

<!--<div id="fb_impressions_container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div style="width:100%;border-bottom: 1px solid #cecece;margin-bottom: 30px;"></div>-->

<script type="text/javascript">
    var engagement_json = <?php echo $engaged_user_json; ?>;
    console.log(engagement_json);
    Highcharts.chart('container_facebook', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'User Engagement on Page',
            align: 'left'
        },

        xAxis: {
            categories: month_arr
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Enagement Numbers'
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

        series: engagement_json
    });

    //FB Insights - Page User Engagement
//    var engagement_json = '<?php echo json_encode($engagements_arr); ?>';
//    console.log(engagement_json);
//    Highcharts.chart('container_facebook', {
//        chart: {
//            type: 'column'
//        },
//        title: {
//            text: 'Page User Engagement for the Current Year',
//            align: 'left'
//        },
//        xAxis: {
//            categories: month_arr
//        },
//        yAxis: {
//            allowDecimals: false,
//            min: 0,
//            title: {
//                text: 'Page User Engagement'
//            }
//        },
//        tooltip: {
//            formatter: function () {
//                return '<b>' + this.x + '</b><br/>' +
//                        this.series.name + ': ' + this.y + '<br/>' +
//                        'Total: ' + this.point.stackTotal;
//            }
//        },
//        plotOptions: {
//            column: {
//                stacking: 'normal'
//            }
//        },
//        series: engagement_json
//    });
</script>