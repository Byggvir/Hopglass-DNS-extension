# Hopglass-DNS-extension
Extends Hopglass frontend to create zone files for bind9.

# Purpose

Managing your freifunk nodes with *ssh* its a bit boring. You have to use IPv6 addresses to address the nodes. One way to get the IPv6 addresses is to use the hopglass frontend and copy an paste the addresses.

To ease my life I set up a DNS-Server on an Raspberry Pi in my local network and create the required zone file from the *nodes.json* file on the map server.

# What you need

You need 

* access to a *nodes.json* file compatible with the hopglass *nodes.json* version 2,
* a DNS Server with zone files compatible with bind9 zone files,
* a PHP installed on your server.

I would prefer to install the PHP scripts on a Hopglass frontend or equivalent server. The script assume that the *nodes.json* is available in a sub-directory */data/* under *zone.php*.  

# Files

* zone.php: Returns the DNS zone file.
* zone.header.inc: Contains the header for a zone file
* zone.conf.inc: Allows to configure some variables.

# Installation

1. Change *zone.header.inc* and *zone.conf.inc* to your needs.
2. Copy the files *zone.** to the root directory of your Hopglass frontend.
3. Call */zone.php* and save it into */etc/bind/zones/xyz.zone* or wherever you store your zone-files.
4. restart *bind9* with *sudo systemctl restart bind9*

## Cronjob for regular updates

Insert a script file named *ff-zone-update* or whatever you like into */etc/crond.hourly* or */etc/crond.daily* to update the zone file every hour or every day.

<u>See Example: ff-zone-update</u>

<pre>
#!/bin/sh
#
# Simple cron script - get zone file for freifunk DNS
  wget -O /tmp/rhb.ff.zone map.freifunk-rheinbach.de/zone.php \
  && cp /tmp/rhb.ff.zone /etc/bind/zones/
  systemnctl restart bind9
</pre>

Be carefull: If the zone file contains errors it will not be loaded.

**Hint:** The serial in the zone file has the format "YmdH", where H is the hour. Updating more than once in an hour will not change the serial.

# Bind9 zone definition

You can define the Freifunk zone as folows:

<u>Example:</u>

<pre>
zone "rhb.ff" {
  type master;
  file "/etc/bind/zones/rhb.ff.zone";
  a llow-transfer { acl_trusted_transfer; };
};
</pre>

Change zone name and file name to your needs.

# Known caveats

* The script lacks a check for multiple routers with the same hostname.

# Example

You get a zone file for Freifunk Rheinbach under:

[map.freifunk-rheinbach.de/zone.php](http://map.freifunk-rheinbach.de/zone.php)

# Copyright

(c) 2018 Thomas Arend
thomas at freifunk-rheinbach.de
