<?php
class MsgBoxModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getMsgLists($con,$pageCount){
		$select =$this->db->select();
		$select->from ( " msg_box m","m.*");
		$select->leftjoin ( " user_ext u","u.user_id=m.user_id","u.face_img");
		
		if(!empty($con['user_id'])) $select->where ( " m.user_id='{$con['user_id']}'" );
		if($con['m_pid']==0) $select->where ( " m.m_pid='0'" );
		if(!empty($con['order'])) $select->order ( $con['order']." desc" );
		
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
	
	function saveMsg($msg,$table){
		return $this->db->insert($msg,$table);
	}
	function getMsgById($m_id){
		return $this->db->getRow("select msg_box.*,user_ext.face_img from msg_box left join user_ext on user_ext.user_id=msg_box.user_id where m_id='$m_id'");
	}
	
	function updateMsg($msg_id){
		return $this->db->execute("update msg_box set flag=0 where m_id='$msg_id'");
	}
	function  getMsgReplies($m_id){
		return $this->db->getAll("select m.*,u.face_img from msg_box m left join user_ext u on u.user_id=m.user_id where m.m_pid='$m_id' order by m_id desc");
	}
	function deleteMsg($m_id){
		$m_id = join(",",$m_id);
		return $this->db->execute("delete from msg_box where m_id in ($m_id) or m_pid in ($m_id)");	
	}
}
	?>