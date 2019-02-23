<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="font-family:arial,sans-serif; font-size:13px; color:#222">
<div class="mail_template_wrapper" style=" width: 100%">
  <div><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/admin/dist/img/logo.jpg" alt=""></a></div>
  <?php
  //print_r($admin_details_by_email_array); 
 
?>
  <div>
    <p>Dear,User</p>
    <p>Welcome to <a href="#" style=" color:#70ad47;">TANUVAS<span style="color:#00b0f0;"></span> </a></p>
    <p>You have forgotten your password. No worries!</p>
    
    <p>Your OTP:<?php echo $otp;?></p>
    <p>Thanks and take care!</p>
  
    <p style="border-top: #00b0f0 1px dotted; border-bottom: #00b0f0 1px dotted; padding:10px 0; display:inline-block">Please note: This is an auto generated email. Do not reply</p>
  </div>

  <div class="clear"></div>
</div>
</body>
</html>
