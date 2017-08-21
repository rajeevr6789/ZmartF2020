<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Smart Dashboard! | </title>
	<!--Custom-->
	<link href="<?php echo base_url();?>/assets/css/small_box.css" rel="stylesheet">
    <!-- Bootstrap -->
	
    <link href="<?php echo base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">
		
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	
    <!-- NProgress -->
    <link href="<?php echo base_url();?>/assets/css/nprogress.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
    <link href="<?php echo base_url();?>/assets/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	
    <!-- iCheck -->
    <link href="<?php echo base_url();?>/assets/css/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url();?>/assets/css/bootstrap-progressbar-3.3.4.css" rel="stylesheet">
	
	<!-- Select2 -->
    <link href="<?php echo base_url();?>/assets/css/select2.min.css" rel="stylesheet">
    
	<!-- Switchery -->
    <link href="<?php echo base_url();?>/assets/css/switchery.min.css" rel="stylesheet">
    
	<!-- starrr -->
    <link href="<?php echo base_url();?>/assets/css/starrr.css" rel="stylesheet">
     
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>/assets/css/daterangepicker.css" rel="stylesheet">
	
	<!-- PNotify -->
    <link href="<?php echo base_url();?>/assets/css/pnotify.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/css/pnotify.buttons.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/assets/css/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>/assets/css/custom.css" rel="stylesheet">
	
	<!--CSS FOR TABLE-->
	<link href="<?php echo base_url();?>/assets/css/Custom_css.css" rel="stylesheet">
		<!-- jQuery -->
	<script src="<?php echo base_url();?>/assets/js/jquery.min.js"></script>
	<!-- Custom script -->
	<script language="javascript" type="text/javascript" src="<?php echo base_url();?>/assets/payloads/highcharts.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo base_url();?>/assets/payloads/exporting.js"></script>
	
	
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-user"></i> <span>Smart Dashboard!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo base_url();?>/assets/images/Logo.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>Smart User</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                
                <ul class="nav side-menu">
                  <!--<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>-->
				  <li><a href="<?php echo base_url();?>smart_controller/smart_home"><i class="fa fa-home"></i> Home </span></a></li>
                    <!--<ul class="nav child_menu">
                      <li><a href="index.php">Dashboard</a></li>
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul>
					
                  </li>
				  -->
                  <li><a><i class="fa fa-edit"></i> View/Edit Values <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="form.php">Proc. Design and Simulation</a></li>
                      <li><a href="form.php">3D Printing</a></li>
                      <li><a href="form.php">Moulding</a></li>
                      <li><a href="form.php">Melting</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-desktop"></i> Additional options1<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="general_elements.html">Sub Options1</a></li>
                      <li><a href="media_gallery.html">Sub Options2</a></li>
                      <li><a href="typography.html">Sub Options3</a></li>
                    </ul>
					<li><a><i class="fa fa-desktop"></i> Additional options2 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       <li><a href="general_elements.html">Sub Options1</a></li>
                      <li><a href="media_gallery.html">Sub Options2</a></li>
                      <li><a href="typography.html">Sub Options3</a></li>
                    </ul>
                  </li>
                 
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url();?>/assets/images/Logo.jpg" alt="">Smart User
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="<?php echo base_url();?>smart_controller/smart_logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url();?>/assets/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

		
		