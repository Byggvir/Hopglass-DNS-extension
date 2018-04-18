<?php
// Hopglass extension DNS zone file
// Thomas Arend
// thomas@freifunk-rheinbach.de

// This file defines the header for the zone file DNS (bind9).

include_once 'zone.conf.inc';

$serial=date($serial_date_format);

print <<<END
\$ORIGIN .
\$TTL 172800     ; 2 days
$domain     IN SOA      pi1.$domain. root.pi1.$domain. (
        $serial    ; serial
        10800      ; refresh (3 hours)
        3600       ; retry (1 hour)
        604800     ; expire (1 week)
        86400      ; minimum (1 day)
)
        NS      pi1.$domain.
        MX      10 pi1.$domain.
\$ORIGIN $domain.
pi1     A       192.168.2.3
pi1     AAAA    fda0:747e:ab29:2241:6018:26ff:fe71:4253

END;
?>