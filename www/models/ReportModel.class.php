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
	function checkName($name){
		return $this->db->getOne ( "select a_id from report where a_title = '{$name}'" );
	}
	function createNewAssignment($report){
		//user table
		return	$this->db->execute ( "insert into report ( a_title,  a_desc,a_sdate,a_edate, c_id, cs_id,a_hasphoto,a_hasaudio)
		values ('{$report['a_title']}','" . $report ['a_desc'] . "','{$report['a_sdate']}','{$report['a_edate']}','{$report['c_id']}','{$report['cs_id']}','{$report['a_hasphoto']}','{$report['a_hasaudio']}')" );

	}
	function deleteAssignment($a_id){
		return $this->db->execute("delete from report where a_id='{$a_id}'");
	}
	function getAssignmentById($a_id){
		return $this->db->getRow("select * from report where a_id='$a_id'");
	}
    function updateAssignment($item,$a_id){
		return $this->db->update($item,"report"," a_id=".$a_id);
    }
}
?>
