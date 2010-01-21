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
		$c_name = !empty($_GET['c_name'])?$_GET['c_name']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$c_contacter = !empty($_GET['c_contacter'])?$_GET['c_contacter']:'';
		$c_title = !empty($_GET['c_title'])?$_GET['c_title']:'';
		
		$con['order'] = $cur_sort;
		$con['c_name'] = $c_name;
		$con['c_id'] = $c_id;
		$con['c_contacter'] = $c_contacter;
		$con['c_title'] = $c_title;
		
		include_once("CorporationModel.class.php");
		$corporationModel = new CorporationModel();
				
		$corporations = $corporationModel->getItems($con,10);
		$this->tpl->assign('total',$corporations['page']->total);
		$this->tpl->assign('corporations',$corporations);
		
    }   

	function view_search(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'c_id';
		$c_name = !empty($_GET['c_name'])?$_GET['c_name']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$c_contacter = !empty($_GET['c_contacter'])?$_GET['c_contacter']:'';
		$c_title = !empty($_GET['c_title'])?$_GET['c_title']:'';
		
		$con['order'] = $cur_sort;
		$con['c_name'] = $c_name;
		$con['c_id'] = $c_id;
		$con['c_contacter'] = $c_contacter;
		$con['c_title'] = $c_title;
		$this->tpl->assign('con',$con);
	}
	function view_add(){
		
	}
    function op_addcorporation(){
    	$msg = '';
		
				
		$pattern = "/^[a-zA-Z][a-zA-Z0-9_]{1,13}[a-zA-Z0-9]$/i";
		
		$_POST ['c_name'] = trim ( $_POST ['c_name'] );
		$c_name_len = mb_strlen ( $_POST ['c_name'], "UTF-8");
		if (empty ( $_POST ['c_name'] ) || ! preg_match ( $pattern, $_POST ['c_name'] ) || $c_name_len < 2 || $c_name_len > 16 ) {
			$msg = array('s'=> 400,'m'=>lang('cnamerule'),'d'=>'');				
			exit(json_output($msg));
		}
		
		if (strlen($_POST ['c_password']) <6) {
			$msg = array('s'=> 400,'m'=>lang('pwdrule'),'d'=>'');				
			exit(json_output($msg));
		}
		
		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
	
		if($corpmod->checkName($_POST ['c_name'])){
			$msg = array('s'=> 400,'m'=>lang('cnameexist'),'d'=>'');				
			exit(json_output($msg));
		}	

		$corporation['c_password'] = md5($_POST ['c_password']);
		$corporation['c_name'] =  $_POST ['c_name'] ;
		$corporation['c_title'] = empty($_POST ['c_title'])?"":addslashes($_POST ['c_title']);
		$corporation['c_contacter'] = empty($_POST ['c_contacter'])?"":addslashes($_POST ['c_contacter']);
		$corporation['c_phone'] = empty($_POST ['c_phone'])?"":addslashes($_POST ['c_phone']);
		$corporation['c_intro'] =empty($_POST ['c_intro'])?"":strip_tags($_POST ['c_intro']);
		
		// 1. create db corporation
		$row = $corpmod->createNewCorporation ( $corporation );
		if ($row !== false) {
			$msg = array('s'=> 200,'m'=>'ok','d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/corporation/defaults");				
			exit(json_output($msg));
								
		}
    }
    
    function op_delcorporation(){
    	$t = true;
    	if(isset($_POST['delete']) && is_array($_POST['delete'])){
    		include_once("CorporationModel.class.php");
    		$corporation = new CorporationModel();
    		foreach ($_POST['delete'] as $u){
    			
    			$t *= $corporation->deleteCorporation($u);
    			
    		}
    		
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
    }
    function view_detail(){
    	$corporation = $_GET['corporation'];
    	$c_id = $_GET['c_id'];
    	
    	include_once("CorporationModel.class.php");
    	$corporation = new CorporationModel();
    	$corporationinfo = $corporation->getcorporationById($c_id,$corporation);
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
  
    	$c_id = $_GET['c_id'];
    	include_once("CorporationModel.class.php");
    	$corporation = new CorporationModel();
    	$info = $corporation->getCorporationById($c_id);
    	$this->tpl->assign('info',$info);
    }
    function op_updatecorporation(){
    	$msg = '';
		if(!empty($_POST ['c_password']) && $_POST ['c_password']!=$_POST ['c_password2'] ){
			$msg = array('s'=> 400,'m'=>lang('pwdnotsame'),'d'=>'');				
			exit(json_output($msg));
		}else{
			if (!empty($_POST ['c_password']) && strlen($_POST ['c_password']) <6) {
				$msg = array('s'=> 400,'m'=>lang('pwdrule'),'d'=>'');				
				exit(json_output($msg));
			}else if(!empty($_POST ['c_password'])){
				$updates['c_password'] = md5( $_POST ['c_password']);
			}
			
		}

		$c_id = $_POST['c_id'];

		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
	
		$updates['c_title'] = empty($_POST ['c_title'])?"":addslashes($_POST ['c_title']);
		$updates['c_contacter'] = empty($_POST ['c_contacter'])?"":addslashes($_POST ['c_contacter']);
		$updates['c_phone'] = empty($_POST ['c_phone'])?"":addslashes($_POST ['c_phone']);
		$updates['c_intro'] =empty($_POST ['c_intro'])?"":strip_tags($_POST ['c_intro']);
		
		
		// 1. update db corporation
		$row = $corpmod->updateCorporation( $updates, $c_id);
		if ($row !== false) {

			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>'');				
			exit(json_output($msg));
								
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
    }
    
}
?>