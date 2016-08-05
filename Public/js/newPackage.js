$(function(){
		 //新建礼包第二步验证
        var $validation = true;
        var curWwwPath=window.document.location.href;
        var pathName=window.document.location.pathname;
        var pos=curWwwPath.indexOf(pathName);
        var localhostPaht=curWwwPath.substring(0,pos);
        var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);

        $('#next-valicty-step2').ace_wizard().on('click' , function(e, info){
            if($validation) {
                if(!$('#validation-form-step2').valid()) return false;
            }
        }).on('finished', function(e) {
//          bootbox.dialog({
//              message: "Thank you! Your information was successfully saved!",
//              buttons: {
//                  "success" : {
//                      "label" : "OK",
//                      "className" : "btn-sm btn-primary"
//                  }
//              }
//          });
        }).on('stepclick', function(e){
            //return false;//prevent clicking on steps
        });

		 $('#validation-form-step2').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			rules: {
				giftname: {
					required: true,
					remote:{
						type: "POST",             //数据发送方式
		                url: localhostPaht+projectName+"/index.php/Home/Record/checkGiftName",     //后台处理程序   
		                dataType: "json",           //接受数据格式   
		                data: {                     //要传递的数据
		                    giftname: function() {
		                        return $("#giftname").val();
		                    }
		                 }
		         }
					//maxlength: 25
				},
				token: {
					required: true,
					remote:{
						type: "POST",             //数据发送方式
		                url: localhostPaht+projectName+"/index.php/Home/Record/checkToken",     //后台处理程序   
		                dataType: "json",           //接受数据格式   
		                data: {                     //要传递的数据
		                    token: function() {
		                        return $("#token").val();
		                    }
		                 }
		         }
				//	maxlength: 25
				},
			},
			messages: {
				giftname: {
					required: "请输入礼包名称",
					remote:   "礼包名称已存在,请重新输入"
				//	maxlength: "名称不得超过25个字符"
				},
				token: {
					required: "请输入领取口令",
					remote:   "领取口令已存在,请重新输入"
				//	maxlength: "名称不得超过25个字符"
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
		 
		
		  
})









