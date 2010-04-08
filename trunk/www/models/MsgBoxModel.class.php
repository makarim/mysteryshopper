<?php
class MsgBoxModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getMsgLists($con,$pageCount){
		$select =$this->db->select();
		$select->from ( " msg_box m","m.*");
		$select->leftjoin ( " user_ext u","u.user_id=m.to_user_id","u.face_img");
		
		if(!empty($con['to_user_id'])) $select->where ( " m.to_user_id='{$con['to_user_id']}'" );
		//if($con['m_pid']==0) $select->where ( " m.m_pid='0'" );
		if(!empty($con['order'])) $select->order ( $con['order']." desc" );
		
		$list = array();
		$offset = '';
		
		$total = $select->count (); 
		include_once("Pager.class.php");
	    $list ['page'] = new Pager ( $total, $pageCount ); 
		$offset = $list ['page']->offset ();               
		
		$pagerStyle = array ('firstPage' => 'page', 'prePage' => 'go_b', 'nextPage' => 'go_b','preGroup'=>'page','nextGroup'=>'page', 'totalPage' => '', 'numBar' => 'on', 'numBarMain' => 'page' );                      //翻页条的样式
		$list ['page']->setLinkStyle ( $pagerStyle );
		$label = array('first_page'=>lang('first_page'),'last_page'=>lang('last_page'),'next_page'=>lang('next_page'),'pre_page'=>lang('pre_page'),'next_group'=>lang('next_group'),'pre_group'=>lang('pre_group'));
		$list ['page']->setLabelName($label);
		if($total>$pageCount){
			$list ['pagebar'] = $arrList ['page']->prePage (lang('pre_page') ) .$arrList ['page']->ocNumBar().$arrList ['page']->nextPage (lang('next_page'));
		}else{
			$list ['pagebar'] = '';
		}
		//print_sql();
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
		return $this->db->getRow("select msg_box.*,user_ext.face_img from msg_box left join user_ext on user_ext.user_id=msg_box.from_user_id where m_id='$m_id'");
	}
	
	function updateMsg($con,$table,$msg_id){
		return $this->db->update($con,$table,$msg_id);
	}
	function getMsgReplies($m_id){
		return $this->db->getAll("select m.*,u.face_img from msg_box m left join user_ext u on u.user_id=m.from_user_id where m.m_pid='$m_id' order by m_id desc");
	}
	function deleteMsg($m_id){
		$m_id = join(",",$m_id);
		return $this->db->execute("delete from msg_box where m_id in ($m_id) or m_pid in ($m_id)");	
	}
}
	?>