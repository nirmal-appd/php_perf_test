PHP Performance Testing

Application for PHP performance Testing

Requisites to run the application

1.  Apache Server set up to serve PHP files
2.  PHP
3.  MySQL Database installed on your end.
4.  Redis Cache Server on default port 6379

Following modules have been included:
1.  DB Module which has a CRUD functionality
2.  PHP-Redis Cache
3.  REST API Module

Run the application on your browser.
Point to the following endpoints:

<b>DB Module Endpoint</b>

    1.  http://your-server-ip/php_perf_test/DB_CRUD/src/ReadWriteDb.php

Following actions will be performed.

Create Table,

Insert into Table,

Read from Table,

Update table records,

Delete table records,

DROP Table

<b>REDIS CACHE ENDPOINT</b>

    2.  http://your-server-ip/php_perf_test/REDIS/src/RedisOperations.php

Following actions can be performed:
Write to Redis Cache,
Read from Redis-Cache,
Print Data


<b>REST API ENDPOINT</b>

     3.  http://your-server-ip/php_perf_test/rest_api/src/employee/read/1 //Only read URL provided here as sample
   

Following actions can be performed:
Create Employee,
Read Employee,
Update Employee,
Delete Employee
