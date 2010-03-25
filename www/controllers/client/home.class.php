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
		
		
    }
	function view_corp(){
		
	}
	function view_corpcontact(){
		
	}
	function view_corpstore(){
		
	}
	
	function view_report(){
		
	}
	function view_shopperdemand(){
		
	}
	function view_quiz(){
		
	}
	function view_overall(){
		$type = !empty($_GET['overall'])?$_GET['overall']:"summary";
		$this->tpl->assign("type",$type);
	}
	function view_environment(){
		$type = !empty($_GET['environment'])?$_GET['environment']:"summary";
		$this->tpl->assign("type",$type);
	}
	function view_service(){
		$type = !empty($_GET['service'])?$_GET['service']:"summary";
		$this->tpl->assign("type",$type);
	}
	function view_product(){
		$type = !empty($_GET['product'])?$_GET['product']:"summary";
		$this->tpl->assign("type",$type);
	}
	
	function view_stores(){
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);
		
		$type = !empty($_GET['stores'])?$_GET['stores']:"summary";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$stores[0]['cs_id'];
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$stores[0]['cs_name'];
		
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
		$type = !empty($_GET['stores'])?$_GET['stores']:"summary";
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:$stores[0]['cs_id'];
		$selstore = isset($_GET['selstore'])?$_GET['selstore']:$stores[0]['cs_name'];
		
		$this->tpl->assign("cs_id",$cs_id);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("sdate",$sdate);
		$this->tpl->assign("edate",$edate);
	}
	
}
?>