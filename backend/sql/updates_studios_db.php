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