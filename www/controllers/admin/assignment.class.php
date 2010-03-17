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

		$a_title = !empty($_GET['a_title'])?$_GET['a_title']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$cs_id= !empty($_GET['cs_id'])?$_GET['cs_id']:'';
		$a_sdate= !empty($_GET['a_sdate'])?$_GET['a_sdate']:'';
		$a_edate= !empty($_GET['a_edate'])?$_GET['a_edate']:'';
		
		$con['order'] = $cur_sort;
		$con['a_title'] = $a_title;
		$con['c_id'] = $c_id;
		$con['cs_id'] = $cs_id;
		$con['a_sdate'] = $a_sdate;
		$con['a_edate'] = $a_edate;
		
		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
				
		$assignments = $assignmentModel->getItems($con,10);
		$this->tpl->assign('total',$assignments['page']->total);
		
		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		$corps  = $corpmod->getAllCorps();
		$this->tpl->assign('corps',$corps);
		$this->tpl->assign('assignments',$assignments);
		$this->tpl->assign('con',$con);
		
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
		
		include_once("ReportModel.class.php");
    	$reportModel = new ReportModel();
    	$reports = $reportModel->getAllReports();
		$this->tpl->assign('corps',$corps);
		$this->tpl->assign('reports',$reports);
	}
    function op_save(){
    	$msg = '';
		
				
		$pattern = "/^[a-zA-Z][a-zA-Z0-9_]{1,13}[a-zA-Z0-9]$/i";
		
		$_POST ['a_title'] = trim ( $_POST ['a_title'] );
		$_POST ['a_sdate'] = trim ( $_POST ['a_sdate'] );
		$_POST ['a_edate'] = trim ( $_POST ['a_edate'] );
		$_POST ['c_id'] = intval( $_POST ['c_id'] );
		$_POST ['cs_id'] = intval ( $_POST ['cs_id'] );
		$_POST ['re_id'] = intval ( $_POST ['re_id'] );
		$_POST ['a_desc'] = strip_tags( $_POST ['a_desc'] );
		$_POST ['a_hasphoto'] = !isset ( $_POST ['a_hasphoto'] )?0:1;
		$_POST ['a_hasaudio'] = !isset ( $_POST ['a_hasaudio'] )?0:1;
		
		if (empty ( $_POST ['a_title'] ) ) {
			$msg = array('s'=> 400,'m'=>lang('a_titlerule'),'d'=>'');				
			exit(json_output($msg));
		}
		

		include_once("AssignmentModel.class.php");
		$assignmentMod = new AssignmentModel();

		$assignment['a_title'] =  $_POST ['a_title'] ;
		$assignment['a_sdate'] =  $_POST ['a_sdate'] ;
		$assignment['a_edate'] =  $_POST ['a_edate'] ;
		$assignment['c_id'] =  $_POST ['c_id'] ;
		$assignment['cs_id'] =  $_POST ['cs_id'] ;
		$assignment['re_id'] =  $_POST ['re_id'] ;
		$assignment['a_desc'] =  $_POST ['a_desc'] ;
		$assignment['a_hasphoto'] =  $_POST ['a_hasphoto'] ;
		$assignment['a_hasaudio'] =  $_POST ['a_hasaudio'] ;
		
		// 1. create db assignment
		$row = $assignmentMod->createNewAssignment ( $assignment );
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
    	$a_id = $_GET['assignment'];
    	
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$assignmentinfo = $assignment->getAssignmentById($a_id);
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
 
    	include_once("CorporationModel.class.php");
    	$corp = new CorporationModel();
    	$corps  = $corp->getAllCorps();
    	
    	
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$info = $assignment->getAssignmentById($a_id);
		
    	$store = $corp->getStoreById($info['cs_id']);
    	$info['cs_abbr'] = $store['cs_abbr'];
    	$info['cs_name'] = $store['cs_name'];
    	
    	
    	include_once("ReportModel.class.php");
    	$reportModel = new ReportModel();
    	$reports = $reportModel->getAllReports();

		$this->tpl->assign('corps',$corps);
		$this->tpl->assign('reports',$reports);
    	$this->tpl->assign('info',$info);
    }
    function op_update(){
    	$msg = '';
		if (empty ( $_POST ['a_title'] ) ) {
			$msg = array('s'=> 400,'m'=>lang('a_titlerule'),'d'=>'');				
			exit(json_output($msg));
		}

		$a_id = $_POST['a_id'];

		include_once("AssignmentModel.class.php");
		$assignment = new AssignmentModel();
	
		$updates['a_title'] = empty($_POST ['a_title'])?"":addslashes($_POST ['a_title']);
		$updates['a_desc'] = empty($_POST ['a_desc'])?"":strip_tags($_POST ['a_desc']);
		$updates['a_sdate'] = empty($_POST ['a_sdate'])?"":trim($_POST ['a_sdate']);
		$updates['a_edate'] =empty($_POST ['a_edate'])?"":trim($_POST ['a_edate']);
		$updates['c_id'] =empty($_POST ['c_id'])?"":intval($_POST ['c_id']);
		$updates['cs_id'] =empty($_POST ['cs_id'])?"":intval($_POST ['cs_id']);
		$updates['re_id'] =empty($_POST ['re_id'])?"":intval($_POST ['re_id']);
		$updates['a_hasphoto'] =!isset($_POST ['a_hasphoto'])?"0":intval($_POST ['a_hasphoto']);
		$updates['a_hasaudio'] =!isset($_POST ['a_hasaudio'])?"":intval($_POST ['a_hasaudio']);
		
		
		// 1. update db assignment
		$row = $assignment->updateAssignment( $updates, $a_id);
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