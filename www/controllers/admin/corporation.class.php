<?php
class corporation{
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
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'c_id';
		$corporation = !empty($_GET['corporation'])?$_GET['corporation']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$corporation_nickname = !empty($_GET['corporation_nickname'])?$_GET['corporation_nickname']:'';
		$corporation_reg_time = !empty($_GET['corporation_reg_time'])?$_GET['corporation_reg_time']:'';
		$corporation_reg_time1 = !empty($_GET['corporation_reg_time1'])?$_GET['corporation_reg_time1']:'';
		
		$con['order'] = $cur_sort;
		$con['corporation'] = $corporation;
		$con['c_id'] = $c_id;
		$con['corporation_nickname'] = $corporation_nickname;
		$con['corporation_reg_time'] = $corporation_reg_time;
		$con['corporation_reg_time1'] = $corporation_reg_time1;
		
		include_once("corporationModel.class.php");
		$corporationModel = new corporationModel();
				
		$corporations = $corporationModel->getItems($con,10);
		$this->tpl->assign('total',$corporations['page']->total);
		$this->tpl->assign('corporations',$corporations);
		
    }   

	function view_search(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'c_id';
		$corporation = !empty($_GET['corporation'])?$_GET['corporation']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$corporation_nickname = !empty($_GET['corporation_nickname'])?$_GET['corporation_nickname']:'';
		$corporation_reg_time = !empty($_GET['corporation_reg_time'])?$_GET['corporation_reg_time']:'';
		$corporation_reg_time1 = !empty($_GET['corporation_reg_time1'])?$_GET['corporation_reg_time1']:'';
		
		$con['order'] = $cur_sort;
		$con['corporation'] = $corporation;
		$con['c_id'] = $c_id;
		$con['corporation_nickname'] = $corporation_nickname;
		$con['corporation_reg_time'] = $corporation_reg_time;
		$con['corporation_reg_time1'] = $corporation_reg_time1;
		$this->tpl->assign('con',$con);
	}
	function view_add(){
		
	}
    function op_addcorporation(){
    	$msg = '';
		$reg_type = !empty($_POST['reg_type'])?$_POST['reg_type']:'';
				
		$pattern = "/^[a-zA-Z][a-zA-Z0-9_]{1,13}[a-zA-Z0-9]$/i";
		$pattern2 = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/";
		if($reg_type=='email'){
			if (empty ( $_POST ['email'] ) || ! preg_match ( $pattern2, $_POST ['email'] )) {
				$msg = array('s'=> 400,'m'=>lang('insertemail'),'d'=>'');				
				exit(json_output($msg));
			}
		}
		if (strlen($_POST ['password']) <6) {
			$msg = array('s'=> 400,'m'=>lang('pwdrule'),'d'=>'');				
			exit(json_output($msg));
		}
		$_POST ['nickname'] = trim ( $_POST ['nickname'] );
		$nickname_len = mb_strlen ( $_POST ['nickname'], "UTF-8");
		if (empty ( $_POST ['nickname'] ) || $nickname_len < 2 || $nickname_len > 16) {
			$msg = array('s'=> 400,'m'=>lang('nicknamerule'),'d'=>'');				
			exit(json_output($msg));
		}



		include_once("PassportModel.class.php");
		$passmod = new PassportModel();
	
		if($passmod->checkNickname($_POST ['nickname'])){
			$msg = array('s'=> 400,'m'=>lang('nicknameexist'),'d'=>'');				
			exit(json_output($msg));
		}
		
		if($reg_type=='email'){
			 if($passmod->checkcorporation ( $_POST ['email'] ) || $passmod->isBlockword($_POST ['email'])) {
				$msg = lang('corporationexist');
				$msg = array('s'=> 400,'m'=>lang('corporationexist'),'d'=>'');				
				exit(json_output($msg));
			}
			$corporation['corporation_email'] = $_POST ['email'];
			$corporation['corporation'] = $_POST ['email'];
			$corporation['corporation_question'] = '';
			$corporation['corporation_answer'] = '';
		}
		

		$corporation['corporation_password'] = PassportModel::encryptpwd($_POST ['password'],$corporation['corporation']);
		$corporation['corporation_nickname'] = htmlspecialchars ( $_POST ['nickname'] );
		$corporation['corporation_sex'] = $_POST ['sex'];
		$corporation['corporation_reg_ip'] = getip();
		
		// 1. create db corporation
		$row = $passmod->createNewcorporation ( $corporation );
		if ($row !== false) {

			$msg = array('s'=> 200,'m'=>'ok','d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/corporation/defaults");				
			exit(json_output($msg));
								
		}
    }
    
    function op_delcorporation(){
    	$t = true;
    	if(isset($_POST['delete']) && is_array($_POST['delete'])){
    		include_once("PassportModel.class.php");
    		$passport = new PassportModel();
    		foreach ($_POST['delete'] as $u){
    			
    			$t *= $passport->deletecorporation($u);
    			
    		}
    		
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
    }
    function view_detail(){
    	$corporation = $_GET['corporation'];
    	$c_id = $_GET['c_id'];
    	
    	include_once("PassportModel.class.php");
    	$passport = new PassportModel();
    	$corporationinfo = $passport->getcorporationById($c_id,$corporation);
    	if($corporationinfo){
    		$corporationinfo['corporation_lastlogin_time'] = date("y-m-d H:i:s",$corporationinfo['corporation_lastlogin_time']);
    		if($corporationinfo['corporation_sex']==1) $corporationinfo['corporation_sex'] = lang('boy');
    		if($corporationinfo['corporation_sex']==2) $corporationinfo['corporation_sex'] = lang('girl');
    		$msg = array('s'=> 200,'m'=>'','d'=>$corporationinfo);				
			exit(json_output($msg));
    	}else{
    		$msg = array('s'=> 400,'m'=>lang('corporationnotexist'),'d'=>'');				
			exit(json_output($msg));
    	}
    }
    
    function view_edit(){
    	$corporation = $_GET['corporation'];
    	$c_id = $_GET['c_id'];
    	include_once("PassportModel.class.php");
    	$passport = new PassportModel();
    	$corporationinfo = $passport->getcorporationById($c_id,$corporation);
    	$this->tpl->assign('corporationinfo',$corporationinfo);
    }
    function op_updatecorporation(){
    	$msg = '';
		$reg_type = !empty($_POST['reg_type'])?$_POST['reg_type']:'';
		$_POST ['sex'] = (isset($_POST ['sex']))?$_POST ['sex']:0;		
		
		$pattern2 = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/";
		if($reg_type=='email'){
			if (empty ( $_POST ['email'] ) || ! preg_match ( $pattern2, $_POST ['email'] )) {
				$msg = array('s'=> 400,'m'=>lang('insertemail'),'d'=>'');				
				exit(json_output($msg));
			}
		}
		if (!empty($_POST ['password']) && strlen($_POST ['password']) <6) {
			$msg = array('s'=> 400,'m'=>lang('pwdrule'),'d'=>'');				
			exit(json_output($msg));
		}
		$_POST ['nickname'] = trim ( $_POST ['nickname'] );
		$nickname_len = mb_strlen ( $_POST ['nickname'], "UTF-8");
		if (empty ( $_POST ['nickname'] ) || $nickname_len < 2 || $nickname_len > 16) {
			$msg = array('s'=> 400,'m'=>lang('nicknamerule'),'d'=>'');				
			exit(json_output($msg));
		}
		
		$_POST ['sex'] = intval($_POST ['sex']);
		if (empty($_POST ['sex'])) {
			$msg = array('s'=> 400,'m'=>lang('sexrule'),'d'=>'');				
			exit(json_output($msg));
		}

		$corporation = $_POST['corporation'];
		$c_id = $_POST['c_id'];

		include_once("PassportModel.class.php");
		$passmod = new PassportModel();
	
		$updates['corporation_email'] = $_POST ['email'];
		if($_POST ['password']!='') $updates['corporation_password'] = PassportModel::encryptpwd($_POST ['password'],$corporation);
		$updates['corporation_nickname'] = htmlspecialchars ( $_POST ['nickname'] );
		$updates['corporation_sex'] = $_POST ['sex'];
		
		
		// 1. update db corporation
		$row = $passmod->updatecorporation( $updates, $c_id,$corporation);
		if ($row !== false) {

			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>'');				
			exit(json_output($msg));
								
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
    }
    
    function view_online(){
    	if(SSO_MODE!='ticket') {
    		show_message(lang('module_ban'));
    		die;
    	}
    	$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'ticket';
		$corporation = !empty($_GET['corporation'])?$_GET['corporation']:'';
		
		
		include_once("corporationModel.class.php");
		$corporationModel = new corporationModel();
		
		$con['order'] = $cur_sort;
		$con['corporation'] = $corporation;
		
		$items = $corporationModel->getOnlinecorporations($con,10);

		$this->tpl->assign('corporations',$items);
		$this->tpl->assign('total',$items['page']->total);
		$this->tpl->assign('con',$con);
    }
    function op_delonlinecorporation(){
    	if(SSO_MODE!='ticket') {
    		show_message(lang('module_ban'));
    		die;
    	}
    	$t = true;
    	if(isset($_POST['delete']) && is_array($_POST['delete'])){
    		
    		include_once("PassportModel.class.php");
    		$passport = new PassportModel();
    		foreach ($_POST['delete'] as $ticket){
    			$t *= $passport->deleteTicketById($ticket);
    		}
    		
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
    }
}
?>