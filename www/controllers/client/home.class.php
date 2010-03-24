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
		
	}
	
	function view_comments(){
		
	}
	
}
?>