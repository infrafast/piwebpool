#!/bin/sh
cd /var/www/html/pumpScheduler
php  cronaction.php >> logs/cronaction.txt 2>&1