<?php echo form_open(site_url('transaksi/update/')); ?>

<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
        <th>QTY</th>
        <th>Item Description</th>
        <th style="text-align:right">Item Price</th>
        <th style="text-align:right">Sub-Total</th>
</tr>

<?php $i = 0; ?>

<?php foreach ($this->cart->contents() as $items): ?>

        <?php echo form_hidden('id', $items['rowid']); ?>

        <tr>
                <td><?php echo form_input(array('name' => 'qty', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></td>
                <td>
                        <?php echo $items['name']; ?>

                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

                                <p>
                                        <?php foreach ($this->cart->product_options($items['id']) as $option_name): ?>

                                                <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

                                        <?php endforeach; ?>
                                </p>
                                <strong><?php echo $items['rowid']; ?></strong>
                        <?php endif; ?>

                </td>
                <td style="text-align:right"><?php echo $this->cart->format_number($items['price']); ?></td>
                <td style="text-align:right"><?php echo $this->cart->format_number($items['subtotal']); ?></td>
                <td><a href="<?php echo site_url('transaksi/delete/'.$items['rowid']) ?>">delete</a></td>
        </tr>

<?php $i++; ?>

<?php endforeach; ?>

<tr>
        <td colspan="2"> </td>
        <td class="right"><strong>Total</strong></td>
        <td class="right"><?php echo $this->cart->format_number($this->cart->total()); ?></td>
</tr>

</table>

<p><?php echo form_submit('', 'Update your Cart'); ?></p>



<table class="table table-bordered">
        <?php foreach ($this->cart->contents(8995078803078) as $h): ?>
        <tr>
                <td><?php echo $h['name']; ?></td>
        </tr>
<?php endforeach; ?>
</table>