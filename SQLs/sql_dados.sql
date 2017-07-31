INSERT INTO `roles` (`roleDesc`) VALUES 
('Administrator'),
('General Manager'),
('Manager'),
('Supervisor'),
('user');

INSERT INTO `departments` (`departmentName`) VALUES 
('Administrativo'),
('Diretoria'),
('Engenharia'),
('Marketing'),
('TI'),
('Vendas Externas'),
('Vendas Internas');

INSERT INTO `discount_groups` (`discountGroupName`) VALUES 
('OEM'),
('UF'),
('MP'),
('INT'),
('REV'),
('GERAL'),
('REVENDA'),
('REVENDA PREMIUM'),
('ATACADO'),
('OUTROS'),
('VVD');


INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('AC', 'Acre');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('AL', 'Alagoas');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('AP', 'Amapá');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('AM', 'Amazonas');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('BA', 'Bahia');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('CE', 'Ceará');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('DF', 'Distrito Federal');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('ES', 'Espírito Santo');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('GO', 'Goiás');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('MA', 'Maranhão');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('MT', 'Mato Grosso');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('MS', 'Mato Grosso do Sul');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('MG', 'Minas Gerais');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('PA', 'Pará');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('PB', 'Paraíba');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('PR', 'Paraná');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('PE', 'Pernambuco');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('PI', 'Piauí');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('RJ', 'Rio de Janeiro');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('RN', 'Rio Grande do Norte');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('RS', 'Rio Grande do Sul');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('RO', 'Rondônia');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('RR', 'Roraima');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('SC', 'Santa Catarina');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('SP', 'São Paulo');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('SE', 'Sergipe');
INSERT INTO `federation_units` (`fuAcronym`, `fuName`) VALUES ('TO', 'Tocantins');


INSERT INTO `users` (`userUser`, `userName`, `userDepartmentID`, `userPassword`, `userEmail`, `userPicturePath`, `userSalt`, `userRoleID`, `userStatus`) 
VALUES ('u222994','Juliana Pavanello' ,1 ,'' ,'juliana.pavanelo@wago.com' ,'' ,'' ,1 , default);

INSERT INTO `users` (`userUser`, `userName`, `userDepartmentID`, `userPassword`, `userEmail`, `userPicturePath`, `userSalt`, `userRoleID`, `userStatus`) 
VALUES ('u225721','Brian Silva' ,1 ,'' ,'brian.silva@wago.com' ,'' ,'' ,1 , default);

INSERT INTO `users` (`userUser`, `userName`, `userDepartmentID`, `userPassword`, `userEmail`, `userPicturePath`, `userSalt`, `userRoleID`, `userStatus`) 
VALUES ('u228820','Leonardo Leao' ,1 ,'' ,'leonardo.leao@wago.com' ,'' ,'' ,1 , default);

INSERT INTO `users` (`userUser`, `userName`, `userDepartmentID`, `userPassword`, `userEmail`, `userPicturePath`, `userSalt`, `userRoleID`, `userStatus`) 
VALUES ('u226700','Joelma Rossignatti' ,2 ,'' ,'joelma.rossignatti@wago.com' ,'' ,'' ,2 , default);

INSERT INTO `users` (`userUser`, `userName`, `userDepartmentID`, `userPassword`, `userEmail`, `userPicturePath`, `userSalt`, `userRoleID`, `userStatus`) 
VALUES ('u225417','Daiane Borim' ,1 ,'' ,'daiane.borim@wago.com' ,'' ,'' ,1 , default);

INSERT INTO `users` (`userUser`, `userName`, `userDepartmentID`, `userPassword`, `userEmail`, `userPicturePath`, `userSalt`, `userRoleID`, `userStatus`) 
VALUES ('u226277','Thais Mazzei' ,1 ,'' ,'Thais.mazzei@wago.com' ,'' ,'' ,1 , default);

INSERT INTO `users` (`userUser`, `userName`, `userDepartmentID`, `userPassword`, `userEmail`, `userPicturePath`, `userSalt`, `userRoleID`, `userStatus`) 
VALUES ('u226278','Marcelo Claro' , 7,'' ,'Thais.mazzei@wago.com' ,'' ,'' ,5 , default);

select * from users;
select * from login_attempts;

INSERT INTO `user_reports`(`userReportID`, `userReportTo`) VALUES (3,1);
INSERT INTO `user_reports`(`userReportID`, `userReportTo`) VALUES (3,2);
INSERT INTO `user_reports`(`userReportID`, `userReportTo`) VALUES (3,4);
INSERT INTO `user_reports`(`userReportID`, `userReportTo`) VALUES (1,4);
INSERT INTO `user_reports`(`userReportID`, `userReportTo`) VALUES (2,4);

