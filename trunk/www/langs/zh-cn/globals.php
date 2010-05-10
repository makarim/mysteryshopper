<?php

$GLOBALS['gLang'] = array(
	'title_install' => ' 安装向导',
	'agreement_yes' => '我同意',
	'agreement_no' => '我不同意',
	'notset' => '不限制',

	'message_title' => '提示信息',
	'error_message' => '错误信息',
	'message_return' => '返回',
	'return' => '返回',
	'install_wizard' => '安装向导',
	'config_nonexistence' => '配置文件不存在',
	'nodir' => '目录不存在',
	'short_open_tag_invalid' => '对不起，请将 php.ini 中的 short_open_tag 设置为 On，否则无法继续安装。',
	'writeable' => '可写',
	'unwriteable' => '不可写',
	'old_step' => '上一步',
	'new_step' => '下一步',
	
	'database_errno_2003' => '无法连接数据库，请检查数据库是否启动，数据库服务器地址是否正确',
	'database_errno_1044' => '无法创建新的数据库，请检查数据库名称填写是否正确',
	'database_errno_1045' => '无法连接数据库，请检查数据库用户名或者密码是否正确',
	'database_connect_error' => '数据库连接错误',
	'database_errno_1064' => 'SQL 语法错误',

	'dbpriv_createtable' => '没有CREATE TABLE权限，无法继续安装',
	'dbpriv_insert' => '没有INSERT权限，无法继续安装',
	'dbpriv_select' => '没有SELECT权限，无法继续安装',
	'dbpriv_update' => '没有UPDATE权限，无法继续安装',
	'dbpriv_delete' => '没有DELETE权限，无法继续安装',
	'dbpriv_droptable' => '没有DROP TABLE权限，无法安装',
	'db_not_null' => '数据库中已经安装过 Xppass, 继续安装会清空原有数据。',
	'db_drop_table_confirm' => '继续安装会清空全部原有数据，您确定要继续吗?',


	'step_env_check_title' => '开始安装',
	'step_env_check_desc' => '环境以及文件目录权限检查',
	'step_db_init_title' => '安装数据库',
	'step_db_init_desc' => '正在执行数据库安装',
	
	'step1_file' => '目录文件',
	'step1_need_status' => '所需状态',
	'step1_status' => '当前状态',
	'not_continue' => '请将以上红叉部分修正再试',

	'tips_dbinfo' => '填写数据库信息',
	'tips_dbinfo_comment' => '',
	'tips_admininfo' => '填写管理员信息',
	'step_install_check_title' => '安装成功',
	'step_install_check_desc' => '点击进入登陆',

	'ext_info_succ' => '安装成功',
	'install_locked' => '安装锁定，已经安装过了，如果您确定要重新安装，请到服务器上删除<br />/tmp/install.lock ',
	'error_quit_msg' => '您必须解决以上问题，安装才可以继续',

	'step_set_params_title' => '设置运行环境',
	'step_set_params_desc' => '设置 Xppass',

	'click_to_back' => '点击返回上一步',
	'adminemail' => '系统信箱 Email',
	'adminemail_comment' => '用于发送程序错误报告',
	'dbhost_comment' => '数据库服务器地址, 一般为 localhost',
	'tablepre_comment' => '同一数据库运行多个论坛时，请修改前缀',
	'forceinstall_check_label' => '我要删除数据，强制安装 !!!',

	'sso_mode' => '单点登录解决方案',
	'ssomode_label' => '在线用户数据存储和共享方式',
	'ssomode_invalid' => '选择一种方案，可修改。',
	'multitable' => '是否分表',
	'multitable_label' => '将用户数据分散存储，默认数256个',
	'multitable_invalid' => '',

	'dbinfo_dbhost_invalid' => '数据库服务器为空，或者格式错误，请检查',
	'dbinfo_dbname_invalid' => '数据库名为空，或者格式错误，请检查',
	'dbinfo_dbuser_invalid' => '数据库用户名为空，或者格式错误，请检查',
	'dbinfo_dbpw_invalid' => '数据库密码为空，或者格式错误，请检查',

	'admininfo_invalid' => '管理员信息不完整，请检查管理员账号，密码，邮箱',
	'dbname_invalid' => '数据库名为空，请填写数据库名称',

	'admin_invalid' => '您的信息管理员信息没有填写完整，请仔细填写每个项目',
	'admininfo_founderpw_invalid' => '管理员密码不能为空，并且不能少于6位',
	'admininfo_founderpw2_invalid' => '两次密码不一致，请检查',
	'admininfo_founderemail_invalid' => '创始人邮箱地址格式错误，请检查',

	'install_in_processed' => '正在安装...',
	'install_succeed' => '数据安装成功，下一步',

	'license' => '<div class="license">
	<h1>Xppass 安装许可证</h1>

<h3>感谢您选择 Xppass 单点登录系统。</h3>

<p>Copyright (c) 2009 著作权由吴仲深(kakapowu@gmail.com)所有。著作权人保留一切权利。</p>

<p>这份授权条款，在使用者符合以下三条件的情形下，授予使用者使用及再散播本软件原代码及二进位代码的权利，无论此包装是否经改作皆然：<p>
<ol>
<li> 对于本软件源代码的再散播，必须保留上述的版权宣告、此三条件表列，以及下述的免责声明。</li>
<li> 对于本套件二进位可执行形式的再散播，必须连带以文件以及／或者其他附于散播包装中的媒介方式，重制上述之版权宣告、此三条件表列，以及下述的免责声明。</li>
<li> 未获事前取得书面许可，不得使用柏克莱加州大学或本软件贡献者之名称，来为本软件之衍生物做任何表示支持、认可或推广、促销之行为。</li>
</ol>
<p>
免责声明：本软件是由本软件之贡献者以现状（"as is"）提供，本软件包装不负任何明示或默示之担保责任，包括但不限于就适售性以及特定目的的适用性为默示性担保。本软件之贡献者，无论任何条件、无论成因或任何责任、无论此责任为因合约关系、无过失责任或因非违约之侵权（包括过失或其他原因等）而起，对于任何因使用本软件包装所产生的任何直接性、间接性、偶发性、特殊性、惩罚性或任何结果的损害（包括但不限于替代商品或劳务之购用、使用损失、资料损失、利益损失、业务中断等等），不负任何责任，即在该种使用已获事前告知可能会造成此类损害的情形下亦然。
</p>
</div>',

	'i_agree' => '我已仔细阅读，并同意上述条款中的所有内容',
	'supportted' => '支持',
	'unsupportted' => '不支持',
	'max_size' => '支持/最大尺寸',
	'project' => '项目',
	'XPpass_required' => 'Xppass 所需配置',
	'XPpass_best' => 'Xppass 最佳',
	'curr_server' => '当前服务器',
	'env_check' => '环境检查',
	'os' => '操作系统',
	'php' => 'PHP 版本',
	'attachmentupload' => '附件上传',
	'unlimit' => '不限制',
	'version' => '版本',
	'gdversion' => 'GD 库',
	'allow' => '允许',
	'unix' => '类Unix',
	'diskspace' => '磁盘空间',
	'priv_check' => '目录、文件权限检查',
	'func_depend' => '函数对象依赖性检查',
	'func_name' => '函数/扩展名称',
	'check_result' => '检查结果',
	'suggestion' => '建议',
	'advice_pdo' => '请检查 pdo 模块是否正确加载',
	'advice_pdo_mysql' => '请检查 pdo_mysql 模块是否正确加载',
	'advice_fopen' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'advice_file_get_contents' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'advice_file_put_contents' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'advice_fsockopen' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
	'advice_json' => '请检查 json 模块是否正确加载',
	'advice_mbstring' => '请检查 mbstring 模块是否正确加载',
	'advice_memcache' => '请检查 memcache 模块是否正确加载',
	'none' => '无',

	'dbhost' => '数据库服务器',
	'dbuser' => '数据库用户名',
	'dbpw' => '数据库密码',
	'dbname' => '数据库名',

	'founderemail' => '创始人电子邮箱',
	'founderpw' => '创始人密码',
	'founderpw2' => '重复创始人密码',

	'create_table' => '建立数据表',
	'succeed' => '成功',

	'method_undefined' => '未定义方法',
	'database_nonexistence' => '数据库操作对象不存在',
);

