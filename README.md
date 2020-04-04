PHP Performance Testing

Application for PHP performance Testing

Requisites to run the application

1.  Apache Server set up to serve PHP files
2.  PHP
3.  MySQL Database installed on your end.

Following modules to be included:
1.  DB Module which has a CRUD functionality - deployed
2.  PHP-Redis Cache - under development/WIP
3.  REST API Module - Not yet started

Run the application on your browser.
Point to the following endpoints:

DB Module Endpoint

    1.  http://your-server-ip/php_perf_test/DB_CRUD/src/ReadWriteDb.php

Following actions will be performed.

Create Table, 
Insert into Table,
Read from Table,
Update table records,
Delete table records,
DROP Table

REDIS CACHE ENDPOINT

    2.  http://your-server-ip/php_perf_test/REDIS/src/RedisOperations.php

Following actions will be performed:

Write to Redis Cache

Read from Redis-Cache

Print Data
