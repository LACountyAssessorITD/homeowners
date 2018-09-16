use [homeowner_test];

drop table [dbo].[claim_table];

create table claim_table
(
	claimID IDENTITY(1,1) PRIMARY KEY,
	claimant varchar(50) not null,
	claimantDOB date not null,
	claimantSSN numeric(9) not null,

	spouse varchar(50),
	spouseDOB date,
	spouseSSN numeric(9),

	currentAPN int not null,
	dateAcquired date not null,
	dateOccupied date not null,
	currentStNum int not null,
	currentStName varchar(50) not null,
	currentCity varchar(50) not null,
	currentZip int not null,

	priorAPN int,
	dateMovedOut date,
	priorStNum int,
	priorStName varchar(50),
	priorCity varchar(50),
	priorZip int,

	rollTaxYear int not null,
	exemptRE int not null,
	suppTaxYear int not null,
	exemptRE2 int not null,

	claimAction varchar(50),
	findingReason varchar(50),

	claimReceived date not null,
	supervisorWorkload date,
	staffReview date,
	staffReviewDate date,
	supervisorReview date,
	caseClosed date
);

select * from [temp_table];


/*
insert into [dbo].[claim_table] values (03456789, 'Porter', 'Harry', 'cs_phx', 23581234, 10.50, 'COMP',to_date('03-09-07','DD-MM-YY'));
*/






