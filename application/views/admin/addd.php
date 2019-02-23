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

               
            <div class="page_contant">
           
             <div class="col-lg-12">
                <div class="page_name">
                            <h2>Role Management</h2>
                        </div>
                      <p style="color:red"><?php  echo $this->session->flashdata('message'); ?></p>
                       
                        <div class="page_box">
                             <form action="" id="" method="post" enctype="multipart/form-data" >
                                        <div class="sep_box">

                                      <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="tbl_text">Role Type<span style="color:red;font-weight: bold;">*</span></div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="tbl_input">
                                                           <select id="emptypeid" name="emptypeid" onchange="getemp()">
                                                            <option value="">Select Role Type</option>
                                        <?php foreach ($emp as $key => $value) { ?>

                                    <option value="<?php echo $value->et_id; ?>">
                                                             <?php echo $value->et_name; ?></option>
                                                          
                                                            <?php } ?>
                                                             </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                     
                                      <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="tbl_text">Employee<span style="color:red;font-weight: bold;">*</span></div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="tbl_input">
                                                           <select id="empid" name="empid" onchange="getmenu()">
                                                            <option value="">Select Employee</option>
                                        
                                                             </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
									
									
                                <div id="menu" style="display:none;">
                                    <div class="sep_box">

                                      <div class="col-lg-6">
                                                <p class="he">Assign Menu</p>
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
                                            
                                            <div class="col-lg-6" id="assignmenu"></div>

                                     

                                    </div>    
                                       <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="tbl_input">
                                                           <input type="submit" name="rolesubmit" value="Submit" class="retailer_btn"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                             </div> 
											 
											 
                                    </form>
                                   
                                    </div>

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
	
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
  function getUser()
  {
	 var role_id =$('#role_id').val();
	 $.ajax({
			type:'POST',
			url:'<?php echo base_url();?>permissions/getUserByRole',
			data: {'role_id':role_id},
			success: function(data){
			var  option_student = '<option value="">--Select User--</option>';
			$('#user_id').empty();
			$("#user_id").append(option_student+data);
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
  
  
 