<?php
class AssignmentModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "assignment a","a.*");
		$select->leftJoin('corporation c','c.c_id=a.c_id','c.c_title,c.c_logo');
		$select->leftJoin('brand b','b.b_id=a.b_id','b.b_logo');
		$select->leftJoin('store s','s.cs_id=a.cs_id','s.cs_name');
		
		
		//
		if(isset($con['order'])) $select->order ( 'a.'.$con['order']." desc" );
		if(isset($con['a_title']) && !empty($con['a_title'])) $select->where ( " a.a_title like '%".$con['a_title']."%'" );
		if(isset($con['c_id']) && !empty($con['c_id'])) $select->where ( " a.c_id = '".$con['c_id']."'" );
		if(isset($con['cs_id']) && !empty($con['cs_id'])) $select->where ( " a.cs_id = '".$con['cs_id']."'" );
		if(isset($con['a_sdate']) && !empty($con['a_sdate'])) $select->where ( " a.a_sdate >= '".$con['a_sdate']."'" );
		if(isset($con['a_edate']) && !empty($con['a_edate'])) $select->where ( " a.a_edate <= '".$con['a_edate']."'" );
		if(isset($con['notselected']) && !empty($con['notselected'])) $select->where ( " a.user_id = ''" );
		if(isset($con['province']) && !empty($con['province'])) $select->where ( " s.cs_province = '{$con['province']}'" );
		if(isset($con['city']) && !empty($con['city'])) $select->where ( " s.cs_city = '{$con['city']}'" );
		if(isset($con['area']) && !empty($con['area'])) $select->where ( " s.cs_district = '{$con['area']}'" );

		
		$list = array();
		$offset = '';
		
		$total = $select->count (); //获得查询到的记录数
		include_once("Pager.class.php");
	    $list ['page'] = new Pager ( $total, $pageCount ); //创建分页对象
		$offset = $list ['page']->offset ();               //获得记录偏移量
		
		$pagerStyle = array ('firstPage' => 'page', 'prePage' => 'go_b', 'nextPage' => 'go_b','preGroup'=>'page','nextGroup'=>'page', 'totalPage' => '', 'numBar' => 'on', 'numBarMain' => 'page' );                      //翻页条的样式
		$list ['page']->setLinkStyle ( $pagerStyle );
		$label = array('first_page'=>lang('first_page'),'last_page'=>lang('last_page'),'next_page'=>lang('next_page'),'pre_page'=>lang('pre_page'),'next_group'=>lang('next_group'),'pre_group'=>lang('pre_group'));
		$list ['page']->setLabelName($label);
		if($total>$pageCount){
			$list ['pagebar'] = $list ['page']->prePage (lang('pre_page') ) .$list ['page']->ocNumBar().$list ['page']->nextPage (lang('next_page'));
		}else{
			$list ['pagebar'] = '';
		}
		
		$select->limit ( $list['page']->offset(), $pageCount );
		$rs = $select->query();
	//echo $select->getSql();
		if ($rs) {
			foreach ( $rs as $key => $record ) {
				$list ['records'] [$key] = $record;
			}
		}
		return (array) $list;
	}
	function checkName($name){
		return $this->db->getOne ( "select a_id from assignment where a_title = '{$name}'" );
	}
	function createNewAssignment($as){
		//user table
		return	$this->db->execute ( "insert into assignment ( a_title,  a_desc,a_demand,a_sdate,a_edate, c_id, cs_id,a_hasphoto,a_hasaudio,re_id,a_quiz,b_id)
		values ('{$as['a_title']}','" . $as ['a_desc'] . "','{$as['a_demand']}','{$as['a_sdate']}','{$as['a_edate']}','{$as['c_id']}','{$as['cs_id']}','{$as['a_hasphoto']}','{$as['a_hasaudio']}','{$as['re_id']}','{$as['a_quiz']}','{$as['b_id']}')" );

	}
	function deleteAssignment($a_id){
		return $this->db->execute("delete from assignment where a_id='{$a_id}'");
	}
	function getAssignmentById($a_id){
		return $this->db->getRow("select a.*,c.c_name,s.*,c.c_logo,b.b_logo,u.user_nickname from assignment a 
		left join corporation c on c.c_id=a.c_id
		left join brand b on b.b_id=a.b_id 
		left join store s on s.cs_id=a.cs_id
		left join user u on a.user_id=u.user_id 
		where a.a_id='$a_id'");
	}
	function getAssignmentApplyCountById($a_id){
		return $this->db->getOne("select count(*) from assignment_rel where a_id='$a_id'");
	}	
	function isApplied($a_id,$u_id){
		return $this->db->getOne("select count(*) from assignment_rel where a_id='$a_id' and user_id='$u_id'");
	}
	function apply($a_id,$u_id){
		return $this->db->execute("insert into assignment_rel (a_id,user_id,selected) values ('$a_id','$u_id',0)");
		
	}
	function getAssignmentApplicantById($a_id){
		return $this->db->getAll("select r.user_id,r.selected,u.user_nickname as nickname,u.user_email as email,ext.realname,ext.mobile,ext.workphone as phone,ext.gender as gender  
		from assignment_rel r 
		left join user_ext ext on ext.user_id=r.user_id 
		left join user u on u.user_id=r.user_id 
		where r.a_id='$a_id'");
	}
	function chooseApplicant($a_id,$user_id){
		$r = true;
		$r *= $this->db->execute("update assignment_rel set selected=0 where a_id='$a_id'");
		$r *= $this->db->execute("update assignment set user_id='$user_id' where a_id='$a_id'");
		$r *= $this->db->execute("update assignment_rel set selected=1 where a_id='$a_id' and user_id='$user_id'");
		if($r) return true;
		else return false;
	}
	function assignToUser($a_id,$user){
		$user_id  = $this->db->getOne("select user_id from user where user='$user'");
		$r = false;
		if($user_id){
			$r |= $this->db->execute("update assignment_rel set selected=0 where a_id='$a_id'");
			$r |=$this->db->execute("delete from assignment_rel where a_id='$a_id' and user_id='$user_id'");
			$r |= $this->db->execute("insert into assignment_rel (a_id,user_id,selected) values ('$a_id','$user_id',1)");
			$r |= $this->db->execute("update assignment set user_id='$user_id' where a_id='$a_id'");
			return $r;
		}
		return false;
	}
    function updateAssignment($item,$a_id){
		return $this->db->update($item,"assignment"," a_id=".$a_id);
    }
    function generateQuiz($quiz_text){
    	$quiz_arr = array();
    	if($quiz_text){
    		$arr = explode("\n",$quiz_text);
    		if(isset($arr) && is_array($arr)){
    			foreach ($arr as $k=>$v){
    				$v_arr = explode("|",$v);
    				foreach ($v_arr as $vv){
    					if(strpos($vv,'title:')!==false){
    						$quiz_arr[$k]['title'] = substr($vv,6);
    					}
    					if(strpos($vv,'A:')!==false){
    						$quiz_arr[$k]['A'] = substr($vv,2);
    					}    					
    					if(strpos($vv,'B:')!==false){
    						$quiz_arr[$k]['B'] = substr($vv,2);
    					}    					
    					if(strpos($vv,'C:')!==false){
    						$quiz_arr[$k]['C'] = substr($vv,2);
    					}    					
    					if(strpos($vv,'D:')!==false){
    						$quiz_arr[$k]['D'] = substr($vv,2);
    					}
    					if(strpos($vv,'answer:')!==false){
    						$quiz_arr[$k]['answer'] = trim(substr($vv,7));
    					}
    					
    				}
    				
    				
    			}
    			return $quiz_arr;
    		}
    	}
    	return '';
    }
    
    function getMyAssignments($user_id){
    	return $this->db->getAll("select r.user_id,r.selected,a.* ,c.c_logo,b.b_logo 
    	from assignment_rel r 
		left join assignment a on a.a_id=r.a_id 
		left join corporation c on c.c_id=a.c_id 
		left join brand b on b.b_id=a.b_id 
		where r.user_id='$user_id' and a.a_finish<1 
		order by a.a_edate asc;
		");
    }    
    function getMyAssignmentCalendar($user_id){
    	return $this->db->getAll("select a_id as id,a_title as title,a_sdate as start,a_edate as end from assignment where user_id='$user_id' and a_finish<1 order by a_sdate desc ");
    }
    function getMyHistoryAssignments($user_id){
    	return $this->db->getAll("select a.*  ,s.cs_name,c.c_title
    	from assignment a 
		left join store s on s.cs_id=a.cs_id 
		left join corporation c on c.c_id=a.c_id 
		where a.user_id='$user_id' and a.a_finish =1
		order by a.a_edate asc;
		");
    }
    function getCorpAssignments($con){
    	
    	$select =$this->db->select();
		$select->from ( "assignment a","a.*");
		$select->leftjoin("store s","s.cs_id=a.cs_id ","s.cs_name");
		$select->leftjoin("corporation c ","c.c_id=a.c_id ","c.c_title");
		
		$select->where("a.a_finish =1");
		if(isset($con['order'])) $select->order ( 'a.'.$con['order']." asc" );
		if(isset($con['sdate']) && !empty($con['sdate'])) $select->where ( " a.a_fdate >= '".$con['sdate']."'" );
		if(isset($con['edate']) && !empty($con['edate'])) $select->where ( " a.a_fdate <= '".$con['edate']."'" );
		if(isset($con['selstores']) && !empty($con['selstores'])){
			if(is_array($con['selstores'])) $select->where ( "a.cs_id in (".join(",",$con['selstores']).")" );
			else   $select->where (  "a.cs_id ='".$con['selstores']."'");
		}
    	
		
		$list = array();
		$offset = '';
		$pageCount = 20;
		$total = $select->count (); //获得查询到的记录数
		include_once("Pager.class.php");
	    $list ['page'] = new Pager ( $total, $pageCount ); //创建分页对象
		$offset = $list ['page']->offset ();               //获得记录偏移量
		
		$pagerStyle = array ('firstPage' => 'page', 'prePage' => 'go_b', 'nextPage' => 'go_b','preGroup'=>'page','nextGroup'=>'page', 'totalPage' => '', 'numBar' => 'on', 'numBarMain' => 'page' );                      //翻页条的样式
		$list ['page']->setLinkStyle ( $pagerStyle );
		$label = array('first_page'=>lang('first_page'),'last_page'=>lang('last_page'),'next_page'=>lang('next_page'),'pre_page'=>lang('pre_page'),'next_group'=>lang('next_group'),'pre_group'=>lang('pre_group'));
		$list ['page']->setLabelName($label);
		if($total>$pageCount){
			$list ['pagebar'] = $list ['page']->prePage (lang('pre_page') ) .$list ['page']->ocNumBar().$list ['page']->nextPage (lang('next_page'));
		}else{
			$list ['pagebar'] = '';
		}
		
		$select->limit ( $list['page']->offset(), $pageCount );
		$rs = $select->query();
		if ($rs) {
			foreach ( $rs as $key => $record ) {
				$list ['records'] [$key] = $record;
			}
		}
		return (array) $list;
		

    }
    function getLastestAssignments(){
    	return $this->db->getAll("select a.* ,c.c_logo,b.b_logo  
    	from assignment a
		left join corporation c on c.c_id=a.c_id 
		left join brand b on b.b_id=a.b_id 
		where a.user_id='' 
		order by a.a_order desc limit 8;
		");
    }
    function getEndDateByCId($c_id){
    	return $this->db->getOne("select DATE_FORMAT(a_fdate, '%Y-%m-%d') as day from assignment where c_id='$c_id' and a_audit=1 order by day desc limit 1");
    }    
    function getEndDateByCsId($cs_id){
    	return $this->db->getOne("select DATE_FORMAT(a_fdate, '%Y-%m-%d') as day from assignment where cs_id='$cs_id' and a_audit=1 order by day desc limit 1");
    }    
    function getStartDateByCId($c_id){
    	return $this->db->getOne("select DATE_FORMAT(a_fdate, '%Y-%m-%d') as day from assignment where c_id='$c_id' and a_audit=1 order by day asc limit 1");
    }    
    function getStartDateByCsId($cs_id){
    	return $this->db->getOne("select DATE_FORMAT(a_fdate, '%Y-%m-%d') as day from assignment where cs_id='$cs_id' and a_audit=1 order by day asc limit 1");
    }
    function getAssignmentsByCsId($con,$cs_id){
    	$add =$addsql = '';
    	if(!empty($con['sdate'])) $add .= " and a_fdate >='".$con['sdate']."'";
    	if(!empty($con['edate'])) $add .= " and a_fdate <= '".$con['edate']."'";
    	if(!empty($con['a_audit'])) $add .= " and a_audit = '".$con['a_audit']."'";
    	if(is_array($cs_id) && count($cs_id)>0) $addsql = " and cs_id in (".join(",",$cs_id).")";
    	else  $addsql = " and cs_id ='".$cs_id."'";
    	//echo "select a_id,re_id,DATE_FORMAT(a_fdate, '%m-%d') as day,a_title from assignment where cs_id='$cs_id' $add order by day";
    	return $this->db->getAll("select a_id,cs_id,re_id,DATE_FORMAT(a_fdate, '%Y-%m-%d') as day,a_title from assignment where 1 $addsql $add order by cs_id,day asc");
    }
    
    function getAssignmentComments($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "assignment a","a.*");
		//
		if(isset($con['order'])) $select->order ( 'a.'.$con['order']." desc" );
		if(isset($con['c_id']) && !empty($con['c_id'])) $select->where ( " a.c_id = '".$con['c_id']."'" );
		if(isset($con['sdate']) && !empty($con['sdate'])) $select->where ( " a.a_fdate >= '".$con['sdate']."'" );
		if(isset($con['edate']) && !empty($con['edate'])) $select->where ( " a.a_fdate <= '".$con['edate']."'" );
		if(isset($con['a_audit']) && !empty($con['a_audit'])) $select->where ( " a.a_audit = '".$con['a_audit']."'" );
		if(isset($con['selstores']) && !empty($con['selstores'])){
			if(is_array($con['selstores'])) $select->where ( "a.cs_id in (".join(",",$con['selstores']).")" );
			else   $select->where (  "a.cs_id ='".$con['selstores']."'");
		}
    	
		
		$list = array();
		$offset = '';
		
		$total = $select->count (); //获得查询到的记录数
		include_once("Pager.class.php");
	    $list ['page'] = new Pager ( $total, $pageCount ); //创建分页对象
		$offset = $list ['page']->offset ();               //获得记录偏移量
		
		$pagerStyle = array ('firstPage' => 'page', 'prePage' => 'go_b', 'nextPage' => 'go_b','preGroup'=>'page','nextGroup'=>'page', 'totalPage' => '', 'numBar' => 'on', 'numBarMain' => 'page' );                      //翻页条的样式
		$list ['page']->setLinkStyle ( $pagerStyle );
		$label = array('first_page'=>lang('first_page'),'last_page'=>lang('last_page'),'next_page'=>lang('next_page'),'pre_page'=>lang('pre_page'),'next_group'=>lang('next_group'),'pre_group'=>lang('pre_group'));
		$list ['page']->setLabelName($label);
		if($total>$pageCount){
			$list ['pagebar'] = $list ['page']->prePage (lang('pre_page') ) .$list ['page']->ocNumBar().$list ['page']->nextPage (lang('next_page'));
		}else{
			$list ['pagebar'] = '';
		}
		
		$select->limit ( $list['page']->offset(), $pageCount );
		$rs = $select->query();
	//echo $select->getSql();
		if ($rs) {
			foreach ( $rs as $key => $record ) {
				$record['comments'] = $this->getCommentsByAsId($record['a_id'],$record['re_id']);
				//if($record['comments']) $record['comments'] = splitx($record['comments']);
				$list ['records'] [$key] = $record;
			}
		}
		return (array) $list;
	}
	
	
	function getCommentsByAsId($a_id,$re_id){
			
		$sql = "select rq_id,rq_type,rq_group from report_question where rq_type=3 and rq_group!=5 and re_id='".$re_id."'";
		$rq_arr = $this->db->getAll($sql);
		$q_row = count($rq_arr);
		$sum = 0;
		$comments = array();

		if($q_row>0){
			foreach ($rq_arr as $rq){
				$sql = "select ans_answer3 from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."'";
				if(!isset($comments[$rq['rq_group']]['score'])){
					if($rq['rq_group']==4){
						$score =0;
						$score += $this->getSummaryScoreByAsId($a_id,$re_id,1);
						$score += $this->getSummaryScoreByAsId($a_id,$re_id,2);
						$score += $this->getSummaryScoreByAsId($a_id,$re_id,3);
						$comments[$rq['rq_group']]['score']  = round($score/3,2);
					}else{
						$comments[$rq['rq_group']]['score'] = $this->getSummaryScoreByAsId($a_id,$re_id,$rq['rq_group']);
					}
				}
				$r = $this->db->getOne($sql);
				if($r) $r= splitx($r);
				$comments[$rq['rq_group']]['content'][]= $r;
			}
			// 所有题目打分平均值之和/问题个数=一份报告同group的打分题平均值
			return $comments;
		}
	}
	
	function getSummaryScoreByAsId($a_id,$re_id,$group,$type=''){
//		if($group=='service') $group=1;
//		if($group=='environment') $group=2;
//		if($group=='product') $group=3;
//		if($group=='summary') $group=4;
		$average = 0;
		//一份报告有多少个的同group的打分题目
		$sql = "select rq_id,rq_type from report_question where rq_group='$group' and re_id='".$re_id."'";
	
		$rq_arr = $this->db->getAll($sql);
		$q_row = count($rq_arr);
		//echo "row:".$q_row."|";
		
		$sum = 0;
		$n = 0;
		if($q_row>0){
			foreach ($rq_arr as $rq){
				if($type && $type!=$rq['rq_type']) continue;
				
				if($rq['rq_type']==2){
					$sql = "select avg(ans_answer2) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."' and rq_type=2 and ans_answer2!='A'";
					$res = $this->db->getOne($sql);
					if($res>0){
						$sum +=$res;
						$n++;
					}
					
				}else if($rq['rq_type']==1){
					$sql = "select ans_answer1  from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."' and rq_type=1 and ans_answer1!='A'";
					$yn = $this->db->getOne($sql);
					if($yn=='Y' or $yn=='N'){
						$sum += ($yn=='Y')?10:0;
						$n++;
					}
					
				}
				
			}
			//echo $a_id."=".$sum."/".$n."<br/>";
			// 所有题目打分平均值之和/问题个数=一份报告同group的打分题平均值
			if($n>0){
				$average = $sum/$n;
				return round($average,2);
			}else{
				return '-';
			}
			
		}
		return '0';
	}
	function getTimeByRqId($rq_id,$a_id){
		$sql = "select ans_answer4 from answer where rq_id='".$rq_id."' and a_id = '".$a_id."' and rq_type=4";
		//echo $sql;
		return $this->db->getOne($sql);
	}
	function saveAttachment($field,$table){
		return $this->db->insert($field,$table);
	}
	function getUploadedAttachment($a_id){
		return $this->db->getAll("select * from assignment_attachment where a_id='{$a_id}'");
	}
	function delUploadAttachment($f_id){
		return $this->db->execute("delete from assignment_attachment where f_id='{$f_id}'");
	}
	function getFirstAssignmentByCId($cid){
		return $this->db->getOne("select a_id from assignment where c_id='$cid' order by a_id asc limit 1");
	}
}
?>
