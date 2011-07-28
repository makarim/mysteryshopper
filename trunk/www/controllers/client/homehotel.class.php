<?php
class homehotel{
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
			redirect("/client.php/index/login");
		}
		$this->tpl->assign('corp',$this->login_corp);
		$view = isset($_GET['view'])?$_GET['view']:"defaults";
		$this->tpl->assign('view',$view);
	}
    function view_defaults(){

		header( "Location: /client.php/homehotel/corpstats");
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
	function view_corpresetpwd(){
		$type = !empty($_GET['view'])?$_GET['view']:"corpresetpwd";
		$this->tpl->assign("type",$type);
	}
	function op_corpresetpwd(){

//		echo "<pre/>";
//		print_r($this->login_corp);

		if (empty ( $_POST ['oldpwd'] ) or empty ( $_POST ['newpwd1'] ) or empty ( $_POST ['newpwd2'] )) {
			show_message_goback(lang('insertpwd'));
		}

		$new1 = $_POST ['newpwd1'];
		$new2 = $_POST ['newpwd2'];
		if (strlen ( $new1 ) < 6 or strlen ( $new2 ) < 6) {
			show_message_goback(lang('pwdrule'));
		}

		if (trim ( $new1 ) != trim ( $new2 )) {
			show_message_goback(lang('pwdnotsame'));;
		}

		include_once("CorporationModel.class.php");

		$corpmod = new CorporationModel();
		//$user_info = $passmod->getUserById($this->login_user['user_id'],$this->login_user['user']);

		//print_r($user_info);
		if ($this->login_corp['c_password'] == md5(md5($_POST ['oldpwd']))) {

			if (false!=$corpmod->updatePwdByCorp ( $this->login_corp['c_id'], md5(md5($new1)) )) {
				show_message_goback(lang('pwdreset'));
			} else {
				show_message_goback(lang('failture'));
			}
		} else {
			show_message_goback(lang('pwdwrong'));
		}

	}

	function isEnglish($str){
		$str = trim($str);

		$preg = '/^[A-Za-z0-9. _-]+$/';
		if(preg_match($preg,$str)) return 'en';
		else return 'zh-cn';
	}

	function view_corpstats(){
		$type = !empty($_GET['view'])?$_GET['view']:"corp";

		$totalcompleted = 0 ;
		include_once("CorporationModel.class.php");
		$corpModel = new CorporationModel();

		//获得a_id
		$corp = $corpModel->getCorporationById($this->login_corp['c_id']);
		$stores = $corpModel->getStoreByCid($this->login_corp['c_id']);

		foreach($stores as $k=>$v){
		$assignment = $corpModel->getStoreLatestCompleted($v['cs_id']);
		$a_id = $assignment['a_id'];
		}

		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
		$attachments = $assignmentModel->getUploadedAttachment($a_id);

		$lang = $_COOKIE['_Selected_Language'];

		$newattachments = array();

		//在这边将attachments中英文名称与非英文名称的PDF分开
		foreach($attachments as $k=>$v){
			if($this->isEnglish($v['f_name']) == $lang){
				$newattachments[$k] = $v;
			}
		}


		$this->tpl->assign("corp",$corp);
		$this->tpl->assign("type",$type);
		$this->tpl->assign("attachments",$newattachments);
	}

}

?>