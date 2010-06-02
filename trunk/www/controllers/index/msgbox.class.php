<?php
class msgbox{
	public $login_user;
	public $tpl;
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		$this->login_user = authenticate();	
		if(!$this->login_user){
			redirect("/index.php/passport/login");
		}
		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		include_once("UserModel.class.php");
		$usermod = new UserModel();
		$bestshopper = $usermod->getBestShopperByMonth(date('Ym'));
		$beststore = $corpmod->getBestStoreByMonth(date('Ym'));
		if($beststore){
			$beststore = unserialize($beststore['rec_content']);
		}		
		if($bestshopper){
			$bestshopper = unserialize($bestshopper['rec_content']);
		}
		$this->tpl->assign('bestshopper',$bestshopper);
		$this->tpl->assign('beststore',$beststore);
		
		$this->tpl->assign('user',$this->login_user);
		$view = isset($_GET['view'])?$_GET['view']:"defaults";
		$this->tpl->assign('view',$view);
		include_once("MsgBoxModel.class.php");
		$this->msgModel = new MsgBoxModel();
	}
    function view_lists(){
		$con['order'] = "m_id";
		//$con['m_pid'] = "0";
		//echo $this->login_user['user_id'];
		$con['to_user_id'] = $this->login_user['user_id'];
		$data = $this->msgModel->getMsgLists($con,10);
		$this->tpl->assign("data",$data);
    }
	function view_read(){
		$m_id = isset($_GET['read'])?intval($_GET['read']):0;
		$msg = $this->msgModel->getMsgById($m_id);
		if($msg){
			$con['flag'] =0;
			$this->msgModel->updateMsg($con,'msg_box'," m_id=".$m_id);
		}
		$reply_data = $this->msgModel->getMsgReplies($m_id);
		$this->tpl->assign("reply_data",$reply_data);
		$this->tpl->assign("msg",$msg);
	}
	function view_write(){
		
	}
	function op_post(){
		$msg = '';
		$field['m_pid'] = 0;
		$field['m_title'] = strip_tags($_POST['title']);
		$field['m_content'] = strip_tags($_POST['content']);
		$field['to_user_id'] = 0;
		$field['from_user_id'] = $this->login_user['user_id'];
		$field['from_user_nickname'] = $this->login_user['user_nickname'];
		$field['to_user_nickname'] = 'admin';
		$field['m_date'] ="MY_F:NOW()";
		
		$rs = $this->msgModel->saveMsg($field,'msg_box');
		if($rs){
			$msg = array('s'=> 200,'m'=>'ok','d'=>'/index.php/msgbox/lists');				
			exit(json_output($msg));
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
			
		}
	}
	
	function op_reply(){
		$msg = '';
		$msg_id = intval($_POST['msg_id']);
		$msg = $this->msgModel->getMsgById($msg_id);
		$field['m_pid'] = $msg_id;
		$field['m_title'] = " Re: ".$msg['m_title'];
		$field['m_content'] = strip_tags($_POST['reply']);
		

		$field['to_user_id'] = $msg['from_user_id'];
		$field['from_user_id'] = $this->login_user['user_id'];
		$field['to_user_nickname'] = $msg['from_user_nickname'];
		$field['from_user_nickname'] = $this->login_user['user_nickname'];
		$field['m_date'] ="MY_F:NOW()";
		
		
		
		$rs = $this->msgModel->saveMsg($field,'msg_box');
		if($rs){
			$msg = array('s'=> 200,'m'=>'ok','d'=>'/index.php/msgbox/read/'.$msg_id);				
			exit(json_output($msg));
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
			
		}
	}
	
	function op_delete(){
		$t = true;
    	if(isset($_POST['id']) && is_array($_POST['id'])){
    		$t =  $this->msgModel->deleteMsg($_POST['id']);
    		if($t) show_message_goback(lang('success'));
    	}
    	show_message(lang('selectone'));
    	goback();
	}
}
?>