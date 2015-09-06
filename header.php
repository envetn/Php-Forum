<!doctype html>  
<style>

</style>
<html lang='sv'>  
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>



	<meta charset="utf-8">
	<title> <?php echo "My website"; ?></title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<!-- href="http://localhost/style/stylesheet.css"-->
	<?php if(isset($pageStyle )) : ?> 
		<style type="text/css"> 
		<?php echo $pageStyle; ?> 
		</style> 
		<?php endif;?> 
	<link rel="shortcut icon" href="images/logoPhp.png"> 
	<!-- Dafuq is this? -->
		<script type="text/javascript">
 
			$(document).ready(function(){
 
				$('.lightbox').click(function(){
					$('.backdrop, .box').animate({'opacity':'.50'}, 300, 'linear');
					$('.box').animate({'opacity':'1.00'}, 300, 'linear');
					$('.backdrop, .box').css('display', 'block');
				});
 
				$('.close').click(function(){
					close_box();
				});
 
				$('.backdrop').click(function(){
					close_box();
				});
 
			});
 
			function close_box()
			{
				$('.backdrop, .box').animate({'opacity':'0'}, 300, 'linear', function(){
					$('.backdrop, .box').css('display', 'none');
				});
			}
 
		</script>


</head>
<body>
<nav class='forum_menu'>

	<a id='index-' href='../Stuff.php'>Hem </a>
	<a id='index-' href='index.php'>Forum </a>
	<a id='index-' href='gallery.php'>Gallery </a>
	<p><?php include("search.php");?></p> <!-- Should make this a function -->
</nav>


