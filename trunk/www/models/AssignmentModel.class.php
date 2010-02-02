<?php
class AssignmentModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "assignment a","a.*");
		$select->leftJoin('corporation c','c.c_id=a.c_id','c.c_title');
		$select->leftJoin('store s','s.cs_id=a.cs_id','s.cs_name');
		
		
		//
		if(isset($con['order'])) $select->order ( 'a.'.$con['order']." desc" );
		if(isset($con['a_title']) && !empty($con['a_title'])) $select->where ( " a.a_title like '%".$con['a_title']."%'" );
		if(isset($con['c_id']) && !empty($con['c_id'])) $select->where ( " a.c_id = '".$con['c_id']."'" );
		if(isset($con['cs_id']) && !empty($con['cs_id'])) $select->where ( " a.cs_id = '".$con['cs_id']."'" );
		if(isset($con['a_sdate']) && !empty($con['a_sdate'])) $select->where ( " a.a_sdate >= '".$con['a_sdate']."'" );
		if(isset($con['a_edate']) && !empty($con['a_edate'])) $select->where ( " a.a_edate <= '".$con['a_edate']."'" );

		
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
	function checkName($name){
		return $this->db->getOne ( "select a_id from assignment where a_title = '{$name}'" );
	}
	function createNewAssignment($assignment){
		//user table
		return	$this->db->execute ( "insert into assignment ( a_title,  a_desc,a_sdate,a_edate, c_id, cs_id,a_hasphoto,a_hasaudio)
		values ('{$assignment['a_title']}','" . $assignment ['a_desc'] . "','{$assignment['a_sdate']}','{$assignment['a_edate']}','{$assignment['c_id']}','{$assignment['cs_id']}','{$assignment['a_hasphoto']}','{$assignment['a_hasaudio']}')" );

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
