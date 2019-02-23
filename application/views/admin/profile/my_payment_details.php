<?php //p($this->session->userdata('sms')); exit;
$sessdata= $this->session->userdata('sms');
		if($sessdata[0]->role_id == 5){
			$role_id = 1;
			$campus_id = $user_row->campus_id;
			$id = $user_row->id;
		}else{
			$id = $sessdata[0]->id;
			$role_id = $sessdata[0]->role_id;
			$campus_id = $sessdata[0]->campus_id;
		}
?>
<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');
        
?>
<style >
.error{
 color:red;	
}
div.stars {
  width: 300px;
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  color: #FD4;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
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
			
		
			  
			     <div class="tab-pane payment_details active" id="payment_details" >
                  
				    <table id="example" class="table table-bordered table-hover">
                <thead>
				<tr>
                  <th>S.No.</th>
                  <th>Program</th>
                  <th>Semester</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Transaction Id</th>
                  <th>Transaction Date</th>
                  <th>Invoice</th>
                  <th>Status</th>
                </tr>  </thead><tbody>
				<?php $i=0;foreach($payments as $payment){$i++;?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $payment->program_name;?></td>
                  <td><?php echo $payment->semester_name;?></td>
                  <td><?php echo $payment->payment_type;?></td>
                  <td><?php echo $payment->amt;?></td>
                  <td><?php echo $payment->mer_txn;?></td>
                  <td>
                    <?php echo $payment->date;?>
                  </td>
				  <td>
					<?php if($payment->f_code == 'Ok'){?>
                    <a href="<?php echo base_url();?>payment/downloadReceipt/<?php echo $payment->mer_txn;?>">Download Invoice</a>
					<?php }else echo '-'; ?>
                  </td>
                 <td>
                    <?php echo $payment->desc;?>
                  </td>
                </tr>
				<?php }?>
              </tbody></table>
               
              </div>
			  
			  
			  
			  
				    
                </form>
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
  <!-- /.content-wrapper -->
  <script type="text/javascript">
	
	$(document).ready(function() {
		$("#sales_dob").datepicker({format: 'dd-mm-yyyy',autoclose: true});
		
	});
	function rateMe(value,id)
   {
     var user_id=id;
     var rating_id=value;
     $('#rate_value').val(rating_id);
	 
   }
	
    function sendFeedBack(){
		var sender_id =$('#sender_id').val();
		var sender_role =$('#sender_role').val();
		var sender_campus =$('#sender_campus').val();
		var rate_value =$('#rate_value').val();
		var feedback_id =$('#feedback_id').val();
		
		var feedback_message =$('#feedback_message').val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>process/sendFeedback',
			data: {'feedback_id':feedback_id,'sender_id':sender_id,'sender_campus':sender_campus,'rate_value':rate_value,'feedback_message':feedback_message},
			success: function(data){
				
				if(data==1){
					//alert('hello');
					alert('Feedback Send Successfully.');
					$('#feedback_form')[0].reset();
					window.location.reload()
				}
				else{
					alert('Feedback Not Send Successfully.');
					$('#feedback_form')[0].reset();
					window.location.reload();
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
	$("#frmpayment").validate({
		rules: {
			program_id: "required",
			semester_id: "required",
			report_card: "required",
			amount: "required"
		
			
			
		},
		messages: {
			program_id: "Select Program",
			semester_id: "Please select anyone",
			report_card:"Select Payment Type",
			amount:"Amount is Blank"
		
			
				
		},
		submitHandler: function (form) {
				form.submit();
		}
	});	
	function change_report_card(report_value){
		//alert(report_value);
		$("#amount").val('');
		if(report_value == 'transcript' || report_value == 'consolidate' || report_value == '')
			$('.program').addClass('hidden');
		else
			$('.program').removeClass('hidden');
		
		if(report_value == 're-evaluation' || report_value == 'exam_fees'){
			$('.re-evaluation').removeClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.transcript').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else if(report_value == 'duplicate_certificate'){
			$('.duplicate_certificate').removeClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.transcript').addClass('hidden');
		}else if(report_value == 'transcript'){
			$('.transcript').removeClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else if(report_value == 'year_wise_marksheet'){
			$('.year_wise_marksheet').removeClass('hidden');
			$('.transcript').addClass('hidden');
			$('.consolidate').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else if(report_value == 'consolidate'){
			$('.consolidate').removeClass('hidden');
			$('.transcript').addClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}else{
			$('.consolidate').addClass('hidden');
			$('.transcript').addClass('hidden');
			$('.year_wise_marksheet').addClass('hidden');
			$('.re-evaluation').addClass('hidden');
			$('.duplicate_certificate').addClass('hidden');
		}
	}
$(document).ready(function() {
	
	$('.semester_id').on('change', function() {
		if($(this).find('option:selected').html() !=''){
		$.get( "getfeeamount", {"_": $.now(), name: $(this).find('option:selected').html(),type: $('#report_card').find('option:selected').html()} )
		  .done(function( data ) {
			$("#amount").val(data);
		});
		}else{
			$("#amount").val('');
		}
		$("#semester_value").val($(this).find('option:selected').html());
	});
	$('#report_card').on('change', function() {
		change_report_card($(this).find('option:selected').val());
	});
	var url = window.location.href;
	var activeTab = url.substring(url.indexOf("#") + 1);
	if($('a[href="#'+ activeTab +'"]').length>0){
		$('a[href="#'+ activeTab +'"]').tab('show');
		setTimeout(function() {
			$(window).scrollTop(0 );
		}, 5);
	}else{
		$('a[href="#report_card"]').tab('show');
			setTimeout(function() {
				$(window).scrollTop(0 );
			}, 5);
			$('select#report_card').val(activeTab);
			change_report_card(activeTab);
	}
	$('.treeview-menu a').click(function(){
		 var scrollHeight = $(document).scrollTop();
		var url = $(this).attr('href');
		var activeTab = url.substring(url.indexOf("#") + 1);
		if($('a[href="#'+ activeTab +'"]').length>0){
			$('a[href="#'+ activeTab +'"]').tab('show');
			setTimeout(function() {
				$(window).scrollTop(scrollHeight );
			}, 5);
		}else{
			console.log(activeTab);
			$('a[href="#report_card"]').tab('show');
			setTimeout(function() {
				$(window).scrollTop(scrollHeight );
			}, 5);
			$('select#report_card').val(activeTab);
			change_report_card(activeTab);
			$('select.semester_id').val('');
		}
	});
   
	$(document).ready(function () {
		$('#example').DataTable();
	});
} );
	
</script>
	
<?php $this->load->view('admin/helper/footer');?> 
  
  
 