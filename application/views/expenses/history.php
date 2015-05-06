<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 7:18 AM
 */
?>
<style>
    table td{
        font-size: 11px;
    }
</style>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">

            <?php
            include_once(APPPATH."views/payments/components/nav_bar.php");
            ?>

        </div>
        <div class="row actual_body_contents">


            <div class="row" style="background-color: ; margin-top: 10px;">

                <!-- Payment Voucher -->
                <div class="col-md-10" style="">
                    <?php
                    include_once(APPPATH."views/payments/components/payment_history.php");
                    ?>
                </div>

            </div>
        </div>



    </div>

</div>