<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 5/5/15
 * Time: 4:20 PM
 */
?>

<div class="row page_heading_container">
    <div class="col-lg-12">
        <section class="col-md-6">
            <h3 class="">
                Add New Expenses <small></small>
            </h3>
        </section>
    </div>
</div>

<div id="page-wrapper" class="whole_page_container">
    <div class="container-fluid">
        <div class="row actual_body_contents">

            <div class="row" style="background-color: ; margin-top: 10px;">
                <!-- expense Voucher -->
                <div class="col-md-10" style="">
                    <?php
                    include_once(APPPATH."views/expenses/components/add_expense_form.php");
                    ?>
                </div>
            </div>

            <div class="row" style="background-color: ; margin-top: 10px;">
                <!-- Receipt Voucher -->
                <div class="col-md-10 " style="">
                    <?php
                    include_once(APPPATH."views/expenses/components/few_expenses.php");
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>