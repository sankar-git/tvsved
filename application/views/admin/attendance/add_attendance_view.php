<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
        $sessdata= $this->session->userdata('sms');
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		$campus_id = @$sessdata[0]->campus;
		
?>
<style >
.error{
 color:red;	
}
.btn-default.btn-on.active{background-color: green;color: #fff;}
.btn-default.btn-off.active{background-color: red;color: #fff;}
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
              
                  
           
		
		<?php if($role_id==2){ ?>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="attendance_form" id="attendance_form" method="post" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				   
					  <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $id;?>">
					  <input type="hidden" name="login_user_type" id="login_user_type" value="<?php echo $role_id;?>">
					  <input type="hidden" name="campus_id" id="campus_id" value="<?php echo @$campus_id;?>">
					  
					
				   
					
					<div class="form-group col-md-3">
					  <label for="program_id">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(),getBatchbyDegree();" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				
				
				
			  
				    <div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">Select Batch</option>
						 
					  </select>
					</div>
					
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" onchange="getCourseByIds();">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
								     <div id="courseCon" class="form-group col-md-3 ">
					  <label for="course_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control"     id="course_id" name="course_id" onchange="getStudentAssignByCourse()">
					   <option value="">Select Course</option>
					   </select>
					</div> 
					<div class="form-group col-md-3" id="attendance_date_div" >
					  <label for="attendance_date">Enter Attendance Date<span style="color:red;font-weight: bold;">*</span></label>
					 <input type="text" class="form-control" id="attendance_date" name="attendance_date" placeholder="Enter Attendance Date">
					</div>
			   
					
					<div class="form-group col-md-6">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="button" class="btn btn-success" onclick="saveAttendance();">Save Attendance</button>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				
			
					<!-- <div class="form-group col-md-3 hidden">
					  <label for="attendance_type">Attendance Type<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="attendance_type" id="attendance_type" class="form-control" >
						  <option value="">Select Attendance Type</option>
						  <option value="1">Daily</option>
						  <option value="2">Weekly</option>
						  <option value="3">Periodic</option>
						 
					  </select>
					</div>
					
					<div class="form-group col-md-3" id="attendance_date_div" style="display: none;">
					  <label for="attendance_date">Enter Attendance Date<span style="color:red;font-weight: bold;">*</span></label>
					 <input type="text" class="form-control" id="attendance_date" name="attendance_date" placeholder="Enter Attendance Date">
					</div>
					<div class="form-group col-md-3" id="attendance_range_div" style="display: none;">
					  <label for="attendance_range">Enter Attendance Range<span style="color:red;font-weight: bold;">*</span></label>
					 <input type="text" class="form-control" id="attendance_range" name="attendance_range" placeholder="Enter Attendance Range">
					</div>
					<div class="form-group col-md-3" id="attendance_periodic_div" style="display: none;">
					  <label for="attendance_periodic">Enter Attendance Periodic<span style="color:red;font-weight: bold;">*</span></label>
					 <input type="text" class="form-control" id="attendance_periodic" name="attendance_periodic" placeholder="Enter Attendance Periodic">
					</div>
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="button" class="btn btn-success" onclick="saveAttendance();">Submit</button>
			   <span class="showMsg" id="showMsg"></span>
				  <div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>
              </div>	-->
				</div>
			  </div>
			   <div id="courseList" style="display:none11">
				   <div class="box-body table-responsive">
						    <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th>S.No.</th>
									<th>Student Id</th>
									<th>Student Name</th>
									<th><input type="checkbox" id="present_check" checked /><label for="present_check">PRESENT ALL</label><input type="checkbox"  id="absent_check"><label for="absent_check">ABSENT ALL</label><br/>Mark Attendance</th>
								</tr>
							</thead>
							<tbody id="tr_list">
							</tbody>
						</table>
	                </div>
			  </div>
              <!-- /.box-body -->
			  <div class="box-footer">
              <div class="form-group col-md-6">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="button" class="btn btn-success" onclick="saveAttendance();">Save Attendance</button>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
              </div>
			  
            </form>
		<?php }else{
			echo '<div class="box-body">
			    <div class="row"><div class="row">
					<div class="form-group col-md-6" style="padding-left:50px;"><label><h5>This module will be enabled only  for teacher</h5></label></div></div></div></div>';
		}?>
		  </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script type="text/javascript">
  function getCourseByIds(){
	 var degree_id =$('#degree_id').val();
		var program_id =$('#program_id').val();
		var campus_id =$('#campus_id').val();
		var semester_id =$('#semester_id').val();
		var batch_id =$('#batch_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getTeacherCourseByIds',
			data: {'campus_id':campus_id,'program_id':program_id,'degree_id':degree_id,'batch_id':batch_id,'semester_id':semester_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Course--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
  }
  function getProgram()
	{
		var campus_id =$('#campus_id').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getTeacherProgramByCampus',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_id').empty();
			$("#program_id").append(option_brand+data);
			 }
		});
	}
	$(document).ready(function(){
		getProgram();
	});
  function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
		var program_id =$('#program_id').val();
		var campus_id =$('#campus_id').val();
		//getDisciplineByDegreeId();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getTeacherSemesterbyDegree',
			data: {'degree_id':degree_id,'program_id':program_id,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_id').empty();
			$("#semester_id").append(option_brand+data);
			 }
		});
	}
	function getBatchbyDegree(){
		var degree_id =$('#degree_id').val();
		var program_id =$('#program_id').val();
		var campus_id =$('#campus_id').val();
		//getDisciplineByDegreeId();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getTeacherBatchbyDegree',
			data: {'degree_id':degree_id,'program_id':program_id,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Batch--</option>';
			$('#batch_id').empty();
			$("#batch_id").append(option_brand+data);
			 }
		});
	}
	$(function() {
		 var start = moment().subtract(15, 'days');
    var end = moment();
  $('#attendance_periodic').daterangepicker({
	   minDate: start,
        maxDate: end,
      autoUpdateInput: false,
	  opens: 'left',
      locale: {
          cancelLabel: 'Clear',
		  format: 'DD-MM-YYYY'
      }
  });

  $('#attendance_periodic').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
  });

  $('#attendance_periodic').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
  
	  var start = moment().subtract(7, 'days');
    var end = moment();
  $('#attendance_range').daterangepicker({
	   minDate: start,
        maxDate: end,
      autoUpdateInput: false,
	  opens: 'left',
      locale: {
          cancelLabel: 'Clear',
		  format: 'DD-MM-YYYY'
      }
  });

  $('#attendance_range').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
	  //getStudentAssignByCourse();
  });


  $('#attendance_range').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});

	$(document).ready(function() {
		var dateobj = $("#attendance_date").datepicker({
			format: 'dd-mm-yyyy',autoclose: true,
			        endDate: '+0d',
			onClose: function() {
				alert($(this).val());
			  }
			});
		
		$('#attendance_date').on('change',function(){
			//console.log($('#attendance_date').val());
			getStudentAssignByCourse();
		});
		$('#attendance_type').on('change',function(){
			if($(this).val() == 1){
				$("#attendance_date_div").show();
				$("#attendance_range_div").hide();
				$("#attendance_periodic_div").hide();
			}else if($(this).val() == 2){
				$("#attendance_date_div").hide();
				$("#attendance_range_div").show();
				$("#attendance_periodic_div").hide();
			}else if($(this).val() == 3){
				$("#attendance_date_div").hide();
				$("#attendance_range_div").hide();
				$("#attendance_periodic_div").show();
			}else{
				$("#attendance_date_div").hide();
				$("#attendance_range_div").hide();
				$("#attendance_periodic_div").hide();
			}
		});
	});
	
	$(document).ready(function () {
		$('#present_check').click(function(){
			//$(".attendance_off input[type='checkbox']").removeAttr('checked','checked');
			$("input[type='radio'].attendance_on").attr('checked','checked');
			$("input[type='radio'].attendance_on").parent('label').addClass('active');
			$("input[type='radio'].attendance_off").parent('label').removeClass('active');
			$(this).attr('checked','checked');return false;
		})
		$('#absent_check').click(function(){
			$("input[type='radio'].attendance_off").attr('checked','checked');    
			$("input[type='radio'].attendance_off").parent('label').addClass('active');
			$("input[type='radio'].attendance_on").parent('label').removeClass('active');
			$(this).removeAttr('checked','checked');return false;
		})
	});
	$(document).ready(function(){
  //On page load
  uncheckedChk();

  //on checkbox change
  $("input[type='checkbox'][name='attendance[]'][title= '1']").on("change",function(){
    uncheckedChk();
  });
});

