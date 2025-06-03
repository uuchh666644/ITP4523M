-- Set the default engine 
SET storage_engine = InnoDB;

-- Create and use database testdb
drop database IF EXISTS lab04;
create database lab04 character set utf8;
use lab04;

-- Create table Customers
CREATE TABLE Customers(
  custID Varchar(4) NOT NULL,
  custName Varchar(30) NOT NULL,
  custPswd Varchar(6) NOT NULL,
  custGender Varchar(1) NOT NULL,
 PRIMARY KEY (custID)
 ) ENGINE = InnoDB;

-- Create testing data for table User
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1001', 'Stanley', 'pass01', 'M');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1002', 'Jennifer', 'pass02', 'F');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1003', 'Kevin', 'pass03', 'M');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1004', 'Fiona', 'pass04', 'F');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1005', 'Jason', 'pass05', 'M');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1006', 'Whitney', 'pass06', 'F');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1007', 'William', 'pass07', 'M');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1008', 'Suki', 'pass08', 'F');
INSERT INTO Customers (custID, custName, custPswd, custGender) VALUES ('1009', 'Alan', 'pass09', 'M');