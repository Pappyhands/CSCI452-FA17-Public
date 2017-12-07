CREATE DATABASE SnippetGoodDatabase;
USE SnippetGoodDatabase;

CREATE TABLE User_Data(
UserID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
Email VARCHAR(32) UNIQUE NOT NULL,
Password VARCHAR(64) NOT NULL,
SecurityAnswer1 VARCHAR(64) NOT NULL,
SecurityAnswer2 VARCHAR(64) NOT NULL
);

CREATE TABLE Language_Data(
LanguageID BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
LanguageName VARCHAR(32),
Language_Code VARCHAR(32)
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

USE SnippetGoodDatabase;

INSERT INTO User_Data(Email, Password, SecurityAnswer1, SecurityAnswer2) VALUES
("Aaron Smith", "8e72c2d77c68b351be2e2ff480f0a552", "Smith", "Spot"),
("WizardProfessor", "4f6dab54642c49d343243be5cd0c885d", "Malkovich", "Barack Obama"),
("Richard Dude", "f2638dbff86c757afa70670c11254a67", "YouAndWhatArmy", "IRequireAShrubbery"),
("Pappyhands", "d0551d708abda9172053b57f53844ec3", "Sanchez", "A Guy"),
("Matt51096", "52773b1d44e87772d219a1b5ca31ff46", "Brutus", "Chase"),
("Berry_Chan", "619dd92c8adcd7593a4986561872db2d", "Magnus", "Merl"),
("MvI7R", "846c3fe39b4aa698a6d6c437a05feedd", "Marcus", "Reddit");


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
?>'),

(4,3,'Sweet HTML stuff', '<body>
    <p>Hi <span>Words</span></p>
    <div>Hi</div>
    <span style="font-size:40px; color:blue">BIG</span>
    <span>BIGGER</span>
    <p id="once">
        Some Words
        </p>
    <div class="many"> </div>
    <div class="lots"> </div>
    <div class="many lots"> </div>
</body>'),

(7,6,'Sweet CSS stuff', '#box{
        border: 1px #996B00;
        width: 600px;
        margin: 0 auto;
    }'),

(4,3,'Sweet HTML stuff', '<body>
    <p>Hi <span>Words</span></p>
    <div>Hi</div>
    <span style="font-size:40px; color:blue">BIG</span>
    <span>BIGGER</span>
    <p id="once">
        Some Words
        </p>
    <div class="many"> </div>
    <div class="lots"> </div>
    <div class="many lots"> </div>
</body>'),

(7,3,'Sweet HTML stuff', '<body>
    <p>Hi <span>Words</span></p>
    <div>Hi</div>
    <span style="font-size:40px; color:blue">BIG</span>
    <span>BIGGER</span>
    <p id="once">
        Some Words
        </p>
    <div class="many"> </div>
    <div class="lots"> </div>
    <div class="many lots"> </div>
</body>'),

(1,3,'Sweet HTML stuff', '<body>
    <p>Hi <span>Words</span></p>
    <div>Hi</div>
    <span style="font-size:40px; color:blue">BIG</span>
    <span>BIGGER</span>
    <p id="once">
        Some Words
        </p>
    <div class="many"> </div>
    <div class="lots"> </div>
    <div class="many lots"> </div>
</body>'),

(1, 1, 'Print out Hello World!', 'public class Hello {
    public static void main(String[] args) {
        System.out.println("Hello World");
    }
}'),

(5, 1, 'Print out Hello World!', 'public class Hello {
    public static void main(String[] args) {
        System.out.println("Hello World");
    }
}'),

(4, 1, 'Print out Hello World!', 'public class Hello {
    public static void main(String[] args) {
        System.out.println("Hello World");
    }
}')
;
