<?php //p($userRequests); exit;?>
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
			   
				
          </div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table dataTable no-footer" cellspacing="0">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Name</th>
									
									<th>Email</th>
									<th>User Type</th>
									<th>Contact Number</th>
									<th>Request Date</th>
									<!--<th>Show Request</th>-->
									<th width="100px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($userRequests as $users): $i++;?>
									<tr>
									
									<td><?php echo $i; ?></td>
									
									<td><?php echo ucfirst($users->first_name).' '.ucfirst($users->last_name);?></td>
									
								
									<td><?php echo $users->email;?></td>
									<?php 
									if($users->roll=='1'){$usertype='Student';}
									if($users->roll=='0'){$usertype='Super Admin';}
									if($users->roll=='2'){$usertype='Teacher';}
									if($users->roll=='5'){$usertype='Parent';}
									if($users->roll=='4'){$usertype='Subadmin/Dean';}
									if($users->roll=='3'){$usertype='User';}
										
									?>
									<td><?php echo $usertype;?></td>
									<td><?php echo $users->contact_number;?></td>
									<td><?php echo date('d-m-Y',strtotime($users->created_on));?></td>
									<!--<td><a class="btn btn-sm " href="<?php echo base_url(); ?>profile/showUpdateRequest/<?php echo $users->id; ?>"  data-toggle="tooltip">View Request</a></td>-->
									
								
								 
										
									<?php $title = 'Approved';
									if($users->status==0){
										$btnClass = 'btn-warning';
										$title = 'Pending Update';
									}else {
										$btnClass = 'btn-success';
									}?>
								
									<td>
										<div class="btn-group" style="width:180px;">
										 <a class="btn btn-sm <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>profile/approveUser/<?php echo $users->id; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($users->status=='1') { ?> Approved<?php }else { ?> Pending Update<?php } ?></a>
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
  
  
 