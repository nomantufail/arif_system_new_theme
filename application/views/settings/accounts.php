<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 2:16 AM
 */

?>

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
                Settings => Accounts <small></small>
            </h3>
        </section>
    </div>
</div>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">

        <div class="row actual_body_contents">

            <div class="row" style="background-color: ;">
                <div class="col-lg-8">
                    <?php
                    include_once(APPPATH."views/settings/components/bank_accounts.php");
                    ?>
                </div>
            </div>
        </div>



    </div>

</div>
