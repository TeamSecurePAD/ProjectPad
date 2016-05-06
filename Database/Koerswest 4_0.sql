-- MySQL Script generated by MySQL Workbench
-- 05/06/16 18:15:00
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema koersWest
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema koersWest
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `koersWest` DEFAULT CHARACTER SET utf8 ;
USE `koersWest` ;

-- -----------------------------------------------------
-- Table `koersWest`.`gebruiker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`gebruiker` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `wachtwoord` VARCHAR(45) NOT NULL,
  `omschijving` VARCHAR(250) NOT NULL,
  `profielnaam` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`Klant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`Klant` (
  `Id` INT NOT NULL,
  `Naam` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `telefoon` INT NULL,
  `Acount_Id` INT NOT NULL,
  PRIMARY KEY (`Id`, `Acount_Id`),
  INDEX `fk_Cliënt_Acount_idx` (`Acount_Id` ASC),
  CONSTRAINT `fk_Cliënt_Acount`
    FOREIGN KEY (`Acount_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`categorie` (
  `Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Categorie`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`dienst`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`dienst` (
  `dienst` VARCHAR(45) NOT NULL,
  `omschijving` TEXT(200) NOT NULL,
  `Afbeelding` BLOB NULL,
  `Categorie_Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`dienst`, `Categorie_Categorie`),
  INDEX `fk_Dienst_Categorie1_idx` (`Categorie_Categorie` ASC),
  CONSTRAINT `fk_Dienst_Categorie1`
    FOREIGN KEY (`Categorie_Categorie`)
    REFERENCES `koersWest`.`categorie` (`Categorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`Gebruiker_bied_dienst_aan`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`Gebruiker_bied_dienst_aan` (
  `Acount_Id` INT NOT NULL,
  `Vaardigheid` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Acount_Id`, `Vaardigheid`),
  INDEX `fk_Acount_has_Vaardigheid_Vaardigheid1_idx` (`Vaardigheid` ASC),
  INDEX `fk_Acount_has_Vaardigheid_Acount1_idx` (`Acount_Id` ASC),
  CONSTRAINT `fk_Acount_has_Vaardigheid_Acount1`
    FOREIGN KEY (`Acount_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Acount_has_Vaardigheid_Vaardigheid1`
    FOREIGN KEY (`Vaardigheid`)
    REFERENCES `koersWest`.`dienst` (`dienst`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`gebruiker_bied_dienst_aan`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`gebruiker_bied_dienst_aan` (
  `Gebruiker_Id` INT NOT NULL,
  `Dienst_dienst` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Dienst_dienst`),
  INDEX `fk_Gebruiker_has_Dienst_Gebruiker1_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_Gebruiker_bied_dienst_aan_Dienst1_idx` (`Dienst_dienst` ASC),
  CONSTRAINT `fk_Gebruiker_has_Dienst_Gebruiker1`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_bied_dienst_aan_Dienst1`
    FOREIGN KEY (`Dienst_dienst`)
    REFERENCES `koersWest`.`dienst` (`dienst`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`gebruiker_vraagt_dienst`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`gebruiker_vraagt_dienst` (
  `Gebruiker_Id` INT NOT NULL,
  `Dienst_dienst` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Dienst_dienst`),
  INDEX `fk_Gebruiker_has_Dienst_Gebruiker2_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_Gebruiker_vraagt_dienst_Dienst1_idx` (`Dienst_dienst` ASC),
  CONSTRAINT `fk_Gebruiker_has_Dienst_Gebruiker2`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_vraagt_dienst_Dienst1`
    FOREIGN KEY (`Dienst_dienst`)
    REFERENCES `koersWest`.`dienst` (`dienst`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`gebruiker_is_goed_in_categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`gebruiker_is_goed_in_categorie` (
  `Gebruiker_Id` INT NOT NULL,
  `Categorie_Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Categorie_Categorie`),
  INDEX `fk_Gebruiker_has_Catogorie_Gebruiker1_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_Gebruiker_is_goed_in_categorie_Categorie1_idx` (`Categorie_Categorie` ASC),
  CONSTRAINT `fk_Gebruiker_has_Catogorie_Gebruiker1`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_is_goed_in_categorie_Categorie1`
    FOREIGN KEY (`Categorie_Categorie`)
    REFERENCES `koersWest`.`categorie` (`Categorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`gebruiker_is_slecht_in_categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`gebruiker_is_slecht_in_categorie` (
  `Gebruiker_Id` INT NOT NULL,
  `Categorie_Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Categorie_Categorie`),
  INDEX `fk_Gebruiker_has_Catogorie1_Gebruiker1_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_gebruiker_is_slecht_in_categorie_Categorie1_idx` (`Categorie_Categorie` ASC),
  CONSTRAINT `fk_Gebruiker_has_Catogorie1_Gebruiker1`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gebruiker_is_slecht_in_categorie_Categorie1`
    FOREIGN KEY (`Categorie_Categorie`)
    REFERENCES `koersWest`.`categorie` (`Categorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`gebruiker_prive`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`gebruiker_prive` (
  `gebruiker_Id` INT NOT NULL,
  `naam` VARCHAR(45) NOT NULL,
  `tussenvoegsel` VARCHAR(45) NULL,
  `achternaam` VARCHAR(45) NOT NULL,
  `telefoonnummer` VARCHAR(45) NOT NULL,
  `straat` VARCHAR(45) NOT NULL,
  `postcode` VARCHAR(45) NOT NULL,
  `woonplaats` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`gebruiker_Id`, `naam`),
  CONSTRAINT `fk_gebruiker_prive_gebruiker1`
    FOREIGN KEY (`gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`Match`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`Match` (
  `` INT NOT NULL,
  PRIMARY KEY (``))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`match`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`match` (
  `gebruiker_Id` INT NOT NULL,
  `match_gebruiker_Id` INT NOT NULL,
  `match_goedgekeurd` TINYINT(1) NOT NULL,
  `gereageerd` TINYINT(1) NOT NULL,
  INDEX `fk_match_gebruiker2_idx` (`gebruiker_Id` ASC),
  INDEX `fk_match_gebruiker3_idx` (`match_gebruiker_Id` ASC),
  PRIMARY KEY (`gebruiker_Id`, `match_gebruiker_Id`),
  CONSTRAINT `fk_match_gebruiker2`
    FOREIGN KEY (`gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_match_gebruiker3`
    FOREIGN KEY (`match_gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`gebruiker_has_gebruiker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`gebruiker_has_gebruiker` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `koersWest`.`match`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `koersWest`.`match` (
  `gebruiker_Id` INT NOT NULL,
  `match_gebruiker_Id` INT NOT NULL,
  `match_goedgekeurd` TINYINT(1) NOT NULL,
  `gereageerd` TINYINT(1) NOT NULL,
  INDEX `fk_match_gebruiker2_idx` (`gebruiker_Id` ASC),
  INDEX `fk_match_gebruiker3_idx` (`match_gebruiker_Id` ASC),
  PRIMARY KEY (`gebruiker_Id`, `match_gebruiker_Id`),
  CONSTRAINT `fk_match_gebruiker2`
    FOREIGN KEY (`gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_match_gebruiker3`
    FOREIGN KEY (`match_gebruiker_Id`)
    REFERENCES `koersWest`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
