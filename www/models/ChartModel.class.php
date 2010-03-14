<?php
class ChartModel extends Model {
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getSummaryScoreByCsId($csid,$group=1){
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id=$csid";
		$data = $this->db->getAll($sql);
		$row =count($data);;
		if($row>0){
			$average = 0;
			foreach ($data as $v){
				$sql = "select rq_id,rq_type from report_question where rq_group='$group' and re_id=".$v['re_id'];
				$rq_arr = $this->db->getAll($sql);
				$q_row = count($rq_arr);
				//echo "row:".$q_row."|";
				$sum = 0;
				if($q_row>0){
					foreach ($rq_arr as $rq){
						if($rq['rq_type']==2){
							$sql = "select avg(ans_answer2) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$v['a_id']."' and rq_type=2";
							$sum += $this->db->getOne($sql);
						}else if($rq['rq_type']==1){
							$sql = "select ans_answer1  from answer where rq_id='".$rq['rq_id']."' and a_id='".$v['a_id']."' and rq_type=1";
							$yn = $this->db->getOne($sql);
							$sum += ($yn=='Y')?10:0;
						}
						
					}
					//echo $sum;
					$average += $sum/$q_row;
				}
				
			}
			//echo $average;
			return round($average/$row,2);
		}
		return 0;
	}
	
	function getScoreByCsId($csid,$group=1){
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id=$csid";
		$data = $this->db->getAll($sql);
		$row =count($data);;
		if($row>0){
			$average = 0;
			foreach ($data as $v){
				$sql = "select rq_id,rq_type from report_question where rq_type=2 and rq_group='$group' and re_id=".$v['re_id'];
				$rq_arr = $this->db->getAll($sql);
				$q_row = count($rq_arr);
				//echo "row:".$q_row."|";
				$sum = 0;
				if($q_row>0){
					foreach ($rq_arr as $rq){
						$sql = "select avg(ans_answer2) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$v['a_id']."' and rq_type=2";
						$sum += $this->db->getOne($sql);
					}
					//echo $sum;
					$average += $sum/$q_row;
				}
				
			}
			//echo $average;
			return round($average/$row,2);
		}
		return 0;
	}
}
?>
