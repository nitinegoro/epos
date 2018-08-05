<div class="row">
	<div class="col-md-6 col-md-offset-3 col-xs-12"><?php echo $this->session->flashdata('notif'); ?></div>
	<div class="col-md-12 bottom2x">
		<div class="col-md-4">
			<a href="<?php echo base_url("product") ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
	<?php echo form_open(current_url()); ?>
	<div class="col-md-8 col-md-offset-2">
		<div class="box-footer">
			<div class="form-horizontal">
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Nama Produk</label>
					</div>
					<div class="col-md-10">
					  	<input type="text" name="name" value="<?php echo (set_value('name')) ? set_value('name') : $get->product_name ?>" class="form-control input-sm" <?php if($this->ion_auth->in_group(array(2))) echo 'readonly'; ?>>
					  	<p><?php echo form_error('name', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Kode Produk</label>
					</div>
					<div class="col-md-5">
						<input type="text" name="code" value="<?php echo (set_value('code')) ? set_value('code') : $get->product_code ?>" class="form-control input-sm" <?php if($this->ion_auth->in_group(array(2))) echo 'readonly'; ?>>
						<p><?php echo form_error('code', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Satuan</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="unit" value="<?php echo (set_value('unit')) ? set_value('unit') : $get->product_unit ?>" class="form-control input-sm" <?php if($this->ion_auth->in_group(array(2))) echo 'readonly'; ?>>
						<p><?php echo form_error('unit', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Kategori Produk</label>
					</div>
					<div class="col-md-7">
						<select name="category" class="form-control">
							<option value="">-- PILIH KATEGORI --</option>
						<?php foreach($this->db->get('tb_category_product')->result() as $row) : ?>
							<option value="<?php echo $row->category_product ?>" <?php if($get->category_product == $row->category_product) echo 'selected'; ?>><?php echo $row->category ?></option>
						<?php endforeach; ?>
						</select>
						<p><?php echo form_error('category', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Jumlah Stok</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="stock" value="<?php echo (set_value('stock')) ? set_value('stock') : $get->stock ?>" class="form-control input-sm">
						<p><?php echo form_error('stock', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Harga Beli</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="purchase" value="<?php echo (set_value('purchase')) ? set_value('purchase') : $get->purchase ?>" class="form-control input-sm" <?php if($this->ion_auth->in_group(array(2))) echo 'readonly'; ?>>
						<p><?php echo form_error('purchase', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Harga Jual Umum</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="default_price" value="<?php echo (set_value('default_price')) ? set_value('default_price') : $get->default_price ?>" class="form-control input-sm" <?php if($this->ion_auth->in_group(array(2))) echo 'readonly'; ?>>
						<p><?php echo form_error('default_price', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Harga Jual Grosir</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="reseller_price" value="<?php echo (set_value('reseller_price')) ? set_value('reseller_price') : $get->reseller_price ?>" class="form-control input-sm" <?php if($this->ion_auth->in_group(array(2))) echo 'readonly'; ?>>
						<p><?php echo form_error('reseller_price', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="col-md-8 col-md-offset-2">
				<a href="<?php echo base_url('product') ?>" class="btn btn-app pull-left"><i class="fa fa-times"></i> Batal</a>
				<button type="submit" class="btn btn-app bg-blue pull-right"><i class="fa fa-save"></i> Create</button>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>



