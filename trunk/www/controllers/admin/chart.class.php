<?php
class chart{
	function __construct(){
		global $tpl;
		$this->tpl = $tpl;
	}
	function view_overall(){
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$cs_id= !empty($_GET['cs_id'])?$_GET['cs_id']:'';
		$a_sdate= !empty($_GET['a_sdate'])?$_GET['a_sdate']:'';
		$a_edate= !empty($_GET['a_edate'])?$_GET['a_edate']:'';
		$group = !empty($_GET['group'])?$_GET['group']:array();
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'';
		//die;
		$con['c_id'] = $c_id;
		$con['cs_id'] = $cs_id;
		$con['a_sdate'] = $a_sdate;
		$con['a_edate'] = $a_edate;
		$con['scoretype'] = $scoretype;
		$con['group'] = join(",",$group);
		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		$corps  = $corpmod->getAllCorps();
		$this->tpl->assign('corps',$corps);
		
		$this->tpl->assign('con',$con);
	}
	function view_overalldata(){
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$group = !empty($_GET['group'])?$_GET['group']:'';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:'';
		$edate = !empty($_GET['edate'])?$_GET['edate']:'';
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:'';
		if($selstores) $selstores_arr = explode(",",$selstores);
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'summary';
		
		$xml = "<?xml version='1.0' encoding='UTF-8'?>
<chart>";
		if($c_id){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			
			include_once("CorporationModel.class.php");	
			$corpModel = new CorporationModel();
			$stores = $corpModel->getStoreByCid($c_id);
			$xml .="<series>\n";
			foreach ($stores as $k=>$store){
				if(!in_array($store['cs_id'],$selstores_arr)) continue;
				$xml .="<value xid='{$store['cs_id']}'>{$store['cs_name']}</value>\n";
			}
			$xml .="</series>\n<graphs>\n";
			if(strpos($group,'service')!==false){	
				$xml .="<graph gid='0'>\n";
				foreach ($stores as $k=>$store){
					if(!in_array($store['cs_id'],$selstores_arr)) continue;
					if(strtolower($scoretype)=='summary'){ 
						$score = $ChartModel->getSummaryScoreByCsId($store['cs_id'],1);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
					if(strtolower($scoretype)=='score'){ 
						$score = $ChartModel->getVoteScoreByCsId($store['cs_id'],1);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
					if(strtolower($scoretype)=='yesorno'){ 
						$score = $ChartModel->getYesByCsId($store['cs_id'],1);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}					
					if(strtolower($scoretype)=='time'){ 
						$score = $ChartModel->getTimesByCsId($store['cs_id'],1);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
				}
				$xml .="</graph>\n";
			}
			if(strpos($group,'environment')!==false){	
				$xml .="<graph gid='1'>\n";			
				foreach ($stores as $k=>$store){
					if(!in_array($store['cs_id'],$selstores_arr)) continue;
					if(strtolower($scoretype)=='summary'){ 
						$score = $ChartModel->getSummaryScoreByCsId($store['cs_id'],2);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
					if(strtolower($scoretype)=='score'){ 
						$score = $ChartModel->getVoteScoreByCsId($store['cs_id'],2);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
					if(strtolower($scoretype)=='yesorno'){ 
						$score = $ChartModel->getYesByCsId($store['cs_id'],2);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}					
					if(strtolower($scoretype)=='time'){ 
						$score = $ChartModel->getTimesByCsId($store['cs_id'],2);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
				}
				$xml .="</graph>\n";
			}
			if(strpos($group,'product')!==false){
				$xml .="<graph gid='2'>\n";
				foreach ($stores as $k=>$store){
					if(!in_array($store['cs_id'],$selstores_arr)) continue;
					if(strtolower($scoretype)=='summary'){ 
						$score = $ChartModel->getSummaryScoreByCsId($store['cs_id'],3);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
					if(strtolower($scoretype)=='score'){ 
						$score = $ChartModel->getVoteScoreByCsId($store['cs_id'],3);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
					if(strtolower($scoretype)=='yesorno'){ 
						$score = $ChartModel->getYesByCsId($store['cs_id'],3);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}					
					if(strtolower($scoretype)=='time'){ 
						$score = $ChartModel->getTimesByCsId($store['cs_id'],3);
						$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
					}
				}
				$xml .="</graph>\n";
			}
			$xml.="</graphs>\n";
			//echo $ChartModel->getScoreByCsId(1,2);
		}

$xml .="
</chart>
";
		echo $xml;die;
	}

	function view_storedata(){
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:'';
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'summary';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$xml = "<?xml version='1.0' encoding='UTF-8'?>
<chart>";
		if($cs_id){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel();
			$con['sdate'] = $sdate;
			$con['edate'] = $edate;
			include_once("AssignmentModel.class.php");	
			$assignmentModel = new AssignmentModel();
			$series = $assignmentModel->getAssignmentsByCsId($con,$cs_id);
			if(count($series)>0){
				$xml .="<series>\n";
				foreach ($series as $k=>$v){
					$xml .="<value xid='{$v['a_id']}'>{$v['day']}</value>\n";
				}
				$xml .="</series>\n<graphs>\n";
				
				
				$xml .="<graph gid='1'>\n";
					foreach ($series as $k=>$v){
						if(strtolower($scoretype)=='summary'){ 
							$score = $ChartModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],'service');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='score'){ 
							$score = $ChartModel->getVoteScoreByAsId($v['a_id'],$v['re_id'],'service');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='yesorno'){ 
							$score = $ChartModel->getYesByAsId($v['a_id'],$v['re_id'],'service');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}					
						if(strtolower($scoretype)=='time'){ 
							$score = $ChartModel->getTimesByAsId($v['a_id'],$v['re_id'],'service');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
					}
					$xml .="</graph>\n";
				
					$xml .="<graph gid='2'>\n";			
					foreach ($series as $k=>$v){
						if(strtolower($scoretype)=='summary'){ 
							$score = $ChartModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],'environment');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='score'){ 
							$score = $ChartModel->getVoteScoreByAsId($v['a_id'],$v['re_id'],'environment');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='yesorno'){ 
							$score = $ChartModel->getYesByAsId($v['a_id'],$v['re_id'],'environment');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}					
						if(strtolower($scoretype)=='time'){ 
							$score = $ChartModel->getTimesByAsId($v['a_id'],$v['re_id'],'environment');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
					}
					$xml .="</graph>\n";
	
					$xml .="<graph gid='3'>\n";
					foreach ($series as $k=>$v){
						if(strtolower($scoretype)=='summary'){ 
							$score = $ChartModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],'product');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='score'){ 
							$score = $ChartModel->getVoteScoreByAsId($v['a_id'],$v['re_id'],'product');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='yesorno'){ 
							$score = $ChartModel->getYesByAsId($v['a_id'],$v['re_id'],'product');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}					
						if(strtolower($scoretype)=='time'){ 
							$score = $ChartModel->getTimesByAsId($v['a_id'],$v['re_id'],'product');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
					}
					$xml .="</graph>\n";
				
				$xml.="</graphs>\n";
			}
			//echo $ChartModel->getScoreByCsId(1,2);
		}

$xml .="
</chart>
";
		echo $xml;die;
	}
	
	function view_timedata(){
		$rq_id = !empty($_GET['rq_id'])?$_GET['rq_id']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$group = !empty($_GET['group'])?$_GET['group']:'';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:'';
		$edate = !empty($_GET['edate'])?$_GET['edate']:'';
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:'';
		if($selstores) $selstores_arr = explode(",",$selstores);
		
		
		include_once("ChartModel.class.php"); 
		$ChartModel = new ChartModel($sdate,$edate);
		//$questions = $ChartModel->getTimeQuestionsByAsId($a_id,$re_id,$group);
		
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$stores = $corpModel->getStoreByCid($c_id);
		$csv = '';

		foreach ($stores as $k=>$store){
			if(!in_array($store['cs_id'],$selstores_arr)) continue;
			$avg_times = $ChartModel->getAvgTimeByRqId($rq_id,$store['cs_id']);
			$avg_times = round($avg_times,2);
			$csv .="{$store['cs_name']};$avg_times\n";
		}
		echo $csv;
	}
	function view_defaults(){
		$cur_sort = !empty($_GET['sort'])?$_GET['sort']:'re_id';
		$re_title = !empty($_GET['re_title'])?$_GET['re_title']:'';
		
		
		include_once("ChartModel.class.php");
		$chartModel = new ChartModel();
		
		$con['order'] = $cur_sort;
		$con['re_title'] = $re_title;
		
		$items = $chartModel->getItems($con,10);

		$this->tpl->assign('charts',$items);
		$this->tpl->assign('total',$items['page']->total);
		$this->tpl->assign('con',$con);
	}
}
?>