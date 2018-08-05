

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('print/header', $this->data, FALSE);

$startDate = new DateTime($this->input->get('from'));
$endDate = new DateTime($this->input->get('to'));
?>
<div style="text-align: right;">
	<a style="color:white; background-color:blue;text-decoration:none; font-weight: bold; border:1px solid blue;padding: 5px; border-radius: 5px; " href="javascript:window.print()" class="hidden-print">
	    <i class="fa fa-print"></i> Cetak Laporan 
	</a>
</div>
<p style="text-align: right"><span><?php echo date('d F Y') ?></span></p>
<p class="text-center"><strong class="head">LAPORAN PENJUALAN</strong></p>
	<table align="left" style="margin-bottom: 20px; width: 100%">
		<tr>
			<td width="90">Periode</td>
			<td class="text-center">:</td>
			<td><?php echo $startDate->format('d F Y') ?> <small>sampai</small> <?php echo $endDate->format('d F Y') ?></td>
		</tr>
		<tr>
			<td width="50">Operator Kasir</td>
			<td class="text-center">:</td>
			<td><?php echo $this->account->name ?></td>
		</tr>
	</table>
			<table class="table-bordered" width="100%">
				<thead class="bg-primary">
					<tr>
						<th class="text-center" width="8">No.</th>
						<th class="text-center" width="150">No. Transaksi</th>
						<th class="text-center">Tanggal </th>
						<th class="text-center">Tipe Penjualan</th>
						<th class="text-center">Total Transaksi</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$grandtotal = 0;
				foreach($transaksi as $row) : 

					$date = new DateTime($row->date);

					$grandtotal += $row->total;
				?>
					<tr>
						<td><?php echo ++$this->page ?>.</td>
						<td><?php echo $row->ID_transaction ?></td>
						<td><?php echo $date->format('d F Y - H:i A'); ?></td>
						<td class="text-center"><?php echo ($row->selling_type=='default') ? 'Umum' : 'Grosir'; ?></td>
						<td class="text-center">Rp. <?php echo number_format($row->total) ?></td>					
					</tr>
				<?php endforeach; ?>
				</tbody>
				<tfoot class="mini-font">
					<tr>
						<td colspan="4"><strong class="pull-right">Total :</strong></td>
						<td colspan="2" class="text-success text-center"><strong>Rp. <?php echo number_format($grandtotal) ?></strong></td>
					</tr>
				</tfoot>
			</table>
	
	<div class="pagebreak"></div>

<p style="text-align: right"><span><?php echo date('d F Y') ?></span></p>
<p class="text-center"><strong class="head">LAPORAN KAS KEUANGAN</strong></p>

	<table align="left" style="margin-bottom: 20px; width: 100%">
		<tr>
			<td width="90">Periode</td>
			<td class="text-center">:</td>
			<td><?php echo $startDate->format('d F Y') ?> <small>sampai</small> <?php echo $endDate->format('d F Y') ?></td>
		</tr>
		<tr>
			<td width="50">Operator Kasir</td>
			<td class="text-center">:</td>
			<td><?php echo $this->account->name ?></td>
		</tr>
	</table>
			<table class="table-bordered" width="100%">
				<thead class="bg-primary">
					<tr>
						<th class="text-center" width="8">No.</th>
						<th class="text-center" width="150">Tanggal </th>
						<th class="text-center">Keterangan</th>
						<th class="text-center" width="90">Debit</th>
						<th class="text-center" width="90">Kredit</th>
						<th class="text-center" width="90">Saldo</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$debit = 0;
				$kredit = 0;
				$saldo = 0;
				$key = 0;
				foreach($this->cash_balance->getRangeDate($startDate->format('Y-m-d'), $endDate->format('Y-m-d')) as $key => $row) : 

					$date = new DateTime($row->date);
				?>
					<tr>
						<td><?php echo ++$key ?>.</td>
						<td><?php echo $date->format('d F Y - H:i A'); ?></td>
						<td><?php echo $row->description; ?></td>
						<td class="text-center">
							<?php 
							if($row->mutation=='masuk')  
							{
								echo 'Rp. '.number_format($row->amount); 

								$debit += $row->amount;
							}
							?>
						</td>	
						<td class="text-center">
							<?php 
							if($row->mutation=='keluar')  
							{
								echo 'Rp. '.number_format($row->amount); 

								$kredit += $row->amount;
							}
							?>
						</td>	
						<?php $saldo = ($debit-$kredit); ?>
						<td class="text-center">Rp. <?php echo number_format(($debit-$kredit)) ?></td>					
					</tr>
				<?php endforeach; ?>
					<tr style="vertical-align: top">
						<td><?php echo ++$key ?>.</td>
						<td><?php echo date('d F Y - H:i A'); ?></td>
						<td>Penjualan periode <?php echo $startDate->format('d F Y') ?> <small>sampai</small> <?php echo $endDate->format('d F Y') ?></td>
						<td class="text-center">
							<?php 
								echo 'Rp. '.number_format($grandtotal); 

								$debit += $grandtotal;
							?>
						</td>	
						<?php $saldo = ($debit-$kredit); ?>
						<td class="text-center"></td>	
						<td class="text-center">Rp. <?php echo number_format($saldo) ?></td>					
					</tr>
				</tbody>
				<tfoot class="mini-font">
					<tr>
						<td colspan="3"><strong class="pull-right">Total :</strong></td>
						<td class="text-success text-center"><strong>Rp. <?php echo number_format($debit) ?></strong></td>
						<td class="text-success text-center"><strong>Rp. <?php echo number_format($kredit) ?></strong></td>
						<td class="text-success text-center"><strong>Rp. <?php echo number_format($saldo) ?></strong></td>
					</tr>
					<tr>
						<td colspan="3"><strong class="pull-right">Saldo Akhir :</strong></td>
						<td colspan="3" class="text-success text-center"><strong>Rp. <?php echo number_format($saldo) ?></strong></td>
					</tr>
				</tfoot>
			</table>
<?php
$this->load->view('print/footer', $this->data, FALSE);

/* End of file cetak-laporan.php */
/* Location: ./application/views/administrator/pages/cetak-laporan.php */
?>