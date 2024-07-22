<?php

/* Template Name: Test Functions */
global $wpdb;

$response = test_sendgrid_email();

print_r($response);