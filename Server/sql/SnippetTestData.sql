USE SnippetGoodDatabase;

INSERT INTO User_Data(Username, Passwrd)VALUES 
("Aaron Smith","M4R10"),
("WizardProfessor", "SchoolRocks123"),
("Richard Dude","wassup");

INSERT INTO Language_Data(LanguageName)VALUES
('Java'),
('SQL'),
('PHP'),
('HTML'),
('Javascript');

INSERT INTO Snippet_Data(CreatorID, LanguageID, Description, Snippet) VALUES 
(1, 1, 'Print out Hello World!', 'public class HelloWorld {

    public static void main(String[] args) {
        // Prints "Hello, World" to the terminal window.
        System.out.println("Hello, World");

    }
    
    
}'),
(3, 2,'Create Snippet_Data table','CREATE TABLE Snippet_Data(
SnippetID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
CreatorID BIGINT,
LanguageID BIGINT,
Description TEXT NOT NULL,
Snippet TEXT NOT NULL,
FOREIGN KEY (LanguageID) REFERENCES Language_Data(LanguageID),
FOREIGN KEY (CreatorID) REFERENCES User_Data(UserID)
);'),
(1, 4,'Custom Div', '<div>

</div>'),
(2, 3,'Database Connection','<?php
$db_hostname = getenv(''IP'');
$db_username = getenv(''C9_USER'');
$db_password = '''';
$db_database = ''SnippetGoodDatabase'';
$db_port = 3306;
// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} 
?>');