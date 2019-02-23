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
					  <label for="days">Exam Date<span style="color:red;font-weight: bold;">*</span></label>
					  <input  type="text" class="form-control" readonly name="exam_date" id="exam_date" value="<?php echo $time_table_row->exam_date;?>" />
					  <input type="hidden" class="form-control"  name="exam_date_id" id="exam_date_id" value="<?php echo $time_table_row->id;?>" />
					  <input type="hidden" class="form-control"  name="ttid" id="ttid" value="<?php echo $time_table_row->ttid;?>" />
					  
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Slot<span style="color:red;font-weight: bold;">*</span></label>
					 <select name="time_slot" id="time_slot" class="form-control">
						  <option value="">--Select Slot--</option>
						  <?php foreach($slot_list as $slot){?>
						  <option value="<?php echo $slot->id;?>" <?php if($time_table_row->slots==$slot->id){ echo "selected";}?>><?php echo $slot->slot_name;?></option>
						  <?php }?>
						</select>
					</div>
					<div class="form-group col-md-3">
					  <label for="campus_id">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select readonly name="campus_id" id="campus_id" class="form-control">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id;?>" <?php if($time_table_row->campus_id==$campus->id){echo "selected";}?>><?php echo $campus->campus_name;?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					  <select readonly name="course_id" id="course_id" class="form-control">
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
					  <select readonly name="discipline_id" id="discipline_id" class="form-control">
						  <option value="">--Select Discipline--</option>
						  <?php foreach($disciplines as $discipline) { ?>
						  <option value="<?php echo $discipline->id;?>" <?php if($time_table_row->discipline_id==$discipline->id){echo "selected";}?>><?php echo $discipline->discipline_name;?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Teacher<span style="color:red;font-weight: bold;">*</span></label>
					  <select  name="teacher_id" id="teacher_id" class="form-control">
						  <option value="">--Select Teacher--</option>
						  <?php foreach($teachers as $teacher){?>
						  <option value="<?php echo $teacher->id;?>" <?php if($time_table_row->teacher_id==$teacher->id){echo "selected";}?>><?php echo ucfirst($teacher->first_name).' '.ucfirst($teacher->last_name);?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="room_id">Class Room<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="room_id" id="room_id" class="form-control">
						  <option value="">--Select Room--</option>
						   <?php foreach($room_list as $room){?>
						  <option value="<?php echo $room->id;?>" <?php if($time_table_row->room_id==$room->id){ echo "selected";}?>><?php echo $room->room_name;?></option>
						  <?php }?>
					  </select>
					</div>
			   </div>
			   
			   
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update</button>

				
				  <div style="float:right;">
				  <a class="btn btn-primary" href="<?php echo site_url('timetable/allocateInvigilator'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
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

   $("#edit_time_table").validate({
		rules: {
			exam_date: "required",
			time_slot: "required",
			course_id: "required",
			discipline_id: "required",
			teacher_id: "required",
			room_id: "required",
			campus_id: "required"
			
		},
		messages: {
			exam_date: "Exam Date Is Required.",
			time_slot:"Slot Is Reqiured.", 
			course_id:"Course Is Reqiured.", 
			discipline_id:"Discipline Is Reqiured.", 
			teacher_id:"Teacher Is Reqiured.", 
			room_id:"Room Is Reqiured.", 
			campus_id:"Campus Is Reqiured."
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 