$GLOBALS['gLang']['user'] = '帐号';
$GLOBALS['gLang']['pwd'] = '密码';
$GLOBALS['gLang']['validatecode'] = '验证码';
$GLOBALS['gLang']['anotherone'] = '换一张';
$GLOBALS['gLang']['notclear'] = '看不清';
$GLOBALS['gLang']['autologin'] = '记住我';
$GLOBALS['gLang']['logon'] = '登录';
$GLOBALS['gLang']['signup'] = '注册';
$GLOBALS['gLang']['forgetpwd'] = '忘记密码';
$GLOBALS['gLang']['emailorusername'] = '用户邮箱/用户名';
$GLOBALS['gLang']['helpmsg1'] = '请输入您的帐号!';
$GLOBALS['gLang']['helpmsg2'] = '请输入您的密码!';
$GLOBALS['gLang']['usernotexist'] = '此用户不存在!';
$GLOBALS['gLang']['codeinvalid'] = "验证码错误!";
$GLOBALS['gLang']['illegalsignon'] = "非法登录!";
$GLOBALS['gLang']['pwdwrong'] = "密码错误!";
$GLOBALS['gLang']['userforbidden'] = "此用户被禁止登录!";
$GLOBALS['gLang']['invalidurl'] = "无效地址!";
$GLOBALS['gLang']['regbyusername'] = "采用用户名注册";
$GLOBALS['gLang']['regbyemail'] = "采用电子邮箱注册";
$GLOBALS['gLang']['email'] = "电子邮箱";
$GLOBALS['gLang']['username'] = "用户名";
$GLOBALS['gLang']['comfirmpwd'] = "确认密码";
$GLOBALS['gLang']['pwdquestion'] = "密码保护问题";
$GLOBALS['gLang']['selectaquestion'] = "请选择一个问题";
$GLOBALS['gLang']['q1'] = "我就读的第一所学校的名称？";
$GLOBALS['gLang']['q2'] = "我最喜欢的休闲运动是什么？";
$GLOBALS['gLang']['q3'] = "我最喜欢的运动员是谁？";
$GLOBALS['gLang']['q4'] = "我最喜欢的物品的名称？";
$GLOBALS['gLang']['q5'] = "我最喜欢的歌曲？";
$GLOBALS['gLang']['q6'] = "我最喜欢的食物？";
$GLOBALS['gLang']['q7'] = "我最爱的人的名字？";
$GLOBALS['gLang']['q8'] = "我最爱的电影？";
$GLOBALS['gLang']['q9'] = "我妈妈的生日？";
$GLOBALS['gLang']['q10'] = "我的初恋日期？";
$GLOBALS['gLang']['youranswer'] = "您的答案";
$GLOBALS['gLang']['realname'] = "姓名";
$GLOBALS['gLang']['nickname'] = "昵称";
$GLOBALS['gLang']['sex'] = "性别";
$GLOBALS['gLang']['boy'] = "男";
$GLOBALS['gLang']['girl'] = "女";
$GLOBALS['gLang']['reset'] = "重置";
$GLOBALS['gLang']['back'] = "返回";
$GLOBALS['gLang']['userexist'] = "此帐号已经存在！请换一个";
$GLOBALS['gLang']['userisok'] = "此帐号可用！";
$GLOBALS['gLang']['insertpwd'] = "输入密码！";
$GLOBALS['gLang']['insertemail'] = "请输入有效邮箱！";
$GLOBALS['gLang']['usernamerule'] = "用户名只能由3-15位字母(a-z)、数字(0-9)或下划线(_)构成,  并且只能以字母开头！";
$GLOBALS['gLang']['pwdnotsame'] = "两个密码不一致！";
$GLOBALS['gLang']['nicknamerule'] = "昵称不能为空，长度在2-16个字";
$GLOBALS['gLang']['sexrule'] = "请选择性别！";
$GLOBALS['gLang']['submit'] = "提交";
$GLOBALS['gLang']['registered'] = "祝贺！您已经成功注册！";
$GLOBALS['gLang']['yourquestion'] = "您的密码保护问题";
$GLOBALS['gLang']['youranswer'] = "请输入您的答案";
$GLOBALS['gLang']['newpwd'] = "输入新密码";
$GLOBALS['gLang']['newpwd2'] = "再次输入密码";
$GLOBALS['gLang']['insertyouranswer'] = "请输入您的答案";
$GLOBALS['gLang']['pwdrule'] = "密码长度要大于6位";
$GLOBALS['gLang']['coderule'] = "请输入验证码";
$GLOBALS['gLang']['realnamerule'] = "请输入真实姓名";

