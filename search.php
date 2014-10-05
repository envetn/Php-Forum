
<style>

#returnForm{
width:80%;
padding-left:20%;
}
.staticValResult{
font-size:20px;
}
</style>
<?php

$searchVal = "";
if(isset($_GET['Submit']) && isset($_GET['q1'])){
	$searchVal = $_GET['searchValue'];
	$greedy = $_GET['q1'];
	$returnVal = searchPost($searchVal,$greedy);

}
?>

<form method='get'>
<p> Search: <input type='text' name='searchValue' value='<?=$searchVal?>'/>
<input type='submit' name='Submit' value='Search'></p>
<p> Greedy search :<input type='radio' name="q1" value="1">Yes<input TYPE="radio" name="q1" value="0">No</p>

</form> 
<div id='returnForm'>
<?php if(isset($returnVal)){
	echo $returnVal;
}
?>
</div>
