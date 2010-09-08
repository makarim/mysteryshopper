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
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'a_id';

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
		$_POST ['b_id'] = intval ( $_POST ['b_id'] );
		$_POST ['a_desc'] = addslashes( $_POST ['a_desc'] );
		$_POST ['a_demand'] = addslashes( $_POST ['a_demand']);
		$_POST ['a_istest'] =  isset($_POST ['a_istest'])?1:0 ;
		$_POST ['a_quiz'] = addslashes( $_POST ['a_quiz'] );
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
		$assignment['b_id'] =  $_POST ['b_id'] ;
		$assignment['a_desc'] =  $_POST ['a_desc'] ;
		$assignment['a_demand'] =  $_POST ['a_demand'] ;
		$assignment['a_istest'] =  $_POST ['a_istest'] ;
		if($assignment['a_istest']==0) $assignment['a_quiz_pass'] = 1 ;
		$assignment['a_quiz'] =  $_POST ['a_quiz'] ;
		$assignment['a_hasphoto'] =  $_POST ['a_hasphoto'] ;
		$assignment['a_hasaudio'] =  $_POST ['a_hasaudio'] ;
		
		// 1. create db assignment
		$row = $assignmentMod->createNewAssignment ( $assignment );
		if ($row !== false) {
			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/assignment/defaults");				
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
 
    function view_edit(){
  
    	$a_id = $_GET['a_id'];
 		$brands = $corp = array();
    	include_once("CorporationModel.class.php");
    	$corp = new CorporationModel();
    	$corps  = $corp->getAllCorps();
    
    	
    	
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$info = $assignment->getAssignmentById($a_id);
		
    	$store = $corp->getStoreById($info['cs_id']);
    
    	$info['cs_abbr'] = $store['cs_abbr'];
    	$info['cs_name'] = $store['cs_name'];
    	$info['b_id'] = $store['b_id'];
    	
    	$brands  = $corp->getBrandByCid($store['c_id']);
    	include_once("ReportModel.class.php");
    	$reportModel = new ReportModel();
    	$reports = $reportModel->getAllReports();

		$this->tpl->assign('corps',$corps);
		$this->tpl->assign('brands',$brands);
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
		$updates['a_desc'] = empty($_POST ['a_desc'])?"":addslashes($_POST ['a_desc']);
		$updates['a_demand'] = empty($_POST ['a_demand'])?"":addslashes($_POST ['a_demand']);
		$updates['a_istest'] = isset($_POST ['a_istest'])?1:0; 
		if($updates['a_istest']==0) $updates['a_quiz_pass'] =1;
		if($updates['a_istest']==1) $updates['a_quiz_pass'] =0;
		$updates['a_quiz'] = empty($_POST ['a_quiz'])?"":($_POST ['a_quiz']);
		$updates['a_sdate'] = empty($_POST ['a_sdate'])?"":trim($_POST ['a_sdate']);
		$updates['a_edate'] =empty($_POST ['a_edate'])?"":trim($_POST ['a_edate']);
		$updates['c_id'] =empty($_POST ['c_id'])?"0":intval($_POST ['c_id']);
		$updates['cs_id'] =empty($_POST ['cs_id'])?"0":intval($_POST ['cs_id']);
		$updates['re_id'] =empty($_POST ['re_id'])?"0":intval($_POST ['re_id']);
		$updates['b_id'] =empty($_POST ['b_id'])?"0":intval($_POST ['b_id']);
		$updates['a_hasphoto'] =!isset($_POST ['a_hasphoto'])?"0":intval($_POST ['a_hasphoto']);
		$updates['a_hasaudio'] =!isset($_POST ['a_hasaudio'])?"0":intval($_POST ['a_hasaudio']);
		
		
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
    
    function view_applicant(){
    	$a_id = $_GET['a_id'];
    	
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$applicant = $assignment->getAssignmentApplicantById($a_id);
    	$this->tpl->assign('applicant',$applicant);
    	$this->tpl->assign('a_id',$a_id);
		
    }
    function op_choose(){
    	$a_id = $_POST['a_id'];
    	$s = $_POST['s'];
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$rs= $assignment->chooseApplicant($a_id,$s);
    	
    	if($rs){
    		$assignment = $assignment->getAssignmentById($a_id);
    		$field['m_pid'] = 0;
			$field['m_title'] = "任务来了！<!--!-->New assignment came!";
			$field['m_content'] = '你申请的任务('.splitx($assignment['a_title']).')已经指派给您。<a href="/index.php/home/assignment/a_id/'.$a_id.'">马上查看任务详情！</a><!--!-->The assignment that you had applied has been assigned to you. <a href="/index.php/home/assignment/a_id/'.$a_id.'">Go to see!</a>';
			$field['to_user_id'] = $assignment['user_id'];
			$field['to_user_nickname'] = $assignment['user_nickname'];
			$field['m_date'] ="MY_F:NOW()";
			include_once("MsgBoxModel.class.php");
			$msgModel = new MsgBoxModel();
			$rs = $msgModel->saveMsg($field,'msg_box');
    	}
    	show_message(lang("success"));
    	//goback( );
    }
    
    function view_assignto(){
    	$a_id = $_GET['a_id'];
 		$this->tpl->assign('a_id',$a_id);
    }
    function op_assignto(){
    	$msg = array('s'=> 400,'m'=>lang('usernotexist'),'d'=>'');		
    	$a_id = $_POST['a_id'];
    	$user = $_POST['user'];
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$rs= $assignment->assignToUser($a_id,$user);
    	
    	if($rs){
    		$assignment = $assignment->getAssignmentById($a_id);
    		$field['m_pid'] = 0;
			$field['m_title'] = "任务来了！<!--!-->New assignment came!";
			$field['m_content'] = '你申请的任务('.splitx($assignment['a_title']).')已经指派给您。<a href="/index.php/home/assignment/a_id/'.$a_id.'">马上查看任务详情！</a><!--!-->The assignment that you had applied has been assigned to you. <a href="/index.php/home/assignment/a_id/'.$a_id.'">Go to see!</a>';
			$field['to_user_id'] = $assignment['user_id'];
			$field['to_user_nickname'] = $assignment['user_nickname'];
			$field['m_date'] ="MY_F:NOW()";
			include_once("MsgBoxModel.class.php");
			$msgModel = new MsgBoxModel();
			$rs = $msgModel->saveMsg($field,'msg_box');
			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>'');	
    	}
    			
		exit(json_output($msg));
    }
}
?>