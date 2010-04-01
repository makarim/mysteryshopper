<?php
class report{
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		$this->loginuser = authenticate();	
		if(isset($this->loginuser['user']) && $this->loginuser['user_id']==1){
			
		}else{
			redirect("/index.php/passport/login");
		}
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
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'re_id';
		$re_title = !empty($_GET['re_title'])?$_GET['re_title']:'';
		
		
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		
		$con['order'] = $cur_sort;
		$con['re_title'] = $re_title;
		
		$items = $reportModel->getItems($con,10);

		$this->tpl->assign('reports',$items);
		$this->tpl->assign('total',$items['page']->total);
		$this->tpl->assign('con',$con);
	}
	
	function view_addreport(){
		include_once("ReportModel.class.php");
		$ReportModel = new ReportModel();
		$group = $ReportModel->getQuesGroup();
		$arr = array();
		foreach ($group as $g){
			$arr[$g['g_id']] = $g['g_name'];
		}
		$this->tpl->assign("questions",$ReportModel->getAllQuestion());
		$this->tpl->assign("groups",$arr);
	}
	
	function view_editreport(){
		$re_id = $_GET['re_id'];
		include_once("ReportModel.class.php");
		$ReportModel = new ReportModel();
		$group = $ReportModel->getQuesGroup();
		$arr = array();
		foreach ($group as $g){
			$arr[$g['g_id']] = $g['g_name'];
		}
		$questions  = $ReportModel->getAllQuestion();
		$report_questions  = $ReportModel->getQuestionsByReId($re_id);
		$tmp = array();
		foreach ($report_questions as $v){
			$tmp[] = $v['q_id'];
		}
		$leftquestions = array();
		foreach ($questions as $k=>$v){
			if(!in_array($v['q_id'],$tmp)){
				$leftquestions[] = $v;
			}
		}
		$report = $ReportModel->getReportByReId($re_id);
		$this->tpl->assign("questions",$leftquestions);
		$this->tpl->assign("report_questions",$report_questions);
		$this->tpl->assign("report",$report);
		$this->tpl->assign("groups",$arr);
	}
	
	function view_preview(){
		$re_id = $_GET['re_id'];
		$a_id =isset($_GET['a_id'])?$_GET['a_id']:0;
		include_once("AssignmentModel.class.php");
    	$assignmentModel = new AssignmentModel();
    	$assignmentinfo = $assignmentModel->getAssignmentById($a_id);
    	
		include_once("ReportModel.class.php");
		$ReportModel = new ReportModel();
		$report_questions  = $ReportModel->getQuestionsByReId($re_id);
		
		if($report_questions){
			foreach ($report_questions as $k=>$v){
				$v['answer'] = $ReportModel->getAnswerByAid($a_id,$v['rq_id'],$v['rq_type']);
				$report_questions[$k] = $v;
			}
			
		}
		$this->tpl->assign("a_id",$a_id);
		$this->tpl->assign("report_questions",$report_questions);
		$this->tpl->assign("assignmentinfo",$assignmentinfo);
	}
	
	function op_audit(){
		$a_id= $_POST['a_id'];
		include_once("AssignmentModel.class.php");
		$assignment = new AssignmentModel();
		$item['a_auditor'] =$this->loginuser['user_nickname'];
		$item['a_audit'] = $_POST['audit_result'];
		if($item['a_audit']==1) $item['a_finish'] = 0.75;
		if($item['a_audit']==2) $item['a_finish'] = 0.50;
		$item['a_audit_time'] ="MY_F:NOW()";
		$r = $assignment->updateAssignment($item,$a_id);
		if($r){
			$assignment = $assignment->getAssignmentById($a_id);
			$field['m_pid'] = 0;
			$field['m_title'] = "问卷审查通知！";
			$field['m_content'] = '恭喜你，你提交的任务('. $assignment['a_title'].')问卷已经被审查通过。下一步，寄送发票!';
			$field['user_id'] = $assignment['user_id'];
			$field['user_nickname'] = $assignment['user_nickname'];
			$field['m_date'] ="MY_F:NOW()";
			include_once("MsgBoxModel.class.php");
			$msgModel = new MsgBoxModel();
			$rs = $msgModel->saveMsg($field,'msg_box');
			show_message_goback(lang('success'));
			//redirect($GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/assignment/defaults");
		}else{
			show_message_goback(lang('failed'));
		
		}
	}	
	function op_auditbill(){
		$a_id= $_POST['a_id'];
		include_once("AssignmentModel.class.php");
		$assignment = new AssignmentModel();
		$item['a_auditbill'] = $_POST['auditbill_result'];
		$item['a_auditbill_time'] = "MY_F:NOW()";
		$item['a_cost'] = $_POST['bill_cost'];
		$item['a_auditbill_who'] =$this->loginuser['user_nickname'];
		if($item['a_auditbill']==1) $item['a_finish'] = 1;
		if($item['a_auditbill']==2) $item['a_finish'] = 0.75;
		$r = $assignment->updateAssignment($item,$a_id);
		if($r){
			$assignment = $assignment->getAssignmentById($a_id);
			$field['m_pid'] = 0;
			$field['m_title'] = "发票审查通知！";
			$field['m_content'] = '恭喜你，你提交的任务('. $assignment['a_title'].')发票(金额:'.$item['a_cost'].'元)已经被审查通过。我们将会很快打钱到你的账户上!';
			$field['user_id'] = $assignment['user_id'];
			$field['user_nickname'] = $assignment['user_nickname'];
			$field['m_date'] ="MY_F:NOW()";
			include_once("MsgBoxModel.class.php");
			$msgModel = new MsgBoxModel();
			$rs = $msgModel->saveMsg($field,'msg_box');
			show_message_goback(lang('success'));
			//redirect($GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/assignment/defaults");
		}else{
			show_message_goback(lang('failed'));
		
		}
	}
	
	function op_saveanswer(){
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		
		$u_id= $this->loginuser['user_id'];
		$a_id= $_POST['a_id'];
		$r = true;
		if($_POST){
			foreach ($_POST as $k=>$v){
				if(substr($k,0,7)=='rq_ans_'){
					list(,,$rq_type,$rq_id) = split("_",$k);
					$r *=$reportModel->saveAnswer($rq_id,$u_id,$a_id,$rq_type,addslashes($v));
				}
			}
		}
		
		if($r){
			show_message_goback(lang('success'));
			//redirect($GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/assignment/defaults");
		}else{
			show_message_goback(lang('failed'));
		
		}
	} 
	
	function op_savereport(){
		
		$arr['re_title'] = $_POST['re_title'];
		if(empty($arr['re_title'])){
			show_message_goback(lang('required'));
		}
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		$arr['q_id'] = $_POST['toBox'];
		$r = $reportModel->addNewReport($arr);

		if($r){
			show_message(lang('success'));
			redirect($GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/report/defaults");
		}else{
			show_message_goback(lang('failed'));
		
		}
		
	}
	function op_updatereport(){
		$arr['re_title'] = $_POST['re_title'];
		$arr['re_id'] = $_POST['re_id'];
		if(empty($arr['re_title'])){
			show_message_goback(lang('required'));
		}
		include_once("ReportModel.class.php");
		$reportModel = new ReportModel();
		$arr['q_id'] = isset($_POST['toBox'])?$_POST['toBox']:array(0);
		$r = $reportModel->updateReport($arr);

		if($r){
			show_message(lang('success'));
			redirect($GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/report/defaults");
		}else{
			show_message_goback(lang('failed'));
		
		}
	}
	function op_delreport(){
		$t = true;
    	if(isset($_POST['delete']) && is_array($_POST['delete'])){
    		include_once("ReportModel.class.php");
    		$reportModel = new ReportModel();
    		foreach ($_POST['delete'] as $u){
    			$t *= $reportModel->deleteReport($u);
    		}
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
	}
}
?>