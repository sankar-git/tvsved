<?php 
  $session_data = $this->session->userdata('sms');
  $data= menuAccess($session_data[0]->id,$session_data[0]->role_id);
  //print_r($data);

$this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>
<style >
.error{
 color:red;	
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $page_title;?>
      
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
	   <div class="box box-primary">
	   
            <div class="box-header with-border">
              <h3 class="box-title" style="color:green"><?php echo $this->session->flashdata('message'); ?></h3>   
            </div>
              
           <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="updateStudentMarks" id="updateStudentMarks" method="post" action="<?php echo base_url();?>marksupdate/saveStudentMarks/<?php echo $user_marks_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="campus_code"><i class="fa fa-user-circle-o"></i> Campus Code<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="campus_code" name="campus_code" value="<?php echo $user_marks_row->campus_code;?>" readonly>
					  <span class="errorMsg"></span>
					</div>
					<div class="form-group col-md-3">
					  <label for="program_name"><i class="fa fa-lock"></i>Program Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="program_name" name="program_name" value="<?php echo $user_marks_row->program_name;?>" readonly>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="degree_name"><i class="fa fa-user-circle-o"></i>Degree Name<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="degree_name" name="degree_name" value="<?php echo $user_marks_row->degree_name;?>" readonly>
					</div>
					<div class="form-group col-md-3">
						  <label for="course_name">Course Name</label>
						  <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo $user_marks_row->course_title;?>" readonly>
						  
				    </div>
               </div>
			   
			   
			           <div class="row">
					  <div class="form-group col-md-3">
					  <label for="degree_name"><i class="fa fa-user-circle-o"></i>Student Id<span style="color:red;font-weight: bold;">*</span></label>
					  <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo $user_marks_row->user_unique_id;?>" readonly>
					</div>
					<div class="form-group col-md-3">
						  <label for="course_name">Student Name</label>
						  <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo $user_marks_row->first_name;?>" readonly>
						  
				    </div>
					
					
				     </div>
					 <div class="row">
					 	<div class="form-group col-md-3">
						  <label for="address_line2">Internal Theory</label>
						  <input type="text" class="form-control" id="internal_theory" name="internal_theory" value="<?php echo $user_marks_row->theory_internal;?>">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line3">Internal Practical</label>
						  <input type="text" class="form-control" id="internal_practical" name="internal_practical" value="<?php echo $user_marks_row->practical_internal;?>">
						</div>
					 	<div class="form-group col-md-3">
						  <label for="address_line4">External Theory</label>
						  <input type="text" class="form-control" id="external_theory" name="external_theory" value="<?php echo $user_marks_row->theory_external;?>">
						</div>
						<div class="form-group col-md-3">
						  <label for="address_line1">External Practical</label>
						  <input type="text" class="form-control" id="external_practical" name="external_practical" value="<?php echo $user_marks_row->practical_external;?>">
						  
						</div>
						
					</div>
			 </div>
			     
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
	
	$(document).ready(function() {
		$("#dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	$(document).ready(function() {
		$("#date_of_joining").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	 $("#addcampus").validate({
		rules: {
			campus_code: "required",
			campus_name: "required",
			campus_short_name: "required",
			login_id:"required",
			password: "required",
                confirm_password: {
                    equalTo: "#password"
                },
			dean_name:"required",	
			dean_phone_number:"required",	
			dean_email:"required",	
				
			},
		messages: {
			campus_code: "Campus Code  Is Required",
			campus_name:"Campus Name Is Required",
			campus_short_name: "Campus Short Name  Is Required",
			login_id:"Login Id Is Required",
			 password: " Password Is Required",
			 messages: {
                password: " Enter Password",
                confirmpassword: "Confirm Password Same as Password"
            },
			dean_name: "Dean Name  Is Required",
			dean_phone_number: "Dean Phone Number Is Required",
			dean_email: "Dean Email  Is Required"
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 