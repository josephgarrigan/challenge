use CustomerOrders;
alter table Customers
	add column active tinyint default 1,
    add column createDate datetime not null default now(),
    add column updateDate datetime null default null;

alter table Orders
	add column AddressID INT NOT NULL,
    add index ind_addrId (AddressID),
	add FOREIGN KEY (`AddressID`)
		REFERENCES `CustomerOrders`.`Address` (`AddressID`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION;

alter table Address
	add column Street varchar(255) not null,
    add column Street2 varchar(255) null,
    add column City varchar(100) not null,
    add column stateAbbr varchar(2) not null,
    add column zip varchar(10) not null;

CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Customers_txn` (
  `CustomerTXNID` INT NOT NULL AUTO_INCREMENT,
  `CustomerID` INT NOT NULL,
  `FName` VARCHAR(45) NOT NULL,
  `LName` VARCHAR(45) NOT NULL,
  `Email` VARCHAR(255) NOT NULL,
  `active` TINYINT,
  `createDate` DATETIME NOT NULL,
  `updateDate` DATETIME NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`CustomerTXNID`),
  UNIQUE INDEX `CustomerTXNID_UNIQUE` (`CustomerTXNID` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Orders_txn` (
  `OrderTXNID` INT NOT NULL AUTO_INCREMENT,
  `OrderID` INT NOT NULL,
  `Description` VARCHAR(255) NULL,
  `CustomerID` INT NOT NULL,
  PRIMARY KEY (`OrderID`),
  UNIQUE INDEX `idOrders_UNIQUE` (`OrderID` ASC),
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
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `CustomerOrders`.`Address_txn` (
  `AddressTXNID` INT NOT NULL AUTO_INCREMENT,
  `AddressID` INT NOT NULL,
  `Street` varchar(255) not null,
  `Street2` varchar(255) null,
  `City` varchar(100) not null,
  `stateAbbr` varchar(2) not null,
  `zip` varchar(10) not null,
  PRIMARY KEY (`AddressTXNID`),
  UNIQUE INDEX `AdressID_UNIQUE` (`AddressTXNID` ASC))
ENGINE = InnoDB;

delimiter ||
CREATE TRIGGER address_txn_trigger
	before update
		on Address for each row
	insert into Address_txn (
		AddressID,
        Street,
        Street2,
        City,
        stateAbbr,
        zip
    )
    VALUES (
		old.AddreessID,
        old.Street,
        old.Street2,
        old.City,
        old.stateAbbr,
        old.zip
    );

CREATE TRIGGER customer_txn_trigger
	before update
		on Customers for each row
	insert into Customers_txn
		(
			CustomerID,
            FName,
            LName,
            Email,
            active,
            createDate
		) values (
			old.CustomerID,
            old.FName,
            old.LName,
            old.Email,
            old.active,
            old.createDate
		);

CREATE TRIGGER order_txn_trigger
	before update
		on Orders for each row
	insert into Orders_txn
		(
			OrderID,
            Description,
            CustomerID,
            AddressID
        ) values (
			old.OrderID,
            old.Description,
            old.CustomerID,
            old.AddressID
        );

delimiter ||
create procedure newCustomer(
    IN fName VARCHAR(45),
    IN lName VARCHAR(45),
    IN email VARCHAR(255)
)
begin
	insert into Customers
    (
        FName,
        LName,
        Email
	) values (
        fName,
        lName,
        email
    );
end ||
create procedure newOrder(
    IN description VARCHAR(255),
    IN customerID INT,
    IN addressID INT
)
begin
	insert into Orders (
        Description,
        CustomerID,
        AddressID
	) VALUES (
		description,
        customerID,
        addressID
	);
end ||
create procedure newAddress(
	IN street VARCHAR(255),
    IN street2 VARCHAR(255),
    IN city VARCHAR(255),
    IN StateAbbr VARCHAR(255),
    IN Zip VARCHAR(255)
)
begin
	insert into Address
    (
		Street,
        Street2,
        City,
        stateAbbr,
        zip
	) VALUES (
		street,
        street2,
        city,
        StateAbbr,
        Zip
    );
end ||
create procedure newCustomerAddressXref(
	IN customerID INT,
    IN addressID INT,
	IN name VARCHAR(255)
)
begin
	insert into CustomerAddressXref
    (
		CustomerID,
        AddressID,
        Name
	) VALUES (
		customerID,
        addressID,
        name
    );
end ||
create procedure updateCustomer(
	IN customerID INT,
    IN fName VARCHAR(255),
    IN lName VARCHAR(255),
    IN email VARCHAR(255)
)
begin
	update Customer
		set FName = fName,
        LName = lName,
		Email = email,
        updateDate = NOW()
	where CustomerID = customerID;
end ||
create procedure updateOrder(
	IN orderID INT,
    IN _desc VARCHAR(255),
    IN customerID INT,
    IN addressID INT
) begin
	update Orders
		set Description = _desc,
        CustomerID = customerID,
        AddressID = addressID
	where OrderID = orderID;
end ||
delimiter ;
