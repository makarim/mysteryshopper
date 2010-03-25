<?php
class index{
	public $login_corp=false;
	public $tpl;
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		if(isset($_SESSION['_XppassOnlineCorp'])){
			$this->login_corp = $_SESSION['_XppassOnlineCorp'];	
		}
		
		//if(!$this->login_corp){
			//show_message("您还未登录!");
			//redirect("/client.php/index/login");
		//}
		$this->tpl->assign('corp',$this->login_corp);
	}
    function view_defaults(){
		
		$msg = '';	
		$_SESSION['_XppassSignKey'] = uniqid();
		if($this->login_corp){
			$msg = "Welcome ".$this->login_user['user_nickname']."";
		}
		$show_code = 0;
		if(isset($_SESSION['pwd_error'])) {
			$show_code = $_SESSION['pwd_error'];
		}
		
		$this->tpl->assign("name","It's a demo.");
		$this->tpl->assign("msg",$msg);
		$this->tpl->assign ( 'show_code', $show_code );
		$this->tpl->assign ( '_XppassSignKey', $_SESSION['_XppassSignKey'] );
		$this->tpl->assign("scr",'index.php');
    }
    function view_login(){
		$_SESSION['_XppassSignKey'] = uniqid();

		$this->tpl->assign ( '_XppassSignKey', $_SESSION['_XppassSignKey'] );
    }
    function op_dologin() {
		$c_name = $_POST ['user'];
		$passwd = $_POST ['password'];
		$sign = $_POST ['s'];
		$msg ='';
		
		//signature
		if($sign!=hmac($_SESSION['_XppassSignKey'],$passwd)){
			$msg = array('s'=> 400,'m'=>lang('illegalsignon'),'d'=>'');				
			exit(json_output($msg));
		}
		include_once("CorporationModel.class.php");
		$corporation = new CorporationModel();
		$corp_info = $corporation->getCorporationByName($c_name);
		
		if ($corp_info) {
		
			if ($corp_info['c_password'] == md5(($passwd))) {
				if ($corp_info ['c_state'] == 1) {
								
					//auto login
					$_SESSION['_XppassOnlineCorp'] = $corp_info;
					
					$_SESSION['_XppassSignKey'] = '';
				
					$msg = array('s'=> 200,'m'=>"ok",'d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/client.php/home");				
					exit(json_output($msg));
									
				} else {
					$msg = lang('userforbidden');
				}
				
			}else{
				$msg = lang('pwdwrong');
			}
		} else {
				
				$msg = lang('usernotexist');
			
		}	
		$msg = array('s'=> 400,'m'=>$msg,'d'=>'');				
		exit(json_output($msg));
		 		
	}
	function view_logout() {
		//echo COOKIE_DOMAIN;
		setcookie ( 'Xppass_IC_CARD', '', time () - 3600, '/', COOKIE_DOMAIN );
		
		
		unset($_SESSION['_XppassOnlineCorp']);		
		
		
		redirect($GLOBALS ['gSiteInfo'] ['www_site_url']."/client.php/index/login");
	}
	
}
?>