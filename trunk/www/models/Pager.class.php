<?php
/*----------------------------- 分页类 ----------------------------------
//文件名: Pager.class.php
//描述: 数据分页类

/////////////////// 例子 ////////////////////
$total = 1000;
$pageitem = 20;
//快速使用
$pageObject = new Pager($total, $pageitem);
$offset    = "offset=".$pageObject->offset();
$pagebar2  = $pageObject->wholeNumBar(10);
echo $offset."<br>".$pagebar2."<br><br>";

//自定义
echo $pageObject->firstPage();
echo $pageObject->prePage();
echo $pageObject->numBar('10',' ',' ');
echo $pageObject->nextPage();
echo $pageObject->lastPage();

//可选
$pageObject->setLinkScript("ajaxLink('@PAGE@');");
//翻页条的样式
$pagerStyle = array ('firstPage' => '', 'prePage' => 'gray4_12b none', 'nextPage' => 'gray4_12b none', 'totalPage' => '', 'numBar' => 'yellowf3_12b none', 'numBarMain' => 'gray4_12 none' );
$pageObject->setLinkStyle ( $pagerStyle );
-------------------------------------------------------------------------*/
class Pager {
	//总条数
	public $total;
	//每页显示条数
	private $pageitem;
	//显示页码数
	private $num;
    //当前页数
	private $page;
    //总分页数
	private $totalPage;
    //分页起点
	private $offset;
	//链接头
	private $linkhead;
	//链接样色
	private $linkStyle;
	private $labelName = array('first_page'=>'首页','last_page'=>'尾页','next_page'=>'下一页','pre_page'=>'上一页','next_group'=>'下一组','pre_group'=>'上一组');
	//连接脚本代码
	private $linkScript;
	//页数前后间隔数
	private $PageStride;

	public function __construct($total, $pageitem=10) {
	
		$this->PageStride = 5;
		$this->page = !isset ( $_GET ['page'] ) ? 1 : intval($_GET ['page']);
		$this->total = $total;
		$this->pageitem = $pageitem;
		$this->totalPage = ceil ( $total / $pageitem );

		if ($this->page > $this->totalPage) {	
			$this->offset = 0;
		} else {
			$this->offset = ($this->page - 1) * $pageitem;
		}

		$linkarr = explode ( "page=", $_SERVER ['QUERY_STRING'] );
		$linkft = $linkarr [0];

		if (empty ( $linkft )) {
			$this->linkhead = $_SERVER ['PHP_SELF'] . "?" ;
		} else {
			$linkft = (substr ( $linkft, - 1 ) == "&") ? $linkft : $linkft . "&";
			$this->linkhead = $_SERVER ['PHP_SELF'] . "?" . $linkft ;
		}
		
	}

	public function setLinkStyle($linkStyle) {
		$this->linkStyle = $linkStyle;
	}

	public function setLinkScript($func) {
		$this->linkScript = $func;
	}

	public function setLabelName($label){
		$this->labelName = $label;
	}
	private function _getLinkScript($num) {
		return str_replace ( "@PAGE@", $num, $this->linkScript );
	}

	public function offset() {
		return $this->offset;
	}

	public function firstPage() {
		return $this->_returnLinkCode($this->labelName['first_page'],1,$this->linkStyle['firstPage'],$this->labelName['first_page']);
	}

	public function lastPage() {		
		return $this->_returnLinkCode($this->labelName['last_page'],$this->totalPage,$this->linkStyle['totalPage'],$this->labelName['last_page']);
	}

	public function prePage($str='[<]') {
		if ($this->page > 1) {
			$prePage = $this->page - 1;
			return $this->_returnLinkCode($str,$prePage,$this->linkStyle['prePage'],$this->labelName['pre_page']);
		} else {
			return '';
		}
	}

	public function nextPage($str='[>]') {

		if ($this->page < $this->totalPage) {
			$nextPage = $this->page + 1;
			return $this->_returnLinkCode($str,$nextPage,$this->linkStyle['nextPage'],$this->labelName['next_page']);

		} else {
			return '';
		}
	}
	public function numBar($num = '', $left = ' [', $right = '] ') {

		$num = (empty ( $num )) ? 10 : $num;
		$this->num = $num;
		$mid = floor ( $num / 2 );
		$last = $num - 1;

		$minpage = (($this->page - $mid) < 1) ? 1 : ($this->page - $mid);
		$maxpage = $minpage + $last;
		if ($maxpage > $this->totalPage) {
			$maxpage = $this->totalPage;
			$minpage = $maxpage - $last;
			$minpage = ($minpage < 1) ? 1 : $minpage;
		}
		$linkbar = '';
		for($i = $minpage; $i <= $maxpage; $i ++) {
			$char = $left . $i . $right;
			if ($i == $this->page) {
				$linkbar .= $this->_returnLinkCode($char,$i,$this->linkStyle['numBar'],$i);
			}else{
				$linkbar .= $this->_returnLinkCode($char,$i,$this->linkStyle['numBarMain'],$i);
			}
		}
		return $linkbar;
	}

