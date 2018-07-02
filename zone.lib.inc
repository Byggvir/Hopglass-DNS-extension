<?php


// Restrict the Domain Name 

function legal_dnsname ($name)
{
  // Replace illegal chars with '-'
  // Replace illegal '-' from start and end of name
  // Replace multiple '-' with one '-' 

  $temp = preg_replace("/[^a-z0-9-\.]/","-",strtolower($name));
  $temp = preg_replace("/^[-\.]*/","",$temp); // strip illegal '-' from start 
  $temp = preg_replace("/[-\.]*$/","",$temp); // strip illegal '-' from end 
  $temp = preg_replace("/--+/","-",$temp); // replace multiple '-' by one 
  $temp = preg_replace("/\.\.+/",".",$temp); // replace multiple '.' by one 
  $temp = preg_replace("/\.-*/",".",$temp); // strip illegal '-' from start of level
  $temp = preg_replace("/-*\.$/",".",$temp); // strip illegal '-' from end of level

  return $temp;

}

// Gluon setup allow more characters in a hostname then DNS
// Therefore we must convert the hostname into an legal DNS hostname
 
function legal_hostname ($name)
{
  // Replace illegal chars with '-'
  // Replace illegal '-' from start and end of name
  // Replace multiple '-' with one '-' 

  $temp = preg_replace("/[^a-z0-9-]/","-",strtolower($name));
  $temp = preg_replace("/^-*/","",$temp); // strip illegal '-' from start 
  $temp = preg_replace("/-*$/","",$temp); // strip illegal '-' from end 
  $temp = preg_replace("/--+/","-",$temp); // replace multiple '-' by one 

  return $temp;

}


?>
