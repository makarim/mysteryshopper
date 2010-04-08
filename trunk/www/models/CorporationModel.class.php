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
		if(isset($con['c_name']) && !empty($con['c_name'])) $select->where ( " c_name like '%".$con['c_name']."%'" );
		if(isset($con['c_id']) && !empty($con['c_id'])) $select->where ( " c_id = '".$con['c_id']."'" );
		if(isset($con['c_contacter']) && !empty($con['c_contacter'])) $select->where ( " c_contacter like '%".$con['c_contacter']."%'" );
		if(isset($con['c_title']) && !empty($con['c_title'])) $select->where ( " c_title like '%".$con['c_title']."%'" );
		
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
	function checkName($name){
		return $this->db->getOne ( "select c_id from corporation where c_name = '{$name}'" );
	}
	function createNewCorporation($corp){
		//user table
		return	$this->db->execute ( "insert into corporation ( c_name,c_password,c_title,c_initial,c_contacter, c_phone, c_intro)
		values ('{$corp['c_name']}','" . $corp ['c_password'] . "','{$corp['c_title']}','{$corp['c_initial']}','{$corp['c_contacter']}','{$corp['c_phone']}','{$corp['c_intro']}')" );

	}
	function createNewStore($store){
		return $this->db->execute("insert into store (cs_name,cs_abbr,cs_address,c_id) value ('{$store['cs_name']}','{$store['cs_abbr']}','{$store['cs_address']}','{$store['c_id']}') ");
	}
	function getStoreByCid($c_id){
		return $this->db->getAll("select * from store where c_id='{$c_id}'");
	}
	function getStoreById($cs_id){
		return $this->db->getRow("select * from store where cs_id='{$cs_id}'");
	}
	function updateStore($item,$cs_id){
		return $this->db->update($item,"store"," cs_id=".$cs_id);
	}
	function deleteCorporation($cid){
		return $this->db->execute("delete from corporation where c_id='{$cid}'");
	}	
	function deleteStore($cs_id){
		return $this->db->execute("delete from store where cs_id='{$cs_id}'");
	}
	function getCorporationById($c_id){
		return $this->db->getRow("select * from corporation where c_id='$c_id'");
	}
    function updateCorporation($item,$c_id){
		return $this->db->update($item,"corporation"," c_id=".$c_id);
    }
    function getAllCorps(){
    	return $this->db->getAll("select c_title,c_id,c_initial from corporation order by c_initial");
    }
    
    function getCorporationByName($c_name){
    	return $this->db->getRow("select * from corporation where c_name='$c_name'");
    }
}
?>
