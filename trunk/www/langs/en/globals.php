<?php

$GLOBALS['gLang'] = array(
	'title_install' => 'Installation Guide',
	'agreement_yes' => 'Agree',
	'agreement_no' => 'Not Agree',
	'notset' => 'Not limited',

	'message_title' => 'remind message',
	'error_message' => 'Error message',
	'message_return' => 'Back',
	'return' => 'Back',
	'install_wizard' => 'Installation Guide',
	'config_nonexistence' => 'The config file not exists!',
	'nodir' => 'The directory not exists!',
	'short_open_tag_invalid' => 'Sorry! Please set short_open_tag to On in php.ini file.',
	'writeable' => 'writeable',
	'unwriteable' => 'not writeable',
	'old_step' => 'Previout Step',
	'new_step' => 'Next Step',
	
	'database_errno_2003' => 'Error in connecting database. Please check the server address.',
	'database_errno_1044' => 'Error in connecting database. Please check the database name.',
	'database_errno_1045' => 'Error in connecting database. Please check the username and password.',
	'database_connect_error' => 'database connecting errors.',
	'database_errno_1064' => 'SQL spell errors',

	'dbpriv_createtable' => 'No CREATE TABLE privilege..',
	'dbpriv_insert' => 'No INSERT privilege.',
	'dbpriv_select' => 'No  SELECT privilege',
	'dbpriv_update' => 'No UPDATE privilege',
	'dbpriv_delete' => 'No DELETE privilege',
	'dbpriv_droptable' => 'No DROP TABLE privilege',
	'db_not_null' => 'The database exists. Please empty the database.',
	'db_drop_table_confirm' => 'The database will be empty, do you comfirm?',


	'step_env_check_title' => 'Start Checking',
	'step_env_check_desc' => 'Checking directory, file privilege',
	'step_db_init_title' => 'Database Installation',
	'step_db_init_desc' => 'Installing Database',
	
	'step1_file' => 'Directory',
	'step1_need_status' => 'Need Status',
	'step1_status' => 'Current Status',
	'not_continue' => 'Please recorrect all above in red color.',

	'tips_dbinfo' => 'Please insert database information.',
	'tips_dbinfo_comment' => '',
	'tips_admininfo' => 'Please insert administrator information',
	'step_install_check_title' => 'Installed successfully!',
	'step_install_check_desc' => 'Go to Login',

	'ext_info_succ' => 'Installed successfully!',
	'install_locked' => 'It is locked. You had installed Xppass. If you need to reinstall, please delete the file <br />/tmp/install.lock ',
	'error_quit_msg' => 'Please fix all the problems above and continue!',

	'step_set_params_title' => 'Setting run environment',
	'step_set_params_desc' => 'Setting Xppass',

	'click_to_back' => 'Go Back',
	'adminemail' => 'Administrator Email',
	'adminemail_comment' => 'use to send error message report',
	'dbhost_comment' => 'server address, defaults localhost',

	'sso_mode' => 'Single Sign-On Solution',
	'ssomode_label' => 'Online user data storage and share mode',
	'ssomode_invalid' => 'Please select one solution, you can change it after installation',
	'multitable' => 'multi-table for user table?',
	'multitable_label' => 'Hash store user data, defaults table number is 256',
	'multitable_invalid' => '',

	'dbinfo_dbhost_invalid' => 'The database server is empty or wrong formated',
	'dbinfo_dbname_invalid' => 'The database name is empty.',
	'dbinfo_dbuser_invalid' => 'The database username is empty.',
	'dbinfo_dbpw_invalid' => 'he database password is empty',

	'admininfo_invalid' => 'The administrator information is not complete.',
	'dbname_invalid' => 'The database name is empty.',

	'admin_invalid' => 'Your information is not complete.',
	'admininfo_founderpw_invalid' => 'The password can be null, and should be more than 6 charactor',
	'admininfo_founderpw2_invalid' => 'Two password are not the same',
	'admininfo_founderemail_invalid' => 'The email address is wrong!',

	'install_in_processed' => 'Installing...',
	'install_succeed' => 'Database installing finished，Next',

	'license' => '<div class="license">
	<h1>Xppass Installation Permission (The BSD License)</h1>
 <p>Copyright (c) 2009, Zhongshen Wu (kakapowu@gmail.com)
 All rights reserved.</p>
 <p>Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:</p>
<ol>
      <li>Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.</li>
     <li> Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.</li>
     <li> Neither the name of the <ORGANIZATION> nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.</li>
</ol>
  <p>THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.</p>
</div>',

	'i_agree' => 'I have read and agree with all above.',
	'supportted' => 'Supported',
	'unsupportted' => 'Not Supported',
	'max_size' => 'Max Sizes',
	'project' => 'Project',
	'XPpass_required' => 'Xppass basic settings',
	'XPpass_best' => 'Xppass best settings',
	'curr_server' => 'Current server',
	'env_check' => 'Checking environment',
	'os' => 'Operating System',
	'php' => 'PHP Version',
	'attachmentupload' => 'Upload attachments',
	'unlimit' => 'Not Limited',
	'version' => 'Version',
	'gdversion' => 'GD Library',
	'allow' => 'Allowed',
	'unix' => 'Likes Unix',
	'diskspace' => 'Disk Space',
	'priv_check' => 'Checking directory, file privilege',
	'func_depend' => 'Checking function dependency',
	'func_name' => 'Function/ Extended',
	'check_result' => 'Checking Result',
	'suggestion' => 'Suggestion',
	'advice_pdo' => 'Please check if pdo module is loaded?',
	'advice_pdo_mysql' => 'Please check if pdo_mysql is loaded',
	'advice_fopen' => 'The allow_url_fopen should be opened in php.ini file.',
	'advice_file_get_contents' => 'The allow_url_fopen should be opened in php.ini file.',
	'advice_file_put_contents' => 'The allow_url_fopen should be opened in php.ini file.',
	'advice_fsockopen' => 'The allow_url_fopen should be opened in php.ini file.',
	'advice_json' => 'Please check if json module is loaded?',
	'advice_mbstring' => 'Please check if mbstring module is loaded?',
	'advice_memcache' => 'Please check if  memcache module is loaded?',
	'none' => 'Null',

	'dbhost' => 'Database Server',
	'dbuser' => 'Database User',
	'dbpw' => 'Database Password',
	'dbname' => 'Database Name',

	'founderemail' => 'Administrator email',
	'founderpw' => 'Administrator password',
	'founderpw2' => 'Repeated password',

	'create_table' => 'Building Database',
	'succeed' => 'Successfully!',

	'method_undefined' => 'Undefined function',
	'database_nonexistence' => 'The database object not exists.',
);
$GLOBALS['gLang']['user'] = 'Passport';
$GLOBALS['gLang']['pwd'] = 'Password';
$GLOBALS['gLang']['validatecode'] = 'Verification Code';
$GLOBALS['gLang']['anotherone'] = 'Change';
$GLOBALS['gLang']['notclear'] = 'Change';
$GLOBALS['gLang']['autologin'] = 'Remember me';
$GLOBALS['gLang']['logon'] = 'Login';
$GLOBALS['gLang']['signup'] = 'Sign up';
$GLOBALS['gLang']['forgetpwd'] = 'Forget your password?';
$GLOBALS['gLang']['emailorusername'] = 'Email/UserName';
$GLOBALS['gLang']['helpmsg1'] = 'Please enter your Email!';
$GLOBALS['gLang']['helpmsg2'] = 'Please enter your Password!';
$GLOBALS['gLang']['usernotexist'] = 'The user not exist!';
$GLOBALS['gLang']['codeinvalid'] = "The verification code is wrong!";
$GLOBALS['gLang']['illegalsignon'] = "Illegal sign on!";
$GLOBALS['gLang']['pwdwrong'] = "The password is wrong!";
$GLOBALS['gLang']['userforbidden'] = "The user is forbidden!";
$GLOBALS['gLang']['invalidurl'] = "Invalid url!";
$GLOBALS['gLang']['regbyusername'] = "Registered by Username";
$GLOBALS['gLang']['regbyemail'] = "Registered by Email";
$GLOBALS['gLang']['email'] = "Email";
$GLOBALS['gLang']['username'] = "Username";
$GLOBALS['gLang']['comfirmpwd'] = "Confirm Password";
$GLOBALS['gLang']['pwdquestion'] = "Protected question";
$GLOBALS['gLang']['selectaquestion'] = "Please select a question";
$GLOBALS['gLang']['q1'] = "What's name of my first school?";
$GLOBALS['gLang']['q2'] = "What's my favorite leisure sport?";
$GLOBALS['gLang']['q3'] = "Who is my favorite sportsman?";
$GLOBALS['gLang']['q4'] = "What's name of my favorites?";
$GLOBALS['gLang']['q5'] = "What's name of my favorite song?";
$GLOBALS['gLang']['q6'] = "What's name of my favorite food?";
$GLOBALS['gLang']['q7'] = "Who is my dearest lover?";
$GLOBALS['gLang']['q8'] = "What's name of my favorite film?";
$GLOBALS['gLang']['q9'] = "Which day is my mum's birthday?";
$GLOBALS['gLang']['q10'] = "When is my firt date?";
$GLOBALS['gLang']['youranswer'] = "Your answer is";
$GLOBALS['gLang']['realname'] = "Realname";
$GLOBALS['gLang']['nickname'] = "Nickname";
$GLOBALS['gLang']['sex'] = "Gender";
$GLOBALS['gLang']['boy'] = "Male";
$GLOBALS['gLang']['girl'] = "Female";
$GLOBALS['gLang']['reset'] = "Reset";
$GLOBALS['gLang']['back'] = "Back";
$GLOBALS['gLang']['userexist'] = "The username exist! Please change another one";
$GLOBALS['gLang']['userisok'] = "Valid spelling!";
$GLOBALS['gLang']['insertpwd'] = "Please enter a password!";
$GLOBALS['gLang']['insertemail'] = "Please enter a available email!";
$GLOBALS['gLang']['usernamerule'] = "The username consist of 3-15 characters(a-z), numbers(0-9) or (_). Begin with only characters!";
$GLOBALS['gLang']['pwdnotsame'] = "Two passwords are not the same!";
$GLOBALS['gLang']['nicknamerule'] = "The nickname is empty! Its length should be more than 2 characters, less than 16 characters!";
$GLOBALS['gLang']['sexrule'] = "Please choose the sex!";
$GLOBALS['gLang']['submit'] = "Submit";
$GLOBALS['gLang']['registered'] = "Congratulations! You have successfully registered";
$GLOBALS['gLang']['yourquestion'] = "Your Question";
$GLOBALS['gLang']['youranswer'] = "Your Answer";
$GLOBALS['gLang']['newpwd'] = "New Password";
$GLOBALS['gLang']['newpwd2'] = "New Password Again";
$GLOBALS['gLang']['insertyouranswer'] = "Please enter your answer!";
$GLOBALS['gLang']['pwdrule'] = "Password must be at least 6 characters long!";
$GLOBALS['gLang']['coderule'] = "Please enter the verification code";
$GLOBALS['gLang']['realnamerule'] = "Please enter real name";

