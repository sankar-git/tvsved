<?php //print_r($payment_row); //exit;
if($mail_flag == false){?>
<div style="position:relative;left;margin:0 auto;width:80%;">
<h2>Thank you  for applying  for <?php echo $payment->payment_type;?></h2>
<form method="post" action="<?php echo base_url();?>payment/downloadReceipt">
   <input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $payment_row->mer_txn;?>">
   <input type="submit" name="submit" id="submit"  formtarget="_blank" value="Save"/>
   <input type="hidden" name="payment_type" id="payment_type"  value="<?php echo $payment->payment_type;?>"/>
</form>
<p><a href="<?php echo base_url();?>process/viewProcess">Back To Home</a></p>
</div>

<?php } ?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Payment Receipt - <?php echo $payment->payment_type;?></title>

<style>
<?php //print_r($payment_row); //exit;
if($mail_flag == false){?>
body{
	width:80%;
	position:relative;left;margin:0 auto;
	border: 1px solid
}

<?php }?>
        .table {
             
            border-collapse: collapse;
            padding:0px !important;
        }

            .table th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0px 0px 0px 0px !important;
                font-size: 13px;
            }

                .table th td {
                     
                    border-collapse: collapse;
                    padding: 0px 0px 0px 0px !important;
                }

            .table tr td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 11px;
                padding: 0px 0px 0px 5px !important;
            }


        .header{
            width:100%;
            padding:0px;
            margin:0px;
            border-bottom:1px solid #000;
        }

        .pdf_container{
            width:100%;
            display:block;
            padding:0px;
            margin:0px;
			border-bottom: 1px solid #000;
        }
        .sub-detail-tbl tr td{
          padding:2px 5px;

        }
        
        .student_table,
        .student_sub_table{
            width:100%;
            padding:0px;
            margin:0px;
            border-collapse: collapse;
            font-size:12px;
        }


        .student_table td,
        .student_table th{
            padding:2px;
            border: 1px solid black;
            font-size:12px;
          }  


          .student_sub_table td,
          .student_sub_table th{
            padding:0px;
            border:none;

          }

         




    </style>
</head>


<body>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">
<p style="padding-left:100px;text-align:right;font-size:11px;">Online Payment Receipt</p>
        <div class="header">
            <table style="padding:0px; margin:0px;border-collapse: collapse;">
                <tr>
                    <td>
                        <img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png" style="padding:0px 20px 10px 0px;">
                    </td>

                    <td colspan="2" style="text-align:center; line-height:1.0;padding-left:10px">
                      <h3>Tamil Nadu Veterinary and Animal Sciences University</h3>
                            <p>Madhavaram Milk Colony Road, Chennai, Tamil Nadu 600051<br/>
                        Phone: +91-44-25551586/87, 25554555/56<br/>
                        Website: www.tanuvas.tn.nic.in</p>
                    </td>
                </tr>
            </table>
            
        </div>
        <div class="pdf_container" >
            <table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Line-height:1.5">
                <tr>
                    <td>
                        <u><h3>Student Detail : </h3></u>
                    </td>
                </tr>

                 <tr>
                    <td>Student ID Number:</td><td><?php echo $userinfo[0]['user_unique_id'];?></td>
                </tr>
				<tr>
                    <td>Name of Student:</td><td ><?php echo $userinfo[0]['name'];?></td>
                </tr>
				<tr>
                    <td>Campus Name:</td><td><?php echo $userinfo[0]['campus_name'].','.$userinfo[0]['address1'];?></td>
                </tr>
				<tr>
                    <td>Program:</td><td><?php echo $userinfo[0]['program_name'];?></td>
                </tr>
				<tr>
                    <td>Degree:</td><td><?php echo $userinfo[0]['degree_name'];?></td>
                </tr>
				<tr>
                    <td>Semester:</td><td ><?php echo $payment->semester_id;?></td>
                </tr>
				<tr>
                    <td>Batch:</td><td ><?php echo $userinfo[0]['batch_name'];?></td>
                </tr>
				<tr>
                    <td>Telephone No. for Communication:</td><td><?php echo $userinfo[0]['contact_number'];?></td>
                </tr>
				<tr>
                    <td>Email-ID:</td><td><?php echo $userinfo[0]['email'];?></td>
                </tr>


             </table>   
        </div>
		<div class="pdf_container" >
            <table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Line-height:1.5">
                <tr>
				<td >&nbsp;</td >
                    <td >
                        <u><h3>Payment Detail</h3></u>
                    </td>
                </tr>
				<?php
				$payment_mode = array('NB'=>'Net banking','CC' => 'Credit Cards','DC' => 'Debit Card','IM' => 'IMPS','MX' => 'AmericanExpress Cards');
				?>
                 <tr>
                    <td>Payment Received At:</td><td><?php echo $payment_row->bank_name;?></td>
                </tr>
				<tr>
                    <td>Payment Mode:</td><td ><?php echo $payment_mode[$payment_row->discriminator];?></td>
                </tr>
				<tr>
                    <td>Payment Transaction No:</td><td><?php echo $payment_row->mer_txn;?></td>
                </tr>
				<tr>
                    <td>Payment Date:</td><td><?php echo $payment_row->date;?></td>
                </tr>
			</table>   
        </div>
		<div class="pdf_container" >
            <table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Line-height:1.5">
                 <tr>
                    <td><strong>Name of Code(Pay Type):</strong></td><td><strong>Date & Time</strong></td><td><strong>Deposit Amount(in Rs.)</strong></td>
                </tr>
				<tr>
                    <td><?php echo ucwords(str_replace("_"," ",$payment->payment_type));?></td><td ><?php echo $payment_row->date;?></td><td ><?php echo $payment_row->amt;?></td>
                </tr>
				<tr>
                   <td>&nbsp;</td><td >CGST(9%)</td><td >0.00</td>
                </tr>
				<tr>
                   <td>&nbsp;</td><td style="border-bottom: 1px solid #000;">SGST(9%)</td><td style="border-bottom: 1px solid #000;">0.00</td>
                </tr>
				<tr >
                   <td>&nbsp;</td><td style="border-bottom: 1px solid #000;">Grand Total</td><td style="border-bottom: 1px solid #000;"><?php echo $payment_row->amt;?></td>
                </tr>
				<tr>
                    <td>SCHEDULE OF CHARGES</td><td>&nbsp;</td><td>&nbsp;</td>
                </tr>
				<tr>
                    <td colspan="2">1. Payment subject to realization.</td><td>&nbsp;</td>
                </tr>
				<tr>
                    <td colspan="2">2. Charges as applicable</td><td>&nbsp;</td>
                </tr>
				<tr>
                    <td>&nbsp;</td><td>Seal</td><td>Receiving Authority Sign</td>
                </tr>
				
				<tr>
                    <td>&nbsp;</td><td colspan="2">(This is Computer generated statement and does not require a signature)</td>
                </tr>
				<tr>
                    <td>&nbsp;</td><td colspan="2"><?php echo date("d/m/Y h:i:s a");?></td>
                </tr>
			</table>   
        </div>
    </div>
</body>




</html>
