<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 7:18 AM
 */
?>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">

            <?php
            include_once(APPPATH."views/receipts/components/nav_bar.php");
            ?>

        </div>
        <div class="row actual_body_contents">


            <div class="row" style="background-color: ; margin-top: 10px;">

                <!-- Receipt Voucher -->
                <div class="col-md-10 " style="">
                    <?php
                    include_once(APPPATH."views/receipts/components/receipt_form.php");
                    ?>
                </div>

            </div>
            <div class="row" style="background-color: ; margin-top: 10px;">

                <!-- Receipt Voucher -->
                <div class="col-md-10 " style="">
                    <?php
                    include_once(APPPATH."views/receipts/components/few_receipts.php");
                    ?>
                </div>

            </div>
        </div>



    </div>

</div>