$GLOBALS['gLang']['pwdreset'] = "Congratulation! Your password has been reset!";
$GLOBALS['gLang']['failture'] = "Failture! Please try again!";
$GLOBALS['gLang']['answerwrong'] = "Sorry! Your answer is wrong!";
$GLOBALS['gLang']['emailsent'] = "Email had been sent! Please check it!";
$GLOBALS['gLang']['emailsendok'] = "Congratulation! It sent!";
$GLOBALS['gLang']['emailsubject'] = "Get Back Password";
$GLOBALS['gLang']['emailcontent'] = ' Dear &lt; %s &gt; ：<br>
				  You had applied for getting back your password! Please click the url and reset your new password! The url will be disabled after 60 minutes.<br>%s<br>%s';

$GLOBALS['gLang']['web-title'] = "Welcome to &quot;Xppass&quot; Single Sign-on System!";
$GLOBALS['gLang']['menu1'] = 'Index';
$GLOBALS['gLang']['menu2'] = 'Sign-on';
$GLOBALS['gLang']['menu3'] = 'Sign-up';
$GLOBALS['gLang']['menu4'] = 'Administrator';
$GLOBALS['gLang']['menu5'] = 'Help';
$GLOBALS['gLang']['menu6'] = 'Sign-out';
$GLOBALS['gLang']['selectlanguage'] = 'Select Language';
$GLOBALS['gLang']['zh-cn'] = 'Chinese (Simplified)';
$GLOBALS['gLang']['zh-tw'] = 'Chinese (Traditional)';
$GLOBALS['gLang']['en'] = 'English';
$GLOBALS['gLang']['nicknameexist'] = 'The nickname exist! Please change another.';

$GLOBALS['gLang']['run_mode'] = 'Application Running Status';
$GLOBALS['gLang']['app_status_label'] = 'If error occurs, all information will be output under development status; Error code number will be output and reporting email will be sent under production status.';
$GLOBALS['gLang']['timezone'] = 'Timezone';
$GLOBALS['gLang']['timezone_label'] = 'Defaults as system timezone';
$GLOBALS['gLang']['dev_status'] = 'Development Status';
$GLOBALS['gLang']['online_status'] = 'Production Status';
$GLOBALS['gLang']['menu_basicset'] = 'Basic Sets';
$GLOBALS['gLang']['menu_regset'] = 'Register Sets';
$GLOBALS['gLang']['menu_emailset'] = 'Email Sets';
$GLOBALS['gLang']['menu_client'] = 'Client Management';
$GLOBALS['gLang']['menu_user'] = 'User Management';

