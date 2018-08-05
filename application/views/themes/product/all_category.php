<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Data Kategori</h3>
    <div class="col-md-2 pull-right">
      <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add-cat"><i class="fa fa-plus"></i> Tambah kategori Baru</a>
    </div>
    <div class="col-md-3 pull-right">
      <form action="<?php echo site_url('category'); ?>" method="get">
      <div class="input-group" style="width: auto;">
        <input type="text" id="cari" name="q" class="form-control input-sm pull-right" placeholder="Pencarian..">
        <div class="input-group-btn">
          <button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="box-body">
    <div class="col-md-12">
    <form action="<?php echo site_url('category/action_multiple') ?>" method="post">
    <div class="col-md-2">
    	<div class="form-group">
    		<select class="form-control input-sm" name="action">
    			<option>~ TINDAKAN MASAL ~</option>
    			<option value="delete">Hapus</option>
    		</select>
    	</div>
    </div>
    <div class="col-md-2">
    	<div class="form-group">
    		<button type="submit" class="btn btn-default btn-sm">Terapkan</button>
    	</div>
    </div>
    <table class="table table-bordered" id="table-category">
    	<thead class="bg-blue">
    		<tr>
    			<th width="20">
    				<label><input type="checkbox" id="checkAll" name="checkAll"></label>
    			</th>
    			<th width="50">No.</th>
    			<th>Nama Kategori</th>
    			<th>Jumlah Produk</th>
    			<th width="100"></th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php $no = (!$this->input->get('page')) ? 1 : $this->input->get('page'); foreach($category as $row) : 
    		if($row->category_product==1) : continue; endif;
    		$nama = highlight_phrase($row->category, $this->input->get('q'), '<b style="color:#E40000;">','</b>'); ?>
    		<tr id="category-<?php echo $row->category_product ?>">
    			<td>
    				<label><input type="checkbox" name="cat[]" value="<?php echo $row->category_product ?>"></label>
    			</td>
    			<td><?php echo $no++; ?>.</td>
    			<td><?php echo $nama; ?></td>
    			<td><?php echo $this->mcategory->count_product($row->category_product); ?></td>
    			<td class="text-center">
    				<a href="#" class="btn btn-xs btn-primary" onclick="update_category('<?php echo $row->category_product ?>','<?php echo $row->category; ?>');"><i class="fa fa-pencil"></i></a>
    				<a href="#" class="btn btn-xs btn-danger" onclick="delete_category('<?php echo $row->category_product ?>','<?php echo $row->category; ?>');"><i class="fa fa-trash-o"></i></a>
    			</td>
    		</tr>
    	<?php endforeach; ?>
    	</tbody>
    </table>
    </form>
    </div>
   	<div class="col-md-12 text-center">
     	<?php echo $this->pagination->create_links(); ?>
   	</div>
  </div><!-- /.box-body -->
</div><!-- /.box -->
  
<style type="text/css">

</style>

<!-- MODAL ADD -->
<div class="modal" id="modal-add-cat" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5 class="modal-title">Form Penambahan Kategori</h5>
			</div>
      <form id="form-add-category" method="post" class="form-horizontal" action="<?php echo site_url('category/add_category') ?>">
      <div class="modal-body">
        <div class="form-group">
          <label class="col-lg-2 control-label">Kategori</label>
          <div class="col-lg-7">
            <input class="form-control" type="text" name="cat_add[1]" placeholder="Kategori #1" />
          </div>
          <div class="col-lg-3">
            <button type="button" class="btn btn-default btn-sm addButton" data-template="cat_add">Add</button>
          </div>
        </div>
        <div class="form-group hide" id="cat_addTemplate">
          <div class="col-lg-offset-2 col-lg-7">
            <input class="form-control" type="text" />
          </div>
          <div class="col-lg-3">
            <button type="button" class="btn btn-default btn-sm removeButton">Remove</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
      </div>
      </form>
		</div>
	</div>
</div>

<!-- MODAL ADD -->
<div class="modal" id="modal-edit-cat" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5 class="modal-title">Form mengubah Nama kategori</h5>
			</div>
      <form id="form-edit-category" method="post" class="form-horizontal" action="#>">
      <div class="modal-body">
        <div class="form-group">
          <label class="col-lg-2 control-label">Kategori</label>
          <div class="col-lg-8">
            <input class="form-control" type="text" name="category" id="name_category" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" id="edit-category"><i class="fa fa-save"></i> Simpan</button>
      </div>
      </form>
		</div>
	</div>
</div>

<!-- MODAL DELETE -->
<div class="modal" id="modal-del-cat" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5 class="modal-title">Hapus kategori yang dipilih?</h5>
			</div>
			<div class="modal-body">
				<p class="text-center"><strong id="category_name"></strong></p>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="hapus-category"> Iya</button>
      </div>
		</div>
	</div>
</div>