<?php
	if(file_exists(dirname(__FILE__).'/install.ini.php')) include_once('install.ini.php'); else header("location: install/index.php");
//////////////////////////////////////////////////////
//					Application	Settings			//
//////////////////////////////////////////////////////
	define("APP_STATUS", "dev");
	define("APP_LANG", "zh-cn");
	define("KFL_DIR", APP_DIR."/KFL");
	define("APP_TEMP_DIR", APP_DIR."/tmp/");


//////////////////////////////////////////////////////
//				Website Settings	                //
//////////////////////////////////////////////////////

	$GLOBALS ["gSiteInfo"] ["web_charset"] =  "UTF-8";
	$GLOBALS ["gSiteInfo"] ["web_keyword"] =  "Xppass";
	$GLOBALS ["gSiteInfo"] ["web_description"] =  "PHP开源 SSO系统--Xppass";
	$GLOBALS ["gSiteInfo"] ["web_title"] =  "美国斯巴特市场咨询有限公司";

//////////////////////////////////////////////////////
//				Email   Settings	                //
//////////////////////////////////////////////////////

	$GLOBALS ["gEmail"] ["smtp_host"] =  "smtp.163.com";
	$GLOBALS ["gEmail"] ["smtp_port"] =  "25";
	$GLOBALS ["gEmail"] ["smtp_account"] =  "wanting_e@163.com";
	$GLOBALS ["gEmail"] ["smtp_pass"] =  "516518";
	$GLOBALS ["gEmail"] ["smtp_from"] =  "wanting_e@163.com";
	$GLOBALS ["gEmail"] ["pop3_host"] =  "pop3.163.com";

//////////////////////////////////////////////////////
//				TimeZone   Settings	                //
//////////////////////////////////////////////////////

	date_default_timezone_set("Asia/Shanghai");


//////////////////////////////////////////////////////
//				Memcached  Settings	                //
//////////////////////////////////////////////////////

	$GLOBALS ["gMemcacheServer"] ["192.168.1.5:11212"] = array (
  'mmhost' => '192.168.1.5',
  'mmport' => '11212',
);
	$GLOBALS ["gMemcacheServer"] ["192.168.1.5:11211"] = array (
  'mmhost' => '192.168.1.5',
  'mmport' => '11211',
);
	$GLOBALS ["gMemcacheServer"] ["192.168.1.5:11213"] = array (
  'mmhost' => '192.168.1.5',
  'mmport' => '11213',
);

//////////////////////////////////////////////////////
//				Packet   Settings	                //
//////////////////////////////////////////////////////

	$GLOBALS ["gPacket"] ["cacheOpen"] =  1;
	$GLOBALS ["gPacket"] ["cacheStore"] =  "file";
	$GLOBALS ["gPacket"] ["cacheTime"] =  3600;
	$GLOBALS ["gPacket"] ["cacheDir"] =  APP_TEMP_DIR;
	$GLOBALS ["gPacket"] ["cacheServer"] =  array($GLOBALS ["gMemcacheServer"]["192.168.1.5:11213"]);

//////////////////////////////////////////////////////
//				PageCache  Settings	                //
//////////////////////////////////////////////////////

	$GLOBALS ["gPageCache"] ["index"] ["rulename"]=  "index";
	$GLOBALS ["gPa、geCache"] ["index"] ["cachestore"]=  "file";
	$GLOBALS ["gPageCache"] ["index"] ["cacheserver"]=  array($GLOBALS ["gMemcacheServer"]["192.168.1.5:11211"]);;
	$GLOBALS ["gPageCache"] ["index"] ["cachedir"]=  APP_TEMP_DIR;
	$GLOBALS ["gPageCache"] ["index"] ["cachetime"]=  60;
	$GLOBALS ["gPageCache"] ["index"] ["compressed"]=  1;
	$GLOBALS ["gPageCache"] ["index"] ["action"]=  "";
	$GLOBALS ["gPageCache"] ["index"] ["view"]=  "";

