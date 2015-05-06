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
                Home <small></small>
            </h3>
        </section>
    </div>
</div>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row actual_body_contents">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Business Status</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th class="title">Total Purchases</th>
                                    <th class="amount"><?= rupee_format($total_purchases) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Sales</th>
                                    <th class="amount"><?= rupee_format($total_sales) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Payables</th>
                                    <th class="amount"><?= rupee_format($total_payables) ?></th>
                                </tr>
                                <tr>
                                    <th class="title">Total Receivables</th>
                                    <th class="amount"><?= rupee_format($total_receivables) ?></th>
                                </tr>
                            </table>
                            <div style="text-align: center;">
                                <h4 style="color: green;">Profit = <?= rupee_format($total_sales - $total_purchases) ?> Rs.</h4>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Bank Accounts Summary</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr class="table_header_row">
                                    <th>Account Title</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($bank_accounts as $account): ?>
                                    <tr>
                                        <th><?= $account['title']." [ ".$account['sub_title']." ]" ?></th>
                                        <td>
                                            <?php
                                            $balance = $account['debit'] - $account['credit'];
                                            if($balance >= 0)
                                            {
                                                echo "<span style='color: green;'>";
                                                echo rupee_format($balance)." Dr";
                                                echo "</span>";
                                            }else{
                                                echo "<span style='color: red;'>";
                                                echo rupee_format($balance*-1)." Cr";
                                                echo "</span>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>