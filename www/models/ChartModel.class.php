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
	/**
	 * @param  $csid 公司ID
	 * @param $group 问题归属,环境类，服务类，产品类
	 * 
	 **/
	function getVoteScoreByCsId($csid,$group=1){
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id=$csid";
		$data = $this->db->getAll($sql);
		$row =count($data);;
		if($row>0){
			$average = 0;
			foreach ($data as $v){
				//一份报告有多少个的同group的打分题目
				$sql = "select rq_id,rq_type from report_question where rq_type=2 and rq_group='$group' and re_id=".$v['re_id'];
				$rq_arr = $this->db->getAll($sql);
				$q_row = count($rq_arr);
				//echo "row:".$q_row."|";
				$sum = 0;
				if($q_row>0){
					foreach ($rq_arr as $rq){
						//一个问题的所有打分的平均值之和
						$sql = "select avg(ans_answer2) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$v['a_id']."' and rq_type=2";
						$sum += $this->db->getOne($sql);
					}
					// 所有题目打分平均值之和/问题个数=一份报告同group的打分题平均值
					$average += $sum/$q_row;
				}
				
			}
			//几个报告的平均值
			return round($average/$row,2);
		}
		return 0;
	}
	
	function getYesByCsId($csid,$group=1){
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id=$csid";
		$data = $this->db->getAll($sql);
		$row =count($data);;
		if($row>0){
			$average = 0;
			foreach ($data as $v){
				//一份报告有多少个的同group的是非题目
				$sql = "select rq_id,rq_type from report_question where rq_type=1 and rq_group='$group' and re_id=".$v['re_id'];
				$rq_arr = $this->db->getAll($sql);
				$q_row = count($rq_arr);
				$sum = 0;
				if($q_row>0){
					foreach ($rq_arr as $rq){
						//一个问题的有多少个人支持，选是
						$sql = "select count(*) from answer where rq_id='".$rq['rq_id']."' and a_id='".$v['a_id']."' and rq_type=1 and ans_answer1='Y'";
						$sum += $this->db->getOne($sql);
					}
					// 所有题目总支持人数/题目数=一份报告同group的是非题平均值
					$average += $sum;
				}
				
			}
			//几个报告的平均值
			return round($average/$row,2);
		}
		return 0;
	}
	function getTimesByCsId($csid,$group=1){
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id=$csid";
		$data = $this->db->getAll($sql);
		$row =count($data);;
		if($row>0){
			$average = 0;
			foreach ($data as $v){
				//一份报告有多少个的同group的时间题目
				$sql = "select rq_id,rq_type from report_question where rq_type=4 and rq_group='$group' and re_id=".$v['re_id'];
				$rq_arr = $this->db->getAll($sql);
				$q_row = count($rq_arr);
				$sum = 0;
				if($q_row>0){
					foreach ($rq_arr as $rq){
						//一个问题不同人输入时间的平均值
						$sql = "select avg(ans_answer4) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$v['a_id']."' and rq_type=4";
						$sum += $this->db->getOne($sql);
					}
					// 所有题目时间平均值/题目数=一份报告同group的时间平均值
					$average += $sum/$q_row;
				}
				
			}
			//几个报告的平均值
			return round($average/$row,2);
		}
		return 0;
	}
}
?>
