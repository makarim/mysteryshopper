<?php
class ReportModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getQuestion($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "question q","q.*");
		$select->leftJoin ( "ques_group g","g.g_id=q.q_group",'g.g_name');
		//
		if(isset($con['order'])) $select->order ("q.". $con['order']." desc" );
		if(isset($con['q_question']) && !empty($con['q_question'])) $select->where ( " q.q_question like '%".$con['q_question']."%'" );
		if(isset($con['g_id']) && !empty($con['g_id'])) $select->where ( " q.q_group = '".$con['g_id']."'" );

		
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
	function getQuesGroup(){
		return $this->db->getAll("select g_id,g_name from ques_group");
	}
	function addNewQuestion($question){
		return $this->db->execute("insert into question (q_question,q_group,q_type) values ('{$question['q_question']}','{$question['q_group']}','{$question['q_type']}')");
	}
	function getQuestionById($q_id){
		return $this->db->getRow("select * from question where q_id='$q_id'");
	}
	function updateQuestion($item,$q_id){
		return $this->db->update($item,"question"," q_id=".$q_id);
    }
	function getAllQuestion(){
		return $this->db->getAll("select q_id,q_question,q_group,q_type from question order by q_group desc");
	}
    function getQuestionsByReId($re_id,$group=''){
    	$addsql = '';
    	if($group) $addsql = "and rq_group='$group'";
    	return $this->db->getAll("select rq_id,rq_group,rq_type,rq_question,q_id,ordernum from report_question where re_id='$re_id' $addsql order by ordernum,rq_type");
    }
    function getReportByReId($re_id){
    	return $this->db->getRow("select * from report where re_id='$re_id'");
    }
    
    function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( " report ","*");
		
		//
		if(isset($con['order'])) $select->order ( $con['order']." desc" );
		if(isset($con['re_title']) && !empty($con['re_title'])) $select->where ( " re_title like '%".$con['re_title']."%'" );
		
		$list = array();
		$offset = '';
		
		$total = $select->count (); 
		include_once("Pager.class.php");
	    $list ['page'] = new Pager ( $total, $pageCount ); 
		$offset = $list ['page']->offset ();               
		
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
	function addNewReport($report){
		//user table
		$rs=$this->db->execute ( "insert into report ( re_title,  re_date)
		values ('{$report['re_title']}',NOW())" );
		$re_id = $this->db->getOne("select last_insert_id() from report");
		if($rs){
			
			foreach ($report['q_id'] as $k=>$q_id){
				
				$question = $this->getQuestionById($q_id);
				$this->db->execute("insert into report_question (re_id,rq_group,rq_type,rq_question,q_id,ordernum)
				 values ('{$re_id}','{$question['q_group']}','{$question['q_type']}','{$question['q_question']}','{$q_id}','{$k}')");
			}
			return true;
		}else{
			$rs=$this->db->execute ( "delete from report where re_id = $re_id" );
		}
		return false;
	}
	function updateReport($report){
		$rs=$this->db->execute ( "update report set re_title='{$report['re_title']}' where re_id='{$report['re_id']}'" );
		if($rs){
			//删除掉问卷的题目和答案
			$to_delete = $this->db->getAll("select rq_id from report_question where q_id not in (".join(',',$report['q_id']).") and re_id='{$report['re_id']}'");
			//print_r($to_delete);die;
			if($to_delete && count($to_delete)>0){
				foreach ($to_delete as $v){
					$rq_id = $v['rq_id'];
					$rs = $this->db->execute("delete from report_question where rq_id='{$rq_id}'");
					if($rs) $this->db->execute("delete from answer where rq_id='{$rq_id}'");
				}
			}
			
			//增加问题
			foreach ($report['q_id'] as $k=>$q_id){
				$rss = $this->db->getOne("select count(*) from report_question where re_id='{$report['re_id']}' and q_id='$q_id'");
				if($rss==0){
					$question = $this->getQuestionById($q_id);
					if($question) $this->db->execute("insert into report_question (re_id,rq_group,rq_type,rq_question,q_id,ordernum)
				 values ('{$report['re_id']}','{$question['q_group']}','{$question['q_type']}','{$question['q_question']}','{$q_id}','$k')");
				}else{
					$this->db->execute("update report_question set ordernum='$k' where re_id='{$report['re_id']}' and q_id='$q_id'");
				}
			}
				
			
			return true;
		}
		return false;
	}
	
	function saveAnswer($rq_id,$u_id,$a_id,$rq_type,$answer){
		$ans_id = $this->db->getOne("select ans_id from answer where rq_id='$rq_id' and a_id='$a_id'");
		if($rq_type==4) $answer = floatval($answer);
		if(!$ans_id){
			$rs =$this->db->execute("insert into answer (rq_id, u_id,a_id, rq_type, ans_answer$rq_type) values ('$rq_id','$u_id','$a_id','$rq_type','{$answer}')");
		}else{
			$rs = $this->db->execute("update answer set ans_answer$rq_type='$answer' where ans_id=$ans_id");
		}
		if($rs){
			
			return true;
		}else{
			return false;
		}
		
	}
	function getAnswerByAid($a_id,$rq_id,$rq_type){
		return $this->db->getOne("select ans_answer$rq_type from answer where a_id='$a_id' and rq_id='$rq_id'");
	}
	
	
	function deleteReport($re_id){
		$rs = $this->db->execute("delete from report where re_id='{$re_id}'");
		if($rs) {
			$report_question = $this->db->getAll("select rq_id from report_question where re_id='{$re_id}'");
			if($report_question && is_array($report_question)){
				foreach ($report_question as $rq){
					$rs1 = $this->db->execute("delete from report_question where rq_id='{$rq['rq_id']}'");
					if($rs1) $this->db->execute("delete from answer where rq_id='{$rq['rq_id']}'");
				}
			}
		}else{
			return false;
		}
		return true;
	}
	function deleteQuestion($q_id){
		return $this->db->execute("delete from question where q_id='$q_id'");
	}
	function getReportById($re_id){
		return $this->db->getRow("select * from report where re_id='$re_id'");
	}

	function getAllReports(){
		return $this->db->getAll("select re_id,re_title from report");
	}
	function getReportIdByCId($c_id){
		return $this->db->getAll("select distinct(re_id) from assignment where c_id='{$c_id}' group by c_id");
	}
}
?>
