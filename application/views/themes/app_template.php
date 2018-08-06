<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php echo $data['title'] ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/ionicons/css/ionicons.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/validation/css/formValidation.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/animate.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/bootstrap-checkbox/awesome-bootstrap-checkbox.min.css"); ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/favicon.png"); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url("assets/favicon.png"); ?>" type="image/x-icon">
    <style type="text/css">
    .img-logo { width:50px; height:50px; margin-top:10px; }
    .app-info { color:white; margin-left:60px; }
    .app-info > .store-name { font-size: 28px; font-weight:bold; padding:5px 0px 0px 0px; }
    .app-info > .store-street { font-size:14px; margin-top:-7px; }
    .navbar-nav { font-size: 20px; }
    .switch { padding-right: 20px; }
    .input-group-addon { background-color: #3C8DBC !important; color: white; border-color: #3C8DBC !important }
    .input-group-addon:hover {  color: white !important }
      @font-face {
          font-family: 'zillap-nitro'; /*a name to be used later*/
          src: url('<?php echo base_url("assets/dist/css/zillap-nitro.ttf") ?>'); /*URL to font*/
      }
      .zillap-nitro {
        font-family: zillap-nitro, sans-serif;
      }
    </style>
    <!-- </head> -->
  </head>
  <body class="skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">
      <header class="main-header">
        <nav class="navbar navbar-static-top" role="navigation">
          <div class="col-md-5">
            <img src="<?php echo base_url('assets/logo.png'); ?>" class="img-logo pull-left">
            <div class="app-info">
              <div class="store-name zillap-nitro">EPOS</div>
              <div class="store-street"><i>Sistem Kasir Kedai Argyta</i></div>
            </div>
          </div>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li><a href="#" data-toggle="modal" data-target="#modal-logoff"><i class="fa fa-sign-out"></i></a></li>
            </ul>
          </div>
        </nav>
      </header>
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header zillap-nitro">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo site_url() ?>">
                <i class="fa fa-home"></i> <span>Utama</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url('transaksi') ?>">
                <i class="fa fa-shopping-cart"></i> <span>Transaksi</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-database"></i>
                <span>Master Data</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo site_url('product') ?>"><i class="fa fa-circle-o"></i> Data Produk</a></li>
                <li><a href="<?php echo site_url('category') ?>"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
              </ul>
            </li>
            <li>
              <a href="<?php echo site_url('data_transaksi') ?>">
                <i class="fa fa-line-chart"></i> <span>Data Transaksi</span>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url('data_transaksi/report') ?>">
                <i class="fa fa-file-text-o"></i> <span>Buat Laporan</span>
              </a>
            </li>
            <?php if($this->ion_auth->in_group(array(1))) : ?>
            <li>
              <a href="<?php echo site_url('users') ?>">
                <i class="fa fa-users"></i> <span>Data Pengguna</span>
              </a>
            </li>
          <?php endif; ?>
            <li>
              <a href="<?php echo site_url('users/account') ?>">
                <i class="fa fa-wrench"></i> <span>Pengaturan Akun</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Breadcrum area -->
        <section class="content">
          <?php $this->load->view($view, $data); ?>
          <div class="modal" id="modal-logoff" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm modal-danger">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h5 class="modal-title"><i class="fa fa-warning"></i> Yakin keluar aplikasi?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline" data-dismiss="modal">Tidak</button>
                  <a href="<?php echo site_url('auth/logout') ?>" class="btn btn-outline"> Iya</a>
                </div>
              </div>
            </div>
          </div>


          <div class="modal" id="modal-delete">
            <div class="modal-dialog modal-sm modal-danger">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-info-circle"></i> Hapus!</h4>
                  <span>Hapus data ini dari database?</span>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
                  <a href="#" id="btn-delete" class="btn btn-outline">Hapus</a>
                </div>
              </div>
            </div>
          </div>


        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer no-print">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0 (Beta)
        </div><small> &copy; Kedai Argyta</small>
      </footer>
    </div><!-- ./wrapper -->
    <script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/fastclick/fastclick.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/validation/js/formValidation.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/validation/js/framework/bootstrap.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/notif/notify.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/daterangepicker/moment.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
    <script src="<?php echo base_url('assets/dist/js/jquery.tableCheckbox.js') ?>"></script>
    <script src="<?php echo base_url("assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/mask-money/jquery.maskMoney.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/dist/js/jquery.printPage.js"); ?>"></script>
    <script src="<?php echo base_url("assets/dist/js/app.js"); ?>"></script>
    <script type="text/javascript">var base_domain = '<?php echo site_url(); ?>';</script>
    <?php 
    /**
    * Load js from loader core
    *
    * @return CI_OUTPUT
    **/
   if($this->load->get_js_files() != FALSE) : 
      foreach($this->load->get_js_files() as $file) :  
    ?>
         <script src="<?php echo $file; ?>?v=<?php echo md5(date('YmdHis')); ?>"></script>
   <?php 
      endforeach; 
    endif; 
    ?>
    <!--  </body></html> -->
  </body>
</html>
