<?php  
// ===========================================================================================  
//  
// Filename: common.php  
//  
// Description: useful functions while building a website.  
//  
// Author: Mikael Roos, mos@bth.se  
//  
// Change history:  
//   
// 2011-02-04:   
// First try. Used as example code in htmlphp-kmom03.  
//  


// -------------------------------------------------------------------------------------------  
//  
// Get current url  
//  
function getCurrentUrl()  
 {  
  $url = "http";  
  $url .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';  
  $url .= "://";  
  $serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :  
    (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");  
  $url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars($_SERVER["REQUEST_URI"]);  
  return $url;  
}  


// -------------------------------------------------------------------------------------------  
//  
// Destroy a session  
//  
function destroySession()   
{  
  // Unset all of the session variables.  
  $_SESSION = array();  
    
  // If it's desired to kill the session, also delete the session cookie.  
  // Note: This will destroy the session, and not just the session data!  
  if (ini_get("session.use_cookies")) {  
      $params = session_get_cookie_params();  
      setcookie(session_name(), '', time() - 42000,  
          $params["path"], $params["domain"],  
          $params["secure"], $params["httponly"]  
      );  
  }  
    
  // Finally, destroy the session.  
  session_destroy();  
}  
// -------------------------------------------------------------------------------------------  
//  
// Function to open and read a directory, return its content as an array.  
//  
// $aPath: A path to the directory to scan for files.   
//   
//  http://php.net/manual/en/function.is-dir.php  
//  http://php.net/manual/en/function.opendir.php  
//  http://php.net/manual/en/function.readdir.php  
//  http://php.net/manual/en/function.is-file.php  
//  http://php.net/manual/en/function.closedir.php  
//  http://php.net/manual/en/function.sort.php  
//    
function readDirectory($aPath) {  
  $list = Array();  
  if(is_dir($aPath)) {  
    if ($dh = opendir($aPath)) {  
      while (($file = readdir($dh)) !== false) {  
        if(is_file("$aPath/$file") && $file != '.htaccess') {  
          $list[$file] = "$file";  
        }  
      }  
      closedir($dh);  
    }  
  }  
  sort($list, SORT_STRING);  
  return $list;  
}  


// -------------------------------------------------------------------------------------------  
//  
// Function to read a file and return its content.  
//  
// $aFilename: A filename with the whole path.   
//   
//  http://php.net/manual/en/function.is-readable.php  
//  http://php.net/manual/en/function.file-get-contents.php  
//    
function getFileContents($aFilename) {  
  if(is_readable($aFilename)) {  
    return file_get_contents($aFilename);  
  } else {  
    return "Filen finns ej.";  
  }  
}  


// -------------------------------------------------------------------------------------------  
//  
// Function to save content to a file and return the status of the operation.  
//  
// $aFilename: A filename with the whole path.   
// $aContent: The content to save.   
//   
//  http://php.net/manual/en/function.is-writable.php  
//  http://php.net/manual/en/function.file-put-contents.php  
//    
function putFileContents($aFilename, $aContent) {  
  if(is_writable($aFilename)) {  
    file_put_contents($aFilename, $aContent);  
    return "Filen sparades.";  
  } else {  
    return "Filen är inte skrivbar och kunde inte sparas.";  
  }  
}  



function figure($src, $size=null, $caption=null, $alt=null, $class=null) { 
  $srcOrig=$src; 
  if(isset($size)) { 
    $src = dirname($src) . '/' . $size . '/'. basename($src);  
  } 
  $alt = isset($alt) ? "alt='[Bild] $alt'" : null; 
  $class = isset($class) ? "class='$class'" : null; 
  return <<<EOD
<figure > 
  <a href="{$srcOrig}"><img style="max-height:100%;max-width:100%;" src="{$src}" {$alt} alt="pic"></a> 
   
    <p><a href="#$src" title="Direktlänk till denna bild" ></a> </p> 
  
</figure>   
EOD;
} 
