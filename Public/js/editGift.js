$(function(){
    var $validation = true;
    var curWwwPath=window.document.location.href;
    var pathName=window.document.location.pathname;
    var pos=curWwwPath.indexOf(pathName);
    var localhostPaht=curWwwPath.substring(0,pos);
    var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
	var temp =  $("#content").val().replace(/<br>/g,'\n');
		$("#content").html(temp);
	var tem =  $("#shuoming").val().replace(/<br>/g,'\n');
		$("#shuoming").html(tem);
		$('#editGift').ace_wizard().on('click' , function(e, info){
            if($validation) {
                if(!$('#validation-edit-form').valid()){
                	return false;
                }
                else{
                	 ajaxForm();
                }
            }
        }).on('finished', function(e) {
        	
        }).on('stepclick', function(e){
        });

		 $('#validation-edit-form').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			rules: {
				gift_name: {
					required: true,
					remote:{
						type: "POST",             //数据发送方式
		                url: localhostPaht+projectName+"/index.php?m=home&c=Index&a=checkFgiftname",     //后台处理程序   
		                dataType: "json",           //接受数据格式   
		                data: {                     //要传递的数据
		                	 gift_name: function() {
			                        return $("#gift_name").val();
			                  },
			                  giftsid: function() {
			                        return $("#giftsid").val();
			                  },
		                 }
					}
				},
				token: {
					required: true,
						remote:{
							type: "POST",             //数据发送方式
			                url: localhostPaht+projectName+"/index.php?m=home&c=Index&a=checkFtoken",     //后台处理程序   
			                dataType: "json",           //接受数据格式   
			                data: {                     //要传递的数据
								token: function() {
				                        return $("#token").val();
				                },
				                giftsid: function() {
				                        return $("#giftsid").val();
				                },
			                 }
						}
				},
				platform:{
					required:true,
				},
			},
			messages: {
				gift_name: {
					required: "请输入礼包名称",
					remote:   "礼包名称已存在,请重新输入"
				},
				token: {
					required: "请输入领取口令",
					remote:   "领取口令已存在,请重新输入"
				},

				platform:{
					required:"请输入礼包适用平台",
				},					
			},
			invalidHandler: function(event, validator) { //display error alert on form submit
				$('.alert-danger', $('.login-form')).show();
			},
			highlight: function(e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},
			success: function(e) {
				$(e).closest('.form-group').removeClass('has-error').addClass('has-info');
				$(e).remove();
			},
			
		});	 
			 
	 function ajaxForm(){
		 $.ajax({
	            type: "POST",
	            url: "?m=Home&c=Record&a=editGiftSave",
	            data: {
	            	giftsid:$("#giftsid").val(),
	            	gift_name:$("#gift_name").val(),
	            	token:$("#token").val(),
	            	content:$("#content").val(),
	            	shuoming:$("#shuoming").val(),
	            	platform:$("#platform").val(),
	            	endtime:$("#endtime").val()
	            	},
	            dataType: "json",
	            success: function(data){
	            	 if(data == true){ 
	            		 layer.confirm('修改成功', function(index) {
	            			 layer.close(index); 
	            			 window.location.href="?m=Home&c=Record&a=lists";
	            		 }); 
			            }else{  		               
			            	layer.alert("修改失败!");
			            }  	            	
	            }   
	        });
		 
	 }
//	 		$('#editGift').click(function(){		   	
//    	        $.ajax({
//    	            type: "POST",
//    	            url: "?m=Home&c=Record&a=editGiftSave",
//    	            data: {
//    	            	giftsid:$("#giftsid").val(),
//    	            	gift_name:$("#gift_name").val(),
//    	            	token:$("#token").val(),
//    	            	content:$("#content").val(),
//    	            	shuoming:$("#shuoming").val(),
//    	            	platform:$("#platform").val(),
//    	            	endtime:$("#endtime").val()
//    	            	},
//    	            dataType: "json",
//    	            success: function(data){
//    	            	 if(data == true){ 
//    	            		 layer.confirm('修改成功', function(index) {
//    	            			 layer.close(index); 
//    	            			 window.location.href="?m=Home&c=Record&a=lists";
//    	            		 }); 
//    			            }else{  		               
//    			            	layer.alert("修改失败!");
//    			            }  	            	
//    	            }   
//    	        });
//	 });

    	       
    	        
    	 	
})