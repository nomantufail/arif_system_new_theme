<div class="col-lg-12">
    <ul id="myTab" class="nav nav-pills" style="border-bottom: 0px solid;">
        <li class="<?php if($section=='cash_purchase'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."" ?>"><i class="fa fa-fw fa-file-o"></i> Daily</a>
        </li>
        <li class="<?php if($section == 'credit_purchase'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."" ?>"><i class="fa fa-fw fa-file-o"></i> Weakly</a>
        </li>
        <li class="<?php if($section == 'cash'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."" ?>"><i class="fa fa-fw fa-file-o"></i> Monthly</a>
        </li>
        <li class="<?php if($section == 'credit'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."" ?>"><i class="fa fa-fw fa-file-o"></i> Yearly</a>
        </li>
        <li class="<?php if($section == 'credit'){echo "active";} ?>">
            <a href="<?= $this->helper_model->controller_path()."" ?>"><i class="fa fa-fw fa-file-o"></i> Custom</a>
        </li>
    </ul>
</div>