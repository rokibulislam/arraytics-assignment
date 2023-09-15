<?php

function arraytics_get_entries() {
    global $wpdb;

    $query = 'SELECT * FROM ' . $wpdb->prefix . 'arraytics_entries';
    
    $results = $wpdb->get_results( $query, ARRAY_A );
    
    return $results;
}