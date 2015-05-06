<style>
    .insert_table td input{
        width: 100%;
    }
    .insert_table td select{
        width: 100%;
        height: 25px;
    }
    .insert_table button
    {
        width: 100%;
    }
    .insert_table .lable{

    }
</style>
<div class="row page_heading_container">
    <div class="col-lg-12">
        <section class="col-md-6">
            <h3 class="">
                Withdraw History <small></small>
            </h3>
        </section>
    </div>
</div>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">

        <!--Notifications Area-->
        <div class="row">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">

                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                            <strong>Error! </strong>', '</div>'); ?>



        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents">

            <div class="row">

                <div class="col-lg-12">
                    <table class="my_table list_table table table-bordered">
                        <thead class="table_header">
                        <tr class="table_row table_header_row">
                            <th class="column_heading">Invoice#</th>
                            <th class="column_heading">Date</th>
                            <th class="column_heading">Bank A/C</th>
                            <th class="column_heading">Withdraw A/C</th>
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
                        <?php  foreach($withdraw_history as $record): ?>

                            <tr style="">

                                <td>
                                    <?php
                                    echo $record->voucher_id;
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->bank_ac;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $record->withdraw_account;
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
                                    echo $record->summary;
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
                </div>

            </div>
        </div>



    </div>

</div>