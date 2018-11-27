USE [homeowner_test]
GO

/****** Object:  Table [dbo].[harvest_table]    Script Date: 11/27/2018 12:54:20 PM ******/
DROP TABLE [dbo].[harvest_table]
GO

/****** Object:  Table [dbo].[harvest_table]    Script Date: 11/27/2018 12:54:20 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[harvest_table](
	[claimID] [bigint] NOT NULL,
	[claimant] [varchar](50) NULL,
	[mailingStName] [varchar](50) NULL,
	[mailingApt] [varchar](50) NULL,
	[mailingCity] [varchar](50) NULL,
	[mailingState] [varchar](50) NULL,
	[mailingZip] [int] NULL,
	[claimAction] [varchar](50) NULL,
	[findingReason] [varchar](50) NULL,
	[rollTaxYear] [int] NULL,
	[exemptRE] [int] NULL,
	[suppTaxYear] [int] NULL,
	[exemptRE2] [int] NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

