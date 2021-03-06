<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/bootstrap.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/pages.css" />
    <title>图书管理系统</title>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=base_url()?>">i-Library</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li<?php echo ($page == 'index')? " class='active'": "";?>><a href="<?=base_url()?>">首页</a></li>
					<li<?php echo ($page == 'fresh')? " class='active'": "";?>><a href="<?=base_url()?>fresh">新书上架</a></li>
					<li<?php echo ($page == 'search')? " class='active'": "";?>><a href="<?=base_url()?>search">图书查询</a></li>
					<li<?php echo ($page == '#')? " class='active'": "";?>><a href="#contact">Contact</a></li>
				</ul>
                <ul class="nav navbar-nav navbar-right">
					<?php 
					   if ($userName)
					   {
					       echo    "<li class='dropdown'>
                                        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                                            $userName
                                            <span class='caret'></span>
                                        </a>
                                        <ul class='dropdown-menu' role='menu'>
									       <li class='dropdown-header'>用户控制</li>
									       <li><a href='#'>个人信息</a></li>
									       <li><a href='". base_url(). "admin/record_user'>借阅记录</a></li>
									       <li><a href='#'>账户安全</a></li>
									       <li class='divider'></li>
									       <li><a href='". base_url(). "user/do_logout'>安全退出</a></li>
								        </ul>
                                    </li>";
					       if ($userType == 2)
					       {
					           echo    "<li><a href='admin'>管理系统入口</a></li>";
					       }
					   }
					   else
					   {
					       echo    "<li><a href='login'>登陆</a></li>
					                <li><a href='register'>注册</a></li>";
					   }
					?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>