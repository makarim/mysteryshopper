<?php
class index{
	public $login_user;
	public $tpl;
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		$this->login_user = authenticate();	
		$this->tpl->assign('user',$this->login_user);
	}
    function view_defaults(){
		
		$msg = '';	
		$_SESSION['_XppassSignKey'] = uniqid();
		if($this->login_user){
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

    function view_setlang(){
    	$select = $_GET['setlang'];
    	setcookie("_Selected_Language",$select,time()+3600*24*365,"/");
    	goback(0);
    }
}
?>