<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- Temlate By : Admin LTE V.2 -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo (isset($title)) ? $title : DEFAULT_TITLE; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/validation/css/formValidation.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/animate.css') ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div id="login-box" class="login-box">
      <div class="login-logo">
        <a href="<?php echo site_url() ?>"><b>Toko</b> Charlie</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg animated">Login Aplikasi</p>
        <form action="" method="post" id="login_app">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Username .." name="username" autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password.." name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-danger btn-block">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/validation/js/formValidation.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/validation/js/framework/bootstrap.js') ?>"></script>
    <script type="text/javascript">var base_domain = '<?php echo site_url() ?>';</script>
    <script src="<?php echo base_url('assets/js_app/login_auth.js') ?>"></script>
    <!-- </body></html> -->
  </body>
</html>
