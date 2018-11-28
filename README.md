# Homeowners Claim and Fraud Prevention 
## USC Team Members
  * Nick Roewe, roewe@usc.edu
  * Henry Keane, hkeane@usc.edu
  * Mingyuan (Molly) He, mingyuah@usc.edu
  * Aneesh Bhamidipati, abhamidi@usc.edu
  
## Overview:

## 1 Main Pages:
* index.php
- Login Page that handles single sign on (routes to LDAP login)
* home_page.php
- Checks whether the user is actually in the database once LDAP has authenticated them, then routes to productivity_report_page.php
* productivity_report_page.php
- Has both the Claims by Type table and Claims by Staff table
* scan_claims_page.php
- Has the ability to scan claims, add more inputs for more claims, assign them to staff, and change the status of a claim
- This is the only page where a claim can be closed
* create_claim_page.php
- This page is intended to create new claims (or update claims that have only be scanned in), it also handles duplicate SSN
* advanced_search_page.php
- This page allows advanced search functionality by fields other than claimID
* claim_page.php
- This page surfaces claims and allows them to be updated as well

## 2 PHP Function Files:
* ainlookup.php
* check_dups.php
* claimID_response.php
* search.php
* update_claim.php
* write_claim.php

## 3 Single Sign In + Constant:
* Everything in LDAP file deals Single Sign On
* Constant.php in LDAP

## 4 MS-SQL Database:
* homeowner_test
* HOX_USC

## 5 Tables in homeowner_test:
* claim_table
- Holds all claims
* harvest_table
- Holds all closed claims (until they are harvested)
* temp_table
- Holds all users (the password field doesn't need to be filled since we are using Single Sign On)
- Permission of 1 is regular Staff Member
- Permission of 2 is a supervisor 
- Name should be Lastname, Firstname (format)