$GLOBALS['gLang']['system_info'] = 'System　Info.';
$GLOBALS['gLang']['os_php'] = 'OS and PHP Version';
$GLOBALS['gLang']['webserver'] = 'Webserver Software';
$GLOBALS['gLang']['mysql_version'] = 'MySQL Version';
$GLOBALS['gLang']['upload_size'] = 'Max Upload Sizes';
$GLOBALS['gLang']['mysql_datasize'] = 'Current Database Sizes';
$GLOBALS['gLang']['hostname'] = 'Host Name';

$GLOBALS['gLang']['double_nickname'] = 'Whether to prohibit duplicate nickname';
$GLOBALS['gLang']['yes'] = 'Yes';
$GLOBALS['gLang']['no'] = 'No';
$GLOBALS['gLang']['ban_email'] = 'Email address prohibited';
$GLOBALS['gLang']['ban_email_label'] = 'These domain names are prohibited. <br> Simply fill out email domain per line, for example, @hotmail.com';
$GLOBALS['gLang']['ban_username'] = 'Username prohibited';
$GLOBALS['gLang']['ban_username_label'] = 'You can set a wildcard(*), each keyword per line such as "*admin*" (without quotation(") marks).';

$GLOBALS['gLang']['email_from'] = 'From Email Address';
$GLOBALS['gLang']['email_from_label'] = 'Default email from';
$GLOBALS['gLang']['smtp_server'] = 'SMTP Server';
$GLOBALS['gLang']['smtp_server_label'] = 'SMTP server address.';
$GLOBALS['gLang']['smtp_port'] = 'SMTP Port';
$GLOBALS['gLang']['smtp_port_label'] = 'Defaults 25';
$GLOBALS['gLang']['smtp_account'] = 'SMTP Authentication Account';
$GLOBALS['gLang']['smtp_password'] = 'SMTP Authentication Password';
$GLOBALS['gLang']['search_domain'] = 'Search';
$GLOBALS['gLang']['add_domain'] = 'Add';
$GLOBALS['gLang']['new_domain'] = 'New Domain';
$GLOBALS['gLang']['domain'] = 'Domain';
$GLOBALS['gLang']['domain_list'] = 'Domain List';
$GLOBALS['gLang']['domain_delete_comfirm'] = 'The action can not be restored. Do you confirm to delete?';
$GLOBALS['gLang']['domain_password'] = 'Private Key';
$GLOBALS['gLang']['delete'] = 'Delete';
$GLOBALS['gLang']['domainexist'] = 'The domain already exists!';

$GLOBALS['gLang']['first_page'] = 'First';
$GLOBALS['gLang']['last_page'] = 'Last';
$GLOBALS['gLang']['next_page'] = 'Next';
$GLOBALS['gLang']['pre_page'] = 'Previous';
$GLOBALS['gLang']['next_group'] = 'Next Group';
$GLOBALS['gLang']['pre_group'] = 'Previous Group';
$GLOBALS['gLang']['success'] = 'Successfully!';
$GLOBALS['gLang']['failed'] = 'Failed!';
$GLOBALS['gLang']['selectone'] = 'Please select one!';
$GLOBALS['gLang']['invaliddomain'] = 'Invalid domain!';

$GLOBALS['gLang']['search_user'] = 'Search User';
$GLOBALS['gLang']['add_user'] = 'Add User';
$GLOBALS['gLang']['reg_date'] = 'Register Date';
$GLOBALS['gLang']['to'] = 'To';
$GLOBALS['gLang']['user_list'] = 'User List';
$GLOBALS['gLang']['user_total'] = 'Total User';
$GLOBALS['gLang']['more'] = 'More';
$GLOBALS['gLang']['edit'] = 'Edit';
$GLOBALS['gLang']['view'] = 'View';
$GLOBALS['gLang']['admin_remind'] = '* administrator can not be deleted.';
$GLOBALS['gLang']['lastlogin'] = 'Last Login';
$GLOBALS['gLang']['edituser'] = 'Edit User';
$GLOBALS['gLang']['pwd_label'] = 'Password not change if it is blank.';
$GLOBALS['gLang']['user_label'] = 'Read Only';
$GLOBALS['gLang']['backtouserlist'] = 'Back to User List';
$GLOBALS['gLang']['user_center'] = 'User Center';
$GLOBALS['gLang']['index_name'] = 'PHP OpenSource SSO software--Xppass';
$GLOBALS['gLang']['feature'] = 'Features';
$GLOBALS['gLang']['feature_1'] = '1. Provide three solutions: Cookie、Session and Ticket, choose one according to requirement.';
$GLOBALS['gLang']['feature_2'] = '2. Use hash multi-table designment in supporting hundreds of millions of user data storage.';
$GLOBALS['gLang']['feature_3'] = '3. Provides two ways to register: user name and email.';
$GLOBALS['gLang']['feature_4'] = '4. To achieve security sign-on technology, using MD5 encrypted password in transmission and hmac authentication.';
$GLOBALS['gLang']['feature_5'] = '5. Automated installation program.';
$GLOBALS['gLang']['feature_6'] = '6. Supports multi-language versions.';
$GLOBALS['gLang']['cookie_solution'] = 'Cookie Solution';
$GLOBALS['gLang']['session_solution'] = 'Session solution';
$GLOBALS['gLang']['ticket_solution'] = 'Ticket solution';
$GLOBALS['gLang']['mentality'] = 'Mentality';
$GLOBALS['gLang']['advantage'] = 'Advantage';
$GLOBALS['gLang']['disadvantage'] = 'Disadvantage';
$GLOBALS['gLang']['cookie_mentality'] = '<ul><li>Online user data stored in the browser cookie.</li>
<li>User data transmission and storage using encryption</li>
<li>Sub-domain sharing decrypt arithmetic and password.</li>
</ul>';
$GLOBALS['gLang']['session_mentality'] = '<ul>
<li>Online users data stored in the server side.</li>
<li>Sub-domain application sharing the session id of root domain.</li>
<li>User data without encryption.</li>
<li>Webserver cluster use the database or memcached to share user data.</li>
</ul>';
$GLOBALS['gLang']['ticket_mentality'] = '<ul>
	<li>When the user visit Application Service (AS), AS determine whether the user has logged locally. If no, AS call SSO client api to access sso server, taking a digital signature, user_name, and domain information.
</li>
<li>When SSO server receives the information from the client, it certified the legality of the signature verification first, 
and then determine whether user_name exists in session. If yes, it return session id (as ticket), or redirecting to login page.
</li>
<li>	
After the user logged in successfully at authentication center, SSO server saved user data in session. Then jump back to application service, URL belt with ticket (session id).
</li>
<li>	
The SSO client, take ticket, domain, and signature (the signature encrypted by the ticket) to visited the SSO Server. SSO Server authorizes first, and then returns the encrypted data named as user token.
</li>
<li>	
User data is encrypted in transmission. SSO client uses the private key to decrypt the token data.
</li>
<li>	
If the user has been logged in step 3, and then skip this step.</li>
<ul>';