$GLOBALS['gLang']['pwdreset'] = "祝贺！您的密码已经更新成功。";
$GLOBALS['gLang']['failture'] = "失败！请重试。";
$GLOBALS['gLang']['answerwrong'] = "对不起！答案错误。";
$GLOBALS['gLang']['emailsent'] = "邮件已经发送！请查收。";
$GLOBALS['gLang']['emailsendok'] = "祝贺！发送成功。";
$GLOBALS['gLang']['emailsubject'] = "找回密码";
$GLOBALS['gLang']['emailcontent'] = '亲爱的 &lt; %s &gt; ：<br>
				 您申请了找回密码服务! 请点击下面的地址，然后重置您的密码。此地址60分钟后失效。<br>%s<br>%s';

$GLOBALS['gLang']['web-title'] = "欢迎使用&quot;Xppass&quot;单点登录系统";
$GLOBALS['gLang']['menu1'] = '首页';
$GLOBALS['gLang']['menu2'] = '登录';
$GLOBALS['gLang']['menu3'] = '注册新用户';
$GLOBALS['gLang']['menu4'] = '系统管理';
$GLOBALS['gLang']['menu5'] = '帮助';
$GLOBALS['gLang']['menu6'] = '退出';
$GLOBALS['gLang']['selectlanguage'] = '选择语言';
$GLOBALS['gLang']['zh-cn'] = '简体中文';
$GLOBALS['gLang']['zh-tw'] = '繁体中文';
$GLOBALS['gLang']['en'] = '英文';
$GLOBALS['gLang']['nicknameexist'] = '此昵称已存在，请换一个！';

$GLOBALS['gLang']['run_mode'] = '应用运行状态';
$GLOBALS['gLang']['app_status_label'] = '遇到错误出现时，开发状态下输出全部错误信息；生产状态下只提示错误编号，并发送通知邮件。';
$GLOBALS['gLang']['timezone'] = '时区';
$GLOBALS['gLang']['timezone_label'] = '默认为系统时区';
$GLOBALS['gLang']['dev_status'] = '开发状态';
$GLOBALS['gLang']['online_status'] = '生产状态';
$GLOBALS['gLang']['menu_basicset'] = '基本设置';
$GLOBALS['gLang']['menu_regset'] = '注册设置';
$GLOBALS['gLang']['menu_emailset'] = '邮件设置';
$GLOBALS['gLang']['menu_client'] = '客户端管理';
$GLOBALS['gLang']['menu_user'] = '用户管理';

