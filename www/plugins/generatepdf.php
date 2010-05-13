<?

require('html2fpdf.php');
$pdf=new HTML2FPDF("P",'mm');
//$pdf->Open();
//$pdf->SetCompression(false);
//$pdf->SetDisplayMode("fullwidth");
//$pdf->UseCSS();
//$pdf->SetFontSize(9);
if($_POST){
	$strContent =  '<style>.missionReport {background-color:#999;}
	.missionReport td{background-color:#FFF;}
	.missionReport .title{background-color:#9F0000;color:#FFF;text-align:center;}
	</style>'.stripslashes($_POST['c']);
}
//$strContent = str_replace("“",'"',$strContent);
//$strContent = str_replace("”",'"',$strContent);
$pdf->SetMargins( 20, 5,-1);
$pdf->AddGBFont();
//$pdf->Header("调查问卷");
$pdf->AddPage();

//$pdf->SetAuthor("Kakapo");
//$pdf->Bookmark( "Bookmark" );
//$pdf->SetTitle("调查问卷");
//$pdf->SetCreator( "WWW.SPOTSHOPPERS.COM" );


//$pdf->DisplayPreferences('HideWindowUI');
$pdf->WriteHTML($strContent);
$pdf->Output("../tmp/sample.pdf");
echo "PDF file is generated successfully!";
?>