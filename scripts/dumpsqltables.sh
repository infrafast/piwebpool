#!/bin/sh
mysqldump -uroot -pQuintal74605 pool measures > measures.sql
mysqldump -uroot -pQuintal74605 pool pumpSchedule > pumpSchedule.sql
mysqldump -uroot -pQuintal74605 pool scripts > scripts.sql
mysqldump -uroot -pQuintal74605 pool settings > settings.sql