<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 7:18 AM
 */
?>
<style>
    .receipt_form_table th{
        text-align: right;
    }
    .receipt_form_table tr{
        border-top: 2px solid inherit;
    }
</style>
<h3 style="color: #006dcc; text-align: center;">Receipt Vocuher</h3>

<?php if(isset($_POST['saveReceipt'])): ?>
    <?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">

                                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                                                <strong>Error! </strong>', '</div>'); ?>
    <?php if(is_array(@$someMessage)){ ?>
        <div class="alert <?= $someMessage['type']; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <?= $someMessage['message']; ?>
        </div>
    <?php } ?>
<?php endif; ?>

<form method="post" action="<?= $this->helper_model->controller_path()."make" ?>">
    <table class="receipt_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td><input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 100%;" type="date" name="voucher_date"></td>

            <th>Customer</th>
            <td>
                <select class="select_box suppliers_select_box" style="width: 100%;" name="customer" id="supplier">
                    <?php foreach($customers as $customer):?>
                        <option value="<?= $customer->name ?>"><?= $customer->name ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Amount</th>
            <td><input type="number" step="any" name="amount" class="form-control"></td>
            <th>Bank A/C</th>
            <td>
                <select class="select_box bank_ac_select_box" style="width: 100%;" name="bank_ac" id="supplier">
                    <?php foreach($bank_accounts as $account):?>
                        <option value="<?= $account->title." (".$account->bank." ".bn_masking($account->account_number).")"."_&&_".$account->type ?>"><?= $account->title." (".$account->bank." ".bn_masking($account->account_number).")" ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Summary</th>
            <td colspan="3">
                <textarea class="form-control" name="summary"></textarea>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <button name="saveReceipt" class="btn btn-success center-block" style="width: 150px;"><i class="fa fa-save"></i> Save</button>
            </td>
        </tr>
    </table>
</form>