$GLOBALS['gLang']['cookie_advantage'] = 'Simple, Safe, to avoid webserver cluster problem, such as sharing user data';
$GLOBALS['gLang']['session_advantage'] = 'Very Safe, be able to resolve webserver cluster problem.';
$GLOBALS['gLang']['ticket_advantage'] = 'Cross-domain,　very Safe.';
$GLOBALS['gLang']['cookie_disadvantage'] = 'Non-cross-domain,the size of cookie data is limited.';
$GLOBALS['gLang']['session_disadvantage'] = 'Non-cross-domain, a little complicated.';
$GLOBALS['gLang']['ticket_disadvantage'] = 'Complicated, need clients';

$GLOBALS['gLang']['menu_onlineuser'] = 'Online Users';
$GLOBALS['gLang']['online_length'] = 'Expiry Time';
$GLOBALS['gLang']['module_ban'] = 'This module is only active under ticket solution.';
$GLOBALS['gLang']['goback'] = 'goback';
$GLOBALS['gLang']['search_assignment'] = 'Search';
$GLOBALS['gLang']['hide'] = 'Close';
$GLOBALS['gLang']['search_question'] = 'Search';
$GLOBALS['gLang']['add_question'] = 'Add';
$GLOBALS['gLang']['question'] = 'Question';
$GLOBALS['gLang']['question_group'] = 'Category';
$GLOBALS['gLang']['question_type'] = 'Type';
$GLOBALS['gLang']['question_title'] = 'Title';
$GLOBALS['gLang']['yesorno'] = 'Yes/No';
$GLOBALS['gLang']['vote'] = 'Point';
$GLOBALS['gLang']['fillblank'] = 'Comment';
$GLOBALS['gLang']['score'] = 'Time';


$GLOBALS['gLang']['corporation_list'] = 'List';
$GLOBALS['gLang']['corporation_total'] = 'Total';
$GLOBALS['gLang']['c_name'] = 'Account';
$GLOBALS['gLang']['c_title'] = 'Title';
$GLOBALS['gLang']['c_contacter'] = 'Contactor';
$GLOBALS['gLang']['c_phone'] = 'Tel.';
$GLOBALS['gLang']['c_store'] = 'Store';
$GLOBALS['gLang']['assignment'] = 'Assignment';
$GLOBALS['gLang']['c_intro'] = 'Introdution';
$GLOBALS['gLang']['c_logo'] = 'Logo';
$GLOBALS['gLang']['c_initial'] = 'Captical';
$GLOBALS['gLang']['add_corporation'] = 'Add Client';
$GLOBALS['gLang']['edit_corporation'] = 'Modify';
$GLOBALS['gLang']['add_store'] = 'Add';
$GLOBALS['gLang']['cs_name'] = 'Store';
$GLOBALS['gLang']['cs_abbr'] = 'Abbr.';
$GLOBALS['gLang']['cs_address'] = 'Address';
$GLOBALS['gLang']['cs_corpration'] = 'Corp.';
$GLOBALS['gLang']['search_corporation'] = 'Search';
$GLOBALS['gLang']['c_id'] = 'ID';
$GLOBALS['gLang']['store_list'] = 'Lists';
$GLOBALS['gLang']['store_total'] = 'Total';
$GLOBALS['gLang']['assignment_list'] = 'Lists';
$GLOBALS['gLang']['assignment_total'] = 'Total';
$GLOBALS['gLang']['a_title'] = 'Title';
$GLOBALS['gLang']['a_sdate'] = 'From';
$GLOBALS['gLang']['a_edate'] = 'To';
$GLOBALS['gLang']['a_demand'] = 'Requirements';
$GLOBALS['gLang']['finish'] = 'Progress';
$GLOBALS['gLang']['assignment_title'] = 'Title';
$GLOBALS['gLang']['add_assignment'] = 'Add';
$GLOBALS['gLang']['edit_assignment'] = 'Modify';
$GLOBALS['gLang']['a_titlerule'] = 'Insert title';
$GLOBALS['gLang']['report'] = 'Report';
$GLOBALS['gLang']['a_hasphoto'] = 'Upload Image';
$GLOBALS['gLang']['a_hasaudio'] = 'Upload Audio';
$GLOBALS['gLang']['a_desc'] = 'Instructions';
$GLOBALS['gLang']['a_quiz'] = 'Quiz';
$GLOBALS['gLang']['gender'] = 'Gender';
$GLOBALS['gLang']['mobile'] = 'Mobile';
$GLOBALS['gLang']['workphone'] = 'Work Tel';
$GLOBALS['gLang']['homephone'] = 'Home Tel';
$GLOBALS['gLang']['selected'] = 'Select';
$GLOBALS['gLang']['report_list'] = 'Lists';
$GLOBALS['gLang']['report_total'] = 'Total';
$GLOBALS['gLang']['service'] = 'Service';
$GLOBALS['gLang']['product'] = 'Product';
$GLOBALS['gLang']['environment'] = 'Environment';
$GLOBALS['gLang']['summary'] = 'Total';
$GLOBALS['gLang']['detail'] = 'Visit Details';
$GLOBALS['gLang']['re_title'] = 'Title';
$GLOBALS['gLang']['add_report'] = 'Create';
$GLOBALS['gLang']['edit_report'] = 'Modify';
$GLOBALS['gLang']['question_list'] = 'Lists';
$GLOBALS['gLang']['question_total'] = 'Total';
$GLOBALS['gLang']['menu_beststore'] = 'Best Store';
$GLOBALS['gLang']['menu_bestshopper'] = 'Best Shopper';
$GLOBALS['gLang']['menu_notice'] = 'Announcement';
$GLOBALS['gLang']['cs_img'] = 'Image';
$GLOBALS['gLang']['cs_month'] = 'Month';
$GLOBALS['gLang']['add_beststore'] = 'Best Store';
$GLOBALS['gLang']['menu_comment'] = 'Highlight Comments';
$GLOBALS['gLang']['add_reccomment'] = 'Add';
$GLOBALS['gLang']['month'] = 'Month';
$GLOBALS['gLang']['img'] = 'Images';
$GLOBALS['gLang']['list'] = 'Lists';
$GLOBALS['gLang']['add'] = 'Add';
$GLOBALS['gLang']['user_name'] = 'Account';
$GLOBALS['gLang']['search_notice'] = 'Search';
$GLOBALS['gLang']['add_notice'] = 'Add';
$GLOBALS['gLang']['total'] = 'Total';
$GLOBALS['gLang']['comment'] = 'Comment';
$GLOBALS['gLang']['an_date'] = 'Date';
$GLOBALS['gLang']['title'] = 'Subject';
$GLOBALS['gLang']['content'] = 'Message';
$GLOBALS['gLang']['c_otherphone'] = 'Work Tel.';
$GLOBALS['gLang']['c_workemail'] = 'Work Email';
$GLOBALS['gLang']['c_website'] = 'Corp. Site';
$GLOBALS['gLang']['c_companytype'] = 'Corp. Type';
$GLOBALS['gLang']['c_companycate'] = 'Corp. Category';
$GLOBALS['gLang']['c_foodcate'] = 'Category';
$GLOBALS['gLang']['c_companysize'] = 'Sizes';
$GLOBALS['gLang']['c_avgbill'] = 'Average Cost';
$GLOBALS['gLang']['c_companyaddress'] = 'Address';
$GLOBALS['gLang']['c_industry'] = 'Industry';
$GLOBALS['gLang']['c_department'] = 'CONTACT DEPARTMENT';
$GLOBALS['gLang']['city_district'] = 'City/District';
$GLOBALS['gLang']['catering'] = 'catering industry';
$GLOBALS['gLang']['restaurant'] = 'dining-hall';
$GLOBALS['gLang']['retail'] = 'retail trade';
$GLOBALS['gLang']['foreign'] = 'overseas-funded enterprises';
$GLOBALS['gLang']['private'] = 'private enterprise';
$GLOBALS['gLang']['nation'] = 'Crown Corporation';
$GLOBALS['gLang']['partnership'] = 'joint venture';
$GLOBALS['gLang']['cafe'] = 'coffee shop';
$GLOBALS['gLang']['club'] = 'club';
$GLOBALS['gLang']['sichuan_food'] = 'Sichuan cuisine';
$GLOBALS['gLang']['xiang_food'] = 'Hunan cuisine';
$GLOBALS['gLang']['guangdong_food'] = 'Cantonese cuisine';
$GLOBALS['gLang']['shanghai_food'] = 'Local style';
$GLOBALS['gLang']['italian_food'] = 'Italian cuisine';
$GLOBALS['gLang']['japanese_food'] = 'Japanese cuisine';
$GLOBALS['gLang']['guizhou_food'] = 'Guizhou food';
$GLOBALS['gLang']['dongbei_food'] = 'Northern Chinese Cuisine';
$GLOBALS['gLang']['taiwan_food'] = 'Taiwanese cuisine';
$GLOBALS['gLang']['xinjiang_food'] = 'Xinjiang Islamic';
$GLOBALS['gLang']['sushi_food'] = 'vegetarian food';
$GLOBALS['gLang']['korea_food'] = 'koreaean-Style';
$GLOBALS['gLang']['xi_food'] = 'Western-style food';
$GLOBALS['gLang']['huoguo'] = 'hot pot';
$GLOBALS['gLang']['bread'] = 'Western Pastry';
$GLOBALS['gLang']['selfhelp_food'] = 'buffet dinner';
$GLOBALS['gLang']['invitation_code'] = 'Invitation Code';
$GLOBALS['gLang']['invitation_code_label'] = 'Please enter the invitation code.';
$GLOBALS['gLang']['invitationcodeinvalid'] = 'Sorry！The invitation code is invalid！';
$GLOBALS['gLang']['checkit_label'] = 'Please read the terms & conditions and agree！';
$GLOBALS['gLang']['index_flash'] = 'spotshoppers_en';
$GLOBALS['gLang']['index_flash_file'] = 'spotshoppers_en.swf';
$GLOBALS['gLang']['client_flash'] = 'client_en';
$GLOBALS['gLang']['client_flash_file'] = 'client_en.swf';
$GLOBALS['gLang']['clients'] = 'Clients';
$GLOBALS['gLang']['about_spot'] = 'About SPOT';
$GLOBALS['gLang']['client_login'] = 'Client Login';
$GLOBALS['gLang']['shoppers'] = 'Shoppers';
$GLOBALS['gLang']['user_name'] = 'Email';
$GLOBALS['gLang']['password'] = 'Password';
$GLOBALS['gLang']['login'] = 'Login';
$GLOBALS['gLang']['lostpassword'] = 'Lost Password?';
$GLOBALS['gLang']['signup'] = 'Sign Up';
$GLOBALS['gLang']['contactus'] = 'Contact Us';

