<?php
class shopper{
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
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'s_id';
		$shopper = !empty($_GET['shopper'])?$_GET['shopper']:'';
		$s_id = !empty($_GET['s_id'])?$_GET['s_id']:'';
		$shopper_nickname = !empty($_GET['shopper_nickname'])?$_GET['shopper_nickname']:'';
		$shopper_reg_time = !empty($_GET['shopper_reg_time'])?$_GET['shopper_reg_time']:'';
		$shopper_reg_time1 = !empty($_GET['shopper_reg_time1'])?$_GET['shopper_reg_time1']:'';
		
		
		include_once("shopperModel.class.php");
		$shopperModel = new shopperModel();
		
		$con['order'] = $cur_sort;
		$con['shopper'] = $shopper;
		$con['s_id'] = $s_id;
		$con['shopper_nickname'] = $shopper_nickname;
		$con['shopper_reg_time'] = $shopper_reg_time;
		$con['shopper_reg_time1'] = $shopper_reg_time1;
		
		$shoppers = $shopperModel->getItems($con,10);
		$this->tpl->assign('total',$shoppers['page']->total);
		$this->tpl->assign('shoppers',$shoppers);
		$this->tpl->assign('con',$con);
    }   
    function view_menu(){
		global $tpl;	
		

    }    
    function view_main(){
		global $tpl;	
		

    }

    function op_addshopper(){
    	$msg = '';
		$reg_type = !empty($_POST['reg_type'])?$_POST['reg_type']:'';
		$_POST ['sex'] = (isset($_POST ['sex']))?$_POST ['sex']:0;		
		
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
		$_POST ['sex'] = intval($_POST ['sex']);
		if (empty($_POST ['sex'])) {
			$msg = array('s'=> 400,'m'=>lang('sexrule'),'d'=>'');				
			exit(json_output($msg));
		}


		include_once("PassportModel.class.php");
		$passmod = new PassportModel();
	
		if($passmod->checkNickname($_POST ['nickname'])){
			$msg = array('s'=> 400,'m'=>lang('nicknameexist'),'d'=>'');				
			exit(json_output($msg));
		}
		
		if($reg_type=='email'){
			 if($passmod->checkshopper ( $_POST ['email'] ) || $passmod->isBlockword($_POST ['email'])) {
				$msg = lang('shopperexist');
				$msg = array('s'=> 400,'m'=>lang('shopperexist'),'d'=>'');				
				exit(json_output($msg));
			}
			$shopper['shopper_email'] = $_POST ['email'];
			$shopper['shopper'] = $_POST ['email'];
			$shopper['shopper_question'] = '';
			$shopper['shopper_answer'] = '';
		}
		

		$shopper['shopper_password'] = PassportModel::encryptpwd($_POST ['password'],$shopper['shopper']);
		$shopper['shopper_nickname'] = htmlspecialchars ( $_POST ['nickname'] );
		$shopper['shopper_sex'] = $_POST ['sex'];
		$shopper['shopper_reg_ip'] = getip();
		
		// 1. create db shopper
		$row = $passmod->createNewshopper ( $shopper );
		if ($row !== false) {

			$msg = array('s'=> 200,'m'=>'ok','d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/shopper/defaults");				
			exit(json_output($msg));
								
		}
    }
    
    function op_delshopper(){
    	$t = true;
    	if(isset($_POST['delete']) && is_array($_POST['delete'])){
    		include_once("PassportModel.class.php");
    		$passport = new PassportModel();
    		foreach ($_POST['delete'] as $u){
    			
    			$t *= $passport->deleteshopper($u);
    			
    		}
    		
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
    }
    function view_detail(){
    	$shopper = $_GET['shopper'];
    	$s_id = $_GET['s_id'];
    	
    	include_once("PassportModel.class.php");
    	$passport = new PassportModel();
    	$shopperinfo = $passport->getshopperById($s_id,$shopper);
    	if($shopperinfo){
    		$shopperinfo['shopper_lastlogin_time'] = date("y-m-d H:i:s",$shopperinfo['shopper_lastlogin_time']);
    		if($shopperinfo['shopper_sex']==1) $shopperinfo['shopper_sex'] = lang('boy');
    		if($shopperinfo['shopper_sex']==2) $shopperinfo['shopper_sex'] = lang('girl');
    		$msg = array('s'=> 200,'m'=>'','d'=>$shopperinfo);				
			exit(json_output($msg));
    	}else{
    		$msg = array('s'=> 400,'m'=>lang('shoppernotexist'),'d'=>'');				
			exit(json_output($msg));
    	}
    }
    
    function view_edit(){
    	$shopper = $_GET['shopper'];
    	$s_id = $_GET['s_id'];
    	include_once("PassportModel.class.php");
    	$passport = new PassportModel();
    	$shopperinfo = $passport->getshopperById($s_id,$shopper);
    	$this->tpl->assign('shopperinfo',$shopperinfo);
    }
    function op_updateshopper(){
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

		$shopper = $_POST['shopper'];
		$s_id = $_POST['s_id'];

		include_once("PassportModel.class.php");
		$passmod = new PassportModel();
	
		$updates['shopper_email'] = $_POST ['email'];
		if($_POST ['password']!='') $updates['shopper_password'] = PassportModel::encryptpwd($_POST ['password'],$shopper);
		$updates['shopper_nickname'] = htmlspecialchars ( $_POST ['nickname'] );
		$updates['shopper_sex'] = $_POST ['sex'];
		
		
		// 1. update db shopper
		$row = $passmod->updateshopper( $updates, $s_id,$shopper);
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
		$shopper = !empty($_GET['shopper'])?$_GET['shopper']:'';
		
		
		include_once("shopperModel.class.php");
		$shopperModel = new shopperModel();
		
		$con['order'] = $cur_sort;
		$con['shopper'] = $shopper;
		
		$items = $shopperModel->getOnlineshoppers($con,10);

		$this->tpl->assign('shoppers',$items);
		$this->tpl->assign('total',$items['page']->total);
		$this->tpl->assign('con',$con);
    }
    function op_delonlineshopper(){
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