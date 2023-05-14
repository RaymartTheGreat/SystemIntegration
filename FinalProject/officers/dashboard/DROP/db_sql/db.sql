/*
-- Create table for member information
-- AWAN DETUY --
CREATE TABLE member (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    member_id VARCHAR(20) NOT NULL,
    year ENUM('1st', '2nd', '3rd', '4th') NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (email)
);

-- Create table for college shirt payment status
CREATE TABLE college_shirt_status (
    id INT(11) NOT NULL AUTO_INCREMENT,
    member_id INT(11) NOT NULL,
    status ENUM('paid', 'unpaid') NOT NULL,
    date_paid DATETIME DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (member_id) REFERENCES member(id)
);

--Insert a member--
INSERT INTO member (email, name, last_name, member_id, year) 
VALUES ('larz.jhin17@gmail.com', 'Larz', 'Jhin', '20-020123', '3rd');
*/

-- AGING GANA DTUY AWAN --

-- college_shirt_member SQL --

CREATE TABLE college_shirt_member (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    year_level INT NOT NULL,
    section ENUM('A', 'B') NOT NULL,
    status ENUM('Paid', 'Unpaid') NOT NULL
);


-- insert a member --

INSERT INTO college_shirt_member (member_id, email, first_name, last_name, year_level, section, status)
VALUES 
    ('20-020123', 'larz.jhin17@gmail.com', 'Larz', 'Jhin', 3, 'A', 'Unpaid'),
    ('20-020456', 'godseme90@gmail.com', 'Godz', 'Eme', 3, 'A', 'Paid');


-- unigames_fee_member SQL --

CREATE TABLE unigames_fee_member (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    year_level INT NOT NULL,
    section ENUM('A', 'B') NOT NULL,
    status ENUM('Paid', 'Unpaid') NOT NULL
);


-- insert a member --

INSERT INTO unigames_fee_member (member_id, email, first_name, last_name, year_level, section, status)
VALUES 
    ('20-020123', 'larz.jhin17@gmail.com', 'Larz', 'Jhin', 3, 'A', 'Unpaid'),
    ('20-020456', 'godseme90@gmail.com', 'Godz', 'Eme', 3, 'A', 'Paid');


-- update if want mo --
-- Paid or unpaid --

UPDATE member_account
SET status = 'Not yet paid'
WHERE id = 1;

ALTER TABLE member_account MODIFY COLUMN status ENUM('Payment Successful', 'Not yet paid') NOT NULL;


--updated--
INSERT INTO member_account (member_id, email, first_name, last_name, year_level, section, status)
VALUES 
    ('20-020321', 'testing@gmail.com', 'Marc', 'Malvar', 2, 'A', 'Unpaid'),
    ('20-020654', 'test@gmail.com', 'Rose Mer', 'Calantoc', 2, 'B', 'Unpaid');




UPDATE member_account
SET first_name = 'Arbhie',
SET last_name = 'Menor'
WHERE member_id = '20-020456';
