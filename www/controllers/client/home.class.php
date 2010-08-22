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
		$brand = array();
		$brands = $corpModel->getBrandByCid($this->login_corp['c_id']);
		
		$brand_id = !empty($_GET['selbrands'])?$_GET['selbrands']:'';
	
		$totalcompleted = $corpModel->getTotalCompletedAssignments($brand_id);
		$corp = $corpModel->getCorporationById($this->login_corp['c_id']);
		
		if($brand_id) {
			$brand = $corpModel->getBrandById($brand_id);
			$stores = $corpModel->getStoreByBid($brand_id);
			$totalcompleted = $corpModel->getTotalCompletedAssignments($brand_id);
		}else{
			$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
			$totalcompleted = $corpModel->getTotalCompletedAssignments($this->login_corp['c_id']);
		}
		//$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		if(isset($stores) && is_array($stores)){
			foreach ($stores as $k=>$v) {
				$v['store_completed'] = $corpModel->getStoreCompletedAssignments($v['cs_id']);
				$v['store_latest_completed'] = $corpModel->getStoreLatestCompleted($v['cs_id']);
				$v['store_next_assignment'] = $corpModel->getStoreNextAssignment($v['cs_id']);
				$stores[$k] = $v;
			}
		}
		
		$this->tpl->assign("brands",$brands);
		$this->tpl->assign("brand",$brand);
		
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
		$quiz = array();
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
			
	function prepare_con($group,$type){
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		
		$chart_title = lang($group);
		if($type!='general') $chart_title.= "/".lang($type);
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['type'] = $type;
		$con['type_id'] = $type_id;
		$con['a_audit'] = 1;
		$this->assignments = $this->selstores= $this->stores = array();
		$internal_average = 0;
		
		include_once("AssignmentModel.class.php");	
		$this->assignmentModel = new AssignmentModel();
		
		include_once("CorporationModel.class.php");	
		$this->corpModel = new CorporationModel();
		
		include_once("ChartModel.class.php"); 
		$this->ChartModel = new ChartModel($sdate,$edate);
			
		$print_edate = $this->assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $this->assignmentModel->getStartDateByCId($this->login_corp['c_id']);
		if($sdate=='') $sdate = $print_sdate;
		if($edate=='') $edate = $print_edate;
		
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("chart_title",$chart_title);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
		return $con;
	}
	
	function get_assignment_avg($con,$brand_id){
		if($brand_id){
			$this->stores = $this->corpModel->getStoreByBid($brand_id);
		}else{
			$this->stores = $this->corpModel->getStoreByCid($this->login_corp['c_id']);
		}
		$def_stores = array();
		foreach ($this->stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$this->selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		$assignments = $this->assignmentModel->getAssignmentsByCsId($con,$this->selstores);
		$count = count($assignments);
		$a_average =$internal_average= 0;
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
					$v['service'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$con['type_id']);;
					$v['environment'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$con['type_id']);
					$v['product'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$con['type_id']);
					$a_average += ($v['service']+$v['environment']+$v['product'])/3; 
				
					$this->assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		return $internal_average;
	}

	function view_general(){
		$type = !empty($_GET['overall'])?$_GET['overall']:"general";
		$con = $this->prepare_con("general",$type);
		
		$brands = $this->corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id']; 
		}
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		
		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);
			$internal_average = $this->get_assignment_avg($con,$brand_id);
			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);
		}else{
			$internal_average = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg($con,$b_id);
			}
			$internal_average = round($internal_average/count($selbrands),2);
			$this->stores = array();
			$this->selstores = array();
		}
		
		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);	
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);
	}
	
	function get_assignment_avg_overall($con,$brand_id){
		if($brand_id){
			$this->stores = $this->corpModel->getStoreByBid($brand_id);
		}else{
			$this->stores = $this->corpModel->getStoreByCid($this->login_corp['c_id']);
		}
		$def_stores = array();
		foreach ($this->stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		
		$this->selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$assignments = $this->assignmentModel->getAssignmentsByCsId($con,$this->selstores);
		
		if($con['type']=='time'){
			$chart_title = '';
			
			$questions = $this->ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			if($questions){
				$this->tpl->assign("questions",$questions);
			}
			$this->tpl->assign("chart_title",$chart_title);
		}
		$count = count($assignments);
		
		$a_average =$internal_average= 0;
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
	
				if($con['type']=='time'){
					foreach ($questions as $qu){
						$v['times'][] = $this->assignmentModel->getTimeByRqId($qu['rq_id'],$v['a_id']);
					}
				}else{
					$v['service'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$con['type_id']);;
					$v['environment'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$con['type_id']);
					$v['product'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$con['type_id']);
					$a_average += ($v['service']+$v['environment']+$v['product'])/3; 
				}
				$this->assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		return $internal_average;
	}
	function view_overall(){
		$type = !empty($_GET['overall'])?$_GET['overall']:"summary";
		$con = $this->prepare_con("overall",$type);
		
		$brands = $this->corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id']; 
		}
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		
		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);
			
			$internal_average = $this->get_assignment_avg_overall($con,$brand_id);
			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);
			
		}else{
			$internal_average = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_overall($con,$b_id);
			}
			$internal_average = round($internal_average/count($selbrands),2);
			$this->stores = array();
			$this->selstores = array();
		}
		
		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);	
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);

	}
	
	function get_assignment_avg_environment($con,$brand_id){
		if($brand_id){
			$this->stores = $this->corpModel->getStoreByBid($brand_id);
		}else{
			$this->stores = $this->corpModel->getStoreByCid($this->login_corp['c_id']);
		}
		$def_stores = array();
		foreach ($this->stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$this->selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$assignments = $this->assignmentModel->getAssignmentsByCsId($con,$this->selstores);
		$a_average = $internal_average= 0;
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				
				$v['yesorno'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['yesorno']);
				$v['vote'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['vote']);
				if($con['type']=='summary') $a_average += $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,'');
				if($con['type']=='yesorno') $a_average += $v['yesorno'];
				if($con['type']=='vote') $a_average += $v['vote'];
				$this->assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		return $internal_average;
	}
	function view_environment(){
		$type = !empty($_GET['environment'])?$_GET['environment']:"summary";
		$con = $this->prepare_con("environment",$type);
		
		$brands = $this->corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id']; 
		}
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);
			
			$internal_average = $this->get_assignment_avg_environment($con,$brand_id);
			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);
			
		}else{
			$internal_average = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_environment($con,$b_id);
			}
			$internal_average = round($internal_average/count($selbrands),2);
			$this->stores = array();
			$this->selstores = array();
		}

		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);	
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);

	}
	
	function get_assignment_avg_service($con,$brand_id){
		if($brand_id){
			$this->stores = $this->corpModel->getStoreByBid($brand_id);
		}else{
			$this->stores = $this->corpModel->getStoreByCid($this->login_corp['c_id']);
		}
		$def_stores = array();
		foreach ($this->stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$this->selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$assignments = $this->assignmentModel->getAssignmentsByCsId($con,$this->selstores);
		$rq_id = '';
		if($con['type']=='time'){
			$chart_title = '';
			
			$questions = $this->ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'service');
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("chart_title",$chart_title);
		}
		$a_average =$internal_average= 0;
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				
				if($con['type']=='time'){
					foreach ($questions as $qu){
						$v['times'][] = $this->assignmentModel->getTimeByRqId($qu['rq_id'],$v['a_id']);
					}
				}else{
					$v['yesorno'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$GLOBALS['gTypes']['yesorno']);
					$v['vote'] =  $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$GLOBALS['gTypes']['vote']);
					if($con['type']=='summary') $a_average +=   $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,'');
					if($con['type']=='yesorno') $a_average += $v['yesorno'];
					if($con['type']=='vote') $a_average += $v['vote'];
				}
				$this->assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		return $internal_average;
	}
	function view_service(){
		$type = !empty($_GET['service'])?$_GET['service']:"summary";
		$con = $this->prepare_con("service",$type);
		
		$brands = $this->corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id']; 
		}
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);
			
			$internal_average = $this->get_assignment_avg_service($con,$brand_id);
			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);
			
		}else{
			$internal_average = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_service($con,$b_id);
			}
			$internal_average = round($internal_average/count($selbrands),2);
			$this->stores = array();
			$this->selstores = array();
		}
		
		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);	
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);

	}
	
	
	function get_assignment_avg_product($con,$brand_id){
		if($brand_id){
			$this->stores = $this->corpModel->getStoreByBid($brand_id);
		}else{
			$this->stores = $this->corpModel->getStoreByCid($this->login_corp['c_id']);
		}
		$def_stores = array();
		foreach ($this->stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$this->selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$assignments = $this->assignmentModel->getAssignmentsByCsId($con,$this->selstores);
		$a_average = $internal_average= 0;
		$count = count($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				
				$v['yesorno'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$GLOBALS['gTypes']['yesorno']);
				$v['vote'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$GLOBALS['gTypes']['vote']);
				if($con['type']=='summary') $a_average += $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,'');
				if($con['type']=='yesorno') $a_average += $v['yesorno'];
				if($con['type']=='vote') $a_average += $v['vote'];
				$this->assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		return $internal_average;
	}
	function view_product(){
		$type = !empty($_GET['product'])?$_GET['product']:"summary";
		$con = $this->prepare_con("product",$type);
		
		$brands = $this->corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id']; 
		}
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);
			
			$internal_average = $this->get_assignment_avg_product($con,$brand_id);
			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);
			
		}else{
			$internal_average = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_product($con,$b_id);
			}
			$internal_average = round($internal_average/count($selbrands),2);
			$this->stores = array();
			$this->selstores = array();
		}
			
		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);	
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);
	}
	
	function view_stores(){
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		
		$brands = $corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id']; 
		}
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
	
		$brand_id =  isset($selbrands[0])?$selbrands[0]:0;
		
		$brand = $corpModel->getBrandById($brand_id);
			
		$this->tpl->assign("brand",$brand);
		
		if($brand_id) {
			$stores = $corpModel->getStoreByBid($brand_id);
		}else{
			$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		}
		$store_id_arr =  array();
		foreach ($stores as $s){
			$store_id_arr[] = $s['cs_id']; 
		}
		
		
		$def_store_id = isset($stores[0]['cs_id'])?$stores[0]['cs_id']:0;
		$def_store_name = isset($stores[0]['cs_name'])?$stores[0]['cs_name']:'';
		$type = !empty($_GET['stores'])?$_GET['stores']:"summary";
		$type_id = isset($GLOBALS['gTypes'][$type])?$GLOBALS['gTypes'][$type]:'';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$def_store_id;
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$def_store_name;
		
		if( !in_array($cs_id,$store_id_arr)) {
			$cs_id = 0;
			$selstore= '';
		}
		
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
		$print_edate = $assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $assignmentModel->getStartDateByCId($this->login_corp['c_id']);
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
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);
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
		
		$print_edate = $assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $assignmentModel->getStartDateByCId($this->login_corp['c_id']);
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
		$con['order'] = 'a_fdate';
		$con['selstores'] = $cs_id;
		$con['c_id'] = $this->login_corp['c_id'];
		
		$myassignment = $assignmentModel->getCorpAssignments($con);
		$this->tpl->assign("myassignment",$myassignment);
		
		$print_edate = $assignmentModel->getEndDateByCId($this->login_corp['c_id']);
		$print_sdate = $assignmentModel->getStartDateByCId($this->login_corp['c_id']);
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
					$vv['answer'] = nl2br($ReportModel->getAnswerByAid($a_id,$vv['rq_id'],$vv['rq_type']));
					$vv['comment'] = nl2br($ReportModel->getCommentByRqid($a_id,$vv['rq_id']));
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
	
	function view_corprank(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$this->tpl->assign("type",$type);
		include_once("ChartModel.class.php"); 
		$ChartModel = new ChartModel();
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		$general = $environment = $service = $product = $store_name= array();
		foreach ($stores as $k=>$store){
			$general[$store['cs_id']]	=  $ChartModel->getGeneralScoreByCsId($store['cs_id']);	
			
			$service[$store['cs_id']]	=  $ChartModel->getSummaryScoreByCsId($store['cs_id'],1);
			$environment[$store['cs_id']]	=  $ChartModel->getSummaryScoreByCsId($store['cs_id'],2);
			$product[$store['cs_id']]	=  $ChartModel->getSummaryScoreByCsId($store['cs_id'],3);
			$store_name[$store['cs_id']] = $store['cs_name'];
		}
		arsort($general);
		arsort($service);
		arsort($environment);
		arsort($product);
		$this->tpl->assign("store_name",$store_name);
		$this->tpl->assign("product",$product);
		$this->tpl->assign("service",$service);
		$this->tpl->assign("environment",$environment);
		$this->tpl->assign("general",$general);
	}
}
?>