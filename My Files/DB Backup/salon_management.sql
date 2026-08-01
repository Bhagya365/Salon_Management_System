-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema project_class_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema project_class_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `project_class_db` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema salon_management_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema salon_management_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `salon_management_db` DEFAULT CHARACTER SET utf8 ;
USE `project_class_db` ;

-- -----------------------------------------------------
-- Table `project_class_db`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`category` (
  `idcategory` INT(11) NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(45) NULL DEFAULT NULL,
  `amount` DOUBLE NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`idcategory`))
ENGINE = InnoDB
AUTO_INCREMENT = 61
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`user_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`user_role` (
  `iduser_role` INT(11) NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(45) NULL DEFAULT NULL,
  `role_description` VARCHAR(50) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`iduser_role`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`master_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`master_user` (
  `idmaster_user` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NULL DEFAULT NULL,
  `last_name` VARCHAR(100) NULL DEFAULT NULL,
  `contact_number` VARCHAR(10) NULL DEFAULT NULL,
  `gender` VARCHAR(45) NULL DEFAULT NULL,
  `dob` DATE NULL DEFAULT NULL,
  `user_name` VARCHAR(150) NULL DEFAULT NULL,
  `password` VARCHAR(200) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `user_role_iduser_role` INT(11) NOT NULL,
  PRIMARY KEY (`idmaster_user`),
  INDEX `fk_master_user_user_role_idx` (`user_role_iduser_role` ASC),
  CONSTRAINT `fk_master_user_user_role`
    FOREIGN KEY (`user_role_iduser_role`)
    REFERENCES `project_class_db`.`user_role` (`iduser_role`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 76
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`time_slot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`time_slot` (
  `idtime_slot` INT(11) NOT NULL AUTO_INCREMENT,
  `time_slot` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idtime_slot`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`appointment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`appointment` (
  `idappointment` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `amount` DOUBLE NULL DEFAULT NULL,
  `master_user_idmaster_user` INT(11) NOT NULL,
  `time_slot_idtime_slot` INT(11) NOT NULL,
  `counsellor_id` INT(11) NOT NULL,
  `category_idcategory` INT(11) NOT NULL,
  PRIMARY KEY (`idappointment`),
  INDEX `fk_appointment_master_user1_idx` (`master_user_idmaster_user` ASC),
  INDEX `fk_appointment_time_slot1_idx` (`time_slot_idtime_slot` ASC),
  INDEX `fk_appointment_master_user2_idx` (`counsellor_id` ASC),
  INDEX `fk_appointment_category1_idx` (`category_idcategory` ASC),
  CONSTRAINT `fk_appointment_category1`
    FOREIGN KEY (`category_idcategory`)
    REFERENCES `project_class_db`.`category` (`idcategory`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_appointment_master_user1`
    FOREIGN KEY (`master_user_idmaster_user`)
    REFERENCES `project_class_db`.`master_user` (`idmaster_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_appointment_master_user2`
    FOREIGN KEY (`counsellor_id`)
    REFERENCES `project_class_db`.`master_user` (`idmaster_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_appointment_time_slot1`
    FOREIGN KEY (`time_slot_idtime_slot`)
    REFERENCES `project_class_db`.`time_slot` (`idtime_slot`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 127
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`assignment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`assignment` (
  `idassignment` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(200) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`idassignment`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`client`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`client` (
  `idclient` INT(11) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NULL DEFAULT NULL,
  `last_name` VARCHAR(100) NULL DEFAULT NULL,
  `contact_number` VARCHAR(10) NULL DEFAULT NULL,
  `gender` VARCHAR(45) NULL DEFAULT NULL,
  `dob` DATE NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `master_user_idmaster_user` INT(11) NOT NULL,
  PRIMARY KEY (`idclient`),
  INDEX `fk_client_master_user1_idx` (`master_user_idmaster_user` ASC),
  CONSTRAINT `fk_client_master_user1`
    FOREIGN KEY (`master_user_idmaster_user`)
    REFERENCES `project_class_db`.`master_user` (`idmaster_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`contact_us`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`contact_us` (
  `idcontact_us` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `message` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`idcontact_us`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`feedback`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`feedback` (
  `idfeedback` INT(11) NOT NULL,
  `rating` VARCHAR(45) NULL DEFAULT NULL,
  `comment` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `appointment_idappointment` INT(11) NOT NULL,
  PRIMARY KEY (`idfeedback`),
  INDEX `fk_feedback_appointment1_idx` (`appointment_idappointment` ASC),
  CONSTRAINT `fk_feedback_appointment1`
    FOREIGN KEY (`appointment_idappointment`)
    REFERENCES `project_class_db`.`appointment` (`idappointment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`gdf`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`gdf` (
  `idgdf` INT(11) NOT NULL AUTO_INCREMENT,
  `main_problem` VARCHAR(200) NULL DEFAULT NULL,
  `severity_level` VARCHAR(45) NULL DEFAULT NULL,
  `appearance_behavior` VARCHAR(200) NULL DEFAULT NULL,
  `previous_treatment` VARCHAR(200) NULL DEFAULT NULL,
  `social_life` VARCHAR(200) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `master_user_idmaster_user` INT(11) NOT NULL,
  PRIMARY KEY (`idgdf`),
  INDEX `fk_gdf_master_user1_idx` (`master_user_idmaster_user` ASC),
  CONSTRAINT `fk_gdf_master_user1`
    FOREIGN KEY (`master_user_idmaster_user`)
    REFERENCES `project_class_db`.`master_user` (`idmaster_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`payment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`payment` (
  `idpayment` INT(11) NOT NULL AUTO_INCREMENT,
  `appointment_idappointment` INT(11) NOT NULL,
  `amount` DOUBLE NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`idpayment`),
  INDEX `fk_payment_appointment1_idx` (`appointment_idappointment` ASC),
  CONSTRAINT `fk_payment_appointment1`
    FOREIGN KEY (`appointment_idappointment`)
    REFERENCES `project_class_db`.`appointment` (`idappointment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 31
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`session_report`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`session_report` (
  `idsesion_report` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NULL DEFAULT NULL,
  `action_taken` VARCHAR(200) NULL DEFAULT NULL,
  `next_appointment_date` DATE NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `master_user_idmaster_user` INT(11) NOT NULL,
  `assignment_idassignment` INT(11) NOT NULL,
  PRIMARY KEY (`idsesion_report`),
  INDEX `fk_sesion_report_master_user1_idx` (`master_user_idmaster_user` ASC),
  INDEX `fk_sesion_report_assignment1_idx` (`assignment_idassignment` ASC),
  CONSTRAINT `fk_sesion_report_assignment1`
    FOREIGN KEY (`assignment_idassignment`)
    REFERENCES `project_class_db`.`assignment` (`idassignment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sesion_report_master_user1`
    FOREIGN KEY (`master_user_idmaster_user`)
    REFERENCES `project_class_db`.`master_user` (`idmaster_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `project_class_db`.`test_table`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project_class_db`.`test_table` (
  `idtest_table` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `amount` DOUBLE NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`idtest_table`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8;

USE `salon_management_db` ;

-- -----------------------------------------------------
-- Table `salon_management_db`.`user_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `salon_management_db`.`user_role` (
  `iduser_role` INT(11) NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(45) NULL DEFAULT NULL,
  `role_description` VARCHAR(50) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`iduser_role`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
