<?php
class home{
	public $login_user;
	public $tpl;
	private $assignmentModel;
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
		$this->login_user = authenticate();

		/*****/
		$this->login_user['Privs'] = array('authen'=>1,'modify_client_admin'=>1,'modify_store_admin'=>1,'modify_storers'=>1);
		$_SESSION['LoginUser'] = $this->login_user;
//		echo "<pre/>";
//		print_r($this->login_user);
		/*****/
		if(empty($this->login_user['user'])){
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
		$this->tpl->assign("userid",$this->login_user['user']);//控制优惠券的访问权限 start 暂时只有jason.wang@spotshoppers.com、info@spotshoppers.com、wendy.ewt@gmail.com三个账户能够访问到 add by wendy 2010.12.8
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
		$province= !empty($_GET['province'])?$_GET['province']:'';
		$city= !empty($_GET['city'])?$_GET['city']:'';
		$area= !empty($_GET['area'])?$_GET['area']:'';

		$con['order'] = $cur_sort;
		$con['a_title'] = $a_title;
		$con['c_id'] = $c_id;
		$con['cs_id'] = $cs_id;
		$con['a_sdate'] = $a_sdate;
		$con['a_edate'] = $a_edate;
		$con['notselected'] = 'notselected';
		$con['province'] = $province;
		$con['city'] = $city;
		$con['area'] = $area;

		include_once("AssignmentModel.class.php");
		$assignmentModel = new AssignmentModel();

		$assignments = $assignmentModel->getItems($con,16);
		$this->tpl->assign('assignments',$assignments);
		$this->tpl->assign('con',$con);
		$this->tpl->assign('total',$assignments['page']->total);
    }
    function get_assignment($a_id){
    	include_once("AssignmentModel.class.php");
    	$this->assignmentModel = new AssignmentModel();
    	$assignmentinfo = $this->assignmentModel->getAssignmentById($a_id);
    	if(!$assignmentinfo){
    		show_message(lang('params_invalid'));
    		goback(10000);
    	}

    	$is_view = '0';
		if($assignmentinfo['user_id']==$this->login_user['user_id']){
			$is_view =1;
		}
		$do_quiz = '';
		if($assignmentinfo['a_istest']==1){
			if(isset($_SESSION['a_'.$a_id]['pass']) && $_SESSION['a_'.$a_id]['pass']==1){
				$do_quiz = 'pass';
			}
			if(isset($_SESSION['a_'.$a_id]['pass']) && $_SESSION['a_'.$a_id]['pass']==0){
				$do_quiz = 'fail';
			}
		}else{
			$do_quiz = 'pass';
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
		$tmp = explode("\n",splitx($assignmentinfo['a_desc']));
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
		$tmp = explode("\n",splitx($assignmentinfo['a_demand']));
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

//    	echo "is_view=".$is_view."<br/>";
//    	echo "<pre/>";
//    	print_r($assignmentinfo);

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
		$this->tpl->assign("mark_type",$assignment['a_markgrade']);
		$this->tpl->assign("report_questions",$report_questions);
	}
	function view_quiz(){
		$a_id = isset($_GET['a_id'])?intval($_GET['a_id']):'0';


		$assignment = $this->get_assignment($a_id);
		$quiz = $this->assignmentModel->generateQuiz(splitx($assignment['a_quiz']));
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
				show_message(lang("pass_test"));
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

//		echo "<pre/>";
//		print_r($assignment);
		if($assignment['user_id']==$this->login_user['user_id']){

			include_once("ReportModel.class.php");
			$ReportModel = new ReportModel();
			$report_questions = array();
			foreach ($GLOBALS['gGroups'] as $k=>$v){
				$arr = $ReportModel->getQuestionsByReId($re_id,$k);

				if($arr){
					foreach ($arr as $kk=>$vv){
						$vv['answer'] = $ReportModel->getAnswerByAid($a_id,$vv['rq_id'],$vv['rq_type']);
						$vv['comment'] = $ReportModel->getCommentByRqid($a_id,$vv['rq_id']);
						$arr[$kk] = $vv;
					}
				}

				$report_questions[$v] = $arr;

			}

//			echo "<pre/>";
//			//print_r($assignment);
//			print_r($report_questions);

			//分制类型信息 add by wendy 32010.11.24
			$this->tpl->assign("mark_type",$assignment['a_markgrade']);
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
		$r = $rs  = true;
		$rall = true;
		if($_POST){
			foreach ($_POST as $k=>$v){
				if(!$v) $rall = false;
				if(substr($k,0,7)=='rq_ans_'){
					list(,,$rq_type,$rq_id) = split("_",$k);
					//echo "k=".$k."  "."answer=".$v."<br/>";
					$r *=$reportModel->saveAnswer($rq_id,$u_id,$a_id,$rq_type,addslashes($v));
				}
				if(substr($k,0,11)=='rq_comment_'){
					list(,,$rq_type,$rq_id) = split("_",$k);
					if($v) $rs *=$reportModel->saveComment($rq_id,$u_id,$a_id,$rq_type,addslashes($v));
				}
			}

		}

		if($r && $rall){
			$updates['a_fdate'] = "MY_F:NOW()";
			$updates['a_finish'] =0.50;
			$updates['a_audit'] =0;
			$assignment->updateAssignment($updates,$a_id);
			show_message_goback(lang('success'));
		}else if(!$rall){
			show_message_goback(lang('success'));
		}else{
			show_message_goback(lang('failed'));
		}
	}

	function op_apply(){
		$rs = false;
		$a_id = isset($_POST['a_id'])?intval($_POST['a_id']):'0';
		$this->get_assignment($a_id);
		//$count = $this->assignmentModel->getAssignmentApplyCountById($a_id);
		//if($count<3){
		$r = $this->assignmentModel->isApplied($a_id,$this->login_user['user_id']);
		if($r>0){
			show_message_goback(lang("have_apply_for"));
		}else{
			$rs=$this->assignmentModel->apply($a_id,$this->login_user['user_id']);
		}
		//}
		if($rs){
			show_message(lang("apply_success"));
			unset($_SESSION['a_'.$a_id]['pass']);
			redirect("/index.php/home/allassignment/a_id/$a_id",2);
		}else{
			show_message(lang("apply_failed"));
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

		$upload->preview = true;

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
				show_message_goback(lang("success"));
			}
		}else{
			show_message_goback(lang('failed'));
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

    /************************************************/
    //add by wendy 2010.11.29
    function view_coupon(){
    	include_once("CouponModel.class.php");
    	$coupon = new CouponModel();

    	$type = !empty($_GET['coupon'])?$_GET['coupon']:"newcoupon";

    	if(isset($_GET['b_id']) && !empty($_GET['b_id'])){
    		$_SESSION['b_id'] = $_GET['b_id'];

    		//获得店家简介，并存入全局变量，供其他页面使用
	    	$comp = $coupon->getBrand($_SESSION['b_id']);
	    	foreach($comp as $k=>$v){
	    		$_SESSION['b_summary'] = $v['b_summary'];
	    	}
    	}
    	$b_id = $_SESSION['b_id'];

    	//查看优惠券——默认为最新的
    	$couplist  = $coupon->getCouponlist($b_id);
    	if(!empty($couplist)){
    	  $defcoup = $couplist[0]['cp_id'];
    	}else $defcoup = '';

    	if($type == 'couplist'){
    		$couplist  = $coupon->getCouponlist($b_id);

    		$this->tpl->assign("couplist",$couplist);
//    		echo "<pre/>";
//    		print_r($couplist);
    	}else if($type == 'coupview'){
    		$cp_id = !empty($_GET['cp_id'])?$_GET['cp_id']:$defcoup;

    		if(!empty($cp_id)){
    		$coup = $coupon->getCoupon($cp_id);
    		$this->tpl->assign("coup",$coup);
    		}
//    		echo "<pre/>";
//    		print_r($coup);
    	}else if($type == 'newcoupon'){
    		$newcoup = $coupon->getNewCoupon($b_id);
//    		echo "<pre/>";
//    		print_r($newcoup);
    		$this->tpl->assign("newcoup",$newcoup);
    	}else if($type == 'compdetail'){
    		$comp = $coupon->getBrand($b_id);
    		$this->tpl->assign("comp",$comp);
    	}

    	$this->tpl->assign("b_summary",$_SESSION['b_summary']);
    	$this->tpl->assign("type",$type);
    }

    function view_coupcomp(){
    	include_once("CouponModel.class.php");
    	$cpcomp = new CouponModel();
    	$allcomp = $cpcomp->getAllBrand();
//    	echo "<pre/>";
//    	print_r($allcomp);
		$this->tpl->assign("allcomp",$allcomp);
    }
    /***********************************************/

    function op_updateuserdetail(){
    	include_once("PassportModel.class.php");
    	$user_id = $_POST['user_id'];
    	$from = $_POST['f'];
    	$type = isset($_POST['type'])?$_POST['type']:"";
    	$user = array();
    	$msg ='';
    	switch ($type){

    		case "contact":
    			$user['realname'] = !empty($_POST['realname'])?$_POST['realname']:'';
    			$user['gender'] = !empty($_POST['gender'])?$_POST['gender']:'0';
				$user['mobile'] = !empty($_POST['mobile'])?$_POST['mobile']:'';
				$user['workphone'] = !empty($_POST['workphone'])?$_POST['workphone']:'';
				$user['homephone'] = !empty($_POST['homephone'])?addslashes($_POST['homephone']):'';
				$user['qq'] = !empty($_POST['qq'])?$_POST['qq']:'';
				$user['msn'] = !empty($_POST['msn'])?$_POST['msn']:'';
				$user['province'] = !empty($_POST['province'])?$_POST['province']:'';
				$user['city'] = !empty($_POST['city'])?$_POST['city']:'';
				$user['area'] = !empty($_POST['area'])?$_POST['area']:'';
				$user['postaddress'] = !empty($_POST['postaddress'])?$_POST['postaddress']:'';

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
				$user['been_mysteryshopper'] = !empty($_POST['been_mysteryshopper'])?$_POST['been_mysteryshopper']:'0';
				$user['otherlanguage'] = !empty($_POST['otherlanguage'])?$_POST['otherlanguage']:'';
				$user['hearabout'] = !empty($_POST['hearabout'])?$_POST['hearabout']:'0';
				$user['company_name'] = !empty($_POST['companyname'])?$_POST['companyname']:'';
				$user['newletters'] = !empty($_POST['newletters'])?$_POST['newletters']:'0';
				$user['birthplace'] = !empty($_POST['birthplace'])?$_POST['birthplace']:'';
    		break;
    		case "other":
    			$user['eatwithwho'] = !empty($_POST['eatwithwho'])?intval($_POST['eatwithwho']):'0';
    			$user['eatlunchtimes'] = !empty($_POST['eatlunchtimes'])?intval($_POST['eatlunchtimes']):'0';
    			$user['eatdinnertimes'] = !empty($_POST['eatdinnertimes'])?intval($_POST['eatdinnertimes']):'0';
    			$user['eatweekdaytimes'] = !empty($_POST['eatweekdaytimes'])?intval($_POST['eatweekdaytimes']):'0';
    			$user['eatlunchavgcost'] = !empty($_POST['eatlunchavgcost'])?$_POST['eatlunchavgcost']:'0';
    			$user['eatdinneravgcost'] = !empty($_POST['eatdinneravgcost'])?$_POST['eatdinneravgcost']:'0';
    			$user['eatweekdaylunch_avgcost'] = !empty($_POST['eatweekdaylunchavgcost'])?$_POST['eatweekdaylunchavgcost']:'0';
    			$user['eatweekdaydinner_avgcost'] = !empty($_POST['eatweekdaydinneravgcost'])?$_POST['eatweekdaydinneravgcost']:'0';


    			$user['eatbooking'] = !empty($_POST['eatbooking'])?intval($_POST['eatbooking']):'0';
    			$user['eatvipcard'] = !empty($_POST['eatvipcard'])?intval($_POST['eatvipcard']):'0';

    			$user['eatcombo'] = !empty($_POST['eatcombo'])?intval($_POST['eatcombo']):'0';
    			$user['lunch_delivered'] = !empty($_POST['lunchdelivered'])?intval($_POST['lunchdelivered']):'0';
    			$user['meal_delivered'] = !empty($_POST['mealdelivered'])?intval($_POST['mealdelivered']):'0';

    			$user['dinnerhall'] = !empty($_POST['dinnerhall'])?intval($_POST['dinnerhall']):'0';
    			$user['eattraffic'] = !empty($_POST['eattraffic'])?$_POST['eattraffic']:'';



				$user['interests'] = !empty($_POST['interests'])?$_POST['interests']:'';
		    		break;
    		case "payment":
    			$user['alipay'] = !empty($_POST['alipay'])?strip_tags($_POST['alipay']):"";
    			$user['alipayrealname'] = !empty($_POST['alipayrealname'])?strip_tags($_POST['alipayrealname']):"";
    			$user['bank_name'] = !empty($_POST['bank_name'])?strip_tags($_POST['bank_name']):"";
    			$user['bank_realname'] = !empty($_POST['bank_realname'])?strip_tags($_POST['bank_realname']):"";
    			$user['subbank_name'] = !empty($_POST['subbank_name'])?strip_tags($_POST['subbank_name']):"";
    			$user['bank_account'] = !empty($_POST['bank_account'])?strip_tags($_POST['bank_account']):"";

    		break;

    		case "upload":

				include_once("FileUpload.class.php");
    			$upload=new FileUpload(APP_DIR."/public/upload/faceimg/",'jpg|png|gif|jpeg');
    			$upload->set_file_name("face_".$user_id);
				$re = $upload->upload();
				if(!$re){
					$t=$upload->get_succ_file();
					if($t){
						$user['face_img'] = substr(strrchr($t[0],"/"),1);
						$re = lang("success");
					}
				}else{
					//$user['face_img'] = '';

				}

    		break;

    		default:

    	}
    	$rs = false;
    	$passmod = new PassportModel();
		if($user) $rs = $passmod->saveUserExt ( $user ,$user_id);
		if(!$rs){
				$msg = array('s'=> 400,'m'=>$msg,'d'=>"");
				if($type!="upload") exit(json_output($msg));
		}else{
				if($from=='user') {
					$msg = array('s'=> 200,'m'=>lang("success"),'d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/index.php/home/mydetail/$type");
				}else{
					$msg = array('s'=> 200,'m'=>lang("success"),'d'=>$GLOBALS ['gSiteInfo'] ['www_site_url']."/?action=user&view=detail&detail=$type&user_id=$user_id");
				}
				if($type!="upload") exit(json_output($msg));

		}
		show_message($re);
		if($from=='user') {
			redirect("/index.php/home/mydetail/$type",3);
		}else{
			goback();
		}

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

    function view_resetpwd(){

    }
    function op_resetpwd(){

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

		include_once("PassportModel.class.php");
		$passmod = new PassportModel();
		$user_info = $passmod->getUserById($this->login_user['user_id'],$this->login_user['user']);

		//print_r($user_info);
		if ($user_info ['user_password'] == PassportModel::encryptpwd ($_POST ['oldpwd'],$this->login_user['user'],0)) {

			if (false!=$passmod->updatePassByUser ( $this->login_user['user'], PassportModel::encryptpwd( $new1,$this->login_user['user']) )) {
				show_message_goback(lang('pwdreset'));
			} else {
				show_message_goback(lang('failture'));
			}
		} else {
			show_message_goback(lang('pwdwrong'));
		}
    }
}
?>