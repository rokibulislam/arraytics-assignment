<?php
namespace Arraytics;

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
/**
 * Entry List Table Class
 * 
 */
class Entry_List_Table extends \WP_List_Table {

	/**
	 * Constructor
	 */
	public function __construct() {
        parent::__construct(
            array(
                'singular'  => 'arraytics-entry',
                'plural'    => 'arraytics-entry',
                'ajax'      => true
            )
        );
	}

	/**
	 * Get Columns
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns            = array( 'cb' => '<input type="checkbox" />' );
        $columns['amount'] = __( "Amount", 'arraytics' );
        $columns['buyer'] = __( "Buyer", 'arraytics' );
        $columns['receipt_id'] = __( "Receipt Id", 'arraytics' );
        $columns['items'] = __( "Items", 'arraytics' );
        $columns['buyer_email'] = __( "Buyer Email", 'arraytics' );
        $columns['buyer_ip'] = __( "Buyer IP", 'arraytics' );
        $columns['note'] = __( "Note", 'arraytics' );
        $columns['city'] = __( "City", 'arraytics' );
        $columns['phone'] = __( "Phone", 'arraytics' );
        $columns['entry_at'] = __( "Entry At", 'arraytics' );
        $columns['entry_by'] = __( "Entry By", 'arraytics' );

		return $columns;
	}

	/**
	 * Prepare items
	 *
	 * @return void
	 */
	public function prepare_items() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'arraytics_entries';

        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $per_page     = 10;
        
		$current_page = $this->get_pagenum();

		$total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

		if ( isset( $_REQUEST['start_date'] ) && !empty($_REQUEST['start_date']) 
        && isset( $_REQUEST['end_date'] ) && !empty($_REQUEST['end_date'])  ) {
            
            $start_date = sanitize_text_field($_REQUEST['start_date']);
            $end_date   = sanitize_text_field($_REQUEST['end_date']);

            $sql = "SELECT * FROM $table_name
            WHERE entry_at BETWEEN '$start_date' AND '$end_date'
            LIMIT $per_page
            OFFSET " . ($current_page - 1) * $per_page;

            $this->items = $wpdb->get_results(
                $sql,
                ARRAY_A
            );
            
        } else {
            $this->items = $wpdb->get_results(
                "SELECT * FROM $table_name
                 LIMIT $per_page
                 OFFSET " . ($current_page - 1) * $per_page,
                ARRAY_A
            );
        }

     
        // print_r($this->items);

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => ceil( $total_items / $per_page ),
			)
		);

        $this->process_bulk_action();
	}

	function column_default($item, $column_name) {
        return $item[$column_name];
    }

    public function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id'] // Replace 'id' with the unique identifier for your item
        );
    }

    public function column_items($item) {
        return unserialize( $item['items'] );
    }

    public function column_amount( $item ) {
        $title = '<strong>' . $item['amount'] . '</strong>';

        $actions['delete'] = sprintf(
            '<a href="%s" title="%s">%s</a>',
            esc_url(
                wp_nonce_url(
                    add_query_arg(
                        array(
                            'action'  => 'delete',
                            'id' => $item['id'],
                        ),
                        admin_url( 'admin.php?page=arraytics' )
                    ),
                    'bulk-arraytics-forms'
                )
            ),
            esc_attr__( 'Delete this entries', 'arraytics' ),
            esc_html__( 'Delete', 'arraytics' )
        );

        return $title . $this->row_actions( $actions );
    }

	/**
     * Add custom filtering options to the table navigation.
     */
    public function extra_tablenav($which) {
        if ($which == 'top') {
            // Check if a date range filter has been submitted
            $start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
            $end_date = isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : '';

            echo '<div class="alignleft actions">';
            echo '<label for="start_date">Start Date:</label>';
            echo '<input type="text" id="start_date" name="start_date" value="' . esc_attr($start_date) . '" class="datepicker" />';
            echo '&nbsp;&nbsp;&nbsp;';
            echo '<label for="end_date">End Date:</label>';
            echo '<input type="text" id="end_date" name="end_date" value="' . esc_attr($end_date) . '" class="datepicker" />';
            echo '<input type="submit" class="button" value="Filter" />';
            echo '</div>';
        } 
        ?>

            <script>
                jQuery( function($) {
                    $( "#start_date" ).datepicker({
                        dateFormat: "yy-mm-dd",
                    });
                    $( "#end_date" ).datepicker({
                        dateFormat: "yy-mm-dd",
                    });
                });
            </script>

		<?php 
    }

    public function get_bulk_actions() {
        $actions['delete']  = __( 'Delete Permanently', 'arraytics' );

        return $actions;
    }

    public function process_bulk_action() {
        global $wpdb;
        $action            = $this->current_action();
        $entry_ids         = isset( $_REQUEST['id'] ) ? wp_parse_id_list( wp_unslash( $_REQUEST['id'] ) ) : array();
        $count             = 0;
        $remove_query_args = [ '_wp_http_referer', '_wpnonce', 'action', 'id', 'post', 'action2' ];
        
        $table_name = $wpdb->prefix . 'arraytics_entries';

        if ( $action ) {

            switch ( $action) {
                case 'delete':
                    foreach ( $entry_ids as $entry_id ) {
                        $deleted = $wpdb->delete(
                            $table_name,
                            [ 'id' => $entry_id, ], 
                            [ '%d' ]
                        );
                    }
                    break;
            }

            $request_uri = isset( $_SERVER['REQUEST_URI'] )  ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
            $redirect    = remove_query_arg( $remove_query_args, $request_uri );

            // wp_redirect(esc_url( $redirect ) );
            // exit();
        }
    }
}