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
<h3 style="color: #006dcc; text-align: center;">Expense Voucher</h3>

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

<form method="post" action="<?= $this->helper_model->controller_path()."add" ?>">
    <table class="payment_form_table table table-bordered">

        <tr>
            <th style="width: ">Date</th>
            <td style="width: 40%;"><input class="form-control" value="<?= date("Y-m-d"); ?>" style="width: 100%;" type="date" name="expense_date"></td>

            <th>Tanker</th>
            <td>
                <select class="select_box tankers_select_box" style="width: 100%;" name="tanker" id="tanker">
                    <?php foreach($tankers as $tanker):?>
                        <option value="<?= $tanker->number ?>"><?= $tanker->number ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Title</th>
            <td style="">
                <select class="select_box bank_ac_select_box" style="width: 100%;" name="expense_title" id="expense_title">
                    <?php foreach($titles as $title):?>
                        <option value="<?= $title->title ?>"><?= ucwords($title->title) ?></option>
                    <?php endforeach; ?>
                </select>
<!--                <span onclick="add_new_title_box();"><i class="fa fa-plus-circle" style="color: green; font-size: 16px; cursor: pointer;"></i></span>-->
                <input style="margin-top: 5px; border: 1px solid blue; width: 80%;" type="hidden" name="new_title" id="new_title">
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
                <button name="addExpense" class="btn btn-success center-block" style="width: 100px;"><i class="fa fa-save"></i> Save</button>
            </td>
        </tr>
    </table>
</form>