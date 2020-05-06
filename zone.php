<?php

// Hopglass extension
// Thomas Arend
// thomas@freifunk-rheinbach.de

// Create a zone file for DNS (bind9) from /data/nodes.json on a hogglass client server.

header("Content-Type: text/plain");

include_once 'zone.conf.inc';

// load the header for the zonefile

include_once 'zone.header.inc';

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

// Compare hostnames of two nodes for usort

function cmp($a, $b)
{
    return strcmp($a['nodeinfo']['hostname'], $b['nodeinfo']['hostname']);
}

// Get nodes.json and convert it into an array.

$json = file_get_contents($json_url)
  or die ("Can not get file!");
  
$nodes = json_decode ($json,true)
  or die ("Json convert error");

// Sort the nodes after their hostname

usort($nodes['nodes'], "cmp");

// Check if nodes.json has version 2

if ( $nodes['version'] == 2 ) { 

  // We have a file with the right version. Lets do the work.
  // Create DNS AAAA and CNAME record for every node.

  foreach ( $nodes['nodes'] as $value ) {
  
    // A node may have multiple IP addresses
    // We use only the first non link address

    $c = count($value['nodeinfo']['network']['addresses']);
    
    // A node should have at least two ip address.
    // If we have only a link address "fe80::"
    // we will use this one.
    
    if ( $c > 0 ) {

      $ip = $value['nodeinfo']['network']['addresses'][0];
      
      // Find first non link IPv6 address 
      
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
      
      } // foreach prefix
    
    } // if c 
  
  } // for each nodes

} // end then 

else  {
  
  // Error message
  
  print ('Wrong nodes.json version. This script works only with version 2.') ;

};
// End if version 2 

?>
