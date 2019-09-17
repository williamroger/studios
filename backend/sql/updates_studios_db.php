ALTER TABLE `db_dev_studios`.`studios`
DROP FOREIGN KEY `fk_studios_cities1`;
ALTER TABLE `db_dev_studios`.`studios`
CHANGE COLUMN `city_id` `city_id` INT(11) NULL ;
ALTER TABLE `db_dev_studios`.`studios`
ADD CONSTRAINT `fk_studios_cities1`
FOREIGN KEY (`city_id`)
REFERENCES `db_dev_studios`.`cities` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

==============================================================

ALTER TABLE `db_dev_studios`.`customers`
DROP FOREIGN KEY `fk_customers_cities1`;
ALTER TABLE `db_dev_studios`.`customers`
CHANGE COLUMN `cities_id` `cities_id` INT(11) NULL ;
ALTER TABLE `db_dev_studios`.`customers`
ADD CONSTRAINT `fk_customers_cities1`
FOREIGN KEY (`cities_id`)
REFERENCES `db_dev_studios`.`cities` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

==============================================================

ALTER TABLE `db_dev_studios`.`users`
CHANGE COLUMN `password` `password` VARCHAR(45) NULL ;

==============================================================

ALTER TABLE `db_dev_studios`.`rooms`
ADD COLUMN `created_at` TIMESTAMP NULL AFTER `color`,
ADD COLUMN `updated_at` TIMESTAMP NULL AFTER `created_at`;


==============================================================


ALTER TABLE `db_dev_studios`.`customers`
DROP FOREIGN KEY `fk_customers_cities1`;
ALTER TABLE `db_dev_studios`.`customers`
CHANGE COLUMN `cities_id` `city_id` INT(11) NULL DEFAULT NULL ;
ALTER TABLE `db_dev_studios`.`customers`
ADD CONSTRAINT `fk_customers_cities1`
FOREIGN KEY (`city_id`)
REFERENCES `db_dev_studios`.`cities` (`id`)
ON DELETE NO ACTION
ON UPDATE NO ACTION;


==============================================================


ALTER TABLE `db_dev_studios`.`rooms`
DROP FOREIGN KEY `fk_rooms_equipments_rooms1`;
ALTER TABLE `db_dev_studios`.`rooms`
DROP COLUMN `equipments_rooms_id`,
DROP INDEX `fk_rooms_equipments_rooms1_idx` ;
;

==============================================================

ALTER TABLE `db_dev_studios`.`equipments_rooms`
ADD COLUMN `room_id` VARCHAR(45) NOT NULL AFTER `name`;

ALTER TABLE `db_dev_studios`.`equipments_rooms` 
ADD COLUMN `description` VARCHAR(150) NULL AFTER `room_id`;