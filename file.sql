CREATE TABLE Users(
    userID int NOT NULL AUTO_INCREMENT,
    firstname varchar(50) NOT NULL,
    lastname varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    phone_no varchar(11) NOT NULL,
    password varchar(255) NOT NULL,
    profile_pic varchar(255) NOT NULL,
    role varchar(50) NOT NULL,
    dateRegistered TIMESTAMP,
    UNIQUE KEY(username, email, phone_no),
    PRIMARY KEY(userID)
);

CREATE TABLE Roles(
    roleID int NOT NULL AUTO_INCREMENT,
    role varchar(50) NOT NULL,
    description varchar(50) NOT NULL,
    UNIQUE KEY(role),
    PRIMARY KEY(roleID)
);

INSERT INTO Roles(role, description)
VALUES           ('Admin', 'Administrator'),
                 ('Student', 'Student');
              
                 
CREATE TABLE role_perm(
    userID int NOT NULL,
    roleID int NOT NULL,
    FOREIGN KEY(userID) REFERENCES Users(userID),
    FOREIGN KEY(roleID) REFERENCES Roles(roleID)
);

CREATE TABLE loginAchievement(
    loginAchID int NOT NULL AUTO_INCREMENT,
    userID int NOT NULL,
    PRIMARY KEY(loginAchID),
    FOREIGN KEY(userID) REFERENCES Users(userID)
);





