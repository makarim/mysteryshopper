<?php
class AssignmentModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "assignment ","*");
		
		//
		if(isset($con['order'])) $select->order ( $con['order']." desc" );
		if(isset($con['a_title']) && !empty($con['a_title'])) $select->where ( " a_title like '%".$con['a_title']."%'" );
		if(isset($con['a_id']) && !empty($con['a_id'])) $select->where ( " a_id = '".$con['a_id']."'" );
		if(isset($con['c_desc']) && !empty($con['c_desc'])) $select->where ( " c_desc like '%".$con['c_desc']."%'" );

		
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
	function createNewAssignment($assignment){
		//user table
		return	$this->db->execute ( "insert into assignment ( a_title,c_password,c_title,c_desc, c_phone, c_intro)
		values ('{$assignment['a_title']}','" . $assignment ['c_password'] . "','{$assignment['c_title']}','{$assignment['c_desc']}','{$assignment['c_phone']}','{$assignment['c_intro']}')" );

	}
	function deleteAssignment($a_id){
		return $this->db->execute("delete from assignment where a_id='{$a_id}'");
	}
	function getAssignmentById($a_id){
		return $this->db->getRow("select * from assignment where a_id='$a_id'");
	}
    function updateAssignment($item,$a_id){
		return $this->db->update($item,"assignment"," a_id=".$a_id);
    }
}
?>
