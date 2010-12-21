
//图片
var vote_image0='/public/images/vote_yes0.gif';
var vote_image='/public/images/vote_yes.gif';

/************** 加载图片 start  add by wendy 2010.12.7****************/
var vote_imagey0 = '/public/images/vote_y0.gif';
var vote_imagey1 = '/public/images/vote_y1.gif';
var vote_imagey2 = '/public/images/vote_y2.gif';
var vote_imagey3 = '/public/images/vote_y3.gif';
var vote_imagey4 = '/public/images/vote_y4.gif';
var vote_imagey5 = '/public/images/vote_y5.gif';
var vote_imagey6 = '/public/images/vote_y6.gif';
var vote_imagey7 = '/public/images/vote_y7.gif';
var vote_imagey8 = '/public/images/vote_y8.gif';
var vote_imagey9 = '/public/images/vote_y9.gif';
var vote_imagey10 = '/public/images/vote_y10.gif';

var vote_imagen0 = '/public/images/vote_n0.gif';
var vote_imagen1 = '/public/images/vote_n1.gif';
var vote_imagen2 = '/public/images/vote_n2.gif';
var vote_imagen3 = '/public/images/vote_n3.gif';
var vote_imagen4 = '/public/images/vote_n4.gif';
var vote_imagen5 = '/public/images/vote_n5.gif';
var vote_imagen6 = '/public/images/vote_n6.gif';
var vote_imagen7 = '/public/images/vote_n7.gif';
var vote_imagen8 = '/public/images/vote_n8.gif';
var vote_imagen9 = '/public/images/vote_n9.gif';
var vote_imagen10 = '/public/images/vote_n10.gif';

var vote_imageybig0 = '/public/images/vote_ybig0.gif';
var vote_imageybig1 = '/public/images/vote_ybig1.gif';
var vote_imageybig2 = '/public/images/vote_ybig2.gif';
var vote_imageybig3 = '/public/images/vote_ybig3.gif';
var vote_imageybig4 = '/public/images/vote_ybig4.gif';
var vote_imageybig5 = '/public/images/vote_ybig5.gif';
var vote_imageybig6 = '/public/images/vote_ybig6.gif';
var vote_imageybig7 = '/public/images/vote_ybig7.gif';
var vote_imageybig8 = '/public/images/vote_ybig8.gif';
var vote_imageybig9 = '/public/images/vote_ybig9.gif';
var vote_imageybig10 = '/public/images/vote_ybig10.gif';

/************** 加载图片 end  add by wendy 2010.12.7****************/

//加载图片
function create_vote_img(id,value){
//isNaN()用来判断value是否为数字，当value为0、‘’、‘ ’、‘12’等形式时，该函数都会判断为数字（‘’和‘ ’被判断为0）；当为‘12s’时，判断不为数字
	value = isNaN(value) ? -1 : value;
//alert("value="+value);
	var vote_div=document.getElementById("voteimg_"+id);
	for(var i=0;i<=10;i++){
	    var vote_img=document.createElement('img');
	  	vote_div.appendChild(vote_img);
		if(i>value)
			vote_img.setAttribute("src",eval('vote_imagen'+i));
		else
			vote_img.setAttribute("src",eval('vote_imagey'+i));
		vote_img.setAttribute("id","yes_"+id+'_'+i);
		vote_img.setAttribute("title",i+"分");
	    vote_img.style.cursor="pointer";

		if(is_ie6){

			 // vote_img.setAttribute("onmouseover",'put_fs(this.id)');
			  //vote_img.setAttribute("onmouseout",'out_fs(this.id)');
			  vote_img.setAttribute("onclick",function(){is_fs(this);});
			}else{
			//  vote_img.setAttribute("onmouseover",'put_fs(this.id)');
			//  vote_img.setAttribute("onmouseout",'out_fs(this.id)');
			  vote_img.setAttribute("onclick",'is_fs(this);');
			}

	}
}

function put_fs(id){
	//alert(id.id);
	var str=id;
 	var q=str.split("_")[1];
 	var obj=str.split("_")[2];
	for(var i=0;i<=obj;i++){
		$("yes_"+q+"_"+i).src=vote_image;
	}
}

function out_fs(id){
	var str=id;
 	var q=str.split("_")[1];
 	var obj=str.split("_")[2];
 	var mark_type=str.split("_")[3];//add by wendy 2010.11.24
	for(var i=0;i<=mark_type;i++){
		$("yes_"+q+"_"+i+'_'+mark_type).src=eval('vote_imagen'+i);
	}

	if(document.getElementById("votebox_"+q).checked==true){
		document.getElementById("rq_ans_"+q).value ="A";
		document.getElementById("span_ch_"+q).innerHTML ="N/A";
	}else{
		document.getElementById("rq_ans_"+q).value ="";
		document.getElementById("span_ch_"+q).innerHTML ="";
	}
	display_comment(q);
}

