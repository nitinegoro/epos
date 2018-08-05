<div class="col-md-6 col-md-offset-3 col-xs-12"><?php $this->session->flashdata('notif'); ?></div>
<div class="box box-primary">
  <div class="box-header with-border no-print">
    <h3 class="box-title">Pengaturan Pengguna Aplikasi</h3>
    <div class="col-md-2 pull-right">
      <a href="<?php echo base_url("users/create") ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Pengguna Baru</a>
    </div>
    <div class="col-md-3 pull-right">
      <form action="<?php echo site_url('users'); ?>" method="get">
      <div class="input-group" style="width: auto;">
        <input type="text" id="cari" name="query" class="form-control input-sm pull-right" value="<?php echo $this->input->get('query') ?>" placeholder="Pencarian..">
        <div class="input-group-btn">
          <button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="box-body no-padding">
    	<table class="table table-bordered">
    		<thead class="bg-primary">
    			<tr>
    				<th width="50">No.</th>
    				<th class="text-center">Nama Lengkap</th>
    				<th class="text-center">Telepon</th>
    				<th class="text-center">Status Users</th>
    				<th class="text-center">Hak Akses</th>
    				<th width="100"></th>
    			</tr>
    		</thead>
    		<tbody>
    		<?php foreach($users as $row) :  ?>
    			<tr>
    				<td><?php echo ++$this->page ?>.</td>
					<td><?php echo $row->name; ?></td>
					<td><?php echo $row->phone ?></td>
					<td><?php echo ($row->active==1) ? 'AKTIF' : 'NON AKTIF'; ?></td>
					<td><?php echo $row->group_name; ?></td>
    				<td class="text-center">
    				<?php if ($this->ion_auth->in_group(array(1))) : ?>
              <?php if($row->id != $this->account->id) : ?>
    					<a href="<?php echo base_url("users/update/{$row->id}") ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
    					<?php endif; if($row->id != $this->account->id OR $row->id != 1) : ?>
    					<button class="btn btn-xs btn-danger delete-user" data-id="<?php echo $row->id ?>"><i class="fa fa-trash-o"></i></button>
    					<?php endif; ?>
    				<?php endif; ?>
    				</td>
    			</tr>
    		<?php endforeach; ?>
    		</tbody>
    	</table>
    <div class="col-md-12 text-center">
      <?php echo $this->pagination->create_links(); ?>
    </div>
  </div>
</div><!-- /.box -->
  
<style type="text/css">
.left { margin-left:30px; }
</style>

