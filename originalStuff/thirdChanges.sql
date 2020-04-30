create view newCustomerIntervals as
  select
  (
    select
      count(Customers.CustomerID)
    from Customers
    where Customers.createDate between NOW() and subdate(NOW(), interval 1 day )
  ) as within_last_day,
  (
    select
      count(Customers.CustomerID)
    from Customers
    where Customers.createDate between NOW() and subdate(NOW(), interval 1 week )
  ) as within_last_week,
  (
    select
      count(Customers.CustomerID)
    from Customers
    where Customers.createDate between NOW() and subdate(NOW(), interval 1 month )
  ) as within_last_month,
  (
    select
      count(Customers.CustomerID)
    from Customers
    where Customers.createDate between NOW() and subdate(NOW(), interval 3 month )
  ) as within_last_three_months;

delimiter ||

  create function customerOrderCount ( customerID INT ) returns INT
	begin
		declare orderCount INT;
        set orderCount = (select count(OrderID) from Orders where CustomerID = customerID);
        return orderCount;
	end ||

delimiter ;
