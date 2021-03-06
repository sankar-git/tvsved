<?php 

 $this->load->view('admin/helper/header');?>
 
  <script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-multiselect.css" type="text/css"/>
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
            <!-- form start -->
            <form role="form" name="permission_form" id="permission_form" method="post" action="<?php echo base_url();?>role/saveMenu" enctype="multipart/form-data">
              <div class="box-body">
			    <div class="row">
					<div class="form-group col-md-3">
					  <label for="degree_code">Role<span style="color:red;font-weight: bold;">*</span></label>
					  <select name="role_id" id="role_id" class="form-control" onchange="getUser();">
						  <option value="">--Select Role--</option>
						  <?php foreach($roles as $role){?>
						  <option value="<?php echo $role->id;?>"><?php echo $role->role_name;?></option>
						<?php }?>
						<option value="5">Parent</option>
					  </select>
					</div>
                    <div class="form-group col-md-3">
                        <label for="program">Campus<span style="color:red;font-weight: bold;">*</span></label>
                        <select name="campus_id" id="campus_id" class="form-control" onchange="getProgram(),getUser();">
                            <option value="">--Select Campus--</option>
                            <?php foreach($campuses as $campus){
                                if($campus_id == $campus->id)
                                    $selected="selected";
                                else
                                    $selected="";
                                ?>
                                <option value="<?php echo $campus->id; ?>" <?php echo $selected;?>><?php echo $campus->campus_name; ?></option>

                            <?php } ?>
                        </select>
                    </div>

                        <div class="form-group col-md-3 student_sec" >
                            <label for="program_id">Program<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="program_id" id="program_id" class="form-control" onchange="getDegreebyProgram();">
                                <option value="">--Select Program--</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 student_sec">
                            <label for="degree">Degree<span style="color:red;font-weight: bold;">*</span></label>
                            <select class="form-control" name="degree_id" id="degree_id" onchange="getSemesterbyDegree(),getUser();" >
                                <option value="">--Select Degree--</option>

                            </select>
                        </div>
                        <div class="form-group col-md-3 student_sec">
                            <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="batch_id" id="batch_id" class="form-control" onchange="getUser();">
                                <option value="">Select Batch</option>
                                <?php foreach($batches as $batch){
                                    if($batch_id == $batch->id)
                                        $selected="selected";
                                    else
                                        $selected="";
                                    ?>
                                    <option value="<?php echo $batch->id;?>" <?php echo $selected;?>><?php echo $batch->batch_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

					<div class="form-group col-md-3" style="margin-top:20px">
					  <label for="user_id">User<span style="color:red;font-weight: bold;">*</span></label>
					  <select class="selectpicker form-control" multiple data-live-search="true" name="user_id[]" id="user_id"  onchange="getmenu()">
					  </select>
					</div>
					
               </div>
			    <div class="row">
				 <label class="box-header fa fa-fa-primary mycolor"  align="center">All Admin Pages</label>
				   <div class="box-icon"></div>
                </div>                       
      <div class="control-group" align="left">
       <div class="row">
			 <div class="col-lg-6">
			 <h4 class="assign1">Assign Menu</h4>
			 
			     <?php   foreach ($mainmenu as $key => $value) 
                                    { 
                                        if($value->parentid==0)
                                        {
                                            echo '<p><input type="checkbox" id="menu'.$value->id.'" onclick="allmenu('.$value->id.')" value="'.$value->id.'"> '.$value->menuname.'</p>'; 

                                            foreach ($mainmenu as $key => $val) 
                                            { 
                                                if($val->parentid==$value->id)
                                                {
                                                    echo '<p style="margin-left: 30px;"><input type="checkbox" value="'.$value->id.'#'.$val->id.'" class="submenu'.$value->id.'" name="menu[]"> '.$val->menuname.'</p>'; 
                                                } 
                                            }
                                        } 
                                    } 
                                    ?>
								
			</div>
			<div class="col-lg-6" id="assignmenu" ></div>
			
        </div>
        </div>
					
               </div>
			   
			   
			  </div>
              <!-- /.box-body -->

              <div class="box-footer">
               <input type="submit" name="rolesubmit" value="Submit" class="retailer_btn"/>
				
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
	
	$(document).ready(function() {
	    $('#role_id').change(function(){
	       if( $(this).val() == 1 ||  $(this).val() == 5 ||  $(this).val() == 6){
	           $('.student_sec').show();
           }else{
               $('.student_sec').hide();
           }
        });
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		$('#user_id').multiselect({
			        	includeSelectAllOption: true,
			        	enableFiltering: true,
						buttonWidth: '345px',
                        maxHeight: 350
						
			        });
	});
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
  function getUser()
  {

	 var role_id =$('#role_id').val();
	 var degree_id =$('#degree_id').val();
	 var campus_id =$('#campus_id').val();
	 var program_id =$('#program_id').val();
	 var batch_id =$('#batch_id').val();
	 $.ajax({
			type:'POST',
			url:'<?php echo base_url();?>permissions/getUserByRole',
			data: {'role_id':role_id,'degree_id':degree_id,'program_id':program_id,'campus_id':campus_id,'batch_id':batch_id},
			success: function(data){
                var  option_student = '';
                $('#user_id').empty();
                $("#user_id").append(option_student+data);
                $('#user_id').multiselect('rebuild');
			},
		});
  }
   $("#permission_form").validate({
		rules: {
			role_id: "required",
			user_id: "required"
			
			
		},
		messages: {
			role_id: "User  Type Is Required.",
			user_id:"User Name Is Reqiured."
			
			
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
function allmenu(ids){

//alert($('#menu'+ids).prop('checked'));
    
    if($('#menu'+ids).prop('checked')==true)
    {
        $('.submenu'+ids).prop('checked', true);
    }
    else
    {
        $('.submenu'+ids).prop('checked', false);
    }
 }
    function getmenu(){
    var user_id=$('#user_id').val();
    if(user_id=='')
    {
        $('#menu').hide();
    }
    else
    {
        $('#menu').show();

        $.ajax({
        url: '<?php echo base_url()?>role/getassignmenu',
        type: 'POST',
        data: {'user_id': user_id},
        success: function(data){
               //alert(data);
           $("#assignmenu").empty();
           $("#assignmenu").append('<h4 class="he">Assigned Menu</h4>'+data);
           
       }
   });

    }
 }
 function removemenu(ids)
{
    var empid=$('#user_id').val();
    var r = confirm("Confirmed remove this menu!");
    if (r == true) 
    {
        $.ajax({
        url: '<?php echo base_url()?>role/removeassignmenu',
        type: 'POST',
        data: {'empid': empid,'menuid': ids},
        success: function(data)
        {    alert(data);
            $('#'+ids).prop('checked', false);
            $('#c'+ids).remove();
            $('#r'+ids).remove();
            $('#m'+ids).html('Successfully remove this menu!');
            setTimeout(function(){ $('#m'+ids).remove(); }, 3000);
            
        }
        });  
    } 
    else 
    {
        return false;
    }

 }
 
 
function permitted_page(userid)
{
	//alert(userid); 
	//var userid= $("input[name='subadmin']:checked").val()	;
	var userid= $("#user_id").val()
	//var roleid= $("#role").val()	;
	//alert(roleid);
	var dataString = 'userid='+ userid;
		$.ajax({
				  type: "POST",
				  dataType:'json',  
				 
				  url:'<?php echo base_url();?>permissions/permitted_pages_view',
				  data: dataString,
				  async: false,  
				  success: function(data) { 
                  //alert(data);				  
					var permission = data.permited_page;
					console.log(permission.length);	
					var checkboxarr = document.getElementsByName("permission_page[]");
						for(var ichecbox=0;ichecbox<checkboxarr.length;ichecbox++ )
						{
							var jsCheckBox = checkboxarr[ichecbox];
							var objCheckBx =$(jsCheckBox);	
							var spanelement = objCheckBx.parent();
							spanelement.removeClass("checked");
							objCheckBx.prop('checked', false); 
						}
						
					if(permission.length==0)
					{
						var checkboxarr = document.getElementsByName("permission_page[]");
						for(var ichecbox=0;ichecbox<checkboxarr.length;ichecbox++ )
						{
							var jsCheckBox = checkboxarr[ichecbox];
							var objCheckBx =$(jsCheckBox);	
							var spanelement = objCheckBx.parent();
							spanelement.removeClass("checked");
							objCheckBx.prop('checked', false); 
						}
						
					}else{
						
					 var checkboxarr = document.getElementsByName("permission_page[]");
						for(var ichecbox=0;ichecbox<checkboxarr.length;ichecbox++ )
						{
							var jsCheckBox = checkboxarr[ichecbox];
							var objCheckBx =$(jsCheckBox);	
							var spanelement = objCheckBx.parent();
							var bChecked=false;
								for(var ipermision=0;ipermision<permission.length;ipermision++)
								{	
										if(checkboxarr[ichecbox].id == permission[ipermision].page_id)
										{
											bChecked=true;
										}
										
										if(bChecked)
										{
											spanelement.addClass("checked");
											objCheckBx.prop('checked', true); 		
										}
											
								 }
							
						}
					}
							
							
				  }
		});
}
	
	</script>	
  
   
  
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 