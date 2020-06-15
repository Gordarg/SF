Installation Guide for Ubuntu Server (LAMP and Userinterface)
===

> We declared `USERNAMEHERE` as username
> and also `/home/USERNAMEHERE/snowframework` as project directory after git clone

# 0. Upgrade packages

```
sudo apt update
sudo apt upgrade
```

# 1. Install "Linux Apahce, MySQL, PHP Server" (LAMP Server)

```
sudo apt install tasksel
sudo tasksel install lamp-server
```

# 2. Change web server root

## File to edit
```
sudo vi /etc/apache2/apache2.conf
```

## Content to edit
```
<DocumentRoot /home/USERNAMEHERE/snowframework>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</DocumentRoot>
```

## File to edit
```
sudo vi /etc/apache2/sites-available/000-default.conf
```

## Content to edit
```
DocumentRoot /home/USERNAMEHERE/snowframework
```

## Add user to group

```
adduser ubuntu www-data
```

## Give group permssion to access files
> To prevent (HTTP Forbidden Error 403)

```
chmod g+rw -R /home/USERNAMEHERE/snowframework
chown www-data:www-data -R /home/USERNAMEHERE/snowframework
```

# 3. Initialize Database

## PASSWORD METHOD 1: set mysql password
```
sudo mysql_secure_installation
```

## PASSWORD METHOD 2: if METHOD 1 doesn't work
```
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'PASSWORDHERE';
```

## PASSWORD METHOD 3: if METHOD 2 doesn't work
> set password manually

### stop mysql service

```
sudo service mysql stop
```

### skip grant tables (step A)

edit the file:
```
sudo vi sudo vi /etc/mysql/mysql.conf.d/mysqld.cnf
```

add the line below in *[mysqld]* section:
```
skip-grant-tables
```

### restart the service

```
sudo service mysql restart
```

### connect to mysql command line interface

```
mysql -u root
```

### set password

```
mysql> use mysql;
mysql> UPDATE user SET authentication_string=password('PASSWORDHERE') WHERE user='root';
mysql> flush privileges;
```

### re-enable grant tables
comment out the line added in step A

## CREATE DATABASE

### connect to cli

```
mysql -u root -p
mysql> password: PASSWORDHERE
```

### create an empty database

```
mysql> create database snowframework;
mysql> use snowframework;
```

### run the database query

Copy and paste the code in file [db/db.my.sql](../db/db.my.sql)

# 4. Configure application

## USER INTERFACE CONFIG: Init config file and edit
```
cd /home/USERNAMEHERE/snowframework/userinterface
cp config.sample.php config.php
vi config.php
```

then set correct info


