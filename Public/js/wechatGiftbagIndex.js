$(function(){
//	 var curWwwPath=window.document.location.href;
//     var pathName=window.document.location.pathname;
//     var pos=curWwwPath.indexOf(pathName);
//     var localhostPaht=curWwwPath.substring(0,pos);
//     var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
	//领取记录表格加载
	var collectlist=$('#collectRecords-table').DataTable({
            "ajax": "?m=home&c=Record&a=listsdata",
            "info":true,
            "searching":false,
            "pageLength":10,
            "lengthChange":true,
            "order":[[0, "" ]],
         	"pagingType": "full_numbers",
            "dom":'rt<"bottom"<"col-md-6 paging"p>>',
            "columns":[
                {"data":"gettime",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    },
                },
                {"data":"game_name",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
                },
                {"data":"gift_name",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },{"data":"code",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },{"data":"openid",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },{"data":"content",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },
                
            ],
            
            "language": {
                "processing": "玩命加载中...",
                "zeroRecords": "没有数据",
                "paginate": {
                    "first":    "首页",
                    "previous": "上一页",
                    "next":     "下一页",
                    "last":     "末页"
                }
            }

        });
		$("#getCore").click(function () {
			collectlist.ajax.reload();
	    });
        
        //礼包列表表格加载
       var packagelist=$('#packagelist-table').DataTable({
    	   "ajax":'?m=home&c=Record&a=giftsdata',
            "info":true,
            "searching":false,
            "pageLength":10,
            "lengthChange":true,

            "order":[[0, "" ]],
         	"pagingType": "full_numbers",
            "dom":'rt<"bottom"<"col-md-6 paging"p>>',
            "columns":[
                {"data":"giftsid",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    },
                },
                {"data":"gift_name",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
                },
                {"data":"token",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },{"data":"stock",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },{"data":"content",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },{"data":"endtime1",
                    "render":function(data, type){
                        return '<div class="center">'+data+'</div>';
                    }
//                    "orderable":false
                },{"data":"giftsid",
                    "render":function(data, type){
                        return '<a href="?m=Home&c=Record&a=importAgain&giftsid='+data+' " class="center leadingin">'+'追加导入'+'</a>';
                    }
//                    "orderable":false
                },
                
            ],
            
            "language": {
                "processing": "玩命加载中...",
                "zeroRecords": "没有数据",
                "paginate": {
                    "first":    "首页",
                    "previous": "上一页",
                    "next":     "下一页",
                    "last":     "末页"
                }
               
            }
       

        });
        
        // 验证
        var $validation = true;
        $('#next-valicty').ace_wizard().on('click' , function(e, info){
        	  if($validation) {
                  
                  if (!$('#validation-form').valid()) {
                    return false;
                  } else{
                	 if($("#name").val()==''){
                		 window.location.href='?m=home&c=Record&a=news_step2&name='+$("#gamelist").find("option:selected").text();
                	 }else{
                		 window.location.href='?m=home&c=Record&a=news_step2&name='+$("#name").val();
                	 }
                    
                  }
              }
        }).on('finished', function(e) {
          bootbox.dialog({
              message: "Thank you! Your information was successfully saved!",
              buttons: {
                  "success" : {
                      "label" : "OK",
                      "className" : "btn-sm btn-primary"
                  }
              }
          });
        }).on('stepclick', function(e){
            //return false;//prevent clicking on steps
        });

		 $('#validation-form').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			
	         
			rules: {
				name: {
					//required: true,   		  //游戏名称非必填，可选列表中的参数 
					remote:{
						type: "POST",             //数据发送方式
		                url: "?m=home&c=Record&a=checkGameName",     //后台处理程序   
		                dataType: "json",           //接受数据格式   
		                data: {                     //要传递的数据
		                    name: function() {
		                        return $("#name").val();
		                    }
		                 }
		         },
					maxlength: 25
				},

				
			},
			messages: {
				name: {
					//required: "请输入游戏名称",
					remote:"游戏已存在，请重新输入",
					maxlength: "名称不得超过25个字符"
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
		 
 		//礼包查询按钮	 
 		 $("#search").click(function () {
 			var giftname=$("#p6_gift_name").val();
 			var token=$("#p6_token").val();
 			var first=$("#p6_first_time").val();
 			var last=$("#p6_last_time").val();
 			if(giftname!=undefined && giftname!=''){
 				document.cookie="giftname="+encodeURI(giftname);	
 			}
 			if(token!=undefined && token!=''){
 				document.cookie="token="+encodeURI(token);
 			}
 			if(first!=undefined && first!=''){
 				document.cookie="first="+encodeURI(first);
 			}
 			if(last!=undefined && last!=''){
 				document.cookie="last="+encodeURI(last);
 			} 			
 			packagelist.ajax.reload();
 	    });
 		 
 		//领取记录查询按钮 
 		 $("#p5_search").click(function () {
 			var userid=$("#p5_userid").val();
 			var giftname=$("#p5_giftname").val();
 			var first=$("#p5_first_time").val();
 			var last=$("#p5_last_time").val();
 			
 			if(userid!=undefined && userid!=''){
 				document.cookie="userid="+encodeURI(userid);
 			}
 			if(giftname!=undefined && giftname!=''){
 				document.cookie="giftname="+encodeURI(giftname);	
 			}
 			if(first!=undefined && first!=''){
 				document.cookie="first5="+encodeURI(first);
 			}
 			if(last!=undefined && last!=''){
 				document.cookie="last5="+encodeURI(last);
 			} 			
 			collectlist.ajax.reload();
 	    });
 		 
 		 $("#import").click(function(){
 			var userid=$("#p5_userid").val();
 			var giftname=$("#p5_giftname").val();
 			var first=$("#p5_first_time").val();
 			var last=$("#p5_last_time").val();
 			
 			if(userid!=undefined && userid!=''){
 				document.cookie="userid="+encodeURI(userid);
 			}
 			if(giftname!=undefined && giftname!=''){
 				document.cookie="giftname="+encodeURI(giftname);	
 			}
 			if(first!=undefined && first!=''){
 				document.cookie="first5="+encodeURI(first);
 			}
 			if(last!=undefined && last!=''){
 				document.cookie="last5="+encodeURI(last);
 			}
 			window.location.href='?m=home&c=Record&a=export';
 		 });
	
		
})