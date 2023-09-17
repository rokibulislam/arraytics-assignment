<?php
/**
 * Admin
 *
 * @author Rokibul
 * @package Arraytics
 */
namespace Arraytics;

/**
 * Admin Class
 */
class Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'update_handler' ) );
	}

	/**
	 * Register Admin Menu
	 *
	 * @return void
	 */
	public function admin_menu() {
		global $submenu;

		$capability = 'edit_posts';
		$slug       = 'arraytics';

		$hook = add_menu_page( __( 'Arraytics Report App', 'arraytics' ), __( 'Arraytics Report App', 'arraytics' ), $capability, $slug, array( $this, 'entries_page' ), 'dashicons-text' );
		
		add_action( 'load-' . $hook, array( $this, 'enqueue_admin' ) );
	}

	/**
	 * Load Entries Page
	 *
	 * @return void
	 */
	public function entries_page() {
		$get_data = wp_unslash( $_GET );
		$action   = isset( $get_data['action'] ) ? sanitize_text_field( wp_unslash( $get_data['action'] ) ) : null;
		$id       = isset( $get_data['id'] ) ? sanitize_text_field( wp_unslash( $get_data['id'] ) ) : null;

		switch ( $action ) {
			case 'edit':
				$data     = arraytics_get_entry_by_id( $id );
				$template = ARRAYTICS_INCLUDES . '/html/edit.php';
				break;
			default:
				$template = ARRAYTICS_INCLUDES . '/html/form-list-view.php';
				break;
		}

		if ( file_exists( $template ) ) {
			include $template;
		}
	}

	/**
	 * Update Handler
	 *
	 * @return void
	 */
	public function update_handler() {
		$post_data = wp_unslash( $_POST );
		global $wpdb;

		if ( ! isset( $post_data['update_arraytics'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $post_data['_wpnonce'], 'update-arraytics' ) ) {
			wp_die( 'Are you cheating?' );
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'Are you cheating?' );
		}

		$id          = intval( $post_data['id'] );
		$amount      = intval( $post_data['amount'] );
		$buyer       = sanitize_text_field( $post_data['buyer'] );
		$receipt_id  = sanitize_text_field( $post_data['receipt_id'] );
		$items       = $post_data['items'];
		$buyer_email = sanitize_email( $post_data['buyer_email'] );
		$note        = sanitize_text_field( $post_data['note'] );
		$city        = sanitize_text_field( $post_data['city'] );
		$phone       = sanitize_text_field( $post_data['phone'] );
		$entry_by    = intval( $post_data['entry_by'] );

		$salt          = 'qrweqrxwq23234rwfd';
		$combined_data = $receipt_id . $salt;
		$hash_key      = hash( 'sha512', $combined_data );

		$updated = $wpdb->update(
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
				'hash_key'    => $hash_key,
			),
			array( 'id' => $id ),
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
			),
			array( '%d' )
		);

		$redirected_to = admin_url( 'admin.php?page=arraytics' );
		wp_redirect( $redirected_to );
		exit;
	}

	/**
	 * Admin Scripts
	 *
	 * @return void
	 */
	public function enqueue_admin() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style( 'jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), ARRAYTICS_VERSION );

		wp_register_script( 'arraytics-admin', ARRAYTICS_ASSETS . '/js/admin.js', array( 'jquery' ), ARRAYTICS_VERSION, true );
		wp_enqueue_script( 'arraytics-admin' );
	}
}
