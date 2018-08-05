<div class="box box-default">
	<div class="box-header with-border no-print">
		<h3 class="box-title">Laporan Transaksi Penjualan</h3>
		<span class="pull-right">
			Tanggal : <strong><?php echo date('d, M Y') ?></strong>
		</span>
	</div>
	<div class="box-body no-print">
		<div class="col-md-12">
		<form class="">
		 <div class="col-md-2 mini-font">
			<div class="form-group">
				<label>Tampilkan Per Halaman :</label>
				<select name="per_page" class="form-control input-sm" required="required">
				<?php $value = 0; while($value < 100) : ?>
					<option value="<?php echo $value+=20; ?>" <?php if($this->per_page==$value) echo 'selected'; ?>><?php echo $value; ?></option>
				<?php endwhile; ?>
				</select>
			</div><!-- /.form group -->
		 </div>
		 <div class="col-md-2 mini-font">
			<div class="form-group">
				<label>Dari Tanggal :</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					<input type="text" class="form-control input-sm pull-right" name="from" id="tgl-dari" value="<?php echo (!$this->input->get('from')) ? date('Y-m-d') : $this->input->get('from') ?>" required>
				</div><!-- /.input group -->
			</div><!-- /.form group -->
		 </div>
		 <div class="col-md-2 mini-font">
			<div class="form-group">
				<label>Sampai Tanggal :</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					<input type="text" class="form-control input-sm pull-right" name="to" id="tgl-sampai" value="<?php echo (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to') ?>" required>
				</div><!-- /.input group -->
			</div><!-- /.form group -->
		 </div>
		 <div class="col-md-2 mini-font">
			<div class="form-group">
				<label>Kasir : </label>
				<select class="form-control input-sm" name="kasir" required>
					<option value="">~ PILIH ~</option>
					<?php foreach($this->db->get('users')->result() as $row) : ?>
					<option value="<?php echo $row->id; ?>" <?php echo ($row->id==$this->input->get('kasir')) ? 'selected' : ''; ?>><?php echo $row->name; ?></option>
				<?php endforeach; ?>
				</select>
			</div>       
		 </div>
		 <div class="col-md-4">
			<button type="submit" class="btn btn-primary top"><i class="fa fa-search"></i> Filter</button>
			<?php if($this->input->get('from') != '') : ?>
			<a href="<?php echo base_url("data_transaksi/cetaklaporan?from={$this->input->get('from')}&to={$this->input->get('to')}&kasir={$this->input->get('kasir')}") ?>" class="btn btn-primary top" target="_blank"><i class="fa fa-print"></i> Cetak Laporan</a>
			<?php endif; ?>
			<a href="<?php echo site_url('data_transaksi/report') ?>" class="btn btn-default top left"><i class="fa fa-times"></i> Reset</a>
		 </div>
		</form>
		</div>
	</div><!-- /.box-body -->  
	<div class="box-body">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead class="bg-primary">
					<tr>
						<th class="text-center" width="8">No.</th>
						<th class="text-center" width="150">No. Transaksi</th>
						<th class="text-center">Tanggal </th>
						<th class="text-center">Tipe Penjualan</th>
						<th class="text-center">Nama Kasir</th>
						<th class="text-center">Total Transaksi</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$subtotal = 0;
				foreach($transaksi as $row) : 

					$date = new DateTime($row->date);

					$subtotal += $row->total;
				?>
					<tr>
						<td><?php echo ++$this->page ?>.</td>
						<td><?php echo $row->ID_transaction ?></td>
						<td><?php echo $date->format('d F Y - H:i A'); ?></td>
						<td><?php echo ($row->selling_type=='default') ? 'Umum' : 'Grosir'; ?></td>
						<td><?php echo $row->name ?></td>
						<td class="text-center">Rp. <?php echo number_format($row->total) ?></td>					
					</tr>
				<?php endforeach; ?>
				</tbody>
				<tfoot class="mini-font">
					<tr>
						<th colspan="5"><span class="pull-right">Total :</span></th>
						<th colspan="2" class="text-success">Rp. <?php echo number_format($subtotal) ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="col-md-12 text-center">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div><!-- /.box-body -->
	<div class="box-footer">
		<div class="pull-right">

		</div>
	</div><!-- /.box-footer-->
</div><!-- /.box -->
	
<style type="text/css">
	.top { margin-top:20px; }
	.mini-font { font-size:12px; }

</style>