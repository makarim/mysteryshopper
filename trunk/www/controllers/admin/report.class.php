<?php
class report{
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
	}
	function view_question(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'q_id';
		
		$q_question = !empty($_GET['q_question'])?$_GET['q_question']:'';
		$g_id = !empty($_GET['g_id'])?$_GET['g_id']:'';
		
		
		
		include_once("ReportModel.class.php");
		$ReportModel = new ReportModel();
		
		$con['order'] = $cur_sort;
		$con['q_question'] = $q_question;
		$con['g_id'] = $g_id;
		
		$questions = $ReportModel->getQuestion($con,10);
		$quesgroup = $ReportModel->getQuesGroup();
		$this->tpl->assign('total',$questions['page']->total);
		$this->tpl->assign('questions',$questions);
		$this->tpl->assign('quesgroup',$quesgroup);
		$this->tpl->assign('con',$con);
	}
	
	function op_addques(){
		$arr['q_question'] = $_POST['q_question'];
		if(empty($arr['q_question'])){
			$msg = array('s'=> 400,'m'=>lang('need'),'d'=>'');				
			exit(json_output($msg));
		}		
		$arr['q_group'] = $_POST['q_group'];
		if(empty($arr['q_group'])){
			$msg = array('s'=> 400,'m'=>lang('need'),'d'=>'');				
			exit(json_output($msg));
		}		
		
		$arr['q_type'] = $_POST['q_type'];
		if(empty($arr['q_type'])){
			$msg = array('s'=> 400,'m'=>lang('need'),'d'=>'');				
			exit(json_output($msg));
		}
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		
		$r = $reportModel->addNewQuestion($arr);
		
		if($r){
			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/report/question");				
			exit(json_output($msg));
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
		
		
	}
	
	function view_editques(){
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		$q_id = $_GET['q_id'];
		$question = $reportModel->getQuestionById($q_id);
		$this->tpl->assign('question',$question);
		$this->tpl->assign('q_id',$q_id);
		$quesgroup = $reportModel->getQuesGroup();
		$this->tpl->assign('quesgroup',$quesgroup);
	}
	
	function op_updateques(){
		$q_id = $_POST['q_id'];
		$arr['q_question'] = $_POST['q_question'];
		if(empty($arr['q_question'])){
			$msg = array('s'=> 400,'m'=>lang('need'),'d'=>'');				
			exit(json_output($msg));
		}		
		$arr['q_group'] = $_POST['q_group'];
		if(empty($arr['q_group'])){
			$msg = array('s'=> 400,'m'=>lang('need'),'d'=>'');				
			exit(json_output($msg));
		}		
		
		$arr['q_type'] = $_POST['q_type'];
		if(empty($arr['q_type'])){
			$msg = array('s'=> 400,'m'=>lang('need'),'d'=>'');				
			exit(json_output($msg));
		}
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		
		$r = $reportModel->updateQuestion($arr,$q_id);
		
		if($r){
			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/report/question");				
			exit(json_output($msg));
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
	}
	
	function view_defaults(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'report_id';
		$domain = !empty($_GET['domain'])?$_GET['domain']:'';
		
		
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		
		$con['order'] = $cur_sort;
		$con['domain'] = $domain;
		
		$items = $reportModel->getItems($con,10);

		$this->tpl->assign('reports',$items);
		$this->tpl->assign('con',$con);
	}
	
	function view_addreport(){
		
	}
	function op_addreport(){
		$arr['domain'] = $_POST['adddomain'];
		$pattern = "/([\w]+\.[\w]+)/i";
		if(!preg_match($pattern,$arr['domain'])){
			$msg = array('s'=> 400,'m'=>lang('invaliddomain'),'d'=>'');				
			exit(json_output($msg));
		}
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		
		if($row = $reportModel->getClientByName($arr['domain'])){
			$msg = array('s'=> 400,'m'=>lang('domainexist'),'d'=>'');				
			exit(json_output($msg));
		}
		
		$arr['key'] = $reportModel->generateKey();
		
		$r = $reportModel->addNewClient($arr);
		
		if($r){
			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/report/defaults");				
			exit(json_output($msg));
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
		
	}
	function op_delreport(){
		$t = true;
    	if(isset($_POST['delete']) && is_array($_POST['delete'])){
    		include_once("ReportModel.class.php");
    		$reportModel = new ReportModel();
    		foreach ($_POST['delete'] as $u){
    			$t *= $reportModel->deleteClient($u);
    		}
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
	}
}
?>