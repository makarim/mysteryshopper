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
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");

		list($y,$m,$d) = explode("-",$edate);
			$enddate = date("Y-m-d",mktime(0, 0, 0, $m  , $d+1, $y));

		//echo "sdate=".$sdate."<br/>"."edate=".$edate."<br/>"."endat=".$enddate;

		$totalcompleted = 0 ;
		include_once("CorporationModel.class.php");
		$corpModel = new CorporationModel();
		$brand = array();
		$brands = $corpModel->getBrandByCid($this->login_corp['c_id']);

		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id'];
		}


		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16
		if(!empty($_GET['selbrands']) && ($_GET['selbrands'] != -1)){
			$selbrands = array($_GET['selbrands']);
		}else if(isset($_GET['selbrands']) && ($_GET['selbrands'] == -1)){
			$selbrands = $def_brands;
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}*/

		if(!empty($_GET['selbrands'])){
			$selbrands = array($_GET['selbrands']);
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		$brand_id = isset($selbrands[0])?$selbrands[0]:0;

		//$brand = $corpModel->getBrandById($brand_id);
		$_SESSION['brand_id'] = array($brand_id);


		//$brand_id = !empty($_GET['selbrands'])?$_GET['selbrands']:'';
		//$_SESSION['brand_id'] = $selbrands;//存入全局变量中，以便在其他页面中使用.
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  */

		$corp = $corpModel->getCorporationById($this->login_corp['c_id']);

		if($brand_id) {
		//if(count($selbrands)<=1) {
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;

			$brand = $corpModel->getBrandById($brand_id);
			//$stores = $corpModel->getStoreByBid($brand_id);
			$stores = $corpModel->getStoreByBidAsc($brand_id);
			$totalcompleted = $corpModel->getTotalCompletedAssignmentsByBid($brand_id);

		}else{
			$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
			$totalcompleted = $corpModel->getTotalCompletedAssignments($this->login_corp['c_id']);
			$totalcompleted = $corpModel->getTotalCompletedAssignments($this->login_corp['c_id']);
		}
		//$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		if(isset($stores) && is_array($stores)){
			foreach ($stores as $k=>$v) {
				$v['store_completed'] = $corpModel->getStoreCompletedAssignments($v['cs_id']);
				$v['store_latest_completed'] = $corpModel->getStoreLatestCompleted($v['cs_id']);
				$v['store_next_assignment'] = $corpModel->getStoreNextAssignment($v['cs_id']);

				$v['store_completed_assignments'] = $corpModel->getStoreCompletedAssignmentsBycsid($v['cs_id'],$sdate,$enddate);
				$stores[$k] = $v;
			}
		}

//		echo "<pre/>";
//		print_r($stores);

		$this->tpl->assign("brands",$brands);
		$this->tpl->assign("brand",$brand);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);

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
		$con['a_finish'] = 1;
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
		/****/
		//echo "int=".$internal_average."<br/>";
		/****/
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
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands']) && ($_GET['selbrands'] != -1)){
			$selbrands = array($_GET['selbrands']);
		}else if(isset($_GET['selbrands']) && ($_GET['selbrands'] == -1)){
			$selbrands = $def_brands;
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}
//		echo "<pre/>";
//		print_r($selbrands);

		$_SESSION['brand_id'] = $selbrands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  add by wendy 2010.11.16*/

//		echo "<pre/>"."SESSION=";
//		print_r($_SESSION['brand_id']);

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

		/*******/
//			echo "count selbrands=".count($selbrands)."<br/>";
//			echo "internal_average=".$internal_average;
			/*******/

		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);
	}

	function get_assignment_avg_overall($con,$brand_id,$n=0){
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
					/* 为了在“综合对比”页面的原始数据后增加一列“综览” add by wendy 2010.11.2 */
					$v['general'] = $this->assignmentModel->getSingleSummaryScoreByAsId($v['a_id'],$v['re_id'],$con['type']);

					$a_average += ($v['service']+$v['environment']+$v['product'])/3;
				}
				//$this->assignments[$k] = $v;
				$this->assignments[$n++] = $v;
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

		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands']) && ($_GET['selbrands'] != -1)){
			$selbrands = array($_GET['selbrands']);
		}else if(isset($_GET['selbrands']) && ($_GET['selbrands'] == -1)){
			$selbrands = $def_brands;
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		//$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		$_SESSION['brand_id'] = $selbrands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  add by wendy 2010.11.16*/

		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);

			$internal_average = $this->get_assignment_avg_overall($con,$brand_id);

			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);

		}else{
			$internal_average = 0;
			$n = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_overall($con,$b_id,&$n);
			}
			$internal_average = round($internal_average/count($selbrands),2);
			$this->stores = array();
			$this->selstores = array();
		}