$GLOBALS['gLang']['system_info'] = '系统信息';
$GLOBALS['gLang']['os_php'] = '操作系统及 PHP';
$GLOBALS['gLang']['webserver'] = '服务器软件';
$GLOBALS['gLang']['mysql_version'] = 'MySQL 版本';
$GLOBALS['gLang']['upload_size'] = '上传许可';
$GLOBALS['gLang']['mysql_datasize'] = '当前数据库尺寸';
$GLOBALS['gLang']['hostname'] = '主机名';
$GLOBALS['gLang']['double_nickname'] = '是否禁止昵称重复';
$GLOBALS['gLang']['yes'] = '是';
$GLOBALS['gLang']['no'] = '否';
$GLOBALS['gLang']['ban_email'] = '禁止的 Email 地址';
$GLOBALS['gLang']['ban_email_label'] = '禁止使用这些域名结尾的 Email 地址注册。<br>只需填写 Email 的域名部分，每行一个域名，例如 @hotmail.com';
$GLOBALS['gLang']['ban_username'] = '禁止的用户名';
$GLOBALS['gLang']['ban_username_label'] = '可以设置通配符，每个关键字一行，如 "*admin*"(不含引号)。';
$GLOBALS['gLang']['email_from'] = '邮件来源地址';
$GLOBALS['gLang']['email_from_label'] = '当发送邮件不指定邮件来源时，默认使用此地址作为邮件来源';
$GLOBALS['gLang']['smtp_server'] = 'SMTP 服务器';
$GLOBALS['gLang']['smtp_server_label'] = '设置 SMTP 服务器的地址';
$GLOBALS['gLang']['smtp_port'] = 'SMTP 端口';
$GLOBALS['gLang']['smtp_port_label'] = '设置 SMTP 服务器的端口，默认为 25';
$GLOBALS['gLang']['smtp_account'] = 'SMTP 身份验证用户名';
$GLOBALS['gLang']['smtp_password'] = 'SMTP 身份验证密码';
$GLOBALS['gLang']['search_domain'] = '搜索域名';
$GLOBALS['gLang']['add_domain'] = '添加域名';
$GLOBALS['gLang']['new_domain'] = '新域名';
$GLOBALS['gLang']['domain'] = '域名';
$GLOBALS['gLang']['domain_list'] = '域名列表';
$GLOBALS['gLang']['domain_delete_comfirm'] = '该操作不可恢复，您确认要删除吗？';
$GLOBALS['gLang']['domain_password'] = '密钥';
$GLOBALS['gLang']['delete'] = '删除';
$GLOBALS['gLang']['domainexist'] = '此域名已经存在。';

$GLOBALS['gLang']['first_page'] = '首页';
$GLOBALS['gLang']['last_page'] = '尾页';
$GLOBALS['gLang']['pre_page'] = '上一页';
$GLOBALS['gLang']['next_page'] = '下一页';
$GLOBALS['gLang']['next_group'] = '下一组';
$GLOBALS['gLang']['pre_group'] = '上一组';
$GLOBALS['gLang']['success'] = '操作成功';
$GLOBALS['gLang']['failed'] = '操作失败';
$GLOBALS['gLang']['selectone'] = '请选择一个';
$GLOBALS['gLang']['invaliddomain'] = '无效的域名';

$GLOBALS['gLang']['search_user'] = '搜索用户';
$GLOBALS['gLang']['add_user'] = '添加用户';
$GLOBALS['gLang']['reg_date'] = '注册日期';
$GLOBALS['gLang']['to'] = '到';
$GLOBALS['gLang']['user_list'] = '用户列表';
$GLOBALS['gLang']['user_total'] = '总数';
$GLOBALS['gLang']['more'] = '更多';
$GLOBALS['gLang']['edit'] = '编辑';
$GLOBALS['gLang']['view'] = '查看';
$GLOBALS['gLang']['admin_remind'] = '* administrator 不能被删除';
$GLOBALS['gLang']['lastlogin'] = '最后登录';
$GLOBALS['gLang']['edituser'] = '编辑用户资料';
$GLOBALS['gLang']['pwd_label'] = '密码留空，保持不变。';
$GLOBALS['gLang']['user_label'] = '不能修改';
$GLOBALS['gLang']['backtouserlist'] = '返回用户列表';
$GLOBALS['gLang']['user_center'] = 'SPOT--Mystery Shopper Admin System';
$GLOBALS['gLang']['index_name'] = 'PHP开源 SSO系统--Xppass';
$GLOBALS['gLang']['feature'] = '主要特点';
$GLOBALS['gLang']['feature_1'] = '1、提供三种解决方案Cookie方案、Session方案和Ticket方案，根据需求任选其一。';
$GLOBALS['gLang']['feature_2'] = '2、可采用哈希分表设计，支持亿万级别用户数据量存储。';
$GLOBALS['gLang']['feature_3'] = '3、提供用户名和电子邮箱两种互补注册方式。';
$GLOBALS['gLang']['feature_4'] = '4、实现安全登录技术，采用密码MD5加密传输和hmac身份验证。';
$GLOBALS['gLang']['feature_5'] = '5、提供自动安装程序。';
$GLOBALS['gLang']['feature_6'] = '6、支持多语言版本。';
$GLOBALS['gLang']['cookie_solution'] = '非跨域名Cookie方案';
$GLOBALS['gLang']['session_solution'] = '非跨域名Session方案';
$GLOBALS['gLang']['ticket_solution'] = '跨域名Ticket方案';
$GLOBALS['gLang']['mentality'] = '思路';
$GLOBALS['gLang']['advantage'] = '优点';
$GLOBALS['gLang']['disadvantage'] = '缺点';
$GLOBALS['gLang']['cookie_mentality'] = '<ul><li>采用浏览器客户端的cookie存储在线用户信息数据</li>
<li>用户信息数据加密存储和传输</li>
<li>子域名应用程序共享解密方法和密码</li>
</ul>';
$GLOBALS['gLang']['session_mentality'] = '<ul>
<li>采用服务器端储存在线用户信息数据</li>
<li>子域名共享根域名的session id.</li>
<li>用户数据无需加密。</li>
<li>web集群服务器需通过数据库或者memcached共享用户数据。</li>
</ul>';
$GLOBALS['gLang']['ticket_mentality'] = '<ul>
	<li>用户访问应用服务SP，SP判断用户是否在本地已经登录，未登录则调用 sso client api访问 sso server，需要带上数字签名signature，user_name 和 domain信息。
