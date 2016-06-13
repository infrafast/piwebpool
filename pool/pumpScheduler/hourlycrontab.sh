#!/bin/sh
cd /var/www/html/pumpScheduler
php -dextension=lua.so cronaction.php >> logs/cronaction.txt 2>&1