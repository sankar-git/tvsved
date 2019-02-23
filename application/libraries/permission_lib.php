<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class permission_lib{
		
		function permit_old($userid,$roleid)
		{
			 $CI=& get_instance();
			 $path_link=$CI->uri->uri_string(); 
			 //print_r($path_link); exit;
			if($path_link!='admin/dashboard')
			{		
				$string='select page_link from tblpage inner join permission on tblpage.page_id=permission.page_id where permission.user_id = '.$userid;
				$string.=' and permission.role_id = '.$roleid.' and tblpage.page_link = "'.$path_link.'"';
				$pages=$CI->common_model->sql_string($string);
				//print_
				$page_name=$CI->common_model->single_value('tblpage','page_name','page_link = "'.$path_link.'"');
				//print_r($page_name); exit;
				if(isset($pages[0]->page_link))
				{
					if($pages[0]->page_link==$path_link)
					{
						return true;
					}else{
						$CI->session->set_flashdata('permission','<span style="color:red">Access Denied For The Page '.$page_name.'</span>');
						redirect('admin/dashboard');
					}
				}else{
					$CI->session->set_flashdata('permission','<span style="color:red">Access Denied For The Page '.$page_name.'</span>');
					redirect('admin/dashboard');
				}
			}
			else{
				return true;
			}
			
		}
		
			function permit($userid,$roleid)
		{
			 $CI=& get_instance();
			 $path_link=$CI->uri->uri_string(); 
			// print_r($path_link); exit;
			if($path_link!='admin/dashboard')
			{		
				$string='select url from tbladminmenu inner join tblassignrole on tbladminmenu.id=tblassignrole.sub_menu where tblassignrole.emp_id = '.$userid;
				$string.=' and tblassignrole.role_id = '.$roleid.' and tbladminmenu.url = "'.$path_link.'"';
				$pages=$CI->common_model->sql_string($string);
				//print_
				//p($pages); exit;
				$page_name=$CI->common_model->single_value('tbladminmenu','menuname','url = "'.$path_link.'"');
				//print_r($page_name); exit;
				if(isset($pages[0]->url))
				{
					if($pages[0]->url==$path_link)
					{
						return true;
					}else{
						$CI->session->set_flashdata('permission','<span style="color:red">Access Denied For The Page '.$page_name.'</span>');
						redirect('admin/dashboard');
					}
				}else{
					$CI->session->set_flashdata('permission','<span style="color:red">Access Denied For The Page '.$page_name.'</span>');
					redirect('admin/dashboard');
				}
			}
			else{
				return true;
			}
			
		}
		function permit_new($userid,$roleid)
		{
			 $CI=& get_instance();
			 $path_link=$CI->uri->uri_string(); 
			 //print_r($path_link); exit;
			if($path_link!='admin/dashboard')
			{		
				$string='select page_link from tblpage inner join tblassignrole on tblpage.page_id=tblassignrole.sub_menu where permission.user_id = '.$userid;
				$string.=' and tblassignrole.role_id = '.$roleid.' and tblpage.page_link = "'.$path_link.'"';
				$pages=$CI->common_model->sql_string($string);
				//print_
				$page_name=$CI->common_model->single_value('tblpage','page_name','page_link = "'.$path_link.'"');
				//print_r($page_name); exit;
				if(isset($pages[0]->page_link))
				{
					if($pages[0]->page_link==$path_link)
					{
						return true;
					}else{
						$CI->session->set_flashdata('permission','<span style="color:red">Access Denied For The Page '.$page_name.'</span>');
						redirect('admin/dashboard');
					}
				}else{
					$CI->session->set_flashdata('permission','<span style="color:red">Access Denied For The Page '.$page_name.'</span>');
					redirect('admin/dashboard');
				}
			}
			else{
				return true;
			}
			
		}
		
		
		
		
		function menuAccess($userid,$roleid)
		{
			
			$CI=& get_instance();
			$menus=$CI->type_model->get_menu_permission($userid);
			//print_r($menus);
			return $menus;
		}
		
		
	}
?>