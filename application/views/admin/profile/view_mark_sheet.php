<?php //p($user_row); exit;?>
<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
        $sessdata= $this->session->userdata('sms');
		//p($sessdata); exit;
		$id = $sessdata[0]->id;
		if($sessdata[0]->role_id == 5){
			$role_id = 1;
			$campus_id = $user_row->campus_id;
			$batch_id = $user_row->batch_id;
			$degree_id = $user_row->degree_id;
		}else{
			$role_id = $sessdata[0]->role_id;
			$campus_id = $sessdata[0]->campus_id;
			$batch_id = $sessdata[0]->batch_id;
			$degree_id = $sessdata[0]->degree_id;
		}
?>
<style >
.error{
 color:red;	
}
.box-body,#activitycalendar{
	height: 720px;
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

      <div class="row">
      
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
       
			
            <div class="tab-content">
			
				   <div class=" active tab-pane mydetails" id="marksheet">
			  
			    <form  class="form-horizontal" method="post" name="marksheet_form" target="fred" id="marksheet_form" action="<?php echo base_url();?>process/viewReport" enctype="multipart/form-data">
				<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $id;?>">
				<input type="hidden" class="form-control" id="user_role" name="user_role" value="<?php echo $role_id;?>">
				<input type="hidden" class="form-control" id="campus_id" name="campus_id" value="<?php echo $campus_id;?>">
				<input type="hidden" class="form-control" id="batch_id" name="batch_id" value="<?php echo $batch_id;?>">
				<input type="hidden" class="form-control" id="degree_id" name="degree_id" value="<?php echo $degree_id;?>">
                 <div class="form-group">
                  <input type="hidden" name="program_id" id="program_id" class="form-control" value="<?php echo $user_row->program_id;?>" />
				    <label for="inputName" class="col-sm-1 control-label" id="semester" name="semester">Semester</label>
                    <div class="col-sm-3">
                      <select name="semester_id" id="semester_id" class="form-control" onchange="getMarksTable();">
						      <option value="">--Select Semester--</option>
							  <?php foreach($semesters as $semvalue){?>
							   <option value="<?php echo $semvalue['semester_id'];?>"><?php echo $semvalue['semester_name'];?></option>
							 <?php }?>
							 
					  </select> 
                    </div>
					
					
                    <!--<div class="col-sm-3">
                      <select name="marks_type" id="marks_type" class="form-control" onchange="getMarks();">
						      <option value="">--Select Marks --</option>
							  <option value="1">Internal Marks</option>
							  <option value="2">External Marks</option>
					  </select> 
                    </div>-->
					
					<div class="col-sm-2">
                       <input type="submit" class="btn btn-success" id="marksheet" name="marksheet" value="SHOW MARKSHEET"/>
                    </div>
						<div class="col-sm-2">
                       <input type="submit" class="btn btn-success" id="download_marksheet"  name="download_marksheet" value="DOWNLOAD MARKSHEET"/>
                    </div>
				 </div>
				 
				
				</form>
				 </div>
				 
			 
				 
                
			 </div>
				  
				<iframe style="display:none" id="fred" name="fred" style="border:1px solid #666CCC" title="PDF Viewer" src="" frameborder="1" scrolling="auto" height="800" width="100%" ></iframe>
                
              </div>
			  
			  
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

  


</section>
	
	
	
  </div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript" src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-year-calendar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap-year-calendar.min.css" />
  <!-- /.content-wrapper -->
  <script type="text/javascript">
  


