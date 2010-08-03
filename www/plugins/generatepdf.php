<?php
date_default_timezone_set("Asia/Shanghai");
function multiwordbreak($str,$maxlen = 33){
	$len = mb_strlen($str, 'UTF-8');
	$ch = '';
	if($len<=$maxlen) return $str;
	for ($i=0; $i < $len; $i++){
		if($i%$maxlen==0){
			  $ch .= mb_substr($str, $i, $maxlen, 'UTF-8')."<br />";
		}
    }
    return $ch;
}
function break_word($matches){
	
	return $matches[1].multiwordbreak($matches[3],$matches[2]);
}
require('html2fpdf.php');
$pdf=new HTML2FPDF("P",'mm');
//$pdf->Open();
//$pdf->SetCompression(false);
//$pdf->SetDisplayMode("fullwidth");
//$pdf->UseCSS();
//$pdf->SetFontSize(9);
$strContent = '';
if($_POST){
	$c = preg_replace_callback('/(.*?)<span\s*id="br_(\d+)">(.*?)<\/span>(.*?)/ism',"break_word",$_POST['c']);

	
	if(strpos($c,'border="0"')!==false) $c = str_replace('border="0"','border="1"',$c);
	
	
	$strContent = stripslashes($c);
}

//$strContent = str_replace("“",'"',$strContent);
//$strContent = str_replace("”",'"',$strContent);
$pdf->SetMargins( 20, 10,-1);
$pdf->AddGBFont();
//$pdf->Header("调查问卷");
$pdf->AddPage();

//$pdf->SetAuthor("Kakapo");
//$pdf->Bookmark( "Bookmark" );
//$pdf->SetTitle("调查问卷");
//$pdf->SetCreator( "WWW.SPOTSHOPPERS.COM" );


//$pdf->DisplayPreferences('HideWindowUI');
$file_name = uniqid().".pdf";
$pdf->WriteHTML($strContent);
$pdf->Output("../tmp/".$file_name);
echo $file_name;
?>