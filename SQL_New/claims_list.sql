USE [homeowner_test]
GO

/****** Object:  Table [dbo].[claims_list]    Script Date: 11/27/2018 12:54:02 PM ******/
DROP TABLE [dbo].[claims_list]
GO

/****** Object:  Table [dbo].[claims_list]    Script Date: 11/27/2018 12:54:02 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[claims_list](
	[claimID] [int] NOT NULL,
	[AIN] [int] NOT NULL,
	[claimantSSN] [numeric](9, 0) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[claimID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

