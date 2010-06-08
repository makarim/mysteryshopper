<?php
class UserModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( " user_index ","*");
		//$select->leftjoin ( " user_index ","*");
		
		//
		if(isset($con['order'])) $select->order ( $con['order']." desc" );
		if(isset($con['user']) && !empty($con['user'])) $select->where ( " user = '".$con['user']."'" );
		if(isset($con['user_id']) && !empty($con['user_id'])) $select->where ( " user_id = '".$con['user_id']."'" );
		if(isset($con['user_nickname']) && !empty($con['user_nickname'])) $select->where ( " user_nickname like '".$con['user_nickname']."%'" );
		if(isset($con['user_reg_time']) && !empty($con['user_reg_time'])) $select->where ( " user_reg_time >= '".strtotime($con['user_reg_time'])."'" );
		if(isset($con['user_reg_time1'])&& !empty($con['user_reg_time1'])) $select->where ( " user_reg_time < '".strtotime($con['user_reg_time1'])."'" );
		
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
	
		if ($rs) {
			foreach ( $rs as $key => $record ) {
				$list ['records'] [$key] = $record;
			}
		}
		return (array) $list;
	}
	function getOnlineUsers($con,$pageCount){
		$select =$this->db->select();
		$select->from ( " onlineuser ","*");
		
		//
		if(isset($con['order'])) $select->order ( $con['order']." desc" );
		if(isset($con['user']) && !empty($con['user'])) $select->where ( " user = '".$con['user']."'" );
		
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
	
		if ($rs) {
			foreach ( $rs as $key => $record ) {
				$list ['records'] [$key] = $record;
			}
		}
		return (array) $list;
	}
	function addBestShopper($fileds,$table){
    	return $this->db->insert($fileds,$table);
    }
    function getBestShopperByMonth($m){
    	return $this->db->getRow("select * from recommend where rec_month='{$m}' and rec_type='U'");
    }
    function getUserInfoById($id,$filed='*'){
    	return $this->db->getRow("select $filed from user_ext where user_id='$id'");
    }
}

?>