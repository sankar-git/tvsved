<?php $this->load->view('admin/helper/header');?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<?php $this->load->view('admin/helper/sidebar');
        $sessdata= $this->session->userdata('sms');
		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
		
?>
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
            <form role="form" name="attendance_form" id="attendance_form"  method="post" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				   <div class="form-group col-md-3">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram()">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
			    </div>
					
					<div class="form-group col-md-3">
					  <label for="program_id">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree();" >
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				
				
				
			  
				    <div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="discipline_id" id="discipline_id" onchange="getStudentByIds();" >
					   
						  <option value="">Select Discipline</option>
					  </select>
					</div>
			     <!--<div id="courseCon" class="form-group col-md-3 ">
					  <label for="course_id">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control"  id="course_id" name="course_id" onchange="getStudentByIds();">
					   <option value="">Select Course</option>
					   </select>
					</div> -->
					<div id="teacherCon" class="form-group col-md-3 " >
					  <label for="student_id">Student<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="selectpicker form-control" multiple data-live-search="true"  name="student_id[]" id="student_id" onclick="showStatus(this.value);">
					   <!--<select class="form-control"   id="student_id" name="student_id">-->
					    <option value="">Select Student</option>
					   </select>
					</div>
					<div class="form-group col-md-3" id="attendance_range_div" >
					  <label for="attendance_range">Date Range<span style="color:red;font-weight: bold;">*</span></label>
					 <input type="text" class="form-control" id="attendance_range" name="attendance_range" placeholder="Enter Attendance Range">
					</div>
					
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="button" class="btn btn-success" onclick="getAttendance();">Submit</button>
			   <?php if($role_id == 8 || $role_id == 0){ ?>
               <button type="button" class="btn btn-success" onclick="publishAttendance();">Publish Attendance</button>
			   <?php } ?>
			   <span class="showMsg" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				
			  </div>
			   <div id="courseList" style="display:none11">
				   <div class="box-body table-responsive" id="attResult">
						   &nbsp;
	                </div>
			  </div>
			  
			  <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto;margin-bottom:20px"></div>
			  <br><br>
			  <div id="container_female" style="min-width: 500px; height: 400px; max-width: 550px; margin: 0 auto;float:left"></div>
			  <div id="container_male" style="min-width: 500px; height: 400px; max-width: 550px; margin: 0 auto;float:left"></div>
              <!-- /.box-body -->
			  <div class="box-footer">
              
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
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
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
 $(document).ready(function() {
	// $('#example').DataTable();
	//var start = moment().subtract(7, 'days');
    //var end = moment();
  $('#attendance_range').daterangepicker({
	  // minDate: start,
        //maxDate: end,
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
  function get_teacher_list(){
	  
	 var campus_id =$('#campus_id').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/get_teacher',
			data: {'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			//var  option_brand = '<option value="">--Select Teacher--</option>';
			$('#teacher_id').empty();
			$("#teacher_id").append(data);
			//$('#teacher_id').multiselect('rebuild');
			 }
		}); 
	  
  }
  function getProgram()
	{
		var campus_id =$('#campus_id').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getProgramByCampus',
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
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'campus_id':campus_id,'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
	function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
		getDisciplineByDegreeId();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getSemesterbyDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_id').empty();
			$("#semester_id").append(option_brand+data);
			 }
		});
	}
	function getDisciplineByDegreeId()
	{
		
		var degree_id =$('#degree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDisciplineByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Discipline--</option>';
			$('#discipline_id').empty();
			$("#discipline_id").append(option_brand+data);
			 }
		});
	}
	function getCourseByIds()
	{
		 //$('#courseCon').removeClass('hidden');
		var $form =$("#attendance_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getCourseByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			//$('#course_id').multiselect('rebuild');
			 }
		});
	}
	function getStudentByIds()
	{
		 //$('#courseCon').removeClass('hidden');
		var $form =$("#attendance_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getStudentByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				
			//var  option_brand = '<option value="">--Select Courses--</option>';
			$('#student_id').empty();
			$("#student_id").append(data);
			$('#student_id').multiselect('rebuild');
			 }
		});
	}
	

	
	
	$(document).ready(function () {
		$('#present_check').click(function(){
			$("input[type='checkbox'][name^='attendance']").attr('checked','checked');
			$(this).attr('checked','checked');return false;
		})
		$('#absent_check').click(function(){
			$("input[type='checkbox'][name^='attendance']").removeAttr('checked');    
			$(this).removeAttr('checked','checked');return false;
		})
		$('#student_id').multiselect({
			        	includeSelectAllOption: true,
			        	enableFiltering: true,
						buttonWidth: '345px',
                        maxHeight: 350
						
			        });
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
	function publishAttendance(){
		var $form = $("#attendance_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/publishAttendance',
			data: $form.serialize(),
			success: function(data){
				alert('Published Successfully');
			}
		});
	}
	function getAttendance()
	{
		$('.showMsg').html('');
		var $form = $("#attendance_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getStudentAttendance',
			data: $form.serialize(),
			success: function(data){
			console.log(data); 
			var data = $.parseJSON(data);

			$('#attResult').html(data.table);
				if(data.present != '0' || data.absent != '0')
				{
					getchart(data.present,data.absent,data.nil);
					$('#container').show();
					$('#chart_div').hide();
					
				}
				else
				{
					$('#container').hide();
					$('#chart_div').hide();
				}
				
				if(data.presentmale != '0' || data.presentfemale != '0')
				{
					getchart_male_percent(data.presentmale,data.absentmale,data.nilmale);
					getchart_female_percent(data.presentfemale,data.absentfemale,data.nilfemale);
					$('#container_male').show();
					$('#container_female').show();
					//$('#chart_div').hide();
					
				}
				else
				{
					$('#container_male').hide();
					$('#container_female').hide();
					$('#chart_div').hide();
				}
				
				
				
			//$('#attResult').html(data); 
			
			if(data==1){
				$('.showMsg').html('Attendance save successfully').css("color", "green");
			}
			if(data==0){
				$('.showMsg').html('Something went wrong').css("color", "red");
			}
			if(data==2){
				$('.showMsg').html('Attendance already given today.').css("color", "red");
			}
			
			
		    }
		});
	}
	
	
	function getchart(present,absent,nilpercent)
	{
		
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Attendance Chart'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
	colors: ['#66ff66', '#ff1a1a', '#ffff4d'],
    series: [{
        name: 'Attendance',
        colorByPoint: true,
        data: [{
            name: 'Present',
            y: present,
            sliced: true,
            selected: true
        }, {
            name: 'Absent',
            y: absent
        },{
            name: 'Not Marked',
            y: nilpercent
        }]
    }]
});
	}
	
	function getchart_male_percent(present,absent,nilpercent)
	{
		
Highcharts.chart('container_male', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Male Attendance Chart'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
	colors: ['#66ff66', '#ff1a1a', '#ffff4d'],
    series: [{
        name: 'Attendance',
        colorByPoint: true,
        data: [{
            name: 'Present',
            y: present,
            sliced: true,
            selected: true
        }, {
            name: 'Absent',
            y: absent
        },{
            name: 'Not Marked',
            y: nilpercent
        }]
    }]
});
	}
	function getchart_female_percent(present,absent,nilpercent)
	{
		
Highcharts.chart('container_female', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Female Attendance Chart'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
	colors: ['#66ff66', '#ff1a1a', '#ffff4d'],
    series: [{
        name: 'Attendance',
        colorByPoint: true,
        data: [{
            name: 'Present',
            y: present,
            sliced: true,
            selected: true
        }, {
            name: 'Absent',
            y: absent
        },{
            name: 'Not Marked',
            y: nilpercent
        }]
    }]
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
  <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-multiselect.css" type="text/css"/>
 <?php $this->load->view('admin/helper/footer');?> 
  
  
