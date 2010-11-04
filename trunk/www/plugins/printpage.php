<?php session_start();?>
<html>
<head>
<title>打印页面</title>
<style type="text/css" rel="stylesheet">
*{
	padding:0;
	margin:0;
	background:none;
}
body {
	padding:0;
	margin:0;
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif, 宋体;
}
#admincontent {
	//width:100%;
	//margin-left:2%;
	//margin-right:2%;
	//padding:10px;
	margin-top:5px;
}
.missionReport {
	border:0;
	background-color:#999;
}
.missionReport td{
border:0;
	background-color:#FFF;
	padding:8px;
}
.missionReport .title{
	background-color:#9F0000;
	color:#FFF;
	text-align:center;
}
</style>
</head>

<body>
<div id="admincontent">
<?php
if(isset($_SESSION['html'])){
	echo $_SESSION['html'];
}else echo "没有可打印的数据！";

?>

</div>
</body>

<script type="text/javascript">
//网页加载完后，弹出打印网页的对话框
//window.print();
</script>
</html>