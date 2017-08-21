 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Smart Login</title>

    <!-- Bootstrap -->
	
    <link href="<?php echo base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">
		
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	
    <!-- NProgress -->
    <link href="<?php echo base_url();?>/assets/css/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
     <link href="<?php echo base_url();?>/assets/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>/assets/css/custom.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" class="form-login" id="login_form" action="<?php echo base_url();?>smart_controller/login_process">
              <h1>Login Form</h1>
              <?php if($this->session->flashdata('err')) { ?>
              		<div class="alert alert-danger alert-dismissible form-label fade in" role="alert">
                                     
                    <h6><?php echo $this->session->flashdata('err');?></h6> 
                  </div>
             <?php }?>
              <div>
                <input type="text" class="form-control" placeholder="Username"  name="username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password"  required="" />
              </div>
              <div>
             
                <button class="btn btn-default submit">Log In</a>
                
                
              </div>
<a class="reset_pass" href="#">Lost your password?</a>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-user"></i> Smart Foundry</h1>
                  <p>©2017 All Rights Reserved.SMART FOUNDRY 2020</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-user"></i> Smart Foundry</h1>
                  <p>©2017 All Rights Reserved.SMART FOUNDRY 2020</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
	
	<!-- jQuery -->
	<script src="<?php echo base_url();?>/assets/js/jquery.min.js"></script>
	
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>/assets/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>/assets/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>/assets/js/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url();?>/assets/js/Chart.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url();?>/assets/js/gauge.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url();?>/assets/js/bootstrap-progressbar.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>/assets/js/icheck.js"></script>
	<script src="<?php echo base_url();?>/assets/payloads/jquery.flot.js"></script>
	<script src="<?php echo base_url();?>/assets/payloads/jquery.flot.resize.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="<?php echo base_url();?>/assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url();?>/assets/js/jquery.hotkeys.js"></script>
    <script src="<?php echo base_url();?>/assets/js/prettify.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url();?>/assets/js/date.js"></script>
 
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url();?>/assets/js/moment.js"></script>
    <script src="<?php echo base_url();?>/assets/js/daterangepicker.js"></script>
	<!-- jQuery Tags Input -->
    <script src="<?php echo base_url();?>/assets/js/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="<?php echo base_url();?>/assets/js/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url();?>/assets/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="<?php echo base_url();?>/assets/js/parsley.js"></script>
    <!-- Autosize -->
    <script src="<?php echo base_url();?>/assets/js/autosize.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url();?>/assets/js/jquery.autocomplete.js"></script>
    <!-- starrr -->
    <script src="<?php echo base_url();?>/assets/js/starrr.js"></script>
	<!-- PNotify -->
    <script src="<?php echo base_url();?>/assets/js/pnotify.js"></script>
    <script src="<?php echo base_url();?>/assets/js/pnotify.buttons.js"></script>
    <script src="<?php echo base_url();?>/assets/js/pnotify.nonblock.js"></script>
	
    <!-- Custom Theme Scripts -->
	<!-- Custom script -->
	
	<script src="<?php echo base_url();?>/assets/js/effect.js"></script>
    <script src="<?php echo base_url();?>/assets/js/custom.js"></script>
  </body>
</html>
