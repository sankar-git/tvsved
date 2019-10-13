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
            <form role="form" name="feedback_form" id="feedback_form"  id="attendance_form" action="<?php echo  base_url();?>feedback/chart" method="post" enctype="multipart/form-data">
            <div class="box-body">
			    <div class="row">
				 <div class="form-group col-md-3">
                            <label for="campus">Campus<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampusId(),getTeacher();">
                                <option value="">--Select Campus--</option>
                                <?php foreach($campuses as $campus){?>
                                    <option value="<?php echo $campus->id; ?>" <?php if($campus->id == @$campus_id){ ?> selected <?php }?>><?php echo $campus->campus_name; ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="program">Program<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
                                <option value="">--Select Program--</option>
                               
                            </select>
                        </div>

				    <div class="form-group col-md-3">
					  
					  <input type="hidden" name="id" id="id" value="<?php echo @$feedbacks_result->id;?>" />
					  <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree();" >
						  <option value="">--Select Degree--</option>
						  
						 
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="semester_id" id="semester_id" class="form-control">
						  <option value="">Select Semester</option>
						  
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="batch">Batch<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="batch_id" id="batch_id" class="form-control" >
						  <option value="">Select Batch</option>
						  <?php foreach($batches as $batch){ ?>
						  <option value="<?php echo $batch->id;?>" <?php if($batch->id == @$batch_id){ ?> selected <?php }?>><?php echo $batch->batch_name;?></option>
						  <?php } ?>
					  </select>
					</div>
					<div class="form-group col-md-3">
					  <label for="batch">Teacher<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="teacher_id" id="teacher_id" class="form-control" >
						  <option value="">Select Teacher</option>
						  
					  </select>
					</div>
					<div class="form-group col-md-6">
					<div class="form-group col-md-2"><label for="show_result">&nbsp;</label><br/>
				   <input  type="submit" name="show_result" id="show_result" class="btn btn-success" value="Show" /></div>
				   <?php if(isset($result) && !empty($result)){ ?>
					&nbsp;&nbsp;
					<div class="form-group col-md-2"><label for="export_csv">&nbsp;</label><br/>
				   <input  type="submit" name="export_csv" id="export_csv" class="btn btn-success" value="Export CSV" />
				 </div>
					<?php } ?>
				  </div>
					<!--<div class="form-group col-md-3">
					  <label for="batch">Question<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="question" id="question" class="form-control" onchange="getchartByQuestionid();">
						  <option value="">Select Question</option>
						 
					  </select>
					</div>-->
					
					
				</div>
		</div>
       <div id="piechart" style="width: 900px; height: 500px;"></div>
			  <div id="columnchart_material" style="margin-left:50px;width: 950px; height: 700px;"></div>

            </form>
          </div>
	   <!-- ./col -->
      </div>
      <!-- /.row -->
	  
      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php if(isset($result) && !empty($result)){ ?>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <?php } ?>
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
		//function getchartByQuestionid(){
			//location.href='<?php echo base_url();?>feedback/chart/'+$('#campus_id').val()+'/'+$('#program_id').val()+'/'+$('#degree_id').val()+'/'+$('#semester_id').val()+'/'+$('#batch_id').val()+'/'+$('#teacher_id').val()+'/'+Math.floor((Math.random() * 10) + 1);;
			//return false;
			
		//}
		
		$().ready(function(){
			<?php if(@$campus_id>0){?>
					getProgramByCampusId();
					getTeacher();
			<?php } ?>
			
			
		});
		<?php if(isset($result) && !empty($result)){ ?>
		 google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
	
	 google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawBarChart);
/*[
          ['Student', 'How was your semester exam Rate it yourself', 'How was the question paper Rate it from 1 to 5', 'Delivering subject(objective and coverage)'],
          ['AASHIKA K', 4, 5, 3],
          ['ABHOORVAN A', 4, 5, 3],
        ]
		*/
      function drawBarChart() {
        var data = google.visualization.arrayToDataTable(<?php if(isset($bar_result) && !empty($bar_result)){ echo json_encode($bar_result, JSON_NUMERIC_CHECK);}else{ echo "[[]]";}?>);

        var options = {
          chart: {
            title: 'Overall Feedback',
			animation:{
			duration: 5000,
			easing: 'out'
		  }
		   
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
      function drawChart() {

        var data = google.visualization.arrayToDataTable(<?php if(isset($result) && !empty($result)){ echo json_encode($result, JSON_NUMERIC_CHECK);}else{ echo "[[]]";}?>);

        var options = {
          title: 'Feedback Result',
		  animation:{
			duration: 5000,
			easing: 'out',
		  },
			colors: ['#DC3912', '#E67300', '#AAAA11', '#329262', '#109618']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

	  <?php } ?>
	  
     
      
	</script>
  
  
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 