//////////////////////////////////////////////////////
//				Session   Settings	                //
//////////////////////////////////////////////////////

	$GLOBALS ["gSession"] ["sessionHandle"] =  "file";
	$GLOBALS ["gSession"] ["lifeTime"] =  3600;//网站的生存时间
	$GLOBALS ["gSession"] ["database"] =  $GLOBALS ["gDataBase"]["db_setting.db3"];
	$GLOBALS ["gSession"] ["memcached"] =  array($GLOBALS ["gMemcacheServer"]["192.168.1.5:11212"],
$GLOBALS ["gMemcacheServer"]["192.168.1.5:11213"]);;

//////////////////////////////////////////////////////
//				Log   Settings	                //
//////////////////////////////////////////////////////

	$GLOBALS ["gLog"] ["sendemail"] =  "1";
	$GLOBALS ["gLog"] ["subject"] =  "应用错误报告";
	$GLOBALS ["gLog"] ["receiver"] =  "kakapowu@gmail.com";
	$GLOBALS ["gLog"] ["maxExecTime"] =  "2";
	$GLOBALS ["gLog"] ["maxMemUsed"] =  "1048576";

	//$GLOBALS['gGroups'][0] = "Overview";
	$GLOBALS['gGroups'][5] = "Detail";
	$GLOBALS['gGroups'][2] = "Environment";
	$GLOBALS['gGroups'][1] = "Service";
	$GLOBALS['gGroups'][3] = "Product";
	$GLOBALS['gGroups'][4] = "Summary";

	$GLOBALS['gGroupsCap']['Service']	 = "C";
	$GLOBALS['gGroupsCap']['Environment'] = "B";
	$GLOBALS['gGroupsCap']['Product']	 = "D";
	$GLOBALS['gGroupsCap']['Summary']	 = "E";
	$GLOBALS['gGroupsCap']['Detail']	 = "A";

	$GLOBALS['gTypes']['yesorno']  =1;
	$GLOBALS['gTypes']['vote']  =2;
	$GLOBALS['gTypes']['fillblank']  =3;
	$GLOBALS['gTypes']['time']  =4;

	$GLOBALS['gIndustry'][1] = 'catering';
	$GLOBALS['gIndustry'][2] = 'retail';

	$GLOBALS['gCompanytype'][1] = 'foreign';
	$GLOBALS['gCompanytype'][2] = 'private';
	$GLOBALS['gCompanytype'][3] = 'nation';
	$GLOBALS['gCompanytype'][4] = 'partnership';

	$GLOBALS['gCompanycate'][1] = 'cafe';
	$GLOBALS['gCompanycate'][2] = 'club';
	$GLOBALS['gCompanycate'][3] = 'restaurant';

	$GLOBALS['gFoodcate'][1] = 'sichuan_food';
	$GLOBALS['gFoodcate'][2] = 'shanghai_food';
	$GLOBALS['gFoodcate'][3] = 'guangdong_food';
	$GLOBALS['gFoodcate'][4] = 'xiang_food';
	$GLOBALS['gFoodcate'][5] = 'guizhou_food';
	$GLOBALS['gFoodcate'][6] = 'dongbei_food';
	$GLOBALS['gFoodcate'][7] = 'taiwan_food';
	$GLOBALS['gFoodcate'][8] = 'xinjiang_food';
	$GLOBALS['gFoodcate'][9] = 'sushi_food';
	$GLOBALS['gFoodcate'][10] = 'italian_food';
	$GLOBALS['gFoodcate'][11] = 'japanese_food';
	$GLOBALS['gFoodcate'][12] = 'korea_food';
	$GLOBALS['gFoodcate'][13] = 'xi_food';
	$GLOBALS['gFoodcate'][14] = 'huoguo';
	$GLOBALS['gFoodcate'][15] = 'bread';
	$GLOBALS['gFoodcate'][16] = 'selfhelp_food';

	$GLOBALS['gCompanysize'][1] = '< 10';
	$GLOBALS['gCompanysize'][2] = '10-20';
	$GLOBALS['gCompanysize'][3] = '20-50';
	$GLOBALS['gCompanysize'][4] = '50-100';
	$GLOBALS['gCompanysize'][5] = '100-150';
	$GLOBALS['gCompanysize'][6] = '150-500';
	$GLOBALS['gCompanysize'][7] = '>500';

?>