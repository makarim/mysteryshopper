<?php
class home{
	public $login_user;
	public $tpl;
	private $assignmentModel;
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		$this->login_user = authenticate();	
		if(!$this->login_user){
			show_message("您还未登录!");
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
	}
    function view_defaults(){
		
		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
		$myassignment = $assignmentModel->getMyAssignments($this->login_user['user_id']);
		$lastestassignment = $assignmentModel->getLastestAssignments();
		
		include_once("AnnouncementModel.class.php");
		$announcementModel = new AnnouncementModel();
		$latestan = $announcementModel->getLatestAnnouncement(3);
		
		$reccomments = $announcementModel->getLastRecComments(10);
		$this->tpl->assign("reccomments",$reccomments);
		$this->tpl->assign("latestan",$latestan);
		$this->tpl->assign("lastestassignment",$lastestassignment);
		$this->tpl->assign("myassignment",$myassignment);
    }


    function view_msgbox(){
    	
    }
    function view_history(){
    	include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
		$myassignment = $assignmentModel->getMyHistoryAssignments($this->login_user['user_id']);
		$this->tpl->assign("myassignment",$myassignment);
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
    function get_assignment($a_id){	
    	include_once("AssignmentModel.class.php");
    	$this->assignmentModel = new AssignmentModel();
    	$assignmentinfo = $this->assignmentModel->getAssignmentById($a_id);
    	if(!$assignmentinfo){
    		show_message("参数无效！");
    		goback(10000);
    	}
    
    	$is_view = '0';
		if($assignmentinfo['user_id']==$this->login_user['user_id']){
			$is_view =1;
		}
		$do_quiz = '';
		if(isset($_SESSION['a_'.$a_id]['pass']) && $_SESSION['a_'.$a_id]['pass']==1){
			$do_quiz = 'pass';
		}
		if(isset($_SESSION['a_'.$a_id]['pass']) && $_SESSION['a_'.$a_id]['pass']==0){
			$do_quiz = 'fail';
		}
		
		if($assignmentinfo['a_fdate']=='0000-00-00 00:00:00' && $assignmentinfo['a_audit']==0){
			$is_submitted = 0;
		}elseif($assignmentinfo['a_audit']==2){
			$is_submitted =2;	
		}elseif($assignmentinfo['a_audit']==1){
			$is_submitted =1;	
		}elseif($assignmentinfo['a_audit']==0 && $assignmentinfo['a_fdate']!='0000-00-00 00:00:00'){
			$is_submitted = 3;
		}
		$tmp = explode("\n",$assignmentinfo['a_desc']);
		$arr = array();
		if(is_array($tmp)){
			foreach ($tmp as $t){
				$t = trim($t);
				if($t){
					if(strpos(".",$t)!==false) $t = explode(".",$t);
					$arr[] = $t;
				}
			}
		}
		$assignmentinfo['a_desc']= $arr;
		$tmp = explode("\n",$assignmentinfo['a_demand']);
		$arr2 = array();
		if(is_array($tmp)){
			foreach ($tmp as $t){
				$t = trim($t);
				if($t){
					if(strpos(".",$t)!==false) $t = explode(".",$t);
					$arr2[] = $t;
				}
			}
		}
		
		$assignmentinfo['a_demand']= $arr2;
		$this->tpl->assign("is_submitted",$is_submitted);
		$this->tpl->assign("do_quiz",$do_quiz);
		$this->tpl->assign("is_view",$is_view);
		$this->tpl->assign('a_id',$a_id);
    	$this->tpl->assign('assignmentinfo',$assignmentinfo);
    	return $assignmentinfo;
    }
    function view_assignment(){
    	$a_id = isset($_GET['a_id'])?intval($_GET['a_id']):'0';
    	$this->get_assignment($a_id);

    }  
    function view_demand(){
    	$a_id = isset($_GET['a_id'])?intval($_GET['a_id']):'0';
    	$this->get_assignment($a_id);

    }
	function view_reportpreview(){
		$a_id = isset($_GET['a_id'])?intval($_GET['a_id']):'0';
		$assignment = $this->get_assignment($a_id);
		$re_id = $assignment['re_id'];
		include_once("ReportModel.class.php");
		$ReportModel = new ReportModel();
		$report_questions = array();
		foreach ($GLOBALS['gGroups'] as $k=>$v){
			$report_questions[$v] = $ReportModel->getQuestionsByReId($re_id,$k);
		}
		$this->tpl->assign("report_questions",$report_questions);
	}
	function view_quiz(){
		$a_id = isset($_GET['a_id'])?intval($_GET['a_id']):'0';
		
		
		$assignment = $this->get_assignment($a_id);
		$quiz = $this->assignmentModel->generateQuiz($assignment['a_quiz']);
		$this->tpl->assign("quiz",$quiz);

		
	}
	function op_doquiz(){
		$a_id = isset($_POST['a_id'])?intval($_POST['a_id']):'0';
		$this->get_assignment($a_id);
		$count = isset($_POST['num'])?intval($_POST['num']):0;
		$a_id = isset($_POST['a_id'])?intval($_POST['a_id']):0;
		$pass = 0;
		if($count>0){
			for ($i=0;$i<$count;$i++){
				if(isset($_POST['option_'.$i]) && isset($_POST['hida_'.$i]) && $_POST['option_'.$i]==$_POST['hida_'.$i]){
					$pass++;
				}
			}
			if($pass==$count){
				$_SESSION['a_'.$a_id]['pass'] = 1;
				$item['a_quiz_pass'] =1;
				$item['a_finish'] =0.25;
				$item['a_quiz_passtime'] ="MY_F:NOW()";
				$this->assignmentModel->updateAssignment($item,$a_id);
				show_message("恭喜您！测试通过！您可以执行任务了！");
				redirect("/index.php/home/report/a_id/$a_id",2);
			}else{
				$_SESSION['a_'.$a_id]['pass'] = 0;
			}
		}
		goback(0);
	}
	function view_report(){
		$a_id = isset($_GET['a_id'])?intval($_GET['a_id']):'0';
		$assignment = $this->get_assignment($a_id);
	
		$re_id = $assignment['re_id'];
		$a_id =isset($_GET['a_id'])?$_GET['a_id']:0;
		
		if($assignment['user_id']==$this->login_user['user_id']){
		
			include_once("ReportModel.class.php");
			$ReportModel = new ReportModel();
			$report_questions = array();
			foreach ($GLOBALS['gGroups'] as $k=>$v){
				$arr = $ReportModel->getQuestionsByReId($re_id,$k);
				
				if($arr){
					foreach ($arr as $kk=>$vv){
						$vv['answer'] = $ReportModel->getAnswerByAid($a_id,$vv['rq_id'],$vv['rq_type']);
						$arr[$kk] = $vv;
					}
				}
			
				$report_questions[$v] = $arr;
				
			}
		
			$this->tpl->assign("report_questions",$report_questions);
		}
	
	}
	function op_savereport(){
		include_once("ReportModel.class.php");
		include_once("AssignmentModel.class.php");
		$assignment = new AssignmentModel();
		$reportModel = new ReportModel();
		$u_id= $this->login_user['user_id'];
		$a_id= $_POST['a_id'];
		$r = true;
		if($_POST){
			foreach ($_POST as $k=>$v){
				if(substr($k,0,7)=='rq_ans_'){
					list(,,$rq_type,$rq_id) = split("_",$k);
					$r *=$reportModel->saveAnswer($rq_id,$u_id,$a_id,$rq_type,addslashes($v));
				}
			}
			
		}
		
		if($r){
			$updates['a_fdate'] = "MY_F:NOW()";
			$updates['a_finish'] =0.50;
			$assignment->updateAssignment($updates,$a_id);
			show_message_goback(lang('success'));
		}else{
			show_message_goback(lang('failed'));
		
		}
	}
	
	function op_apply(){
		$rs = false;
		$a_id = isset($_POST['a_id'])?intval($_POST['a_id']):'0';
		$this->get_assignment($a_id);
		$count = $this->assignmentModel->getAssignmentApplyCountById($a_id);
		if($count<3){
			$r = $this->assignmentModel->isApplied($a_id,$this->login_user['user_id']);
			if($r>0){
				show_message_goback("你已经报过名了！");
			}else{
				$rs=$this->assignmentModel->apply($a_id,$this->login_user['user_id']);
			}
		}
		if($rs){
			show_message("恭喜您，报名成功！如果您从被选中，我们会联系您！");
			unset($_SESSION['a_'.$a_id]['pass']);
			redirect("/index.php/home/allassignment/a_id/$a_id",2);
		}else{
			show_message("对不起，名额已满！请选择其他任务！");
			redirect("/index.php/home/allassignment");
		}
	}
	function view_upload(){
		$a_id = isset($_GET['a_id'])?intval($_GET['a_id']):'0';
		$this->get_assignment($a_id);
		$attachments = $this->assignmentModel->getUploadedAttachment($a_id);
		$this->tpl->assign("attachments",$attachments);
	}
	function op_upload(){
		include_once("FileUpload.class.php");
		$a_id = isset($_POST['a_id'])?$_POST['a_id']:0;
		$upload=new FileUpload(APP_DIR."/public/upload/",'jpg|png|gif|jpeg|mp3|wma');
		$upload->renamed = true;
		$re = $upload->upload();
		if(!$re){
			$fname_arr=$upload->get_succ_file();
			
			
			if($fname_arr){
				include_once("AssignmentModel.class.php");
    			$this->assignmentModel = new AssignmentModel();
    			foreach ($fname_arr as $t){
	    			$fields['f_name'] = substr(strrchr($t,'/'),1);
	    			$fields['a_id'] = $a_id;
	    			$fields['f_created'] = 'MY_F:NOW()';
					$this->assignmentModel->saveAttachment($fields,"assignment_attachment");
    			}
				show_message_goback('上传成功!');
				
			}
		}else{
			show_message_goback('上传失败!');		
		}
		
	}
    
    function view_mydetail(){
    	$type = !empty($_GET['mydetail'])?$_GET['mydetail']:"contact";
    	include_once("PassportModel.class.php");
    	$passmod = new PassportModel();
		$userinfo  = $passmod->getUserInfoById($this->login_user['user_id']);
    	list($userinfo['year'],$userinfo['month'],$userinfo['day']) = explode("-",$userinfo['birthdate']);
    	$this->tpl->assign("type",$type);
    	$this->tpl->assign("userinfo",$userinfo);
    
    	//$rs = $passmod->saveUserExt ( $user ,$this->login_user['user_id']);
    }
    function op_updateuserdetail(){
    	include_once("PassportModel.class.php");
    	$type = isset($_POST['type'])?$_POST['type']:"";
    	$user = array();
    	$msg ='';
    	switch ($type){
    		
    		case "contact":
    			$user['realname'] = !empty($_POST['realname'])?$_POST['realname']:'';
    			$user['gender'] = !empty($_POST['gender'])?$_POST['gender']:'0';
				$user['mobile'] = !empty($_POST['mobile'])?$_POST['mobile']:'';
				$user['phone'] = !empty($_POST['phone'])?$_POST['phone']:'';
				$user['qq'] = !empty($_POST['qq'])?$_POST['qq']:'';
				$user['msn'] = !empty($_POST['msn'])?$_POST['msn']:'';
				$user['province'] = !empty($_POST['province'])?$_POST['province']:'';
				$user['city'] = !empty($_POST['city'])?$_POST['city']:'';
				$user['area'] = !empty($_POST['area'])?$_POST['area']:'';
				$user['address'] = !empty($_POST['address'])?addslashes($_POST['address']):'';
    		break;
    		case "extinfo":
    			
    			$birthdateyear = !empty($_POST['birthdateyear'])?$_POST['birthdateyear']:'';
				$birthdatemonth = !empty($_POST['birthdatemonth'])?$_POST['birthdatemonth']:'';
				$birthdateday = !empty($_POST['birthdateday'])?$_POST['birthdateday']:'';
				$user['birthdate']  =$birthdateyear.'-'. sprintf('%02d',$birthdatemonth).'-'.sprintf('%02d',$birthdateday);
				$user['marital'] = !empty($_POST['maritalstatus'])?$_POST['maritalstatus']:'0';
				$user['children'] = !empty($_POST['children'])?$_POST['children']:'0';
				$user['nationality'] = !empty($_POST['nationality'])?$_POST['nationality']:'';
				$user['occupation'] = !empty($_POST['occupation'])?$_POST['occupation']:'';
				$user['householdincome'] = !empty($_POST['householdincome'])?$_POST['householdincome']:'0';
				$user['education'] = !empty($_POST['education'])?$_POST['education']:'0';
				$user['havecar'] = !empty($_POST['havecar'])?$_POST['havecar']:'0';
				$user['speak_english'] = !empty($_POST['speakenglish'])?$_POST['speakenglish']:'0';
				$user['speaklanguage'] = !empty($_POST['speaklanguage'])?$_POST['speaklanguage']:'0';
				$user['hearabout'] = !empty($_POST['hearabout'])?$_POST['hearabout']:'0';
    		break;    		
    		case "other":
    			$user['eatingoutcount'] = !empty($_POST['eatingoutcount'])?intval($_POST['eatingoutcount']):'';
				$user['avgbill'] = !empty($_POST['avgbill'])?$_POST['avgbill']:'';
				$user['apparelspending'] = !empty($_POST['apparelspending'])?$_POST['apparelspending']:'';
				
				$user['newletters'] = !empty($_POST['newletters'])?$_POST['newletters']:'0';
				$user['interests'] = !empty($_POST['interests'])?$_POST['interests']:'';
		    		break;	
    		case "payment":
    			$user['alipay'] = !empty($_POST['alipay'])?strip_tags($_POST['alipay']):"";
    			$user['bank_name'] = !empty($_POST['bank_name'])?strip_tags($_POST['bank_name']):"";
    			$user['bank_realname'] = !empty($_POST['bank_realname'])?strip_tags($_POST['bank_realname']):"";
    			$user['subbank_name'] = !empty($_POST['subbank_name'])?strip_tags($_POST['subbank_name']):"";
    			$user['bank_account'] = !empty($_POST['bank_account'])?strip_tags($_POST['bank_account']):"";
    			
    		break;    		
    		
    		case "upload":
	    		
				include_once("FileUpload.class.php");
    			$upload=new FileUpload(APP_DIR."/public/upload/faceimg/",'jpg|png|gif|jpeg');
    			$upload->set_file_name("face_".$this->login_user['user_id']);
				$re = $upload->upload();
				if(!$re){
					$t=$upload->get_succ_file();
					if($t){
						$user['face_img'] = substr(strrchr($t[0],"/"),1);
						$re = '上传成功';
					}
				}else{
					//$user['face_img'] = '';
					
				}
    			
    		break;
    		
    		default:
    			
    	}
    	$rs = false;
    	$passmod = new PassportModel();
		if($user) $rs = $passmod->saveUserExt ( $user ,$this->login_user['user_id']);
		if(!$rs){
				$msg = array('s'=> 400,'m'=>$msg,'d'=>"");				
				if($type!="upload") exit(json_output($msg));
		}else{
				$msg = array('s'=> 200,'m'=>'已经保存！','d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/index.php/home/mydetail/$type");				
				if($type!="upload") exit(json_output($msg));
				
		}
		show_message($re);
		redirect("/index.php/home/mydetail/$type",3);
		
    }
    
    function view_notice(){
    	$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'an_id';
		
		$con['order'] = $cur_sort;
		$con['an_title'] = '';
		$con['an_date'] = '';
		
		include_once("AnnouncementModel.class.php");
		$an = new AnnouncementModel();
				
		$data = $an->getItems($con,15);
		$this->tpl->assign('data',$data);
		$this->tpl->assign('total',$data['page']->total);
    }
    function view_noticedetail(){
    	$an_id = isset($_GET['noticedetail'])?$_GET['noticedetail']:'';
    	include_once("AnnouncementModel.class.php");
		$an = new AnnouncementModel();
				
		$data = $an->getAnnouncementById($an_id);
		$this->tpl->assign('data',$data);
    }
    function view_calendar(){
    	
    }
    function view_calendarjson(){
    	$color = array("#c63","#6c3","#36c","#63c","#3c6","#c36");
    	include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();
		$calendar = $assignmentModel->getMyAssignmentCalendar($this->login_user['user_id']);
		if ($calendar) {
			foreach ($calendar as $k=>$v){
				$v['url'] = BASE_URL."/index.php/home/assignment/a_id/".$v['id'];
				$v['bgcolor'] = isset($color[$k])?$color[$k]:"#ccc";
				$calendar[$k] = $v;
			}
			echo json_encode($calendar);
		}else{
			echo json_encode(array(
				array(
				)
			));
		}
		die;
		
    }
}
?>