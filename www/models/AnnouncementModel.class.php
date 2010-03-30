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
		if(isset($con['an_title']) && !empty($con['a_title'])) $select->where ( " a.an_title like '%".$con['an_title']."%'" );
		if(isset($con['an_date']) && !empty($con['an_date'])) $select->where ( " a.an_date <= '".$con['an_date']."'" );

		
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
	function createNewAnnouncement($an){
		//user table
		return	$this->db->execute ( "insert into announcement ( an_title,  an_content,an_date)
		values ('{$an['an_title']}','" . $an ['an_content'] . "',NOW())" );

	}
	function deleteAnnouncement($an_id){
		return $this->db->execute("delete from announcement where anid='{$an_id}'");
	}
	function getAnnouncementById($an_id){
		return $this->db->getRow("select * from announcement where an_id='$an_id'");
	}
	function getLatestAnnouncement($n=1){
		return $this->db->getAll("select * from announcement order by an_id desc limit $n");
	}
	
}
?>
