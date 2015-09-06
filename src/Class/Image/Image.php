<?php

	class Image{
	
	

/** 
 * Display error message. 
 * 
 * @param string $message the error message to display. 
 */ 
function errorMessage($message) { 
  header("Status: 404 Not Found"); 
  die('img.php says 404 - ' . htmlentities($message)); 
} 



/** 
 * Display log message. 
 * 
 * @param string $message the log message to display. 
 */ 
public function verbose($message) { 
  echo "<p>" . htmlentities($message) . "</p>"; 
} 



/** 
 * Output an image together with last modified header. 
 * 
 * @param string $file as path to the image. 
 * @param boolean $verbose if verbose mode is on or off. 
 */ 
public function outputImage($file, $verbose) { 
  $info = getimagesize($file); 
  !empty($info) or errorMessage("The file doesn't seem to be an image."); 
  $mime   = $info['mime']; 

  $lastModified = filemtime($file);   
  $gmdate = gmdate("D, d M Y H:i:s", $lastModified); 

  if($verbose) { 
    $this->verbose("Memory peak: " . round(memory_get_peak_usage() /1024/1024) . "M"); 
    $this->verbose("Memory limit: " . ini_get('memory_limit')); 
    $this->verbose("Time is {$gmdate} GMT."); 
  } 

  if(!$verbose) header('Last-Modified: ' . $gmdate . ' GMT'); 
  if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified){ 
    if($verbose) { verbose("Would send header 304 Not Modified, but its verbose mode."); exit; } 
    header('HTTP/1.0 304 Not Modified'); 
  } else {   
    if($verbose) { verbose("Would send header to deliver image with modified time: {$gmdate} GMT, but its verbose mode."); exit; } 
    header('Content-type: ' . $mime);   
    readfile($file); 
  } 
  exit; 
} 



/** 
 * Sharpen image as http://php.net/manual/en/ref.image.php#56144 
 * http://loriweb.pair.com/8udf-sharpen.html 
 * 
 * @param resource $image the image to apply this filter on. 
 * @return resource $image as the processed image. 
 */ 
public function sharpenImage($image) { 
  $matrix = array( 
    array(-1,-1,-1,), 
    array(-1,16,-1,), 
    array(-1,-1,-1,) 
  ); 
  $divisor = 8; 
  $offset = 0; 
  imageconvolution($image, $matrix, $divisor, $offset); 
  return $image; 
} 
}
?>