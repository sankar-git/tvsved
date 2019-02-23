
<!DOCTYPE html>
<html>

<!-- Mirrored from thememakker.com/templates/admincc/locked.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 05 Dec 2017 20:03:19 GMT -->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Tamil Nadu Veterinary and Animal Sciences University</title>
<!-- Favicon-->
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Custom Css -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link href="<?php echo base_url()?>assets_login/css/main.css" rel="stylesheet">
<link href="<?php echo base_url()?>assets_login/css/login.css" rel="stylesheet">

<!-- AdminCC You can choose a theme from css/themes instead of get all themes -->
<link href="<?php echo base_url()?>assets_login/css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-cyan">
<div class="authentication">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-8 col-md-5 col-xs-12">
                <div class="l-detail">
                            <h5>Welcome</h5>
							
                            <h1>Student Management System</h1>
							<div class="row">                    
                            <div class="col-xs-12">
                                <a href="<?php echo base_url();?>authenticate/studentLogin" class="btn btn-raised waves-effect bg-white" name="go" type="submit">Student Login</a>
								<a href="<?php echo base_url();?>authenticate/studentAluminiLogin" class="btn btn-raised waves-effect bg-white" name="go" type="submit">Alumini Student Login</a>
								<a href="<?php echo base_url();?>authenticate/deanLogin" class="btn btn-raised waves-effect bg-white" name="go" type="submit">Dean Login</a>
								<a href="<?php echo base_url();?>authenticate/parentLogin" class="btn btn-raised waves-effect bg-white" name="go" type="submit">Parents Login</a>
								<a href="<?php echo base_url();?>authenticate/teacherLogin"
								class="btn btn-raised waves-effect bg-white" name="go" type="submit">Teacher Login</a>
								<a href="<?php echo base_url();?>authenticate/juniorAdmin" class="btn btn-raised waves-effect bg-white" name="go" type="submit">Junior Admin Login</a>
                            </div>
                           
                        </div>
                            <h3>Tamil Nadu Veterinary and Animal Sciences University</h3>
                            <p>Madhavaram Milk Colony Road, Chennai, Tamil Nadu 600051</p>                            
                           <!-- <ul class="list-unstyled l-social">
                                <li><a href="#"><i class="zmdi zmdi-facebook-box"></i></a></li>                                
                                <li><a href="#"><i class="zmdi zmdi-linkedin-box"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-pinterest-box"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-youtube-play"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-google-plus-box"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-behance"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-dribbble"></i></a></li>
                                <li><a href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                            </ul> -->
                        </div>
						 
			</div>
			<div class="col-lg-4 col-md-7 col-xs-12">
				<div class="card locked">
				    <h4 class="l-login m-b-20">Student Management System</h4>
                    <div class="col-md-12">
                      <div class="thumb">
                        <img class="media-object img-circle" src="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" alt="">
                      </div>
                      <h4 class="media-heading">TANUVAS<strong><?php echo $page_title;?></strong></h4>
                    </div>
					
                    <form class="col-md-12" id="authenticate" name="authenticate" method="post" action="<?php echo base_url();?>authenticate/student_login" autocomplete="false" onsubmit="return checkValidation();">
					    <div>  <p class="login-box-msg"><?php echo validation_errors(); ?> 
                        <?php echo $this->session->flashdata('logoutmsg'); ?></p></div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="username" name="username" id="username" autocomplete="false" class="form-control">
                                <label class="form-label">Email</label>
								<span id="userMsg"></span>
                            </div>
                        </div>
							<div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" name="password" id="password" autocomplete="false" class="form-control">
                                <label class="form-label">Password</label>
								<span id="passMsg"></span>
                            </div>
                        </div>
                        <div>  <p class="login-box-msg"><?php echo validation_errors(); ?> 
                        <?php echo $this->session->flashdata('message'); ?></p></div>						
                        <div class="row">                    
                            <div class="col-xs-12">
                                <button class="btn btn-raised waves-effect bg-red" name="go" type="submit">Login</button>
                            </div>
							
                            <div class="col-xs-12"> <a href="<?php echo base_url();?>authenticate/forgotPassword">Forgot Password!</a> </div>
                        </div>
                    </form>
				</div>
			</div>
			
		</div>
	</div>
</div>

<!-- Jquery Core Js --> 
<script src="<?php echo base_url()?>assets_login/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?php echo base_url()?>assets_login/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
<script src="<?php echo base_url()?>assets_login/plugins/css-gradientify/gradientify.min.js"></script><!-- Gradientify Js -->

<script src="<?php echo base_url()?>assets_login/bundles/mainscripts.bundle.js"></script><!-- Custom Js --> 

<script type="text/javascript">
    $(document).ready(function() {
        $("body").gradientify({
            gradients: [
                { start: [49,76,172], stop: [242,159,191] },
                { start: [255,103,69], stop: [240,154,241] },
                { start: [33,229,241], stop: [235,236,117] }
            ]
        });
    });
	  $("#authenticate").validate({
		rules: {
			username: "required",
			password: "required"
			
			},
		messages: {
			username: "Username is required",
			password:"Password is required"
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
</script>
</body>

<!-- Mirrored from thememakker.com/templates/admincc/locked.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 05 Dec 2017 20:03:19 GMT -->
</html>
