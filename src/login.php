<?php 
// =========================================================================================== 
// 
// Origin: http://github.com/mosbth/Utility 
// 
// Filename: login.php 
// 
// Description: Provide a set of functions to enable login & logout on a website. 
// 
// Author: Mikael Roos, mos@bth.se 
// 
// Change history: 
//  
// 2011-01-26:  
// First try. Used as example code in htmlphp-kmom03. 
// 


// ------------------------------------------------------------------------------------------- 
// 
// Is user authenticated and logged in? 
// 
function userIsAuthenticated() { 
  if(isset($_SESSION['authenticated'])) { 
    return $_SESSION['authenticated']; 
  } else { 
    return false; 
  } 
} 


// ------------------------------------------------------------------------------------------- 
// 
// create the login/logout menu 
// 
function userLoginMenu() { 
  // array with all menu items 
  $menu = array( 
    "login"   => "userLogin.php", //"login.php?p=login" 
          //   "status"   => "login.php" 
    "logout"   => "userLogin.php",   
  ); 

  // check if user is logged in or not, alter the menu depending on the result 
  if(userIsAuthenticated()) { 
    unset($menu['login']); 
  } else { 
    unset($menu['status']); 
    unset($menu['logout']);       
  } 
   
  $html = "<nav class='login'>"; 
  foreach($menu as $key=>$val) { 
    $html .= "<a href='$val'>$key</a> "; 
  } 
  $html .= "</nav>"; 
  return $html; 
} 


// ------------------------------------------------------------------------------------------- 
// 
// Get login-form 
// 
function userLoginForm($output=null, $outputClass=null) { 

  if(isset($output)) { 
    $output = "<p class='right' style='width:300px;'><output class='$outputClass'>$output</output></p>"; 
  } 

  $disabled = null; 
  $disabledInfo = null; 
  if(userisAuthenticated()) { 
    $disabled = "disabled"; 
    $disabledInfo = "<em class='quiet small'>Inloggad<br/> <a href='?p=logout'>logga ut</a> </em>"; 
  } 
$html = <<<EOD

<form method="post" action="?p=login"> 

    <p> 
      <label for="input1">Användarkonto:</label> 
      <input id="input1" class="text" type="text" name="account"> 
    </p> 
   
   <p> 
      <label for="input2">Lösenord:</label> 
      <input id="input2" class="text" type="password" name="password"> 
    </p> 
   
    <p> 
      <input type="submit" name="doLogin" value="Login" $disabled> 
      $disabledInfo 
    </p> 
   
</form> 
EOD;


  return $html; 
} 


// ------------------------------------------------------------------------------------------- 
// 
// Login the user 
// 
function userLogin() { 
  global $userAccount, $userPassword; 
  // if form is submitted then try to login 
  // $_POST['doLogin'] is related to the name of the login-button 
  $output=null; 
  $outputClass=null; 
  if(isset($_POST['doLogin'])) { 
   
    // does account and password match? 
    if($userAccount == $_POST['account'] && $userPassword == userPassword($_POST['password'])) { 
      
      $outputClass = "success"; 
      $_SESSION['authenticated'] = true;  
    } else { 
      $output = "Du lyckades ej logga in. Felaktigt konto eller lösenord."; 
      $outputClass = "error"; 
    } 
  } 
   
  return userLoginForm($output, $outputClass); 
} 


// ------------------------------------------------------------------------------------------- 
// 
// Logout the user 
// 
function userLogout() { 
  unset($_SESSION['authenticated']); 
  return "<p>Du är nu utloggad.</p>"; 
} 


// ------------------------------------------------------------------------------------------- 
// 
// Generate a password 
// 
function userPassword($password) { 
  return sha1($password); 
} 
