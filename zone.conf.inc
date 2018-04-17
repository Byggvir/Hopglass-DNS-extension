<?php

// Replace with your domain. 
// Hint: "ff." is a currentlty unused TLD.
  
  $domain="rhb.ff";
    
// Get server running the script

  if ($server == "" ) { 
    $server=$_SERVER['SERVER_NAME'];
  }  
  
// Update to your needs when the server with nodes.json
// differs from the server running zone.php.
  
  $json_server=$server;
   
  if ( $proto == "" ) {
    if ( $_SERVER['HTTPS'] == "" ) {
      $proto="http://";
    }
    else {
    $proto="https://";
    }
  }
  
  $json_proto=$proto;
  
// Replace with the datapath for the nodes.json file when it's not in a sub-directory /data 
  
  $data_path=preg_replace("/zone.php/","",$_SERVER['PATH_INFO']) . '/data' ; 

  $json_data_path=$data_path;
  
// Replace with your name of the nodes.json file
  
  $json_nodes="/nodes.json";

// Repace with your url when it differs from the assumed URL of your nodes.json  
// $json_url is the URL where zone.php tries to read a nodes.json compatible file from.

  $json_url = $json_proto . $json_server . $json_data_path . $json_nodes ;

// If you use a prefix for the hostname and wish to use shorter names without the prefix
// you can define the prefixes here.
 
  $hostname_prefix = 
    array ( 
      'su-rhb-',
      'su-snw-' 
  );

?>
