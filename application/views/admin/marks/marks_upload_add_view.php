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
            </div>
			
            <!-- /.box-header -->
            <!-- form start -->
			<!--<center>
			<div class="row" style="padding-left:30px;" align="rignt">
			 <div class="form-group col-md-4">
					  <label for="wwe">Upload Type<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="upload_type" id="upload_type" onchange="ChangeUploadView();">
						  <option value="">--Select College Type--</option>
						   <option value="B">BVSC</option>
						   <option value="A">BTECH</option>
						 
					 </select>
		      </div>
			  </div>
			  </center>-->
			 <div id="bvscccc">
            <form role="form"  name="ug_marks_upload_view" id="ug_marks_upload_view" method="post" action="return false;" enctype="multipart/form-data">
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
					   <select class="form-control" name="course_id" id="course_id" onchange="getCourseCredit();">
					   
						  <option value="">Select Course</option> 
						
						
					  </select>
					</div>
				  <div class="form-group col-md-4">
				  <label for="course-group">Date Of Start<span style="color:red;font-weight: bold;">*</span></label>
				   <select class="form-control" name="date_of_start" id="date_of_start">
				   </select>
				</div>
				
				    <div class="ncc_show" style="display:none;">
				     <div class="form-group col-md-4" id="show_list">
				       <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				       <select class="form-control" name="marks_type_ncc" id="marks_type_ncc" onchange="getStudentnccMarks();">
						   <option value="0">Select Upload</option>
						   <option value="3">Upload List</option>
					  </select>
				     </div>
				   </div>
				
				<div class="for_ncc_hide">
				<?php if($session_data[0]->upload_type=='1'){?>
				  <div class="form-group col-md-4" id="itemsImport" style="display:none;">
				  <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				   <select class="form-control" name="marks_type" id="marks_type" onchange="getStudentAssignedMarks();">
					  <option value="0">-Select Marks Type-</option>
					  <option value="1">Internal Marks</option>
					  <?php if($session_data[0]->role_id!=2){?>
					  <option value="2">External Marks</option>
					  <?php } ?>
				   </select>
				  </div>
				<?php } elseif($session_data[0]->upload_type=='2'){?>
					 <div class="form-group col-md-4" id="itemsImport" style="display:none;">
				       <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				       <select class="form-control" name="marks_type" id="marks_type" onchange="getStudentAssignedMarks();">
						   <option value="0">-Select Marks Type-</option>
						   <option value="1">Internal Marks</option>
						 
					  </select>
				     </div>
				<?php }else{?>
				     <div class="form-group col-md-4" id="itemsImport" style="display:none;">
				       <label for="course-group">Items to be Import<span style="color:red;font-weight: bold;">*</span></label>
				       <select class="form-control" name="marks_type" id="marks_type" onchange="getStudentAssignedMarks();">
						   <option value="0">-Select Marks Type-</option>
						   <option value="2">External Marks</option>
					  </select>
				     </div>
				<?php }?>
			  </div>
			  </div>
			  <div class="row"><div class="form-group col-md-4"><p class="credit_points" style="font-weight:bold">&nbsp;</p></div></div>
			  
			  </div>
			  <div class="box-footer">
               <button type="button" class="btn btn-success" onclick="saveUGInternalMarksNew();">Save</button>
			  </div>
			    <div id="ncc">
			   <div id="nccListDiv" class="nccListDiv" style="display:none" >
			        <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr id="ncc_list" class="ncc_list">
								    <th>Unique Id</th>
								    <th>Student Name</th>
									<th><span style="margin-left: 47px;">Ncc Subject</span></br></th>
									
									
								</tr>
								
							</thead>
							<tbody id="trncc" class="trncc">
								
							</tbody>
						</table>
						
	                </div>
				</div>
			</div>
			  
			  
			  <div id="bvsc">
			  
			   <div id="courseList" class="courseList" style="display:none" >
			        <div class="box-body table-responsive">
						
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr id="internal" class="internal" style="display:none">
								    <th>Unique Id</th>
								    <!--<th>Student Id</th>-->
								    <th>Student Name</th>
									<th><span style="margin-left: 47px;">INTERNAL</span></br><span >FIRST(40)</span><span>SECOND(40)</span><span>THIRD(40)</span></th>
									<th nowrap class="practical_head_cont"></th>
									
									
								</tr>
								
								<tr id="external" class="external" style="display:none">
								    <th>Unique Id</th>
								   <!-- <th>Student Id</th>-->
								    <th>Student Name</th>
									<th><span style="margin-left: 47px;">INTERNAL</span></br><span>FIRST(40)</span><span>SECOND(40)</span><span>THIRD(40)</span></th>
									<th nowrap class="practical_head_cont"></th>
									<th nowrap class="external_head_cont"><span style="margin-left: 47px;">EXTERNAL</span></br><span>PAPER-I(100)</span><span>PAPER-II(100)</span></th>
									
									
								</tr>
							</thead>
							<tbody id="trlist" class="trlist">
								
							</tbody>
						</table>
						
	                </div>
				</div>
			</div>
		<div id="bvscwewew" style="display:none" >
			   <div id="courseList" class="courseList" >
			        <div class="box-body table-responsive">
						    <table id="example" class="table table-bordered table-hover">
							<thead>
								<tr id="internal" class="internal" style="display:none">
								    <th>Unique Id</th>
								    <th>Student Name</th>
									<th>Internal Theory(25)</th>
									<th>Assignment(5)</th>
									<th>Internal Practical(20)</th>
								</tr>
								<tr id="external" class="external" style="display:none">
								    <th>Unique Id</th>
								    <th>Student Name</th>
									<th>Theory(25)</th>
									<th>Assignment(5)</th>
									<th>Practical(20)</th>
									<th>External Theory(50)</th>
									<!--<th>External Practical(100)</th>-->
							    </tr>
							</thead>
							<tbody id="trlisttt" class="trlist">
							</tbody>
						</table>
	                </div>
				</div>
			</div>
				
			  
              <!-- /.box-body -->

              <div class="box-footer">
               <button type="button" class="btn btn-success" onclick="saveUGInternalMarksNew();">Save</button>
			  </div>
			  
            </form>
			</div>
			<input type="hidden" name="theory_credit" id="theory_credit" value="" />
					<input type="hidden" name="practicle_credit" id="practicle_credit" value="" />
			<!--****************************B.Tech ******************************************************************-->
		
			
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
	$(document).on( 'keyup', '.assignment_mark_btech5',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>5)
			this.value = '';
	});$(document).on( 'keyup', '.assignment_mark_btech10',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>10)
			this.value = '';
	});
	$(document).on( 'keyup', '.theory_internal_btech40',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>40)
			this.value = '';
	});
	$(document).on( 'keyup', '.practical_internal_btech15',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>15)
			this.value = '';
	});
	$(document).on( 'keyup', '.practical_internal_btech40',function(e) {
		this.value = this.value.replace(/[^0-9\.]/g,'');
		if(this.value>40)
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
	$(document).ready(function() {
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
					getStudentAssignedMarks();
				 }
			});
		
		 
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
		$('#bvsc').hide();
		$("#ncc").hide();
		$("#bvscwewew").hide();
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
	
	function getSemesterbyDegree(){
		$('#bvsc').hide();
		$("#ncc").hide();
		$("#bvscwewew").hide();
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
	
	function getBatchbyDegree()
	{
		$('#bvsc').hide();
		$("#ncc").hide();
		$("#bvscwewew").hide();
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
	
	
	function getDisciplinebyDegree()
	{
		$('#bvsc').hide();
		$("#ncc").hide();
		$("#bvscwewew").hide();
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
	
	function getDegreebyProgram()
	{
		$('#bvsc').hide();
		$("#ncc").hide();
		$("#bvscwewew").hide();
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
		var bvsc = [ "1", "2", "3", "4" ];
		if($.inArray($('#campus_id').val(),bvsc)>=0 && $('#program_id').val()==1){
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
		}else{
			saveUGInternalMarksBtech();
		}
	}
	function saveUGInternalMarksBtech()
	{
		//alert("hello");return false;
		var $form =$("#ug_marks_upload_view");
		
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
			$('#bvscwewew').hide();
			$('#bvsc').hide();
			$("#ncc").show();
			$('.trncc').empty();	
			$('.trncc').append(data);
			 }
		});
	}
	
	
	function getStudentAssignedMarks()
	{   
		$('#bvsc').hide();
		$("#ncc").hide();
		$("#bvscwewew").hide();
			
		var bvsc = [ "1", "2", "3", "4" ];
		if($.inArray($('#campus_id').val(),bvsc)>=0 && $('#program_id').val()==1){ //console.log("Campus="+$('#campus_id').val()) 
			var uploadType=$('#marks_type').val();
				   if(uploadType == 0)
					   return false;
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
			 if(uploadType=='1')
			 {
				 $(".internal").show();
				 
									
				 $(".external").hide(); 
			 }
			 if(uploadType=='2')
			 {
				$(".external").show(); 
				$(".internal").hide();
			 }
			 
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
					$('#bvsc .trlist').append(data);
				 }
			});
		}else if($('#program_id').val()==1){
			getStudentAssignedMarkss();	
		}else{
			getStudentAssignedPGMarks();	
		}
	}
	function getStudentAssignedPGMarks(){
		$("#bvscwewew").show();
		var uploadType=$('#marks_type').val();
				   
		$(".courseList").show();

		if(uploadType=='1')
		{
			$(".internal").show();
			$("#bvscwewew .internal th").eq(2).show().html('Internal Theory(20)');
			$("#bvscwewew .internal th").eq(3).html('TermPaper(10)');
			$("#bvscwewew .internal th").eq(4).show().html('Internal Practical(50/100)');
			$(".external").hide(); 
		}
		if(uploadType=='2')
		{
			$(".external").show(); 
			
			$("#bvscwewew .external th").eq(2).show().html('Internal Theory(20)');
			$("#bvscwewew .external th").eq(3).html('TermPaper(10)');
			$("#bvscwewew .external th").eq(4).show().html('Internal Practical(50/100)');
			$("#bvscwewew .external th").eq(5).show().html('External Theory(70/100)');
			$(".internal").hide();
		}
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			cache:false,
			url:'<?php echo base_url();?>marks/getStudentAssignedPGMarkss',
			data: {"campus_id": $('#campus_id').val(),"program_id": $('#program_id').val(),"degree_id": $('#degree_id').val(),"batch_id": $('#batch_id').val(),"semester_id": $('#semester_id').val(),"discipline_id": $('#discipline_id').val(),"course_id": $('#course_id').val(),"marks_type_ncc": $('#marks_type_ncc').val(),"marks_type": $('#marks_type').val(),"practicle_credit": $('#practicle_credit').val(),"theory_credit": $('#theory_credit').val()},
			success: function(data){
				//alert(data); return false;
				$('.trlist').empty();	
				$('#bvscwewew .trlist').append(data);
			 }
		});
	}
	function getStudentAssignedMarkss() //for btech
	{   
		$("#bvscwewew").show();
		var uploadType=$('#marks_type').val();
				   
		$(".courseList").show();

		if(uploadType=='1')
		{
			$(".internal").show();
			if($('#practicle_credit').val() == 0) { 
				$("#bvscwewew .internal th").eq(2).show().html('Internal Theory(40)');
				$("#bvscwewew .internal th").eq(3).html('Assignment(10)');
				$("#bvscwewew .internal th").eq(4).hide();
			}else if($('#theory_credit').val() == 0) { 
				$("#bvscwewew .internal th").eq(2).hide();
				$("#bvscwewew .internal th").eq(3).html('Assignment(10)');
				$("#bvscwewew .internal th").eq(4).show().html('Internal Practical(40)');
			}else{
				$("#bvscwewew .internal th").eq(2).show().html('Internal Theory(30)');
				$("#bvscwewew .internal th").eq(3).html('Assignment(5)');
				$("#bvscwewew .internal th").eq(4).show().html('Internal Practical(15)');
			}
			$("#bvscwewew .external th").eq(5).show().html('External Theory(50)');
			$(".external").hide(); 
		}
		if(uploadType=='2')
		{
			$(".external").show(); 

				
			if($('#practicle_credit').val() == 0) { 
				$("#bvscwewew .external th").eq(2).show().html('Theory(40)');
				$("#bvscwewew .external th").eq(3).html('Assignment(10)');
				$("#bvscwewew .external th").eq(4).hide();
			}else if($('#theory_credit').val() == 0) { 
				$("#bvscwewew .external th").eq(4).show().html('Practical(40)');
				$("#bvscwewew .external th").eq(3).html('Assignment(10)');
				$("#bvscwewew .external th").eq(2).hide();
			}else{
				$("#bvscwewew .external th").eq(4).show().html('Practical(15)');
				$("#bvscwewew .external th").eq(3).html('Assignment(5)');
				$("#bvscwewew .external th").eq(2).show().html('Theory(30)');
			}
			$(".internal").hide();
		}
		var $form =$("#ug_marks_upload_view");
		$.ajax({
			type:'POST',
			cache:false,
			url:'<?php echo base_url();?>marks/getStudentAssignedMarkss',
			data: {"campus_id": $('#campus_id').val(),"program_id": $('#program_id').val(),"degree_id": $('#degree_id').val(),"batch_id": $('#batch_id').val(),"semester_id": $('#semester_id').val(),"discipline_id": $('#discipline_id').val(),"course_id": $('#course_id').val(),"marks_type_ncc": $('#marks_type_ncc').val(),"marks_type": $('#marks_type').val(),"practicle_credit": $('#practicle_credit').val(),"theory_credit": $('#theory_credit').val()},
			success: function(data){
				//alert(data); return false;
				$('.trlist').empty();	
				$('#bvscwewew .trlist').append(data);
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
  
  
 