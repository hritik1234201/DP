<?php

/* Template Name: Migration Page Template */
global $wpdb;

$path = 'privacy_links.csv';
$table_prefix = $wpdb->prefix;


/* 
 * 
 * START - Read FROM CSV File
 * 
 */

// $file = fopen($path, "r");

// echo 'Please Wait for the program(Writing Privacy Policy in OPTIONS table) to complete. DO NOT REFRESH...';
// $i = 0;
// while (!feof($file)) {
//    $row = fgetcsv($file);
//    echo '<pre>';
//    print_r($i .' = '. $row[0].' - '.$row[1]);
//    echo '</pre>';

//    //Find if the term(sponsor) is present in the database
//    $sql = "SELECT t.term_id FROM `{$table_prefix}terms` t 
//    JOIN `{$table_prefix}term_taxonomy` tt ON t.term_id = tt.term_id
//    WHERE 1=1 AND tt.taxonomy LIKE 'sponsored_by' AND t.name LIKE '{$row[0]}';";
//    $result = $wpdb->get_row($sql);
   
//    if (!empty($result) && !empty($row[1])) {
//        /*
//         * Find if the term's(sponsor's) meta value is present in the options table.
//         * All the additional meta value are stored on options table in a serialized array in option_name called 'taxonomy_term_<term_id>'
//         */
       
//        $privacy_meta = "SELECT * FROM `{$table_prefix}options` WHERE option_name LIKE 'taxonomy_term_$result->term_id'";

//        $output = $wpdb->get_row($privacy_meta);

//        if (!empty($output)) {
//            //If there is a taxonomy_term option_name
//            $privacy_link_arr = unserialize($output->option_value);
//            $privacy_link_arr['client_url'] = $row[1];
//            $arr = serialize($privacy_link_arr);
//            $query = "UPDATE {$table_prefix}options SET option_value='$arr' WHERE option_name LIKE 'taxonomy_term_$result->term_id'";
//            echo '<pre>';
//            print_r($query);
//            echo '</pre>';
//            $wpdb->query($wpdb->prepare($query));
//        } else {
//            //If taxonomy_term option_name is not available
//            $privacy_link_arr['client_url'] = $row[1];
//            $arr = serialize($privacy_link_arr);
//            $query = "INSERT INTO {$table_prefix}options (option_name,option_value) VALUES('taxonomy_term_{$result->term_id}','{$arr}');";
//            echo '<pre>';
//            print_r($query);
//            echo '</pre>';
//            $wpdb->query($wpdb->prepare($query));
//        }
//    }
//    $i++;
// }
// echo '<br/><br/>Program is COMPLETED!';

// fclose($file);
// die();

/* 
 * 
 * END - READ from CSV File
 * 
 */


/* 
 * 
 * START - Write to CSV File
 * 
 */
$sql = "SELECT * FROM `{$table_prefix}terms` t 
   JOIN `{$table_prefix}term_taxonomy` tt ON t.term_id = tt.term_id
   WHERE 1=1 AND tt.taxonomy LIKE 'sponsored_by';";


$results = $wpdb->get_results($sql);

$fp = fopen($path, 'w'); // open in write only mode (write at the start of the file)
echo 'Please Wait for the program(Reading Privacy Policy from OPTIONS table) to complete. DO NOT REFRESH...';
foreach($results as $result) {
   
   $sql1 = "SELECT * FROM `{$table_prefix}options` WHERE option_name LIKE 'taxonomy_term_$result->term_id'";
   $output = $wpdb->get_row($sql1);
   $privacy_link_arr = unserialize($output->option_value);
   $privacy_link = $privacy_link_arr['client_url'];
   $sponsor = $result->name;
   
   fputcsv($fp, array($sponsor,$privacy_link));
}
fclose($fp);
echo '<br/><br/>Program is COMPLETED!';


/* 
 * 
 * END - Write to CSV File
 * 
 */