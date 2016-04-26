-- MySQL Script generated by MySQL Workbench
-- 04/26/16 13:25:10
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema zlangevr004
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `zlangevr004`.`gebruiker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`gebruiker` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `Wachtwoord` VARCHAR(45) NOT NULL,
  `telefoonnummer` VARCHAR(45) NOT NULL,
  `straat` VARCHAR(45) NOT NULL,
  `postcode` VARCHAR(45) NOT NULL,
  `woonplaats` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `zlangevr004`.`categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`categorie` (
  `Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Categorie`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zlangevr004`.`dienst`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`dienst` (
  `dienst` VARCHAR(45) NOT NULL,
  `omschijving` TEXT(200) NOT NULL,
  `Afbeelding` BLOB NULL,
  `Categorie_Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`dienst`, `Categorie_Categorie`),
  INDEX `fk_Dienst_Categorie1_idx` (`Categorie_Categorie` ASC),
  CONSTRAINT `fk_Dienst_Categorie1`
    FOREIGN KEY (`Categorie_Categorie`)
    REFERENCES `zlangevr004`.`categorie` (`Categorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zlangevr004`.`Gebruiker_bied_dienst_aan`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`Gebruiker_bied_dienst_aan` (
  `Acount_Id` INT NOT NULL,
  `Vaardigheid` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Acount_Id`, `Vaardigheid`),
  INDEX `fk_Acount_has_Vaardigheid_Vaardigheid1_idx` (`Vaardigheid` ASC),
  INDEX `fk_Acount_has_Vaardigheid_Acount1_idx` (`Acount_Id` ASC),
  CONSTRAINT `fk_Acount_has_Vaardigheid_Acount1`
    FOREIGN KEY (`Acount_Id`)
    REFERENCES `zlangevr004`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Acount_has_Vaardigheid_Vaardigheid1`
    FOREIGN KEY (`Vaardigheid`)
    REFERENCES `zlangevr004`.`dienst` (`dienst`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zlangevr004`.`gebruiker_bied_dienst_aan`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`gebruiker_bied_dienst_aan` (
  `Gebruiker_Id` INT NOT NULL,
  `Dienst_dienst` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Dienst_dienst`),
  INDEX `fk_Gebruiker_has_Dienst_Gebruiker1_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_Gebruiker_bied_dienst_aan_Dienst1_idx` (`Dienst_dienst` ASC),
  CONSTRAINT `fk_Gebruiker_has_Dienst_Gebruiker1`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `zlangevr004`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_bied_dienst_aan_Dienst1`
    FOREIGN KEY (`Dienst_dienst`)
    REFERENCES `zlangevr004`.`dienst` (`dienst`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zlangevr004`.`gebruiker_vraagt_dienst`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`gebruiker_vraagt_dienst` (
  `Gebruiker_Id` INT NOT NULL,
  `Dienst_dienst` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Dienst_dienst`),
  INDEX `fk_Gebruiker_has_Dienst_Gebruiker2_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_Gebruiker_vraagt_dienst_Dienst1_idx` (`Dienst_dienst` ASC),
  CONSTRAINT `fk_Gebruiker_has_Dienst_Gebruiker2`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `zlangevr004`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_vraagt_dienst_Dienst1`
    FOREIGN KEY (`Dienst_dienst`)
    REFERENCES `zlangevr004`.`dienst` (`dienst`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zlangevr004`.`gebruiker_is_goed_in_categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`gebruiker_is_goed_in_categorie` (
  `Gebruiker_Id` INT NOT NULL,
  `Categorie_Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Categorie_Categorie`),
  INDEX `fk_Gebruiker_has_Catogorie_Gebruiker1_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_Gebruiker_is_goed_in_categorie_Categorie1_idx` (`Categorie_Categorie` ASC),
  CONSTRAINT `fk_Gebruiker_has_Catogorie_Gebruiker1`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `zlangevr004`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gebruiker_is_goed_in_categorie_Categorie1`
    FOREIGN KEY (`Categorie_Categorie`)
    REFERENCES `zlangevr004`.`categorie` (`Categorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zlangevr004`.`gebruiker_is_slecht_in_categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `zlangevr004`.`gebruiker_is_slecht_in_categorie` (
  `Gebruiker_Id` INT NOT NULL,
  `Categorie_Categorie` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Gebruiker_Id`, `Categorie_Categorie`),
  INDEX `fk_Gebruiker_has_Catogorie1_Gebruiker1_idx` (`Gebruiker_Id` ASC),
  INDEX `fk_gebruiker_is_slecht_in_categorie_Categorie1_idx` (`Categorie_Categorie` ASC),
  CONSTRAINT `fk_Gebruiker_has_Catogorie1_Gebruiker1`
    FOREIGN KEY (`Gebruiker_Id`)
    REFERENCES `zlangevr004`.`gebruiker` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gebruiker_is_slecht_in_categorie_Categorie1`
    FOREIGN KEY (`Categorie_Categorie`)
    REFERENCES `zlangevr004`.`categorie` (`Categorie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
