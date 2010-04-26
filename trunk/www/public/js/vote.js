
//图片
var vote_image0='/public/images/vote_yes0.gif';
var vote_image='/public/images/vote_yes.gif';

//加载图片
function create_vote_img(id,value){
	value = isNaN(value) ? -1 : value;
	
	var vote_div=document.getElementById("voteimg_"+id);
	for(var i=0;i<=10;i++){	
	    var vote_img=document.createElement('img');
	  	vote_div.appendChild(vote_img);		
		if(i>value)
			vote_img.setAttribute("src",vote_image0);
		else 
			vote_img.setAttribute("src",vote_image);
		vote_img.setAttribute("id","yes_"+id+'_'+i);	
		vote_img.setAttribute("title",i+"分");
	    vote_img.style.cursor="pointer";
	   
			if(is_ie){
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
	for(var i=0;i<=obj;i++){
		$("yes_"+q+"_"+i).src=vote_image0;
	}

	if(document.getElementById("votebox_"+q).checked==true){
		document.getElementById("rq_ans_"+q).value ="A";
		document.getElementById("span_ch_"+q).innerHTML ="N/A";
	}else{
		document.getElementById("rq_ans_"+q).value ="";
		document.getElementById("span_ch_"+q).innerHTML ="";
	}
	

}
function is_fs(id){
	var str=id.id;
	var q=str.split("_")[1];
 	var obj=str.split("_")[2];
	var vote_span=document.createElement("div");
	//out_fs=function(){return false;};
	//put_fs=function(){return false;};
	for(var i=0;i<=10;i++){	
		$("yes_"+q+"_"+i).src=vote_image0;
	}
	for(var i=0;i<=obj;i++){	
		$("yes_"+q+"_"+i).src=vote_image;
	}

	var vote_span_text=obj+"分";
	document.getElementById("rq_ans_"+q).value =obj;
	document.getElementById("span_ch_"+q).innerHTML =vote_span_text;
	document.getElementById("votebox_"+q).checked = 0;
	//is_fs=function(){return false;};
}