</li>
<li>sso server 接收到来自client的信息后，先认证client是否合法，即签名校验。然后从本机session判断user_name是否存在，存在则返回session id，即票证ticket；ticket不存在就转跳到登录界面。
</li>
<li>用户在身份认证中心登录成功后，sso server在session中保存用户信息。然后转跳回应用服务SP，URL带上ticket(session id)。
</li>
<li>应用服务通过SSO client 插件,再次带上ticket，domain和signature(此时signature由 ticket加密得到)访问 SSO Server，SSO Server先进行授权判断，然后返回加密的用户token数据。
</li>
<li>用户信息数据是加密传输，SSO client 插件通过private key解密token数据。
</li>
<li>如果用户已经在步骤 3 登录过了，则跳过此步骤。</li>
<ul>';

$GLOBALS['gLang']['cookie_advantage'] = '机制简单，避免了webserver集群造成的会话数据同步问题。有一定的安全性。';
$GLOBALS['gLang']['session_advantage'] = '安全性高。能解决webserver集群的会话数据共享问题。';
$GLOBALS['gLang']['ticket_advantage'] = '实现跨域，安全性高。';
$GLOBALS['gLang']['cookie_disadvantage'] = 'cookie存取的数据量有限。无法跨域。';
$GLOBALS['gLang']['session_disadvantage'] = '无法跨域。稍微复杂，采用数据库有瓶颈问题要解决，采用memcached需要部署memcached服务器。';
$GLOBALS['gLang']['ticket_disadvantage'] = '复杂，需要开发客户端插件。';
$GLOBALS['gLang']['menu_onlineuser'] = '在线用户';
$GLOBALS['gLang']['online_length'] = '过期时间';
$GLOBALS['gLang']['module_ban'] = '此功能只在Ticket方案下使用。';
$GLOBALS['gLang']['goback'] = '返回';
$GLOBALS['gLang']['search_assignment'] = '查找任务';
$GLOBALS['gLang']['hide'] = '关闭';
$GLOBALS['gLang']['search_question'] = '查找问题';
$GLOBALS['gLang']['add_question'] = '添加问题';
$GLOBALS['gLang']['question'] = '问题';
$GLOBALS['gLang']['question_group'] = '问题类别';
$GLOBALS['gLang']['question_type'] = '问题形式';
$GLOBALS['gLang']['question_title'] = '问题';
$GLOBALS['gLang']['yesorno'] = '是非题';
$GLOBALS['gLang']['vote'] = '打分题';
$GLOBALS['gLang']['fillblank'] = '问答题';
$GLOBALS['gLang']['score'] = '时间题';


