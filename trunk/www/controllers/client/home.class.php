<?php
class home{
	public $login_corp=false;
	public $tpl;
	private $assignmentModel;
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		if(isset($_SESSION['_XppassOnlineCorp'])){
			$this->login_corp = $_SESSION['_XppassOnlineCorp'];	
		}
		
		if(!$this->login_corp){
			show_message("您还未登录!");
			redirect("/client.php/index/login");
		}
		$this->tpl->assign('corp',$this->login_corp);
		$view = isset($_GET['view'])?$_GET['view']:"defaults";
		$this->tpl->assign('view',$view);
	}
    function view_defaults(){
		
		header( "Location: /client.php/home/corp");
    }
	function view_corp(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$corp = $corpModel->getCorporationById($this->login_corp['c_id']);
		$this->tpl->assign("corp",$corp);
		$this->tpl->assign("type",$type);
	}
	function view_corpcontact(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$corp = $corpModel->getCorporationById($this->login_corp['c_id']);
		$this->tpl->assign("corp",$corp);
		$this->tpl->assign("type",$type);
	}
	function view_corpstore(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
	}
	
	function view_report(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$this->tpl->assign("type",$type);
		
		$re_id = 0;
		include_once("ReportModel.class.php");
    	$ReportModel = new ReportModel();
    	$re_id_arr = $ReportModel->getReportIdByCId($this->login_corp['c_id']);
		//print_r($re_id_arr);
		if(isset( $re_id_arr[0]['re_id'])) $re_id = $re_id_arr[0]['re_id'];
		if($re_id){
			include_once("ReportModel.class.php");
			$ReportModel = new ReportModel();
			$report_questions = array();
			//unset($GLOBALS['gGroups'][5]);
			foreach ($GLOBALS['gGroups'] as $k=>$v){
				$report_questions[$v] = $ReportModel->getQuestionsByReId($re_id,$k);
			}
			
			//$report_questions  = 
			$this->tpl->assign("report_questions",$report_questions);
		}
	}
	function view_shoppers(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$this->tpl->assign("type",$type);
		
		include_once("AssignmentModel.class.php");
    	$this->assignmentModel = new AssignmentModel();
    	$a_id = $this->assignmentModel->getFirstAssignmentByCId($this->login_corp['c_id']);
    	$assignmentinfo = $this->assignmentModel->getAssignmentById($a_id);
    	if(!$assignmentinfo){
    		
    	}
    	$this->tpl->assign('a_id',$a_id);
    	$this->tpl->assign('assignmentinfo',$assignmentinfo);
	}
	function view_quiz(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$this->tpl->assign("type",$type);
		
		include_once("AssignmentModel.class.php");
    	$this->assignmentModel = new AssignmentModel();
    	$a_id = $this->assignmentModel->getFirstAssignmentByCId($this->login_corp['c_id']);
    	$assignmentinfo = $this->assignmentModel->getAssignmentById($a_id);
    	if($assignmentinfo) $quiz = $this->assignmentModel->generateQuiz($assignmentinfo['a_quiz']);
		$this->tpl->assign("quiz",$quiz);
    	$this->tpl->assign('a_id',$a_id);
    	$this->tpl->assign('assignmentinfo',$assignmentinfo);
	}
	function view_description(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$this->tpl->assign("type",$type);
		
		include_once("AssignmentModel.class.php");
    	$this->assignmentModel = new AssignmentModel();
    	$a_id = $this->assignmentModel->getFirstAssignmentByCId($this->login_corp['c_id']);
    	$assignmentinfo = $this->assignmentModel->getAssignmentById($a_id);
    	if(!$assignmentinfo){
    		
    	}
    	$this->tpl->assign('a_id',$a_id);
    	$this->tpl->assign('assignmentinfo',$assignmentinfo);
	}
	
	function view_overall(){
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$type = !empty($_GET['overall'])?$_GET['overall']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$def_stores = array();
		$chart_title = '综览';
		$chart_title.= "/".lang($type);
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['a_audit'] = 1;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			if($questions){
				$rq_id = $questions['0']['rq_id'];
				$this->tpl->assign("questions",$questions);
				$this->tpl->assign("rq_id",$rq_id);
				$chart_title = $questions['0']['rq_question'];
			}
		}
		$count = count($assignments);
		$print_sdate = '';
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				if($k==$count-1 && $sdate=='') $print_sdate = $v['day'];
				if($type=='time'){
					$v['times'] = $assignmentModel->getTimeByRqId($rq_id,$v['a_id']);
				}else{
					$v['service'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$type_id);
					$v['environment'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$type_id);
					$v['product'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$type_id);
				}
				$assignments[$k] = $v;
			}
		}
//		
		if($edate=='') {
			$print_edate = date("Y-m-d");
		}else{
			$print_edate = $edate;
		}
		if($sdate) $print_sdate = $sdate;
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("chart_title",$chart_title);
		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("selstores",$selstores);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	function view_environment(){
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$type = !empty($_GET['environment'])?$_GET['environment']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$def_stores = array();
		$chart_title = '环境';
		$chart_title.= "/".lang($type);
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['a_audit'] = 1;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		$rq_id = '';
		
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'environment');
			if(is_array($questions) && count($questions)>0){
				$rq_id = $questions['0']['rq_id'];
				$chart_title = $questions['0']['rq_question'];
			}else{
				$chart_title = 'No Question!';
			}
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("rq_id",$rq_id);
			
			
		}
		$print_sdate = '';
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				if($k==$count-1 && $sdate=='') $print_sdate = $v['day'];
				if($type=='time'){
					$v['times'] = $assignmentModel->getTimeByRqId($rq_id,$v['a_id']);
				}else{
					$v['yesorno'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['yesorno']);
					$v['vote'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['vote']);
				}
				$assignments[$k] = $v;
			}
		}
