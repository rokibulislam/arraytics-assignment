<?php
/**
 * Ajax
 *
 * @author Rokibul
 * @package Arraytics
 */

namespace Arraytics;

/**
 * Ajax Class
 */
class Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_arraytics', array( $this, 'save_arraytics' ) );
		add_action( 'wp_ajax_nopriv_save_arraytics', array( $this, 'save_arraytics' ) );
	}

	/**
	 * Save From data
	 *
	 * @return void
	 */
	public function save_arraytics() {
		$post_data = wp_unslash( $_POST );

		if ( ! wp_verify_nonce( $post_data['nonce'], 'arraytics_nonce' ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Nonce verification failed!', 'arraytics' )
				),
			);
		}

		global $wpdb;
		
		parse_str( $post_data['data'], $form_data );

		// Validate and sanitize form data.
		$amount = intval( $form_data['amount'] );

		if ( $amount <= 0 ) {
			echo 'Amount must be a positive number.';
			wp_die();
		}

		$buyer = sanitize_text_field( $form_data['buyer'] );

		if ( ! preg_match( '/^[a-zA-Z0-9\s]{1,20}$/', $buyer ) ) {
			echo 'Buyer can only contain text, spaces, and numbers (max 20 characters).';
			wp_die();
		}

		$receipt_id = sanitize_text_field( $form_data['receipt_id'] );

		if ( ! preg_match( '/^[a-zA-Z\s]+$/', $receipt_id ) ) {
			echo 'Receipt ID can only contain text.';
			wp_die();
		}

		$items = $form_data['items'];

		$buyer_email = sanitize_email( $form_data['buyer_email'] );

		if ( ! filter_var( $buyer_email, FILTER_VALIDATE_EMAIL ) ) {
			echo 'Invalid email format.';
			wp_die();
		}

		$note = sanitize_text_field( $form_data['note'] );

		if ( ! preg_match( '/^[\w\s]{0,30}$/', $note ) ) {
			echo 'Note can contain up to 30 characters with letters, numbers, and spaces.';
			wp_die();
		}

		$city = sanitize_text_field( $form_data['city'] );

		if ( ! preg_match( '/^[a-zA-Z\s]+$/', $city ) ) {
			echo 'City can only contain text and spaces.';
			wp_die();
		}

		$phone = sanitize_text_field( $form_data['phone'] );

		if ( ! preg_match( '/^\d{11}$/', $phone ) ) {
			echo 'Phone must be 11 digits.';
			wp_die();
		}

		$entry_by = intval( $form_data['entry_by'] );

		if ( $entry_by <= 0 ) {
			echo 'Entry By must be a positive number.';
			wp_die();
		}

		// Concatenate the receipt_id and salt.
		$salt          = 'qrweqrxwq23234rwfd';
		$combined_data = $receipt_id . $salt;
		$hash_key      = hash( 'sha512', $combined_data );

		$wpdb->insert(
			$wpdb->prefix . 'arraytics_entries',
			array(
				'amount'      => $amount,
				'buyer'       => $buyer,
				'receipt_id'  => $receipt_id,
				'items'       => maybe_serialize( $items ),
				'buyer_email' => $buyer_email,
				'note'        => $note,
				'city'        => $city,
				'phone'       => $phone,
				'entry_by'    => $entry_by,
				'buyer_ip'    => wp_unslash( $_SERVER['REMOTE_ADDR'] ),
				'entry_at'    => date( 'Y-m-d' ),
				'hash_key'    => $hash_key,
			),
			array(
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
			),
		);

		$response = array(
			'success' => true,
			'message' => 'entry submitted successfully',
		);

		wp_send_json( $response );
	}
}
