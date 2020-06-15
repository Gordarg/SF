# Download the database script

Use the following script to generate database form script: [my.sql](Download/my.sql)


# Database sampling

mysql -u root -pPASSWORDHERE --xml -e 'use snowframework; select * from posts order by Id desc limit 10000'>posts.xml

# Fast database dump

mysqldump --host="localhost" --user="root" --password="PASSWORDHERE" snowframework > /home/usenramehere/snowframework/db/dump_JUNE_04_2020.sql