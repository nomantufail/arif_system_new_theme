<h4 style="color: #006dcc">Receipt History</h4>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Vcouher#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Customer</th>
        <th class="column_heading">Bank</th>
        <th class="column_heading">Amount</th>
        <th class="column_heading">Summary</th>
        <th class="column_heading"></th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_product_quantity = 0;
    $grand_total_amount = 0;
    ?>
    <?php $parent_count = 0; ?>
    <?php  foreach($receipt_history as $record): ?>
        <?php
        $debit_entries = $record->debit_entries();
        $credit_entries = $record->credit_entries();
        ?>
        <tr style="">

            <td>
                <?php
                echo $record->id;
                ?>
            </td>

            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                $customer = $credit_entries[0]->related_customer;
                echo $customer;
                ?>
            </td>
            <td>
                <?php
                $bank = $debit_entries[0]->ac_title." [ ".$debit_entries[0]->ac_sub_title." ]";
                echo $bank;
                ?>
            </td>
            <td>
                <?php
                $amount =$credit_entries[0]->amount;
                $grand_total_amount += $amount;
                echo rupee_format($amount);
                ?>
            </td>
            <td>
                <?php
                echo $record->summary;
                ?>
            </td>
            <td></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">
        <th style="text-align: right;" colspan="4">Totals</th>
        <th class="total_amount"><?= rupee_format($grand_total_amount) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>