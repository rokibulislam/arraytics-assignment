<?php
/**
 * Frontend form
 *
 * @author Rokibul
 * @package Arraytics
 */

?>
<form id="arraytics-submission-form" action="" method="post">
	<div class="arraytics-form-group">
		<label for="amount"> <?php esc_html_e( 'Amount:', 'arraytics' ); ?> </label>
		<input type="number" id="amount" name="amount" class="arraytics-form-control" />
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group">
		<label for="buyer"> <?php esc_html_e( 'Buyer:', 'arraytics' ); ?> </label>
		<input type="text" id="buyer" name="buyer" maxlength="20" class="arraytics-form-control" />
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group">
		<label for="receipt_id"> <?php esc_html_e( 'Receipt ID:', 'arraytics' ); ?> </label>
		<input type="text" id="receipt_id" name="receipt_id" maxlength="20" class="arraytics-form-control" />
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group items_container">
		<div class="item_fields">
			<div>
				<label for="items"> <?php esc_html_e( 'Items:', 'arraytics' ); ?> </label>
				<input type="text" id="items" name="items[]" maxlength="255" class="arraytics-form-control" />
			</div>
			<button class="remove-field"> <?php esc_html_e( 'Remove', 'arraytics' ); ?> </button>
		</div>
		<p class="error-message"> </p>
	</div>

	<button id="addField"> <?php esc_html_e( 'Add Field', 'arraytics' ); ?> </button>

	<div class="arraytics-form-group">
		<label for="buyer_email"> <?php esc_html_e( 'Buyer Email:', 'arraytics' ); ?> </label>
		<input type="email" id="buyer_email" name="buyer_email" maxlength="50" class="arraytics-form-control" />
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group">
		<input type="hidden" name="action" value="save_arraytics">
	</div>

	<div class="arraytics-form-group">
		<label for="note"> <?php esc_html_e( 'Note:', 'arraytics' ); ?> </label>
		<textarea id="note" name="note" rows="4" maxlength="30" class="arraytics-form-control"></textarea>
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group">
		<label for="city"> <?php esc_html_e( 'City:', 'arraytics' ); ?> </label>
		<input type="text" id="city" name="city" maxlength="20" class="arraytics-form-control" />
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group">
		<label for="phone"> <?php esc_html_e( 'Phone:', 'arraytics' ); ?> </label>
		<input type="tel" id="phone" name="phone" pattern="[0-9]{11}"  class="arraytics-form-control" />
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group">
		<label for="entry_by"> <?php esc_html_e( 'Entry By:', 'arraytics' ); ?> </label>
		<input type="number" id="entry_by" name="entry_by" class="arraytics-form-control" />
		<p class="error-message"> </p>
	</div>

	<div class="arraytics-form-group">
		<button type="submit" class="btn-arraytics-submit"> <?php echo esc_html_e( 'Submit', 'arraytics' ); ?> </button>
	</div>

</form>

<div id="form-message"></div>


