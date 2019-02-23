<?php
//print_r($data);
function admin_mainmenu()
{
	
	$CI = & get_instance();  //get instance, access the CI superobject
  	
	

  	$isLoggedIn = $CI->session->userdata('sms');
	//p($isLoggedIn ); exit;
	
	$memId = $isLoggedIn[0]->id;
	$userType = $isLoggedIn[0]->role_id;
		
	$param = array('empid'=>$memId);
	//dd($param); 

	$assignRole = fun_global($memId);
    //print_r($assignRole); exit;	

	if(!empty($assignRole))
	{
		foreach($assignRole as $k=>$v){

		$uMainMenu1[] = $v->main_menu;
		$uSubMenu1[] = $v->sub_menu;
	}
	$uMainMenu 	=	 	array_unique($uMainMenu1);
	$uSubMenu 	= 		array_unique($uSubMenu1);

}
//print_r($uMainMenu); exit;
	

	$parameter = array( 'login' => '' );
	

	
	$data['result'] = fun_global_admin($userType);
	//print_r($data['result']);exit;
	$msg='';

	if($memId==1){
		
			foreach($data['result'] as $values){
				
			
				
				$msg .=' <li class="treeview" >
				          <a href="#">
							<i class="fa fa-user"></i> <span>'.$values->menuname.'</span>
							<span class="pull-right-container">
							  <i class="fa fa-angle-left pull-right"></i>
							</span>
						  </a>
						  
						   <ul class="treeview-menu">';
                        
                      
                        $data1['submenu'] = fun_left_submenu($values->id);	
						
                    // dd($data1['submenu']);
                    	foreach($data1['submenu'] as $submenu1){
							        // p(@$submenu1->url);
                    		
								  if (strpos($_SERVER['REQUEST_URI'], @$submenu1->url) != false) {
									 // p('hello');
                        		      $msg.='<li class="active treeview menu-open"><a href='.base_url().$submenu1->url.'>'.$submenu1->menuname.'</a></li>';
								  }
								  else{
									  // p("byy");
									 $msg.='<li ><a href='.base_url().$submenu1->url.'>'.$submenu1->menuname.'</a></li>'; 
								  }
								 
                        } 

                        $msg.='</ul>
						  
				        </li>';
                   

		
     
     
   }  
  // echo $msg ;
	}
	
	else
	{
		$msg='';
			foreach($data['result'] as $values){
				
			if(@in_array(@$values->id,$uMainMenu)){
				
				$msg .=' <li class="treeview ">
				          <a href="#">
							<i class="fa fa-user"></i> <span>'.$values->menuname.'</span>
							<span class="pull-right-container">
							  <i class="fa fa-angle-left pull-right"></i>
							</span>
						  </a>
						  
						   <ul class="treeview-menu" >';
                        
                      
                        $data1['submenu'] = fun_left_submenu($values->id);	
                    // dd($data1['submenu']);
                    	foreach($data1['submenu'] as $submenu1){
							if(in_array($submenu1->id,$uSubMenu)){
                    		
                        		$msg.='<li><a href='.base_url().$submenu1->url.'>'.$submenu1->menuname.'</a></li>';
                          }
                        } 

                        $msg.='</ul>
						  
				        </li>';
			}
	}
	
	  
	}
	   echo $msg ;
}