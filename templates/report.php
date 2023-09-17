<?php
/**
 * Frontend Report
 *
 * @author Rokibul
 * @package Arraytics
 */

?>
<table class="table">
	<thead>
		<tr>
			<th> <?php echo esc_html_e( 'Amount', 'arraytics' ); ?> </th>
			<th> <?php echo esc_html_e( 'Buyer', 'arraytics' ); ?> </th>
			<th> <?php echo esc_html_e( 'Receipt Id', 'arraytics' ); ?>  </th>
			<th> <?php echo esc_html_e( 'Items', 'arraytics' ); ?>  </th>
			<th> <?php echo esc_html_e( 'Buyer Email', 'arraytics' ); ?> </th>
			<th> <?php echo esc_html_e( 'Buyer IP', 'arraytics' ); ?> </th>
			<th> <?php echo esc_html_e( 'Note', 'arraytics' ); ?> </th>
			<th> <?php echo esc_html_e( 'City', 'arraytics' ); ?> </th>
			<th> <?php echo esc_html_e( 'Phone', 'arraytics' ); ?></th>
			<th> <?php echo esc_html_e( 'Entry At', 'arraytics' ); ?> </th>
			<th> <?php echo esc_html_e( 'Entry By', 'arraytics' ); ?> </th>
		</tr>
	</thead>

	<tbody>
<?php
if ( ! empty( $entries ) ) {
	foreach ( $entries  as $entry ) {
		?>
		<tr>
			<td> <?php echo esc_html( $entry['amount'] ); ?> </td>
			<td> <?php echo esc_html( $entry['buyer'] ); ?> </td>
			<td> <?php echo esc_html( $entry['receipt_id'] ); ?> </td>
			<td> <?php echo esc_html( $entry['amount'] ); ?> </td>
			<td> <?php echo esc_html( $entry['buyer_email'] ); ?> </td>
			<td> <?php echo esc_html( $entry['buyer_ip'] ); ?> </td>
			<td> <?php echo esc_html( $entry['note'] ); ?> </td>
			<td> <?php echo esc_html( $entry['city'] ); ?> </td>
			<td> <?php echo esc_html( $entry['phone'] ); ?> </td>
			<td> <?php echo esc_html( $entry['entry_at'] ); ?> </td>
			<td> <?php echo esc_html( $entry['entry_by'] ); ?> </td>
		</tr>
		<?php
	}
}
?>
	</tbody>
</table>