/* 在前台显示页面，有个<input type="hidden" id="rq_ans_182" name="rq_ans_2_182" value="9">隐藏框，这里用来设置它的值，后续程序会读取这个值并存入数据库 */
function is_fs(id){
	var str=id.id;
	//alert("str="+str);
	var q=str.split("_")[1];
 	var obj=str.split("_")[2];
	var vote_span=document.createElement("div");
	//out_fs=function(){return false;};
	//put_fs=function(){return false;};
	for(var i=0;i<=10;i++){
		$("yes_"+q+"_"+i).src=eval('vote_imagen'+i);
	}
	for(var i=0;i<=obj;i++){
		$("yes_"+q+"_"+i).src=eval('vote_imagey'+i);
	}

	var vote_span_text=obj+"分";
	document.getElementById("rq_ans_"+q).value =obj;
	document.getElementById("span_ch_"+q).innerHTML =vote_span_text;
	document.getElementById("votebox_"+q).checked = 0;
	//is_fs=function(){return false;};
	display_comment(q);
}

function display_comment(id){
	var obj = $("icon_updown_"+id);
	if($("td_comment_"+id)){
		$("td_comment_"+id).style.display = '';
		$("td_comment_"+id).focus();
	}
	if(obj){
	if(is_ie6){
		obj.setAttribute("onclick",function(){hide_comment(id);});
	}else{
		obj.setAttribute("onclick",'hide_comment('+id+');');
	}
	}
}
function hide_comment(id){
	var obj = $("icon_updown_"+id);
	if($("td_comment_"+id)) $("td_comment_"+id).style.display = 'none';
	if(obj){
	if(is_ie6){
		obj.setAttribute("onclick",function(){display_comment(id);});
	}else{
		obj.setAttribute("onclick",'display_comment('+id+');');
	}
	}
}

/***********************************************************************/
/* 解决评论分制的多样化 start -add by wendy 2010.11.23*/
/*加载图片

* 入口参数：id:任务ID；
*         value:数据库中的分值；
*        mark_type:分制类型（10、5、4、3、2）
*/

function create_vote_img_mark(id,value,mark_type){
//isNaN()用来判断value是否为数字，当value为0、‘’、‘ ’、‘12’等形式时，该函数都会判断为数字（‘’和‘ ’被判断为0）；当为‘12s’时，判断不为数字
	value = isNaN(value) ? -1 : value;
	value = value ? value : 0;
//	alert("value="+value);
//	alert("type="+mark_type);

	//定义保存分制的二维数组，一维的索引号表示分制类型，二维的索引号表示数据库中的value，值表示应在前端显示的数值
	var grade_ary = new Array();
	//10分制
	grade_ary[10] = new Array();
	grade_ary[10][-1] = -1;//保证当选择N/A时，所有图标为灰色
	grade_ary[10][0] = 0;
	grade_ary[10][1] = 1;
	grade_ary[10][2] = 2;
	grade_ary[10][3] = 3;
	grade_ary[10][4] = 4;
	grade_ary[10][5] = 5;
	grade_ary[10][6] = 6;
	grade_ary[10][7] = 7;
	grade_ary[10][8] = 8;
	grade_ary[10][9] = 9;
	grade_ary[10][10] = 10;
	//5分制
	grade_ary[5] = new Array();
	grade_ary[5][-1] = -1;//保证当选择N/A时，所有图标为灰色
	grade_ary[5][0] = 0;
	grade_ary[5][2] = 1;
	grade_ary[5][4] = 2;
	grade_ary[5][6] = 3;
	grade_ary[5][8] = 4;
	grade_ary[5][10] = 5;
	//4分制
	grade_ary[4] = new Array();
	grade_ary[4][-1] = -1;//保证当选择N/A时，所有图标为灰色
	grade_ary[4][0] = 0;
	grade_ary[4][2.5] = 1;
	grade_ary[4][5] = 2;
	grade_ary[4][7.5] = 3;
	grade_ary[4][10] = 4;
//	alert("grade_ary[4][2.5]="+grade_ary[4][2.5]);
//	alert("grade_ary[4][7.5]="+grade_ary[4][7.5]);
	//2分制
	grade_ary[2] = new Array();
	grade_ary[2][-1] = -1;//保证当选择N/A时，所有图标为灰色
	grade_ary[2][0] = 0;
	grade_ary[2][5] = 1;
	grade_ary[2][10] = 2;

	var newvalue;
	switch(mark_type){
	case 10:newvalue = grade_ary[10][value];break;
	case 5:newvalue = grade_ary[5][value];break;
	case 4:newvalue = grade_ary[4][value];break;
	case 2:newvalue = grade_ary[2][value];break;
	}
//	alert("newvalue="+newvalue);

	var vote_div=document.getElementById("voteimg_"+id);
	for(var i=0;i<=mark_type;i++){
	    var vote_img=document.createElement('img');
	  	vote_div.appendChild(vote_img);
		if(i>newvalue)
			vote_img.setAttribute("src",eval('vote_imagen'+i));
		else if(i == newvalue)
			vote_img.setAttribute("src",eval('vote_imageybig'+i));
		else
			vote_img.setAttribute("src",eval('vote_imagey'+i));
		vote_img.setAttribute("id","yes_"+id+'_'+i+'_'+mark_type);
		vote_img.setAttribute("title",i+"分");
	    vote_img.style.cursor="pointer";

		if(is_ie6){

			 // vote_img.setAttribute("onmouseover",'put_fs(this.id)');
			  //vote_img.setAttribute("onmouseout",'out_fs(this.id)');
			  vote_img.setAttribute("onclick",function(){is_fs_mark(this);});
			}else{
			//  vote_img.setAttribute("onmouseover",'put_fs(this.id)');
			//  vote_img.setAttribute("onmouseout",'out_fs(this.id)');
			  vote_img.setAttribute("onclick",'is_fs_mark(this);');
			}

	}
}

