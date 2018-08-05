<div class="row">
	<div class="col-md-6 col-md-offset-3 col-xs-12"><?php $this->session->flashdata('notif'); ?></div>
	<?php echo form_open(current_url(), array('method' => 'get')); ?>
	<div class="col-md-12 bottom2x">
		<div class="col-md-2">
			<?php if($this->ion_auth->in_group(array(1))) : ?>
			<a href="<?php echo base_url("product/create"); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Produk</a>
			<?php endif; ?>
		</div>
		<div class="col-md-4 pull-right">
            <div class="input-group input-group-sm">
            	<input type="text" name="query" class="form-control" value="<?php echo $this->input->get('query') ?>" placeholder="Pencarian ...">
            	<div class="input-group-btn">
                  	<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari Produk</button> 
            	</div>
            </div>
		</div>
	</div>
	<?php echo form_close(); ?>
	<div class="col-md-12" style="margin-top: 15px;">
		<div class="box box-default">
		<?php echo form_open(base_url("administrator/sproduct/bulkaction")); ?>
			<table class="table table-bordered table-hover checked">
				<thead class="bg-blue">
					<tr>
						<th width="30" rowspan="2">No.</th>
						<th class="text-center" rowspan="2" width="130">KD. Produk</th>
						<th class="text-center" rowspan="2">Nama Produk</th>
						<th class="text-center" rowspan="2" width="70">Satuan</th>
						<th class="text-center" rowspan="2" width="60">Stok</th>
						<th class="text-center" rowspan="2">Kategori</th>
						<th class="text-center" colspan="2">Harga</th>
						<th class="text-center" rowspan="2">Kelola</th>
					</tr>
					<tr>
						<th class="text-center">Umum</th>
						<th class="text-center">Reseller</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($products as $key => $row) :  ?>
					<tr class="item-<?php echo $row->ID ?>">
						<td><?php echo ++$this->page ?>.</td>
						<td><?php echo $row->product_code ?></td>
						<td><?php echo $row->product_name ?></td>
						<td class="text-center"><?php echo strtoupper($row->product_unit) ?></td>
						<td class="text-center"><?php echo $row->stock ?></td>
						<td><?php echo $row->category ?></td>
						<td>Rp. <?php echo number_format($row->default_price); ?></td>
						<td>Rp. <?php echo number_format($row->reseller_price); ?></td>
						<td width="80" class="text-center">
							<a href="<?php echo base_url("product/update/{$row->ID}") ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
						<?php if($this->ion_auth->in_group(array(1))) : ?>
							<button type="button" data-id="<?php echo $row->ID ?>" class="btn btn-xs btn-danger delete-produk"><i class="fa fa-trash-o"></i></button>
						<?php endif; ?>
						</td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		<?php echo form_close(); ?>
		</div>
		<div class="text-center">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div>
</div>
