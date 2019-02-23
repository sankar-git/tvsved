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
			<div id="page" class="content">
				<table class="dataforgraph">
				<tr>
					<td>Student</td>
					<td><?php echo count($students);?></td>
				</tr>
				<tr>
					<td>Campus</td>
					<td><?php echo count($campuses);?></td>
				</tr>
				<tr>
					<td>Teacher</td>
					<td>0</td>
				</tr>
				
				
				</table>
			</div>
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
  <script type="text/javascript">
		<!--
			$(document).ready(function() {
				
					$('#page').liveGraph({
						height : 350,
						barWidth : 100,
						barGapSize : 3,
						data : 'table.dataforgraph',
						hideData : true
					});
					$('div#update').show();
					$('#page').data('liveGraph').settings.hideData = false;
					$('#page h2').html("Graph");
					$('#page div.controls').show();
					$('.animation').change(function(){
						if ($(this).val() == "true") {
							$('#page').data('liveGraph').settings.animate = true;
						} else {
							$('#page').data('liveGraph').settings.animate = false;
						}
					});
					$('.animTime').change(function() {
						$('#page').data('liveGraph').settings.animTime = parseInt($(this).val());
					});
				
				$('table.updatedata').find('tbody tr').each(function() {
					var label = $(this).find('td').first();
					var oldlab = label.html();
					var value = $(this).find('td').last();
					var oldval = value.html();
					value.html("<input type='text' value='"+oldval+"' />");
					label.html("<input type='text' value='"+oldlab+"' />");
				});
				
			});
		-->
	</script>
	
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
  
  
 <!--for graph js--><!--for graph js-->
  <script type="text/javascript">
		<!--
			$(document).ready(function() {
				
					$('#page').liveGraph({
						height : 350,
						barWidth : 100,
						barGapSize : 3,
						data : 'table.dataforgraph',
						hideData : true
					});
					$('div#update').show();
					$('#page').data('liveGraph').settings.hideData = false;
					$('#page h2').html("Graph");
					$('#page div.controls').show();
					$('.animation').change(function(){
						if ($(this).val() == "true") {
							$('#page').data('liveGraph').settings.animate = true;
						} else {
							$('#page').data('liveGraph').settings.animate = false;
						}
					});
					$('.animTime').change(function() {
						$('#page').data('liveGraph').settings.animTime = parseInt($(this).val());
					});
				
				$('table.updatedata').find('tbody tr').each(function() {
					var label = $(this).find('td').first();
					var oldlab = label.html();
					var value = $(this).find('td').last();
					var oldval = value.html();
					value.html("<input type='text' value='"+oldval+"' />");
					label.html("<input type='text' value='"+oldlab+"' />");
				});
				
			});
		-->
	</script>
	
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
  
  
 <!--for graph js-->
  <!-- /.content-wrapper -->
 <?php $this->load->view('admin/helper/footer');?> 
  
  
 