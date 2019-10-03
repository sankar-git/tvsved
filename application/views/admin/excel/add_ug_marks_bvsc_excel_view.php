<?php
 $session_data = $this->session->userdata('sms');
 //p($session_data[0]); exit;
 //p($session_data[0]->permission_status); exit;
 $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
     //print_r($session_data[0]);
	  
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
              <h3 class="box-title" style="color:red"><?php echo $this->session->flashdata('errormessage'); ?></h3>   
            </div>
			
            <!-- /.box-header -->
            <!-- form start -->
	
			 <div id="bvscccc">
            <form role="form"  name="ug_marks_upload_view" id="ug_marks_upload_view" method="post" action="<?php echo base_url();?>excelupload/downloadMarksFormat" enctype="multipart/form-data">
              <div class="box-body">
			   <div class="box-body">
			    <div class="row">
				
				<div class="form-group col-md-4">
					  <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $k=>$campus){ //if($k>3) continue; ?>
						  <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>
						 
						  <?php } ?>
					  </select>
					
			    </div>
				
				
					<div class="form-group col-md-4">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
						  <?php foreach($programs as $program){?>
						  <option value="<?php echo $program->id; ?>"><?php echo $program->program_name; ?></option>
						 
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(),getBatchbyDegree(),getBatchbyDOS(),getDisciplinebyDegree(),uploadView();">
						  <option value="">--Select Degree--</option>
						 
					  </select>
					</div>
				</div>
				
				
			   <div class="row">
				    <div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>"><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					
					
					<div class="form-group col-md-4">
					  <label for="course-group">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="discipline_id" id="discipline_id" onchange="getCourseByIds();">
					   
						  <option value="">Select Discipline</option>
						  <?php foreach($disciplines as $discipline){?>
						    <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
						  <?php } ?>
						
					  </select>
					</div>
					
					
				
					
               </div>
			   
               <div class="row">
			     <div class="form-group col-md-4">
					  <label for="course-group">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <select class="form-control" name="course_id" id="course_id" onchange="getCourseCredit(),getInternalOption();getStudentAssignedMarks();">
					   
						  <option value="">Select Course</option> 
						
						
					  </select>
					</div>
					<div class="form-group col-md-4">
					  <label for="exampleInputEmail1">Exam<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="exam_type" id="exam_type" class="form-control">
						  <option value="">Select Type</option>
						  <option value="1">Regular</option>						  
						  <option value="2">CAP</option>						  
					  </select>
					</div>
				  <div class="form-group col-md-4" id="itemsImport" >
				       <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				       <select class="form-control" name="marks_type" id="marks_type" onchange="getStudentAssignedMarks();">
						   <option value="0">-Select Marks Type-</option>
						  
					  <?php if(in_array($session_data[0]->role_id,array(0,2,7,8,9,10,11,12))){ ?>
					  <option value="1">Internal Marks</option>
					  <?php } if(in_array($session_data[0]->role_id,array(0,8,9,10,11,12))){?>
					  <option value="2">External Marks</option>
					  <?php } ?>
					 
					  </select>
				     </div>
				
				   
				
			  </div>
			  <div class="row"><div class="form-group col-md-4"><p class="credit_points" style="font-weight:bold">&nbsp;</p></div></div>
			  
			  </div>
			
			  
			   
			  
			 <div class="courseList" style="display:none">
			 <label for="campus">Download Upload Marks Excel Format<span style="color:red;font-weight: bold;">*</span></label>
						<input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Download Excel" name="downloadExcel" id="downloadExcel" >
			        
				</div>
			  
            </form>
			</div>
			<input type="hidden" name="theory_credit" id="theory_credit" value="" />
					<input type="hidden" name="practicle_credit" id="practicle_credit" value="" />
			<!--****************************B.Tech ******************************************************************-->
			
			
			 <div class="box-body courseList" style="display:none">
				<div class="row">
					 <form method="post" id="excel_marks_upload" name="excel_marks_upload" action="<?php echo base_url();?>excelupload/excelUploadMarks" enctype="multipart/form-data"> 
						<div class="form-group col-md-12">
						<label for="campus">Upload Marks Excel Format<span style="color:red;font-weight: bold;">*</span></label>
						

					<div class="row">
					<div class="form-group col-md-3">
					  <label for="course-group">Course<span style="color:red;font-weight: bold;">*</span></label>
					   <input type="file" class="form-control" name="userfile" id="userfile"/>
					</div>
					</div>
					<input style="background: #1870BB;border: none;color: #fff;padding: 5px 10px;font-size: 13px;" type="submit" value="Upload Excel" name="uploadExcel" id="uploadExcel">
					<input type="hidden" name="campus_id_1" id="campus_id_1" value ="" />
					<input type="hidden" name="program_id_1" id="program_id_1" value ="" />
					<input type="hidden" name="degree_id_1" id="degree_id_1" value ="" />
					<input type="hidden" name="batch_id_1" id="batch_id_1" value ="" />
					<input type="hidden" name="semester_id_1" id="semester_id_1" value ="" />
					<input type="hidden" name="discipline_id_1" id="discipline_id_1" value ="" />
					<input type="hidden" name="course_id_1" id="course_id_1" value ="" />
					<input type="hidden" name="marks_type_1" id="marks_type_1" value ="" />
					<input type="hidden" name="exam_type_1" id="exam_type_1" value ="" />
				</div>
					</form>
				</div>
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
 
  	$(document).on( 'keyup', '.theory_internal',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>40)
			this.value = '';
	});
	$(document).on( 'keyup', '.theory_external',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>100)
			this.value = '';
	});
	$(document).on( 'keyup', '.practical_exam',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>60)
			this.value = '';
	});
	$(document).on( 'keyup', '.theory_internal_btech30',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>30)
			this.value = '';
	});
	$(document).on( 'keyup', '.theory_internal_btech50',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>50)
			this.value = '';
	});
	$(document).on( 'keyup', '.practical_internal_btech20',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>20)
			this.value = '';
	});
	$(document).on( 'keyup', '.practical_internal_btech50',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>50)
			this.value = '';
	});
	$(document).on( 'keyup', '.theory_external_btech',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>50)
			this.value = '';
	});
  
	/*$(document).on( 'keypress', 'td input',function(e) {
			if (e.keyCode == 13) {
				var $this = $(this);
					index =  $(this).index();
					 //alert( $(this).index());
				//console.log('thisElem='+$this);
				//console.log('index='+index);
				$(this).parent('td').closest('tr').next().find('td').find('input').eq(index).focus();
				e.preventDefault();
			}
		});*/
		function validate_fileupload(fileName)
		{
			var allowed_extensions = new Array("xls");
			var file_extension = fileName.split('.').pop().toLowerCase(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

			for(var i = 0; i <= allowed_extensions.length; i++)
			{
				if(allowed_extensions[i]==file_extension)
				{
					return true; // valid file extension
				}
			}

			return false;
		}
	$(document).ready(function() {
		 $('#downloadExcel').click(function(){
			if($("#campus_id").val()>0 && $("#program_id").val()>0 &&  $("#degree_id").val()>0 &&  $("#batch_id").val()>0 &&  $("#semester_id").val()>0 &&  $("#discipline_id").val()>0 &&  $("#course_id").val()!='' &&  $("#marks_type").val()>0 &&  $("#exam_type").val()>0){
				return true;
			}else{
				alert('Please select all fields');return false;
			}
		 });
		 $('#uploadExcel').click(function(){
			 if($("#userfile").val() == ''){
				 alert('Please upload excel file to import');return false;
			 }
			 if(validate_fileupload($("#userfile").val()) == false){
				 alert('Please upload valid excel file to import');return false;
			 }
				 
			if($("#campus_id").val()>0 && $("#program_id").val()>0 &&  $("#degree_id").val()>0 &&  $("#batch_id").val()>0 &&  $("#semester_id").val()>0 &&  $("#discipline_id").val()>0 &&  $("#course_id").val()!='' &&  $("#marks_type").val()>0 &&  $("#exam_type").val()>0){
				$("#campus_id_1").val($("#campus_id").val());
				$("#program_id_1").val($("#program_id").val());
				$("#degree_id_1").val($("#degree_id").val());
				$("#batch_id_1").val($("#batch_id").val());
				$("#semester_id_1").val($("#semester_id").val());
				$("#discipline_id_1").val($("#discipline_id").val());
				$("#course_id_1").val($("#course_id").val());
				$("#marks_type_1").val($("#marks_type").val());
				$("#exam_type_1").val($("#exam_type").val());
				return true;
			}else{
				alert('Please select all fields');return false;
			}
		 });
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$(document).on( 'keypress', 'td input[type="text"]',function(e) {
			if (e.keyCode == 13) {
				index =  parseInt($(this).index('td input[type="text"]'));
				var count = $('#example #trlist tr').eq(0).find('td input[type="text"]').length;
				if(index>=count)
					index = index %count;
				//console.log(index);
				//console.log( $(this).html());
				//console.log($(this).parent('td').closest('tr').html());
				$(this).closest('tr').next().find('input[type="text"]').eq(index).focus();
					e.preventDefault();
			}
		});
	});
	function getCourseCredit()
	{   
		$.ajax({
				type:'POST',
				url:'<?php echo base_url();?>marks/getCourseCreditPoints',
				data: { course_id: $('#course_id').val()},
				success: function(data){
					var obj = jQuery.parseJSON(data);
					$('#theory_credit').val(obj.theory_credit);
					$('#practicle_credit').val(obj.practicle_credit);
					$('.credit_points').html('Credit Points: '+obj.theory_credit+' + '+obj.practicle_credit);
				 }
			});
		var non_credit_val = $('#course_id').val();
		 //alert(non_credit_val[1]);
		 if(non_credit_val==32){ // courseid
			//$('#itemsImport').val().empty(); 
			//$('#marks_type').reset();
			 $('#marks_type').prop('selectedIndex',0);
			 $('.for_ncc_hide').hide();
			 $(".ncc_show").show();
		 }
		 else{
			 $('.for_ncc_hide').show();
			 $(".ncc_show").hide(); 
		 }
		 
    }
	function getInternalOption(){
		var course_id = $('#course_id').val();
	}
	function ChangeUploadView()
	{   
		var upload_type =$('#upload_type').val();
		//$('#bvscwewew').hide();
		if(upload_type=='A')
		{
			$('#btechhh').show();
			$('#bvscccc').hide();
			 
			
		}
		if(upload_type=='B')
		{
			$('#btechhh').hide();
			$('#bvscccc').show();
			 
		}
		//alert(upload_type);
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
	function getProgramm()
	{
		var campus_idd =$('#campus_idd').val();
		//alert(campus_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getProgramByCampus',
			data: {'campus_id':campus_idd},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Program--</option>';
			$('#program_idd').empty();
			$("#program_idd").append(option_brand+data);
			 }
		});
	}
	function getSemesterbyDegree(){
		var degree_id =$('#degree_id').val();
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
	function getSemesterbyDegreee(){
		var degree_id =$('#degree_idd').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getSemesterbyDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_idd').empty();
			$("#semester_idd").append(option_brand+data);
			 }
		});
	}
	function getBatchbyDegree()
	{
		var degree_id =$('#degree_id').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getBatchbyDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Batch--</option>';
			$('#batch_id').empty();
			$("#batch_id").append(option_brand+data);
			 }
		});
	}
	function getBatchbyDegreee()
	{
		var degree_id =$('#degree_idd').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getBatchbyDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Batch--</option>';
			$('#batch_idd').empty();
			$("#batch_idd").append(option_brand+data);
			 }
		});
	}
	function getDisciplinebyDegreee()
	{
		var degree_id =$('#degree_idd').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDisciplineByDegreeId',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Discipline--</option>';
			$('#discipline_idd').empty();
			$("#discipline_idd").append(option_brand+data);
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
	
	function getBatchbyDOS()
	{
		var degree_id =$('#degree_id').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getBatchbyDOS',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Date Of Start--</option>';
			$('#date_of_start').empty();
			$("#date_of_start").append(option_brand+data);
			 }
		});
	}
	function getBatchbyDOSS()
	{
		var degree_id =$('#degree_idd').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getBatchbyDOS',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Date Of Start--</option>';
			$('#date_of_startt').empty();
			$("#date_of_startt").append(option_brand+data);
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
			data: {'program_id':program_id,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
	function getDegreebyProgramm()
	{
		var program_idd =$('#program_idd').val();
		var campus_id =$('#campus_idd').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_idd,'campus_id':campus_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_idd').empty();
			$("#degree_idd").append(option_brand+data);
			 }
		});
	}
	function getSyllabusYearbyProgram()
	{
		var program_id =$('#program_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getSyllabusYearbyProgram',
			data: {'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Syllabus Year--</option>';
			$('#syllabus_year').empty();
			$("#syllabus_year").append(option_brand+data);
			 }
		});
	}
	function getCourseByIds()
	{
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getCourseGroupByIds',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				if (!$.trim(data)){   
					 $("#itemsImport").hide();
				}
				else{   
					
					 $("#itemsImport").show();
				}
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_id').empty();
			$("#course_id").append(option_brand+data);
			 }
		});
	}
	
	function getCourseByIdss()
	{
		var $form =$("#ug_marks_upload_view_btech");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getCourseByIdss',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				if (!$.trim(data)){   
					 $("#itemsImportt").hide();
				}
				else{   
					
					 $("#itemsImportt").show();
				}
			var  option_brand = '<option value="">--Select Courses--</option>';
			$('#course_idd').empty();
			$("#course_idd").append(option_brand+data);
			 }
		});
	}
	
	function saveUGInternalMarksNew()
	{
		//alert("hello");return false;
		var $form =$("#ug_marks_upload_view");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/saveUGInternalMarksNew',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
                				
				if(data==0)
				{
					alert("Marks Update Successfully"); 
				}
				if(data==1)
				{
					alert("Marks Saved Successfully");
				}
			   
			 }
		});
	}
	function saveUGInternalMarksBtech()
	{
		//alert("hello");return false;
		var $form =$("#ug_marks_upload_view_btech");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/saveUGInternalMarksBtech',
			data: $form.serialize(),
			success: function(data){
				
				if(data==0)
				{
					alert("Marks Update Successfully"); 
				}
				if(data==1)
				{
					alert("Marks Saved Successfully");
				}
				
			
			 }
		});
	}
	
	function getStudentnccMarks()
	{   var uploadType=$('#marks_type_ncc').val();
	     
         if(uploadType=='3'){		 
		 $(".nccListDiv").show();
		 }
		 //$("#ncc").show();
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getStudentnccMarks',
			data: $form.serialize(),
			success: function(data){
			//alert(data); return false;
			$('#bvsc').hide();
			$("#ncc").show();
			$('.trncc').empty();	
			$('.trncc').append(data);
			 }
		});
	}
	
	
	function getStudentAssignedMarks()
	{   
	//alert('sdfasdfsdf');
	//var uploadType=$('#marks_type').val();
	//alert(uploadType);
	          // if(uploadType == 0)
				  // return false;
		        $(".courseList").show();
		var courseid=$('#course_id').val();
		var courseArr = courseid.split("-");
		var courseidArr = courseArr[0].split("|");
		var length = courseidArr.length;
		var numeralCodes = ["","I","II","III","IV","V","VI","VII","VIII","IX"];
		var i;
		$(".practical_head_cont").html('<span style="margin-left: 47px;">PRACTICAL</span></br>');
		$(".external_head_cont").html('<span style="margin-left: 47px;">EXTERNAL</span><br>');
		for (i = 1; i <= length; i++) { 
			var paper = numeralCodes[i];
			$(".practical_head_cont").append('<span>PAPER-'+paper+'(60)</span>');
			$(".external_head_cont").append('<span>PAPER-'+paper+'(100)</span>');
		}
	     /*if(uploadType=='1')
		 {
			 $(".internal").show();
			 
								
			 $(".external").hide(); 
		 }
		 if(uploadType=='2')
		 {
			$(".external").show(); 
		    $(".internal").hide();
		 }*/
		 
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getStudentAssignedMarks',
			data: { campus_id: $('#campus_id').val(),
					program_id: $('#program_id').val(),
					degree_id: $('#degree_id').val(),
					batch_id: $('#batch_id').val(),
					semester_id: $('#semester_id').val(),
					discipline_id: $('#discipline_id').val(),
					course_id: $('#course_id').val(),
					date_of_start: $('#date_of_start').val(),
					marks_type_ncc: $('#marks_type_ncc').val(),
			marks_type: $('#marks_type').val() },
			success: function(data){
				//alert(data); return false;
				$('.for_ncc_hide').show();
			    $(".ncc_show").hide(); 
				$('#bvsc').show();
				
				$('#ncc').hide();
				$('.trlist').empty();	
				$('.trlist').append(data);
			 }
		});
	}
	
	function getStudentAssignedMarkss() //for btech
	{   var uploadType=$('#marks_typee').val();
	          // alert('3235325');
		        $(".courseList").show();
				
		 
	    
		 $.ajax({
			type:'POST',
			url:'<?php echo base_url();?>marks/getCourseCreditPoints',
			data: { course_id: $('#course_idd').val()},
			success: function(data){
				var obj = jQuery.parseJSON(data);
				$('#theory_credit').val(obj.theory_credit);
					$('#practicle_credit').val(obj.practicle_credit);
					$('.credit_points').html('Credit Points: '+obj.theory_credit+' + '+obj.practicle_credit);
					 if(uploadType=='1')
					 {
						 $(".internal").show();
						  if($('#practicle_credit').val() == 0) { $("#bvscwewew .internal th").eq(2).html('Internal Theory(50)');$("#bvscwewew .internal th").eq(3).hide();}else{$("#bvscwewew .internal th").eq(2).html('Internal Theory(30)');$("#bvscwewew .internal th").eq(3).show();}
						 if($('#theory_credit').val() == 0) { $("#bvscwewew .internal th").eq(3).html('Internal Practical(50)');$("#bvscwewew .internal th").eq(2).hide();}else{$("#bvscwewew .internal th").eq(3).html('Internal Practical(20)');$("#bvscwewew .internal th").eq(2).show();}
						 $(".external").hide(); 
					 }
					 if(uploadType=='2')
					 {
						$(".external").show(); 
						if($('#practicle_credit').val() == 0) { $("#bvscwewew .external th").eq(2).html('Theory(50)');$("#bvscwewew .external th").eq(3).hide();}else{$("#bvscwewew .external th").eq(2).html('Theory(30)');$("#bvscwewew .external th").eq(3).show();}
						 if($('#theory_credit').val() == 0) { $("#bvscwewew .external th").eq(3).html('Practical(50)');$("#bvscwewew .external th").eq(2).hide();}else{$("#bvscwewew .external th").eq(3).html('Practical(20)');$("#bvscwewew .external th").eq(2).show();}
						$(".internal").hide();
					 }
					 var $form =$("#ug_marks_upload_view");
					$.ajax({
						type:'POST',
						cache:false,
						url:'<?php echo base_url();?>marks/getStudentAssignedMarkss',
						data: {"campus_id": $('#campus_idd').val(),"program_id": $('#program_idd').val(),"degree_id": $('#degree_idd').val(),"batch_id": $('#batch_idd').val(),"semester_id": $('#semester_idd').val(),"discipline_id": $('#discipline_idd').val(),"course_id": $('#course_idd').val(),"marks_type_ncc": $('#marks_type_ncc').val(),"marks_type": $('#marks_typee').val(),"practicle_credit": $('#practicle_credit').val(),"theory_credit": $('#theory_credit').val()},
						success: function(data){
							//alert(data); return false;
						$('.trlist').empty();	
						$('.trlist').append(data);
						 }
					});
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
				//form.submit();
				return false;
		}
	});	
	function getInternal(id)
	{
		//var hour = $(this).closest('tr').find('.hour').val();
		//var row = $(this).closest('tr');
		//alert($(this).prev('input').attr('id'));
		
		//var inputtt = $(row).find('input');
		//alert(inputtt); return false;
	}
	function uploadView()
	{
		var degreeType=$('#degree_id').val();
		
		//alert(degreeType); return false;
		if(degreeType=='1')
		{
		 $('#bvsc').show();
		 $('#btech').hide();
		}
		if(degreeType=='2')
		{
		 $('#bvsc').hide();
		 $('#btech').show();
		}
		 
		
	}
	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 