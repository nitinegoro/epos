<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Ubah Data Transaksi</h3>
	</div>
	<div class="box-body">
		<div class="col-md-6">
		<form method="POST" id="form_order" onsubmit="return cari_product()">
			<div class="form-group col-md-9">
				<div class="input-group">
					<input type="text" class="form-control input-lg" id="kode_barang" name="order" placeholder="Barcode Scanner.." autofocus="">
					<a class="input-group-addon" style="cursor: pointer;" data-toggle="modal" data-target="#search_product">Cari Manual <i class="fa fa-search"></i></a>
				</div><!-- /.input group -->
			</div>
		</form>
		</div>
		<div class="col-md-4 pull-right tool-harga">
			<span class="total-dibayar">Total :</span>
			<span id="total-atas" class="total-dibayar pull-right"></span>
		</div>
		<div class="col-md-6 col-md-offset-3" id="hasil">
		</div>
		<div class="col-md-12">
			<table class="table table-bordered blue" id="table-update-transaction" data-id="<?php echo $transaksi->ID_transaction ?>" data-selling="<?php echo $transaksi->selling_type; ?>">
				<thead class="bg-primary">
					<tr>
						<th width="4%">No.</th>
						<th width="16%">Kode Barang</th>
						<th width="25%">Nama</th>
						<th width="9%">Jumlah</th>
						<th width="10%">Satuan</th>
						<th width="15%">Harga</th>
						<th width="16%">Total</th> 
						<th width="5%">Ubah</th>         
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div><!-- /.box-body -->
	<div class="box-footer">
		<form id="form-bayar" method="POST" action="">
		<div class="col-md-4">

			<table class="table table-striped">
					<tr>
						<td><strong>Grand Total</strong></td>
						<td class="text-center" width="30">:</td>
						<td><span id="total-bawah"></span></td>
					</tr>
					<tr>
						<td><strong>Tunai</strong></td>
						<td class="text-center" width="30">:</td>
						<td>
							<div class="form-group">
								<input type="text" class="form-control input-lg" id="dibayar" name="bayar" value="<?php echo $transaksi->paid ?>" placeholder="Dibayar..">
							</div>
						</td>
					</tr>
					<tr>
						<td><strong>Kembali</strong></td>
						<td class="text-center" width="30">:</td>
						<td><span id="kembali">Rp. </span></td>
					</tr>
			</table>
		</div>
		<div class="pull-right">
			<a href="<?php echo base_url("transaksi/print_transaction/{$transaksi->ID_transaction}") ?>" target="_blank" class="btn btn-app btn-print"><i class="fa fa-print"></i> Cetak Ulang Nota</a>
		</div>
		</form> <!-- cart -->
	</div><!-- /.box-footer-->
</div><!-- /.box -->

<!-- INPUT DATA -->
<div class="modal animated" id="order_quantity" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<h5 class="modal-title">Masukkan jumlah pembelian</h5>
			</div>
			<form id="form-qty" method="post">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12">
						<table class="table table-bordered">
							<thead  style="color: white;" class="bg-blue">
								<tr>
									<th>Kode Barang</th>
									<th>Nama Produk</th>
									<th>Stock</th>
									<th>Satuan</th>
									<th>Harga Umum</th>
									<th>Harga Reseller</th>
								</tr>
							</thead>
							<tbody>
								<tr id="result"></tr>
							</tbody>
						</table>
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group col-md-4">
							<label>Quantity</label>
							<input type="text" class="form-control" id="qty" name="qty" placeholder="Quantity.." value="1" maxlength="3" requiblue>
							<input type="hidden" class="form-control" name="transaction" value="<?php echo $transaksi->ID_transaction ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="col-md-4">
					<div class="alert text-center alert-dismissable" id="message"></div>
				</div>
				<button type="button" id="out" class="btn btn-default" onclick="batal_beli()">Batal</button>
				<button type="submit" id="masukkan" class="btn btn-primary"><i class="fa fa-save"></i> Masukkan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- CARI DATA -->
<div class="modal animated" id="search_product" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<h5 class="modal-title">Cari Produk</h5>
			</div>
			<div class="modal-body">
						<table class="table table-bordered blue" id="table_ajax_product">
							<thead class="bg-blue">
								<tr>
									<th>Kode Barang</th>
									<th>Nama Produk</th>
									<th>Stock</th>
									<th>Satuan</th>
									<th>Harga Umum</th>
									<th>Harga Reseller</th>
									<th></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
			</div>
			<div class="modal-footer">
				<button type="button" id="out" class="btn btn-default" onclick="batal_beli()">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- STOCK HABIS -->
<div class="modal" id="modal-trans" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12" id="trans-content"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="batal_beli()">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- DELETE -->
<div class="modal modal-danger" id="modal-hapus" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h5 class="modal-title">Hapus Produk ini, Jumlah Stock akan dikembalikan?</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered bg-gray">
							<thead>
								<tr>
									<th>Kode Barang</th>
									<th>Nama Produk</th>
									<th>Jumlah</th>
									<th>Satuan</th>
									<th>Harga</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<tr id="data-cart"></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="batal_beli()">Close</button>
				<span id="btn"></span>
			</div>
		</div>
	</div>
</div>

<!-- EDIT -->
<div class="modal" id="modal-edit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-blue">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h5 class="modal-title" id="modal-title">Ubah Produk ini?</h5>
			</div>
			<form method="post" id="form-edit">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-bordered blue">
							<thead class="bg-blue">
								<tr>
									<th>Kode Barang</th>
									<th>Nama Produk</th>
									<th>Jumlah</th>
									<th>Satuan</th>
									<th>Harga</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<tr id="get-cart"></tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-12">
						<div class="form-group col-md-4">
							<label>Quantity</label>
							<input type="text" class="form-control" id="qty-edit" name="qty" placeholder="Quantity.." maxlength="3">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="batal_beli()">Close</button>
				<button type="submit" id="iya_edit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>
<style type="text/css">
tbody > tr { padding:-1000px; }
.total-dibayar { font-size:2em;  }
.mar-top { margin-top:5px; }
.input-group-addon:hover { color: #777; border-color: #444; }
</style>
<audio id="audio" src="<?php echo base_url('assets/scanner.mp3') ?>"></audio>