USE [homeowner_test]
GO

/****** Object:  Table [dbo].[claim_table]    Script Date: 11/27/2018 12:53:34 PM ******/
DROP TABLE [dbo].[claim_table]
GO

/****** Object:  Table [dbo].[claim_table]    Script Date: 11/27/2018 12:53:34 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[claim_table](
	[claimID] [bigint] NOT NULL,
	[claimant] [varchar](50) NULL,
	[claimantSSN] [varchar](50) NULL,
	[spouse] [varchar](50) NULL,
	[spouseSSN] [varchar](50) NULL,
	[currentAPN] [bigint] NULL,
	[dateAcquired] [date] NULL,
	[dateOccupied] [date] NULL,
	[currentStName] [varchar](50) NULL,
	[currentApt] [varchar](50) NULL,
	[currentCity] [varchar](50) NULL,
	[currentState] [varchar](50) NULL,
	[currentZip] [int] NULL,
	[mailingStName] [varchar](50) NULL,
	[mailingApt] [varchar](50) NULL,
	[mailingCity] [varchar](50) NULL,
	[mailingState] [varchar](50) NULL,
	[mailingZip] [int] NULL,
	[priorAPN] [bigint] NULL,
	[dateMovedOut] [date] NULL,
	[priorStName] [varchar](50) NULL,
	[priorApt] [varchar](50) NULL,
	[priorCity] [varchar](50) NULL,
	[priorState] [varchar](50) NULL,
	[priorZip] [int] NULL,
	[rollTaxYear] [int] NULL,
	[exemptRE] [int] NULL,
	[suppTaxYear] [int] NULL,
	[exemptRE2] [int] NULL,
	[claimAction] [varchar](50) NULL,
	[findingReason] [varchar](50) NULL,
	[claimReceived] [date] NULL,
	[claimReceivedAssignee] [varchar](50) NULL,
	[claimReceivedAssignor] [varchar](50) NULL,
	[supervisorWorkload] [date] NULL,
	[supervisorWorkloadAssignee] [varchar](50) NULL,
	[supervisorWorkloadAssignor] [varchar](50) NULL,
	[staffReview] [date] NULL,
	[staffReviewAssignee] [varchar](50) NULL,
	[staffReviewAssignor] [varchar](50) NULL,
	[staffReviewDate] [date] NULL,
	[staffReviewDateAssignee] [varchar](50) NULL,
	[staffReviewDateAssignor] [varchar](50) NULL,
	[supervisorReview] [date] NULL,
	[supervisorReviewAssignee] [varchar](50) NULL,
	[supervisorReviewAssignor] [varchar](50) NULL,
	[caseClosed] [date] NULL,
	[caseClosedAssignee] [varchar](50) NULL,
	[caseClosedAssignor] [varchar](50) NULL,
	[currStatus] [varchar](20) NULL,
	[preprintSent] [date] NULL,
	[preprintSentAssignee] [varchar](50) NULL,
	[preprintSentAssignor] [varchar](50) NULL,
	[hold] [date] NULL,
	[holdAssignee] [varchar](50) NULL,
	[holdAssignor] [varchar](50) NULL,
	[active] [varchar](50) NULL,
 CONSTRAINT [PK__claim_ta__01BDF9B33BDE967C] PRIMARY KEY CLUSTERED 
(
	[claimID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

