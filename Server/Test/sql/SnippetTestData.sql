USE SnippetGoodTestDatabase;

INSERT INTO User_Data(Username, Passwrd)VALUES ("WizardProfessor", "SchoolRocks123");
INSERT INTO User_Data(Username, Passwrd)VALUES ("Aaron Smith","M4R10");
INSERT INTO User_Data(Username, Passwrd)VALUES ("Richard Dude","wassup");

INSERT INTO Snippet_Data(CreatorID, Language, Description) VALUES (1, 'Java', 'Print out Hello World!');
INSERT INTO Snippet_Data(CreatorID, Language, Description) VALUES (3, 'SQL','Create Snippet_Data table');
INSERT INTO Snippet_Data(CreatorID, Language, Description) VALUES (1, 'HTML','Custom Div');
INSERT INTO Snippet_Data(CreatorID, Language, Description) VALUES (2, 'PHP','Database Connection');