	public function preGroup() {

		$mid = floor ( $this->num / 2 );
		$minpage = (($this->page - $mid) < 1) ? 1 : ($this->page - $mid);
		$pgpagecount = ($minpage > $this->num) ? $minpage - $mid : 1;
		return $this->_returnLinkCode("[..]",$pgpagecount,$this->linkStyle['preGroup'],$this->labelName['pre_group']);
	}

	public function nextGroup() {
	
		$mid = floor ( $this->num / 2 );
		$last = $this->num;
		$minpage = (($this->page - $mid) < 1) ? 1 : ($this->page - $mid);
		$maxpage = $minpage + $last;
		if ($maxpage > $this->totalPage) {
			$maxpage = $this->totalPage;
		}
		$ngpagecount = ($this->totalPage > $maxpage + $last) ? $maxpage + $mid : $this->totalPage;
		return $this->_returnLinkCode("[..]" ,$ngpagecount,$this->linkStyle['nextGroup'],$this->labelName['next_group']);
	}

	public function wholeNumBar($num = '') {
		$numBar = $this->numBar ( $num );
		return $this->firstPage () . $this->preGroup () . $this->prePage ( ) . $numBar . $this->nextPage ( ) . $this->nextGroup (  ) . $this->lastPage ( );
	}


	private function _returnLinkCode($char,$page,$class,$title){
		if ($this->linkScript) {
			return "<a href='#' onclick='{$this->_getLinkScript($page)}' title='{$title}' class='{$class}'>{$char}</a>\n";
		} else {
			return "<span class='{$class}'><a href='{$this->linkhead}page={$page}' title='{$title}'>{$char}</a></span>\n";
		}
	
	}
	
	
	public function ocNumBar () {
				
		$linkbar = '';
		if ($this->linkScript) {
			$linkbar .= $this->page - $this->PageStride > 1 ? '<a href="##" onclick="'.$this->_getLinkScript(1).'" title="1">1</a></span>'."\n".'<span class="page">...</span>'."\n" : '';
		}else {
			$linkbar .= $this->page - $this->PageStride > 1 ? '<span class="'.$this->linkStyle['numBarMain'].'"><a href="'.$this->linkhead.'page=1" title="1">1</a></span>'."\n".'<span class="page">...</span>'."\n" : '';
		}
		for ($i = max(1, $this->page - $this->PageStride); $i < $this->page; $i++){
			$linkbar .= $this->_returnLinkCode($i,$i,$this->linkStyle['numBarMain'],$i);
		}
		$linkbar .= $this->_returnLinkCode($i,$i,$this->linkStyle['numBar'],$i);
		for ($i = $this->page+1; $i < min($this->totalPage, $this->page+$this->PageStride)+1; $i++){
			$linkbar .= $this->_returnLinkCode($i,$i,$this->linkStyle['numBarMain'],$i);
		}
		if ($this->linkScript) {
			if($i-1 == $this->totalPage || $i-1 == $this->totalPage-1) {
				$linkbar .= $this->_returnLinkCode($this->totalPage,$this->totalPage,$this->linkStyle['numBarMain'],$this->totalPage);
			}else if($i-1 == $this->totalPage){
				$linkbar .= ($this->totalPage - $this->page > $this->PageStride) ?  '<span class="page">...</span>'."\n".'<a href="##" onclick="'.$this->_getLinkScript($this->totalPage).'" title="'.$this->totalPage.'">'.$this->totalPage.'</a></span>'."\n" : '';
			}else {
				$linkbar .= '';
			}
			//$linkbar .= ($this->totalPage - $this->page > $this->PageStride) ?  '<span class="page">...</span>'."\n".'<a href="##" onclick="'.$this->_getLinkScript($this->totalPage).'" title="'.$this->totalPage.'" class="'.$this->linkStyle['numBarMain'].'">'.$this->totalPage.'</a></span>'."\n" : '';
		}else {
			if($i-1 == $this->totalPage-1) {
				$linkbar .= $this->_returnLinkCode($this->totalPage,$this->totalPage,$this->linkStyle['numBarMain'],$this->totalPage);
			}else if($i-1 == $this->totalPage) {
				$linkbar .= '';
			}else {
				$linkbar .= ($this->totalPage - $this->page > $this->PageStride) ?  '<span class="page">...</span>'."\n".'<span class="'.$this->linkStyle['numBarMain'].'"><a href="'.$this->linkhead.'page='.$this->totalPage.'" title="'.$this->totalPage.'">'.$this->totalPage.'</a></span>'."\n" : '';
			}
			//$linkbar .= ($this->totalPage - $this->page > $this->PageStride) ?  '<span class="page">...</span>'."\n".'<span class="'.$this->linkStyle['numBarMain'].'"><a href="'.$this->linkhead.'page='.$this->totalPage.'" title="'.$this->totalPage.'" class="'.$this->linkStyle['numBarMain'].'">'.$this->totalPage.'</a></span>'."\n" : '';
		}
		return $linkbar;
		
	}

}

?>