delimiter ||
create procedure updateAddress (
  IN addressID INT,
  IN street VARCHAR(255),
  IN street2 VARCHAR(255),
  IN city VARCHAR(255),
  IN StateAbbr VARCHAR(2),
  IN Zip VARCHAR(10)
)
   begin
   update Address
    set Street = street,
      Street2 = street2,
      City = city,
      stateAbbr = StateAbbr,
      zip = Zip
    where AddressID = addressID;
   end ||

-- retrospect of just writing this procedure, not super useful.
create procedure updateCustomerAddressXrefByName(
  IN customerID INT,
  IN addressID INT,
  IN name VARCHAR(255)
)
begin
  update CustomerAddressXref
    set CustomerID = customerID,
    AddressID = addressID
  where Name = name;
end ||
create procedure deleteCustomer( IN customerID INT )
begin
  delete from Customers where CustomerID = customerID;
end ||
create procedure deleteOrder( IN orderID INT )
begin
  delete from Orders where OrderID = orderID;
end ||
create procedure deleteeAddress( IN addressID INT )
begin
  delete from Address where AddressID = addressID;
end ||
create procedure deleteCustomerAddressXRefByName  ( IN name VARCHAR(255) )
begin
  delete from CustomerAddressXref where Name = name;
end ||

create procedure order_info_by_id ( IN orderID INT )
  as
    select
      Orders.OrderID,
      concat(
        Customer.FName,
        ' ',
        Customer.LName
      ) as name,
      concat(
        Address.Street,
        ' ',
        Address.Street2,
        ', '
        Address.City,
        ', ',
        Address.stateAbbr,
        ', ',
        Address.zip
      ) as address
    from Orders
      join Customers on Orders.CustomerID = Customers.CustomerID
      join Address on Orders.AddressID = Address.AddressID
    where Orders.OrderID = orderID;
delimiter ;
