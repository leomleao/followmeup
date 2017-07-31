SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `followMeUp` ;
CREATE SCHEMA IF NOT EXISTS `followMeUp` DEFAULT CHARACTER SET utf8 ;
USE `followMeUp` ;

-- -----------------------------------------------------
-- Table `followMeUp`.`departments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`departments` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`departments` (
  `departmentID` INT NOT NULL AUTO_INCREMENT ,
  `departmentName` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`departmentID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `followMeUp`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`roles` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`roles` (
  `roleID` INT NOT NULL AUTO_INCREMENT ,
  `roleDesc` VARCHAR(45) NULL ,
  PRIMARY KEY (`roleID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `followMeUp`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`users` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`users` (
  `userID` INT NOT NULL AUTO_INCREMENT ,
  `userUser` VARCHAR(45) NOT NULL ,
  `userName` VARCHAR(45) NOT NULL ,
  `userDepartmentID` INT NOT NULL ,
  `userPassword` CHAR(128) NULL ,
  `userEmail` VARCHAR(45) NULL ,
  `userPicturePath` VARCHAR(45) NULL ,
  `userCreationDate` TIMESTAMP NULL DEFAULT NOW() ,
  `userLastMod` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP ,
  `userSalt` CHAR(128) NULL ,
  `userRoleID` INT NOT NULL ,
  `userStatus` INT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`userID`) ,
  INDEX `userDepartmentID_idx` (`userDepartmentID` ASC) ,
  INDEX `userRoleID_idx` (`userRoleID` ASC) ,
  CONSTRAINT `userDepartmentID`
    FOREIGN KEY (`userDepartmentID` )
    REFERENCES `followMeUp`.`departments` (`departmentID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `userRoleID`
    FOREIGN KEY (`userRoleID` )
    REFERENCES `followMeUp`.`roles` (`roleID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `followMeUp`.`user_reports`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`user_reports` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`user_reports` (
  `userReportID` INT NOT NULL ,
  `userReportTo` INT NOT NULL ,
  PRIMARY KEY (`userReportID`, `userReportTo`) ,
  INDEX `userReportTo_idx` (`userReportTo` ASC) ,
  CONSTRAINT `userReportID`
    FOREIGN KEY (`userReportID` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `userReportTo`
    FOREIGN KEY (`userReportTo` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `followMeUp`.`Segments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`Segments` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`segments` (
  `segmentID` INT NOT NULL AUTO_INCREMENT ,
  `segmentName` VARCHAR(45) NOT NULL ,
   PRIMARY KEY (`segmentID`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `followMeUp`.`Federation_units`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`Federation_units` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`federation_units` (
  `fuID` INT NOT NULL AUTO_INCREMENT ,
  `fuAcronym` VARCHAR(2) NOT NULL ,
  `fuName` VARCHAR(45) NULL ,
   PRIMARY KEY (`fuID`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `followMeUp`.`customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`customers` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`customers` (
  `customerID` INT NOT NULL AUTO_INCREMENT ,
  `customerCode` INT(10) NOT NULL ,
  `customerName` VARCHAR(45) NULL ,
  `customerContactName` VARCHAR(45) NULL ,
  `customerCNPJ` VARCHAR(45) NULL ,
  `customerStatus` VARCHAR(45) NULL ,
  `customerCreationDate` TIMESTAMP NULL DEFAULT NOW() ,
  `customerLastMod` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP ,
  `customerSalesManID` INT NOT NULL ,
  `customerSegmentID` INT NOT NULL ,
  `customerEmail` VARCHAR(128) NULL ,
  `customerTel` VARCHAR(40) NULL ,
  `customerCel` VARCHAR(40) NULL ,
  `customerZipCode` VARCHAR(16) NOT NULL ,
  `customerStreet` VARCHAR(128) NOT NULL ,
  `customerStreetNumber` VARCHAR(128) NOT NULL ,
  `customerNeighborhood` VARCHAR(128) NOT NULL ,
  `customerCity` VARCHAR(128) NOT NULL ,
  `customerState` VARCHAR(2) ,
  `customerIBGE` VARCHAR(45) NULL ,
  `customerLastModBy` INT NOT NULL ,
  PRIMARY KEY (`customerID`) ,
CONSTRAINT `customerRegion`
    FOREIGN KEY (`customerSalesManID` )
    REFERENCES `followMeUp`.`users` (`userid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `customerLastModBy`
    FOREIGN KEY (`customerLastModBy` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `customerSegmentID`
    FOREIGN KEY (`customerSegmentID` )
    REFERENCES `followMeUp`.`segments` (`segmentID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `followMeUp`.`follow_ups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`follow_ups` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`follow_ups` (
  `followUpID` INT NOT NULL AUTO_INCREMENT ,
  `followUpQuotationID` INT NOT NULL,
  `followUpDesc1` VARCHAR(45) NULL ,
  `followUpUserID1` INT NULL ,
  `followUpInsertionDate1` TIMESTAMP NULL DEFAULT NOW() ,
  `followUpDesc2` VARCHAR(45) NULL ,
  `followUpUserID2` INT NULL ,
  `followUpInsertionDate2` TIMESTAMP NULL,
  `followUpUserID3` INT NULL ,
  `followUpInsertionDate3` DATETIME NULL ,
  `followUpDesc3` VARCHAR(45) NULL ,
  PRIMARY KEY (`followUpID`) ,
  INDEX `quotationFollowUpID_idx` (`followUpQuotationID` ASC) ,
CONSTRAINT `followUpUserID1`
    FOREIGN KEY (`followUpUserID1` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `followUpUserID2`
    FOREIGN KEY (`followUpUserID2` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `followUpUserID3`
    FOREIGN KEY (`followUpUserID3` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationFollowUpID`
    FOREIGN KEY (`followUpQuotationID` )
    REFERENCES `followMeUp`.`quotations` (`quotationID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `followMeUp`.`quotations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`quotations` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`quotations` (
  `quotationID` INT NOT NULL AUTO_INCREMENT ,
  `quotationNumber` INT NOT NULL ,
  `quotationCustomerID` INT NOT NULL ,
  `quotationValue` DOUBLE NULL ,
  `quotationFinalValue` DOUBLE NULL ,
  `quotationState` VARCHAR(45) NOT NULL ,
  `quotationCommuWay` VARCHAR(45) NULL ,
  `quotationReceivedConf` TINYINT(1) NULL ,
  `quotationDealerUserID` INT NOT NULL ,
  `quotationInsertionDate` TIMESTAMP NULL DEFAULT NOW() ,
  `quotationLastModified` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP ,
  `quotationSendDate` DATETIME NULL ,
  `quotationCreationDate` DATETIME NULL ,
  `quotationClosingDate` DATETIME NULL DEFAULT NULL ,
  `quotationUserID` INT NOT NULL ,
  `quotationPriority` CHAR(1) NULL ,
  `quotationStatus` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`quotationID`) ,
  INDEX `quotationCustomerID_idx` (`quotationCustomerID` ASC) ,
  INDEX `quotationUserID_idx` (`quotationUserID` ASC) ,
  INDEX `quotationDealerUserID_idx` (`quotationDealerUserID` ASC) ,
  CONSTRAINT `quotationCustomerID`
    FOREIGN KEY (`quotationCustomerID` )
    REFERENCES `followMeUp`.`customers` (`customerID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
  CONSTRAINT `quotationUserID`
    FOREIGN KEY (`quotationUserID` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationDealerUserID`
    FOREIGN KEY (`quotationDealerUserID` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '	';


-- -----------------------------------------------------
-- Table `followMeUp`.`quotation_histories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`quotation_histories` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`quotation_histories` (
  `quotationHistoryID` INT NOT NULL AUTO_INCREMENT ,
  `quotationHistoryQuotationID` INT NULL ,
  `quotationHistoryValue` DOUBLE NULL ,
  `quotationHistoryFinalValue` DOUBLE NULL ,
  `quotationHistoryState` VARCHAR(45) NULL ,
  `quotationHistoryCreationDate` DATETIME NULL ,
  `quotationHistoryClosingDate` DATETIME NULL ,
  `quotationHistoryUserID` INT NULL ,
  `quotationHistoryCustomerID` INT NULL ,
  `quotationHistoryDealerUserID` INT NULL ,
  `quotationHistoryType` VARCHAR(10) NULL ,
  `quotationHistoryFollowUpID` INT NULL ,
  `quotationHistoryEventDate` TIMESTAMP NULL DEFAULT NOW() ,
  PRIMARY KEY (`quotationHistoryID`) ,
  INDEX `quotationHistoryQuotationID_idx` (`quotationHistoryQuotationID` ASC) ,
  INDEX `quotationHistoryCustomerID_idx` (`quotationHistoryCustomerID` ASC) ,
  INDEX `quotationHistoryDealerID_idx` (`quotationHistoryDealerUserID` ASC) ,
  INDEX `quotationHistoryFollowUpID_idx` (`quotationHistoryFollowUpID` ASC) ,
  CONSTRAINT `quotationHistoryQuotationID`
    FOREIGN KEY (`quotationHistoryQuotationID` )
    REFERENCES `followMeUp`.`quotations` (`quotationID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationHistoryUserID`
    FOREIGN KEY (`quotationHistoryUserID` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationHistoryCustomerID`
    FOREIGN KEY (`quotationHistoryCustomerID` )
    REFERENCES `followMeUp`.`customers` (`customerID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationHistoryDealerUserID`
    FOREIGN KEY (`quotationHistoryDealerUserID` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `followMeUp`.`password_recoveries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`password_recoveries` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`password_recoveries` (
  `passwordID` INT NOT NULL AUTO_INCREMENT ,
  `userID` INT NOT NULL ,
  `token` VARCHAR(255) NOT NULL ,
  `status` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`passwordID`) ,
  INDEX `userID_idx` (`userID` ASC) ,
  CONSTRAINT `userID`
    FOREIGN KEY (`userID` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `followMeUp`.`login_attempts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `followMeUp`.`login_attempts` ;

CREATE  TABLE IF NOT EXISTS `followMeUp`.`login_attempts` (
  `loginAttemptID` INT NOT NULL AUTO_INCREMENT ,
  `loginAttemptUserID` INT NOT NULL ,
  `tried_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`loginAttemptID`, `loginAttemptUserID`) ,
  INDEX `loginAttemptUserID_idx` (`loginAttemptUserID` ASC) ,
  CONSTRAINT `loginAttemptUserID`
    FOREIGN KEY (`loginAttemptUserID` )
    REFERENCES `followMeUp`.`users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `followmeup` ;
USE `followmeup`;

DELIMITER $$

USE `followmeup`$$
DROP TRIGGER IF EXISTS `followmeup`.`updateAction` $$
USE `followmeup`$$


CREATE TRIGGER `updateAction` AFTER UPDATE ON quotations FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
IF ((SELECT quotationStatus FROM quotations WHERE quotationID = NEW.quotationID ORDER BY quotationInsertionDate DESC LIMIT 1) = FALSE)
THEN 
INSERT INTO `followmeup`.`quotation_histories` (`quotationHistoryQuotationID`, `quotationHistoryValue`, `quotationHistoryFinalValue`, `quotationHistoryState`, `quotationHistoryCreationDate`, `quotationHistoryClosingDate`, `quotationHistoryUserID`, `quotationHistoryCustomerID`, `quotationHistoryDealerUserID`,`quotationHistoryType`,`quotationHistoryFollowUpID`) 
VALUES ((SELECT quotationID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1 ),
 (SELECT quotationFinalValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationState FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCreationDate FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationClosingDate FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCustomerID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationDealerUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 'DELETE',
 (SELECT followUpID FROM follow_ups WHERE followUpQuotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1));
ELSEIF ((SELECT quotationStatus FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1) = TRUE)
THEN
INSERT INTO `followmeup`.`quotation_histories` (`quotationHistoryQuotationID`, `quotationHistoryValue`, `quotationHistoryFinalValue`, `quotationHistoryState`, `quotationHistoryCreationDate`, `quotationHistoryClosingDate`,  `quotationHistoryUserID`, `quotationHistoryCustomerID`, `quotationHistoryDealerUserID`,`quotationHistoryType`,`quotationHistoryFollowUpID`) 
VALUES ((SELECT quotationID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1 ),
 (SELECT quotationFinalValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationState FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCreationDate FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationClosingDate FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCustomerID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationDealerUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 'UPDATE',
 (SELECT followUpID FROM follow_ups WHERE followUpQuotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1));

END IF
$$


USE `followmeup`$$
DROP TRIGGER IF EXISTS `followmeup`.`insertAction` $$
USE `followmeup`$$


CREATE TRIGGER `insertAction` AFTER INSERT ON quotations FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
INSERT INTO `followmeup`.`quotation_histories` (`quotationHistoryQuotationID`, `quotationHistoryValue`, `quotationHistoryFinalValue`, `quotationHistoryState`, `quotationHistoryCreationDate`, `quotationHistoryClosingDate`,  `quotationHistoryUserID`, `quotationHistoryCustomerID`, `quotationHistoryDealerUserID`,`quotationHistoryType`,`quotationHistoryFollowUpID`) 
VALUES ((SELECT quotationID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1 ),
 (SELECT quotationFinalValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationState FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCreationDate FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationClosingDate FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCustomerID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationDealerUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 'INSERT',
 (SELECT followUpID FROM follow_ups WHERE followUpQuotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1));
END
$$


DELIMITER $$

USE `followmeup`$$
DROP TRIGGER IF EXISTS `followmeup`.`insertFollowUpAction` $$
USE `followmeup`$$


CREATE TRIGGER `insertFollowUpAction` AFTER INSERT ON follow_ups FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
UPDATE `quotation_histories` SET `quotationHistoryFollowUpID`= (SELECT followUpID FROM follow_ups WHERE followUpQuotationID = NEW.followUpID ORDER BY NEW.followUpInsertionDate1 DESC LIMIT 1) WHERE `quotationHistoryQuotationID`= NEW.followUpQuotationID;
END
$$


DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


