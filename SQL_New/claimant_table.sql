USE [homeowner_test]
GO

/****** Object:  Table [dbo].[claimant_table]    Script Date: 11/27/2018 12:53:49 PM ******/
DROP TABLE [dbo].[claimant_table]
GO

/****** Object:  Table [dbo].[claimant_table]    Script Date: 11/27/2018 12:53:49 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[claimant_table](
	[claimant] [varchar](50) NULL,
	[claimantSSN] [numeric](9, 0) NOT NULL,
	[spouse] [varchar](50) NULL,
	[spouseSSN] [numeric](9, 0) NULL,
	[mailingStName] [varchar](50) NULL,
	[mailingApt] [varchar](50) NULL,
	[mailingCity] [varchar](50) NULL,
	[mailingState] [varchar](50) NULL,
	[mailingZip] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[claimantSSN] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