INSERT INTO `customers`
(`customerCode`,
 `customerName`,
 `customerContactName`,
 `customerCNPJ`,
 `customerStatus`, 
 `customerRegion`,
 `customerSegmentID`,
 `customerEmail`,
 `customerZipCode`,
 `customerStreet`,
 `customerStreetNumber`,
 `customerNeighborhood`,
 `customerCity`, 
 `customerState`,
 `customerIBGE`,
 `customerLastModBy`,
 `customerTel`,
 `customerCel`) 

VALUES (  
  12345,
  'Marcenaria',
  'Brina Jonias',
  '04934837000173',
  'Cliente Ativo',
  25,
  1,
  'brian.jones@silva.com',
  '13295000',
  'Sei La',
  '232',
  'Sao Rock da Lapa',
  'JundCity',
  'SP',
  '123123123',
  1,
 '1145910199',
 '11972721766');

INSERT INTO `quotations` 
(`quotationNumber`,
 `quotationCustomerID`,
 `quotationValue`,
 `quotationFinalValue`,
 `quotationState`,
 `quotationCommuWay`,
 `quotationReceivedConf`,
 `quotationDealerUserID`,
 `quotationSendDate`,
 `quotationCreationDate`,
 `quotationUserID`,
 `quotationPriority`)
 
 VALUES ('1312312',
 1,
 131,
 132,
 'Teste',
 'Cell',
 TRUE,
 1,
 NOW(),
 NOW(),
 1,
 NULL);

select * from segments;
INSERT INTO `quotations` 
  (`quotationNumber`,
  `quotationCustomerID`,
  `quotationValue`,
  `quotationFinalValue`,
  `quotationState`,
  `quotationCommuWay`,
  `quotationReceivedConf`,
  `quotationDealerUserID`,
  `quotationSendDate`,
  `quotationCreationDate`,
  `quotationUserID`,
  `quotationPriority`,
  `quotationStatus`)
VALUES ('1312312',
 1,
 131,
 132,
 'Teste',
 'cELL',
 TRUE,
 1,
 NOW(),
 NOW(),
 1,
 NULL,
1);

select * from segments;


SELECT * FROM `follow_ups`
select 

UPDATE quotations SET quotationNumber = '1312312',
 quotationCustomerID = 1,
 quotationValue = 131324,
 quotationFinalValue = 13322,
 quotationState = 'Teste',
 quotationCommuWay = 'cELL',
 quotationReceivedConf = TRUE,
 quotationFollowUpID = 1,
 quotationDealerUserID = 1,
 quotationSendDate = NOW(),
 quotationCreationDate = NOW(),
 quotationUserID = 1,
 quotationPriority = NULL
WHERE quotationID = 1;




DELETE FROM quotation_histories WHERE quotationHistoryID = 1
DELETE FROM quotations WHERE quotationID = 1

select * from quotation_histories;
select * from followmeup.quotations 
LEFT JOIN followmeup.follow_ups ON (followUpID = followmeup.follow_ups.followUpID); 

SELECT quotationID, quotationNumber, followUpID, followUpDesc1, followUpUserID1, Users1.userName,followUpUserID2, Users2.userName FROM followmeup.quotations LEFT JOIN followmeup.follow_ups ON (followmeup.quotations.quotationID = follow_ups.followUpQuotationID) LEFT JOIN followmeup.users as Users1 ON (followmeup.follow_ups.followUpUserID1 = Users1.userID)LEFT JOIN followmeup.users as Users2 ON (followmeup.follow_ups.followUpUserID2 = Users2.userID)


select * from users ORDER BY userCreationDate LIMIT 2 ;

select * from roles;

select * from login_attempts;

delete from login_attempts where loginattemptuserid = 1;

update users set userName = 'Brian Jones' where userID = 1;

SELECT roleDesc from roles LEFT JOIN users ON (followmeup.users.userroleid = followmeup.roles.roleID) where roleID = 1;

INSERT INTO `quotations` (`quotationNumber`, `quotationCustomerID`, `quotationValue`, `quotationFinalValue`, `quotationStatus`, `quotationCommuWay`, `quotationReceivedConf`, `quotationFollowUpID`, `quotationDealerUserID`, `quotationInsertionDate`, `quotationLastModified`, `quotationSendDate`, `quotationCreationDate`, `quotationUserID`, `quotationPriority`)  VALUES ('1312312', 12, 13, 132, 'Teste', 'cELL', 2, NULL, 3, NULL, NULL, NULL, NULL, 2, NULL)

ALTER TABLE usersuserDepartmentID
ADD CONSTRAINT fk_usersDepartments
FOREIGN KEY (userDepartmentID)
REFERENCES departments(departmentID)

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


DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


