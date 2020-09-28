## Authenticaition

Edit **.htaccess** for default **.htpasswd** file directory.

Then set the permissions to

```
chmod 644 .htaccess
chmod 644 .htpasswd
```

To create **.htpasswd** for the first time:

```
htpasswd -c /var/www/html/Sariab-V2/.htpasswd tayyebi
```
