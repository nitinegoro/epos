<div class="row">
	<div class="col-md-6 col-md-offset-3 col-xs-12"><?php echo $this->session->flashdata('alert'); ?></div>
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
					  	<input type="text" name="name" value="<?php echo set_value('name') ?>" class="form-control input-sm">
					  	<p><?php echo form_error('name', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Email</label>
					</div>
					<div class="col-md-5">
						<input type="email" name="email" value="<?php echo set_value('email') ?>" class="form-control input-sm">
						<p><?php echo form_error('email', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Telepon</label>
					</div>
					<div class="col-md-3">
						<input type="text" name="phone" value="<?php echo set_value('phone') ?>" class="form-control input-sm">
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
				<div class="form-group">
					<div class="col-md-2">
						<label for="">Akses Penggunan</label>
					</div>
					<div class="col-md-7">
						<select name="group" class="form-control">
							<option value="">-- PILIH --</option>
						<?php foreach($this->db->get('groups')->result() as $row) : ?>
							<option value="<?php echo $row->id ?>" <?php if(set_value('group') == $row->id) echo 'selected'; ?>><?php echo $row->description ?></option>
						<?php endforeach; ?>
						</select>
						<p><?php echo form_error('group', '<small class="text-red">','</small>') ?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="col-md-8 col-md-offset-2">
				<a href="<?php echo base_url('users') ?>" class="btn btn-app pull-left"><i class="fa fa-times"></i> Batal</a>
				<button type="submit" class="btn btn-app bg-blue pull-right"><i class="fa fa-save"></i> Create</button>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>



