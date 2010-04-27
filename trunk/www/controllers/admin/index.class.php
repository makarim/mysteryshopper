<?php
class index{
	function __construct(){
		global $tpl;	
		$this->tpl = $tpl;
		$user = authenticate();	
		if(isset($user['user']) && $user['user_id']==1){
			$this->tpl->assign('user',$user);
		}else{
			redirect("/index.php/home");
		}
		
	}
    function view_defaults(){
		
    }   
    function view_menu(){
		
    }    
    function view_main(){
		$this->db = Model::dbConnect($GLOBALS ["gDataBase"] ["db"]);
		
		$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
		$serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
		$dbversion = $this->db->getOne("SELECT VERSION()");
		$fileupload = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : '<font color="red">'.$lang['no'].'</font>';
		$dbsize = 0;
	
		$query = $tables = $this->db->getAll("SHOW TABLE STATUS");
		foreach($tables as $table) {
			$dbsize += $table['Data_length'] + $table['Index_length'];
		}
		$dbsize = $dbsize ? size_unit_convert($dbsize) : $lang['unknown'];
		$dbversion = $this->db->getOne("SELECT VERSION()");
		$magic_quote_gpc = get_magic_quotes_gpc() ? 'On' : 'Off';
		$allow_url_fopen = ini_get('allow_url_fopen') ? 'On' : 'Off';
		$this->tpl->assign('serverinfo', $serverinfo);
		$this->tpl->assign('fileupload', $fileupload);
		$this->tpl->assign('dbsize', $dbsize);
		$this->tpl->assign('dbversion', $dbversion);
		$this->tpl->assign('magic_quote_gpc', $magic_quote_gpc);
		$this->tpl->assign('allow_url_fopen', $allow_url_fopen);
    }
    
