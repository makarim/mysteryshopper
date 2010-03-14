<?php
class index{

    function view_defaults(){
		global $tpl;	
		$user = authenticate();	
		$msg = '';	
		$_SESSION['_XppassSignKey'] = uniqid();
		if($user){
			$msg = "Welcome ".$user['user_nickname']."";
		}
		$show_code = 0;
		if(isset($_SESSION['pwd_error'])) {
			$show_code = $_SESSION['pwd_error'];
		}
		$tpl->assign('user',$user);
		$tpl->assign("name","It's a demo.");
		$tpl->assign("msg",$msg);
		$tpl->assign ( 'show_code', $show_code );
		$tpl->assign ( '_XppassSignKey', $_SESSION['_XppassSignKey'] );
		$tpl->assign("scr",'index.php');
    }
    function view_help(){
    	global $tpl;	
    	$test_file = APP_DIR. "/client/test.php";
    	$code = '';
    	if (file_exists($test_file)) {
    		$code = highlight_file($test_file,true);
    	}
    	$tpl->assign('code',$code);
    	
    }
    function view_setlang(){
    	$select = $_GET['setlang'];
    	setcookie("_Selected_Language",$select,time()+3600*24*365,"/");
    	goback(0);
    }
}
?>