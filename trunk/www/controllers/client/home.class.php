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
			redirect("/client.php/index/login");
		}
		$this->tpl->assign('corp',$this->login_corp);
		$view = isset($_GET['view'])?$_GET['view']:"defaults";
		$this->tpl->assign('view',$view);
	}
    function view_defaults(){
		
		header( "Location: /client.php/home/corpstats");
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
	function view_corpstats(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$totalcompleted = 0 ;
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$totalcompleted = $corpModel->getTotalCompletedAssignments($this->login_corp['c_id']);
		$corp = $corpModel->getCorporationById($this->login_corp['c_id']);
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		if(isset($stores) && is_array($stores)){
			foreach ($stores as $k=>$v) {
				$v['store_completed'] = $corpModel->getStoreCompletedAssignments($v['cs_id']);
				$v['store_latest_completed'] = $corpModel->getStoreLatestCompleted($v['cs_id']);
				$v['store_next_assignment'] = $corpModel->getStoreNextAssignment($v['cs_id']);
				$stores[$k] = $v;
			}
		}
		$this->tpl->assign("corp",$corp);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("totalcompleted",$totalcompleted);
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
    	$tmp = explode("\n",$assignmentinfo['a_desc']);
		$arr = array();
		if(is_array($tmp)){
			foreach ($tmp as $t){
				$t = trim($t);
				if($t){
					if(strpos(".",$t)!==false) $t = explode(".",$t);
					$arr[] = $t;
				}
			}
		}
		$assignmentinfo['a_desc']= $arr;
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
    	
    	$tmp = explode("\n",$assignmentinfo['a_demand']);
		$arr = array();
		if(is_array($tmp)){
			foreach ($tmp as $t){
				$t = trim($t);
				if($t){
					if(strpos(".",$t)!==false) $t = explode(".",$t);
					$arr[] = $t;
				}
			}
		}
		$assignmentinfo['a_demand']= $arr;
    	
    	$this->tpl->assign('a_id',$a_id);
    	$this->tpl->assign('assignmentinfo',$assignmentinfo);
	}
	
	function view_overall(){
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$type = !empty($_GET['overall'])?$_GET['overall']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
	
		$def_stores = array();
		$chart_title = lang("summary");
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
			$chart_title = '';
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			if($questions){
				$this->tpl->assign("questions",$questions);
			}
		}
		$count = count($assignments);
		
		$a_average =$internal_average= 0;
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
	
				if($type=='time'){
					foreach ($questions as $qu){
						$v['times'][] = $assignmentModel->getTimeByRqId($qu['rq_id'],$v['a_id']);
					}
				}else{
					$v['service'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$type_id);;
					$v['environment'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$type_id);
					$v['product'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$type_id);
					$a_average += ($v['service']+$v['environment']+$v['product'])/3; 
				}
				$assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		
		$print_edate = $assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $assignmentModel->getStartDateByCId($this->login_corp['c_id']);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("internal_average",$internal_average);
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
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$type = !empty($_GET['environment'])?$_GET['environment']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$def_stores = array();
		$chart_title = lang("environment");
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
		
		
		$a_average =$internal_average= 0;
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				
				$v['yesorno'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['yesorno']);
				$v['vote'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['vote']);
				if($type=='summary') $a_average += ($v['yesorno']+$v['vote'])/2;
				if($type=='yesorno') $a_average += $v['yesorno'];
				if($type=='vote') $a_average += $v['vote'];
				$assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}

		$print_edate = $assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $assignmentModel->getStartDateByCId($this->login_corp['c_id']);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("internal_average",$internal_average);
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
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$type = !empty($_GET['service'])?$_GET['service']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$def_stores = array();
		$chart_title = lang("service");
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
			$chart_title = '';
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'service');
			$this->tpl->assign("questions",$questions);
		}
		$a_average =$internal_average= 0;
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				
				if($type=='time'){
					foreach ($questions as $qu){
						$v['times'][] = $assignmentModel->getTimeByRqId($qu['rq_id'],$v['a_id']);
					}
				}else{
					$v['yesorno'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$GLOBALS['gTypes']['yesorno']);
					$v['vote'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$GLOBALS['gTypes']['vote']);
					if($type=='summary') $a_average += ($v['yesorno']+$v['vote'])/2;
					if($type=='yesorno') $a_average += $v['yesorno'];
					if($type=='vote') $a_average += $v['vote'];
				}
				$assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
