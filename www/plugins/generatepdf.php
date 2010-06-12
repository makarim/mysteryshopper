<?php
date_default_timezone_set("Asia/Shanghai");

require('html2fpdf.php');
$pdf=new HTML2FPDF("P",'mm');
//$pdf->Open();
//$pdf->SetCompression(false);
//$pdf->SetDisplayMode("fullwidth");
//$pdf->UseCSS();
//$pdf->SetFontSize(9);
if($_POST){
	$strContent = stripslashes($_POST['c']);
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