//		
		
		if($edate=='') {
			$print_edate = date("Y-m-d");
		}else{
			$print_edate = $edate;
		}
		if($sdate) $print_sdate = $sdate;
		$chart_title .="($print_sdate/$print_edate)";
		$this->tpl->assign("chart_title",$chart_title);
		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("selstores",$selstores);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	function view_service(){
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$type = !empty($_GET['service'])?$_GET['service']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$def_stores = array();
		$chart_title = '服务';
		$chart_title.= "/".lang($type);
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['a_audit'] = 1;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		$rq_id = '';
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'service');
			if(is_array($questions) && count($questions)>0){
				$rq_id = $questions['0']['rq_id'];
				$chart_title = $questions['0']['rq_question'];
			}else{
				$chart_title = 'No Question!';
			}
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("rq_id",$rq_id);
			
			
		}
		$print_sdate = '';
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				if($k==$count-1 && $sdate=='') $print_sdate = $v['day'];
				if($type=='time'){
					$v['times'] = $assignmentModel->getTimeByRqId($rq_id,$v['a_id']);
				}else{
					$v['yesorno'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$GLOBALS['gTypes']['yesorno']);
					$v['vote'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$GLOBALS['gTypes']['vote']);
				}
				$assignments[$k] = $v;
			}
		}
//		
		if($edate=='') {
			$print_edate = date("Y-m-d");
		}else{
			$print_edate = $edate;
		}
		if($sdate) $print_sdate = $sdate;
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("chart_title",$chart_title);
		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("selstores",$selstores);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	function view_product(){
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$type = !empty($_GET['product'])?$_GET['product']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$def_stores = array();
		$chart_title = '产品';
		$chart_title.= "/".lang($type);
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['a_audit'] = 1;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		$rq_id = '';
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'product');
			if(is_array($questions) && count($questions)>0){
				$rq_id = $questions['0']['rq_id'];
				$chart_title = $questions['0']['rq_question'];
			}else{
				$chart_title = 'No Question!';
			}
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("rq_id",$rq_id);
			
			
		}
		$print_sdate = '';
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				if($k==$count-1 && $sdate=='') $print_sdate = $v['day'];
				if($type=='time'){
					$v['times'] = $assignmentModel->getTimeByRqId($rq_id,$v['a_id']);
				}else{
					$v['yesorno'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$GLOBALS['gTypes']['yesorno']);
					$v['vote'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$GLOBALS['gTypes']['vote']);
				}
				$assignments[$k] = $v;
			}
		}
//		
		if($edate=='') {
			$print_edate = date("Y-m-d");
		}else{
			$print_edate = $edate;
		}
		if($sdate) $print_sdate = $sdate;
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("chart_title",$chart_title);
		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("selstores",$selstores);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	
	function view_stores(){
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		$def_store_id = isset($stores[0]['cs_id'])?$stores[0]['cs_id']:0;
		$def_store_name = isset($stores[0]['cs_name'])?$stores[0]['cs_name']:'';
		$type = !empty($_GET['stores'])?$_GET['stores']:"summary";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$def_store_id;
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$def_store_name;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['a_audit'] = 1;
			
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$cs_id);
		$this->tpl->assign("chart_title",$selstore);
		$this->tpl->assign("selstore",$selstore);
		$this->tpl->assign("cs_id",$cs_id);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	
	function view_comments(){
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		
		$def_store_id = isset($stores[0]['cs_id'])?$stores[0]['cs_id']:0;
		$def_store_name = isset($stores[0]['cs_name'])?$stores[0]['cs_name']:'';
		$type = !empty($_GET['stores'])?$_GET['stores']:"summary";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$def_store_id;
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$def_store_name;
		
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['order'] = 'a_id';
		$con['selstores'] = $cs_id;
		$con['a_audit'] = 1;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();

		$assignments = $assignmentModel->getAssignmentComments($con,10);
		//print_sql();

		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("selstore",$selstore);
		$this->tpl->assign("cs_id",$cs_id);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	
	function view_assignment(){
		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
		$myassignment = $assignmentModel->getCorpAssignments($this->login_corp['c_id']);
		$this->tpl->assign("myassignment",$myassignment);
	}
	
	function view_reportcomplete(){
		$re_id = $_GET['re_id'];
		$a_id = $_GET['a_id'];
    	
		include_once("ReportModel.class.php");
		$ReportModel = new ReportModel();
		$report_questions = array();
			foreach ($GLOBALS['gGroups'] as $k=>$v){
				$arr = $ReportModel->getQuestionsByReId($re_id,$k);
				
				if($arr){
					foreach ($arr as $kk=>$vv){
						$vv['answer'] = $ReportModel->getAnswerByAid($a_id,$vv['rq_id'],$vv['rq_type']);
						$arr[$kk] = $vv;
					}
				}
			
				$report_questions[$v] = $arr;
				
			}
		
		$this->tpl->assign("report_questions",$report_questions);
	}
}
?>