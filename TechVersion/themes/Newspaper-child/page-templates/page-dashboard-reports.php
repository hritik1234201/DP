<?php
/* Template Name: Dashboard Report */

get_header('noheader');
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<style type="text/css">
    h1,h2 {
        text-align: center;
    }
    h1 {
        /*text-decoration: underline;*/
    }
    .page-title {
        display:table-cell;color: #FFF; vertical-align:middle;
        color: #ffffff;
        font-family: Lato !important;
        font-size: 40px !important;
        line-height: 50px !important;
        font-weight: 600 !important;
    }

</style>
<script type="text/javascript">
    var month_arr = ['Jan\'23', 'Feb\'23', 'Mar\'23', 'Apr\'22', 'May\'22', 'Jun\'22', 'Jul\'22', 'Aug\'22', 'Sep\'22', 'Oct\'22', 'Nov\'22', 'Dec\'22'];
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<?php
$months = $months_total = array();
for ($i = 0; $i < 12; $i++) {
    $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
    $months[date('n', $timestamp)] = date('M', $timestamp);
}

ksort($months);

function fetch_months($type = "months") {
    $months = $months_total = array();
    for ($i = 0; $i < 12; $i++) {
        $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
        if ($type === 'total') {
            $months_total[date('n', $timestamp)] = 0;
        } else {
            $months[date('n', $timestamp)] = date('M', $timestamp);
        }
    }
    if ($type === 'total') {
        return $months_total;
    } else {
        ksort($months);
        return $months;
    }
}
?>
<div style="background-color: #04a353;width:100%;height: 290px;display: table;margin-bottom: 50px;">
    <h1 class="page-title">Dashboard Reports</h1>;
</div>

<div class="reports-page" style=" width: 80%;margin:0 auto;"><!-- margin: 20px;-->
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-dp_report" type="button" role="tab" aria-controls="nav-home" aria-selected="true">DP Reports</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-fb_report" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Facebook Report</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-li_report" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">LinkedIn Report</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-tw_report" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Twitter Report</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent" style="margin-top: 50px;">
        <div class="tab-pane fade show active" id="nav-dp_report" role="tabpanel" aria-labelledby="nav-dp_report-tab"><?php require_once __DIR__ . '/dashboard_reports/other_insights.php'; ?></div>
        <div class="tab-pane fade" id="nav-fb_report" role="tabpanel" aria-labelledby="nav-fb_report-tab"><?php require_once __DIR__ . '/dashboard_reports/facebook_insights.php'; ?></div>
        <div class="tab-pane fade" id="nav-li_report" role="tabpanel" aria-labelledby="nav-li_report-tab"><?php require_once __DIR__ . '/dashboard_reports/linkedin_insights.php'; ?></div>
        <div class="tab-pane fade" id="nav-tw_report" role="tabpanel" aria-labelledby="nav-tw_report-tab"><?php require_once __DIR__ . '/dashboard_reports/twitter_insights.php'; ?></div>
    </div>
</div>
<script type="text/javascript">
//        alert('Hello');
    var tabEl = document.querySelector('button[data-bs-toggle="tab"]');
    tabEl.addEventListener('show.bs.tab', function (event) {
        event.target; // newly activated tab
        event.relatedTarget; // previous active tab
        console.log(event);
    });
</script>
<?php
get_footer('landingpage');
