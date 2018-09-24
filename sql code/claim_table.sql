use [homeowner_test];

drop table [dbo].[claim_table];

create table claim_table
(
	claimID int IDENTITY(1,1) PRIMARY KEY,
	claimant varchar(50),
	claimantSSN numeric(9),

	spouse varchar(50),
	spouseSSN numeric(9),

	currentAPN int,
	dateAcquired date,
	dateOccupied date,
	currentStName varchar(50),
	currentApt varchar(50),
	currentCity varchar(50),
	currentState varchar(50),
	currentZip int,

	mailingStName varchar(50),
	mailingApt varchar(50),
	mailingCity varchar(50),
	mailingState varchar(50),
	mailingZip int,

	priorAPN int,
	dateMovedOut date,
	priorStName varchar(50),
	priorApt varchar(50),
	priorCity varchar(50),
	priorState varchar(50),
	priorZip int,

	rollTaxYear int,
	exemptRE int,
	suppTaxYear int,
	exemptRE2 int,

	claimAction varchar(50),
	findingReason varchar(50),

	claimReceived date,
	supervisorWorkload date,
	staffReview date,
	staffReviewDate date,
	supervisorReview date,
	caseClosed date
);

select * from [claim_table];



insert into [dbo].[claim_table] values ('he, molly', 123456789, null, null, 1234567890, '2015-12-12',' 2015-12-13', '123 any street', null, 'los angeles', 'ca', 90012, '123 any street', null, 'los angeles', 'ca', 90012, 1234567890, '2015-01-01', '123 any street', null, 'los angeles', 'ca', 90012, 218000, 7000, 218000, 7000, 'Met', 'Other', '2018-01-01', '2018-01-02', '2018-01-03', '2018-01-04', '2018-01-05', '2018-01-06');
