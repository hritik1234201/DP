<style type="text/css">
    .linked_row {
        /*margin: 20px;*/
        text-align: center;
    }
    .linked_col {
        border: 1px solid #cecece;
        display: inline-block;
        padding: 20px;
        margin: 20px 10px;
        width: auto;
    }
</style>
<h2> LinkedIn Insights </h2>
<?php
//curl -X GET 'https://api.linkedin.com/rest/organizationPageStatistics?q=organization&organization={organization URN}' \
//-H 'Authorization: Bearer {INSERT_TOKEN}'
//Page ID = 506828140
//curl -X GET 'https://api.linkedin.com/rest/organizationalEntityFollowerStatistics?q=organizationalEntity&organizationalEntity={organization URN}' \
//-H 'Authorization: Bearer {INSERT_TOKEN}'
//FOllower Statistics

/* $curl = curl_init();


  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.linkedin.com/rest/organizationalEntityFollowerStatistics?q=organizationalEntity&organizationalEntity=urn:li:organization:30987048",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "{}",
  CURLOPT_HTTPHEADER => array(
  "Authorization: Bearer AQWrEG6T7Deamcib64bbUZjzPr8JyVlJ59eHRyGuSJv-9MWUuToapxubMNeq6tA6s0QC6m8T8TfyRgojz1lCifCxUB4DNKwfUqlxdsvfEyDqcURc5ILpdz-EAVXJkPyOloWpX5bc0ByH6rboeHUgOET2y_zCketATDL7binj4B1EEukVAfEHCFGXpX2UTPCUqcV7xiY6rc3AmcLNqJy-vxS5EspaBXaU0IADrfbGzJCnsddv_Qnny54Tlot58NOCCA8j8w1DGKqmTfOf12oyptub8lO9c-p51nGOrSU6mgY4jR2i7vE6BXmfscyUX9Axp7Kjka7FOCuP7vNLuhnRM1iXyhkwkA",
  "LinkedIn-Version: 202302",
  //        "X-Restli-Protocol-Version: 2.0.0",
  ),
  ));

  $err = curl_error($curl);

  $response = curl_exec($curl);
  $arr = json_decode($response);
 */

//Share Statistics
//curl -X GET 'https://api.linkedin.com/rest/organizationalEntityShareStatistics?q=organizationalEntity&organizationalEntity={organization URN}' \
//-H 'Authorization: Bearer {INSERT_TOKEN}'
$curl = curl_init();


curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.linkedin.com/rest/organizationalEntityShareStatistics?q=organizationalEntity&organizationalEntity=urn:li:organization:30987048",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "{}",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer AQWrEG6T7Deamcib64bbUZjzPr8JyVlJ59eHRyGuSJv-9MWUuToapxubMNeq6tA6s0QC6m8T8TfyRgojz1lCifCxUB4DNKwfUqlxdsvfEyDqcURc5ILpdz-EAVXJkPyOloWpX5bc0ByH6rboeHUgOET2y_zCketATDL7binj4B1EEukVAfEHCFGXpX2UTPCUqcV7xiY6rc3AmcLNqJy-vxS5EspaBXaU0IADrfbGzJCnsddv_Qnny54Tlot58NOCCA8j8w1DGKqmTfOf12oyptub8lO9c-p51nGOrSU6mgY4jR2i7vE6BXmfscyUX9Axp7Kjka7FOCuP7vNLuhnRM1iXyhkwkA",
        "LinkedIn-Version: 202302",
//        "X-Restli-Protocol-Version: 2.0.0",
    ),
));

$err = curl_error($curl);

$response = curl_exec($curl);
$arr = json_decode($response);
?>

<div class="container">
    <div class="linked_row">
    <!--<div class="col-sm">-->
    <div class="linked_col"><?php echo '<b>Unique Impressions Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->uniqueImpressionsCount; ?></div>
    <div class="linked_col"><?php echo '<b>Share Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->shareCount; ?></div>
    <div class="linked_col"><?php echo '<b>Share Mentions Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->shareMentionsCount; ?></div>
    <div class="linked_col"><?php echo '<b>Engagement</b><br/>'; echo $arr->elements[0]->totalShareStatistics->engagement; ?></div>
    <div class="linked_col"><?php echo '<b>Click Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->clickCount; ?></div>
    <div class="linked_col"><?php echo '<b>Like Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->likeCount; ?></div>
    <div class="linked_col"><?php echo '<b>Impressions Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->impressionCount; ?></div>
    <!--<div class="linked_col"><?php echo '<b>Comment Mentions Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->commentMentionsCount; ?></div>-->
    <div class="linked_col"><?php echo '<b>Comment Count</b><br/>'; echo $arr->elements[0]->totalShareStatistics->commentCount; ?></div>
</div>
</div>


<?php

//curl -X GET 'https://api.linkedin.com/rest/organizationalEntityFollowerStatistics?q=organizationalEntity&organizationalEntity=urn%3Ali%3Aorganization%3A2414183&timeIntervals=(timeRange:(start:1536364800000,end:1536796800000),timeGranularityType:DAY)' \
//-H 'X-Restli-Protocol-Version: 2.0.0' \
//-H 'Authorization: Bearer {INSERT_TOKEN}'

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.linkedin.com/rest/organizationalEntityFollowerStatistics?q=organizationalEntity&organizationalEntity=urn:li:organization:30987048&timeIntervals=(timeRange:(start:1646111850,end:1675228650),timeGranularityType:DAY)",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "{}",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer AQWrEG6T7Deamcib64bbUZjzPr8JyVlJ59eHRyGuSJv-9MWUuToapxubMNeq6tA6s0QC6m8T8TfyRgojz1lCifCxUB4DNKwfUqlxdsvfEyDqcURc5ILpdz-EAVXJkPyOloWpX5bc0ByH6rboeHUgOET2y_zCketATDL7binj4B1EEukVAfEHCFGXpX2UTPCUqcV7xiY6rc3AmcLNqJy-vxS5EspaBXaU0IADrfbGzJCnsddv_Qnny54Tlot58NOCCA8j8w1DGKqmTfOf12oyptub8lO9c-p51nGOrSU6mgY4jR2i7vE6BXmfscyUX9Axp7Kjka7FOCuP7vNLuhnRM1iXyhkwkA",
        "LinkedIn-Version: 202302",
//        "X-Restli-Protocol-Version: 2.0.0",
    ),
));

$err = curl_error($curl);

$response = curl_exec($curl);
$arr = json_decode($response);
echo '<pre>';
print_r($arr);
echo '</pre>';
?>

