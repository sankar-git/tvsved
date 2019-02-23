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
			     <div style="float:left;">
				 <form class="form-inline" name="user_form" id="user_form" method="post" action="<?php echo base_url();?>admin/downloadUserExcel">
				  <div class="form-group">
					<select name="user_type" id="user_type" class="form-control" >
					  <option value="">--Select Role--</option>
					  <?php foreach($roles as $role){?>
					  <option value="<?php echo $role->id;?>"><?php echo $role->role_name;?></option>
					 
					  <?php } ?>
					  </select>
				  </div>
				 <input type="submit" name="userExcel" id="userExcel" class="btn btn-primary" value="Excel"/>
				 <input type="submit" name="userPdf" id="userPdf" class="btn btn-primary" value="PDF"/>
				 <input type="submit" name="csvDownload" id="csvDownload" class="btn btn-primary" value="CSV"/>
				 
				</form>
				
				</div>
				 <div style="float:right;">
				  <a class="btn btn-primary " href="<?php echo site_url('admin/addUser'); ?>"><i class="fa fa-plus"></i> Add User</a>
				</div>
          </div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table dataTable no-footer" cellspacing="0">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Name</th>
									<th>Image</th>
									<th>Email</th>
									<th>User Type</th>
									<th>Contact Number</th>
									<th width="190px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($user_list as $users): $i++;?>
									<tr>
									
									<td><?php echo $i; ?></td>
									
									<td><?php echo ucfirst($users->first_name).' '.ucfirst($users->last_name);?></td>
									
									<td>
									<?php if($users->user_image){?>
									<img style="width:50px;height:50px;" src="<?php echo base_url('uploads/user_images/student/'.$users->user_image);?>" alt="current"/>
									<?php } else {?>
									<img style="width:50px;height:50px;" src="<?php echo base_url('uploads/user_images/student/');?>/no_image.jpg" alt="current"/>
									<?php }?>
									</td>
									<td><?php echo $users->email;?></td>
									<td><?php if($users->role_id=='1')
									          {
									              echo "Student";
											  }
											  if($users->role_id=='2')
									          {
									              echo "Teacher";
											  }
											  if($users->role_id=='3')
									          {
									              echo "User";
											  }
									
									?></td>
									<td><?php echo $users->contact_number;?></td>
									
								
								 
										
									<?php $title = 'Activate';
									if($users->status==0){
										$btnClass = 'btn-warning';
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-success';
									}?>
								
									<td>
										
										<div class="btn-group outer">
											<a class="btn btn-sm btn-info inner" href="<?php echo base_url(); ?>admin/editUser/<?php echo $users->id.'/'.$users->role_id; ?>" title="Edit" data-toggle="tooltip"><!-- <i class="fa fa-pencil"></i> -->Edit</a>
						
											<!-- <a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>admin/deleteUser/<?php echo $users->id.'/'.$users->role_id; ?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>-->

											 <a class="btn btn-sm btn-primary inner" href="<?php echo base_url(); ?>admin/userDetails/<?php echo $users->id.'/'.$users->status; ?>" title="View Detail" data-toggle="tooltip"><!-- <i class="fa fa-eye"></i> -->View Details</a>
											 
											 <a class="btn btn-sm  inner <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>admin/studentStatus/<?php echo $users->id.'/'.$users->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($users->status=='1') { ?> Active<?php }else { ?> Inactive<?php } ?></a>
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
   $("#user_form").validate({
		rules: {
			user_type: "required"
		},
		messages: {
			user_type: "Select UserType"
			},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 