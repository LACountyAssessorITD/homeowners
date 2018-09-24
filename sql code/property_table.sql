use [homeowner_test];

drop table [dbo].[property_table];

create table property_table
(
	AIN int PRIMARY KEY,
	streetName varchar(50),
	apt varchar(50),
	city varchar(50),
	state varchar(50),
	zip int,

	ownerName varchar(50),
	ownerSSN int,
	dateAcquired date,
	dateOccupied date,
	dateMovedOut date
);

select * from [property_table];


insert into [dbo].[property_table] values (123456789, '123 any street', null, 'los angeles', 'ca', 90012, 'molly he', 123456789, '2010-01-01', '2010-01-02', '2017-11-22');
