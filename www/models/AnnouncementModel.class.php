<?php
class AnnouncementModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "announcement a","a.*");
		
		
		//
		if(isset($con['order'])) $select->order ( 'a.'.$con['order']." desc" );
		if(isset($con['an_title']) && !empty($con['an_title'])) $select->where ( " a.an_title like '%".$con['an_title']."%'" );
		if(isset($con['an_date']) && !empty($con['an_date'])) $select->where ( " a.an_date <= '".$con['an_date']."'" );

		
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
	function createNewAnnouncement($an){
		//user table
		return	$this->db->execute ( "insert into announcement ( an_title,  an_content,an_date)
		values ('{$an['an_title']}','" . $an ['an_content'] . "',NOW())" );

	}
	function deleteAnnouncement($an_id){
		return $this->db->execute("delete from announcement where an_id='{$an_id}'");
	}
	function getAnnouncementById($an_id){
		return $this->db->getRow("select * from announcement where an_id='$an_id'");
	}
	function getLatestAnnouncement($n=1){
		return $this->db->getAll("select * from announcement order by an_id desc limit $n");
	}
	function updateNotice($item,$an_id){
		return $this->db->update($item,"announcement"," an_id=".$an_id);
    }
    function getLastRecComments($n=10){
    	return $this->db->getAll("select * from recommend where rec_type='C'  order by rec_id desc limit $n");
    }
}
?>
