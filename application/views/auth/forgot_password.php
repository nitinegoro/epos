<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lupa Password</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('public/components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/components/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/components/Ionicons/css/ionicons.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/dist/css/style-login.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/plugins/iCheck/square/blue.css') ?>">
  <link rel="icon" href="<?php echo base_url('public/images/favicon.ico') ?>" type="image/x-icon" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo base_url('public/images/mainlogo.png') ?>" alt="Logo E-BHABIN">
  </div>
  <div class="login-box-body">
    <?php echo form_open("auth/forgot_password");?>
      <div class="form-group">
        <?php if($message) : ?>
          <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $message ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="form-group has-feedback">
        <label><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label>
        <input type="text" class="form-control" name="identity" value="<?php echo set_value('identity') ?>" placeholder="E-Mail">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12" style="margin-bottom: 10px;">
          <a href="login" class="pull-right">kembali Login <i class="fa fa-arrow-right"></i></a>
        </div>
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block"><?php echo lang('forgot_password_submit_btn') ?></button>
        </div>
      </div>
    <?php echo form_close();?>
  </div>
</div>
<footer>
    <p class="text-center"><small>&copy; Hak Cipta 2017 <?php if(date('Y')!=2017) echo "- ".date('Y');  ?> Polda Kep. Bangka Belitung</small></p>
</footer>
<script src="<?php echo base_url('public/components/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('public/components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('public/plugins/iCheck/icheck.min.js') ?>"></script>
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
