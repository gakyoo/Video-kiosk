<?php //error_reporting(false); ?>
<html>
	<head>
		<title>Video</title>
		<link href="../css/style.css" rel="stylesheet" media="all" />
		<script type="text/javascript" src="../js/jquery.min.js" ></script>
		<script type="text/javascript">
			function confDel(url){
				if(confirm("Are you sure you want to delete user?")){
					return window.location = url;
				}
			}
			
			$("document").ready(function(){
				$('#password').hide();
				});
			function passForm(){
				$('#password').show();
			}
			function exitForm(){
				$('#password').hide();
			}
			
		</script>
		<style type="text/css">
			.msg{color:red; font-style:italic; font:12px sans-serif;}
			#right-pane{ width: 850px; }
			#left-pane{width: 200px; min-height: 50px;}
			#login-form{ float: right; }
		</style>
	</head>

<body>
	<div id="wrapper" >
		<div id="header">
			<img src='../icons/header.jpeg' width='100%'/>
			<div id='menu-bar'>
				<ul>
					<li><a href="../index.php">Home</a></li>
				</ul>
			 </div>
		</div><!-- end header -->
		
		<div id="content" >
