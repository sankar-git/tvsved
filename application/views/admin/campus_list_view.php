<?php $this->load->view('admin/helper/header');?>
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
        <?=$page_title;?>
      
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> <?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
       
	   <div class="box box-primary">
	       
           <div class="box-footer" >
               <p style="color:green" align="center"> <?php echo $this->session->flashdata('message'); ?></p>
			     <!-- <div style="float:left;">
				  <form method="post" action="<?php echo base_url();?>campus/downloadCampus">
                                  <input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Download Excel" name="campusExcel">
                  </form>
				</div>-->
				 <div style="float:right;">
				  <a class="btn btn-primary " href="<?php echo site_url('campus/addCampus'); ?>"><i class="fa fa-plus"></i> Add Campus</a>
				</div>
          </div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table dataTable no-footer" cellspacing="0">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Campus Code</th>
									<th>Campus Name</th>
									<th>Campus Short Name</th>
									<th>Email</th>
									<th>Landline No.</th>
									<th>Dean Name</th>
									<th>Dean Mobile Number</th>
									<th>Dean Email</th>
									
									<th width="100px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($campus_list as $campuses): $i++;?>
									<tr>
									
									<td><?php echo $i; ?></td>
									<td><?php echo $campuses->campus_code;?></td>
									<td><?php echo $campuses->campus_name;?></td>
									<td><?php echo $campuses->campus_short_name;?></td>
									<td><?php echo $campuses->email;?></td>
									<td><?php echo $campuses->landline_number;?></td>
									<td><?php echo $campuses->dean_name;?></td>
									<td><?php echo $campuses->dean_phone_number;?></td>
									<td><?php echo $campuses->dean_email;?></td>
									<?php $title = 'Activate';
									if($campuses->status==0){
										$btnClass = 'btn-warning';
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-success';
									}?>
								
									<td>
										<div class="btn-group" style="width:180px;">
											<a class="btn btn-sm btn-info" href="<?php echo site_url('campus/editCampus/'.$campuses->id);?>" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
						
											<!-- <a class="btn btn-sm btn-danger" href="<?php echo site_url('campus/deleteCampus/'.$campuses->id);?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>-->

											 <a class="btn btn-sm btn-primary" href="<?php echo site_url('campus/detailCampus/'.$campuses->id);?>" title="View Detail" data-toggle="tooltip"><i class="fa fa-eye"></i></a>
											 
											 <a class="btn btn-sm <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>campus/campusStatus/<?php echo $campuses->id.'/'.$campuses->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($campuses->status=='1') { ?> Active<?php }else { ?> Inactive<?php } ?></a>
										</div>
									</td>
									</tr>
									<?php endforeach;?>
							</tbody>
						</table>
	
	
					</div>
           	
			
       
          </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
	function areyousure(){
		return confirm('Are you sure you want to delete?');
	}
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	
    $(document).ready(function () {
		$('#example').DataTable();
	});
   $("#userform").validate({
		rules: {
			username: "required",
			password: "required",
			first_name: "required",
			last_name:"required",
			state_id:"required",
			pincode: {
				required:true,
				digits: true,
				minlength:6,
				maxlength:6
			},
			contact_number: {
				required:true,
				digits: true,
				minlength:10,
				maxlength:10
			},
			mobile_number: {
				required:true,
				digits: true,
				minlength:10,
				maxlength:10
			},
			email:{
				required:true,
				email:true
			},
			
			
			dob:"required",
			sales_email:{
				required:true,
				email:true
			},
			address_name: 'required',
		
			imei_number: {
				required:true,
				digits: true,
				minlength:15,
				maxlength:15
			},
			//driver_image: 'required',
			
			member_address: 'required'
			
		},
		messages: {
			username: "User Name  Is Required",
			password:"Password Is Required",
			first_name: "First Name  Is Required",
			last_name:"Last Name Is Required",
			state_id:"Select your state",
			//user_image  	 : "Select an image to upload",
			
				pincode:{ 
					required: "Pincode Number is required",
					minlength: "Enter valid 6 digit Phone Number",
					maxlength: "Enter valid 6 digit Phone Number",
					digits : "Pincode Number Accept only Numbers"
			},
			contact_number:{ 
					required: "Contact Number is required",
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Contact Number Accept only Numbers"
			},
			mobile_number:{ 
					required: "Mobile Number is required",
					minlength: "Enter valid 10 digit Phone Number",
					maxlength: "Enter valid 10 digit Phone Number",
					digits : "Mobile Number Accept only Numbers"
			},
		email:{
				required:"Please enter  email.",
				email:"Please enter valid  email."
			},
			
			dob: "DOB Is Required",
			sales_email:{
				required:"Please enter sales email.",
				email:"Please enter valid sales email."
			},
		 address_name   : "Address is required",
			imei_number:{ 
					required: "IMEI Number is required",
					minlength: "Enter valid 15 digit IMEI Number",
					maxlength: "Enter valid 15 digit IMEI Number",
					digits : "IMEI Number Accept only Numbers"
			},
		   // driver_image  	 : "Select an image to upload",
			member_address   : "Address is required"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 