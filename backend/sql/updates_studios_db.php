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