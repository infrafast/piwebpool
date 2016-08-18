#!/bin/sh
echo "Please enter your database root password: "
read pwd_variable
mysqldump -uroot -p$pwd_variable pool measures > measures.sql
mysqldump -uroot -p$pwd_variable pool pumpSchedule > pumpSchedule.sql
mysqldump -uroot -p$pwd_variable pool scripts > scripts.sql
mysqldump -uroot -p$pwd_variable pool settings > settings.sql
mysqldump -uroot -p$pwd_variable pool  > piwebpool.sql