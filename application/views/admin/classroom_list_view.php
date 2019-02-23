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
			     <div style="float:left;">
				
				</div>
				 <div style="float:right;">
				  <a class="btn btn-primary " href="<?php echo site_url('master/addClassRoom'); ?>"><i class="fa fa-plus"></i> &nbsp;&nbsp;&nbsp;Add Class Room</a>
				</div>
              </div>
            <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>S.No</th>
									<th>Room Name</th>
									<th>Campus Name</th>
									
									<th width="100px">Action</th>
									
								</tr>
							</thead>
									<tbody>
								
									<?php $i=0;foreach ($room_list as $room): $i++;?>
									<tr>
									<td><?php echo $i; ?></td>
									
									<td><?php echo $room->room_name;?></td>
									<td><?php echo $room->campus_name;?></td>
									<?php $title = 'Activate';
									if($room->status==1){
										$btnClass = 'btn-success';
										
										$title = 'De-activate';
									}else {
										$btnClass = 'btn-warning';
									}?>
								
									<td>
										<div class="btn-group" style="width:180px;">
											<a class="btn btn-sm btn-info" style="margin-right: 6px" href="<?php echo site_url('master/editclassroom/'.$room->id);?>" title="Edit" data-toggle="tooltip"><!-- <i class="fa fa-pencil"></i> -->Edit</a>
						
											 <a class="btn btn-sm btn-danger" href="<?php echo site_url('master/deleteClassRoom/'.$room->id);?>" onclick="return areyousure();" title="Delete" data-toggle="tooltip"><i class="fa fa-trash-o"></i> </a>                                             <a class="btn btn-sm <?php echo $btnClass; ?>" href="<?php echo base_url(); ?>master/degreeStatus/<?php echo $room->id.'/'.$room->status; ?>" title="<?php echo $title; ?>" data-toggle="tooltip"><i class="fa fa-undo"></i><?php if($room->status=='1') { ?> Active<?php }else { ?> Inactive<?php } ?></a>
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
  
  
 