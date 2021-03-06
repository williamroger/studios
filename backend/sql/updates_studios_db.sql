ALTER TABLE `db_dev_studios`.`tokens`
CHANGE COLUMN `acitve` `active` TINYINT(4) NULL DEFAULT NULL ;

===================================================================

ALTER TABLE `db_dev_studios`.`users`
CHANGE COLUMN `email` `email` VARCHAR(250) NOT NULL ,
CHANGE COLUMN `password` `password` VARCHAR(255) NULL DEFAULT NULL ;

==============================================================01/10

ALTER TABLE `db_dev_studios`.`time_periods`
CHANGE COLUMN `day` `day` VARCHAR(45) NULL DEFAULT NULL ;

================================================================

ALTER TABLE `db_dev_studios`.`schedules_time_periods`
DROP FOREIGN KEY `fk_Agendamentos_has_Horarios_Horarios1`,
DROP FOREIGN KEY `fk_Agendamentos_has_Horarios_Agendamentos`;
ALTER TABLE `db_dev_studios`.`schedules_time_periods`
DROP INDEX `fk_Agendamentos_has_Horarios_Agendamentos_idx` ,
DROP INDEX `fk_Agendamentos_has_Horarios_Horarios1_idx` ;

================================================================

ALTER TABLE `db_dev_studios`.`time_periods`
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

================================================================

ALTER TABLE `db_dev_studios`.`time_periods`
CHANGE COLUMN `price` `amount` DECIMAL(10,2) NOT NULL ;

=========================================================05-10-19

ALTER TABLE `db_dev_studios`.`time_periods`
ADD COLUMN `day_order` INT NULL AFTER `end_period`;

=========================================================10-10-19

ALTER TABLE `db_dev_studios`.`studios`
CHANGE COLUMN `image` `image` VARCHAR(1500) NULL DEFAULT NULL ;

=========================================================14-10-19

ALTER TABLE `db_dev_studios`.`rooms` 
CHANGE COLUMN `images` `image` VARCHAR(1500) NULL DEFAULT NULL ;

=========================================================19-10-19

ALTER TABLE `db_dev_studios`.`studios` 
ADD COLUMN `has_wifi` INT(11) NULL AFTER `image`;

=========================================================25-10-19

ALTER TABLE `db_dev_studios`.`schedules` 
CHANGE COLUMN `date_scheduling` `date_scheduling` DATE NOT NULL AFTER `comment`;

=========================================================29-10-19

ALTER TABLE `db_dev_studios`.`studios` 
ADD COLUMN `has_recording` INT(11) NULL AFTER `has_wifi`,
ADD COLUMN `has_mixing_mastering` INT(11) NULL AFTER `has_recording`;

=========================================================03-11-19

ALTER TABLE `db_dev_studios`.`schedules`
DROP FOREIGN KEY `fk_Agendamentos_Clientes1`;

=========================================================19-11-19

ALTER TABLE `db_dev_studios`.`schedules` 
ADD COLUMN `user_cancellation` VARCHAR(45) NULL AFTER `date_scheduling`;

=========================================================21-11-19

ALTER TABLE `db_dev_studios`.`schedules_time_periods` 
ADD COLUMN `schedule_cancelled` VARCHAR(45) NULL AFTER `time_period_id`;