$GLOBALS['gLang']['mystery_shopper'] = 'Mystery Shopper?';
$GLOBALS['gLang']['mystery_shopper_info'] = 'Businesses have always had a hard time figuring out what their employees are doing when management is not there.  Sending a department representative does not always indicate what is really happening since employees know somebody is watching.  The best information comes from real customers who are given the task to evaluate the experience, but nobody knows it’s them.  This is why they are called Mystery Shoppers!';

$GLOBALS['gLang']['what_do_i_do'] = 'What do I have to do?';
$GLOBALS['gLang']['what_do_i_do_info'] = 'A mystery shopper is an auditor and critic of a brand’s consumer experience.  Auditing requires the shopper to assess execution of brand standards and training.  Critiquing involves an evaluation of the consumer experience based on the customer’s point of view.   Qualified shoppers must be a customer or potential customer of the brand.  Assignments as a mystery shopper can occur on the phone, online, or most commonly in-store. ';

$GLOBALS['gLang']['what_can_i_get'] = 'What can I get?';
$GLOBALS['gLang']['what_can_i_get_info'] = 'Simply put, Mystery Shoppers get paid to do be a customer.  How much each shopper gets paid depends on the business itself.  Shoppers are reimbursed up to an allotted amount for completing each assignment. As a Mystery Diner, you and a friend get a free meal!  Restaurants don’t want you to eat alone, so as long as you and your mystery dining apprentice stay within the budget; your meal is on the house!  But, don’t forget the receipt because our clients need proof that you really were there.
';

$GLOBALS['gLang']['how_do_i_become_one'] = 'How do I become one?';
$GLOBALS['gLang']['how_do_i_become_one_info'] = 'After filling out your profile information, head over to our assignment board and pick an assignment.  A report form, instructions, and a short quiz will be given to you.  This short quiz is just to make sure you know what you need to do for the evaluation, just make sure you read through the instructions and skim the report form before you start the quiz.  Once qualified, perform the visit within the time frame and fill out the report.  We will look over your report and arrange for a pick-up of your receipt.  Reimbursement will then be credited to you after we approve your report.';
$GLOBALS['gLang']['telephone'] = 'tel_en';
$GLOBALS['gLang']['telephone2'] = 'tel2_en';
$GLOBALS['gLang']['homepage'] = 'Main';
$GLOBALS['gLang']['quit'] = 'Logout';
$GLOBALS['gLang']['hello'] = 'Hello';
$GLOBALS['gLang']['what_is_mystery_shopping'] = 'What is Mystery Shopping?';
$GLOBALS['gLang']['what_is_mystery_shopping_answer'] = ' <p><br />Mystery Shopping is a method using informed shoppers to anonymously assess a brand’s core standards that involves customer service, operations, employee integrity, merchandising, and product quality.
Whenever there is a deviation from these standards, it indicates inconsistency.  Auditing the execution of these standards by way of mystery shoppers gives the most genuine data.</p>';
$GLOBALS['gLang']['more'] = 'More...';
$GLOBALS['gLang']['faq'] = 'FAQ';
$GLOBALS['gLang']['shoppermain'] = 'Shopper Main';
$GLOBALS['gLang']['protocol'] = 'Terms & Conditions';

