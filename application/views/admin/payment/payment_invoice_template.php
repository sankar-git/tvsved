<?php //p($fail_student_list[0]['campus_name']); exit;?>

<!DOCTYPE html>
<html>
<head>
    <title>Result List</title>
    <style>
        #table {
            border: 1px solid;
            border-collapse: collapse;
        }

            #table th {
                border: 1px solid;
                border-collapse: collapse;
                height:35px;
            }

                #table th td {
                    border: 1px solid;
                    border-collapse: collapse;
                }
                #table tr td {
                    border: 1px solid;
                    border-collapse: collapse;
                    font-size:14px;
                }
    </style>
</head>


<body>
    <div style="padding:10px 10px 10px 10px; width:852px; font-family:Arial, Helvetica, sans-serif;">
        <div id="dummy">
          <table>
                <tr>
                  <td>
                        <div>
                            <table>
                              <tr>
							  <td align="center">
                                         <p align="center" style=" font-size:14px;padding:10px 0px 0px 0px;">
										     <b>Transaction Receipt:</b>
										 </p>
                                    </td>
                                </tr>
                            </table>
                        </div>


                    </td>
                </tr>
            </table>

            <hr />
            <table>
                <tr>
                    <td align="left" style="width:400px;"><div style="font-size:14px;"><b>Name :</b>
					<?php echo $payment_row->customer_name;?>
					</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                   
                    <td align="right" style="width:200px;"><div style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Amount :</b><?php echo $payment_row->amt;?></div></td>
                </tr>
                <tr>
                <td align="left" style="width:400px;"><div style="font-size:14px;"><b>Transaction Id:</b><?php echo $payment_row->mer_txn;?></div></td>
                   
                    <td  align="right" style="width:200px;"><div style="font-size:14px;"><b>Date :</b><?php echo $payment_row->date; ?></div></td>
                </tr>
            </table>

</div>
    </div>
</body>




</html>
