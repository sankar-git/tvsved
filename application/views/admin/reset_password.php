<html>
<head>
  <!-- Favicon -->
<link rel="icon" href="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" type="image/gif" sizes="16x16">
<script  src="https://code.jquery.com/jquery-3.3.1.min.js"  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
   <script src="<?php echo base_url();?>assets/admin/bower_components/jquery/dist/jquery.validate.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
.form-gap {
    padding-top: 70px;
}
.error{
	color:red;
}
</style>

<script type="text/javascript">
    /*$(document).ready(function() {
        $("body").gradientify({
            gradients: [
                { start: [49,76,172], stop: [242,159,191] },
                { start: [255,103,69], stop: [240,154,241] },
                { start: [33,229,241], stop: [235,236,117] }
            ]
        });
    });*/
</script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
 </head>
 <body>
 <div class="form-gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
			   
                <div class="text-center">
				 <div class="thumb">
                  <img class="media-object img-circle" height="100" width="100" src="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" alt="">
				  </div>
                  <h2 class="text-center">Reset Password</h2>

                  <div class="panel-body">
                       <div>  <p class="login-box-msg"> 
                        <span class="alert-danger"><?php echo $this->session->flashdata('wrongmsg'); ?></span>
                        <span class="alert-success"><?php echo $this->session->flashdata('successmsg'); ?></span>
						</p></div>
					
                    <form id="register-form" name="register-form" role="form" autocomplete="off" class="form" method="post"  action="<?php echo base_url().'authenticate/resetPassword'; ?>">
					
                      <div class="form-group">
                        <div class="input-group  " >
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                          <input  name="newpassword" id="newpassword" placeholder="New Password" class="form-control"  type="password" >
                        </div>
                      </div>
					  <label for="newpassword" generated="true" class="error">&nbsp;</label>
					  <div class="form-group">
                        <div class="input-group  " >
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                          <input  name="confirmpassword" id="confirmpassword" placeholder="Re-enter Password" class="form-control"  type="password" >
                        </div>
                      </div>
					  <label for="confirmpassword" generated="true" class="error">&nbsp;</label>
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Set Password" type="submit">
                      </div>
                      
                      <input type="hidden" class="hide" name="username" id="username" value="<?php echo $username;?>"> 
                      <input type="hidden" class="hide" name="token" id="token" value=""> 
                    </form>
                  
					
                 
                </div>
              </div>
            </div>
          </div>
	</div>
</div>
</body>
</html>

<script>
$("#register-form").validate({
		rules: {
			newpassword: {
				required: true,
				minlength: 5
			},
			confirmpassword: {
				required: true,
				minlength: 5,
				equalTo: "#newpassword"
			}
		},
		messages: {
			newpassword: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirmpassword: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			}
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
</script>