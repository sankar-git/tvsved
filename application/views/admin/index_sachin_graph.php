<?php $this->load->view('admin/helper/header');?>
<?php $this->load->view('admin/helper/sidebar');?>

<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/graph/jquery.livegraph.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin/graph/livegraph.css" />


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo count($campuses);?></h3>

              <p>Total Number Of College</p>
            </div>
            <div class="icon">
           <i class="fa fa-university"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo count($students);?></h3>

              <p>Total Student</p>
            </div>
            <div class="icon">
             <i class="fa fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>Total Teacher</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Total Program</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
	<div class="row"><!-- /for graph -->

		<div class="col-lg-6 col-xs-12">
		<!-- small box -->
			<div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
		</div>
			
		
    </div>
	  
	   <div class="row">
	    
            <div class="box-header with-border" align="center">
              <h3 class="box-title" style="color:green"><?php echo $this->session->flashdata('permission'); ?></h3>   
            </div>
       </div>
    </section>
    <!-- /.content -->
  </div>
<!--for graph js-->
 <script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	exportEnabled: true,
	animationEnabled: true,
	title:{
		text: "Car Parts Sold in Different States"
	},
	subtitles: [{
		text: "Click Legend to Hide or Unhide Data Series"
	}], 
	axisX: {
		title: "Data Graph"
	},
	axisY: {
		title: "Number Of Data",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "Clutch - Units",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Oil Filter",
		showInLegend: true,      
		//yValueFormatString: "#,##0.# Units",
		dataPoints: [
			{ label: "Student",  y: 19034.5 },
			{ label: "Teacher", y: 20015 },
			{ label: "Campus", y: 25342 },
			{ label: "Program",  y: 20088 },
			{ label: "Degree",  y: 28234 }
		]
	},
	{
		type: "column",
		name: "Clutch",
		axisYType: "secondary",
		showInLegend: true,
		//yValueFormatString: "#,##0.# Units",
		dataPoints: [
			{ label: "Student", y: 210.5 },
			{ label: "Teacher", y: 135 },
			{ label: "Campus", y: 425 },
			{ label: "Program", y: 130 },
			{ label: "Degree", y: 528 }
		]
	}]
});
chart.render();

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

}
</script>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  
  
 <!--for graph js--><!--for graph js-->
 
  
 <!--for graph js-->
  <!-- /.content-wrapper -->
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 