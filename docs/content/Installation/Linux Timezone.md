# Set date manually

sudo date +%Y%m%d -s "20190502"
sudo date +%T -s "12:33:00"

# Change time zone

sudo mv /etc/localtime /etc/localtime.backup
sudo ln -s /usr/share/zoneinfo/Asia/Tehran /etc/localtime

> Note: Restart MySQL to apply the changes

# NTP

sudo yum install ntp ntpdate ntp-doc

sudo chkconfig ntpd on

sudo ntpdate ntp.example.com

sudo systemctl start ntpd

sudo vi /etc/ntp.conf

# Check MySQL Date

SELECT @@global.time_zone, @@session.time_zone;

select timediff(now(),convert_tz(now(),@@session.time_zone,'+00:00'));


