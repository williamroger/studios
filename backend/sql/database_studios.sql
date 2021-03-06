-- MySQL Script generated by MySQL Workbench
-- Wed Sep 11 02:27:54 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_dev_studios
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_dev_studios
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_dev_studios` DEFAULT CHARACTER SET utf8 ;
USE `db_dev_studios` ;

-- -----------------------------------------------------
-- Table `db_dev_studios`.`states`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`states` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `initials` VARCHAR(2) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`cities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`cities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `state_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cities_states1_idx` (`state_id` ASC),
  CONSTRAINT `fk_cities_states1`
    FOREIGN KEY (`state_id`)
    REFERENCES `db_dev_studios`.`states` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`customers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `cpf` VARCHAR(45) NULL,
  `cities_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_customers_cities1_idx` (`cities_id` ASC),
  CONSTRAINT `fk_customers_cities1`
    FOREIGN KEY (`cities_id`)
    REFERENCES `db_dev_studios`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`schedules`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`schedules` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date_scheduling` TIMESTAMP NOT NULL,
  `status` INT NOT NULL,
  `date_cancellation` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `customer_id` INT NOT NULL,
  `comment` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Agendamentos_Clientes1_idx` (`customer_id` ASC),
  CONSTRAINT `fk_Agendamentos_Clientes1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `db_dev_studios`.`customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`payments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`payments` (
  `id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `status` INT NOT NULL,
  `schedule_id` INT NOT NULL,
  `date_payment` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Pagamentos_Agendamentos1_idx` (`schedule_id` ASC),
  CONSTRAINT `fk_Pagamentos_Agendamentos1`
    FOREIGN KEY (`schedule_id`)
    REFERENCES `db_dev_studios`.`schedules` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`studios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`studios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `address` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  `description` VARCHAR(250) NULL,
  `cnpj` VARCHAR(45) NULL,
  `telephone` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `has_parking` INT NULL,
  `is_24_hours` INT NULL,
  `city_id` INT NOT NULL,
  `rate_cancellation` INT NULL,
  `days_cancellation` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_studios_cities1_idx` (`city_id` ASC),
  CONSTRAINT `fk_studios_cities1`
    FOREIGN KEY (`city_id`)
    REFERENCES `db_dev_studios`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`equipments_rooms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`equipments_rooms` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`rooms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`rooms` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(1500) NULL,
  `studio_id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `maximum_capacity` INT NULL,
  `equipments_rooms_id` INT NULL,
  `color` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_salas_estudio1_idx` (`studio_id` ASC),
  INDEX `fk_rooms_equipments_rooms1_idx` (`equipments_rooms_id` ASC),
  CONSTRAINT `fk_salas_estudio1`
    FOREIGN KEY (`studio_id`)
    REFERENCES `db_dev_studios`.`studios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rooms_equipments_rooms1`
    FOREIGN KEY (`equipments_rooms_id`)
    REFERENCES `db_dev_studios`.`equipments_rooms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`time_periods`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`time_periods` (
  `id` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `room_id` INT NOT NULL,
  `day` INT NULL,
  `price_rate` DECIMAL(10,2) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `begin_period` TIME NOT NULL,
  `end_period` TIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Horarios_salas1_idx` (`room_id` ASC),
  CONSTRAINT `fk_Horarios_salas1`
    FOREIGN KEY (`room_id`)
    REFERENCES `db_dev_studios`.`rooms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`schedules_time_periods`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`schedules_time_periods` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `schedule_id` INT NOT NULL,
  `time_period_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Agendamentos_has_Horarios_Horarios1_idx` (`time_period_id` ASC),
  INDEX `fk_Agendamentos_has_Horarios_Agendamentos_idx` (`schedule_id` ASC),
  CONSTRAINT `fk_Agendamentos_has_Horarios_Agendamentos`
    FOREIGN KEY (`schedule_id`)
    REFERENCES `db_dev_studios`.`schedules` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Agendamentos_has_Horarios_Horarios1`
    FOREIGN KEY (`time_period_id`)
    REFERENCES `db_dev_studios`.`time_periods` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`ratings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`ratings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `rating` INT NOT NULL,
  `comment` VARCHAR(150) NULL,
  `created_at` TIMESTAMP NULL,
  `customer_id` INT NOT NULL,
  `studio_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ratings_customers1_idx` (`customer_id` ASC),
  INDEX `fk_ratings_studios1_idx` (`studio_id` ASC),
  CONSTRAINT `fk_ratings_customers1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `db_dev_studios`.`customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ratings_studios1`
    FOREIGN KEY (`studio_id`)
    REFERENCES `db_dev_studios`.`studios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`equipments_categorys`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`equipments_categorys` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`equipments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`equipments` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `description` VARCHAR(100) NULL,
  `equipment_category_id` INT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `studio_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_equipamentos_categorias_equipamentos1_idx` (`equipment_category_id` ASC),
  INDEX `fk_equipment_studios1_idx` (`studio_id` ASC),
  CONSTRAINT `fk_equipamentos_categorias_equipamentos1`
    FOREIGN KEY (`equipment_category_id`)
    REFERENCES `db_dev_studios`.`equipments_categorys` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_studios1`
    FOREIGN KEY (`studio_id`)
    REFERENCES `db_dev_studios`.`studios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`equipments_schedules`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`equipments_schedules` (
  `equipment_id` INT NOT NULL,
  `schedule_id` INT NOT NULL,
  INDEX `fk_equipments_schedules_equipments1_idx` (`equipment_id` ASC),
  INDEX `fk_equipments_schedules_schedules1_idx` (`schedule_id` ASC),
  CONSTRAINT `fk_equipments_schedules_equipments1`
    FOREIGN KEY (`equipment_id`)
    REFERENCES `db_dev_studios`.`equipments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipments_schedules_schedules1`
    FOREIGN KEY (`schedule_id`)
    REFERENCES `db_dev_studios`.`schedules` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`credits`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`credits` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `amount` DECIMAL(10,2) NOT NULL,
  `updated_at` TIMESTAMP NULL,
  `studio_id` INT NOT NULL,
  `customer_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_credits_studios1_idx` (`studio_id` ASC),
  INDEX `fk_credits_customers1_idx` (`customer_id` ASC),
  CONSTRAINT `fk_credits_studios1`
    FOREIGN KEY (`studio_id`)
    REFERENCES `db_dev_studios`.`studios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_credits_customers1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `db_dev_studios`.`customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`black_list`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`black_list` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `reason` VARCHAR(100) NULL,
  `customer_id` INT NOT NULL,
  `studio_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_saldos_Clientes1_idx` (`customer_id` ASC),
  INDEX `fk_saldos_estudio1_idx` (`studio_id` ASC),
  CONSTRAINT `fk_saldos_Clientes10`
    FOREIGN KEY (`customer_id`)
    REFERENCES `db_dev_studios`.`customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_saldos_estudio10`
    FOREIGN KEY (`studio_id`)
    REFERENCES `db_dev_studios`.`studios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `customer_id` INT NULL,
  `studio_id` INT NULL,
  `is_studio` INT NULL,
  `is_customer` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_customers1_idx` (`customer_id` ASC),
  INDEX `fk_users_studios1_idx` (`studio_id` ASC),
  CONSTRAINT `fk_users_customers1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `db_dev_studios`.`customers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_studios1`
    FOREIGN KEY (`studio_id`)
    REFERENCES `db_dev_studios`.`studios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`tokens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(1000) NOT NULL,
  `refresh_token` VARCHAR(1000) NOT NULL,
  `expired_at` TIMESTAMP NOT NULL,
  `acitve` TINYINT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tokens_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_tokens_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `db_dev_studios`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_dev_studios`.`bloqued_dates`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_dev_studios`.`bloqued_dates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` TIMESTAMP NOT NULL,
  `studios_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_bloqued_dates_studios1_idx` (`studios_id` ASC),
  CONSTRAINT `fk_bloqued_dates_studios1`
    FOREIGN KEY (`studios_id`)
    REFERENCES `db_dev_studios`.`studios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
