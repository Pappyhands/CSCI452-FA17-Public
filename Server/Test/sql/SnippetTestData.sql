USE SnippetGoodTestDatabase;


INSERT INTO User_Data(Username, Password, SecurityAnswer1, SecurityAnswer2) VALUES 
("Aaron Smith", "M4R10", "Smith", "Spot"),
("WizardProfessor", "SchoolRocks123", "Malkovich", "Barack Obama"),
("Richard Dude", "wassup", "YouAndWhatArmy", "IRequireAShrubbery");

INSERT INTO Language_Data(LanguageName) VALUES
('Java'),
('SQL'),
('HTML'),
('PHP'),
('Javascript'),
('CSS');


INSERT INTO Snippet_Data(CreatorID, LanguageID, Description, Code) VALUES 
(1, 1, 'Print out Hello World!', 'public class Hello {
    public static void main(String[] args) {
        System.out.println("Hello World");
    }
}'),
(3, 2,'Create Snippet_Data table', 'CREATE TABLE Snippet_Data(
SnippetID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
CreatorID BIGINT NOT NULL,
LanguageID BIGINT NOT NULL,
Description VARCHAR(MAX),
Code VARCHAR(MAX) NOT NULL,
FOREIGN KEY (LanguageID) REFERENCES Language_Data(LanguageID),
FOREIGN KEY (CreatorID) REFERENCES User_Data(UserID)
);'),
(1, 3, 'Custom Div', '<div id="custom">My Content</div>'),
(2, 4, 'Database Connection', '<?php
    $db_hostname = getenv("IP");
    $db_username = getenv("C9_USER");
    $db_password = "";
    $db_database = "SnippetGoodDatabase";
    $db_port = 3306;

    // Create connection
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
?>');