<?php $this->load->view('admin/helper/header');?>
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
            <form role="form" name="feedback_form" id="feedback_form"  id="attendance_form" method="post" enctype="multipart/form-data">
            <div class="box-body">
			    <div class="row">
				 <div class="form-group col-md-3">
                            <label for="campus">Campus<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampusId(),getTeacher();">
                                <option value="">--Select Campus--</option>
                                <?php foreach($campuses as $campus){?>
                                    <option value="<?php echo $campus->id; ?>"><?php echo $campus->campus_name; ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
                                <option value="">--Select Program--</option>
                                <?php //foreach($programs as $program){?>
                                <!--<option value="<?php //echo $program->id; ?>"><?php //echo $program->program_name; ?></option>-->

                                <?php //} ?>
                            </select>
                        </div>

				    <div class="form-group col-md-3">
					  
					  <input type="hidden" name="id" id="id" value="<?php echo @$feedbacks_result->id;?>" />
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(),getQuestions();" >
						  <option value="">--Select Degree--</option>
						  <?php foreach($degrees as $degree){?>
					  <option value="<?php echo $degree->id; ?>" <?php if($degree->id == @$degree_id){ ?> selected <?php }?> ><?php echo $degree->degree_name; ?></option>
					 
					  <?php } ?>
						 
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control" onchange="getQuestions();">
						  <option value="">Select Semester</option>
						  <?php foreach($semesters as $semester){ ?>
						  <option value="<?php echo $semester->id;?>" <?php  if($semester->id == @$semester_id){ ?> selected <?php }?>><?php echo $semester->semester_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="batch">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" onchange="getQuestions();">
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>" <?php if($batch->id == @$batch_id){ ?> selected <?php }?>><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="batch">Teacher<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="teacher_id" id="teacher_id" class="form-control" onchange="getQuestions();">
						  <option value="">Select Teacher</option>
						  
					  </select>
					</div>
					
					<div class="form-group col-md-3">
					  <label for="batch">Question<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="question" id="question" class="form-control" onchange="getchartByQuestionid();">
						  <option value="">Select Question</option>
						 
					  </select>
					</div>
					
				</div>
		</div>
       <div id="piechart" style="width: 900px; height: 500px;"></div>
			  
            </form>
          </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
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
                
            }
        });
    }
		function getchartByQuestionid(){
			if($('#question').val()>0){
			location.href='<?php echo base_url();?>feedback/chart/'+$('#degree_id').val()+'/'+$('#semester_id').val()+'/'+$('#batch_id').val()+'/'+$('#teacher_id').val()+'/'+$('#question').val();
			}
			return false;
			
		}
		function getQuestions(){
			var degree_id =$('#degree_id').val();
			var semester_id =$('#semester_id').val();
			var batch_id =$('#batch_id').val();
			var teacher_id =$('#teacher_id').val();
			 // alert(campus_id); 
			 if(degree_id>0 && semester_id>0 && batch_id>0 && teacher_id>0){
				$.ajax({
					type:'POST',
					url:'<?php echo base_url();?>feedback/getQuestions',
					data: {'degree_id':degree_id,'semester_id':semester_id,'batch_id':batch_id},
					success: function(data){
						//alert(data); 
					var  option_brand = '<option value="">--Select Question--</option>';
					$('#question').empty();
					$("#question").append(option_brand+data);
					$("#question").val(<?php echo $question;?>);
					}
				});	
			 }else{
				 $('#question').empty();
				 var  option_brand = '<option value="">--Select Question--</option>';
				 $("#question").append(option_brand);
				 
			 }
		}
		$().ready(function(){
			if($('#batch_id').val()>0){
				$('#batch_id').trigger('change');
				
			}
			
		});
		<?php if(isset($result) && !empty($result)){ ?>
		 google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(<?php if(isset($result) && !empty($result)){ echo json_encode($result, JSON_NUMERIC_CHECK);}else{ echo "[[]]";}?>);

        var options = {
          title: 'Feedback Result',
		  animation:{
			duration: 1000,
			easing: 'out',
		  },

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

	  <?php } ?>
	  
     
      
	</script>
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 