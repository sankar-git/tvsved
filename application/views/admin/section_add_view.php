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

            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title" style="color:green"><?php echo $this->session->flashdata('message'); ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" name="section_form" id="section_form" method="post" action="<?php echo base_url();?>batch/<?php if(isset($section_id) && @$section_id>0){?>updateSection/<?php echo @$section_row->id;?><?php }else{?>saveSection<?php } ?>" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="degree_code">Section Code<span style="color:red;font-weight: bold;">*</span></label>
                                <input type="text" class="form-control" id="section_code"  value="<?php echo @$section_row->section_code;?>" name="section_code" placeholder="Enter section_code">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="degree_name">Section Name<span style="color:red;font-weight: bold;">*</span></label>
                                <input type="text" class="form-control" id="section_name"  value="<?php echo @$section_row->section_name;?>" name="section_name" placeholder="Enter Section Name">
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <div style="float:right;">
                            <a class="btn btn-primary" href="<?php echo site_url('batch/listBatch'); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
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

    $("#section_form").validate({
        rules: {
            section_code: "required",
            section_name: "required"
        },
        messages: {
            section_code: "Section code is required..",
            section_name:"Section name is reqiured."


        },
        submitHandler: function (form) {
            form.submit();
        }
    });

</script>



<?php $this->load->view('admin/helper/footer');?>