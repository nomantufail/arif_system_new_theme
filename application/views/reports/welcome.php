<?php
/*
 * this variable shows that how many rows will will be displayed by default
 * */
$default_row_counter = 2;
?>
<style>
    .invoice_entries_container{
        border: 0px solid lightgray;
        min-height: 200px;
        margin: 0px;
    }
    .invoice_table{
        width: 50%;
    }
    .invoice_table td{
        margin: 10px;
    }
</style>

<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
        <div class="row">
            <?php
            include_once(APPPATH."views/reports/components/nav_bar.php");
            ?>
        </div>

        <!--Notifications Area-->
        <div class="row">
            <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">

                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                            <strong>Error! </strong>', '</div>'); ?>
            <?php if(is_array(@$someMessage)){ ?>
                <div class="alert <?= $someMessage['type']; ?> alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <?= $someMessage['message']; ?>
                </div>
            <?php } ?>

        </div>
        <!--notifications area ends-->

        <div class="row actual_body_contents" style="background-color: rgba(0,0,0,0.03); margin-top: 20px;">
            <form method="post">
                <div class="row">
                    <h1 style="margin: 150px;">Under Development..</h1>
                </div>

            </form>
        </div>



    </div>

</div>
