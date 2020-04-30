-- MySQL Script generated by MySQL Workbench
-- Sat Apr 25 12:06:57 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema CustomerOrders
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `CustomerOrders` ;

-- -----------------------------------------------------
-- Schema CustomerOrders
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `CustomerOrders` DEFAULT CHARACTER SET utf8 ;
USE `CustomerOrders` ;

-- -----------------------------------------------------
-- Table `CustomerOrders`.`Customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CustomerOrders`.`Customers` ;

CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Customers` (
  `CustomerID` INT NOT NULL AUTO_INCREMENT,
  `FName` VARCHAR(45) NOT NULL,
  `LName` VARCHAR(45) NOT NULL,
  `Email` VARCHAR(255) NOT NULL,
  `Active` TINYINT NOT NULL DEFAULT 1,
  `CreateDate` DATETIME NOT NULL DEFAULT NOW(),
  `UpdateDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`CustomerID`),
  UNIQUE INDEX `CustomerID_UNIQUE` (`CustomerID` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `CustomerOrders`.`Customers_txn`
-- This is used to track changes to customers
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Customers_txn` (
  `CustomerTXNID` INT NOT NULL AUTO_INCREMENT,
  `CustomerID` INT NOT NULL,
  `FName` VARCHAR(45) NOT NULL,
  `LName` VARCHAR(45) NOT NULL,
  `Email` VARCHAR(255) NOT NULL,
  `Active` TINYINT,
  `CreateDate` DATETIME NOT NULL,
  `UpdateDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`CustomerTXNID`),
  UNIQUE INDEX `CustomerTXNID_UNIQUE` (`CustomerTXNID` ASC),
  CONSTRAINT `fk_customerorders`
    FOREIGN KEY (`CustomerID`)
    REFERENCES `CustomerOrders`.`Customers` (`CustomerID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Trigger to populate Transaction table
-- -----------------------------------------------------
CREATE TRIGGER customer_txn_trigger
	BEFORE UPDATE
		ON Customers FOR EACH ROW
	INSERT INTO Customers_txn
		(
			CustomerID,
      FName,
      LName,
      Email,
      Active,
      CreateDate,
      UpdateDate
		) VALUES (
			old.CustomerID,
      old.FName,
      old.LName,
      old.Email,
      old.Active,
      old.CreateDate,
      old.UpdateDate
		);

-- -----------------------------------------------------
-- Table `CustomerOrders`.`Address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CustomerOrders`.`Address` ;

CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Address` (
  `AddressID` INT NOT NULL AUTO_INCREMENT,
  `Street` VARCHAR(255) NOT NULL,
  `Street2` VARCHAR(255) NULL,
  `City` VARCHAR(100) NOT NULL,
  `StateAbr` VARCHAR(2) NOT NULL,
  `Zip` VARCHAR(10) NOT NULL,
  `Active` TINYINT NOT NULL DEFAULT 1,
  `CreateDate` DATETIME NOT NULL DEFAULT NOW(),
  `UpdateDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`AddressID`),
  UNIQUE INDEX `AdressID_UNIQUE` (`AddressID` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `CustomerOrders`.`Address_txn`
-- This is used to track changes to Addresses
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Address_txn` (
  `AddressTXNID` INT NOT NULL AUTO_INCREMENT,
  `AddressID` INT NOT NULL,
  `Street` varchar(255) not null,
  `Street2` varchar(255) null,
  `City` varchar(100) not null,
  `StateAbbr` varchar(2) not null,
  `Zip` varchar(10) not null,
  `Active` TINYINT NOT NULL DEFAULT 1,
  `CreateDate` DATETIME NOT NULL DEFAULT NOW(),
  `UpdateDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`AddressTXNID`),
  UNIQUE INDEX `AdressTXNID_UNIQUE` (`AddressTXNID` ASC),
  CONSTRAINT `fk_customerorders`
    FOREIGN KEY (`AddressID`)
    REFERENCES `CustomerOrders`.`Address` (`AddressID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Trigger to populate Transaction table
-- -----------------------------------------------------
CREATE TRIGGER address_txn_trigger
	BEFORE UPDATE
		ON Address FOR EACH ROW
	INSERT INTO Address_txn
    (
  		AddressID,
      Street,
      Street2,
      City,
      StateAbbr,
      Zip,
      Active,
      CreateDate,
      UpdateDate
    ) VALUES (
  		old.AddreessID,
      old.Street,
      old.Street2,
      old.City,
      old.StateAbbr,
      old.Zip,
      old.Active,
      old.CreateDate,
      old.UpdateDate
    );

-- -----------------------------------------------------
-- Table `CustomerOrders`.`CustomerAddressXref`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CustomerOrders`.`CustomerAddressXref` ;

CREATE TABLE IF NOT EXISTS `CustomerOrders`.`CustomerAddressXref` (
  `CustomerID` INT NOT NULL,
  `AddressID` INT NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`CustomerID`, `AddressID`),
  UNIQUE INDEX `CustomerID_UNIQUE` (`CustomerID` ASC),
  UNIQUE INDEX `AddressID_UNIQUE` (`AddressID` ASC),
  CONSTRAINT `fkCustomerAddress`
    FOREIGN KEY (`CustomerID`)
    REFERENCES `CustomerOrders`.`Customers` (`CustomerID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkAddressCustomer`
    FOREIGN KEY (`AddressID`)
    REFERENCES `CustomerOrders`.`Address` (`AddressID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CustomerOrders`.`Orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `CustomerOrders`.`Orders` ;

CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Orders` (
  `OrderID` INT NOT NULL AUTO_INCREMENT,
  `Description` VARCHAR(255) NULL,
  `CustomerID` INT NOT NULL,
  `AddressID` INT NOT NULL,
  `Active` TINYINT,
  `Status` ENUM ('Waiting', 'Accepted', 'Prepared', 'Shipped') NOT NULL DEFAULT 'Waiting',
  `Alert` TINYINT NOT NULL DEFAULT 0,
  `CreateDate` DATETIME NOT NULL,
  `UpdateDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  UNIQUE INDEX `idOrders_UNIQUE` (`OrderID` ASC),
  INDEX `fk_customerorders_idx` (`CustomerID` ASC),
  CONSTRAINT `fk_customerorders`
    FOREIGN KEY (`CustomerID`)
    REFERENCES `CustomerOrders`.`Customers` (`CustomerID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customerorders`
    FOREIGN KEY (`AddressID`)
		REFERENCES `CustomerOrders`.`Address` (`AddressID`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `CustomerOrders`.`Orders_txn`
-- This is used to track changes to Orders
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Orders_txn` (
  `OrderTXNID` INT NOT NULL AUTO_INCREMENT,
  `OrderID` INT NOT NULL,
  `Description` VARCHAR(255) NULL,
  `CustomerID` INT NOT NULL,
  `AddressID` INT NOT NULL,
  `Active` TINYINT,
  `Status` ENUM ('Waiting', 'Accepted', 'Prepared', 'Shipped') NOT NULL DEFAULT 'Waiting',
  `Alert` TINYINT NOT NULL DEFAULT 0,
  `CreateDate` DATETIME NOT NULL,
  `UpdateDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`OrderTXNID`),
  UNIQUE INDEX `idTXNOrders_UNIQUE` (`OrderTXNID` ASC),
  INDEX `fk_customerorders_idx` (`OrdersID` ASC),
  INDEX `fk_customerorders_idx` (`CustomerID` ASC),
  CONSTRAINT `fk_customerorders`
    FOREIGN KEY (`OrderID`)
    REFERENCES `CustomerOrders`.`Orders` (`OrdersID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customerorders`
    FOREIGN KEY (`CustomerID`)
    REFERENCES `CustomerOrders`.`Customers` (`CustomerID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customerorders`
    FOREIGN KEY (`AddressID`)
		REFERENCES `CustomerOrders`.`Address` (`AddressID`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Trigger to populate Transaction table
-- -----------------------------------------------------
CREATE TRIGGER order_txn_trigger
	BEFORE UPDATE
		ON Orders FOR EACH ROW
	INSERT INTO Orders_txn
		(
			OrderID,
      Description,
      CustomerID,
      AddressID,
      Active,
      Status,
      Alert,
      CreateDate,
      UpdateDate
    ) VALUES (
			old.OrderID,
      old.Description,
      old.CustomerID,
      old.AddressID,
      old.Active,
      old.Status,
      old.Alert,
      old.CreateDate,
      old.UpdateDate
    );

-- ----------------------------------------------------
-- Stored Procedures
-- ----------------------------------------------------
delimiter ||
-- Create
CREATE PROCEDURE newCustomer(
  IN fName VARCHAR(45),
  IN lName VARCHAR(45),
  IN email VARCHAR(255)
)
BEGIN
	INSERT INTO Customers
  (
    FName,
    LName,
    Email
	) VALUES (
    fName,
    lName,
    email
  );
END ||

CREATE PROCEDURE newOrder(
  IN description VARCHAR(255),
  IN customerID INT,
  IN addressID INT
)
BEGIN
	INSERT INTO Orders (Description, CustomerID, AddressID)
	VALUES (
		description,
		customerID,
		addressID
	);
END ||

CREATE PROCEDURE newAddress(
	IN street VARCHAR(255),
  IN street2 VARCHAR(255),
  IN city VARCHAR(255),
  IN stateAbbr VARCHAR(255),
  IN zip VARCHAR(255)
)
BEGIN
	insert into Address
  (
		Street,
    Street2,
    City,
    StateAbbr,
    Zip
	) VALUES (
		street,
    street2,
    city,
    stateAbbr,
    zip
  );
end ||

CREATE PROCEDURE newCustomerAddressXref(
	IN customerID INT,
  IN addressID INT,
	IN name VARCHAR(255)
)
BEGIN
	INSERT INTO CustomerAddressXref
  (
		CustomerID,
    AddressID,
    Name
	) VALUES (
		customerID,
    addressID,
    name
  );
END ||

-- Update
CREATE PROCEDURE updateCustomer(
	IN customerID INT,
  IN fName VARCHAR(255),
  IN lName VARCHAR(255),
  IN email VARCHAR(255)
)
BEGIN
	UPDATE Customers
		SET FName = QUOTE(fName),
        LName = QUOTE(lName),
				Email = QUOTE(email),
        updateDate = NOW()
	WHERE CustomerID = customerID;
END ||

CREATE PROCEDURE updateOrder(
	IN orderID INT,
  IN _desc VARCHAR(255),
  IN customerID INT,
  IN addressID INT
)
BEGIN
	UPDATE Orders
		SET Description = QUOTE(_desc),
        CustomerID = QUOTE(customerID),
        AddressID = QUOTE(addressID)
	WHERE OrderID = orderID;
END ||

CREATE PROCEDURE updateAddress (
  IN addressID INT,
  IN street VARCHAR(255),
  IN street2 VARCHAR(255),
  IN city VARCHAR(255),
  IN stateAbbr VARCHAR(2),
  IN zip VARCHAR(10)
)
BEGIN
  UPDATE Address
    SET
  		Street = street,
  		Street2 = street2,
  		City = city,
  		StateAbbr = stateAbbr,
  		Zip = zip
  WHERE AddressID = addressID;
END ||

CREATE PROCEDURE orderAlerted (
  IN orderID INT
)
BEGIN
  UPDATE Orders
    SET Alert = 1
  WHERE OrderID = orderID;
END ||

CREATE PROCEDURE orderStatusAccepted (
  IN orderID INT
)
BEGIN
  UPDATE Orders
    SET Status = 'Accepted',
        Alert = 0
  WHERE OrderID = orderID;
END ||

CREATE PROCEDURE orderStatusPrepared (
  IN orderID INT
)
BEGIN
  UPDATE Orders
    SET Status = 'Prepared',
        Alert = 0
  WHERE OrderID = orderID;
END ||

CREATE PROCEDURE orderStatusShipped (
  IN orderID INT
)
BEGIN
  UPDATE Orders
    SET Status = 'Shipped',
        Alert = 0
  WHERE OrderID = orderID;
END ||

-- Delete
CREATE PROCEDURE deleteCustomer (
  IN customerID INT
)
BEGIN
  UPDATE Customers
    SET Active = 0
  WHERE CustomerID = customerID;
END ||

CREATE PROCEDURE deleteOrder (
  IN orderID INT
)
BEGIN
  UPDATE Orders
    SET Active = 0
  WHERE OrderID = orderID;
END ||

CREATE PROCEDURE deleteAddress (
  IN addressID INT
)
BEGIN
  UPDATE Address
    SET Active = 0
  WHERE AddressID = addressID;
END ||

CREATE PROCEDURE deleteCustomerAddressXRef (
  IN customerID INT,
  IN addressID INT
)
BEGIN
  DELETE FROM CustomerAddressXref
  WHERE CustomerID = customerID
    AND AddressID = addressID;
END ||

-- Select
CREATE PROCEDURE getCustomerByID (
  IN customerID INT
)
BEGIN
  SELECT
    *
  FROM Customers
  WHERE CustomerID = customerID;
END ||

CREATE PROCEDURE getOrderByID (
  IN orderID INT
)
BEGIN
  SELECT
    *
  FROM Orders
  WHERE OrderID = orderID;
END ||

CREATE PROCEDURE getAddressByID (
  IN addressID INT
)
BEGIN
  SELECT
    *
  FROM Address
  WHERE AddressID = addressID;
END || 

CREATE PROCEDURE getOrderMetaDataByID (
IN orderID INT
)
BEGIN  
  SELECT 
    Orders.OrderID,
    concat(
      Customers.FName,
      ' ',
      Customers.LName
    ) as name,
    concat(
      Address.Street,
      ' ',
      Address.Street2,
      ', ',
      Address.City,
      ', ',
      Address.stateAbbr,
      ', ',
      Address.zip
    ) as address
  FROM Orders
    JOIN Customers
      ON Orders.CustomerID = Customers.CustomerID
    JOIN Address
      ON Orders.AddressID = Address.AddressID
  WHERE Orders.OrderID = orderID;
END ||

DELIMITER ;

-- Views
CREATE VIEW ActiveCustomers AS
  SELECT
    *
  FROM Customers
  WHERE Active = 1;

CREATE VIEW InactiveCustomers AS
  SELECT
    *
  FROM Customers
  WHERE Active = 0;

CREATE VIEW ActiveOrders AS
  SELECT
    *
  FROM Orders
  WHERE Active = 1;

CREATE VIEW InactiveOrders AS
	SELECT
	*
	FROM Orders
	WHERE Active = 0;

CREATE VIEW ActiveAddress AS
  SELECT
    *
  FROM Address
  WHERE Active = 1;

CREATE VIEW InactiveAddress AS
	SELECT
	  *
	FROM Address
	WHERE Active = 0;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
