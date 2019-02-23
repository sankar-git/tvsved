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
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
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
			     <!--<div style="float:left;">
				  <form method="post" action="<?php echo base_url();?>master/downloadSyllabusYear">
                                  <input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Download Excel" name="syllabusYearExcel">
                  </form>
				</div>-->
				 <div style="float:right;">
				  <a class="btn btn-primary " href="<?php echo site_url('message/sendSms'); ?>"><i class=" fa fa-arrow"></i>Send Sms</a>
				</div>
          </div>
		  
		  
            <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>S.No</th>
									<th>User Name</th>
									<th>Message</th>
									<th>Mobile No</th>
									<th>Send By</th>
									<th>Send Date</th>
									<!--<th width="100px">Action</th>-->
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0; foreach ($sended_message as $messages): $i++;?>
									<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $messages->name;?></td>
									<td><?php echo $messages->message;?></td>
									<td><?php echo $messages->mobile;?></td>
									<td><?php echo $messages->sender_name;?></td>
									<td><?php echo $messages->created_on;?></td>
									
								
									<!--<td>
										<div class="btn-group" style="width:180px;">
											<a class="btn btn-sm btn-danger" href="<?php echo site_url('message/deleteMessage/'.$messages->id);?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>
                                       </div>
									</td>-->
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
  
  
 