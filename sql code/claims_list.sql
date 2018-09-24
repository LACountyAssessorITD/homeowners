use [homeowner_test];

drop table [dbo].[claims_list];

create table claims_list
(
	claimID int not null PRIMARY KEY,
	AIN int not null,
	claimantSSN numeric(9) not null,
);