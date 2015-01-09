<?php

?>
<html>
<head>
<title>Admin</title>
<style>
<!-- Style grid -->
.grid:after{
clear:both;
content:'';
display: table;}

[class*='c-']{
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
float:left;}

.clearfix{
		  clear:both;
}

.c-top-panel{
	width:100%;
	text-align:center;
	border:1px solid #eee;
	margin:1% 0;
}
.c-left-panel{
	width:21%;
	text-align:center;
	border:1px solid #eee;
	margin:1% 0;
}
.c-content{
	width:78%;
	text-align:center;
	border:1px solid #eee;
	margin:1% 0 1% 1%;
}
.c-footer{
	width:100%;
	text-align:center;
	border:1px solid #eee;
	margin:1% 0;
}

body{
	padding:1%;
}

.title{
	color: #575757;
	text-decoration: underline;
	font-weight: bold;
	margin: 2px;
	background-color: #eee;
}

</style>
</head>
<body clss="grid">
	<div class="c-top-panel"><div class="title"><?=App::$params['app_name']?></div></div>
	<div class="c-left-panel"><div class="title"><?=App::$params['app_name']?></div>
		<div><a href="/admin/?r=menu">Menu</a></div>
		<div><a href="/admin/?r=content">Content</a></div>
	</div>
	<div class="c-content"><div class="title">Content</div>
	<div>
		<?=pastData()?>
	</div>
	</div>
	<div class="c-footer"><div class="title">Footer</div></div>
</body>
</html>