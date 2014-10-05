<style>
#forum_wrapper
{
 width:800px;
 margin-left:auto;
 margin-right:auto;
}

</style>
<?php

include('../include/header.php');




?>
<div id="forum_wrapper">
<h2> Forum - reply post</h2>
<p> Basic login</p>
	<div id="content">
	<form action="create_user_parse.php" method="post">
	<p>username</p>
	<input type='text' name='user_name' size='28' maxlength='150'/>
	<p>password</p>
	<input type='text' name='user_password' size='28' maxlength='150'/>
	<p>Email</p>
	<input type='text' name='user_email' size='28' maxlength='150'/><br/>
	<input type="radio" name="email_notify" value="Yes">Yes<br/>
	<input type="radio" name="email_notify" value="No">No<br/>
	
	
	<input type='submit' name='user_submit' value='Create user' />
	</div>
</div>