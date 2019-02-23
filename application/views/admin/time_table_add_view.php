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
            <form role="form" name="add_time_table" id="add_time_table" method="post" action="<?php echo base_url();?>timetable/saveTimeTable" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="days">Day<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="days" id="days" class="form-control">
						  <option value="">--Select day--</option>
						  <option value="Monday">Monday</option>
						  <option value="Tuesday">Tuesday</option>
						  <option value="Wednesday">Wednesday</option>
						  <option value="Thursday">Thursday</option>
						  <option value="Friday">Friday</option>
						  <option value="Saturday">Saturday</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree_name">Slot<span style="color:red;font-weight: bold;">*</span></label>
					 <select name="time_slot" id="time_slot" class="form-control">
						  <option value="">--Select Slot--</option>
						  <option value="9-10 AM">9-10 AM</option>
						  <option value="10-11 AM">10-11 AM</option>
						  <option value="11-12 AM">11-12 AM</option>
						  <option value="12-1 PM">12-1 PM</option>
						  <option value="1-2 PM">1-2 PM</option>
						  <option value="2-3 PM">2-3 PM</option>
						  <option value="3-4 PM">3-4 PM</option>
						  <option value="4-5 PM">4-5 PM</option>
						</select>
					</div>
					<div class="form-group col-md-3">
					  <label for="campus_id">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id;?>"><?php echo $campus->campus_name;?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="course_id" id="course_id" class="form-control">
						  <option value="">--Select Course--</option>
						  <?php foreach($courses as $course){?>
						  <option value="<?php echo $course->id;?>"><?php echo $course->course_title;?></option>
						  <?php } ?>
					  </select>
					</div>
               </div>
			   <div class="row">
			   <div class="form-group col-md-3">
					  <label for="discipline_id">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="discipline_id" id="discipline_id" class="form-control" onchange="getTeacherByCampusAndDiscipline();";>
						  <option value="">--Select Discipline--</option>
						  <?php foreach($disciplines as $discipline) { ?>
						  <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
						  <?php }?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="teacher_id">Teacher<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="teacher_id" id="teacher_id" class="form-control">
						  <option value="">--Select Teacher--</option>
						 
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="room_id">Class Room<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="room_id" id="room_id" class="form-control">
						  <option value="">--Select Room--</option>
						  <option value="101">101</option>
						  <option value="102">102</option>
						  <option value="103">103</option>
						  <option value="104">104</option>
					  </select>
					</div>
			   </div>
			   
			   
			 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
				 <button type="reset" class="btn btn-danger">Reset</button>
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
	
    function getTeacherByCampusAndDiscipline()
	{
		var $form = $("#add_time_table");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>timetable/getTeacherByCampusAndDiscipline',
			data: $form.serialize(),
			    dataType: 'json',
			success: function(selectValues){
				//alert(data); return false;
				//$('#teacher_id').html(data);
				$.each(selectValues, function(key, value) {   
					$('#teacher_id').append($("<option></option>").attr("value",value.id).text(value.name)); 
				});
			 }
		});
	}
   $("#add_time_table").validate({
		rules: {
			days: "required",
			time_slot: "required",
			campus_id: "required",
			course_id: "required",
			discipline_id: "required",
			teacher_id: "required",
			room_id: "required"
			
		},
		messages: {
			days: "Days Is Required.",
			time_slot:"Time-Slot Is Reqiured.", 
			campus_id:"Campus Name Is Reqiured.",
			course_id:"Course Name Is Reqiured.",
			discipline_id:"Discipline Name Is Reqiured.",
			teacher_id:"Teacher Name Is Reqiured.",
			room_id:"Room No. Name Is Reqiured."
			
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 