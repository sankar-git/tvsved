<?php $this->load->view('admin/helper/header');?>
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
    .box-body,#activitycalendar{
        height: 720px;
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
                <form role="form" name="attendance_form" id="attendance_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                        <div class="form-group col-md-3">
                            <label for="campus">Campus<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="campus_id" id="campus_id" class="form-control" onchange="getProgramByCampusId();">
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

                        <div class="form-group col-md-3" >
                            <label for="degree_id">Degree<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="degree_id[]" multiple id="degree_id" class="form-control">

                            </select>
                            <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $id;?>">
                            <input type="hidden" name="login_user_type" id="login_user_type" value="<?php echo $role_id;?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Batch<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="batch_id[]" multiple id="batch_id" class="form-control">
                                <?php foreach($batches as $batch){ ?>
                                    <option value="<?php echo $batch->id;?>"><?php echo $batch->batch_name;?></option>
                                <?php }  ?>
                            </select>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Semester<span style="color:red;font-weight: bold;">*</span></label>
                            <select name="semester_id[]" multiple id="semester_id" class="form-control" >

                            </select>
                        </div>
                        </div>

                        <div class="row">
                            <?php if($managelist == 1){?>
                                <div class="modal modal-fade" id="event-modal" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title">
                                                    Holidays
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="event-index" value="">
                                                <form name="frm-event" id="frm-event" class="form-horizontal">
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label for="event-name" class="control-label">Name</label>

                                                            <input name="event-name" type="text" class="form-control">

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="min-date" class="control-label">Dates</label>

                                                            <div class="input-group input-daterange" data-provide="datepicker">
                                                                <input name="event-start-date" type="text" class="form-control" value="">
                                                                <span class="input-group-addon">to</span>
                                                                <input name="event-end-date" type="text" class="form-control" value="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" id="save-event">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div id='activitycalendar' class="hidden" ></div>
                        </div>
                        <!--<div class="box-body table-responsive">
                                 <table id="example" class="table table-bordered table-hover">
                                     <thead>
                                     <tr>
                                         <th>S.No.</th>
                                         <th>Student Id</th>
                                         <th>Student Name</th>
                                         <th><label><input type="checkbox" checked onclick="return false;">:PRESENT,<input type="checkbox" onclick="return false;">:ABSENT</label><br/>Mark Attendance</th>
                                     </tr>
                                 </thead>
                                 <tbody id="tr_list">
                                 </tbody>
                             </table>
                         </div>-->

                        <!-- /.box-body -->

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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript" src="<?php echo base_url()?>assets/bootstrap/js/bootstrap-year-calendar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap-year-calendar.min.css" />

<script type="text/javascript">
    function editEvent(event) {
        $('#event-modal input[name="event-index"]').val(event ? event.id : '');
        $('#event-modal input[name="event-name"]').val(event ? event.name : '');
        $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
        $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
        $('#event-modal').modal();
    }
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
                $('#degree_id').empty();
                $("#degree_id").append(data);
                $('#degree_id').multiselect('rebuild');
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
                var  option_brand = '';
                $('#semester_id').empty();
                $("#semester_id").append(option_brand+data);
                $('#semester_id').multiselect('rebuild');
            }
        });
    }
    function deleteEvent(event) {
        var dataSource = $('#activitycalendar').data('calendar').getDataSource();

        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource.splice(i, 1);
                break;
            }
        }
        var degree_id =$('#degree_id').val();
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>attendance/deleteholiday/'+event.id,
            data: {'degree_id':degree_id},
            success: function(data){

            }
        });
        $('#activitycalendar').data('calendar').setDataSource(dataSource);
    }

    function saveEvent() {

        var event = {
            id: $('#event-modal input[name="event-index"]').val(),
            name: $('#event-modal input[name="event-name"]').val(),
            startDate: $('#event-modal input[name="event-start-date"]').val(),
            endDate: $('#event-modal input[name="event-end-date"]').val(),
            degree_id: $('#degree_id').val(),
            batch_id: $('#batch_id').val(),
            semester_id: $('#semester_id').val(),
            campus_id: $('#campus_id').val(),
            program_id: $('#program_id').val()
        }
        if ($('#campus_id').val() == ''){
            alert('Please select campus');
            return false;
        }
        if ($('#program_id').val() == ''){
            alert('Please select program');
            return false;
        }
        if($('#event-modal input[name="event-name"]').val() == ''){
            alert('Please enter the name');
            $('#event-modal input[name="event-name"]').focus();
            return false;
        }
        if($('#event-modal input[name="event-start-date"]').val() == ''){
            alert('Please select start date');
            $('#event-modal input[name="event-start-date"]').focus();
            return false;
        }
        if($('#event-modal input[name="event-end-date"]').val() == ''){
            alert('Please select end date');
            $('#event-modal input[name="event-end-date"]').focus();
            return false;
        }
        var dataSource = $('#activitycalendar').data('calendar').getDataSource();

        if(event.id) {
            for(var i in dataSource) {
                if(dataSource[i].id == event.id) {
                    dataSource[i].name = event.name;
                    dataSource[i].startDate = $('#event-modal input[name="event-start-date"]').datepicker('getDate');
                    dataSource[i].endDate = $('#event-modal input[name="event-start-date"]').datepicker('getDate');
                }
            }


            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>attendance/saveholidays/',
                data: event,
                success: function(data){

                }
            });
        }
        else
        {
            var newId = 0;
            for(var i in dataSource) {
                if(dataSource[i].id > newId) {
                    newId = dataSource[i].id;
                }
            }

            $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>attendance/saveholidays/',
                data: event,

                success: function(data){
                    event.id = parseInt(data);
                    event.startDate = $('#event-modal input[name="event-start-date"]').datepicker('getDate');
                    event.endDate = $('#event-modal input[name="event-start-date"]').datepicker('getDate');
                    dataSource.push(event);
                }
            });
        }
        $('#activitycalendar').data('calendar').setDataSource(dataSource);
        loadHolidays($('#degree_id').val());
        $('#event-modal').modal('hide');
    }

    $(function() {
        var currentYear = new Date().getFullYear();
        var holidayData=[];
        $('#activitycalendar').calendar({
            enableContextMenu: <?php if($managelist == 1){?>true<?php }else{?> false<?php }?>,
            style: 'background',
            enableRangeSelection: true,
            minDate:new Date(<?php echo date('Y')-1;?>, 0, 01),
            maxDate:new Date(<?php echo date('Y')+1;?>, 11,31),
            startYear: <?php echo date('Y');?>,
            contextMenuItems:[
                {
                    text: 'Update',
                    click: editEvent
                },
                {
                    text: 'Delete',
                    click: deleteEvent
                }
            ],
            selectRange: function(e) {
                editEvent({ startDate: e.startDate, endDate: e.endDate });
            },
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
            url:'<?php echo base_url();?>attendance/getholidays',
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
                    //if(item.name == 'Weekly Off')
                    data[i].color = '#8B0000';
                    //else
                    //data[i].color = '#006400';
                    //data[i].endDate = JSON.stringify(item.endDate);
                });
                $('#activitycalendar').data('calendar').setDataSource(data);
            }
        });

    }
    $(document).ready(function() {

        $('#degree_id,#batch_id,#semester_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            buttonWidth: '345px',
            maxHeight: 350,
            onChange: function(element, checked) {


                if($($(element).context.offsetParent).attr('id') == 'degree_id'){
                    getSemesterbyDegree();
                }

                if($('#degree_id').val().length>0 || $('#batch_id').val().length>0 || $('#semester_id').val().length>0){
                    $("#activitycalendar").removeClass('hidden');
                    loadHolidays($('#degree_id').val());
                }else{
                    $("#activitycalendar").addClass('hidden');
                }
            }
        });

        /*$('#degree_id').on('change',function(){
            if($(this).val() >0){
                $("#activitycalendar").removeClass('hidden');
                    loadHolidays($(this).val());
            }else{
                $("#activitycalendar").addClass('hidden');
            }
        });*/
    });

    $(document).ready(function () {
        //$.dataTable =$('#example').DataTable();
    });
    $(document).ready(function(){
        //On page load
        uncheckedChk();

        //on checkbox change
        $("input[type='checkbox'][name='attendance[]'][title= '1']").on("change",function(){
            uncheckedChk();
        });
    });

    //Function to identify all the unchecked checkbox with title=1
    function uncheckedChk(){
        var not_checked = []
        $("input[type='checkbox'][name='attendance[]'][title= '1']:not(:checked)").each(function (){
            not_checked.push($(this).val());
        });

    }
    function getProgramByCampus()
    {
        var campus_id =$('#campus_id').val();
        // alert(campus_id);
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


    function getCourseByPDS()
    {
        var $form = $("#attendance_form");

        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>attendance/getCourseByPDS',
            data: $form.serialize(),
            success: function(data){
                var  option_brand = '<option value="">--Select Course--</option>';
                $('#course_id').empty();
                $("#course_id").append(option_brand+data);

            }
        });
    }
    function getStudentAssignByCourse()
    {

        var $form = $("#attendance_form");
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>attendance/getStudentAssignByCourse',
            data: $form.serialize(),
            success: function(data){
                //$('#courseList').show();
                $('#tr_list').html(data);
                //$.dataTable.draw(false);

            }
        });
    }
    function saveAttendance()
    {
        $('.showMsg').html('');
        var $form = $("#attendance_form");
        $.ajax({
            type:'POST',
            url:'<?php echo base_url();?>attendance/saveAttendance',
            data: $form.serialize(),
            success: function(data){

                if(data==1){
                    $('.showMsg').html('Attendance save successfully').css("color", "green");
                }
                if(data==0){
                    $('.showMsg').html('Something went wrong').css("color", "red");
                }
                if(data==2){
                    $('.showMsg').html('Attendance already given today.').css("color", "red");
                }


            }
        });
    }



    var sList = "";
    $('input[type=checkbox]').each(function () {
        sList += "(" + $(this).val() + "-" + (this.checked ? "1" : "0") + ")";
    });
    //alert(sList);
    function getVal()
    {
        $('input[type=checkbox]').each(function () {
            sList += "(" + $(this).val() + "-" + (this.checked ? "1" : "0") + ")";
        });
    }
</script>

<script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-multiselect.css" type="text/css"/>

<?php $this->load->view('admin/helper/footer');?>