$(function() {
    var currentYear = new Date().getFullYear();
var holidayData=[];
    $('#activitycalendar').calendar({
        enableContextMenu: <?php if($managelist == 1){?>true<?php }else{?> false<?php }?>,
        style: 'background',
        enableRangeSelection: true,
		
        
        mouseOnDay: function(e) {
            if(e.events.length > 0) {
                var content = '';
                
                for(var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                                    + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                   
                                + '</div>';
                }
            
                $(e.element).popover({
                    trigger: 'manual',
                    container: 'body',
                    html:true,
                    content: content
                });
                
                $(e.element).popover('show');
            }
        },
        mouseOutDay: function(e) {
            if(e.events.length > 0) {
                $(e.element).popover('hide');
            }
        },
        dayContextMenu: function(e) {
            $(e.element).popover('hide');
        },
		customDayRenderer: function(element, date) {
			
			//$(element).css('background-color', 'red');
			//$(element).css('color', 'white');
			//$(element).css('border-radius', '15px');
		},
        dataSource: []
    });
    
    $('#save-event').click(function() {
        saveEvent();
    });
});
 
	
function loadHolidays(degree_id){
	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getmyattendance',
			data: {'degree_id':degree_id},
			success: function(data){
				data = jQuery.parseJSON(data);
				$.each(data, function(i, item) {
					startDateArr = item.startDate.split("-")
					endDateArr = item.endDate.split("-")
					startDate = new Date(startDateArr[0], startDateArr[1]-1, startDateArr[2]);
					endDate = new Date(endDateArr[0], endDateArr[1]-1, endDateArr[2]);
					data[i].id = parseInt(item.id);
					data[i].startDate = startDate;
					data[i].endDate = endDate;
					data[i].color = item.color;
					
					//data[i].endDate = JSON.stringify(item.endDate);
				});
				$('#activitycalendar').data('calendar').setDataSource(data);
			}
	});	
	
}
	$(document).ready(function() {
		
		 
		$('#degree_semestersubmit').click(function(){
			if($('#degree_semester_id').val() >0){
				$("#activitycalendar").removeClass('hidden');
					loadHolidays($(this).val());
			}else{
				alert('Please select semester');
				$("#activitycalendar").addClass('hidden');
			}
			
			return false;
		});
		$('#degree_semester_id').on('change',function(){
			if($(this).val() >0){
				$("#activitycalendar").removeClass('hidden');
					loadHolidays($(this).val());
			}else{
				$("#activitycalendar").addClass('hidden');
			}
		});
	});
	</script>
  <script type="text/javascript">
	
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
	var url = window.location.href;
	var activeTab = url.substring(url.indexOf("#") + 1);
	$('a[href="#'+ activeTab +'"]').tab('show');
	setTimeout(function() {
        $(window).scrollTop(0 );
    }, 5);
	$('.nav-tabs a').click(function(){
		$('#fred').hide();
	});
	$('.treeview-menu a').click(function(){
		$('#fred').hide();
		 var scrollHeight = $(document).scrollTop();
		var url = $(this).attr('href');
		var activeTab = url.substring(url.indexOf("#") + 1);
		$('a[href="#'+ activeTab +'"]').tab('show');
		setTimeout(function() {
			$(window).scrollTop(scrollHeight );
		}, 5);
		
	});
	});
	function getMarksTable11()
	{
		 var semester_id=$('#semester_id').val();
		 if(semester_id=='1'){
			$('#bvsc').show();
			$('#btech').hide();
		}
		 else{
			$('#btech').show();
			$('#bvsc').hide();
		}
	}
	function getMarks()
	{   var semester_id=$('#semester_id').val();
	//alert(uploadType); 
	      if(semester_id=='1'){
			$('#bvsc').show();
			$('#btech').hide();
		}
		 else{
			$('#btech').show();
			$('#bvsc').hide();
		}
		var $form =$("#report_form");
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>process/getMarks',
			data: $form.serialize(),
			success: function(data){
				//alert(data); return false;
				
				$('.trlist').empty();	
				$('.trlist').append(data);
			 }
		});
	}
	
    function sendFeedBack(){
		var sender_id =$('#sender_id').val();
		var sender_role =$('#sender_role').val();
		var sender_campus =$('#sender_campus').val();
		var feedback_subject =$('#feedback_subject').val();
		var feedback_message =$('#feedback_message').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>process/sendFeedback',
			data: {'sender_id':sender_id,'sender_campus':sender_campus,'feedback_subject':feedback_subject,'feedback_message':feedback_message},
			success: function(data){
				//alert(data); 
				if(data==1){
					//alert('hello');
					alert('Feedback Send Successfully.');
					$('#feedback_form')[0].reset();
				}
				else{
					alert('Feedback Not Send Successfully.');
					$('#feedback_form')[0].reset();
				}
			
			 }
		});
		
	}
	function getDegreebyProgram()
	{
		var program_id =$('#program_id').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>course/getDegreebyProgram',
			data: {'program_id':program_id},
			success: function(data){
				//alert(data); 
			var  option_brand = '<option value="">--Select Degree--</option>';
			$('#degree_id').empty();
			$("#degree_id").append(option_brand+data);
			 }
		});
	}
   $("#campus_and_degree_form").validate({
		rules: {
			campus_id: "required",
			program_id: "required",
			degree_id: "required"
		
			
			
		},
		messages: {
			campus_id: "Select Campus Name",
			program_id: "Select Program Name",
			degree_id:"Select Degree Name"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	$("#marksheet_form").validate({
		rules: {
			
			program_id: "required",
			semester_id: "required"
		
			
			
		},
		messages: {
			
			program_id: "Select Program Name",
			semester_id:"Select Semester"
		
			
				
		},
		submitHandler: function (form) {
			$('#fred').show();
				form.submit();
		}
	});	
	$("#hall_ticket").validate({
		rules: {
			
			program_id: "required",
			semester_id: "required"
		
			
			
		},
		messages: {
			
			program_id: "Select Program Name",
			semester_id:"Select Semester"
		
			
				
		},
		submitHandler: function (form) {
			$('#fred').show();
				form.submit();
		}
	});	
	</script>	
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 