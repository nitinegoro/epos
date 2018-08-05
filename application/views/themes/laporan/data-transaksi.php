 <?php $kemarin = date('Y-m-d', strtotime("-1 days", strtotime(date('Y-m-d')))); ?>
<div class="box box-default">
	<div class="box-header with-border no-print">
		<h3 class="box-title">Data Transaksi Penjualan</h3>
		<div class="col-md-3 pull-right">
			<form action="<?php echo site_url('data_transaksi'); ?>" method="get">
			<div class="input-group" style="width: auto; margin-top: 20px;">
				<input type="text" id="cari" name="query" class="form-control input-sm pull-right" placeholder="No. Transaksi.." value="<?php echo $this->input->get('query') ?>">
				<div class="input-group-btn">
					<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<div class="box-body no-print">
		<div class="col-md-12">
		<form class="">
		 <div class="col-md-2 mini-font">
			<div class="form-group">
				<label>Per Halaman :</label>
				<select name="per_page" class="form-control input-sm" required="required">
				<?php $value = 0; while($value < 100) : ?>
					<option value="<?php echo $value+=20; ?>" <?php if($this->per_page==$value) echo 'selected'; ?>><?php echo $value; ?></option>
				<?php endwhile; ?>
				</select>
			</div><!-- /.form group -->
		 </div>
		 <div class="col-md-3 mini-font">
			<div class="form-group">
				<label>Dari Tanggal :</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					<input type="text" class="form-control input-sm pull-right" name="from" id="tgl-dari" value="<?php echo (!$this->input->get('from')) ? date('Y-m-d') : $this->input->get('from') ?>">
				</div><!-- /.input group -->
			</div><!-- /.form group -->
		 </div>
		 <div class="col-md-3 mini-font">
			<div class="form-group">
				<label>Sampai Tanggal :</label>
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					<input type="text" class="form-control input-sm pull-right" name="to" id="tgl-sampai" value="<?php echo (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to') ?>">
				</div><!-- /.input group -->
			</div><!-- /.form group -->
		 </div>
		 <div class="col-md-2 mini-font">
			<div class="form-group">
				<label>Kasir : </label>
				<select class="form-control input-sm" name="kasir">
					<option value="">~ PILIH ~</option>
					<?php foreach($this->db->get('users')->result() as $row) : ?>
					<option value="<?php echo $row->id; ?>" <?php echo ($row->id==$this->input->get('kasir')) ? 'selected' : ''; ?>><?php echo $row->name; ?></option>
				<?php endforeach; ?>
				</select>
			</div>       
		 </div>
		 <div class="col-md-2">
				<button type="submit" class="btn btn-primary top"><i class="fa fa-search"></i> Filter</button>
				<a href="<?php echo site_url('data_transaksi') ?>" class="btn btn-default top left"><i class="fa fa-times"></i> Reset</a>
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
						<th class="text-center" width="100" class="no-print"></th>
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
						<td class="text-center">
						<?php if($date->format('Y-m-d') == date('Y-m-d')) : ?>
							<a href="<?php echo base_url("transaksi/print_transaction/{$row->ID_transaction}") ?>" target="_blank" class="btn btn-xs btn-default btn-print"><i class="fa fa-print"></i></a>
							<a href="<?php echo base_url("data_transaksi/update/{$row->ID_transaction}") ?>" class="btn btn-xs btn-primary"><i class="fa fa-wrench"></i></a>
							<button type="button" data-id="<?php echo $row->ID_transaction ?>" class="btn btn-xs btn-danger delete-transaksi"><i class="fa fa-trash-o"></i></button>
						<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
				<tfoot class="mini-font">
					<tr>
						<th colspan="5"><span class="pull-right">Total :</span></th>
						<th colspan="2" class="text-success"><h4>Rp. <?php echo number_format($subtotal) ?></h4></th>
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