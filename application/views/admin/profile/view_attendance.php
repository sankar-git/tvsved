<?php //p($user_row); exit;?>
<?php $this->load->view('admin/helper/header');?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
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
	height: 300px;
}
.course_txt{
    background-color:#ccc !important;
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
			<div class="tab-pane active" id="attendance_con">
				<a class="btn btn-success" onclick="showDayWiseAttendance()" style="padding:5px 8px">Day Wise Attendance</a>
				<a class="btn btn-primary" id="attendance_rangebtn" onclick="showRangeWiseAttendance()" style="padding:5px 8px">Multiple Date Range Attendance</a>
				<input type="hidden" class="form-control" id="campus_id" name="campus_id" value="<?php echo $user_row->campus_id;?>">
				<input type="hidden" class="form-control" id="section_id" name="section_id" value="<?php echo $user_row->section_id;?>">
				<input type="hidden" class="form-control" id="student_id" name="student_id" value="<?php echo $user_row->user_id;?>">
				   <input type="hidden" class="form-control" id="role_id" name="role_id" value="">
				   <input type="hidden" class="form-control" id="semester_id" name="semester_id" value="<?php echo $user_row->semester_id;?>">
				   <input type="hidden" class="form-control" id="degree_id" name="degree_id" value="<?php echo $user_row->degree_id;?>">
			</div>
			
            
					
			 <div class="tab-pane  hidden" id="dayWiseattendance">
                <form class="form-horizontal" target="fred" id="frmattendance" action="" name="frmattendance"  method="POST" >
				  <div class="form-group">
			       
				    <div class="col-sm-12"><div id="datepicker"> </div></div>
					
					<!--<div class="col-sm-4">
                      <button type="sbmit" class="btn btn-success" id="degree_semestersubmit"  name="degree_semestersubmit"/>View</button><span class="feedback" id="feedback" ></span>
                    </div>-->
					
                 
				  
				   <div id='activitycalendar' class="hidden" ></div>
			 </div>
			 </form>
			     <div id="attendanceList" > 
				  </div>
				  <div id="container" ></div>
				
                
              </div>
			   <div class="tab-pane active " id="rangeWiseattendance">
                <form class="form-horizontal" target="fred" id="frmattendancerange" action="" name="frmattendancerange"  method="POST" >
				  <div class="form-group">
			      
				    <div class="col-sm-12">&nbsp;</div>
				    <div class="col-sm-4"><label for="attendance_range">Attendance Range&nbsp;</label><input type="text" id="attendance_range" name="attendance_range" value="<?php echo date('d-m-Y', strtotime('-7 days', strtotime(date('Y-m-d')))).' - '.date('d-m-Y');?>
" /></div><div class="col-sm-2"><a class="btn btn-primary" id="attendance_rangebtn" onclick="displayRangeView();" style="padding:5px 8px">Show</a></div>
					
					<!--<div class="col-sm-4">
                      <button type="sbmit" class="btn btn-success" id="degree_semestersubmit"  name="degree_semestersubmit"/>View</button><span class="feedback" id="feedback" ></span>
                    </div>-->
					
                 
				  
				   <div id='activitycalendar' class="hidden" ></div>
			 </div>
			 </form>
			      <div id="attendanceRangeList" >
				  </div>
				  <div  id="containerRange"></div>
                
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
   $(document).ready(function() {
		// $('#example').DataTable();
		//var start = moment().subtract(7, 'days');
		//var end = moment();
		displayRangeView();
	  $('#attendance_range').daterangepicker({
		  // minDate: start,
			//maxDate: end,
		  autoUpdateInput: false,
		  opens: 'right',
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
  function displayRangeView(){
	  if($('#attendance_range').val()==''){
		  $('#attendance_range').focus();
		  return false;
	  }
	  getAttendance($('#attendance_range').val(),'range');
  }
  function showDayWiseAttendance(){
	   $('#rangeWiseattendance').removeClass('active').addClass('hidden');
	  $('#dayWiseattendance').removeClass('hidden').addClass('active');
	 
  }
  function showRangeWiseAttendance(){
	   $('#dayWiseattendance').removeClass('active').addClass('hidden');
	  $('#rangeWiseattendance').removeClass('hidden').addClass('active');
  }
 $( function() {
    $( "#datepicker" ).datepicker();
	$('#datepicker').datepicker().on('changeDate', function (ev) {
		getAttendance(ev.format(0,"dd-mm-yyyy"),'single');
		});
  } );
function getAttendance(attendance_date,attType){
	var student_id = $('#student_id').val();
	var degree_id = $('#degree_id').val();
	var semester_id = $('#semester_id').val();
	var campus_id = $('#campus_id').val();
	var section_id = $('#section_id').val();
	$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>attendance/getmyattendance',
			data: {'type':attType,'semester_id':semester_id,'student_id':student_id,'degree_id':degree_id,'campus_id':campus_id,'section_id':section_id,'attendance_date':attendance_date},

			success: function(data){
				 var data = $.parseJSON(data);
				if(attType == 'single'){
					$('#attendanceList').html(data.table);
                    var dataDate= [];
                    var resPassData= [];
                    var resFailData= [];
                    var resNaData= [];
                    $.each(data.datewise, function(i, item) {
                        dataDate.push(i);
                        resPassData.push(item.pass);
                        resFailData.push(item.fail);
                        resNaData.push(item.na);
                    })
					getchart(dataDate,resPassData,resFailData,resNaData,'container');
					
						//getchart(attendance_date,data.present,data.absent,'container');
						$('#container').show();


				}else{
					$('#attendanceRangeList').html(data.table);
					var dataDate= [];
					var resPassData= [];
					var resFailData= [];
					var resNaData= [];
					$.each(data.datewise, function(i, item) {
						dataDate.push(i);
						resPassData.push(item.pass);
						resFailData.push(item.fail);
						resNaData.push(item.na);
					})
					getchart(dataDate,resPassData,resFailData,resNaData,'containerRange');
				}
			}
			
	});
}

function getchart(date,present,absent,notapplicable,type)
{
	//date = '21-01-2019';
Highcharts.chart(type, {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Attendance Graph'
    },
    xAxis: {
        categories: date
    },
    yAxis: {
         min: 1,
		max: 8,
		
startOnTick: false,
tickInterval: 1,
        title: {
            text: 'Total No. Of Periods'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
	colors: ['#98d3af', '#cd605d', '#c6c6c6'],
    series: [{
        name: 'Present',
        data: present
    }, {
        name: 'Absent',
        data: absent
    }, {
        name: 'N/A',
        data: notapplicable
    }]
});	
	
	
}
$(function() {
    var currentYear = new Date().getFullYear();
var holidayData=[];
    $('#activitycalendar').calendar({
        enableContextMenu: <?php if($managelist == 1){?>true<?php }else{?> false<?php }?>,
        style: 'background',
        enableRangeSelection: true,
        format: 'DD-MM-YYYY',
        
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
  
  
 