#!/bin/sh
cd /var/www/html/pool
php -dextension=lua.so cronaction.php