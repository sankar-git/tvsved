<html>
<head>
  <!-- Favicon -->
<link rel="icon" href="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" type="image/gif" sizes="16x16">
<script  src="https://code.jquery.com/jquery-3.3.1.min.js"  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
.form-gap {
    padding-top: 70px;
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
                  <a href="<?php echo base_url();?>"><img class="media-object img-circle" height="100" width="100" src="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" alt=""></a>
				  </div>
                  <h2 class="text-center">Forgot Password?</h2>
<p><span><a href="<?php echo base_url();?>authenticate/forgotPassword" class="btn  btn-success tab_id" >Mobile</a></span>&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="<?php echo base_url();?>authenticate/forgotPasswordByEmail" class="btn  btn-primary tab_id"  >Email</a></span></p>
                  <div class="panel-body">
                       <div>  <p class="login-box-msg"> 
                        <span class="alert-danger"><?php echo $this->session->flashdata('wrongmsg'); ?></span>
                        <span class="alert-success"><?php echo $this->session->flashdata('successmsg'); ?></span>
						</p></div>
					
                    <form id="register-form" role="form" autocomplete="off" class="form" method="post"  action="<?php if($err_flag!=1){ echo base_url().'authenticate/sendotpbyusernme';} else { echo base_url().'authenticate/sendPassword'; }?>">
					<?php if($err_flag !=1){ ?>
                      <div class="form-group">
                        <div class="input-group  " >
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                          <input  name="username" id="username" placeholder="Username" class="form-control"  type="text" >
                        </div>
                      </div>
					  <?php }?>
					  <?php if($err_flag==1){ ?>
					    <div class="form-group ">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon fa fa-key color-blue"></i></span>
                          <input type="number" id="otp_number" name="otp_number" placeholder="Enter OTP" class="form-control"  >
                          <input type="hidden" id="username" name="username" value="<?php echo $this->session->userdata('username');?>" class="form-control"  >
                        </div>
                      </div>
					  <?php }?>
                      <div class="form-group">
                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit"><br/>
						<a href="<?php echo base_url();?>" class="errormsg"><< Back to Login</a>
                      </div>
                      
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
function changeDiv(id)
{
	//alert(id); return false;
	//var mobile =$('.tab_id').val();
	//alert()
	if(id=='1')
	{
	$('#mobile').show();	
	$('#email').hide();	
	}
		if(id=='2')
	{
	$('#email').show();	
	$('#mobile').hide();	
	}
}
function sendOTPUsernname()
{
	var mobile =$('#username').val();
	//alert(mobile); return false;
	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>authenticate/sendotpbyusernme',
			data: {'username':username},
			success: function(data){
				console.log(data);
				//<?php echo base_url();?>authenticate/sendPassword
		
			 }
		});
		return false;
}
</script>