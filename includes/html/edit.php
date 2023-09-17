<?php
/**
 * Form Edit View
 *
 * @author Rokibul
 * @package Arraytics
 */

$items = unserialize( $data->items );
?>

<form id="arraytics-submission-form" action="" method="post">

<table class="form-table">

<tbody>
	<tr class="arraytics-form-group row">
		<td> <label for="amount"> <?php esc_html_e( 'Amount:', 'arraytics' ); ?> </label> </td>
		<td> <input type="number" id="amount" name="amount" class="arraytics-form-control" value="<?php echo esc_attr( $data->amount ); ?>" />
		<p class="error-message"> </p> </td>
	</tr>

	<tr class="arraytics-form-group row">
		<td><label for="buyer"> <?php esc_html_e( 'Buyer:', 'arraytics' ); ?> </label> </td>
		<td> <input type="text" id="buyer" name="buyer" maxlength="20" class="arraytics-form-control" value="<?php echo esc_attr( $data->buyer ); ?>" />
		<p class="error-message"> </p> </td>
	</div>

	<tr class="arraytics-form-group">
		<td> <label for="receipt_id"> <?php esc_html_e( 'Receipt ID:', 'arraytics' ); ?> </label> </td>
		<td> <input type="text" id="receipt_id" name="receipt_id" maxlength="20" class="arraytics-form-control" value="<?php echo esc_attr( $data->receipt_id ); ?>"/>
		<p class="error-message"> </p> </td>
	</tr>

	<?php if ( ! empty( $items ) ) { ?>
	<tr class="arraytics-form-group">
		<td>
			<table>
				<tbody class="items_container">
					<?php
					foreach ( $items as $item ) {
						?>
						<tr class="item_fields">
							<td> <label for="items"> <?php esc_html_e( 'Items:', 'arraytics' ); ?> </label> </td>
							<td>
								<input type="text" id="items" name="items[]" maxlength="255" class="arraytics-form-control" value="<?php echo esc_attr( $item ); ?>" />
								<p class="error-message"> </p>
							</td>
							<td> <button class="remove-field"> <?php esc_html_e( 'Remove', 'arraytics' ); ?> </button> </td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</td>
	</tr>
		<?php
	}
	?>

	<tr>
		<td>  <button id="addField"> <?php esc_html_e( 'Add Field', 'arraytics' ); ?> </button> </td>
	</tr>

	<tr class="arraytics-form-group">
	   <td> <label for="buyer_email"> <?php esc_html_e( 'Buyer Email:', 'arraytics' ); ?> </label> </td>
	   <td> <input type="email" id="buyer_email" name="buyer_email" maxlength="50" class="arraytics-form-control" value="<?php echo esc_attr( $data->buyer_email ); ?>" />
		<p class="error-message"> </p> </td>
	</tr>

	<tr class="arraytics-form-group">
		<td> <label for="note"> <?php esc_html_e( 'Note:', 'arraytics' ); ?> </label> </td>
		<td> <textarea id="note" name="note" rows="4" maxlength="30" class="arraytics-form-control"> <?php echo esc_attr( $data->note ); ?> </textarea>
		<p class="error-message"> </p> </td>
	</tr>

	<tr class="arraytics-form-group">
		<td> <label for="city"> <?php esc_html_e( 'City:', 'arraytics' ); ?> </label> </td>
		<td> <input type="text" id="city" name="city" maxlength="20" class="arraytics-form-control" value="<?php echo esc_attr( $data->city ); ?>" />
		<p class="error-message"> </p> </td>
	</tr>

	<tr class="arraytics-form-group">
		<td> <label for="phone"> <?php esc_html_e( 'Phone:', 'arraytics' ); ?> </label> </td>
		<td> <input type="tel" id="phone" name="phone" pattern="[0-9]{11}"  class="arraytics-form-control" value="<?php echo esc_attr( $data->phone ); ?>" />
		<p class="error-message"> </p> </td>
	</tr>

	<tr class="arraytics-form-group">
		<td> <label for="entry_by"> <?php esc_html_e( 'Entry By:', 'arraytics' ); ?> </label> </td>
		<td> <input type="number" id="entry_by" name="entry_by" class="arraytics-form-control" value="<?php echo esc_attr( $data->entry_by ); ?>" />
		<p class="error-message"> </p> </td>
	</tr>

	<tr class="arraytics-form-group">
		<td>
		<input type="hidden" name="id" value="<?php echo esc_attr( $data->id ); ?>">
		<?php wp_nonce_field( 'update-arraytics' ); ?>
		<?php submit_button( __( 'Update', 'arraytics' ), 'primary', 'update_arraytics' ); ?>
		</td>
	</tr>

	</tbody>
</table>

</form>