$GLOBALS['gLang']['who_needs_mystery_shopping'] = 'Who needs Mystery Shopping?';
$GLOBALS['gLang']['who_needs_mystery_shopping_answer'] = 'Any business who wants to monitor its operations, facilities, product delivery, and service performance needs Mystery Shopping.  A developing brand needs to monitor its current locations while focusing on expanding into new ones.  Likewise, an established brand needs to maintain or raise standards at all locations in order to strengthen its position in the market.  Monitoring, maintaining, and raising standards is the key to developing a long-term brand strategy.';

$GLOBALS['gLang']['why_do_i_need_mystery_shopping'] = 'Why do I need Mystery Shopping?';
$GLOBALS['gLang']['why_do_i_need_mystery_shopping_answer'] = 'Improve customer retention<br />
Monitor service performance<br />
Monitor facility conditions<br />
Ensure service & product delivery quality<br />
Support promotional programs<br />
Audit pricing & merchandising compliance<br />
Identify training needs<br />
Enforce employee integrity
';

$GLOBALS['gLang']['why_is_consistency_important'] = 'Why is consistency important?';
$GLOBALS['gLang']['why_is_consistency_important_answer'] = 'Consistency is the key to any business that wants to grow.  Before a business can grow it must establish a set of standards.  These standards are the fundamentals of a brand and can be any part of the business as long as it stays constant from one location to the next.  When a consumer sees a brand name, a quality standard comes to mind.  If an inconsistency appears during a consumer experience, that quality standard is lost.  To a customer, consistency equals trust; trust that they will receive the same quality service, trust that they will receive the same quality product, and trust that they will receive the same quality experience each and every time they visit or purchase from the brand.';

$GLOBALS['gLang']['registration'] = 'Shopper Registration';
$GLOBALS['gLang']['already_signup'] = 'Already Signed Up?';
$GLOBALS['gLang']['notyet_signup'] = 'Haven\'t Registered Yet?';
$GLOBALS['gLang']['invitation_code'] = 'Invitation Code';
$GLOBALS['gLang']['regstepclass'] = 'regStep_en';
$GLOBALS['gLang']['congratulation'] = 'Congratulation! You have signed up！';
$GLOBALS['gLang']['redireting'] = 'Redirecting to home page after 5 seconds. Click here...';
$GLOBALS['gLang']['submit'] = 'Submit';

$GLOBALS['gLang']['map'] = 'map_en';
$GLOBALS['gLang']['shopper_login'] = 'Shopper Login';
$GLOBALS['gLang']['client_login'] = 'Client Login';
$GLOBALS['gLang']['how_to_use'] = 'How do I use Mystery Shopping?';
$GLOBALS['gLang']['how_to_use_answer'] = '<p>To have good Mystery Shopping data, you must have good quantitative questions focused on things that can be changed.  Too many businesses don’t think this through and end up with useless information that they spent a lot of time and money attaining.</p>
 <p>&nbsp;</p>
<p>Before using the data, you must first exploit the program.  Notify employees about the program and what is required of them.  If possible, involve them with the evaluation form to get their input.  The point is to have everyone understand and accept the program.  Without acceptance, staff members become skeptical of the results and discriminate against customers who they think might be a mystery shopper.  The purpose is to treat every customer as if they were a mystery shopper.  This will drastically increase performance before even starting the program.</p>
  <p>&nbsp;</p>
<p>After receiving the results, share the information with staff and discuss ways to improve.  Always use reports in a positive manner like with a rewards program for excellent reports.  Using the results negatively with punishment will only create defensive attitudes that become unconstructive and inhibit better behavior.  Mystery Shoppers are your customers and their comments should be appreciated instead of meeting it with resistance.  In the service industry, we don’t ask “Why?” we ask “How can we help?”</p>';
$GLOBALS['gLang']['is_marketing_research'] = 'Is Mystery Shopping marketing research?';
$GLOBALS['gLang']['is_marketing_research_answer'] = 'To maximize the use of Mystery Shopping, every visit includes a portion of marketing research questions that evaluates the consumer experience; however, it is not marketing research.  Mystery Shopping is a complement to a brand’s current marketing research and operations management.  It cannot stand on its own, but is very powerful in reinforcing what you have.';

