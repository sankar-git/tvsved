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
           <div class="box-body">
		    <div class="col-lg-12" align="center">
                        <div class='flashmsg'>
                          
                        </div>
            </div>
			    <div class="row">
				<form  id="userImages" name="userImages" method="post" enctype="multipart/form-data" >
					<!--<div class="form-group col-md-4" style="text-align:left; padding-left:40px; padding-top:25px;">
					    <label for="campus">Upload User Images<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="file"  name="userfile[]" id="userfile" multiple class="btn btn-primary">
						   <input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Upload" name="submit">
					</div>-->
					<div class="form-group col-md-3">
					    
						  <label for="campus">Upload User Images<span style="color:red;font-weight: bold;">*</span></label>
						  <input type="file"  name="userfile[]" id="userfile" multiple class="btn btn-primary"> 
					</div>
					<div class="form-group col-md-3" style="text-align:left; padding-left:40px; padding-top:25px;">
					  <input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Upload" name="submit">
					</div>
					
				</form>
			 </div>
			
			 
			 
			 </div>
             
			
              <!-- /.box-body -->
		
          </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 