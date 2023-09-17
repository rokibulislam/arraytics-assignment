<?php
/**
 * Form List View
 *
 * @author Rokibul
 * @package Arraytics
 */

?>
<div class="wrap">
	<?php
		$entry_list_table = new \Arraytics\Entry_List_Table();
	?>
	<form method="get">
		<input type="hidden" name="page" value="arraytics">
		<?php
			$entry_list_table->prepare_items();
			$entry_list_table->search_box( __( 'Search Forms', 'arraytics' ), 'arraytics-form-search' );
			$entry_list_table->views();
			$entry_list_table->display();
		?>
	</form>
</div>