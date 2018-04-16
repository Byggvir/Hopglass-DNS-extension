# Hopglass-DNS-extension
Extends Hopglass frontend to create zone files for bind9

## Purpose

Managing your freifunk nodes with ssh its a bit boring. You have to use IPv6 addresses to address the nodes. One way is to get the IPv6 addresses is to use the hopglass frontend and copy an paste the addresses.

To ease my life I set up a DNS-Server on an Raspberry Pi and create the required zone file from the nodes.json file.

## Files

* zone.php: Returns the DNS zone file.
* zone.header.inc: Contains the header for a zone file
* zone.conf.inc: Allows to configure some variables.

## Installation

1. Change zone.header.in and zone.conf.inc to your needs
2. Copy the files zone.* to the root directory of the Hopglass.
3. Call .../zone.php

## Copyright

(c) 2018 Thomas Arend
thomas at freifunk-rheinbach.de
