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
		$a_edate= !empty($_GET['a_edate'])?$_GET['a_edate']:date("Y-m-d");
		
		$group = !empty($_GET['group'])?$_GET['group']:array();
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'';
		$type_id = isset($GLOBALS['gTypes'][$scoretype])?$GLOBALS['gTypes'][$scoretype]:'';
		//die;
		$chart_title = lang("summary");
		$chart_title.= "/".lang($scoretype);
		$con['c_id'] = $c_id;
		$con['cs_id'] = $cs_id;
		$con['sdate'] = $a_sdate;
		$con['edate'] = $a_edate;
		$con['scoretype'] = $scoretype;
		$con['group'] = join(",",$group);
		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		$corps  = $corpmod->getAllCorps();
		$stores = array();
		if( $c_id ) $stores = $corpmod->getStoreByCid($c_id);
		$def_stores =array();
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($cs_id)?array($cs_id):$def_stores;
		
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();
		$assignments = array();
		if($c_id) $assignments = $assignmentModel->getAssignmentsByCsId($con,$selstores);
		
		if($scoretype=='time'){
			$chart_title = '';
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($a_sdate,$a_edate);
			$questions = $ChartModel->getTimeQuestionsByCId($c_id,'all');
			if($questions){
				$this->tpl->assign("questions",$questions);
			}
		}
		$count = count($assignments);
		
		$a_average =$internal_average= 0;
		
		if(is_array($assignments)){
			foreach ($assignments as $k=>$v){
	
				if($scoretype=='time'){
					foreach ($questions as $qu){
						$v['times'][] = $assignmentModel->getTimeByRqId($qu['rq_id'],$v['a_id']);
					}
				}else{
					$v['service'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],1,$type_id);;
					$v['environment'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],2,$type_id);
					$v['product'] = $assignmentModel->getSummaryScoreByAsId($v['a_id'],$v['re_id'],3,$type_id);
					$a_average += ($v['service']+$v['environment']+$v['product'])/3; 
				}
				$assignments[$k] = $v;
			}
			if($count>0)$internal_average = round($a_average/$count,2);
		}
		
		$print_edate = $assignmentModel->getEndDateByCId($c_id);
		$print_sdate = $assignmentModel->getStartDateByCId($c_id);
		if($a_sdate=='') $a_sdate = $print_sdate;
		if($a_edate=='') $a_edate = $print_edate;
		$chart_title .="($print_sdate/$print_edate)";
		
		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("selstores",$selstores);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign('corps',$corps);
		$this->tpl->assign("internal_average",$internal_average);
		$this->tpl->assign("chart_title",$chart_title);
		$this->tpl->assign("type",$scoretype);
		$this->tpl->assign("sdate",$a_sdate);
		$this->tpl->assign("edate",$a_edate);
		$this->tpl->assign('con',$con);
	}
	
	function segment_brand($brands,$group_id,$type){
		$brand_stores = array();
		$xml = '';
		foreach ($brands as $k=>$brand){
			if(!in_array($brand['b_id'],$this->selbrands_arr)) continue;
			$brand_stores = $this->corpModel->getStoreByBid($brand['b_id']); 
			$brand_stores_count = $score = 0;
			if($brand_stores){
				$brand_stores_count =  count($brand_stores);
				foreach ($brand_stores as $k=>$store){
					if(strtolower($type)=='summary'){ 
						$score += $this->ChartModel->getSummaryScoreByCsId($store['cs_id'],$group_id);
					}
					if(strtolower($type)=='vote'){ 
						$score += $this->ChartModel->getVoteScoreByCsId($store['cs_id'],$group_id);
					}
					if(strtolower($type)=='yesorno'){ 
						$score += $this->ChartModel->getYesByCsId($store['cs_id'],$group_id);
					}					
					if(strtolower($type)=='time'){ 
						$score += $this->ChartModel->getTimesByCsId($store['cs_id'],$group_id);
						
					}
				}
				$score = round($score/$brand_stores_count,2);
			}
			$xml .="<value xid='{$brand['b_id']}'>{$score}</value>\n";
		}
		return $xml;
	}
	
	function segment_store($stores,$group_id,$type){
		foreach ($stores as $k=>$store){
			if(!in_array($store['cs_id'],$this->selstores_arr)) continue;
			if(strtolower($type)=='summary'){ 
				$score = $this->ChartModel->getSummaryScoreByCsId($store['cs_id'],$group_id);
				$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
			}
			if(strtolower($type)=='vote'){ 
				$score = $this->ChartModel->getVoteScoreByCsId($store['cs_id'],$group_id);
				$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
			}
			if(strtolower($type)=='yesorno'){ 
				$score = $this->ChartModel->getYesByCsId($store['cs_id'],$group_id);
				$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
			}					
			if(strtolower($type)=='time'){ 
				$score = $this->ChartModel->getTimesByCsId($store['cs_id'],$group_id);
				$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
			}
		}
		return $xml;
	}
	function view_overalldata(){
		//http://www.spotshoppers.com/admin.php?action=chart&view=overalldata&scoretype=summary&c_id=18&sdate=2009-01-02&edate=2010-04-14&selstores=54,55,56,57,58,59,60,61,62,63&group=product
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$b_id = !empty($_GET['b_id'])?$_GET['b_id']:'';
		$group = !empty($_GET['group'])?$_GET['group']:'';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:'';
		$edate = !empty($_GET['edate'])?$_GET['edate']:'';
		$this->selbrands_arr =  $this->selstores_arr = array();
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:'';
		if($selstores) $this->selstores_arr = explode(",",$selstores);
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:'';
		if($selbrands) $this->selbrands_arr = explode(",",$selbrands);
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'summary';
		
		$xml = "<?xml version='1.0' encoding='UTF-8'?>
<chart>";
		if($c_id){
			include_once("ChartModel.class.php"); 
			$this->ChartModel = new ChartModel($sdate,$edate);
			
			include_once("CorporationModel.class.php");	
			$this->corpModel = new CorporationModel();
			
			if(count($this->selbrands_arr)>1){
				$brands = $this->corpModel->getBrandByCid($c_id);
				$xml .="<series>\n";
				foreach ($brands as $k=>$brand){
					if(!in_array($brand['b_id'],$this->selbrands_arr)) continue;
					$xml .="<value xid='{$brand['b_id']}'>{$brand['b_name']}</value>\n";
				}
				$xml .="</series>\n<graphs>\n";
				
				if(strpos($group,'environment')!==false){	
						$xml .="<graph gid='0'>\n";			
						$xml .= $this->segment_brand($brands,2,$scoretype);
						$xml .="</graph>\n";
				}
				if(strpos($group,'service')!==false){	
						$xml .="<graph gid='1'>\n";			
						$xml .= $this->segment_brand($brands,1,$scoretype);
						$xml .="</graph>\n";
				}				
				if(strpos($group,'product')!==false){	
						$xml .="<graph gid='2'>\n";			
						$xml .= $this->segment_brand($brands,3,$scoretype);
						$xml .="</graph>\n";
				}
				
			}else{
					$stores = $this->corpModel->getStoreByBid($b_id);
					$xml .="<series>\n";
					foreach ($stores as $k=>$store){
						if(!in_array($store['cs_id'],$this->selstores_arr)) continue;
						$xml .="<value xid='{$store['cs_id']}'>{$store['cs_name']}</value>\n";
					}
					$xml .="</series>\n<graphs>\n";
					
					if(strpos($group,'environment')!==false){	
						$xml .="<graph gid='0'>\n";			
						$xml .= $this->segment_store($stores,2,$scoretype);
						$xml .="</graph>\n";
					}
					if(strpos($group,'service')!==false){	
						$xml .="<graph gid='1'>\n";
						$xml .= $this->segment_store($stores,1,$scoretype);
						$xml .="</graph>\n";
					}
					
					if(strpos($group,'product')!==false){
						$xml .="<graph gid='2'>\n";
						$xml .= $this->segment_store($stores,3,$scoretype);
						$xml .="</graph>\n";
					}
					$xml.="</graphs>\n";
			}
			//echo $ChartModel->getScoreByCsId(1,2);
		}

$xml .="
</chart>
";
		echo $xml;die;
	}
	function view_generaldata(){
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$b_id = !empty($_GET['b_id'])?$_GET['b_id']:'';
		$group = !empty($_GET['group'])?$_GET['group']:'';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:'';
		$edate = !empty($_GET['edate'])?$_GET['edate']:'';
		$selbrands_arr =  $selstores_arr = array();
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:'';
		if($selstores) $selstores_arr = explode(",",$selstores);
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:'';
		if($selbrands) $selbrands_arr = explode(",",$selbrands);
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'general';
		
		$xml = "<?xml version='1.0' encoding='UTF-8'?>
<chart>";
		if($c_id){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			
			include_once("CorporationModel.class.php");	
			$corpModel = new CorporationModel();
			
			if(count($selbrands_arr)>1){
				$brands = $corpModel->getBrandByCid($c_id);
				$xml .="<series>\n";
				foreach ($brands as $k=>$brand){
					if(!in_array($brand['b_id'],$selbrands_arr)) continue;
					$xml .="<value xid='{$brand['b_id']}'>{$brand['b_name']}</value>\n";
				}
				$xml .="</series>\n<graphs>\n";
				$xml .="<graph gid='3'>\n";
					foreach ($brands as $k=>$brand){
						if(!in_array($brand['b_id'],$selbrands_arr)) continue;
						if(strtolower($scoretype)=='general'){ 
							$brand_stores = $corpModel->getStoreByBid($brand['b_id']); 
							$brand_stores_count = $score = 0;
							if($brand_stores){
								$brand_stores_count =  count($brand_stores);
								foreach ($brand_stores as $store){
									$score += $ChartModel->getGeneralScoreByCsId($store['cs_id']);
								}
								$score = round($score/$brand_stores_count,2);
							}
							
							$xml .="<value xid='{$brand['b_id']}'>{$score}</value>\n";
						}
						
					}
					$xml .="</graph>\n";
				
			
				$xml.="</graphs>\n";
				
				
			}else{
				$stores = $corpModel->getStoreByBid($b_id);
				$xml .="<series>\n";
				foreach ($stores as $k=>$store){
					if(!in_array($store['cs_id'],$selstores_arr)) continue;
					$xml .="<value xid='{$store['cs_id']}'>{$store['cs_name']}</value>\n";
				}
				$xml .="</series>\n<graphs>\n";
					
					$xml .="<graph gid='3'>\n";
					foreach ($stores as $k=>$store){
						if(!in_array($store['cs_id'],$selstores_arr)) continue;
						if(strtolower($scoretype)=='general'){ 
							$score = $ChartModel->getGeneralScoreByCsId($store['cs_id']);
							$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
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
	function view_storedata(){
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:'';
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'summary';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$xml = "<?xml version='1.0' encoding='UTF-8'?>
<chart>";
		if($cs_id){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$con['sdate'] = $sdate;
			$con['edate'] = $edate;
			$con['a_audit'] = 1;
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
						if(strtolower($scoretype)=='vote'){ 
							$score = $ChartModel->getVoteScoreByAsId($v['a_id'],$v['re_id'],'service');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='yesorno'){ 
							$score = $ChartModel->getYesByAsId($v['a_id'],$v['re_id'],'service');
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
						if(strtolower($scoretype)=='vote'){ 
							$score = $ChartModel->getVoteScoreByAsId($v['a_id'],$v['re_id'],'environment');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='yesorno'){ 
							$score = $ChartModel->getYesByAsId($v['a_id'],$v['re_id'],'environment');
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
						if(strtolower($scoretype)=='vote'){ 
							$score = $ChartModel->getVoteScoreByAsId($v['a_id'],$v['re_id'],'product');
							$xml .="<value xid='{$v['a_id']}'>{$score}</value>\n";
						}
						if(strtolower($scoretype)=='yesorno'){ 
							$score = $ChartModel->getYesByAsId($v['a_id'],$v['re_id'],'product');
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
	
	function view_storetimedata(){
		$cs_id = !empty($_GET['cs_id'])?$_GET['cs_id']:'';
		$scoretype = !empty($_GET['scoretype'])?$_GET['scoretype']:'summary';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:"";
		$edate = !empty($_GET['edate'])?$_GET['edate']:"";
		$xml = "<?xml version='1.0' encoding='UTF-8'?>
<chart>";
		if($cs_id){
			include_once("ChartModel.class.php"); 
			$ChartModel = new ChartModel($sdate,$edate);
			$con['sdate'] = $sdate;
			$con['edate'] = $edate;
			$con['a_audit'] = 1;
			include_once("AssignmentModel.class.php");	
			$assignmentModel = new AssignmentModel();
			$series = $assignmentModel->getAssignmentsByCsId($con,$cs_id);
			if(count($series)>0){
				$xml .="<series>\n";
				foreach ($series as $k=>$v){
					$xml .="<value xid='{$v['a_id']}'>{$v['day']}</value>\n";
				}
				$xml .="</series>\n<graphs>\n";
				$questions = $ChartModel->getTimeQuestionsByCsId($cs_id,'all');
				foreach ($questions as $k=> $qu){
					$k=$k+1;
					$xml .="<graph gid='$k'>\n";
						foreach ($series as $kk=>$vv){
						
							if(strtolower($scoretype)=='time'){ 
								$score = $ChartModel->getTimeByRqId($qu['rq_id'],$vv['a_id']);
								$xml .="<value xid='{$vv['a_id']}'>{$score}</value>\n";
							}					
							
						}
						$xml .="</graph>\n";
					
				}	
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
		$b_id = !empty($_GET['b_id'])?$_GET['b_id']:'';
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$group = !empty($_GET['group'])?$_GET['group']:'';
		$sdate = !empty($_GET['sdate'])?$_GET['sdate']:'';
		$edate = !empty($_GET['edate'])?$_GET['edate']:'';
		$selstores = !empty($_GET['selstores'])?$_GET['selstores']:'';
		if($selstores) $selstores_arr = explode(",",$selstores);
		$selbrands = !empty($_GET['selbrands'])?$_GET['selbrands']:'';
		if($selbrands) $this->selbrands_arr = explode(",",$selbrands);
		
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
	
	function view_comment(){
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$cs_id= !empty($_GET['cs_id'])?$_GET['cs_id']:'';
		$a_sdate= !empty($_GET['a_sdate'])?$_GET['a_sdate']:'';
		$a_edate= !empty($_GET['a_edate'])?$_GET['a_edate']:date("Y-m-d");
		
		include_once("CorporationModel.class.php");	
		$corpModel = new CorporationModel();
		$corps  = $corpModel->getAllCorps();
		$stores = $corpModel->getStoreByCid($c_id);
			
		$def_stores =array();
		foreach ($stores as $s){
			$def_stores[] = $s['cs_id']; 
		}
		$selstores = !empty($cs_id)?array($cs_id):$def_stores;
		
		$con['c_id'] = $c_id;
		$con['cs_id'] = $cs_id;
		$con['sdate'] = $a_sdate;
		$con['edate'] = $a_edate;
		$con['order'] = 'a_id';
		$con['selstores'] = $selstores;
		$con['a_audit'] = 1;
		include_once("AssignmentModel.class.php");	
		$assignmentModel = new AssignmentModel();

		$assignments = $assignmentModel->getAssignmentComments($con,10);
		
		$print_edate = $assignmentModel->getEndDateByCId($c_id);
		$print_sdate = $assignmentModel->getStartDateByCId($c_id);
		if($a_sdate=='') $a_sdate = $print_sdate;
		if($a_edate=='') $a_edate = $print_edate;

		$this->tpl->assign("assignments",$assignments);
		$this->tpl->assign("con",$con);
		$this->tpl->assign("corps",$corps);
		$this->tpl->assign("stores",$stores);
		$this->tpl->assign("sdate",$a_sdate);
		$this->tpl->assign("edate",$a_edate);
	}
}
?>