    function view_beststore(){
    	
		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		
		$this->tpl->assign('beststore',$corpmod->getBestStoreList());
    }    
    function op_addbeststore(){
    	include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		
		$fileds['rec_month'] = $_POST['cs_month'];
		$fileds['rec_content'] = serialize(array("img"=>$_POST['cs_img'],"cs_name"=>$_POST['cs_name'],"c_title"=>$_POST['cs_title']));
		$fileds['rec_type'] = 'S';
		
		$row= $corpmod->addBestStore($fileds,"recommend");
		if ($row !== false) {
			$msg = array('s'=> 200,'m'=>'ok','d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/admin.php/index/beststore");				
			exit(json_output($msg));
								
		}
    }
    function view_editbeststore(){
    	$rec_id = $_GET['rec_id'];
    	include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		$row = $corpmod->getBestStoreById($rec_id);
		$row['content'] = unserialize($row['rec_content']);
		$this->tpl->assign('info',$row);
    }
    function op_updatebeststore(){
    	include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		
		$fileds['rec_content'] = serialize(array("img"=>$_POST['cs_img'],"cs_name"=>$_POST['cs_name'],"c_title"=>$_POST['cs_title']));
		
		$row= $corpmod->updateBestStore($fileds,$_POST['rec_id']);
		if ($row !== false) {
			show_message_goback("保存成功!");
								
		}
    }
    
    function view_bestshopper(){
    	include_once("UserModel.class.php");
		$usermod = new UserModel();
		$row = $usermod->getBestShopperByMonth(date('Ym'));
		if($row){
			$row['content'] = unserialize($row['rec_content']);
		}else{
			$row['rec_id'] = 0;
			$row['rec_month'] = '';
			$row['content']['user_name'] = '';
			$row['content']['img'] = '';
		}
		$this->tpl->assign('info',$row);
    }
    function op_addbestshopper(){
    	include_once("UserModel.class.php");
		$usermod = new UserModel();
		$fileds['rec_month'] = $_POST['month'];
		$fileds['rec_content'] = serialize(array("user_name"=>$_POST['user_name']));
		$fileds['rec_type'] = 'U';
		$usermod->addBestShopper($fileds,"recommend");
    }
    function view_notice(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'an_id';
		$a_title = !empty($_GET['an_title'])?$_GET['an_title']:'';
		$a_sdate= !empty($_GET['an_date'])?$_GET['an_date']:'';
		
    	include_once("AnnouncementModel.class.php");
		$announcementModel = new AnnouncementModel();
		$con['order'] = $cur_sort;
		$con['an_title'] = $a_title;
		$con['an_date'] = $a_sdate;
	
		$data = $announcementModel->getItems($con,16);
		$this->tpl->assign('data',$data);
		$this->tpl->assign('total',$data['page']->total);
			$this->tpl->assign('con',$con);
    }
    function view_editnotice(){
    	$an_id = $_GET['an_id'];
    	include_once("AnnouncementModel.class.php");
		$announcementModel = new AnnouncementModel();
		$info = $announcementModel->getAnnouncementById($an_id);
		$this->tpl->assign('info',$info);
    }
    function op_updatenotice(){
    	$msg = '';
		if (empty ( $_POST ['an_title'] ) ) {
			$msg = array('s'=> 400,'m'=>lang('a_titlerule'),'d'=>'');				
			exit(json_output($msg));
		}

		$an_id = $_POST['an_id'];

		include_once("AnnouncementModel.class.php");
		$announcementModel = new AnnouncementModel();
	
		$updates['an_title'] = empty($_POST ['an_title'])?"":addslashes($_POST ['an_title']);
		$updates['an_content'] = empty($_POST ['an_content'])?"":addslashes($_POST ['an_content']);
		$updates['an_date'] = empty($_POST ['an_date'])?"":trim($_POST ['an_date']);
		
		
		
		// 1. update db assignment
		$row = $announcementModel->updateNotice( $updates, $an_id);
		if ($row !== false) {

			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>'');				
			exit(json_output($msg));
								
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
    }
    
    function view_addnotice(){
    	
    }
    function op_savenotice(){
    	include_once("AnnouncementModel.class.php");
		$announcementModel = new AnnouncementModel();
		$an['an_title'] = empty($_POST ['an_title'])?"":addslashes($_POST ['an_title']);
		$an['an_content'] = empty($_POST ['an_content'])?"":addslashes($_POST ['an_content']);
		$an['an_date'] = empty($_POST ['an_date'])?"":trim($_POST ['an_date']);
		$row = $announcementModel->createNewAnnouncement($an);
		if ($row !== false) {

			$msg = array('s'=> 200,'m'=>lang('success'),'d'=>'');				
			exit(json_output($msg));
								
		}else{
			$msg = array('s'=> 400,'m'=>lang('failed'),'d'=>'');				
			exit(json_output($msg));
		}
    }
    function op_delnotice(){
    	include_once("AnnouncementModel.class.php");
    	
		$announcementModel = new AnnouncementModel();
		if(is_array($_POST['delete'])){
			foreach ($_POST['delete'] as $an_id){
    			$announcementModel->deleteAnnouncement($an_id);
			}
		}
		show_message(lang('success'));
		goback();
    }
    
    function view_reccomment(){
    	include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		
		$this->tpl->assign('reccomment',$corpmod->getRecComments());
    }
    function op_addreccomment(){
    	include_once("FileUpload.class.php");
		$upload=new FileUpload(APP_DIR."/public/upload/",'jpg|png|gif|jpeg');
		$upload->renamed = true;
		$re = $upload->upload();
		if(!$re){
			$fname_arr=$upload->get_succ_file();
			
			
			if($fname_arr){
				include_once("CorporationModel.class.php");
				$corpmod = new CorporationModel();
    			foreach ($fname_arr as $t){
    				$fileds['rec_month'] = date("Ym");
					$fileds['rec_content'] = serialize(array("img"=>substr(strrchr($t,'/'),1),"user_name"=>$_POST['user_name'],"comment"=>strip_tags($_POST['comment']),"title"=>$_POST['title']));
					$fileds['rec_type'] = 'C';
					
					$row= $corpmod->addBestStore($fileds,"recommend");
					
    			}
				show_message_goback('保存成功!');
				
			}
		}else{
			show_message_goback('保存失败!');		
		}
    }
    function view_editreccomment(){
    	$rec_id = $_GET['rec_id'];
    	include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		$row = $corpmod->getBestStoreById($rec_id);
		$row['content'] = unserialize($row['rec_content']);
		$this->tpl->assign('info',$row);
    }
    function op_updatereccomment(){
    	include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
    	$uploadimg = '';
    	$rec_id = $_POST['rec_id'];
    	$arr  = $corpmod->getRecCommentById($rec_id);
    	$content = unserialize($arr['rec_content']);
    	if ($_FILES['img']['error']==0) {
	    	include_once("FileUpload.class.php");
			$upload=new FileUpload(APP_DIR."/public/upload/",'jpg|png|gif|jpeg');
			$upload->renamed = true;
			$re = $upload->upload();
			if(!$re){
				$fname_arr=$upload->get_succ_file();
			}
			$uploadimg = $fname_arr[0];
		}
	
			if($uploadimg){
    			
				$fileds['rec_content'] = serialize(array("img"=>substr(strrchr($uploadimg,'/'),1),"user_name"=>$_POST['user_name'],"comment"=>strip_tags($_POST['comment']),"title"=>$_POST['title']));
			}else{
				$fileds['rec_content'] = serialize(array("img"=>$content['img'],"user_name"=>$_POST['user_name'],"comment"=>strip_tags($_POST['comment']),"title"=>$_POST['title']));
			}
				$row= $corpmod->updateBestStore($fileds,$_POST['rec_id']);
				if ($row !== false) {
					show_message_goback("保存成功!");
										
				}else{
					show_message_goback('保存失败!');
				}
			
		
    }
}
?>