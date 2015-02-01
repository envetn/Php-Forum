<?php

session_start();
	include('header.php');
	include('config.php');
	include("database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

?>
<div id="forum_wrapper">
<h2> Forum - Create user</h2>
		
  <form action="parse/create_user_parse.php" method="post">
	<table>
       <tr>
          <td><label> Username </label></td>
          <td><input type='text' name='user_name' size='28' maxlength='150'/></td>
        </tr>
        <tr>
            <td><label> Password </label></td>
            <td> <input type='password' name='user_password' size='28' maxlength='150'/></td>
        </tr>
		<tr>
			<td><label>E-mail </label></td>
			<td><input type='text' name='user_email' size='28' maxlength='150'/></td>
		</tr>
		<tr>
			<td><label>Image </label></td>
			<td><input type='text' name='user_Image' size='28' maxlength='150'/></td>
		</tr>
		<tr>
			<td><label>notification </label></td>
			<td><input type="radio" name="email_notify" value="Yes">Yes</td>
			<td><input type="radio" name="email_notify" value="No">No</td>
		<tr>
        <tr>
            <td colspan="2"><input type="submit" value="submit" name='user_submit'/></td>
        </tr>
    </table>
  </form>
</div>