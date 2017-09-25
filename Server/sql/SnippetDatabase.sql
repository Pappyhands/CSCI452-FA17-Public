DROP DATABASE IF EXISTS SnippetGoodDatabase;
CREATE DATABASE SnippetGoodDatabase;
USE SnippetGoodDatabase;

CREATE TABLE User_Data(
UserID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
Username VARCHAR(32) NOT NULL,
Passwrd VARCHAR(32) NOT NULL
);

CREATE TABLE Language_Data(
LanguageID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
LanguageName VARCHAR(32)
);

CREATE TABLE Snippet_Data(
SnippetID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
CreatorID BIGINT NOT NULL,
LanguageID BIGINT NOT NULL,
Description TEXT,
Code TEXT NOT NULL,
FOREIGN KEY (LanguageID) REFERENCES Language_Data(LanguageID),
FOREIGN KEY (CreatorID) REFERENCES User_Data(UserID)
);

