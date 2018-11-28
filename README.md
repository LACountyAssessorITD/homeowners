# Homeowners Claim and Fraud Prevention 
## USC Team Members
  * Nick Roewe, roewe@usc.edu
  * Henry Keane, hkeane@usc.edu
  * Mingyuan (Molly) He, mingyuah@usc.edu
  * Aneesh Bhamidipati, abhamidi@usc.edu
  
## To Run this Website
1.	Download this project
2.	Place it in the inetpub/wwwroot/
3.	In constants make sure ON_AZURE is correctly set to true or false
4.	Make sure the necessary Databases homeowner_test and HOX_USC are in the MS SQL Database as well as the tables (if they aren’t execute the SQL scripts in the SQL_NEW folder)
5.	Make sure in temp_table you add all the users with their level of permissions
6.	Go to http://localhost/homeowners/index.php in your preferred browser and you are ready to start using the website

NOTES:
1.	Any value of 0 is assumed to be NULL by PHP
2.	When using advanced search there is a discrepancy with the state field (uses CA instead of California)
3.	Create_claim_page.php should only be used for inputting data ONCE, after that you should update the claim through claim_page.php
4.	
## Overview:

## 1 Main Pages:
1.	index.php
a.	Login Page that handles single sign on (routes to LDAP login)  
2.	home_page.php
a.	Checks whether the user is actually in the database once LDAP has authenticated them, then routes to productivity_report_page.php
3.	productivity_report_page.php
a.	Has both the Claims by Type table and Claims by Staff table
4.	scan_claims_page.php
a.	Has the ability to scan claims, add more inputs for more claims, assign them to staff, and change the status of a claim  
b.	This is the only page where a claim can be closed  
5.	create_claim_page.php
a.	This page is intended to create new claims (or update claims that have only be scanned in), it also handles duplicate SSN 
6.	advanced_search_page.php
a.	This page allows advanced search functionality by fields other than claimID 
7.	claim_page.php
a.	This page surfaces claims and allows them to be updated as well  

## 2 PHP Function Files:
1.	ainlookup.php
a.	searches HOX_USC and looks for matches
2.	check_dups.php
a.	checks whether there are duplicate SSN in any of the claims
3.	claimID_response.php
a.	given a claimID responds with that specific claim
4.	search.php
a.	returns all claims with matching parameters
5.	update_claim.php
a.	updates a claim
6.	write_claim.php
a.	creates a new claim


## 3 Single Sign In + Constant:
1.  Everything in LDAP file deals Single Sign On
2. Constant.php in LDAP


## 4 MS-SQL Database:
1. homeowner_test
2. HOX_USC

## 5 Tables in homeowner_test (to create tables look in the SQL folder and execute scripts):
1.	claim_table
a.	 Holds all claims
2.	harvest_table
a.	Holds all closed claims (until they are harvested)
3.	temp_table
a.	Holds all users (the password field doesn't need to be filled since we are using Single Sign On)
b.	Permission of 1 is regular Staff Member
c.	Permission of 2 is a supervisor 
d.	Name should be Lastname, Firstname (format)

