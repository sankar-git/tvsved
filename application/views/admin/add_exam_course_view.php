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
            <form role="form" name="registration_form" id="registration_form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
				<div class="form-group col-md-3">
					  <label for="campus_id">Campus<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampus();">
						  <option value="">--Select Campus--</option>
						  <?php foreach($campuses as $campus){?>
						  <option value="<?php echo $campus->id;?>" <?php if($this->input->get('campus_id')==$campus->id) echo "selected" ;?>><?php echo $campus->campus_name;?></option>
						  <?php }?>
					  </select>
					</div>
				
					<div class="form-group col-md-3">
					  <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
						  <option value="">--Select Program--</option>
						   
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(),getBatchbyDegree(),getBatchbyDOS(),getBatchbyDOC();">
						  <option value="">--Select Degree--</option>
						   
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" >
						  <option value="">Select Semester</option>
						
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" onchange="getCourseList();">
						  <option value="">Select Batch</option>
						
					  </select>
					</div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Exam<span style="color:red;font-weight: bold;">*</span></label>
                        <select name="exam_type" id="exam_type" class="form-control" onchange="getCourseList();">
                            <option value="">Select Type</option>
                            <option value="1">Regular</option>
                            <option value="2">CAP</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1">Examination Type<span style="color:red;font-weight: bold;">*</span></label>
                        <select name="examination" id="examination" class="form-control" onchange="getCourseList();">
                            <option value="">Select Examination Type</option>
                            <option value="external">External</option>
                            <option value="internal_1">Internal 1</option>
                            <option value="internal_2">Internal 2</option>
                            <option value="internal_3">Internal 3</option>
                            <option value="internal_4">Internal 4</option>
                            <option value="internal_5">Internal 5</option>
                            <option value="internal_6">Internal 6</option>
                            <option value="practical_1">Practical 1</option>
                            <option value="practical_2">Practical 2</option>
                            <option value="practical_3">Practical 3</option>
                            <option value="practical_4">Practical 4</option>
                            <option value="practical_5">Practical 5</option>
                            <option value="practical_6">Practical 6</option>
                        </select>
                    </div>
					
				
               </div>
			   
			  <!--   <div class="row">
				
				
				</div> -->	
			 </div>
			 
			 
			  <div id="studentList" style="display:none">
				   <div class="box-body table-responsive">
			     
							 <table id="example" class="table table-bordered table-hover">
								<thead>
								<tr>
								    <th><input type="checkbox"  id="select_all">Select All</th>
								    <th>S.No</th>
									<th>Course Code</th>
									<th>Course Name</th>
									<th>Add Exam Date</th>
									<!--<th>Print(PDF)</th>-->
									
								</tr>
							</thead>
							<tbody id="tr_list">
								
							</tbody>
						</table>
	
	
					</div>
					<div style="text-align: center;padding-top:21px">
					 <button type="button"  class="btn btn-success" style="margin-bottom: 14px;padding-bottom: 7px;width: 90px;" onclick="saveExamDate();">Save</button>
					</div>
				 </div>
			 
              <!-- /.box-body -->
               
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
	   $('body').on('focus',".exam_dates", function(){
			$(this).datepicker({format: 'dd-mm-yyyy',autoclose: true});
		});
	});
	  function getclosureDate(dateVal)
	  {
		 // alert(dateVal);
		 if(dateVal!='')
		 {
			 $('#studentList').show();
			 
		 }
		 else
		 {
			  $('#studentList').hide();
		 }
		
	  }
 
    function getSemesterbyDegree()
	{
		var degree_id =$('#degree_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getSemesterByDegree',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Semester--</option>';
			$('#semester_id').empty();
			
			$("#semester_id").append(option_brand+data);
			
			 }
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
	
	function getBatchbyDOC()
	{
		var degree_id =$('#degree_id').val();
		//alert(degree_id); 
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>generate/getBatchbyDOC',
			data: {'degree_id':degree_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Date Of Closure--</option>';
			$('#date_of_closure').empty();
			$("#date_of_closure").append(option_brand+data);
			 }
		});
	}
	
	function getCourseList()
	{
		
		$('#courseList').show(); 
		$('#studentList').show(); 
		var $form = $("#registration_form");
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>examdate/getCourseList',
			data: $form.serialize(),
			success: function(data){
				//alert(data); 
				$(".exam_dates").datepicker({format: 'dd-mm-yyyy',autoclose: true});
				 
				 $('#tr_list').html(data);
		
			 }
		});
	}
    function saveExamDate()
	{
		var $form = $("#registration_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>examdate/saveExamDate',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
				alert("Date successfully assigned to respective course."); 
				//$('#tr_list').html(data);
		
			 }
		});
	}
	
   $("#registration_form").validate({
		rules: {
			campus_id: "required",
			program_id: "required",
			degree_id: "required",
			batch_id: "required",
			exam_date: "required"
			
			
			
			
		},
		messages: {
			campus_id: "Select Campus Name",
			program_id: "Select Program Name",
			degree_id:"Select Degree Name",
			batch_id:"Select Semester Name",
			exam_date:"Select Semester Name"
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	
	//select all checkboxes
$("#select_all").change(function(){  //"select all" change 
    $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
});

//".checkbox" change 
$('.checkbox').change(function(){ 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(false == $(this).prop("checked")){ //if this item is unchecked
        $("#select_all").prop('checked', false); //change "select all" checked status to false
    }
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){
        $("#select_all").prop('checked', true);
    }
});
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 