<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ?> | Kedai Argyta</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/style-login.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/square/blue.css') ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo text-center">
    <img src="<?php echo base_url('assets/full-logo.png'); ?>" class="text-center">
  </div>
  <div class="login-box-body">
    <?php echo form_open("auth/login");?>
      <div class="form-group">
        <?php if($message) : ?>
          <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $message ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="form-group has-feedback">
        <label>E-Mail :</label>
        <input type="text" class="form-control" name="identity" value="<?php echo set_value('identity') ?>" placeholder="E-Mail">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label>Password :</label>
        <input type="password" class="form-control" name="password" value="<?php echo set_value('password') ?>" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
             <?php echo form_checkbox('remember', '1', TRUE, 'id="remember"'); ?> Tetap login
            </label>
          </div>
        </div>
        <div class="col-xs-6">
          <!-- <a href="forgot_password" class="pull-right">Lupa password?</a> -->
        </div>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </div>
      </div>
    <?php echo form_close();?>
  </div>
</div>
<footer>
    <p class="text-center"><small>&copy; Hak Cipta 2018 <br><i class="fa fa-home"></i> Jl. Horman Maddati No. 66, Rangkui - Pangkalpinang</small></p>
</footer>
<script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
    });
  });
</script>
</body>
</html>
