
CREATE DATABASE `usersDB`;
USE `usersDB`;

DROP TABLE IF EXISTS `users`;

-- Table for usernames and passwords
CREATE TABLE `users`
    (
        `username` VARCHAR(25) NOT NULL PRIMARY KEY,
        `password` VARCHAR(100),
        `fname` VARCHAR(25),
        `lname` VARCHAR(25),
        `metric` BOOLEAN,
        `darkmode` BOOLEAN 
    );

-- Insert default user
INSERT INTO `users` VALUES ("test", sha1("pass"), "Test", "User", false, false);

CREATE user "ubuntu"@"localhost" identified by "ryan";
GRANT SELECT, INSERT, UPDATE, DELETE ON usersDB.* TO "ubuntu"@"localhost";