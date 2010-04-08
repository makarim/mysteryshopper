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
	}
	function view_shoppers(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$this->tpl->assign("type",$type);
	}
	function view_quiz(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";
		$this->tpl->assign("type",$type);
	}
	function view_overall(){
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$type = !empty($_GET['overall'])?$_GET['overall']:"summary";
		$def_stores = array();
		
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
//		
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("rq_id",$questions['0']['rq_id']);
		}
		
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
		$def_stores = array();
		
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("rq_id",$questions['0']['rq_id']);
		}
		
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
		$def_stores = array();
		
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("rq_id",$questions['0']['rq_id']);
		}
		
		
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
		$def_stores = array();
		
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:$def_stores;
		
		$con['sdate'] = $sdate;
		$con['edate'] = $edate;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		
		if($type=='time'){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$questions = $ChartModel->getTimeQuestionsByCId($this->login_corp['c_id'],'all');
			$this->tpl->assign("questions",$questions);
			$this->tpl->assign("rq_id",$questions['0']['rq_id']);
		}
		
		
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
			
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = $assignmentModel->getAssignmentsByCsId($con,$cs_id);
		
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
	
}
?>