<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/libao/Public/css/ace.min.css">
    <link rel="stylesheet" href="/libao/Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/libao/Public/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/libao/Public/css/main.css" />
    <script type="text/javascript" src="/libao/Public/js/jquery-2.2.4.min.js" ></script>
    <script type="text/javascript" src="/libao/Public/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="/libao/Public/js/ace-elements.min.js" ></script>
    <script type="text/javascript" src="/libao/Public/js/ace.min.js" ></script>
    <script type="text/javascript" src="/libao/Public/js/jquery.validate.js" ></script>
    <title>登录页面</title>
</head>
<body class="login-layout">
<img class="login-bg" src="/libao/Public/img/login-back.jpg" height="100%" width="100%">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body login-update">
                                <h4 class="header white lighter bigger login-logo">
                                   		 微信礼包登录
                                </h4>
                                <div class="widget-main">
                                    <div class="space-6"></div>
                                    <form id="loginForm" method="POST" action="<?php echo U('Home/Login/checkLogin');?>">
                                        <fieldset>
                                            <label class="block clearfix" style="height: 50px">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="用户名" />
                                                    <i class="icon-user"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix" style="height: 50px">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="密码" />
                                                    <i class="icon-lock"></i>
                                                </span>
                                            </label>
                                          <!--    <label class="block clearfix" style="height: 50px">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control" id="parten" name="parten" placeholder="验证码"/>
                                                    <img class="check_img" src="/libao/Public/img/code.png" id="code"/>
                                                    <i class="icon-refresh"></i>
                                                </span>
                                            </label>
                                            -->
                                            <div class="space"></div>
                                            <div class="clearfix">
                                                <label class="inline">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl color"> 记住密码</span>
                                                </label>
                                              
                                                <button id="login-next" type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="icon-key"></i>
                                                   	 登录
                                                </button>
                                               
                                            </div>
                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>
                            </div><!-- /widget-body -->
                           		 <!-- 
                                <div class="toolbar clearfix">
                                    <div>
                                        <a href="javascript:;" class="showbox white forgot-password-link">
                                            <i class="icon-arrow-left"></i>
                                          	  忘记密码
                                        </a>
                                    </div>
                                </div>
                                 -->
                            </div><!-- /login-box -->
                        <div id="forgot-box" class="forgot-box" style="display: none">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                        <i class="icon-key"></i>
                                        	找回密码
                                    </h4>
                                    <div class="space-6"></div>
                                    <p>
                                       	请输入邮箱验证
                                    </p>
                                    <form id="loginForm1" method="get" action="">
                                        <fieldset>
                                            <label class="block clearfix" style="height: 50px">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="email" id="email" class="form-control" placeholder="请输入邮箱" />
                                                    <i class="icon-envelope"></i>
                                                </span>
                                            </label>
                                            <div class="clearfix">
                                                <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                    <i class="icon-lightbulb"></i>
                                                   	 发送
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div><!-- /widget-main -->
                                <div class="toolbar center">
                                    <a href="#"  class="back-to-login-link backbox">
                                        	返回登录
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div><!-- /widget-body -->
                        </div><!-- /forgot-box -->
                    </div><!-- /position-relative -->
                  </div>
                </div>
              </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
<!-- /.main-container -->
</body>
</html>
<!--登录验证js-->
<script>

    $('#loginForm').validate({
        errorElement: 'div',
        errorClass: 'help-block',
            rules:{
                username: {
                    required: true,
                    minlength:2
                },
             //   parten:{
            //        required:true,
            //        minlength:4
           //     },
                password:{
                    required:true,
                    minlength:6
                }
            },
            messages:{
                username: {
                    required: "请输入用户名",
                    minlength: "用户名必需由两个字母组成"
                },
                password: {
                    required: "请输入密码",
//                  minlength: jQuery.format("密码不能小于{0}个字 符")
                }
             //   parten: {
               //     required:'请输入验证码',
             //       minlength:"验证码不能少于四位"
              //  }
            }

    });
    $('#loginForm1').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        rules:{
            email: {
                required: true,
                email: true
            }
        }
    });
    $('.showbox').click(function(event) {
        $('.login-update').hide();
        $('.forgot-box').show();

    });
    $('.backbox').click(function(event){
        $('.login-update').show();
        $('.forgot-box').hide();
    });
</script>