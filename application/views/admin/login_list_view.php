<?php
//print_r($syllabus_list); exit;

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
       <?=$page_title;?>
      </h1>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
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
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>S.No</th>
									<th>User Name</th>
									<th>Type</th>
									<th>Role</th>
									<th>IP</th>
									<th>Client Details</th>
									<th>Date Time</th>
									
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0; foreach ($payments as $payment): $i++;?>
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php if(!empty($payment->first_name)) echo $payment->first_name;elseif(!empty($payment->username)) echo $payment->username; ?></td>
									<td><?php echo ucfirst($payment->log_type);?></td>
									<td><?php if($payment->role_name == 0) echo "Admin"; else echo $payment->role_name;?></td>
									<td><?php echo $payment->ipaddress;?></td>
									<td><?php echo $payment->full_user_agent_string;?></td>
									<td nowrap><?php echo $payment->created_on;?></td>
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
	
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	function areyousure(){
		return confirm('Are you sure you want to delete?');
	}

 </script>	
   <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 