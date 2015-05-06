<h4 style="color: #006dcc">Payment History</h4>
<table class="my_table list_table table table-bordered">
    <thead class="table_header">
    <tr class="table_row table_header_row">
        <th class="column_heading">Invoice#</th>
        <th class="column_heading">Date</th>
        <th class="column_heading">Tanker</th>
        <th class="column_heading">Title</th>
        <th class="column_heading">Amount</th>
        <th class="column_heading">Summary</th>
        <th class="column_heading"></th>
    </tr>
    </thead>
    <tbody class="table_body">
    <?php
    $total_cost = 0;
    ?>
    <?php $parent_count = 0; ?>
    <?php  foreach($few_expenses as $record): ?>

        <tr style="">

            <td>
                <?php
                echo $record->invoice_id;
                ?>
            </td>

            <td>
                <?php
                echo Carbon::createFromFormat('Y-m-d',$record->expense_date)->toFormattedDateString();
                ?>
            </td>
            <td>
                <?php
                echo $record->tanker;
                ?>
            </td>
            <td>
                <?php
                echo $record->expense_title;
                ?>
            </td>
            <td>
                <?php
                $total_cost += $record->amount;
                echo rupee_format($record->amount);
                ?>
            </td>
            <td>
                <?php
                echo $record->invoice_summary;
                ?>
            </td>
            <td></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot class="table_footer">
    <tr class="table_footer_row">
        <th colspan="4" style="text-align: right;">Totals</th>
        <th class="total_amount"><?= rupee_format($total_cost) ?></th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>