$GLOBALS['gLang']['corporation_list'] = '企业列表';
$GLOBALS['gLang']['corporation_total'] = '企业总数';
$GLOBALS['gLang']['c_name'] = '帐号';
$GLOBALS['gLang']['c_title'] = '公司名称';
$GLOBALS['gLang']['c_contacter'] = '联系人';
$GLOBALS['gLang']['c_phone'] = '联系电话';
$GLOBALS['gLang']['c_store'] = '分店';
$GLOBALS['gLang']['assignment'] = '任务';
$GLOBALS['gLang']['c_intro'] = '介绍';
$GLOBALS['gLang']['c_logo'] = '标识';
$GLOBALS['gLang']['c_initial'] = '首字母';
$GLOBALS['gLang']['add_corporation'] = '添加企业';
$GLOBALS['gLang']['edit_corporation'] = '修改企业';
$GLOBALS['gLang']['add_store'] = '添加分店';
$GLOBALS['gLang']['cs_name'] = '分店名称';
$GLOBALS['gLang']['cs_abbr'] = '字母缩写';
$GLOBALS['gLang']['cs_address'] = '分店地址';
$GLOBALS['gLang']['cs_corpration'] = '所属企业';
$GLOBALS['gLang']['search_corporation'] = '查找企业';
$GLOBALS['gLang']['c_id'] = 'ID';
$GLOBALS['gLang']['store_list'] = '分店列表';
$GLOBALS['gLang']['store_total'] = '分店总数';
$GLOBALS['gLang']['assignment_list'] = '任务列表';
$GLOBALS['gLang']['assignment_total'] = '任务总数';
$GLOBALS['gLang']['a_title'] = '任务标题';
$GLOBALS['gLang']['a_sdate'] = '开始时间';
$GLOBALS['gLang']['a_edate'] = '结束时间';
$GLOBALS['gLang']['a_demand'] = '任务要求';
$GLOBALS['gLang']['finish'] = '进度';
$GLOBALS['gLang']['assignment_title'] = '任务标题';
$GLOBALS['gLang']['add_assignment'] = '添加任务';
$GLOBALS['gLang']['edit_assignment'] = '修改任务';
$GLOBALS['gLang']['a_titlerule'] = '请输入任务标题';
$GLOBALS['gLang']['report'] = '问卷';
$GLOBALS['gLang']['a_hasphoto'] = '上传图片';
$GLOBALS['gLang']['a_hasaudio'] = '上传音频';
$GLOBALS['gLang']['a_desc'] = '任务说明';
$GLOBALS['gLang']['a_quiz'] = '小测试';
$GLOBALS['gLang']['gender'] = '性别';
$GLOBALS['gLang']['mobile'] = '手机';
$GLOBALS['gLang']['phone'] = '电话';
$GLOBALS['gLang']['selected'] = '选择';
$GLOBALS['gLang']['report_list'] = '问卷列表';
$GLOBALS['gLang']['report_total'] = '问卷总数';
$GLOBALS['gLang']['service'] = '服务';
$GLOBALS['gLang']['product'] = '产品';
$GLOBALS['gLang']['environment'] = '环境';
$GLOBALS['gLang']['summary'] = '综合';
$GLOBALS['gLang']['detail'] = '神秘顾客造访细节';
$GLOBALS['gLang']['re_title'] = '问卷名称';
$GLOBALS['gLang']['add_report'] = '创建问卷';
$GLOBALS['gLang']['edit_report'] = '修改问卷';
$GLOBALS['gLang']['question_list'] = '问题列表';
$GLOBALS['gLang']['question_total'] = '问题总数';
$GLOBALS['gLang']['menu_beststore'] = '最佳餐厅';
$GLOBALS['gLang']['menu_bestshopper'] = '最佳顾客';
$GLOBALS['gLang']['menu_notice'] = '公告管理';
$GLOBALS['gLang']['cs_img'] = '餐厅图片';
$GLOBALS['gLang']['cs_month'] = '月份';
$GLOBALS['gLang']['add_beststore'] = '最佳餐厅';
$GLOBALS['gLang']['menu_comment'] = '推荐评论';
$GLOBALS['gLang']['add_reccomment'] = '添加评论';
$GLOBALS['gLang']['add_reccomment'] = '添加评论';
$GLOBALS['gLang']['month'] = '月份';
$GLOBALS['gLang']['img'] = '图片';
$GLOBALS['gLang']['list'] = '列表';
$GLOBALS['gLang']['add'] = '添加';
$GLOBALS['gLang']['user_name'] = '帐号';
$GLOBALS['gLang']['search_notice'] = '查找公告';
$GLOBALS['gLang']['add_notice'] = '添加公告';
$GLOBALS['gLang']['total'] = '总数';
$GLOBALS['gLang']['comment'] = '评论';
$GLOBALS['gLang']['an_date'] = '时间';
$GLOBALS['gLang']['title'] = '标题';
$GLOBALS['gLang']['content'] = '内容';
$GLOBALS['gLang']['c_otherphone'] = '公司电话';
$GLOBALS['gLang']['c_workemail'] = '公司邮箱';
$GLOBALS['gLang']['c_website'] = '公司网站';
$GLOBALS['gLang']['c_companytype'] = '公司性质';
$GLOBALS['gLang']['c_companycate'] = '公司类别';
$GLOBALS['gLang']['c_foodcate'] = '美食分类';
$GLOBALS['gLang']['c_companysize'] = '公司规模';
$GLOBALS['gLang']['c_avgbill'] = '人均消费';
$GLOBALS['gLang']['c_companyaddress'] = '公司地址';
$GLOBALS['gLang']['c_industry'] = '所属行业';
$GLOBALS['gLang']['c_department'] = '联系部门';
$GLOBALS['gLang']['city_district'] = '城市/区';
$GLOBALS['gLang']['catering'] = '餐饮业';
$GLOBALS['gLang']['restaurant'] = '餐厅';
$GLOBALS['gLang']['retail'] = '零售业';
$GLOBALS['gLang']['foreign'] = '外资企业';
$GLOBALS['gLang']['private'] = '民营企业';
$GLOBALS['gLang']['nation'] = '国家企业';
$GLOBALS['gLang']['partnership'] = '合资企业';
$GLOBALS['gLang']['cafe'] = '咖啡馆';
$GLOBALS['gLang']['club'] = '俱乐部';
$GLOBALS['gLang']['sichuan_food'] = '川菜';
$GLOBALS['gLang']['xiang_food'] = '湘菜';
$GLOBALS['gLang']['guangdong_food'] = '粤菜';
$GLOBALS['gLang']['shanghai_food'] = '本帮菜';
$GLOBALS['gLang']['italian_food'] = '意大利菜';
$GLOBALS['gLang']['japanese_food'] = '日本菜';
$GLOBALS['gLang']['guizhou_food'] = '贵州菜';
$GLOBALS['gLang']['dongbei_food'] = '东北菜';
$GLOBALS['gLang']['taiwan_food'] = '台湾菜';
$GLOBALS['gLang']['xinjiang_food'] = '新疆清真';
$GLOBALS['gLang']['sushi_food'] = '素食';
$GLOBALS['gLang']['korea_food'] = '韩式';
$GLOBALS['gLang']['xi_food'] = '西餐';
$GLOBALS['gLang']['huoguo'] = '火锅';
$GLOBALS['gLang']['bread'] = '面包西点';
$GLOBALS['gLang']['selfhelp_food'] = '自助餐';
$GLOBALS['gLang']['invitation_code_label'] = '请输入邀请码';
$GLOBALS['gLang']['invitationcodeinvalid'] = '对不起,邀请码无效！';
$GLOBALS['gLang']['checkit_label'] = '请阅读协议条款，只有同意才能注册！';
$GLOBALS['gLang']['index_flash'] = 'spotshoppers';
$GLOBALS['gLang']['index_flash_file'] = 'spotshoppers.swf';
$GLOBALS['gLang']['client_flash'] = 'client';
$GLOBALS['gLang']['client_flash_file'] = 'client.swf';
$GLOBALS['gLang']['clients'] = '企业专区';
$GLOBALS['gLang']['about_spot'] = 'SPOT的理念';
$GLOBALS['gLang']['client_login'] = '企业登录';
$GLOBALS['gLang']['shoppers'] = '神秘顾客专区';
$GLOBALS['gLang']['user_name'] = '邮箱帐号';
$GLOBALS['gLang']['password'] = '登录密码';
$GLOBALS['gLang']['login'] = '登录';
$GLOBALS['gLang']['lostpassword'] = '忘记密码？';
$GLOBALS['gLang']['signup'] = '加入我们';
$GLOBALS['gLang']['contactus'] = '联系我们';

