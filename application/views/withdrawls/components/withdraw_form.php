<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 7:18 AM
 */
?>
<style>
    .payment_form_table th{
        text-align: right;
    }
    .payment_form_table tr{
        border-top: 2px solid inherit;
    }
</style>
<script>
    function add_new_title_box()
    {
        document.getElementById("new_title").type = 'text';
    }
</script>
<h3 style="color: #006dcc; text-align: center;">Withdraw Voucher</h3>

<?php if(isset($_POST['addExpense'])): ?>
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

<form method="post" action="<?= $this->helper_model->controller_path()."withdraw" ?>">
    <table class="payment_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td style="width: 40%;"><input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 100%;" type="date" name="voucher_date"></td>

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
            <th>Withdraw A/C</th>
            <td style="">
                <select class="select_box bank_ac_select_box" style="width: 100%;" name="withdraw_account" id="withdraw_account">
                    <?php foreach($withdraw_accounts as $title):?>
                        <option value="<?= $title->title ?>"><?= ucwords($title->title) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <th>Amount</th>
            <td><input type="number" step="any" name="amount" class="form-control"></td>
        </tr>
        <tr>
            <th>Summary</th>
            <td colspan="3">
                <textarea class="form-control" name="summary"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <button name="withdraw" class="btn btn-success center-block" style="width: 100px;"><i class="fa fa-save"></i> Withdraw</button>
            </td>
        </tr>
    </table>
</form>