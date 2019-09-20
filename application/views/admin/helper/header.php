<?php $session_data=$this->session->userdata('sms');

//p($session_data); exit;?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | TANUVAS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<!-- Favicon -->
  <link rel="icon" href="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" type="image/gif" sizes="16x16">

   <script src="<?php echo base_url();?>assets/admin/bower_components/jquery/dist/jquery.validate.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!--nCSS-CSS------------------------------->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/nstyle.css">
  <!--nCSS-CSS End------------------------------->
  <!--Datatables Js-CSS------------------------------->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <!--Datatables Js-CSS  end------------------------------->
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url();?>admin/dashboard" class="logo">
	
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" height="50px;" width="50px;" style="border-radius: 50%" alt="User Image"></span>
      <!-- logo for regular state and mobile devices -->
	 
      <span class="logo-lg"><b> <img src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png" height="50px;" width="50px;"  style="border-radius: 50%" alt="User Image">&nbspTANUVAS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  <?php if(!empty($session_data[0]->user_image) && file_exists('uploads/user_images/parent/'.$session_data[0]->user_image)){?>
              <img src="<?php echo base_url();?>uploads/user_images/parent/<?php echo $session_data[0]->user_image;?>" style="margin-right: 6px !important" class="user-image" alt="User Image">
			   <?php } elseif(!empty($session_data[0]->user_image) && file_exists('uploads/user_images/student/'.$session_data[0]->user_image)){ ?>
              <img src="<?php echo base_url();?>uploads/user_images/student/<?php echo $session_data[0]->user_image;?>" style="margin-right: 6px !important" class="user-image" alt="User Image">
			   <?php } else{?>
			   <img src="<?php echo base_url();?>uploads/user_images/student/no_image.jpg" style="margin-right: 6px !important" class="user-image" alt="User Image">
			  <?php }?>
              <span class="hidden-xs" style="font-size: 17px"><?php echo ucfirst($session_data[0]->first_name);?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
			      <?php if(!empty($session_data[0]->user_image &&  file_exists('uploads/user_images/parent/'.$session_data[0]->user_image))){?>
              <img src="<?php echo base_url();?>uploads/user_images/parent/<?php echo $session_data[0]->user_image;?>" class="img-circle" alt="User Image">
			  <?php } elseif(!empty($session_data[0]->user_image) && file_exists('uploads/user_images/student/'.$session_data[0]->user_image)){ ?>
              <img src="<?php echo base_url();?>uploads/user_images/student/<?php echo $session_data[0]->user_image;?>" class="img-circle" alt="User Image">
			  <?php }  else{?>
			   <img src="<?php echo base_url();?>uploads/user_images/student/no_image.jpg" class="img-circle" alt="User Image">
			  <?php }?>
                

                <p>
                  <?php echo ucfirst($session_data[0]->first_name);?>
                 
                </p>
				 <p>Last Login: <?php  if(!empty($session_data[0]->last_login_time)){ echo $newDate = date("d-m-Y h:m:s A", strtotime($session_data[0]->last_login_time));}else echo '-';
//echo $session_data[0]->last_login_time;?></p>
              </li>
              <!-- Menu Body -->
             <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url();?>profile/userProfile" class="btn btn-default btn-flat">Profile</a>
                </div>
				
                <div class="pull-right">
                  <!-- <a href="<?php echo base_url('authenticate/logout');?>" onclick="a()" class="btn btn-default btn-flat">Sign out</a> -->
                  <a  onclick="aaa()" id="alertall" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>
 
  <script type="text/javascript">


    function aaa() {
var logout = confirm("Are you sure to logout?");

if(logout){
     location.href = "<?php echo base_url('authenticate/logout');?>";
}
    }
  </script>