$GLOBALS['gLang']['mystery_shopper'] = '什么是神秘顾客';
$GLOBALS['gLang']['mystery_shopper_info'] = '企业在没有管理者在场的时候总是很难弄明白自己的员工在做些什么。派一个部门管理人员也并不能每次都奏效，因为员工知道有人在看着。最好的信息来自于被派出作评估的匿名消费者，因为没有人知道他们是谁。这就是为什么他们被称为神秘购物者！';

$GLOBALS['gLang']['what_do_i_do'] = '神秘顾客做什么';
$GLOBALS['gLang']['what_do_i_do_info'] = '一个神秘购物者是对一个品牌消费体验的审核者和评论者。不但要对品牌公司的要求和培训执行情况进行审核, 也以消费者的观点客观地提出评估。合格的神秘购物者必须是一个品牌的真实消费者或者潜在的消费者。';

$GLOBALS['gLang']['what_can_i_get'] = '神秘顾客得到什么';
$GLOBALS['gLang']['what_can_i_get_info'] = '简单地说，神秘购物者因为作为一个消费者获得报酬。每个购物者获得多少报酬取决于任务本身的難度。购物者在完成每项任务后按规定的数额进行报销。
作为一个神秘用餐者，你和你的朋友可以免费吃一顿！餐馆可不想让你一个人吃，只要你和你的神秘餐友不要超过预算；你的这顿饭就是免费的！但是，别忘了要收据，因为我们的客户需要证据证明你曾经到过那里。';

$GLOBALS['gLang']['how_do_i_become_one'] = '怎样成为神秘顾客';
$GLOBALS['gLang']['how_do_i_become_one_info'] = '点击“加入我们”按钮进入后，请填写你的个人信息资料并提交申请，在得到我们任务管理部门的通知后，你就可以选一个适合你的任务开始申请。
申请时，你将收到一份任务说明及问卷调查表，在任务之前我们会对你进行一次测试。这份简短的测试是为了确保你知道你将为评估做些什么，在你开始做这份测试题之前请确认你已经通读了那份任务说明及问卷调查表。一旦获得资格，你应在规定的时限内完成任务并且填写好报告。我们将察看你的报告并且安排接送你的收据。报销款将在我们批准你的报告后存入你的帐户。';

$GLOBALS['gLang']['telephone'] = 'tel';
$GLOBALS['gLang']['telephone2'] = 'tel2';
$GLOBALS['gLang']['homepage'] = '我的主页';
$GLOBALS['gLang']['quit'] = '退出';
$GLOBALS['gLang']['hello'] = '您好';
$GLOBALS['gLang']['what_is_mystery_shopping'] = '什么是神秘购物？';
$GLOBALS['gLang']['what_is_mystery_shopping_answer'] = "  <p><br />
      神秘购物是通过匿名购物者的方式对一个品牌包括客户服务、业务、员工诚信、销售、产品质量等方面的核心标准进行评估的方法。每当出现与这些标准相背离的情况时，就表明有不一致的情况发生。通过神秘购物者审核这些标准的执行情况可以得到最真实的资料作为企业管理者的重要参考。 </p>
      <p>&nbsp;</p>
      <p>任何想监控其业务活动、设施、产品递送和服务性能成效的企业都需要神秘购物服务。一个发展中的品牌在进行扩张之前都需要了解其品牌当前所处的地位。同样，一个已经获得成功的品牌更需要在所有场所中保持或提高其产品标准，以加强在市场上的品牌地位。因为监控，保持和提高标准是企业发展一个长期品牌的战略关键。</p>";
$GLOBALS['gLang']['more'] = '更多...';
$GLOBALS['gLang']['faq'] = '常见问题';
$GLOBALS['gLang']['shoppermain'] = '神秘顾客首页';
$GLOBALS['gLang']['protocol'] = '协议条款';

$GLOBALS['gLang']['who_needs_mystery_shopping'] = '谁需要神秘购物服务？';
$GLOBALS['gLang']['who_needs_mystery_shopping_answer'] = '任何想监控其业务活动、设施、产品递送和服务性能成效的企业都需要神秘购物服务。一个发展中的品牌在进行扩张之前都需要了解其品牌当前所处的地位。同样，一个已经获得成功的品牌更需要在所有场所中保持或提高其产品标准，以加强在市场上的品牌地位。因为监控，保持和提高标准是企业发展一个长期品牌的战略关键。';

$GLOBALS['gLang']['why_do_i_need_mystery_shopping'] = '为什么我需要神秘购物服务？';
$GLOBALS['gLang']['why_do_i_need_mystery_shopping_answer'] = '<br />
      提高消费者保持力<br />	
      监测服务表现<br /> 
      监测设备状况<br />	
      保证服务和产品交付质量<br /> 
      支持奖励性计划<br />	
      审核价格和销售的配合关系<br /> 
      确定培训需求<br />	
      加强员工的诚实性 
';

