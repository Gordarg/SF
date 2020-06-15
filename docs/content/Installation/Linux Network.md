# To block IP address

```
sudo iptables -A INPUT -s 5.160.195.56 -j DROP
```

# To revoke block IP address

```
sudo iptables -D INPUT -s 5.160.195.56 -j DROP
```