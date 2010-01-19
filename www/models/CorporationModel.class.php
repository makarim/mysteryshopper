<?php
class CorporationModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "corporation ","*");
		
		//
		if(isset($con['order'])) $select->order ( $con['order']." desc" );
		if(isset($con['corporation']) && !empty($con['corporation'])) $select->where ( " corporation = '".$con['corporation']."'" );
		if(isset($con['c_id']) && !empty($con['c_id'])) $select->where ( " c_id = '".$con['c_id']."'" );
		if(isset($con['corporation_nickname']) && !empty($con['corporation_nickname'])) $select->where ( " corporation_nickname like '".$con['corporation_nickname']."%'" );
		if(isset($con['corporation_reg_time']) && !empty($con['corporation_reg_time'])) $select->where ( " corporation_reg_time >= '".strtotime($con['corporation_reg_time'])."'" );
		if(isset($con['corporation_reg_time1'])&& !empty($con['corporation_reg_time1'])) $select->where ( " corporation_reg_time < '".strtotime($con['corporation_reg_time1'])."'" );
		
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
	
}

?>