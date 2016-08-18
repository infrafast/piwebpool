#!/bin/sh
mysqldump -uroot -ppiwebpool pool measures > measures.sql
mysqldump -uroot -ppiwebpool pool pumpSchedule > pumpSchedule.sql
mysqldump -uroot -ppiwebpool pool scripts > scripts.sql
mysqldump -uroot -ppiwebpool pool settings > settings.sql
mysqldump -uroot -ppiwebpool pool  > piwebpool.sql