$GLOBALS['gLang']['user_panel'] = 'User Panel';
$GLOBALS['gLang']['main'] = 'Main';
$GLOBALS['gLang']['inbox'] = 'Inbox';
$GLOBALS['gLang']['past_assignment'] = 'Past Assignments';
$GLOBALS['gLang']['assignment_board'] = 'Assignment Board';
$GLOBALS['gLang']['my_profile'] = 'My Profile';
$GLOBALS['gLang']['top_spot_of_month'] = 'Spot of the Month';
$GLOBALS['gLang']['top_shopper_of_month'] = 'Shopper of the Month';
$GLOBALS['gLang']['my_assignments'] = 'My Assignments';
$GLOBALS['gLang']['start_date'] = 'From';
$GLOBALS['gLang']['end_date'] = 'To';
$GLOBALS['gLang']['status'] = 'Status';
$GLOBALS['gLang']['comment_highlight'] = 'Comment Highlights';
$GLOBALS['gLang']['recent_assignments'] = 'Recent Assignments';
$GLOBALS['gLang']['my_calendar'] = 'My Calendar';
$GLOBALS['gLang']['client'] = 'Client';
$GLOBALS['gLang']['create'] = 'New Message';
$GLOBALS['gLang']['selectall'] = 'Select All';
$GLOBALS['gLang']['delete'] = 'Delete';
$GLOBALS['gLang']['read'] = 'Read Message';
$GLOBALS['gLang']['send'] = 'Send';
$GLOBALS['gLang']['reply'] = 'Reply';
$GLOBALS['gLang']['iam'] = 'I said';
$GLOBALS['gLang']['announcement'] = 'Announcements';
$GLOBALS['gLang']['publish_date'] = 'Published Date';
$GLOBALS['gLang']['finished_date'] = 'Finish Date';
$GLOBALS['gLang']['brands'] = 'Brand';
$GLOBALS['gLang']['stores'] = 'Location';
$GLOBALS['gLang']['assignment'] = 'Assignment';
$GLOBALS['gLang']['income'] = 'Reimbursement';
$GLOBALS['gLang']['income_unit'] = 'RMB';
$GLOBALS['gLang']['contact'] = 'Contact Info.';
$GLOBALS['gLang']['profiles'] = 'Profiles';
$GLOBALS['gLang']['diningcustoms'] = 'Dining Habits';
$GLOBALS['gLang']['general_dining'] = 'General Dining';
$GLOBALS['gLang']['work_week'] = 'Work Week (Mon - Fri)';
$GLOBALS['gLang']['weekends'] = 'Weekends (Sat & Sun)';
$GLOBALS['gLang']['payments'] = 'Payments';
$GLOBALS['gLang']['uploadface'] = 'Uploads';
$GLOBALS['gLang']['save'] = 'Save';
$GLOBALS['gLang']['real_name'] = 'Name (Last / First Middle)';
$GLOBALS['gLang']['living_city'] = 'Residing City';
$GLOBALS['gLang']['district'] = 'District';
$GLOBALS['gLang']['address_detail'] = 'Address';
$GLOBALS['gLang']['birthday'] = 'Birthdate';
$GLOBALS['gLang']['year'] = 'YYYY';
$GLOBALS['gLang']['month'] = 'MM';
$GLOBALS['gLang']['day'] = 'DD';
$GLOBALS['gLang']['marriage'] = 'Marital Status';
$GLOBALS['gLang']['married'] = 'Married';
$GLOBALS['gLang']['single'] = 'Single';
$GLOBALS['gLang']['divorced'] = 'Divorced';
$GLOBALS['gLang']['quan_of_children'] = 'Children';
$GLOBALS['gLang']['nationality'] = 'Nationality';
$GLOBALS['gLang']['birthplace'] = 'Birth City';
$GLOBALS['gLang']['job_position'] = 'Occupation';
$GLOBALS['gLang']['salary'] = 'Monthly Income';
$GLOBALS['gLang']['education'] = 'Education';
$GLOBALS['gLang']['middle_school'] = 'Middle School';
$GLOBALS['gLang']['technical_secondary'] = 'Technical Secondary School/ High School';
$GLOBALS['gLang']['junior_college'] = 'Bachelors/Junior College';
$GLOBALS['gLang']['master_degree'] = 'Masters';
$GLOBALS['gLang']['doctor_degree'] = 'Doctorate';
$GLOBALS['gLang']['have_own_car'] = 'Do you have a car?';
$GLOBALS['gLang']['have_been_mystery_shopper'] = 'Have you ever been a Mystery Shopper?';
$GLOBALS['gLang']['other_language'] = 'Other Languages';
$GLOBALS['gLang']['how_do_you_know_spot'] = 'How do you hear about SPOT?';
$GLOBALS['gLang']['introduced_by_friends'] = 'Friends';
$GLOBALS['gLang']['internet_advertisement'] = 'Internet Classifieds';
$GLOBALS['gLang']['outdoor_advertising'] = 'Internet Search';
$GLOBALS['gLang']['newspaper'] = 'Print Media';
$GLOBALS['gLang']['television'] = 'Client Referral';
$GLOBALS['gLang']['others'] = 'Others';

