use [homeowner_test];

drop table [dbo].[claim_table];

create table claim_table
(
	claimID int IDENTITY(1,1) PRIMARY KEY,
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

select * from [claim_table];



insert into [dbo].[claim_table] values ('he, molly', '1997-01-01', 123456789, null, null, null, 1234567890, '2015-12-12',' 2015-12-13', 123, 'any street', 'los angeles', 90012, 1234567890, '2015-01-01', 123, 'any street', 'los angeles', 90012, 218000, 7000, 218000, 7000, 'Met', 'Other', '2018-01-01', '2018-01-02', '2018-01-03', '2018-01-04', '2018-01-05', '2018-01-06');
