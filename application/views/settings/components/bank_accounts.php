<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/14/15
 * Time: 2:16 AM
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> Account Titles</h3>
    </div>
    <div class="panel-body">
        <div class="list-group">

            <?php if(isset($_POST['addBankAc']) || isset($_GET['del_bank_ac'])): ?>
                <?php echo validation_errors('<div class="alert-danger">
                                            <strong>Error! </strong>', '</div>');
                ?>
                <?php if(is_array($someMessage)){ ?>
                    <div class="<?= $someMessage['type']; ?>">
                        <?= $someMessage['message']; ?>
                    </div>
                <?php } ?>
            <?php endif; ?>

            <form method="post" action="<?= base_url()."settings/accounts"?>">
                <table class="search-table2" border="0" style=" width: 100%;">
                    <tr>
                        <td style=""><input style="width: 100%;" required="required" type="text" placeholder="new title here...." value="" name="title"></td>
                        <td style=""><input style="width: 100%;" required="required" type="text" placeholder="account#" value="" name="account_number"></td>
                        <td style=""><input style="width: 100%;" required="required" type="text" placeholder="bank" value="" name="bank"></td>
                        <td style="">
                            <select name="type" style="width: 100%; height: 25px;">
                                <option value="current">Current</option>
                                <option value="saving">Saving</option>
                                <option value="online">Online</option>
                            </select>
                        </td>
                        <td style="width: 10%;"><input type="submit" name="addBankAc" value="Add Title" class="btn btn-success" style="border-radius: 0px;"></td>
                    </tr>
                </table>
            </form>
            <table class="table table-bordered table-hover table-striped" style="font-size:12px;">

                <thead style="border-top: 3px solid lightgray">
                <tr>
                    <th style="width: 10%">ID</th>
                    <th>Title</th>
                    <th>Account#</th>
                    <th>Bank</th>
                    <th>Type</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                //Showing otherAgents Data
                foreach($banks as $title){
                    ?>
                    <tr>
                        <td><?= $title->id; ?></td>
                        <td><?= $title->title; ?></td>
                        <td><?= $title->account_number; ?></td>
                        <td><?= $title->bank; ?></td>

                        <td>
                            <?php if($this->helper_model->is_editable_title($title->title)): ?>
                                <a href="#" id="account_type_<?= $title->id ?>" data-name="type" data-type="select" data-pk="<?= $title->id ?>" data-url="<?= base_url()."helper_controller/edit_record/account_titles/required" ?>" data-title="Title"><?= ucwords($title->type) ?></a>
                            <?php else:?>
                                <?= ucwords($title->type) ?>
                            <?php endif; ?>
                        </td>
                        <td></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>