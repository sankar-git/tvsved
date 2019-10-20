<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>
<style >
.error{
 color:red;	
}
</style>

    <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
        rel="stylesheet" type="text/css" />
    <script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
        type="text/javascript"></script>
		
	<script src="https://cdnjs.cloudflare.com/ajax/libs/multiple-select/1.2.0/multiple-select.min.js"></script>
      
    <link href="https://cdnjs.cloudflare.com/ajax/libs/multiple-select/1.2.0/multiple-select.css" rel="stylesheet"/>
        

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
			 <form role="form" name="batch_form" id="batch_form"  method="post" action="<?php echo base_url();?>message/sendMessage" enctype="multipart/form-data">
            <div class="box-body">
			   <div class="row">
				<div class="form-group col-md-3">
					  <label for="user_type">User Type<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="user_type" id="user_type" class="form-control" onchange="loadSection();"  >
						  <option value="">User Type</option>
						  <?php foreach($roles as $role){?>
						  <option value="<?php echo $role->id;?>"><?php echo $role->role_name;?></option>
						  <?php } ?>
					  </select>
					</div>
				 <div class="form-group col-md-3">
                            <label for="campus">Campus<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampusId(),getTeacher();">
                                <option value="">--Select Campus--</option>
                                <?php foreach($campuses as $campus){?>
                                    <option value="<?php echo $campus->id; ?>" <?php if($campus->id == @$campus_id){ ?> selected <?php }?>><?php echo $campus->campus_name; ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3 student_section">
                            <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
                                <option value="">--Select Program--</option>
                               
                            </select>
                        </div>

				    <div class="form-group col-md-3 student_section">
					  
					  <input type="hidden" name="id" id="id" value="<?php echo @$feedbacks_result->id;?>" />
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree();" >
						  <option value="">--Select Degree--</option>
						  
						 
					  </select>
					</div>
					<div class="form-group col-md-3 student_section">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
					<div class="form-group col-md-3 student_section">
					  <label for="batch">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" onchange="getUsers();" >
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>" <?php if($batch->id == @$batch_id){ ?> selected <?php }?>><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3 other_section" style="display:none" >
					  <label for="discipline">Discipline<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="discipline" id="discipline" class="form-control" onchange="getUsers();" >
						  <option value="">Select Discipline</option>
						 <?php foreach($disciplines as $discipline){?>
					      <option value="<?php echo $discipline->id;?>"><?php echo $discipline->discipline_name;?></option>
					     <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3" style="margin-top:15px" >
					  <label for="degree_code">User<span style="color:red;font-weight: bold;">*</span></label>
					 <select  class="form-control" name="userlist[]" id="userlist" multiple="multiple">
						
					 </select>
					 
					</div>
					</div>
					<div class="row">
					<div class="form-group col-md-6">
					  <label for="message">Message<span style="color:red;font-weight: bold;">*</span></label>
					  <textarea type="text" class="form-control" maxlength="160" id="message" name="message" placeholder="Enter Message"></textarea>
					</div>
					<div class="form-group col-md-6" style="margin-top:30px;">
					
				  <button type="submit" class="btn btn-success">Send</button>
				 <button type="reset" class="btn btn-danger">Reset</button>
				  
				  </div>
				  </div>
					<!--<div class="form-group col-md-3">
					  <label for="batch">Question<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="question" id="question" class="form-control" onchange="getchartByQuestionid();">
						  <option value="">Select Question</option>
						 
					  </select>
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
  function loadSection(){
	  if($('#user_type').val() == 1 || $('#user_type').val() == 6){
		$('.student_section').show();
		$('.other_section').hide();
	  }else if($('#user_type').val()>0){
		$('.student_section').hide();
		$('.other_section').show();
	  }else{
		  $('.student_section').hide();
		$('.other_section').hide();
	  }
  }
  function getProgramByCampusId()
    {
        var campus_id =$('#campus_id').val();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>course/getProgramByCampusId',
            data: {'campus_id':campus_id},
            success: function(data){

                var  option_brand = '<option value="">--Select Program--</option>';
                $('#program_id').empty();
                $("#program_id").append(option_brand+data);
				<?php if(@$program_id>0){?>
				$("#program_id").val(<?php echo @$program_id;?>);
				getDegreebyProgram();
				<?php } ?>
            }
        });
    }
	function getTeacher()
    {
        var campus_id =$('#campus_id').val();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>attendance/get_teacher',
            data: {'campus_id':campus_id},
            success: function(data){

                var  option_brand = '<option value="">--Select Teacher--</option>';
                $('#teacher_id').empty();
                $("#teacher_id").append(option_brand+data);
				<?php if(@$teacher_id>0){?>
				$("#teacher_id").val(<?php echo @$teacher_id;?>);
				<?php } ?>
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
				<?php if(@$degree_id>0){?>
				$("#degree_id").val(<?php echo @$degree_id;?>);
				getSemesterbyDegree();
				<?php } ?>
                
            }
        });
    }
    function getSemesterbyDegree(){
        var degree_id =$('#degree_id').val().toString();
        //getDisciplineByDegreeId();
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
                <?php if(@$semester_id>0){?>
				$("#semester_id").val(<?php echo @$semester_id;?>);
				<?php } ?>
            }
        });
    }

		$().ready(function(){
			if($('#user_type').val()>0){
				loadSection();
			}
			<?php if(@$campus_id>0){?>
					getProgramByCampusId();
					getTeacher();
			<?php } ?>
			
			
		});
   function getValueUsingClass(){
	/* declare an checkbox array */
	var chkArray = [];
	/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
	$(".chk:checked").each(function() {
		chkArray.push($(this).val());
	});
	/* we join the array separated by the comma */
	var selected;
	selected = chkArray.join(',') ;
	/* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
	//if(selected.length > 0){
		//alert("You have selected " + selected);	
	//}else{
		//alert("Please at least check one of the checkbox");	
	//}
	
	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>message/getUsers',
			data: {'userType':selected},
			success: function(data){
			//alert(data); return false;
			$("#userlist").empty();
			//$("#userlist").attr("multiple","multiple");
			//$("#userlist").multiselect('destroy');
			$("#userlist").append(data);
			
			$('#userlist').multiselect('rebuild');
			 }
		});
}
  
	function getUsers()
	{
		
		//alert(selectedGroups); return false;
		var userType = $("#user_type").val();
		//alert(userType); return false;
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>message/getUsers',
			data: $('#batch_form').serialize(),
			success: function(data){
				//alert(data); return false;
				$("#userlist").empty();
				//$("#userlist").attr("multiple","multiple");
				//$("#userlist").multiselect('destroy');
				$("#userlist").append(data);
				$('#userlist').multiselect('rebuild');
			 }
		});
		
	}
	
	$(document).ready(function() {
		$('#userlist').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			buttonWidth: '250px',
			maxHeight: 350
		});
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});

   $("#batch_form").validate({
		rules: {
			user_type: "required",
			campus_id: "required",
			userlist: "required"
			
			
		},
		messages: {
			user_type: "User Type is required..",
			campus_id: "Campus is required.",
			userlist:"User is reqiured." 
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 