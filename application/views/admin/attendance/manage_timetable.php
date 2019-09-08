<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
        $sessdata= $this->session->userdata('sms');

		$id = $sessdata[0]->id;
		$role_id = $sessdata[0]->role_id;
        if($role_id == 1) {
            $campus_id = @$sessdata[0]->campus_id;
            $section_id = @$sessdata[0]->section_id;
            $program_id = @$sessdata[0]->program_id;
            $degree_id = @$sessdata[0]->degree_id;
        }else
		    $campus_id = @$sessdata[0]->campus;



?>
<style >
.error{
 color:red;	
}.success{
 color:green;	font-weight:bold;
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
      <div >
       
	   <div class="box box-primary">
	   
            <div class="box-header with-border">
              <h3 class="box-title" style="color:green"><?php echo $this->session->flashdata('message'); ?></h3>   
            </div>
              
                  
           
		

            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="attendance_form" id="attendance_form" method="post" enctype="multipart/form-data">
              <div class="box-body">
                  <?php if($role_id == 1){?>
                      <input type="hidden" name="campus_id" id="campus_id" value="<?php echo $campus_id;?>" />
                      <input type="hidden" name="program_id" id="program_id" value="<?php echo $program_id;?>" />
                      <input type="hidden" name="degree_id" id="degree_id" value="<?php echo $degree_id;?>" />
                      <input type="hidden" name="section_id" id="section_id" value="<?php echo $section_id;?>" />
					<?php }else{ ?>
					<?php if(!in_array($role_id,array(2))){?>
					<div class="form-group col-md-3">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram()">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
			    </div>
					 <?php }else{ ?>
					 <input type="hidden" name="campus_id" id="campus_id" value="<?php echo @$campus_id;?>">
					 <?php }?>
					<div class="form-group col-md-3">
					  <label for="program_id">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
					  </select>
					</div>
					
				    <div class="form-group col-md-3">
					  <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $id;?>">
					  <input type="hidden" name="login_user_type" id="login_user_type" value="<?php echo $role_id;?>">
					  
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree()<?php if($role_id==2){?>,getBatchbyDegree()<?php }?>;" >
						  <option value="">--Select Degree--</option>
						  
						 
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">Select Batch</option>
						  <?php if($role_id!=2){?>
						 <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" onchange="">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
                  <div class="form-group col-md-3">
                      <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
                      <select class="form-control" name="discipline_id" id="discipline_id"  onchange="getCourseByIds();">

                          <option value="">Select Discipline</option>


                      </select>
                  </div>
                  <div class="form-group col-md-3">
                      <label for="course-group">Section<span style="color:red;font-weight: bold;">*</span></label>
                      <select class="form-control" name="section_id" id="section_id"  onchange="getCourseByIds();">
                          <option value="">Select Section</option>
                          <?php foreach($section as $sectionObj){ ?>
                          <option value="<?php echo $sectionObj->id;?>"><?php echo $sectionObj->section_name;?></option>
                          <?php } ?>

                      </select>
                  </div>
              
					
					<?php if(!in_array($role_id,array(2))){?>
					<div class="form-group col-md-3">
					  <label for="course">Course<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="course_id" id="course_id" class="form-control">
						  <option value="">Select Course</option>
						 
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					<label for="attendance_date">&nbsp;</label><br/>
               <button type="submit" class="btn btn-success" >Submit</button>
			   <span class="showMsg success" id="showMsg"></span>
				  <!--<div style="float:right;">
				    <a class="btn btn-primary" href="<?php //echo site_url('course/assignCourseList'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
				</div>-->
              </div>
				 <?php } ?>
			  </div>
                <?php } ?>
			   <div id="courseList" style="margin-left:30px;">
				  <div id="scheduler"></div>
<div id="log"></div>
			  </div>
              <!-- /.box-body -->
			  <div class="box-footer">
              <!-- <button type="button" class="btn btn-success" onclick="saveAttendance();">Submit</button>-->
			 
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
   <script type="text/javascript">
	$.role_id = <?php echo $role_id;?>
   </script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/dist/css/jquery.scheduler.css"></link>
<script src="<?php echo base_url();?>assets/admin/dist/js/date.format.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/dist/js/jquery.scheduler.js"></script>
 <script type="text/javascript">
     <?php if($role_id == 1){?>
     $().ready(function(){
        loadScheduler('');
     });
     <?php } ?>
 <?php if($role_id == 2){?>
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
     function getDisciplinebyDegree()
     {
         var degree_id =$('#degree_id').val();
         //alert(degree_id);
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
         var $form =$("#attendance_form");
         $.ajax({
             type:'POST',
             url:'<?php echo base_url();?>marks/getCourseGroupByIds',
             data: $form.serialize(),
             success: function(data){
                 var  option_brand = '<option value="">--Select Course--</option>';
                 $('#course_id').empty();
                 $("#course_id").append(option_brand+data);
                 loadScheduler($("#semester").val());
             }
         });
     }
	function getCourseByPDS(){
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
			loadScheduler($("#semester").val());
			 }
		});
  }
  function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
		var program_id =$('#program_id').val();
		var campus_id =$('#campus_id').val();
      getDisciplinebyDegree();
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
	$(document).ready(function(){
		getProgram();
	});
 <?php }else{ ?>
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
     function getDisciplinebyDegree()
     {
         var degree_id =$('#degree_id').val();
         //alert(degree_id);
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
         var $form =$("#attendance_form");
         $.ajax({
             type:'POST',
             url:'<?php echo base_url();?>attendance/getCourseGroupByIds',
             data: $form.serialize(),
             success: function(data){
                 var  option_brand = '<option value="">--Select Course--</option>';
                 $('#course_id').empty();
                 $("#course_id").append(option_brand+data);
                 loadScheduler($("#semester").val());
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
        getDisciplinebyDegree();
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
	function getCourseByPDS()
	{
		var $form = $("#attendance_form");
		$('#scheduler').html('');
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getCourseByPDS',
			data: $form.serialize(),
			success: function(data){
			var  option_brand = '<option value="">--Select Course--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
				loadScheduler($("#semester").val());
			 }
		});
	}
 <?php }?>
function getRsvns() {
	var listArr = [];
	$('.rsvn-container div').each(function(){
	 var left = parseInt($(this).css('left').replace('px',''))/115;
	 var top = parseInt($(this).css('top').replace('px',''))/71;
	 var width = parseInt($(this).css('width').replace('px',''))/116;
	// console.log(top+' - '+left+' : '+(left+width)+' - '+$(this).find('span').html());
	listArr.push({
		"start": left+1,
		"end": Math.round(left+width)+1,
		"id": $(this).find('span').html(),
		"row": top,
	});
	});
	return listArr;
}
	// Sets dates for example reservations to always be on current day or after
function loadScheduler(){
    $('#scheduler').html('');
    $(".rsvn-container").html('');
    console.log('clear rsvn');
	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getScheduler',
			 dataType: "json",
			data: {'degree_id':$('#degree_id').val(),'semester_id':$('#semester_id').val(),'campus_id':$('#campus_id').val(),
                'program_id':$('#program_id').val(),'batch_id':$('#batch_id').val(),'discipline_id':$('#discipline_id').val(),'section_id':$('#section_id').val()},
			success: function(resdata){
				var date = new Date();
				day = date.getDate();
				date1 = new Date();
				//date2 = new Date(),
				//date3 = new Date();
				date1.setDate(day);
				//date2.setDate(day + 1);
				//date3.setDate(day + 2);
				date1 = date1.format('Y-m-d');
				//date2 = date2.format('Y-m-d');
				//date3 = date3.format('Y-m-d');

				// Array of example date
				//console.log(date1);
				/*var reservations = [
									{date: date1, start: '1:00', end: '3:00',subject:'Veterinary Anatomy Paper-I',id:1, row: 1}, 
									{date: date1, start: '2:00', end: '6:00',subject:'Veterinary Anatomy Paper-II',id:2, row: 3}, 
									{date: date1, start: '3:00', end: '5:00',subject:'Veterinary Physiology -Paper-I',id:3, row: 5}
									];*/
				reservations = resdata;
				//console.log(reservations);
				// Array of sample items              
				var printers = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

				// Initialize 
				$("#scheduler").scheduler({items: printers, reservations: reservations, timeslotHeight: 70, timeslotWidth: 115});
			}
	});
	
}

