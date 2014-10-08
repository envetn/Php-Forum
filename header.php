<!doctype html>  
<style>

</style>
<html lang='sv'>  
<head>
<body>
<meta charset="utf-8">
<title> <?php echo "My website"; ?></title>
<link rel="stylesheet" href="http://localhost/style/stylesheet.css" title="General stylesheet">

<?php if(isset($pageStyle )) : ?> 
    <style type="text/css"> 
    <?php echo $pageStyle; ?> 
    </style> 
    <?php endif;?> 
<link rel="shortcut icon" href="images/logoPhp.png"> 

<nav class='forum_menu'>

	<a id='index-' href='../Stuff.php'>Hem </a>
	<a id='index-' href='index.php'>Forum </a>
	<a id='index-' href='gallery.php'>Gallery </a>
</nav>