//Function to identify all the unchecked checkbox with title=1
function uncheckedChk(){
  var not_checked = []
  $("input[type='checkbox'][name='attendance[]'][title= '1']:not(:checked)").each(function (){
    not_checked.push($(this).val());
  });
  
}
    function getProgramByCampus()
	{
	  var campus_id =$('#campus_id').val();
	 // alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getProgramByCampus',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_id').empty();
			$("#program_id").append(option_brand+data);
			}
		});	
	}
	
	function getDegreebyProgram()
	{
		var program_id =$('#program_id').val();
		var campus_id =$('#campus_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getTeacherDegreebyProgram',
			data: {'campus_id':campus_id,'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
	function getCourseByPDS()
	{
		var $form = $("#attendance_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getCourseByPDS',
			data: $form.serialize(),
			success: function(data){
			var  option_brand = '<option value="">--Select Course--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
		
			 }
		});
	}
	function getStudentAssignByCourse()
	{
		if($('#course_id').val()>0 && $('#attendance_date').val()!=''){
			var $form = $("#attendance_form");
			$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>attendance/getStudentAssignByCourse',
				data: $form.serialize(),
				success: function(data){
				//$('#courseList').show();
				$('#tr_list').html(data);
				//$.dataTable.draw(false);
		
				}
			});
		}
	}
	function saveAttendance()
	{
		$('.showMsg').html('Please Wait.. Saving Data').css("color", "blue").css("font-weight", "bold");
		var $form = $("#attendance_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/saveAttendance',
			data: $form.serialize(),
			success: function(data){
			//console.log(data); 
			data = $.trim(data);
			if(data==1){
				$('.showMsg').html('Attendance saved successfully').css("color", "green").css("font-weight", "bold");
			}else{
				$('.showMsg').html(data).css("color", "red").css("font-weight", "bold");
			}
			
			
			
		    }
		});
	}
   $("#course_assign").validate({
		rules: {
			program_id: "required",
			degree_id: "required",
			semester_id: "required",
			previous_semester_id:"required",
			syllabus_year:"required",
			batch_id:"required"
			
			
			
		},
		messages: {
			program_id: "Select Program Name",
			degree_id:"Select Degree Name",
			semester_id: "Select Discipline Name",
			previous_semester_id:"Select Course Group Name",
			syllabus_year:"Select Syllabus Year Name",
			batch_id:"Select Semester Name"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
		
	
    var sList = "";
    $('input[type=checkbox]').each(function () {
      sList += "(" + $(this).val() + "-" + (this.checked ? "1" : "0") + ")";
    });
     //alert(sList);
	 function getVal()
	 {
	  $('input[type=checkbox]').each(function () {
        sList += "(" + $(this).val() + "-" + (this.checked ? "1" : "0") + ")";
     }); 
	 }
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 