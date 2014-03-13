Pyrocms-shop-monitoring
=======================

Pyrocms module for the shop monitoring

The bin folder contains the perl scripts to get the status of availability of devices and service providers of shops

bin/cron.cgi use:

Monitoring the local network of the shop item:

/usr/bin/perl /path/to/modules/monitoring/bin/cron.cgi -local

Monitoring the external network of the shop item:

/usr/bin/perl /path/to/modules/monitoring/bin/cron.cgi -ext