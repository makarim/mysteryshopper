<?php
class assignment{
	function __construct(){
		global $tpl;	
		$this->tpl = $tpl;
		$user = authenticate();	
		if(isset($user['user']) && $user['user_id']==1){
			$tpl->assign('user',$user);
		}else{
			redirect(BASE_URL);
		}
		
	}
    function view_defaults(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'a_order';

		$a_id = !empty($_GET['a_id'])?$_GET['a_id']:'';
		$a_desc = !empty($_GET['a_desc'])?$_GET['a_desc']:'';
		$a_title = !empty($_GET['a_title'])?$_GET['a_title']:'';
		
		$con['order'] = $cur_sort;
		$con['a_id'] = $a_id;
		$con['a_desc'] = $a_desc;
		$con['a_title'] = $a_title;
		
		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
				
		$assignments = $assignmentModel->getItems($con,10);
		$this->tpl->assign('total',$assignments['page']->total);
		$this->tpl->assign('assignments',$assignments);
		
    }   

	function view_search(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'a_id';
		$c_name = !empty($_GET['c_name'])?$_GET['c_name']:'';
		$a_id = !empty($_GET['a_id'])?$_GET['a_id']:'';
		$a_desc = !empty($_GET['a_desc'])?$_GET['a_desc']:'';
		$a_title = !empty($_GET['a_title'])?$_GET['a_title']:'';
		
		$con['order'] = $cur_sort;
		$con['c_name'] = $c_name;
		$con['a_id'] = $a_id;
		$con['a_desc'] = $a_desc;
		$con['a_title'] = $a_title;
		$this->tpl->assign('con',$con);
	}
	function view_add(){
		$corps = array();
    	include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		$corps  = $corpmod->getAllCorps();
		$this->tpl->assign('corps',$corps);
	}
    function op_save(){
    	$msg = '';
		
				
		$pattern = "/^[a-zA-Z][a-zA-Z0-9_]{1,13}[a-zA-Z0-9]$/i";
		
		$_POST ['c_name'] = trim ( $_POST ['c_name'] );
		$c_name_len = mb_strlen ( $_POST ['c_name'], "UTF-8");
		if (empty ( $_POST ['c_name'] ) || ! preg_match ( $pattern, $_POST ['c_name'] ) || $c_name_len < 2 || $c_name_len > 16 ) {
			$msg = array('s'=> 400,'m'=>lang('cnamerule'),'d'=>'');				
			exit(json_output($msg));
		}
		
		if (strlen($_POST ['c_password']) <6) {
			$msg = array('s'=> 400,'m'=>lang('pwdrule'),'d'=>'');				
			exit(json_output($msg));
		}
		
		include_once("AssignmentModel.class.php");
		$corpmod = new AssignmentModel();
	
		if($corpmod->checkName($_POST ['c_name'])){
			$msg = array('s'=> 400,'m'=>lang('cnameexist'),'d'=>'');				
			exit(json_output($msg));
		}	

		$assignment['c_password'] = md5($_POST ['c_password']);
		$assignment['c_name'] =  $_POST ['c_name'] ;
		$assignment['a_title'] = empty($_POST ['a_title'])?"":addslashes($_POST ['a_title']);
		$assignment['a_desc'] = empty($_POST ['a_desc'])?"":addslashes($_POST ['a_desc']);
		$assignment['c_phone'] = empty($_POST ['c_phone'])?"":addslashes($_POST ['c_phone']);
		$assignment['c_intro'] =empty($_POST ['c_intro'])?"":strip_tags($_POST ['c_intro']);
		
		// 1. create db assignment
		$row = $corpmod->createNewAssignment ( $assignment );
		if ($row !== false) {
			$msg = array('s'=> 200,'m'=>'ok','d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/assignment/defaults");				
			exit(json_output($msg));
								
		}
    }
    
    function op_delassignment(){
    	$t = true;
    	if(isset($_POST['delete']) && is_array($_POST['delete'])){
    		include_once("AssignmentModel.class.php");
    		$assignment = new AssignmentModel();
    		foreach ($_POST['delete'] as $u){
    			
    			$t *= $assignment->deleteAssignment($u);
    			
    		}
    		
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
    }
    function view_detail(){
    	$assignment = $_GET['assignment'];
    	$a_id = $_GET['a_id'];
    	
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$assignmentinfo = $assignment->getassignmentById($a_id,$assignment);
    	if($assignmentinfo){
    		$assignmentinfo['assignment_lastlogin_time'] = date("y-m-d H:i:s",$assignmentinfo['assignment_lastlogin_time']);
    		if($assignmentinfo['assignment_sex']==1) $assignmentinfo['assignment_sex'] = lang('boy');
    		if($assignmentinfo['assignment_sex']==2) $assignmentinfo['assignment_sex'] = lang('girl');
    		$msg = array('s'=> 200,'m'=>'','d'=>$assignmentinfo);				
			exit(json_output($msg));
    	}else{
    		$msg = array('s'=> 400,'m'=>lang('assignmentnotexist'),'d'=>'');				
			exit(json_output($msg));
    	}
    }
    
    function view_edit(){
  
    	$a_id = $_GET['a_id'];
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$info = $assignment->getAssignmentById($a_id);
    	$this->tpl->assign('info',$info);
    }
    function op_updateassignment(){
    	$msg = '';
		if(!empty($_POST ['c_password']) && $_POST ['c_password']!=$_POST ['c_password2'] ){
			$msg = array('s'=> 400,'m'=>lang('pwdnotsame'),'d'=>'');				
			exit(json_output($msg));
		}else{
			if (!empty($_POST ['c_password']) && strlen($_POST ['c_password']) <6) {
				$msg = array('s'=> 400,'m'=>lang('pwdrule'),'d'=>'');				
				exit(json_output($msg));
			}else if(!empty($_POST ['c_password'])){
				$updates['c_password'] = md5( $_POST ['c_password']);
			}
			
		}

		$a_id = $_POST['a_id'];

		include_once("AssignmentModel.class.php");
		$corpmod = new AssignmentModel();
	
		$updates['a_title'] = empty($_POST ['a_title'])?"":addslashes($_POST ['a_title']);
		$updates['a_desc'] = empty($_POST ['a_desc'])?"":addslashes($_POST ['a_desc']);
		$updates['c_phone'] = empty($_POST ['c_phone'])?"":addslashes($_POST ['c_phone']);
		$updates['c_intro'] =empty($_POST ['c_intro'])?"":strip_tags($_POST ['c_intro']);
		
		
		// 1. update db assignment
		$row = $corpmod->updateAssignment( $updates, $a_id);
		if ($row !== false) {

			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>'');				
			exit(json_output($msg));
								
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
    }
    
}
?>