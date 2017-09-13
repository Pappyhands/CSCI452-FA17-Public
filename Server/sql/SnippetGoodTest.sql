DROP DATABASE IF EXISTS SnippetGoodTest;
CREATE DATABASE SnippetGoodTest;
USE SnippetGoodTest;

CREATE TABLE User_Data(
UserID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
Username VARCHAR(32) NOT NULL,
Passwrd VARCHAR(32) NOT NULL,
SecurityQuestion1 TEXT NOT NULL,
SecurityQuestion2 TEXT NOT NULL,
SecurityQuestion3 TEXT NOT NULL
);

CREATE TABLE Snippet_Data(
Lanugage VARCHAR(32),
Description TEXT NOT NULL,
SnippetCode TEXT NOT NULL);

INSERT INTO User_Data(Username, Passwrd, SecurityQuestion1, SecurityQuestion2, SecurityQuestion3)
VALUES ("WizardProfessor", "SchoolRocks123", "What color are the best apples?", "Do pigs fly?", "What's one plus two?");

INSERT INTO SnippetData(Language, Description, SnippetCode)
VALUES ("Java", "Print out Hello World!", "System.out.println(\\"Hello World!\\")";

SELECT * FROM User_Data;
SELECT * FROM Snippet_Data;