<?php 
//print_r($time_table_row); exit;
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
            <form role="form" name="edit_time_table" id="edit_time_table" method="post" action="<?php echo base_url();?>timetable/updateTimeTable/<?php echo $time_table_row->id;?>" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="days">Day<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="days" id="days" class="form-control" disabled>
						  <option value="">--Select day--</option>
						  <option value="Monday" <?php if($time_table_row->days=="Monday"){ echo "selected";}?>>Monday</option>
						  <option value="Tuesday" <?php if($time_table_row->days=="Tuesday"){ echo "selected";}?>>Tuesday</option>
						  <option value="Wednesday" <?php if($time_table_row->days=="Wednesday"){ echo "selected";}?>>Wednesday</option>
						  <option value="Thursday" <?php if($time_table_row->days=="Thursday"){ echo "selected";}?>>Thursday</option>
						  <option value="Friday" <?php if($time_table_row->days=="Friday"){ echo "selected";}?>>Friday</option>
						  <option value="Saturday" <?php if($time_table_row->days=="Saturday"){ echo "selected";}?>>Saturday</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Slot<span style="color:red;font-weight: bold;">*</span></label>
					 <select name="time_slot" id="time_slot" class="form-control" disabled>
						  <option value="">--Select Slot--</option>
						  <option value="09-10 AM" <?php if($time_table_row->slots=='09-10 AM'){ echo "selected";}?>>09-10 AM</option>
						  <option value="10-11 AM" <?php if($time_table_row->slots=='10-11 AM'){ echo "selected";}?>>10-11 AM</option>
						  <option value="11-12 AM" <?php if($time_table_row->slots=='11-12 AM'){ echo "selected";}?>>11-12 AM</option>
						  <option value="12-01 PM" <?php if($time_table_row->slots=='12-01 PM'){ echo "selected";}?>>12-01 PM</option>
						  <option value="01-02 PM" <?php if($time_table_row->slots=='01-02 PM'){ echo "selected";}?>>01-02 PM</option>
						  <option value="02-03 PM" <?php if($time_table_row->slots=='02-03 PM'){ echo "selected";}?>>02-03 PM</option>
						  <option value="03-04 PM" <?php if($time_table_row->slots=='03-04 PM'){ echo "selected";}?>>03-04 PM</option>
						  <option value="04-05 PM" <?php if($time_table_row->slots=='04-05 PM'){ echo "selected";}?>>04-05 PM</option>
						</select>
					</div>
					<div class="form-group col-md-3">
					  <label for="campus_id">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" disabled>
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id;?>" <?php if($time_table_row->campus_id==$campus->id){echo "selected";}?>><?php echo $campus->campus_name;?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="course_id" id="course_id" class="form-control" disabled>
						  <option value="">--Select Course--</option>
						  <?php foreach($courses as $course){?>
						  <option value="<?php echo $course->id;?>" <?php if($time_table_row->course_id==$course->id){echo "selected";}?>><?php echo $course->course_title;?></option>
						  <?php } ?>
					  </select>
					</div>
               </div>
			   <div class="row">
			   <div class="form-group col-md-3">
					  <label for="discipline_id">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="discipline_id" id="discipline_id" class="form-control" disabled>
						  <option value="">--Select Discipline--</option>
						  <?php foreach($disciplines as $discipline) { ?>
						  <option value="<?php echo $discipline->id;?>" <?php if($time_table_row->discipline_id==$discipline->id){echo "selected";}?>><?php echo $discipline->discipline_name;?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Teacher<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="teacher_id" id="teacher_id" class="form-control" disabled>
						  <option value="">--Select Teacher--</option>
						  <?php foreach($teachers as $teacher){?>
						  <option value="<?php echo $teacher->id;?>" <?php if($time_table_row->teacher_id==$teacher->id){echo "selected";}?>><?php echo ucfirst($teacher->first_name).' '.ucfirst($teacher->last_name);?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="room_id">Class Room<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="room_id" id="room_id" class="form-control" disabled>
						  <option value="">--Select Room--</option>
						  <option value="101" <?php if($time_table_row->room_id=='101'){echo "selected";}?>>101</option>
						  <option value="102" <?php if($time_table_row->room_id=='102'){echo "selected";}?>>102</option>
						  <option value="103" <?php if($time_table_row->room_id=='103'){echo "selected";}?>>103</option>
						  <option value="104" <?php if($time_table_row->room_id=='104'){echo "selected";}?>>104</option>
					  </select>
					</div>
			   </div>
			   
			   
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('timetable/viewTimeTable'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

   $("#program_form").validate({
		rules: {
			program_code: "required",
			program_name: "required",
			program_description: "required"
			
		},
		messages: {
			program_code: "Program Code Is Required.",
			program_name:"Program Name Is Reqiured.", 
			program_description:"Program Description Is Reqiured."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 