 <?php 

 $enddate= date('Y-m-d', strtotime("-1 days", strtotime(date('Y-m-d'))));

    $dataTransaksi =  $this->mtransaction->getallByUser(date('Y-m-d'), date('Y-m-d'), $this->account->id,'result');
 
        $grandtotal = 0;
        foreach($dataTransaksi as $row) 
          $grandtotal += $row->total;

 ?>
<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header bg-blue">
        <span class="box-title">Pencatatan Keuangan</span>
      </div>
      <form action="<?php echo base_url('main/addsaldo') ?>" method="POST">
      <div class="box-body">
        <div class="form-group">
          <div class="col-md-6">
            <label for="">Jumlah Uang</label>
              <input type="text" name="amount" class="form-control input-sm" required>
          </div>
          <div class="col-md-6">
            <label for="">Jenis</label>
            <select name="mutation" id="inputMutation" class="form-control input-sm" required>
              <option value="">-- PILIH --</option>
              <option value="masuk">Uang Masuk</option>
              <option value="keluar">Uang Keluar</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12" style="margin-top: 10px;">
            <textarea name="description" class="form-control" rows="2" placeholder="Keterangan..." required></textarea>
          </div>
        </div>
      </div>
      <div class="box-footer">
         <div class="col-md-4 pull-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Catat Keuangan</button>
         </div>
      </div>
      </form>
    </div>
  </div>
  <div class="col-md-6">
    <div class="col-lg-6 col-xs-6">
      <div class="info-box bg-green">
        <span class="info-box-icon"><i class="ion ion-arrow-graph-up-right"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Penjualan Hari ini</span>
          <span class="info-box-number">Rp. <?php echo number_format( $grandtotal) ?></span>
          <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
          <span class="progress-description"><?php echo @count(@$dataTransaksi); ?> Transaksi</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div>
    <div class="col-lg-6 col-xs-6">
      <div class="info-box bg-yellow">
        <span class="info-box-icon"><i class="ion ion-arrow-graph-up-left"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Penjualan Kemarin</span>
          <span class="info-box-number">Rp. <?php echo number_format($this->mtransaction->profit($enddate)) ?></span>
          <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
          <span class="progress-description"><?php echo $this->mtransaction->count($enddate); ?> Transaksi</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div>
    <div class="col-lg-6 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner"><h3><?php echo $this->db->count_all('tb_product'); ?></h3><p>Jumlah Produk</p></div>
        <div class="icon"><i class="ion ion-bag"></i></div>
      </div>
    </div><!-- ./col -->
    <?php  
    /* HITUNG SALDO */


        $debit = 0;
        $kredit = 0;
        $saldo = 0;
        foreach($this->cash_balance->getByDate(date('Y-m-d')) as $key => $row)
        {
            if($row->mutation=='masuk')  
                $debit += $row->amount;

            if($row->mutation=='keluar')  
                $kredit += $row->amount;

            $saldo = ($debit-$kredit);
        }

        $debit += $grandtotal;

        $saldo = ($debit-$kredit);
    ?>

    <div class="col-lg-6 col-xs-6">
      <div class="small-box bg-blue">
        <div class="inner"><h3> Rp. <?php echo number_format($saldo) ?></h3><p>Kas Hari ini</p>
        </div>
        <div class="icon"><i class="fa fa-money"></i></div>
      </div>
    </div><!-- ./col --> 
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-header bg-blue">
        <span class="box-title">Uang Masuk</span>
      </div>
      <div class="box-body no-padding" id="masuk-box">
        <table class="table table-hover">
        <?php foreach($this->cash_balance->getByDate(date('Y-m-d'), 'masuk') as $row) : 
          $dateMasuk = new DateTime($row->date);
        ?>
            <tr id="masuk-<?php echo $row->ID; ?>">
              <td>
                <strong id="set-amount-<?php echo $row->ID; ?>"><?php echo 'Rp. '.number_format($row->amount) ?></strong>
                <p><small id="set-desc-<?php echo $row->ID; ?>"><?php echo $row->description ?></small></p>
                <p><i class="fa fa-clock-o"></i> <i><?php echo $dateMasuk->format('H:i A') ?></i></p>
              </td>
              <td width="40">
                <button class="btn btn-xs update-cash" data-id="<?php echo $row->ID ?>"><i class="fa fa-pencil"></i></button>
                <button class="btn btn-xs text-danger delete-cash" data-id="<?php echo $row->ID ?>"><i class="fa fa-trash-o"></i></button>
              </td>
            </tr>
          <?php endforeach; ?>
          </table>  
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-header bg-blue">
        <span class="box-title">Uang Keluar</span>
      </div>
      <div class="box-body no-padding" id="keluar-box">
        <table class="table table-hover">
        <?php 
        foreach($this->cash_balance->getByDate(date('Y-m-d'), 'keluar') as $row) : 
          $dateKeluar = new DateTime($row->date);
        ?>
            <tr id="keluar-<?php echo $row->ID; ?>">
              <td>
                <strong id="set-amount-<?php echo $row->ID; ?>"><?php echo 'Rp. '.number_format($row->amount) ?></strong>
                <p><small id="set-desc-<?php echo $row->ID; ?>"><?php echo $row->description ?></small></p>
                <p><i class="fa fa-clock-o"></i> <i><?php echo $dateKeluar->format('H:i A') ?></i></p>
              </td>
              <td>
                <button class="btn btn-xs update-cash" data-id="<?php echo $row->ID ?>"><i class="fa fa-pencil"></i></button>
                <button class="btn btn-xs text-danger delete-cash" data-id="<?php echo $row->ID ?>"><i class="fa fa-trash-o"></i></button>
              </td>
            </tr>
          <?php endforeach; ?>
          </table>  
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="chart">
      <canvas id="areaChart" style="height:250px"></canvas>
    </div>
  </div>
</div>

<div class="modal" id="modal-form-cash" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Ubah data</h5>
      </div>
      <form action="" method="POST" role="form" id="form-cash_balance">
      <div class="modal-body">
        <div class="form-group">
          <label for="">Jumlah</label>
          <input type="text" name="amount" id="get-amount" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="">Keterangan</label>
          <textarea name="description" rows="3" id="get-desc" class="form-control" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
        <button type="submit" id="simpan-cash-balance" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
      </div>
      </form>
    </div>
  </div>
</div>