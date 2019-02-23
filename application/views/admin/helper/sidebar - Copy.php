 <?php 
   $session_data = $this->session->userdata('sms');
  // print_r($session_data[0]->id); exit;
   $menues =menuAccess($session_data[0]->id,$session_data[0]->role_id);
 //print_r($menues); exit;
 ?>
 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?php echo base_url('admin/dashboard');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
           
          </a>
         
        </li>
		
		  <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Manage Permission</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('permissions/addPermission');?>">Add Permission</a></li>
           
           
          </ul>
        </li>
		
		 <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Manage Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('admin/addUser');?>">Add User</a></li>
            <li><a href="<?php echo base_url('admin/listUser');?>">All User List</a></li>
			<!--<li><a href="<?php echo base_url('teacher/addTeacher');?>">Add Teacher</a></li>
            <li><a href="<?php echo base_url('teacher/listTeacher');?>">Teacher List</a></li>
			<li><a href="<?php echo base_url('teacher/addTeacher');?>">Add Teacher</a></li>
            <li><a href="<?php echo base_url('teacher/listTeacher');?>">Teacher List</a></li>-->
           
          </ul>
        </li>
		   <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('campus/listCampus');?>">Campus List</a></li>
            <li><a href="<?php echo base_url('discipline/viewDiscipline');?>">Discipline List</a></li>
            <li><a href="<?php echo base_url('discipline/viewCourse');?>">Course List</a></li>
		    <li><a href="<?php echo base_url('program/listProgram');?>">Program List</a></li>
			<li><a href="<?php echo base_url('master/listDegree');?>">Degree List</a></li>
			<li><a href="<?php echo base_url('master/listSyllabusYear');?>">Syllabus Year List</a></li>
			<li><a href="<?php echo base_url('semester/listSemester');?>">Semester List</a></li>
			<li><a href="<?php echo base_url('course/listCourseGroup');?>">Course Group List</a></li>
			
          </ul>
        </li>
		 <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Assign Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url('course/assignCourseList');?>">Assign Course List</a></li>
            <li><a href="<?php echo base_url('campus/campusAndDegreeList');?>">Add Campus and Degree</a></li>
            <li><a href="<?php echo base_url('course/studentCourseAssignment');?>">Student Course Assignment</a></li>
         </ul>
        </li>
		
		
		
      <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Schedule Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('secure/addTimeTable');?>">Add Time-Table </a></li>
            <li><a href="<?php echo base_url('timetable/viewTimeTable');?>">List Time-Table</a></li>
           
          </ul>
        </li>
       
      <!--  <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>-->
		
			
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Registration Card</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('generate/generateRegistrationCard');?>">Generate Registration Card</a></li>
          </ul>
        </li>
		
		
        <!--<li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>-->
       
    </section>
    <!-- /.sidebar -->
  </aside>