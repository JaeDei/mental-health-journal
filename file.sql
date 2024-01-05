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

CREATE TABLE mood(
    moodID int not null auto_increment,
    mood varchar(10) not null,
    description varchar(20) not null,
    PRIMARY KEY(moodID)
);

INSERT INTO mood(mood, description)
VALUES          ('&#128513;', 'Excited'),
                ('&#129402;', 'Sad'),
                ('&#128544;', 'Angry'),
                ('&#128567;', 'Sick'),
                ('&#128558;', 'Surprised'),
                ('&#128522;', 'Happy'),
                ('&#129393;', 'Bored');

create table journal(
    journal_id int auto_increment not null,
    userID int not null,
    title varchar(100),
    content varchar(355),
    moodID int not null,
    thought varchar(355),
    date date,
    status varchar(10),
    PRIMARY KEY (journal_id),
    FOREIGN KEY(userID) REFERENCES users(userID),
    FOREIGN KEY(moodID) REFERENCES mood(moodID)
);






