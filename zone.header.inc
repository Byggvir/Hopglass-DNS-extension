<?php
// Hopglass extension DNS zone file
// Thomas Arend
// thomas@freifunk-rheinbach.de

// This file defines the header for the zone file DNS (bind9).

include_once 'zone.conf.inc';

$serial=date($serial_date_format);

print <<<END
\$ORIGIN $domain.
\$TTL 3600     ; 2 days
@	IN SOA     nn.$domain. root.$domain. ( ; Adjust to your community
        $serial    ; serial
        10800      ; refresh (3 hours)
        3600       ; retry (1 hour)
        604800     ; expire (1 week)
        86400      ; minimum (1 day)
)
        IN	NS      nn.$domain.         ; Adjust to your community
        IN	MX      10 nn.$domain.      ; Adjust to your community
nn      A	10.152.112.1                ; Adjust to your community, see site.conf
        AAAA	2a03:2260:3017:1400::1  ; Adjust to your community, see site.conf
nextnode    CNAME   nn
mail    IN AAAA 2a03:2260:3017:1400::1  ; Adjust to your community

END;
?>
