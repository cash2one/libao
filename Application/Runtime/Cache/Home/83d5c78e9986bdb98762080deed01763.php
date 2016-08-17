<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>导入礼包</title>
		<link rel="stylesheet" href="/libao/Public/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/libao/Public/css/ace.min.css" />
		<link rel="stylesheet" href="/libao/Public/css/font-awesome.min.css" />
		<link rel="stylesheet" href="/libao/Public/css/main.css" />
		<script type="text/javascript" src="/libao/Public/js/jquery-2.2.4.min.js" ></script>
	</head>
	<body>
		<div class="navbar navbar-default index-header-bar" id="navbar">
			<script type="text/javascript">
				try {
					ace.settings.check('navbar', 'fixed')
				} catch (e) {}
			</script>
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand index-header-logo">
                       <lable>后台管理</lable> 
					</a>
				</div>
			</div>
		</div>

	    <div class="main-container-inner main-container">
	        <a class="menu-toggler" id="menu-toggler" href="#">
	            <span class="menu-text"></span>
	        </a>
	        <div class="sidebar" id="sidebar">
		        <script type="text/javascript">
		            try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
		        </script>
		        <ul class="nav nav-list">
		            <li class="active">
		                <a href="wechatGiftbagIndex.html">
		                    <i class="icon-dashboard"></i>
		                    <span class="menu-text"> 公众号礼包 </span>
		                </a>
		            </li>
		                
		        </ul><!-- /.nav-list -->
		
		        <script type="text/javascript">
		            try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
		        </script>
	    	</div>
	        <div class="main-content">
		        <div class="breadcrumbs" id="breadcrumbs">
		            <script type="text/javascript">
		                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		            </script>
		            <ul class="breadcrumb">
		                <li>
		                    <i class="icon-dashboard"></i>
		                    <span><a href="<?php echo U('Home/Record/lists');?>">公众号礼包</a></span>
		                </li>
		                <li class="active">导入礼包</li>
		            </ul>
		        </div>
		        <div class="page-content padding-top" id="organization-detail">
		        	<div class="tabbable">
						<ul class="nav nav-tabs padding-12 tab-color-blue background-blue " id="myTab4">
							<li class="active">
								<a data-toggle="tab" href="#profile5">导入礼包</a>
							</li>
						</ul>
					</div>
					<div class="tab-content">
						<div id="profile5" class="tab-pane in active row">
				            <form class="form-horizontal importPackage col-sm-10 step1-margin show" action="<?php echo U('Home/Index/importAgainDeal');?>" method="POST" enctype="multipart/form-data" novalidate="novalidate">
								<div class="form-group">
		                            <label class="control-label col-sm-2 control-label" >游戏名称：</label>
		                            <div class="col-sm-10">
		                                <span><?php echo ($list["game_name"]); ?></span>
		                                <input type="hidden" id="gameName" name="gamaname" value="">
		                            </div>
		                        </div>
								<div class="form-group">
		                            <label class="control-label col-sm-2 control-label" >礼包名称：</label>
		                            <div class="col-sm-10">
		                                <span><?php echo ($list["gift_name"]); ?></span>
		                                <input type="hidden" id="giftName" name="giftsid" value="<?php echo ($list["giftsid"]); ?>">
		                            </div>
		                        </div>
		
								<div class="form-group">
		                            <label class="control-label col-sm-2 control-label" >领取口令：</label>
		                            <div class="col-sm-10">
		                                <span><?php echo ($list["token"]); ?></span>
		                                <input type="hidden" id="getCode" name="token" value="">
		                            </div>
		                        </div>
		
								<div class="form-group">
		                            <label class="control-label col-sm-2 control-label" >礼包内容：</label>
		                            <div class="col-sm-10">
		                                <span><?php echo ($list["content"]); ?></span>
		                                <input type="hidden" id="packageContent" name="content" value="">
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-sm-2 control-label" >使用说明：</label>
		                            <div class="col-sm-10">
		                                <span><?php echo ($list["shuoming"]); ?></span>
		                                <input type="hidden" id="packageContent" name="content" value="">
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label class="control-label col-sm-2 control-label" >适用平台：</label>
		                            <div class="col-sm-10">
		                                <span><?php echo ($list["platform"]); ?></span>
		                                <input type="hidden" id="packageContent" name="content" value="">
		                            </div>
		                        </div>
								<div class="form-group">
		                            <label class="control-label col-sm-2 control-label" >有效期：</label>
		                            <div class="col-sm-10">
		                                <span><?php echo ($list["endtime"]); ?></span>
		                                <input type="hidden" id="time" name="endtime" value="">
		                            </div>
		                        </div>
		                        <div class="form-group micro-form-group">
									<label class="control-label col-sm-2 control-label" for="id-input-file-3">选择文件：</label>
									<div class="col-sm-10">
										<div class="clearfix">
											<input class="upload" type="file" name="file"/>
											<!-- <input type="button" value="上传" class="btn btn-default btn-radius padding-12"> -->
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2"">
										<button type="submit" class="btn-radius padding-12 btn btn-default">确定</button>
									</div>
								</div>
							</form>
						</div>	
					</div>
        		</div>			
			</div>
	    </div>
		
	</body>
</html>