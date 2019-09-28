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
									<th>User ID</th>
									<th>User Name</th>
									<th>Type</th>
									<th>Program</th>
									<th>Semester</th>
									<th>Bank Transaction Id</th>
									<th>Amount</th>
									<th>Transaction Status</th>
									<th>Transaction Date</th>
									
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0; foreach ($payments as $payment): $i++;?>
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $payment->user_unique_id;?></td>
									<td><?php echo $payment->first_name.' '.$payment->last_name;?></td>
									
									<td><?php echo $payment->payment_type;?></td>
									<td><?php echo $payment->program_name;?></td>
									<td><?php if(!empty($payment->semester_name)) echo $payment->semester_name;elseif(!empty($payment->semester_id)) echo $payment->semester_id;?></td>
									<td><?php echo $payment->mer_txn;?></td>
									<td><?php echo $payment->amt;?></td>
									<td><?php echo $payment->desc;?></td>
									<td><?php echo $payment->date;?></td>
									
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
  
  
 