//		

		$print_edate = $assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $assignmentModel->getStartDateByCId($this->login_corp['c_id']);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("internal_average",$internal_average);
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
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$type = !empty($_GET['product'])?$_GET['product']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$def_stores = array();
		$chart_title = lang("product");
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
		
		$a_average =$internal_average= 0;
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				$v['yesorno'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$GLOBALS['gTypes']['yesorno']);
				$v['vote'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$GLOBALS['gTypes']['vote']);
				//echo $v['yesorno'];
				if($type=='summary') {
					if($v['yesorno']!='-'&& $v['vote']!='-') $a_average += ($v['yesorno']+$v['vote'])/2;
					elseif ($v['yesorno']=='-' || $v['vote']=='-') $a_average += ($v['yesorno']+$v['vote']);
				}
				if($type=='yesorno') $a_average += $v['yesorno'];
				if($type=='vote') $a_average += $v['vote'];
				$assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		$print_edate = $assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $assignmentModel->getStartDateByCId($this->login_corp['c_id']);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;
		$chart_title .="($print_sdate/$print_edate)";
	
		$this->tpl->assign("internal_average",$internal_average);
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
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$def_store_id;
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$def_store_name;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['a_audit'] = 1;
		
		if($type=='time'){
			$chart_title = '';
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			if($questions){
				$this->tpl->assign("questions",$questions);
			}
		}	
		
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$cs_id);
		
		
	
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
	
				if($type=='time'){
					foreach ($questions as $qu){
						$v['times'][] = $assignmentModel->getTimeByRqId($qu['rq_id'],$v['a_id']);
					}
				}else{
					$v['service'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$type_id);;
					$v['environment'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$type_id);
					$v['product'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$type_id);
				}
				$assignments[$k] = $v;
			}
			
		}
		
		$print_edate = $assignmentModel->getEndDateByCsId($cs_id);
		$print_sdate = $assignmentModel->getStartDateByCsId($cs_id);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;
		
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
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
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
		
		$print_edate = $assignmentModel->getEndDateByCsId($cs_id);
		$print_sdate = $assignmentModel->getStartDateByCsId($cs_id);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;

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
		
		
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		
		
		$def_store_id = isset($stores[0]['cs_id'])?$stores[0]['cs_id']:0;
		$def_store_name = isset($stores[0]['cs_name'])?$stores[0]['cs_name']:'';
		$type = !empty($_GET['stores'])?$_GET['stores']:"summary";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$def_store_id;
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$def_store_name;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['order'] = 'a_edate';
		$con['selstores'] = $cs_id;
		$con['c_id'] = $this->login_corp['c_id'];
		
		$myassignment = $assignmentModel->getCorpAssignments($con);
		$this->tpl->assign("myassignment",$myassignment);
		
		$print_edate = $assignmentModel->getEndDateByCsId($cs_id);
		$print_sdate = $assignmentModel->getStartDateByCsId($cs_id);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;
		$this->tpl->assign("selstore",$selstore);
		$this->tpl->assign("cs_id",$cs_id);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	
	function view_reportcomplete(){
		$re_id = $_GET['re_id'];
		$a_id = $_GET['a_id'];
    	include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
		$assignment = $assignmentModel->getAssignmentById($a_id);
		include_once("ReportModel.class.php");
		$ReportModel = new ReportModel();		
		include_once("UserModel.class.php");
		$UserModel = new UserModel();
		
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
	
		$mystery_shopper_info = $UserModel->getUserInfoById($assignment['user_id'],'gender,birthdate,marital,nationality,householdincome');
		
		$attachments = $assignmentModel->getUploadedAttachment($a_id);
		$this->tpl->assign("attachments",$attachments);
		
		$this->tpl->assign("ms_info",$mystery_shopper_info);
		$this->tpl->assign("assignment",$assignment);
		$this->tpl->assign("report_questions",$report_questions);
	}
}
?>