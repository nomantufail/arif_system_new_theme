<?php
/**
 * Created by Zeenomlabs.
 * User: ZeenomLabs
 * Date: 4/16/15
 * Time: 11:43 PM
 */
?>
<style>
    table td{
        font-size: 12px;
    }
    table th{
        font-size: 12px;
    }
    .col-md-6{
        margin: 0px !important;
    }
</style>
<div id="page-wrapper" class="whole_page_container">

    <div class="container-fluid">
       <div class="row actual_body_contents">
           <div class="row" style="">
           <h3 style="color: #006dcc;">Day Book: <?= Carbon::now()->toFormattedDateString(); ?></h3>
               <table class="my_table list_table table table-bordered">
                   <thead>
                   <tr class="table_header_row">
                       <th colspan="9" style="text-align: center; font-size: 18px;">
                           Purchases
                       </th>
                   </tr>
                   <tr class="">
                       <th>Invoice#</th>
                       <th>Date</th>
                       <th>Supplier</th>
                       <th>Product</th>
                       <th>Quantity</th>
                       <th>Cost / Item</th>
                       <th>Total Cost</th>
                       <th>Debit</th>
                       <th>Credit</th>
                   </tr>
                   </thead>
                   <tbody>
                   <?php
                   $total_product_quantity = 0;
                   $total_credit = 0;
                   $total_debit = 0;
                   ?>
                   <?php $parent_count = 0; ?>
                   <?php  foreach($purchases as $record): ?>
                       <?php
                       $count = 0;
                       $num_invoice_items = sizeof($record->entries);
                       ?>
                       <?php foreach($record->entries as $entry): ?>
                           <?php
                           $count++;
                           $parent_count++;
                           ?>

                           <tr style="<?= (($count == 1)?"border-top:2px solid lightgray":"") ?>;">
                               <?php if($count == 1){echo "<td rowspan=".($num_invoice_items)." style=''><a target=_blank href='#".$record->id."'>".$record->id."</a></td>";} ?>
                               <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".Carbon::createFromFormat('Y-m-d',$record->date)->toFormattedDateString()."</td>";} ?>

                               <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->supplier->name."</td>";} ?>

                               <td>
                                   <?php
                                   echo $entry->product->name;
                                   ?>
                               </td>

                               <td>
                                   <?php
                                   $total_product_quantity += $entry->quantity;
                                   echo $entry->quantity;
                                   ?>
                               </td>
                               <td>
                                   <?php
                                   echo rupee_format($entry->costPerItem);
                                   ?>
                               </td>
                               <td>
                                   <?php
                                   echo rupee_format($entry->total_cost());
                                   ?>
                               </td>

                               <?php if($count == 1):?>
                                   <td rowspan="<?=($num_invoice_items)?>">

                                   </td>
                               <?php endif; ?>
                               <?php if($count == 1):?>
                                   <td rowspan="<?=($num_invoice_items)?>" style="vertical-align: middle;">
                                       <?php
                                       $total_credit += $record->grand_total_purchase_price();
                                       echo rupee_format($record->grand_total_purchase_price());
                                       ?>
                                   </td>
                               <?php endif; ?>

                           </tr>
                       <?php endforeach ?>
                   <?php endforeach; ?>
                   <tr>
                       <th colspan="7" style='text-align:right;'>Totals</th>
                       <th style="background-color: lightblue;"><?= rupee_format($total_debit) ?></th>
                       <th style="background-color: lightblue;"><?= rupee_format($total_credit) ?></th>
                   </tr>
                   </tbody>

                   <thead>
                   <tr class="table_header_row">
                       <th colspan="9" style="text-align: center; font-size: 18px;">
                           Sales
                       </th>
                   </tr>
                   <tr class="">
                       <th>Invoice#</th>
                       <th>Date</th>
                       <th>Customer</th>
                       <th>Product</th>
                       <th>Quantity</th>
                       <th>Price / Item</th>
                       <th>Total Price</th>
                       <th>Debit</th>
                       <th>Credit</th>
                   </tr>
                   </thead>
                   <tbody>
                   <?php
                   $total_product_quantity = 0;
                   $total_cost = 0;
                   $total_debit = 0;
                   $total_credit = 0;
                   ?>
                   <?php $parent_count = 0; ?>
                   <?php  foreach($sales as $record): ?>
                       <?php
                       $count = 0;
                       $num_invoice_items = sizeof($record->entries);
                       ?>
                       <?php foreach($record->entries as $entry): ?>
                           <?php
                           $count++;
                           $parent_count++;
                           ?>

                           <tr style="<?= (($count == 1)?"border-top:2px solid lightgray":"") ?>;">
                               <?php if($count == 1){echo "<td rowspan=".($num_invoice_items)." style=''><a target=_blank href='#".$record->id."'>".$record->id."</a></td>";} ?>
                               <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".Carbon::createFromFormat('Y-m-d',$record->date)->toFormattedDateString()."</td>";} ?>

                               <?php if($count == 1){echo "<td rowspan=".($num_invoice_items).">".$record->customer->name."</td>";} ?>

                               <td>
                                   <?php
                                   echo $entry->product->name;
                                   ?>
                               </td>

                               <td>
                                   <?php
                                   $total_product_quantity += $entry->quantity;
                                   echo $entry->quantity;
                                   ?>
                               </td>
                               <td>
                                   <?php
                                   echo rupee_format($entry->salePricePerItem);
                                   ?>
                               </td>
                               <td>
                                   <?php
                                   echo rupee_format($entry->total_cost());
                                   ?>
                               </td>

                               <?php if($count == 1):?>
                                   <td rowspan="<?=($num_invoice_items)?>">
                                       <?php
                                       $total_debit += $record->grand_total_sale_price();
                                       echo rupee_format($record->grand_total_sale_price());
                                       ?>
                                   </td>
                               <?php endif; ?>
                               <?php if($count == 1):?>
                                   <td rowspan="<?=($num_invoice_items)?>" style="vertical-align: middle;">

                                   </td>
                               <?php endif; ?>


                           </tr>
                       <?php endforeach ?>
                   <?php endforeach; ?>
                   <tr>
                       <th colspan="7" style='text-align:right;'>Totals</th>
                       <th class='total_amount'><?= rupee_format($total_debit) ?></th>
                       <th class='total_amount'><?= rupee_format($total_credit) ?></th>
                   </tr>
                   </tbody>

                   <thead>
                   <tr class="table_header_row">
                       <th colspan="9" style="text-align: center; font-size: 18px;">
                           Receipts
                       </th>
                   </tr>
                   <tr>
                       <th>Voucher#</th>
                       <th>Date</th>
                       <th>Customer</th>
                       <th colspan="4">Bank</th>
                       <th>Debit</th>
                       <th>Credit</th>
                   </tr>
                   </thead>
                   <tbody>
                   <?php
                   $total_product_quantity = 0;
                   $total_cost = 0;
                   $total_credit = 0;
                   $total_debit = 0;
                   ?>
                   <?php $parent_count = 0; ?>
                   <?php  foreach($receipts as $record): ?>
                       <?php
                       $debit_entries = $record->debit_entries();
                       $credit_entries = $record->credit_entries();
                       ?>
                       <tr style="">

                           <td>
                               <?php
                               echo $record->id;
                               ?>
                           </td>

                           <td>
                               <?php
                               echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                               ?>
                           </td>
                           <td>
                               <?php
                               $customer = $credit_entries[0]->related_customer;
                               echo $customer;
                               ?>
                           </td>
                           <td colspan="4">
                               <?php
                               $bank = $debit_entries[0]->ac_title." [ ".$debit_entries[0]->ac_sub_title." ]";
                               echo $bank;
                               ?>
                           </td>
                           <td>

                           </td>
                           <td>
                               <?php
                               $amount = $credit_entries[0]->amount;
                               $total_credit += $amount;
                               echo rupee_format($amount);
                               ?>
                           </td>

                       </tr>
                   <?php endforeach; ?>
                   </tr>
                   <tr>
                       <th colspan="7" style='text-align:right;'>Totals</th>
                       <th class='total_amount'><?= rupee_format($total_debit) ?></th>
                       <th class='total_amount'><?= rupee_format($total_credit) ?></th>
                   </tr>
                   </tbody>

                   <thead>
                   <tr class="table_header_row">
                       <th colspan="9" style="text-align: center; font-size: 18px;">
                           Payments
                       </th>
                   </tr>
                   <tr>
                       <th>Voucher#</th>
                       <th>Date</th>
                       <th>Supplier</th>
                       <th colspan="4">Bank</th>
                       <th>Debit</th>
                       <th>Credit</th>
                   </tr>
                   </thead>
                   <tbody>
                   <tr>
                       <?php
                       $total_product_quantity = 0;
                       $total_cost = 0;
                       $total_credit = 0;
                       $total_debit = 0;
                       ?>
                       <?php $parent_count = 0; ?>
                       <?php  foreach($payments as $record): ?>
                       <?php
                       $debit_entries = $record->debit_entries();
                       $credit_entries = $record->credit_entries();
                       ?>
                   <tr style="">

                       <td>
                           <?php
                           echo $record->id;
                           ?>
                       </td>

                       <td>
                           <?php
                           echo Carbon::createFromFormat('Y-m-d',$record->voucher_date)->toFormattedDateString();
                           ?>
                       </td>
                       <td>
                           <?php
                           $supplier = $debit_entries[0]->related_supplier;
                           echo $supplier;
                           ?>
                       </td>
                       <td colspan="4">
                           <?php
                           $bank = $credit_entries[0]->ac_title." [ ".$credit_entries[0]->ac_sub_title." ]";
                           echo $bank;
                           ?>
                       </td>
                       <td>
                           <?php
                           $amount = $credit_entries[0]->amount;
                           $total_debit += $amount;
                           echo rupee_format($amount);
                           ?>
                       </td>
                       <td>
                           <?php

                           ?>
                       </td>

                   </tr>
                   <?php endforeach; ?>
                   </tr>
                   <tr>
                       <th colspan="7" style='text-align:right;'>Totals</th>
                       <th class='total_amount'><?= rupee_format($total_debit) ?></th>
                       <th class='total_amount'><?= rupee_format($total_credit) ?></th>
                   </tr>
                   </tbody>
               </table>
           </div>
        </div>

    </div>

</div>