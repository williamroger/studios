ALTER TABLE `db_dev_studios`.`tokens`
CHANGE COLUMN `acitve` `active` TINYINT(4) NULL DEFAULT NULL ;

===================================================================

ALTER TABLE `db_dev_studios`.`users`
CHANGE COLUMN `email` `email` VARCHAR(250) NOT NULL ,
CHANGE COLUMN `password` `password` VARCHAR(255) NULL DEFAULT NULL ;

==============================================================01/10

ALTER TABLE `db_dev_studios`.`time_periods`
CHANGE COLUMN `day` `day` VARCHAR(45) NULL DEFAULT NULL ;