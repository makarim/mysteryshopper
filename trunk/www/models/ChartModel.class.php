<?php
class ChartModel extends Model {
	public $sdate;
	public $edate;
	private $addsql;
	function __construct($sdate,$edate){
		$this->sdate = $sdate;
		$this->edate = $edate;
		$addsql = '';
		if($this->sdate) $this->addsql .= " and a.a_fdate >= '$this->sdate'";
		if($this->edate) $this->addsql .= " and a.a_fdate < '$this->edate'";
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getSummaryScoreByCsId($csid,$group=1){
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id='$csid' $this->addsql";
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
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id='$csid' $this->addsql";
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
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id='$csid' $this->addsql";
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
		$sql="select a.re_id,a.a_id from assignment a where a.cs_id='$csid' $this->addsql";
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
	
	function getSummaryScoreByAsId($a_id,$re_id,$group){
		if($group=='service') $group=1;
		if($group=='environment') $group=2;
		if($group=='product') $group=3;
		if($group=='summary') $group=4;
		$average = 0;
		//一份报告有多少个的同group的打分题目
		$sql = "select rq_id,rq_type from report_question where rq_group='$group' and re_id='".$re_id."'";
		$rq_arr = $this->db->getAll($sql);
		$q_row = count($rq_arr);
		//echo "row:".$q_row."|";
		$sum = 0;
		if($q_row>0){
			foreach ($rq_arr as $rq){
				if($rq['rq_type']==2){
					$sql = "select avg(ans_answer2) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."' and rq_type=2";
					$sum += $this->db->getOne($sql);
				}else if($rq['rq_type']==1){
					$sql = "select ans_answer1  from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."' and rq_type=1";
					$yn = $this->db->getOne($sql);
					$sum += ($yn=='Y')?10:0;
				}
			}
			// 所有题目打分平均值之和/问题个数=一份报告同group的打分题平均值
			$average += $sum/$q_row;
			return round($average,2);
		}
		return 0;
	}
	
	function getVoteScoreByAsId($a_id,$re_id,$group){
		if($group=='service') $group=1;
		if($group=='environment') $group=2;
		if($group=='product') $group=3;
		if($group=='summary') $group=4;
		$average = 0;
		//一份报告有多少个的同group的打分题目
		$sql = "select rq_id,rq_type from report_question where rq_type=2 and rq_group='$group' and re_id='".$re_id."'";
		$rq_arr = $this->db->getAll($sql);
		$q_row = count($rq_arr);
		//echo "row:".$q_row."|";
		$sum = 0;
		if($q_row>0){
			foreach ($rq_arr as $rq){
				$sql = "select avg(ans_answer2) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."' and rq_type=2";
				$sum += $this->db->getOne($sql);
			}
			// 所有题目打分平均值之和/问题个数=一份报告同group的打分题平均值
			$average += $sum/$q_row;
			return round($average,2);
		}
		return 0;
	}
	
	function getYesByAsId($a_id,$re_id,$group){
		if($group=='service') $group=1;
		if($group=='environment') $group=2;
		if($group=='product') $group=3;
		if($group=='summary') $group=4;
		$average = 0;
		//一份报告有多少个的同group的打分题目
		$sql = "select rq_id,rq_type from report_question where rq_type=1 and rq_group='$group' and re_id='".$re_id."'";
		$rq_arr = $this->db->getAll($sql);
		$q_row = count($rq_arr);
		//echo "row:".$q_row."|";
		$sum = 0;
		if($q_row>0){
			foreach ($rq_arr as $rq){
				$sql = "select count(*) from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."' and rq_type=1 and ans_answer1='Y'";
				$sum += $this->db->getOne($sql);
			}
			// 所有题目打分平均值之和/问题个数=一份报告同group的打分题平均值
			$average += $sum/$q_row;
			return round($average,2);
		}
		return 0;
	}
	
	function getTimesByAsId($a_id,$re_id,$group){
		if($group=='service') $group=1;
		if($group=='environment') $group=2;
		if($group=='product') $group=3;
		if($group=='summary') $group=4;
		$average = 0;
		//一份报告有多少个的同group的打分题目
		$sql = "select rq_id,rq_type from report_question where rq_type=1 and rq_group='$group' and re_id='".$re_id."'";
		$rq_arr = $this->db->getAll($sql);
		$q_row = count($rq_arr);
		//echo "row:".$q_row."|";
		$sum = 0;
		if($q_row>0){
			foreach ($rq_arr as $rq){
				$sql = "select avg(ans_answer4) as avg from answer where rq_id='".$rq['rq_id']."' and a_id='".$a_id."' and rq_type=4";
				$sum += $this->db->getOne($sql);
			}
			// 所有题目打分平均值之和/问题个数=一份报告同group的打分题平均值
			$average += $sum/$q_row;
			return round($average,2);
		}
		return 0;
	}
	
	function getTimeQuestionsByCId($c_id,$group){
		if($group=='service') $group=1;
		if($group=='environment') $group=2;
		if($group=='product') $group=3;
		if($group=='summary') $group=4;
		if($group =='all') $addsql =" ";
		$re_id_arr = $this->db->getAll("select re_id from assignment where c_id='$c_id' group by re_id");
		foreach ($re_id_arr as $value) {
			$re_id[] = $value['re_id'];
		}
		
		$re_id_str = join(',',$re_id);
		return $this->db->getAll("select rq_id,rq_type,rq_question from report_question where rq_type=4 and re_id in ($re_id_str) $addsql");
	}
	
	function getAvgTimeByRqId($rq_id,$cs_id){
		$assignment = $this->db->getAll("select a.a_id from assignment a where a.cs_id='$cs_id' $this->addsql");
		$a_id = array();$a_id_str = '';
		
		foreach ($assignment as $v) {
			$a_id[] = $v['a_id'];
		}
		$a_id_str = join(",",$a_id);
		if(count($a_id)>0) 
			$sql = "select avg(ans_answer4) as avg from answer where rq_id='".$rq_id."' and a_id in (".$a_id_str.") and rq_type=4";
		else 
			$sql = "select avg(ans_answer4) as avg from answer where rq_id='".$rq_id."' and a_id = '".$a_id_str."' and rq_type=4";
		//echo $sql;
		return $this->db->getOne($sql);
	}
}
?>
