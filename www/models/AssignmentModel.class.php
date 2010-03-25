<?php
class AssignmentModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getItems($con,$pageCount){
		$select =$this->db->select();
		$select->from ( "assignment a","a.*");
		$select->leftJoin('corporation c','c.c_id=a.c_id','c.c_title,c.c_logo');
		$select->leftJoin('store s','s.cs_id=a.cs_id','s.cs_name');
		
		
		//
		if(isset($con['order'])) $select->order ( 'a.'.$con['order']." desc" );
		if(isset($con['a_title']) && !empty($con['a_title'])) $select->where ( " a.a_title like '%".$con['a_title']."%'" );
		if(isset($con['c_id']) && !empty($con['c_id'])) $select->where ( " a.c_id = '".$con['c_id']."'" );
		if(isset($con['cs_id']) && !empty($con['cs_id'])) $select->where ( " a.cs_id = '".$con['cs_id']."'" );
		if(isset($con['a_sdate']) && !empty($con['a_sdate'])) $select->where ( " a.a_sdate >= '".$con['a_sdate']."'" );
		if(isset($con['a_edate']) && !empty($con['a_edate'])) $select->where ( " a.a_edate <= '".$con['a_edate']."'" );
		if(isset($con['notselected']) && !empty($con['notselected'])) $select->where ( " a.user_id = ''" );

		
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
	function createNewAssignment($as){
		//user table
		return	$this->db->execute ( "insert into assignment ( a_title,  a_desc,a_sdate,a_edate, c_id, cs_id,a_hasphoto,a_hasaudio,re_id,a_quiz)
		values ('{$as['a_title']}','" . $as ['a_desc'] . "','{$as['a_sdate']}','{$as['a_edate']}','{$as['c_id']}','{$as['cs_id']}','{$as['a_hasphoto']}','{$as['a_hasaudio']}','{$as['re_id']}','{$as['a_quiz']}')" );

	}
	function deleteAssignment($a_id){
		return $this->db->execute("delete from assignment where a_id='{$a_id}'");
	}
	function getAssignmentById($a_id){
		return $this->db->getRow("select a.*,c.c_name,s.cs_name,c.c_logo from assignment a 
		left join corporation c on c.c_id=a.c_id
		left join store s on s.cs_id=a.cs_id
	
		where a.a_id='$a_id'");
	}
	function getAssignmentApplyCountById($a_id){
		return $this->db->getOne("select count(*) from assignment_rel where a_id='$a_id'");
	}
	function apply($a_id,$u_id){
		return $this->db->execute("insert into assignment_rel (a_id,user_id,selected) values ('$a_id','$u_id',0)");
		
	}
	function getAssignmentApplicantById($a_id){
		return $this->db->getAll("select r.user_id,r.selected,u.user_nickname as nickname,u.user_email as email,ext.realname,ext.mobile,ext.phone,u.user_sex as gender  from assignment_rel r 
		left join user_ext ext on ext.user_id=r.user_id 
		left join user u on u.user_id=r.user_id 
		where r.a_id='$a_id'");
	}
	function chooseApplicant($a_id,$user_id){
		$this->db->execute("update assignment_rel set selected=0 where a_id='$a_id'");
		return $this->db->execute("update assignment_rel set selected=1 where a_id='$a_id' and user_id='$user_id'");
	}
	
    function updateAssignment($item,$a_id){
		return $this->db->update($item,"assignment"," a_id=".$a_id);
    }
    function generateQuiz($quiz_text){
    	$quiz_arr = array();
    	if($quiz_text){
    		$arr = explode("\n",$quiz_text);
    		if(isset($arr) && is_array($arr)){
    			foreach ($arr as $k=>$v){
    				$v_arr = explode("|",$v);
    				foreach ($v_arr as $vv){
    					if(strpos($vv,'title:')!==false){
    						$quiz_arr[$k]['title'] = substr($vv,6);
    					}
    					if(strpos($vv,'A:')!==false){
    						$quiz_arr[$k]['A'] = substr($vv,2);
    					}    					
    					if(strpos($vv,'B:')!==false){
    						$quiz_arr[$k]['B'] = substr($vv,2);
    					}    					
    					if(strpos($vv,'C:')!==false){
    						$quiz_arr[$k]['C'] = substr($vv,2);
    					}    					
    					if(strpos($vv,'D:')!==false){
    						$quiz_arr[$k]['D'] = substr($vv,2);
    					}
    					if(strpos($vv,'answer:')!==false){
    						$quiz_arr[$k]['answer'] = trim(substr($vv,7));
    					}
    					
    				}
    				
    				
    			}
    			return $quiz_arr;
    		}
    	}
    	return '';
    }
    
    function getMyAssignments($user_id){
    	return $this->db->getAll("select r.user_id,r.selected,a.* ,c.c_logo
    	from assignment_rel r 
		left join assignment a on a.a_id=r.a_id 
		left join corporation c on c.c_id=a.c_id 
		where r.user_id='$user_id'
		order by a.a_edate asc;
		");
    }    
    function getMyHistoryAssignments($user_id){
    	return $this->db->getAll("select r.user_id,r.selected,a.*  ,s.cs_name,c.c_title
    	from assignment_rel r 
		left join assignment a on a.a_id=r.a_id 
		left join store s on s.cs_id=a.cs_id 
		left join corporation c on c.c_id=a.c_id 
		where r.user_id='$user_id' and a.a_finish =1
		order by a.a_edate asc;
		");
    }
    function getLastestAssignments(){
    	return $this->db->getAll("select a.* ,c.c_logo
    	from assignment a
		left join corporation c on c.c_id=a.c_id 
		where a.user_id='' 
		order by a.a_order desc limit 8;
		");
    }
    
    function getAssignmentsByCsId($con,$cs_id){
    	$add = '';
    	if(!empty($con['sdate'])) $add .= " and a_fdate >='".$con['sdate']."'";
    	if(!empty($con['edate'])) $add .= " and a_fdate < '".$con['edate']."'";
    	//echo "select a_id,re_id,DATE_FORMAT(a_fdate, '%m-%d') as day,a_title from assignment where cs_id='$cs_id' $add order by day";
    	return $this->db->getAll("select a_id,re_id,DATE_FORMAT(a_fdate, '%m-%d') as day,a_title from assignment where cs_id='$cs_id' $add order by day");
    }
}
?>