$GLOBALS['gLang']['usual_dining_custom'] = 'Who do you usually eat out with?';
$GLOBALS['gLang']['individual'] = 'Individual';
$GLOBALS['gLang']['with_family'] = 'Family';
$GLOBALS['gLang']['with_friends'] = 'Friends';
$GLOBALS['gLang']['with_colleagues'] = 'Colleagues';
$GLOBALS['gLang']['with_clients'] = 'Clients';
$GLOBALS['gLang']['lunchtimes'] = 'How often do you go out for lunch?';
$GLOBALS['gLang']['lunch_average_bill'] = 'Average lunch cost: (per person)';
$GLOBALS['gLang']['dinnertimes'] = 'How often do you go out for dinner?';
$GLOBALS['gLang']['dinner_average_bill'] = 'Average dinner cost: (per person)';
$GLOBALS['gLang']['to_restaurant_on_weekends'] = 'How many times do you dine out on weekends? ';
$GLOBALS['gLang']['average_lunch_bill_on_weekends'] = 'Average lunch cost: (per person)';
$GLOBALS['gLang']['average_dinner_bill_on_weekends'] = 'Average dinner cost: (per person)';
$GLOBALS['gLang']['company_name'] = 'Company Name';
$GLOBALS['gLang']['food_you_like'] = 'What kind of food do you like?';
$GLOBALS['gLang']['orderbyphone'] = 'Do you normally call in a reservation before dining out?';
$GLOBALS['gLang']['enjoy_vip_card'] = 'Do you frequently use Discount/VIP cards?';
$GLOBALS['gLang']['meals_delivered'] = 'How often do you have your meals delivered?';
$GLOBALS['gLang']['order_set'] = 'Do you frequently order set lunches?';
$GLOBALS['gLang']['lunch_delivered'] = 'How often do you have your lunch delivered?';
$GLOBALS['gLang']['order_drink'] = 'Do you usually order drink?';
$GLOBALS['gLang']['primary_to_restaurant'] = 'Which one is most important to you when dining out?';
$GLOBALS['gLang']['environment'] = 'Environment';
$GLOBALS['gLang']['convenient_transportation'] = 'Location';
$GLOBALS['gLang']['product_and_service'] = 'Service';
$GLOBALS['gLang']['price'] = 'Price';
$GLOBALS['gLang']['others'] = 'Product';
$GLOBALS['gLang']['your_interest'] = 'What is your interest?';
$GLOBALS['gLang']['vehicle'] = 'What method of transportation do you use when dining out? ';
$GLOBALS['gLang']['favorite_restaurant'] = 'What is your favorite restaurant?';
$GLOBALS['gLang']['receive_newsletter'] = 'Would you willing to receive the newsletter from SPOT?';
$GLOBALS['gLang']['metro'] = 'Metro';
$GLOBALS['gLang']['bus'] = 'Bus';
$GLOBALS['gLang']['taxi'] = 'Taxi';
$GLOBALS['gLang']['personal_auto'] = 'Personal Auto';
$GLOBALS['gLang']['company_car'] = 'Company Car';
$GLOBALS['gLang']['alipay_account'] = 'Alipay Account';
$GLOBALS['gLang']['alipay_realname'] = 'Alipay Account Name';
$GLOBALS['gLang']['bank_name'] = 'Bank Name';
$GLOBALS['gLang']['sub_branch_name'] = 'Sub branch Name';
$GLOBALS['gLang']['bank_account'] = 'Bank Account';
$GLOBALS['gLang']['account_name'] = 'Account Name';
$GLOBALS['gLang']['file_attachment'] = 'Support Doc：jpg/png/gif/jpeg，less than 2MB';
$GLOBALS['gLang']['assign_to'] = 'Assign To';
$GLOBALS['gLang']['nopass_img'] = 'nopass_en.gif';
$GLOBALS['gLang']['assigment_page'] = 'Assignment Info.';
$GLOBALS['gLang']['apply'] = 'Apply';
$GLOBALS['gLang']['preview'] = 'Report Form';
$GLOBALS['gLang']['fillout'] = 'Fill-in Report';
$GLOBALS['gLang']['uploadattachment'] = 'Uploads';
$GLOBALS['gLang']['params_invalid'] = 'Invalid Params!';
$GLOBALS['gLang']['pass_test'] = 'Congratulations! Your quiz is passed! Please go on to finish the job!';
$GLOBALS['gLang']['have_apply_for'] = 'Sorry! You have applied.';
$GLOBALS['gLang']['apply_success'] = 'Congratulations! You have applied successfully! We will contact you if you are seleted!';
$GLOBALS['gLang']['apply_failed'] = 'We are sorry! We are sorry that the application is full. Please look for the other assignments.';
$GLOBALS['gLang']['apply_first'] = 'Please apply first!';
$GLOBALS['gLang']['apply_second'] = 'Please finish the quiz first!';
$GLOBALS['gLang']['ordernum'] = 'Number';
$GLOBALS['gLang']['questions'] = 'Questions';
$GLOBALS['gLang']['options'] = 'Options';
$GLOBALS['gLang']['finish_report'] = 'You had finished the report! Please wait for the approval!';
$GLOBALS['gLang']['approval_pass'] = 'Congratulations! Your report is passed!';
$GLOBALS['gLang']['approval_notpass'] = 'Sorry! Your report is not passed.';
$GLOBALS['gLang']['test_notpass'] = 'Sorry! Your quiz is not passed! Try to redo it!';
$GLOBALS['gLang']['fiinish_redmark_question'] = 'Sorry! Please finish the question that marked red color!';
$GLOBALS['gLang']['submit_alert'] = 'Attension! If you had not finished the assignment, you must be check out. Are you sure to submit?';
$GLOBALS['gLang']['mp3_image'] = 'Frequency or Images';
$GLOBALS['gLang']['support_file_format'] = 'Suport Doc：';
$GLOBALS['gLang']['less_than'] = 'less than ';
$GLOBALS['gLang']['grade_info'] = 'Standard for Evaluation';
$GLOBALS['gLang']['level_0'] = 'N/A';
$GLOBALS['gLang']['level_1'] = 'Worse';
$GLOBALS['gLang']['level_2'] = 'Bad';
$GLOBALS['gLang']['level_3'] = 'To Improve';
$GLOBALS['gLang']['level_4'] = 'Common';
$GLOBALS['gLang']['level_5'] = 'Good';
$GLOBALS['gLang']['level_6'] = 'Very Good';
$GLOBALS['gLang']['level_7'] = 'Perfect';
$GLOBALS['gLang']['applicant'] = 'Applicant';
$GLOBALS['gLang']['menu_site'] = 'Website';
$GLOBALS['gLang']['menu_shopper'] = 'Mystery Shoppers';
$GLOBALS['gLang']['menu_shopperlist'] = 'Shopper Lists';
$GLOBALS['gLang']['menu_mailbox'] = 'Mailbox';
$GLOBALS['gLang']['menu_corperation'] = 'Corporation';
$GLOBALS['gLang']['menu_corplist'] = 'Corp. Lists';
$GLOBALS['gLang']['menu_searchcorp'] = 'Search Corp.';
$GLOBALS['gLang']['menu_addcorp'] = 'Add Corp.';
$GLOBALS['gLang']['menu_addstore'] = 'Add Store';
$GLOBALS['gLang']['menu_assignment'] = 'Assignment';
$GLOBALS['gLang']['menu_assignmentlist'] = 'Assignment Lists';
$GLOBALS['gLang']['menu_addassignment'] = 'Add Assignment';
$GLOBALS['gLang']['menu_report'] = 'Report';
$GLOBALS['gLang']['menu_question'] = 'Question Lists';
$GLOBALS['gLang']['menu_createreport'] = 'Create Report';
$GLOBALS['gLang']['menu_reportlist'] = 'Report Lists';
$GLOBALS['gLang']['menu_charts'] = 'Chart';
$GLOBALS['gLang']['menu_comment'] = 'Comment';

$GLOBALS['gLang']['msg_list'] = 'Message Lists';
$GLOBALS['gLang']['new'] = 'New';
$GLOBALS['gLang']['m_title'] = 'Title';
$GLOBALS['gLang']['from_user'] = 'From';
$GLOBALS['gLang']['to_user'] = 'To';
$GLOBALS['gLang']['m_date'] = 'Date';
$GLOBALS['gLang']['required'] = 'Required';
$GLOBALS['gLang']['mobilerule'] = '11 numbers required';
$GLOBALS['gLang']['spot_mystery'] = 'SPOT Mystery Shopper Info.';
$GLOBALS['gLang']['age'] = 'Age';

$GLOBALS['gLang']['control_pannel'] = 'Control Panel';
$GLOBALS['gLang']['company_info'] = 'Company Information';
$GLOBALS['gLang']['mystery_shopper'] = 'Mystery Shopper';
$GLOBALS['gLang']['by_location'] = 'By Location';
$GLOBALS['gLang']['comment_analysis'] = 'Comment Analysis';
$GLOBALS['gLang']['completed_visits'] = 'Completed Visits';
$GLOBALS['gLang']['overall'] = 'Overall Compare';
$GLOBALS['gLang']['general'] = 'General';
$GLOBALS['gLang']['profile'] = 'Profile';
$GLOBALS['gLang']['contact'] = 'Contact';
$GLOBALS['gLang']['locations'] = 'Locations';
$GLOBALS['gLang']['all_locations'] = 'All Locations';
$GLOBALS['gLang']['bar_graph'] = 'Bar Graph';
$GLOBALS['gLang']['original_figures'] = 'Original Figures';
$GLOBALS['gLang']['graphical_chart'] = 'Graphical Chart';
$GLOBALS['gLang']['scorenum'] = 'Score';
$GLOBALS['gLang']['finish_date'] = 'Finished Date';
$GLOBALS['gLang']['completed_visits'] = 'Completed Visits';
$GLOBALS['gLang']['to_visit'] = 'Next Visit';
$GLOBALS['gLang']['latest_visits'] = 'Latest Completed Visit';
$GLOBALS['gLang']['answer'] = 'Answer';
$GLOBALS['gLang']['search_report'] = 'Search';
$GLOBALS['gLang']['select_location'] = 'Select Location';
$GLOBALS['gLang']['or'] = 'Or';
$GLOBALS['gLang']['retsetpwd'] = 'Reset Password';
$GLOBALS['gLang']['oldpwd'] = 'Old Password';
$GLOBALS['gLang']['paynote'] = '*Note: If possible, please use China Construction Bank for the most efficient transaction）';
$GLOBALS['gLang']['assignmentprogress'] = 'Assignment Progress';
$GLOBALS['gLang']['ranking'] = 'Rankings';
?>