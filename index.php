
<?php
$num = 5;
$location = 'tree';

$format = 'There are %d monkeys in the %s';
echo sprintf($format, $num, $location) . "<br/>";
?>
<?php

$a = "binero";
$b = "jultomte";
$c = levenshtein($a,$b)+crc32(sprintf("%u",$b));
$d = str_split($a.$b,4);
$e = sha1($c.$d[2]);
echo $e."\n" . $c . "<br/>" . "5D41402ABC4B2A76B9719D911017C592" ;
var_dump($d);
?>


<?php
 session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
echo displayUserInfo();


/*

*/
?>

<div id="forum_wrapper">
<h2> Forum of forums</h2>
<!--<a href='search.php'>Search </a>-->
<?php
include("search.php");
$userC ="";



?>
<hr/>

<div id="content">
<?php
	include_once("connect_db.php");
	$sql = "SELECT * FROM	categories ORDER BY category_title ASC;";
	$res = mysql_query($sql) or die(mysql_error());
	$categories = "";
	if(mysql_num_rows($res) > 0)
	{
		while($row = mysql_fetch_assoc($res))
		{
		
			$id = $row['id'];
			$title = $row['category_title'];
			$description = $row['category_description'];
			$categories .= "<a class='cat_links' href='view_cat.php?cid=".$id."'>{$title}<font size='-1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {$description}</font></a>";
		}
		echo $categories;
	}
	else
	{
		echo "<p>No categories avaliable</p>";
	}
	
	echo $userC;
	
	$widthYes = 22;
	$widthNo = 2;
	$widthDo = 32;
	$score = 200;
	$i = 2;
?>
</div>

</body>
</html>