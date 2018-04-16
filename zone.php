<?php

// Hopglass extension
// Thomas Arend
// thomas@freifunk-rheinbach.de

// Create a zone file for DNS (bind9) from /data/nodes.json on a hogglass client server.

include_once 'zone.conf.inc';

// load the header for the zonefile

include_once 'zone.header.inc';

// if $server is not set in zone.conf.inc use SERVER_NAME from request

if ($server == "" ) { 
  $server=$_SERVER['SERVER_NAME'];
}  

if ( $proto == "" ) {
  if ( $_SERVER['HTTPS'] == "" ) {
    $proto="http://";
  }
  else {
    $proto="https://";
  }
}

// Gluon setup allow more characters in a hostname then DNS
// Therefore we must convert the hostname into an legal DNS hostname
 
function legal_hostname ($name)
{
  // Replace illegal chars with '-'
  // Replace illegal '-' from start and end of name
  // Replace multiple '-' with one '-' 

  $host = preg_replace("/[^a-z0-9-]/","-",strtolower($name));
  $host = preg_replace("/^-*/","",$host); // strip illegal '-' from start 
  $host = preg_replace("/-*$/","",$host); // strip illegal '-' from end 
  $host = preg_replace("/--+/","-",$host); // replace multiple '-' by one 

  return $host;

}

// Get nodes.json and convert it into an array.
$json = file_get_contents('http://' . $server . $datapath . '/nodes.json')
  or die ("Can not get file!");
$nodes = json_decode ($json,true)
  or die ("Json convert error");

// Check if nodes.json has version 2
if ( $nodes['version'] == 2 ) { 

  // We have a file with the right version

  // Create DNS AAAA and CNAME record vor every node.

  foreach ( $nodes['nodes'] as $value ) {
  
    // A node may have multiple IP addresses
    // We use only the first non local address

    $c = count($value['nodeinfo']['network']['addresses']);

    if ( $c > 0 ) {

      $ip = $value['nodeinfo']['network']['addresses'][0];
      
      // Find first non local IPv6 address 
      $i = 1 ;
      while ( $i < $c and substr($ip,0,6) == "fe80::" ) {
     
        $ip = $value['nodeinfo']['network']['addresses'][$i];
        $i = $i+1;
      }
  
      // Convert hostname into a legal hostname
      $hostname = legal_hostname($value['nodeinfo']['hostname']);
 
      // Print a AAAA record 
  
      print ( $hostname . "\t\t\tAAAA\t" . $ip . "\n");
  
      // Print a CNAME record without sites hostname prefix
 
      foreach ( $hostname_prefix as $prefix ) {
        $cname=preg_replace("/".$prefix."/","",$hostname);
        if ( $cname != $hostname ) {
          print ( $cname . "\t\t\tCNAME\t" . $hostname . "\n");
        } // if cname
      } // for each prefix
    } // if c 
  } // for each nodes
} // end then 

else  {
  // Error message 
  print ('Wrong nodes.json version. This script works only with version 2.') ;
};
// End if version 2 

?>
