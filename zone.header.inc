<?php
// Hopglass extension DNS zone file
// Thomas Arend
// thomas@freifunk-rheinbach.de

// This file defines the header for the zone file DNS (bind9).

?>
$ORIGIN .
$TTL 172800     ; 2 days
rhb.ff                  IN SOA  svr1.rhb.ff. root.rhb.ff. (
<?php
  print ( "\t\t" . date("YmdH") . " ; serial\n" );
?>
                                10800      ; refresh (3 hours)
                                3600       ; retry (1 hour)
                                604800     ; expire (1 week)
                                86400      ; minimum (1 day)
                                )
                        NS      ns1.rhb.ff.
                        MX      10 mail.rhb.ff.
$ORIGIN rhb.ff.
ns1                     A       192.168.2.3
mail                    A       192.168.2.3
svr1                    A       192.168.2.2
