<html>
<head>
    <title>Class Grade</title>
    <style>
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
                padding: 0px 0px 0px 0px !important;
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
        }
        .sub-detail-tbl tr td{
          padding:5px 0px;

        }
        
        .student_table,
        .student_sub_table{
            width:100%;
            padding:0px;
            margin:0px;
            border-collapse: collapse;
            font-size:14px;
        }


        .student_table td,
        .student_table th{
            padding:5px;
            border: 1px solid black;
          }  


          .student_sub_table td,
          .student_sub_table th{
            padding:0px;
            border:none;
          }

         




    </style>
</head>

<>
<body>
    <div style="padding:0px; width:100%; font-family:Arial, Helvetica, sans-serif; ">

        <div class="header">
            <table style="padding:0px; margin:0px;border-collapse: collapse;">
                <tr>
                    <td >
                        <img height="110" src="<?php echo base_url();?>assets/admin/dist/img/tanuvaslogo.png" style="padding:10px 20px 10px 0px;">
                    </td>
                    <td style="text-align:center; line-height:1.5">
                        <h4>TAMIL NADU  VETERINARY AND ANIMAL SCIENCES UNIVERSITY</h4>
                        <h5><?php echo $aggregate_marks[0]->degree_name;?></h5>
                        <h5><?php echo $aggregate_marks[0]->semester_name;?> SEMESTER FINAL EXAMINATION</h5>
                    </td>
                </tr>
            </table>
            
        </div>
        <div class="pdf_container">
            <table class="sub-detail-tbl" style="width:100%;padding:20px 0px; margin:0px; border-collapse: collapse; margin:20px 0px;Lline-height:1.5">
                <tr>
                    <td>
                        <b>College : </b> <?php echo $aggregate_marks[0]->campus_name;?>
                    </td>
                    <td style="text-align:right">
                        <b>Month & Year :</b> MAR-2016
                    </td>
                </tr>

                 <tr>
                    <td>
                        <b>Subject Code : </b> <?php echo $aggregate_marks[0]->course_code;?> (<?php echo $aggregate_marks[0]->theory_credit ;?> + <?php echo $aggregate_marks[0]->practicle_credit ;?>)
                    </td>
                    <td style="text-align:right">
                        <b>Batch :</b> <?php echo $aggregate_marks[0]->batch_name;?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Subject : </b> <?php echo $aggregate_marks[0]->course_title;?>
                    </td>
                    <td>
                       
                    </td>
                </tr>

             </table>   







        <div class="table_holder">
           
          
            <table id="table" width="100%;" class="student_table">
                <tr>
                    <th>ID No. </th>
                    <th> Name of the Student </th>
                    <th style="padding:0px; margin:0px;">
                       
                            <table class="student_sub_table" >
                                <tr>
                                    <th colspan="2" style="border-bottom:1px solid black; padding:5px 0px;">                                    
                                            THEORY                                      
                                    </th>

                                </tr>
                                <tr>
                                    <th style="border-right:1px solid black; padding:5px 0px;"> 
                                      
                                            INT.
                                            (Max. 20)
                                      
                                    </th>
                                    <th>
                                       
                                            EXT.
                                            (Max. 80)
                                      
                                    </th>
                                </tr>
                            </table>
                       
                    </th>
                    <th style="padding:0px; margin:0px;">
                       
                            <table class="student_sub_table" >
                                <tr>
                                    <th colspan="2" style="border-bottom:1px solid black; padding:5px 0px;">    
                                        PRACTICAL
                                     </th>

                                </tr>
                                <tr>
                                   <th style="border-right:1px solid black; padding:5px 0px;"> 
                                            INT.
                                            (Max. 20)
                                    </th>
                                    <th>
                                            EXT.
                                            (Max. 80)
                                    </th>
                                </tr>
                            </table>
                       
                    </th>
                </tr>
                
                <?php foreach($aggregate_marks as $marks){?>
                <tr>
                    <td>
                      
                            <?php echo $marks->user_unique_id;?>
                     
                    </td>
                    <td>
                      
                          <?php echo ucfirst($marks->first_name).' '.ucfirst($marks->first_name);?>
                        
                    </td>
                    <td style="padding:0px; marging:0px" >
                     
                            <table class="student_sub_table">
                                <tr>
                                    <td  colspan="2" style="border-right:1px solid black; padding:5px;">
                                      
                                            <?php 
                                            if(empty($marks->theory_internal))
                                            {
                                                echo '00';
                                            }
                                            else
                                            {
                                            echo strlen($marks->theory_internal)==1 ? '0'.$marks->theory_internal: $marks->theory_internal;
                                            }
                                            ?>
                                       
                                    </td>
                                    <td  colspan="2" style="padding:5px; margin:0px">
                                      
                                            <?php 
                                            if(empty($marks->theory_external))
                                            {
                                                echo '00';
                                            }
                                            else
                                            {
                                            echo strlen($marks->theory_external)==1 ? '0'.$marks->theory_external: $marks->theory_external;
                                            }
                                            ?>
                                       
                                    </td>
                                </tr>
                            </table>
                    </td>
                    <td style="padding:0px; marging:0px" >
                     
                            <table class="student_sub_table">
                                <tr>
                                     <td  colspan="2" style="border-right:1px solid black; padding:5px;">
                                       
                                          <?php
                                          if(empty($marks->practical_internal))
                                            {
                                                echo '00';
                                            }
                                            else
                                            {
                                      
                                             echo strlen($marks->practical_internal)==1 ? '0'.$marks->practical_internal: $marks->practical_internal;
                                            }
                                             ?>
                                      
                                    </td>
                                    <td  colspan="2" style="padding:5px; margin:0px">
                                          <?php
                                             if(empty($marks->practical_external))
                                            {
                                                echo '00';
                                            }
                                            else
                                            {
                                             echo strlen($marks->practical_external)==1 ? '0'.$marks->practical_external: $marks->practical_external;
                                            }
                                            ?>
                                    </td>
                                </tr>
                            </table>
                   
                    </td>

                </tr>
                
                <?php } ?>
            </table>


            
             
        </div>












        </div>




    
</body>




</html>