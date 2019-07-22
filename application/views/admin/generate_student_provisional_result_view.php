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
                      <select class="form-control" name="degree_id" id="degree_id" onchange="getBatchbyDegree(),getBatchbyDOS();">
                          <option value="">--Select Degree--</option>
                           
                      </select>
                    </div>
                    
                    <div class="form-group col-md-3">
                      <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
                      <select name="batch_id" id="batch_id" class="form-control" onchange="getStudentList();">
                          <option value="">Select Batch</option>
                        
                      </select>
                    </div>
                
               </div>
               
                <div class="row">
                <div class="form-group col-md-3">
                      <label for="exampleInputEmail1">Student<span style="color:red;font-weight: bold;">*</span></label>
                      <select name="student_id" id="student_id" class="form-control">
                          <option value="">Select Student</option>
                        
                      </select>
                </div>
                <div class="form-group col-md-3">
                      <label for="month">Month<span style="color:red;font-weight: bold;">*</span></label>
                       <select class="form-control" name="month" id="month">
                       
                          <option value="">Select Month</option>
                        <?php for($i=1;$i<=12;$i++){ ?>
                        <option value="<?php echo date('F', mktime(0,0,0,$i, 1, date('Y')));?>"><?php echo date('F', mktime(0,0,0,$i, 1, date('Y')));?></option>
                        <?php }?>
                      </select>
                    </div>
                     <div class="form-group col-md-3">
                      <label for="year">Year<span style="color:red;font-weight: bold;">*</span></label>
                       <select class="form-control" name="year" id="year">
                       
                          <option value="">Select Year</option>
                            <?php for($i=date('Y')-10;$i<=date('Y');$i++){?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php }?>
                        
                      </select>
                    </div>
             </div>
             <div class="row">
             <div class="form-group col-md-3">
                     
                      
                      <input type="submit"  name="provisional_result" id="provisional_result" value="Generate" class="btn btn-primary" formtarget="_blank">
                        
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
  $(document).ready(function() {
        $("#start_date").datepicker({format: 'dd-mm-yyyy',autoclose: true});
        $("#date_of_closure11").datepicker({format: 'dd-mm-yyyy',autoclose: true});
        
    });
    
    function getProgramByCampus()
    {
      var campus_id =$('#campus_id').val();
      //alert(campus_id); 
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
        var program_id =$('#program_id').val(); var campus_id =$('#campus_id').val();
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
    function getStudentList()
    {
        var $form = $("#registration_form");
        
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>provisional/getStudentList',
            data: $form.serialize(),
            success: function(data){
                //alert(data); 
            var  option_brand = '<option value="">--Select Student--</option>';
            $('#student_id').empty();
            $("#student_id").append(option_brand+data);
        
             }
        });
    }
    

    function getPrint()
    {
        //alert("hello"); 
        $('#courseList').show(); 
        var $form = $("#registration_form");
        
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>generate/getPrint',
            data: $form.serialize(),
            success: function(data){
                //alert(data); 
                 //$('#tr_list').html(data);
        
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
  
  
 