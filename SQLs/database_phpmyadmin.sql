
CREATE  TABLE `departments` (
  `departmentID` INT NOT NULL AUTO_INCREMENT ,
  `departmentName` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`departmentID`) )
ENGINE = InnoDB;

CREATE  TABLE `roles` (
  `roleID` INT NOT NULL AUTO_INCREMENT ,
  `roleDesc` VARCHAR(45) NULL ,
  PRIMARY KEY (`roleID`) )
ENGINE = InnoDB;
CREATE  TABLE `users` (
  `userID` INT NOT NULL AUTO_INCREMENT ,
  `userUser` VARCHAR(45) NOT NULL ,
  `userName` VARCHAR(45) NOT NULL ,
  `userDepartmentID` INT NOT NULL ,
  `userPassword` CHAR(128) NULL ,
  `userEmail` VARCHAR(45) NULL ,
  `userPicturePath` VARCHAR(45) NULL ,
  `userCreationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `userLastMod` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP ,
  `userSalt` CHAR(128) NULL ,
  `userRoleID` INT NOT NULL ,
  `userStatus` INT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`userID`) ,
  INDEX `userDepartmentID_idx` (`userDepartmentID` ASC) ,
  INDEX `userRoleID_idx` (`userRoleID` ASC) ,
  CONSTRAINT `userDepartmentID`
    FOREIGN KEY (`userDepartmentID` )
    REFERENCES `departments` (`departmentID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `userRoleID`
    FOREIGN KEY (`userRoleID` )
    REFERENCES `roles` (`roleID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE  TABLE `user_reports` (
  `userReportID` INT NOT NULL ,
  `userReportTo` INT NOT NULL ,
  PRIMARY KEY (`userReportID`, `userReportTo`) ,
  INDEX `userReportTo_idx` (`userReportTo` ASC) ,
  CONSTRAINT `userReportID`
    FOREIGN KEY (`userReportID` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `userReportTo`
    FOREIGN KEY (`userReportTo` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `discount_groups` (
  `discountGroupID` INT NOT NULL AUTO_INCREMENT ,
  `discountGroupName` VARCHAR(45) NOT NULL ,
   PRIMARY KEY (`discountGroupID`))
ENGINE = InnoDB;

DROP TABLE IF EXISTS `Federation_units` ;

CREATE  TABLE `federation_units` (
  `fuID` INT NOT NULL AUTO_INCREMENT ,
  `fuAcronym` VARCHAR(2) NOT NULL ,
  `fuName` VARCHAR(45) NULL ,
   PRIMARY KEY (`fuID`))
ENGINE = InnoDB;

DROP TABLE IF EXISTS `customers` ;

CREATE  TABLE `customers` (
  `customerID` INT NOT NULL AUTO_INCREMENT ,
  `customerCode` INT(10) NOT NULL ,
  `customerName` VARCHAR(45) NULL ,
  `customerContactName` VARCHAR(45) NULL ,
  `customerCNPJ` VARCHAR(45) NULL ,
  `customerStatus` VARCHAR(45) NULL ,
  `customerCreationDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `customerLastMod` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP ,
  `customerSalesManID` INT NOT NULL ,
  `customerDiscountGroupID` INT NOT NULL ,
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
    REFERENCES `users` (`userid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `customerLastModBy`
    FOREIGN KEY (`customerLastModBy` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `customerDiscountGroupID`
    FOREIGN KEY (`customerDiscountGroupID` )
    REFERENCES `discount_groups` (`discountGroupID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE  TABLE `follow_ups` (
  `followUpID` INT NOT NULL AUTO_INCREMENT ,
  `followUpQuotationID` INT NOT NULL,
  `followUpDesc1` VARCHAR(45) NULL ,
  `followUpUserID1` INT NULL ,
  `followUpInsertionDate1` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
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
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `followUpUserID2`
    FOREIGN KEY (`followUpUserID2` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `followUpUserID3`
    FOREIGN KEY (`followUpUserID3` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationFollowUpID`
    FOREIGN KEY (`followUpQuotationID` )
    REFERENCES `quotations` (`quotationID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE  TABLE `quotations` (
  `quotationID` INT NOT NULL AUTO_INCREMENT ,
  `quotationNumber` INT NOT NULL ,
  `quotationCustomerID` INT NOT NULL ,
  `quotationValue` DOUBLE NULL ,
  `quotationFinalValue` DOUBLE NULL ,
  `quotationState` VARCHAR(45) NOT NULL ,
  `quotationCommuWay` VARCHAR(45) NULL ,
  `quotationReceivedConf` TINYINT(1) NULL ,
  `quotationDealerUserID` INT NOT NULL ,
  `quotationInsertionDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `quotationLastModified` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP ,
  `quotationSendDate` DATETIME NULL ,
  `quotationCreationDate` DATETIME NULL ,
  `quotationUserID` INT NOT NULL ,
  `quotationPriority` CHAR(1) NULL ,
  `quotationStatus` TINYINT(1) NOT NULL DEFAULT TRUE ,
  PRIMARY KEY (`quotationID`) ,
  INDEX `quotationCustomerID_idx` (`quotationCustomerID` ASC) ,
  INDEX `quotationUserID_idx` (`quotationUserID` ASC) ,
  INDEX `quotationDealerUserID_idx` (`quotationDealerUserID` ASC) ,
  CONSTRAINT `quotationCustomerID`
    FOREIGN KEY (`quotationCustomerID` )
    REFERENCES `customers` (`customerID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
  CONSTRAINT `quotationUserID`
    FOREIGN KEY (`quotationUserID` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationDealerUserID`
    FOREIGN KEY (`quotationDealerUserID` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '	';


DROP TABLE IF EXISTS `quotation_histories` ;

CREATE  TABLE `quotation_histories` (
  `quotationHistoryID` INT NOT NULL AUTO_INCREMENT ,
  `quotationHistoryQuotationID` INT NULL ,
  `quotationHistoryValue` DOUBLE NULL ,
  `quotationHistoryFinalValue` DOUBLE NULL ,
  `quotationHistoryState` VARCHAR(45) NULL ,
  `quotationHistoryUserID` INT NULL ,
  `quotationHistoryCustomerID` INT NULL ,
  `quotationHistoryDealerUserID` INT NULL ,
  `quotationHistoryType` VARCHAR(10) NULL ,
  `quotationHistoryFollowUpID` INT NULL ,
  `quotationHistoryEventDate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`quotationHistoryID`) ,
  INDEX `quotationHistoryQuotationID_idx` (`quotationHistoryQuotationID` ASC) ,
  INDEX `quotationHistoryCustomerID_idx` (`quotationHistoryCustomerID` ASC) ,
  INDEX `quotationHistoryDealerID_idx` (`quotationHistoryDealerUserID` ASC) ,
  INDEX `quotationHistoryFollowUpID_idx` (`quotationHistoryFollowUpID` ASC) ,
  CONSTRAINT `quotationHistoryQuotationID`
    FOREIGN KEY (`quotationHistoryQuotationID` )
    REFERENCES `quotations` (`quotationID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationHistoryUserID`
    FOREIGN KEY (`quotationHistoryUserID` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationHistoryCustomerID`
    FOREIGN KEY (`quotationHistoryCustomerID` )
    REFERENCES `customers` (`customerID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `quotationHistoryDealerUserID`
    FOREIGN KEY (`quotationHistoryDealerUserID` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


DROP TABLE IF EXISTS `password_recoveries` ;

CREATE  TABLE `password_recoveries` (
  `passwordID` INT NOT NULL AUTO_INCREMENT ,
  `userID` INT NOT NULL ,
  `token` VARCHAR(255) NOT NULL ,
  `status` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`passwordID`) ,
  INDEX `userID_idx` (`userID` ASC) ,
  CONSTRAINT `userID`
    FOREIGN KEY (`userID` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

DROP TABLE IF EXISTS `login_attempts` ;

CREATE  TABLE `login_attempts` (
  `loginAttemptID` INT NOT NULL AUTO_INCREMENT ,
  `loginAttemptUserID` INT NOT NULL ,
  `tried_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`loginAttemptID`, `loginAttemptUserID`) ,
  INDEX `loginAttemptUserID_idx` (`loginAttemptUserID` ASC) ,
  CONSTRAINT `loginAttemptUserID`
    FOREIGN KEY (`loginAttemptUserID` )
    REFERENCES `users` (`userID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `followMeUp` ;
USE `followMeUp`;

DELIMITER $$

USE `followMeUp`$$
DROP TRIGGER IF EXISTS `updateAction` $$
USE `followMeUp`$$


CREATE TRIGGER `updateAction` AFTER UPDATE ON quotations FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
IF ((SELECT quotationStatus FROM quotations WHERE quotationID = NEW.quotationID ORDER BY quotationInsertionDate DESC LIMIT 1) = FALSE)
THEN 
INSERT INTO `quotation_histories` (`quotationHistoryQuotationID`, `quotationHistoryValue`, `quotationHistoryFinalValue`, `quotationHistoryState`, `quotationHistoryUserID`, `quotationHistoryCustomerID`, `quotationHistoryDealerUserID`,`quotationHistoryType`,`quotationHistoryFollowUpID`) 
VALUES ((SELECT quotationID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1 ),
 (SELECT quotationFinalValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationState FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCustomerID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationDealerUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 'DELETE',
 (SELECT followUpID FROM follow_ups WHERE followUpQuotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1));
ELSEIF ((SELECT quotationStatus FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1) = TRUE)
THEN
INSERT INTO `quotation_histories` (`quotationHistoryQuotationID`, `quotationHistoryValue`, `quotationHistoryFinalValue`, `quotationHistoryState`, `quotationHistoryUserID`, `quotationHistoryCustomerID`, `quotationHistoryDealerUserID`,`quotationHistoryType`,`quotationHistoryFollowUpID`) 
VALUES ((SELECT quotationID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1 ),
 (SELECT quotationFinalValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationState FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCustomerID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationDealerUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 'UPDATE',
 (SELECT followUpID FROM follow_ups WHERE followUpQuotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1));

END IF
$$


USE `followMeUp`$$
DROP TRIGGER IF EXISTS `insertAction` $$
USE `followMeUp`$$


CREATE TRIGGER `insertAction` AFTER INSERT ON quotations FOR EACH ROW
-- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
INSERT INTO `quotation_histories` (`quotationHistoryQuotationID`, `quotationHistoryValue`, `quotationHistoryFinalValue`, `quotationHistoryState`, `quotationHistoryUserID`, `quotationHistoryCustomerID`, `quotationHistoryDealerUserID`,`quotationHistoryType`,`quotationHistoryFollowUpID`) 
VALUES ((SELECT quotationID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1 ),
 (SELECT quotationFinalValue FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationState FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationCustomerID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 (SELECT quotationDealerUserID FROM quotations WHERE quotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1),
 'INSERT',
 (SELECT followUpID FROM follow_ups WHERE followUpQuotationID = NEW.quotationID ORDER BY NEW.quotationInsertionDate DESC LIMIT 1));
END
$$


DELIMITER $$

USE `followMeUp`$$
DROP TRIGGER IF EXISTS `insertFollowUpAction` $$
USE `followMeUp`$$


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


