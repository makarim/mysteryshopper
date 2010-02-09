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
		//$pagerStyle = array ('firstPage' => '', 'prePage' => 'gray4_12b none', 'nextPage' => 'gray4_12b none', 'totalPage' => '', 'numBar' => 'yellowf3_12b none', 'numBarMain' => 'gray4_12 none' );                      //翻页条的样式
		//$list ['page']->setLinkStyle ( $pagerStyle );
		//$list ['page']->setLinkScript("gotopage(@PAGE@)");
		$label = array('first_page'=>lang('first_page'),'last_page'=>lang('last_page'),'next_page'=>lang('next_page'),'pre_page'=>lang('pre_page'),'next_group'=>lang('next_group'),'pre_group'=>lang('pre_group'));	
		$list ['page']->setLabelName($label);
		$list ['page_array'] ['pagebar'] = $list ['page']->wholeNumBar();
		
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
    function getQuestionsByReId($re_id){
    	return $this->db->getAll("select rq_id,rq_group,rq_type,rq_question,q_id from report_question where re_id='$re_id'");
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
		//$pagerStyle = array ('firstPage' => '', 'prePage' => 'gray4_12b none', 'nextPage' => 'gray4_12b none', 'totalPage' => '', 'numBar' => 'yellowf3_12b none', 'numBarMain' => 'gray4_12 none' ); 
		//$list ['page']->setLinkStyle ( $pagerStyle );
		//$list ['page']->setLinkScript("gotopage(@PAGE@)");
		$label = array('first_page'=>lang('first_page'),'last_page'=>lang('last_page'),'next_page'=>lang('next_page'),'pre_page'=>lang('pre_page'),'next_group'=>lang('next_group'),'pre_group'=>lang('pre_group'));	
		$list ['page']->setLabelName($label);
		$list ['page_array'] ['pagebar'] = $list ['page']->wholeNumBar();
		
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
		if($rs){
			$re_id = $this->db->getOne("select last_insert_id() from report");
			foreach ($report['q_id'] as $q_id){
				$question = $this->getQuestionById($q_id);
				$this->db->execute("insert into report_question (re_id,rq_group,rq_type,rq_question,q_id)
				 values ('{$re_id}','{$question['q_group']}','{$question['q_type']}','{$question['q_question']}','{$q_id}')");
			}
			return true;
		}
		return false;
	}
	function updateReport($report){
		$rs=$this->db->execute ( "update report set re_title='{$report['re_title']}' where re_id='{$report['re_id']}'" );
		if($rs){
			//增加问题
			foreach ($report['q_id'] as $q_id){
				$rs = $this->db->getOne("select count(*) from report_question where re_id='{$report['re_id']}' and q_id='$q_id'");
				if($rs==0){
					$question = $this->getQuestionById($q_id);
					$this->db->execute("insert into report_question (re_id,rq_group,rq_type,rq_question,q_id)
				 values ('{$report['re_id']}','{$question['q_group']}','{$question['q_type']}','{$question['q_question']}','{$q_id}')");
				}
			}
			
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
			
			
			
			return true;
		}
		return false;
	}
	
	
	function deleteReport($a_id){
		return $this->db->execute("delete from report where a_id='{$a_id}'");
	}
	function getReportById($a_id){
		return $this->db->getRow("select * from report where a_id='$a_id'");
	}

}
?>