// Allows for reservation deletion
$(document).on('click', ".reservation", function () {
	<?php if($role_id >6 || $role_id==0){?>
    $(this).remove();
	<?php } ?>
});


 
	
	$(document).ready(function () {
		$('#present_check').click(function(){
			$("input[type='checkbox'][name^='attendance']").attr('checked','checked');
			$(this).attr('checked','checked');return false;
		})
		$('#absent_check').click(function(){
			$("input[type='checkbox'][name^='attendance']").removeAttr('checked');    
			$(this).removeAttr('checked','checked');return false;
		})
	});



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
	
	
	function saveAttendance()
	{
		listArr = getRsvns();
		$.ajax({
			  dataType: "json",
			type:'POST',
			url:'<?php echo base_url();?>attendance/saveval',
			data: {"data":JSON.stringify(listArr),'degree_id':$('#degree_id').val(),'semester_id':$('#semester_id').val(),'campus_id':$('#campus_id').val(),
                'program_id':$('#program_id').val(),'batch_id':$('#batch_id').val(),'discipline_id':$('#discipline_id').val(),'section_id':$('#section_id').val()},
			success: function(data){
				$('#showMsg').html('Saved Sucessfully');
			}
		});	
	}
   $("#attendance_form").validate({
		rules: {
			
			degree_id: "required",
			semester_id: "required"
			
			
			
		},
		messages: {
			
			degree_id:"Select Degree Name",
			semester_id: "Select Discipline Name"
		},
		submitHandler: function (form) {
				//form.submit();
				$('#showMsg').html('');
				saveAttendance();return false;
		}
	});	
		
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 