//		echo "<pre/>";
//		print_r($this->assignments);

		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);

	}

	function get_assignment_avg_environment($con,$brand_id,$n=0){
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
//		echo "<pre/>";
//		print_r($con);
//		print_r($assignments);
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
				$v['yesorno'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['yesorno']);
				$v['vote'] = $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$GLOBALS['gTypes']['vote']);
				if($con['type']=='summary') $a_average += $this->assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,'');
				if($con['type']=='yesorno') $a_average += $v['yesorno'];
				if($con['type']=='vote') $a_average += $v['vote'];
				//$this->assignments[$k] = $v;
				$this->assignments[$n++] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		return $internal_average;
	}
	function view_environment(){
		$type = !empty($_GET['environment'])?$_GET['environment']:"summary";

		$con = $this->prepare_con("environment",$type);

		$brands = $this->corpModel->getBrandByCid($this->login_corp['c_id']);

//		echo "<pre/>"."brands";
//		print_r($brands);

		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id'];
		}
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands']) && ($_GET['selbrands'] != -1)){
			$selbrands = array($_GET['selbrands']);
		}else if(isset($_GET['selbrands']) && ($_GET['selbrands'] == -1)){
			$selbrands = $def_brands;
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		//$selbrands = !empty($_GET['selbrands'])?array($_GET['selbrands']):$def_brands;
		$_SESSION['brand_id'] = $selbrands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作 end  add by wendy 2010.11.16*/

		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);

			$internal_average = $this->get_assignment_avg_environment($con,$brand_id);

			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);

		}else{
			$internal_average = 0;
			$n = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_environment($con,$b_id,&$n);
			}
			$internal_average = round($internal_average/count($selbrands),2);
			$this->stores = array();
			$this->selstores = array();
		}