$GLOBALS['gLang']['why_is_consistency_important'] = '一致性的重要性要哪里？';
$GLOBALS['gLang']['why_is_consistency_important_answer'] = '任何企业想要发展，一致性是一个关键。在一个企业发展之前，它必须树立一套（服务/产品）标准。这些标准是一个品牌的基本要素，只要企业本身不变，就算地理位置、（经营方式得到）改变，这些标准仍可以成为企业的任何组成部份，并逐渐形成“无隐”的企业文化。当消费者看到你的企业品牌，一个质量标准就会浮现在脑海。如果消费者体验到某个品牌的不一致性，那么对于消费者来说该品牌的质量标准将会失去，即等于造成了负面的品牌形象。对于一个消费者来说，一致性等于信任，他们相信会得到同等品质的服务/产品；对于一个企业来说，提供一致性的服务/产品，就等于得到了无数忠实的顾客。';

$GLOBALS['gLang']['how_to_use'] = '我如何使用神秘购物服务？';
$GLOBALS['gLang']['how_to_use_answer'] = ' 为了获得良好的神秘购物资料，您必须拥有足够数量的有关什么事情是可以改变的好问题。许多企业没有认真地考虑这一点，结果他们花了很多时间和金钱后，却得到一些无用的信息。 </p>
    <p>&nbsp;</p>
    <p>在使用该资料之前，您必须先充分利用该计划。向员工通报该计划，告诉他们对他们的要求是什么。如果可能的话，让他们参与到评价表中来。关键是让大家了解和接受该计划。如果他们不接受，员工会对结果产生怀疑，并对他们认为可能是神秘顾客的人产生歧视。其目的是把每一位客户都当作神秘顾客来对待。这将在开始该计划之前就大大提高服务表现。 </p>
    <p>&nbsp;</p>
    <p>在得到结果之后，与员工共享信息，同时和他们讨论改进的方法。始终以积极的方式使用报告，比如制定对出色报告的奖励计划。如果以消极的方式使用结果，将会导致对抗的态度，它们是非建设性的，而且会阻止更好的行为出现。神秘购物者是你的消费者，你应该对他们的意见表示感谢，而不是抵触。在服务行业，我们不问“为什么？”我们问“我们怎样才能帮助您？”';

$GLOBALS['gLang']['registration'] = '神秘顾客注册';
$GLOBALS['gLang']['already_signup'] = '已经是注册用户？';
$GLOBALS['gLang']['notyet_signup'] = '还不是注册用户？';
$GLOBALS['gLang']['invitation_code'] = '邀请码';
$GLOBALS['gLang']['regstepclass'] = 'regStep';
$GLOBALS['gLang']['congratulation'] = '恭喜，您已注册成功！';
$GLOBALS['gLang']['redireting'] = '5秒钟后将自动跳转到用户控制面板，如果浏览器没有反应，请点击这里进入...';
$GLOBALS['gLang']['submit'] = '提交';

$GLOBALS['gLang']['map'] = 'map_cn';
$GLOBALS['gLang']['shopper_login'] = '神秘顾客登录';
$GLOBALS['gLang']['client_login'] = '企业登录';

$GLOBALS['gLang']['user_panel'] = '用户控制面板';
$GLOBALS['gLang']['main'] = '首页';
$GLOBALS['gLang']['inbox'] = '收件箱';
$GLOBALS['gLang']['past_assignment'] = '历史任务';
$GLOBALS['gLang']['assignment_board'] = '全部任务';
$GLOBALS['gLang']['my_profile'] = '我的资料';
$GLOBALS['gLang']['top_spot_of_month'] = '上月最受好评';
$GLOBALS['gLang']['top_shopper_of_month'] = '上月最佳神秘顾客';
$GLOBALS['gLang']['my_assignments'] = '我的任务';
$GLOBALS['gLang']['start_date'] = '开始时间';
$GLOBALS['gLang']['end_date'] = '结束时间';
$GLOBALS['gLang']['status'] = '完成进度';
$GLOBALS['gLang']['comment_highlight'] = '推荐评论';
$GLOBALS['gLang']['recent_assignments'] = '最近任务';
$GLOBALS['gLang']['my_calendar'] = '我的日历';
$GLOBALS['gLang']['client'] = '商户';
$GLOBALS['gLang']['create'] = '新建';
$GLOBALS['gLang']['selectall'] = '全选';
$GLOBALS['gLang']['delete'] = '删除';
$GLOBALS['gLang']['read'] = '阅读';
$GLOBALS['gLang']['send'] = '发送';
$GLOBALS['gLang']['reply'] = '回复';
$GLOBALS['gLang']['iam'] = '我';
$GLOBALS['gLang']['announcement'] = '公告';
$GLOBALS['gLang']['publish_date'] = '发布时间';
$GLOBALS['gLang']['finished_date'] = '完成时间';
$GLOBALS['gLang']['brands'] = '品牌';
$GLOBALS['gLang']['stores'] = '分店';
$GLOBALS['gLang']['assignment'] = '任务';
$GLOBALS['gLang']['income'] = '报酬';
$GLOBALS['gLang']['income_unit'] = '单位:元';
$GLOBALS['gLang']['contact'] = '联系方式';
$GLOBALS['gLang']['profiles'] = '个人信息';
$GLOBALS['gLang']['diningcustoms'] = '平常就餐习惯';
$GLOBALS['gLang']['payments'] = '付款方式';
$GLOBALS['gLang']['payments'] = '付款方式';
$GLOBALS['gLang']['uploadface'] = '头像上传';
$GLOBALS['gLang']['save'] = '保存';
$GLOBALS['gLang']['real_name'] = '真名';
$GLOBALS['gLang']['living_city'] = '居住城市';
$GLOBALS['gLang']['address_detail'] = '详细地址';
?>