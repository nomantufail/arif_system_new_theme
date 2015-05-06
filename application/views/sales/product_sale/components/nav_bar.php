<div class="col-lg-12">
    <ul id="myTab" class="nav nav-pills" style="border-bottom: 0px solid;">

        <li class="<?php if($section == 'credit_sale'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."credit_sale" ?>"><i class="fa fa-fw fa-plus-circle"></i>Sale</a>
        </li>
        <li class="<?php if($section == 'invoices'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."invoices" ?>"><i class="fa fa-fw fa-file-o"></i>Sale Invoices</a>
        </li>
    </ul>
</div>