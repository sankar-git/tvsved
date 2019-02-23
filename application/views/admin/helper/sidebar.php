 <?php 
   $session_data = $this->session->userdata('sms');
   // $path_link=$this->uri->uri_string(); 
   // $data=aciveMenu($path_link);
	//print_r($data); exit;
 ?>
 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
         
		
		 <?php
              admin_mainmenu();

         ?> 
		   
	</ul>
       
    </section>
    <!-- /.sidebar -->
  </aside>