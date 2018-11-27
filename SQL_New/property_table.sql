USE [homeowner_test]
GO

/****** Object:  Table [dbo].[property_table]    Script Date: 11/27/2018 12:54:34 PM ******/
DROP TABLE [dbo].[property_table]
GO

/****** Object:  Table [dbo].[property_table]    Script Date: 11/27/2018 12:54:34 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[property_table](
	[ID] [bigint] IDENTITY(1,1) NOT NULL,
	[AIN] [bigint] NULL,
	[streetName] [varchar](50) NULL,
	[apt] [varchar](50) NULL,
	[city] [varchar](50) NULL,
	[state] [varchar](50) NULL,
	[zip] [int] NULL,
	[ownerName] [varchar](50) NULL,
	[ownerSSN] [numeric](9, 0) NULL,
	[dateAcquired] [date] NULL,
	[dateOccupied] [date] NULL,
	[dateMovedOut] [date] NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

