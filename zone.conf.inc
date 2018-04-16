<?php

  $domain="rhb.ff";
  $server="";
  $datapath=preg_replace("/zone.php/","",$_SERVER['PATH_INFO']) . '/data' ;

// If you use a prefix for the hostname and wish to use shorter names without the prefix
// you can put the prefix here.
 
  $hostname_prefix = 
    array ( 
      'su-rhb-',
      'su-snw-' 
  );

?>
