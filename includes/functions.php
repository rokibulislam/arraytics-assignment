<?php
/**
 * Functions
 *
 * @author Rokibul
 * @package Arraytics
 */

/**
 * Get Entries
 *
 * @return array
 */
function arraytics_get_entries() {
	global $wpdb;

	$query = 'SELECT * FROM ' . $wpdb->prefix . 'arraytics_entries';

	$results = $wpdb->get_results( $query, ARRAY_A );

	return $results;
}

/**
 * Get Entry by id
 *
 * @param int $id id.
 *
 * @return object
 */
function arraytics_get_entry_by_id( $id ) {
	global $wpdb;

	$table_name = $wpdb->prefix . 'arraytics_entries';

	$record = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ) );

	return $record;
}
