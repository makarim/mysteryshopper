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
		$con['c_id'] = $c_id;
		$con['cs_id'] = $cs_id;
		$con['a_sdate'] = $a_sdate;
		$con['a_edate'] = $a_edate;
		include_once("CorporationModel.class.php");
		$corpmod = new CorporationModel();
		$corps  = $corpmod->getAllCorps();
		$this->tpl->assign('corps',$corps);
		
		$this->tpl->assign('con',$con);
	}
	function view_overalldata(){
		$c_id = !empty($_GET['c_id'])?$_GET['c_id']:'';
		$xml = "<?xml version='1.0' encoding='UTF-8'?>
<chart>";
		if($c_id){
			include_once("ChartModel.class.php");
			$ChartModel = new ChartModel();
			
			include_once("CorporationModel.class.php");	
			$corpModel = new CorporationModel();
			$stores = $corpModel->getStoreByCid($c_id);
			$xml .="<series>\n";
			foreach ($stores as $k=>$store){
				$xml .="<value xid='{$store['cs_id']}'>{$store['cs_name']}</value>\n";
			}
			$xml .="</series>\n<graphs>\n";
			$xml .="<graph gid='0'>\n";
			foreach ($stores as $k=>$store){
				$score = $ChartModel->getSummaryScoreByCsId($store['cs_id'],1);
				$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
			}
			$xml .="</graph>\n<graph gid='1'>\n";			
			foreach ($stores as $k=>$store){
				$score = $ChartModel->getSummaryScoreByCsId($store['cs_id'],2);
				$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
			}
			$xml .="</graph>\n<graph gid='2'>\n";
			foreach ($stores as $k=>$store){
				$score = $ChartModel->getSummaryScoreByCsId($store['cs_id'],3);
				$xml .="<value xid='{$store['cs_id']}'>{$score}</value>\n";
			}
			$xml .="</graph>\n</graphs>\n";
			//echo $ChartModel->getScoreByCsId(1,2);
		}

$xml .="
</chart>
";
		echo $xml;die;
	}
	function view_environment(){
		
	}
	
	function view_product(){
		
	}
	function view_service(){
		
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