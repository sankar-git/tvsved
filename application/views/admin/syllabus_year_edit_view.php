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
        <li class="active"><?=$page_title;?></li>
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
            <form role="form" name="syllabus_year_form" id="syllabus_year_form" method="post" action="<?php echo base_url();?>master/updateSyllabusYear/<?php echo $syllabus_year_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			   
			    <div class="row">
					<div class="form-group col-md-6">
					  <label for="discipline_code">Syllabus Year<span style="color:red;font-weight: bold;">*</span></label>
					    <select name="syllabus_id" id="syllabus_id" class="form-control">
						  <option value="">--Select Syllabus Year--</option>
						  <?php $firstYear = (int)date('Y') - 10;
							$lastYear = $firstYear + 20;
							for($i=$firstYear;$i<=$lastYear;$i++)
							{?>
								<option value="<?php echo $i?>" <?php if($i==$syllabus_year_row->syllabus_year){echo "selected";}?>><?php echo $i?></option>
							<?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-6">
					  <label for="discipline_name">Program Name<span style="color:red;font-weight: bold;">*</span></label>
					   <select name="program_id" id="program_id" class="form-control">
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						   <option value="<?php echo $program->id;?>" <?php if($program->id==$syllabus_year_row->program_id){echo "selected";}?>><?php echo $program->program_name;?></option>
						  <?php }?>
					  </select>
					</div>
					
               </div>
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				 <button type="reset" class="btn btn-danger">Reset</button>
				 <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('master/listSyllabusYear'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>
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
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});

   $("#syllabus_year_form").validate({
		rules: {
			syllabus_id: "required",
			program_id: "required"
			
		},
		messages: {
			syllabus_id: " Syllabys Year  Is Required.",
			program_id:"Program Name Is Reqiured."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 