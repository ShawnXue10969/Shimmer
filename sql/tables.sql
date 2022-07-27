CREATE TABLE users (
    userId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userFullName varchar(128) NOT NULL,
    userEmail varchar(128) NOT NULL,
    userUid varchar(128) NOT NULL,
    userPwd varchar(128) NOT NULL
);

CREATE TABLE pwdReset (
    pwdResetId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    pwdResetEmail TEXT NOT NULL,
    pwdResetSelector TEXT NOT NULL,
    pwdResetToken LONGTEXT NOT NULL,
    pwdResetExpires TEXT NOT NULL
);

CREATE TABLE profiles (
    id int(11) not null PRIMARY KEY AUTO_INCREMENT,
    userId int(11) not null,
    type varchar(128) NOT NULL
);

CREATE TABLE comments (
    cid int(11) not null PRIMARY KEY AUTO_INCREMENT,
    nid int(11) not null,
    userId int(11) not null,
    date datetime not nULL,
    message TEXT not null
);

CREATE TABLE pins (
    pid int(11) not null PRIMARY KEY AUTO_INCREMENT,
    userId int(11) not null,
    nid int(11) not null
);