//		echo "type=".$type;
//		echo "<pre/>";
//		print_r($this->assignments);

		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("assignments",$this->assignments);
		$this->tpl->assign("selstores",$this->selstores);
		$this->tpl->assign("stores",$this->stores);
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);

	}

	function get_assignment_avg_service($con,$brand_id,$n=0){
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
				//$this->assignments[$k] = $v;
				$this->assignments[$n++] = $v;
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

		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands']) && ($_GET['selbrands'] != -1)){
			$selbrands = array($_GET['selbrands']);
		}else if(isset($_GET['selbrands']) && ($_GET['selbrands'] == -1)){
			$selbrands = $def_brands;
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		//$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		$_SESSION['brand_id'] = $selbrands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  add by wendy 2010.11.16*/

		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);

			$internal_average = $this->get_assignment_avg_service($con,$brand_id);

			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);

		}else{
			$internal_average = 0;
			$n = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_service($con,$b_id,&$n);
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


	function get_assignment_avg_product($con,$brand_id,$n=0){
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
				//$this->assignments[$k] = $v;
				$this->assignments[$n++] = $v;
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

		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands']) && ($_GET['selbrands'] != -1)){
			$selbrands = array($_GET['selbrands']);
		}else if(isset($_GET['selbrands']) && ($_GET['selbrands'] == -1)){
			$selbrands = $def_brands;
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		//$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		$_SESSION['brand_id'] = $selbrands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  add by wendy 2010.11.16*/

		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;
			$brand = $this->corpModel->getBrandById($brand_id);

			$internal_average = $this->get_assignment_avg_product($con,$brand_id);

			$this->tpl->assign("brand",$brand);
			$this->tpl->assign("brand_id",$brand_id);

		}else{
			$internal_average = 0;
			$n = 0;
			foreach ($selbrands as $b_id){
				$internal_average +=$this->get_assignment_avg_product($con,$b_id,&$n);
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

		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands'])){
			$selbrands = array($_GET['selbrands']);
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}
		//$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  add by wendy 2010.11.16*/

		$brand_id =  isset($selbrands[0])?$selbrands[0]:0;

		$brand = $corpModel->getBrandById($brand_id);
		$_SESSION['brand_id'] = array($brand_id);

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

		$brands = $corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id'];
		}

		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands'])){
			$selbrands = array($_GET['selbrands']);
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		//$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  add by wendy 2010.11.16*/

		$brand_id =  isset($selbrands[0])?$selbrands[0]:0;

		$brand = $corpModel->getBrandById($brand_id);
		$_SESSION['brand_id'] = array($brand_id);

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

		//echo"<pre/>";
		//print_r($stores);

		$def_store_id = isset($stores[0]['cs_id'])?$stores[0]['cs_id']:0;
		$def_store_name = isset($stores[0]['cs_name'])?$stores[0]['cs_name']:'';
		$type = !empty($_GET['stores'])?$_GET['stores']:"summary";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$def_store_id;
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$def_store_name;


		//当该品牌下没有该门店，则显示该品牌下的所有评论
		if( !in_array($cs_id,$store_id_arr)) {
			$cs_id = 0;//这里的值设置的有点问题，当设成-1时，可保证不将其他公司的评论列出。by wendy 20101021.此问题还有待深究
			$selstore= '';
		}
		//echo "cs_id=".$cs_id;
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['order'] = 'a_id';
		$con['selstores'] = $cs_id;
		$con['a_audit'] = 1;
		$con['brand_id'] = $brand_id;//Add by Wendy 2010.10.22 保证只显示本品牌下的评论
		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();

		//echo "<pre/>";
		//print_r($con);

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
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);
	}

	function view_assignment(){
		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();


		include_once("CorporationModel.class.php");
		$corpModel = new CorporationModel();

		$brands = $corpModel->getBrandByCid($this->login_corp['c_id']);
		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id'];
		}

		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands'])){
			$selbrands = array($_GET['selbrands']);
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		//$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:$def_brands;
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  add by wendy 2010.11.16*/

		$brand_id =  isset($selbrands[0])?$selbrands[0]:0;

		$brand = $corpModel->getBrandById($brand_id);
		$_SESSION['brand_id'] = array($brand_id);

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
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$def_store_id;
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$def_store_name;

		if( !in_array($cs_id,$store_id_arr)) {
			$con['selstores'] = $store_id_arr;
			$selstore= '';
		}else{
			$con['selstores'] = $cs_id;
		}

		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		$con['order'] = 'a_fdate';

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
		$this->tpl->assign("selbrands",$selbrands);
		$this->tpl->assign("brands",$brands);
	}

	function view_reportcomplete(){
		/* 半角全角对应的数组 */
		$array = array('<'=>'＜', '>'=>'＞');

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
					$answer = $ReportModel->getAnswerByAid($a_id,$vv['rq_id'],$vv['rq_type']);
					$comment = $ReportModel->getCommentByRqid($a_id,$vv['rq_id']);

					/* 在显示前，将半角的转换为全角的 add by wendy at 20101029*/
//					$answer = strtr($answer,$array);
//					$comment = strtr($comment,$array);
//					$answer = strtr($answer,$array);
//					$comment = strtr($comment,$array);

					/* 将\n转换成<br/> */
//					$vv['answer'] = nl2br($ReportModel->getAnswerByAid($a_id,$vv['rq_id'],$vv['rq_type']));
//					$vv['comment'] = nl2br($ReportModel->getCommentByRqid($a_id,$vv['rq_id']));

					$vv['answer'] = nl2br($answer);
					$vv['comment'] = nl2br($comment);
					$arr[$kk] = $vv;
				}
			}

			$report_questions[$v] = $arr;

		}

		$mystery_shopper_info = $UserModel->getUserInfoById($assignment['user_id'],'gender,birthdate,marital,nationality,householdincome');

		$attachments = $assignmentModel->getUploadedAttachment($a_id);

		$this->tpl->assign("attachments",$attachments);
		$this->tpl->assign("mark_type",$assignment['a_markgrade']);
		$this->tpl->assign("ms_info",$mystery_shopper_info);
		$this->tpl->assign("assignment",$assignment);
		$this->tpl->assign("report_questions",$report_questions);
	}

	function view_corprank(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");

		//echo "type=".$type."<br/>"."sdate=".$sdate."<br/>"."edate=".$edate."<br/>";
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);

		include_once("CorporationModel.class.php");
		$corpModel = new CorporationModel();
		$brand = array();
		$brands = $corpModel->getBrandByCid($this->login_corp['c_id']);

		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id'];
		}

		if(!empty($_GET['selbrands'])){
			$selbrands = array($_GET['selbrands']);
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}

		$brand_id = isset($selbrands[0])?$selbrands[0]:0;

		//$brand = $corpModel->getBrandById($brand_id);
		$_SESSION['brand_id'] = array($brand_id);

		if($brand_id){
			$brand = $corpModel->getBrandById($brand_id);
			$stores = $corpModel->getStoreByBid($brand_id);
		}else{
			$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		}

		include_once("ChartModel.class.php");
		$ChartModel = new ChartModel($sdate,$edate);
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
		$this->tpl->assign('brand',$brand);
		$this->tpl->assign('brands',$brands);
	}

	/***     Add by Wendy 2011.2.18    ***/
	function view_corprankall(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:date("Y-m-d");

		//echo "type=".$type."<br/>"."sdate=".$sdate."<br/>"."edate=".$edate."<br/>";
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);

		//$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$totalcompleted = 0 ;
		include_once("CorporationModel.class.php");
		$corpModel = new CorporationModel();
		$brand = array();
		$brands = $corpModel->getBrandByCid($this->login_corp['c_id']);

		$def_brands = array();
		foreach ($brands as $b){
			$def_brands[] = $b['b_id'];
		}


		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  start  add by wendy 2010.11.16*/
		if(!empty($_GET['selbrands']) && ($_GET['selbrands'] != -1)){
			$selbrands = array($_GET['selbrands']);
		}else if(isset($_GET['selbrands']) && ($_GET['selbrands'] == -1)){
			$selbrands = $def_brands;
		}
		else if(isset($_SESSION['brand_id']) && !empty($_SESSION['brand_id'])){
			$selbrands = $_SESSION['brand_id'];
		}
		else{
			$selbrands = $def_brands;
		}
		//$brand_id = !empty($_GET['selbrands'])?$_GET['selbrands']:'';
		$_SESSION['brand_id'] = $selbrands;//存入全局变量中，以便在其他页面中使用.
		/* 实现选择一次品牌后，其他页面都是对该品牌的操作  end  */

		if(count($selbrands)<=1){
			$brand_id = isset($selbrands[0])?$selbrands[0]:0;

			$brand = $corpModel->getBrandById($brand_id);
			//$stores = $corpModel->getStoreByBid($brand_id);
			$stores = $corpModel->getStoreByBidAsc($brand_id);
		}else{
			$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		}

		include_once("ChartModel.class.php");
		$ChartModel = new ChartModel($sdate,$edate);
		$general = $environment = $service = $product = $store_name= array();
		foreach ($stores as $k=>$store){
			$general[$store['cs_id']]	=  $ChartModel->getGeneralScoreByCsId($store['cs_id']);

			$service[$store['cs_id']]	=  $ChartModel->getSummaryScoreByCsId($store['cs_id'],1);
			$environment[$store['cs_id']]	=  $ChartModel->getSummaryScoreByCsId($store['cs_id'],2);
			$product[$store['cs_id']]	=  $ChartModel->getSummaryScoreByCsId($store['cs_id'],3);
			$store_name[$store['cs_id']] = $store['cs_name'];

			$all['name'] = $store['cs_name'];
			$all['general'] =  $general[$store['cs_id']];
			$all['service'] = $service[$store['cs_id']];
			$all['environment'] = $environment[$store['cs_id']];
			$all['product'] = $product[$store['cs_id']];

			$allrank[$store['cs_id']] = $all;

		}

		$this->tpl->assign("store_name",$store_name);
		$this->tpl->assign("product",$product);
		$this->tpl->assign("service",$service);
		$this->tpl->assign("environment",$environment);
		$this->tpl->assign("general",$general);

		$this->tpl->assign("allrank",$allrank);
		$this->tpl->assign('brands',$brands);
		$this->tpl->assign('brand',$brand);
	}
}
?>