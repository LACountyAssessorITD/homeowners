use [homeowner_test];

drop table [dbo].[claims_list];

create table claims_list
(
	claimID int IDENTITY(1,1) PRIMARY KEY,
	AIN int not null,
	claimantSSN numeric(9) not null,
);

insert into [dbo].[claims_list] values (1234567890, 123456789);

select * from claims_list;