use [homeowner_test];

drop table [dbo].[claimant_table];

create table claimant_table
(
	claimantID int IDENTITY(1,1) PRIMARY KEY,
	claimant varchar(50),
	claimantSSN numeric(9),

	spouse varchar(50),
	spouseSSN numeric(9),

	mailingStName varchar(50),
	mailingApt varchar(50),
	mailingCity varchar(50),
	mailingState varchar(50),
	mailingZip int
);

select * from [claimant_table];



insert into [dbo].[claimant_table] values ('he, molly', 123456789, null, null, '123 any street', null, 'los angeles', 'ca', 90012);
