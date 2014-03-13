#!/usr/bin/perl -w

use Net::Ping;
use POSIX qw/strftime/;
use strict;
use warnings;
use DBI;
use Data::Dumper;

my ($arg) = $ARGV[0];
my $base = 'web_sms'; #you database
my $user = 'web_sms'; #sql user
my $password = 'Aa123456'; #sql password

my $dbh = DBI->connect('DBI:mysql:web_sms', 'web_sms', 'Aa123456') || die "Could not connect to database: ", $DBI::errstr;

if(defined $arg and $arg eq "-local")
{
	my $sth = $dbh->prepare('SELECT ip FROM default_monitoring_local_networks');
	$sth->execute();
	while (my @row = $sth->fetchrow_array) { 
		my @ips = $row[0];
		foreach my $ip (@ips)
		{
			my $p = Net::Ping->new("icmp", 1, 5);
			if ($p->ping($ip))
			{
				$dbh->do("UPDATE default_monitoring_local_networks SET state = '1' WHERE ip LIKE '$ip'");
				print $ip . " OK\n";
			}
			else
			{
				$dbh->do("UPDATE default_monitoring_local_networks SET state = '0' WHERE ip LIKE '$ip'");
				print $ip . " Fail\n";
			}
		}
	}
}
elsif (defined $arg and $arg eq "-ext")
{
	my $sth = $dbh->prepare('SELECT ip FROM default_monitoring_networks');
	$sth->execute();
	while (my @row = $sth->fetchrow_array) { 
		my @ips = $row[0];
		foreach my $ip (@ips)
		{
			my $p = Net::Ping->new("icmp", 1, 5);
			if ($p->ping($ip))
			{
				$dbh->do("UPDATE default_monitoring_networks SET state = '1' WHERE ip LIKE '$ip'");
				print $ip . " OK\n";
			}
			else
			{
				$dbh->do("UPDATE default_monitoring_networks SET state = '0' WHERE ip LIKE '$ip'");
				print $ip . " Fail\n";
			}
		}
	}
}
else
{
	print "arg is not specified \n";
}