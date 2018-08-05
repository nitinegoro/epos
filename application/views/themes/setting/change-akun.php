<div class="row">
	<div class="col-md-6 col-md-offset-3 col-xs-12"><?php echo $this->session->flashdata('notif'); ?></div>
	<div class="col-md-12 bottom2x">
		<div class="col-md-4">
			<a href="<?php echo base_url("users") ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
		</div>
	</div>
	<?php echo form_open(current_url()); ?>
	<div class="col-md-8 col-md-offset-2">
		<div class="box-footer">
			<div class="form-horizontal">
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Nama Pengguna</label>
					</div>
					<div class="col-md-10">
					  	<input type="text" name="name" value="<?php echo (set_value('name')) ? set_value('name') : $this->account->name ?>" class="form-control input-sm">
					  	<p><?php echo form_error('name', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Email</label>
					</div>
					<div class="col-md-5">
						<input type="email" name="email" value="<?php echo (set_value('email')) ? set_value('email') : $this->account->email ?>" class="form-control input-sm">
						<p><?php echo form_error('email', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Telepon</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="phone" value="<?php echo (set_value('phone')) ? set_value('phone') : $this->account->phone ?>" class="form-control input-sm">
						<p><?php echo form_error('phone', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Password</label>
					</div>
					<div class="col-md-8">
						<input type="password" name="password" value="<?php echo set_value('password') ?>" class="form-control input-sm">
						<p><?php echo form_error('password', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="col-md-8 col-md-offset-2">
				<a href="<?php echo base_url('users') ?>" class="btn btn-app pull-left"><i class="fa fa-times"></i> Batal</a>
				<button type="submit" class="btn btn-app bg-blue pull-right"><i class="fa fa-save"></i> Simpan Perubahan</button>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>



