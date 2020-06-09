SnowFramework
===

![Tag](https://img.shields.io/github/tag-date/Gordarg/SnowFramework.svg)
![Release](https://img.shields.io/github/release/Gordarg/SnowFramework.svg)
![License](https://img.shields.io/github/license/Gordarg/SnowFramework.svg)
[![Donate](https://img.shields.io/badge/give-donation-yellow.svg)](https://zarinp.al/@tayyebi)
![Languages](https://img.shields.io/github/languages/count/Gordarg/SnowFramework.svg
)
![Downloads](https://img.shields.io/github/downloads/Gordarg/SnowFramework/total.svg)
![Issues](https://img.shields.io/github/issues/Gordarg/SnowFramework.svg)
![Pull requests](https://img.shields.io/github/issues-pr/Gordarg/SnowFramework.svg)
![Commit activity](https://img.shields.io/github/commit-activity/w/Gordarg/SnowFramework.svg)
![Gordarg followers](https://img.shields.io/github/followers/Gordarg.svg?style=social)
![Stars](https://img.shields.io/github/stars/Gordarg/SnowFramework.svg?style=social)
![Forks](https://img.shields.io/github/forks/Gordarg/SnowFramework.svg?style=social)
![Watchers](https://img.shields.io/github/watchers/Gordarg/SnowFramework.svg?style=social)

Director: Mohammad R. Tayyebi <smile@tyyi.net>



# Installation notes

## Install Apache-MySQL-PHP

```
apt install tasksel
tasksel install lamp-server
```

## Configure MySQL

```
mysql_secure_installation
```

## Check apache installation

```
cd /var/www/html
vi index.php
```
> `<?php phpinfo(); ?>`
```
wget http://localhost/index.php
```

## Check the php version

```
php --version
```

## Create database

```
mysql> CREATE DATABASE `SF2`;
```

## Execute database query

From file `my.sql` [ > Download](docs/Download/my.sql)

## Change config file and set yout cridentials

Copy `Core/Config.Sample.php` to `Core/Config.php`;
then edit the `Core/Config.php`.

also set `baseurl` (website root) in `static/js/config.js`.

# **How to contribute on project :**

0- Install git from git-scm.com

1- Make a **Fork** of the repository

2- **Clone** the project on your machine

3- Change whatever you want

4- Commit your changes

5- **Pull** before push(Notice that you have to choose **Pull From** the main project.)

6- Push

7- Make a **pull request**

8- Tell us your notes

9- Your commits will be merged after review by developers of master branch

# Documentation
All related documentation is located at **[docs/](http://gordarg.github.io/SF)**.