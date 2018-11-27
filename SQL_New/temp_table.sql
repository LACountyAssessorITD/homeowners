USE [homeowner_test]
GO

/****** Object:  Table [dbo].[temp_table]    Script Date: 11/27/2018 12:54:46 PM ******/
DROP TABLE [dbo].[temp_table]
GO

/****** Object:  Table [dbo].[temp_table]    Script Date: 11/27/2018 12:54:46 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[temp_table](
	[id] [int] NULL,
	[username] [varchar](50) NULL,
	[name] [varchar](50) NULL,
	[password] [varchar](50) NULL,
	[permissions] [int] NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