/* 在前台显示页面，有个<input type="hidden" id="rq_ans_182" name="rq_ans_2_182" value="9">隐藏框，这里用来设置它的值，后续程序会读取这个值并存入数据库 */
function is_fs_mark(id){
	var str=id.id;
	var q=str.split("_")[1];
 	var obj=str.split("_")[2];
 	var mark_type=str.split("_")[3];
	var vote_span=document.createElement("div");
	//out_fs=function(){return false;};
	//put_fs=function(){return false;};
	for(var i=0;i<=mark_type;i++){
		$("yes_"+q+"_"+i+'_'+mark_type).src=eval('vote_imagen'+i);
	}
	for(var i=0;i<=obj;i++){
		if(i == obj)
			$("yes_"+q+"_"+i+'_'+mark_type).src = eval('vote_imageybig'+i);
		else
			$("yes_"+q+"_"+i+'_'+mark_type).src=eval('vote_imagey'+i);
	}

	var vote_span_text=obj+"分";
	document.getElementById("span_ch_"+q).innerHTML =vote_span_text;
	if(document.getElementById("votebox_"+q)){
	document.getElementById("votebox_"+q).checked = 0;}

	/* 设置隐藏框的值前，将值转换成能存入数据库的值（10分制的） */
	//定义保存分制的二维数组，一维的索引号表示分制类型，二维的索引号表示应在前端显示的数值，值表示应存入数据库中的value
	var value_ary = new Array();
	var newvalue;
	//10分制
	value_ary[10] = new Array();
	value_ary[10][0] = 0;
	value_ary[10][1] = 1;
	value_ary[10][2] = 2;
	value_ary[10][3] = 3;
	value_ary[10][4] = 4;
	value_ary[10][5] = 5;
	value_ary[10][6] = 6;
	value_ary[10][7] = 7;
	value_ary[10][8] = 8;
	value_ary[10][9] = 9;
	value_ary[10][10] = 10;
	//5分制
	value_ary[5] = new Array();
	value_ary[5][0] = 0;
	value_ary[5][1] = 2;
	value_ary[5][2] = 4;
	value_ary[5][3] = 6;
	value_ary[5][4] = 8;
	value_ary[5][5] = 10;
	//4分制
	value_ary[4] = new Array();
	value_ary[4][0] = 0;
	value_ary[4][1] = 2.5;
	value_ary[4][2] = 5;
	value_ary[4][3] = 7.5;
	value_ary[4][4] = 10;
	//2分制
	value_ary[2] = new Array();
	value_ary[2][0] = 0;
	value_ary[2][1] = 5;
	value_ary[2][2] = 10;

	//此时，mark_type为char型
	switch(mark_type){
	case '10':newvalue = value_ary[10][obj];break;
	case '5':newvalue = value_ary[5][obj];break;
	case '4':newvalue = value_ary[4][obj];break;
	case '2':newvalue = value_ary[2][obj];break;
	}

	document.getElementById("rq_ans_"+q).value =newvalue;//设置隐藏框的值
	//is_fs=function(){return false;};
	display_comment(q);
}

// 解决评论分制的多样化 end -add by wendy 2010.11.23

