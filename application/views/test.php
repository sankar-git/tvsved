open_pay_modal(<?php echo $user->id;?>,<?php echo $payable ;?>,<?php echo $user->role_id;?>,<?php echo $due_rs; ?>)

function open_pay_modal(user_id,monthly,role_id,due_rs){

$("#myPayModal").modal('show');
	$("#user_id").val(user_id);
	$("#role_id").val(role_id);
	
		$("#monthly").val(monthly);
		$("#concession").val(0);
		$("#amount").val(0);
		$("#due_amount").val(due_rs);
	 
	var classid=$("#class").val();
	$("#class_id").val(classid);
	
	if(role_id==3)
	{
		$("#concession_control").hide();
		
	}
}
    
    <?php $data=array(
			   			'user_id'=>$user->id,
						'payable'=>$payable,
						'role_id'=>$user->role_id,
						'due_rs'=>$due_rs
			   		);
			   
			   ?>