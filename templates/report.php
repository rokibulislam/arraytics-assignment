<table class="table">
    <thead>
        <tr>
            <th> Amount </th>
            <th> Buyer</th>
            <th> Receipt Id </th>
            <th> Items </th>
            <th> Buyer Email</th>
            <th> Buyer IP</th>
            <th> Note</th>
            <th> City</th>
            <th> Phone</th>
            <th> Entry At</th>
            <th> Entry By</th>
        </tr>
    </thead>

    <tbody>
<?php 
if( !empty( $entries ) ) {
    foreach( $entries  as $entry ) { ?>
        <tr>
            <td> <?php echo esc_html( $entry['amount'] ); ?> </td>
            <td> <?php echo esc_html( $entry['buyer'] );?> </td>
            <td> <?php echo esc_html( $entry['receipt_id'] );?> </td>
            <td> <?php echo esc_html( $entry['amount'] ); ?> </td>
            <td> <?php echo esc_html( $entry['buyer_email'] ); ?> </td>
            <td> <?php echo esc_html( $entry['buyer_ip'] ); ?> </td>
            <td> <?php echo esc_html( $entry['note'] ); ?> </td>
            <td> <?php echo esc_html( $entry['city'] ); ?> </td>
            <td> <?php echo esc_html( $entry['phone'] ); ?> </td>
            <td> <?php echo esc_html( $entry['entry_at'] ); ?> </td>
            <td> <?php echo esc_html( $entry['entry_by'] ); ?> </td>
        </tr>
    <?php } } ?>
    </tbody>
</table>