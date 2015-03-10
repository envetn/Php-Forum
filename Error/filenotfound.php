<?php
include('../header.php');
include("../config.php");
include("../database.php");
$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);
echo displayErrorMessage("HAHA, YOU HAVE NO POWER HERE!");
?>