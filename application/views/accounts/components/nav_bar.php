<div class="col-lg-12">
    <ul id="myTab" class="nav nav-pills" style="border-bottom: 0px solid;">
        <li class="<?php if($section == 'customers_ledger'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."customers_ledger" ?>"><i class="fa fa-fw fa-file-o"></i> Customers Ledger</a>
        </li>
        <li class="<?php if($section == 'suppliers_ledger'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."suppliers_ledger" ?>"><i class="fa fa-fw fa-file-o"></i> Suppliers Ledger</a>
        </li>
        <!--<li class="<?php /*if($section == 'credit_purchase'){echo "active";} */?>">
            <a href="<?/*= $this->helper_model->controller_path()."" */?>"><i class="fa fa-fw fa-file-o"></i> Income Statement</a>
        </li>
        <li class="<?php /*if($section == 'cash'){echo "active";} */?>">
            <a href="<?/*= $this->helper_model->controller_path()."" */?>"><i class="fa fa-fw fa-file-o"></i> Balance Sheet</a>
        </li>
        <li class="<?php /*if($section == 'credit'){echo "active";} */?>">
            <a href="<?/*= $this->helper_model->controller_path()."" */?>"><i class="fa fa-fw fa-file-o"></i> Trial Balance</a>
        </li>
        <li class="<?php /*if($section == 'credit'){echo "active";} */?>">
            <a href="<?/*= $this->helper_model->controller_path()."" */?>"><i class="fa fa-fw fa-file-o"></i> Debit / Credit</a>
        </li>
        <li class="<?php /*if($section == 'credit'){echo "active";} */?>">
            <a href="<?/*= $this->helper_model->controller_path()."" */?>"><i class="fa fa-fw fa-file-o"></i> Journal</a>
        </li>-->
    </ul>
</div>