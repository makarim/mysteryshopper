<?php
class home{
	public $login_user;
	public $tpl;
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		$this->login_user = authenticate();	
		if(!$this->login_user){
			show_message("您还未登录!");
			redirect("/index.php/passport/login");
		}
		$this->tpl->assign('user',$this->login_user);
		$view = isset($_GET['view'])?$_GET['view']:"defaults";
		$this->tpl->assign('view',$view);
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
		$this->tpl->assign("scr",'home.php');
    }


    function view_msgbox(){
    	
    }
    function view_history(){
    	
    }
    function view_allassignment(){
    	$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'a_order';

		$a_title = !empty($_GET['a_title'])?$_GET['a_title']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$cs_id= !empty($_GET['cs_id'])?$_GET['cs_id']:'';
		$a_sdate= !empty($_GET['a_sdate'])?$_GET['a_sdate']:'';
		$a_edate= !empty($_GET['a_edate'])?$_GET['a_edate']:'';
		
		$con['order'] = $cur_sort;
		$con['a_title'] = $a_title;
		$con['c_id'] = $c_id;
		$con['cs_id'] = $cs_id;
		$con['a_sdate'] = $a_sdate;
		$con['a_edate'] = $a_edate;
		$con['notselected'] = 'notselected';
		
		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
				
		$assignments = $assignmentModel->getItems($con,16);
		$this->tpl->assign('assignments',$assignments);
		$this->tpl->assign('total',$assignments['page']->total);
    }    
    function view_assignment(){
    	$a_id = $_GET['assignment'];
    	
    	include_once("AssignmentModel.class.php");
    	$assignment = new AssignmentModel();
    	$assignmentinfo = $assignment->getAssignmentById($a_id);
    	if(!$assignmentinfo){
    		show_message("参数无效！");
    		goback(10000);
    	}
    	$this->tpl->assign('a_id',$a_id);
    	$this->tpl->assign('assignmentinfo',$assignmentinfo);
    }
    function view_mydetail(){
    	
    }
}
?>