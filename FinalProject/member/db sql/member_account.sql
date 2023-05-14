CREATE TABLE member_account (
  id INT NOT NULL AUTO_INCREMENT,
  member_id VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  year_level INT NOT NULL,
  section ENUM('A', 'B') NOT NULL,
  status ENUM('Payment Successful', 'Not yet paid') NOT NULL,
  payment_receipt BLOB
  PRIMARY KEY (id)
);

INSERT INTO member_account (member_id, email, password, first_name, last_name, year_level, section, status)
VALUES 
    ('20-020123', 'larz.jhin17@gmail.com', '123', 'Larz', 'Jhin', 3, 'A', 'Not yet paid'),
    ('20-020456', 'godseme90@gmail.com', '123', 'Godz', 'Eme', 3, 'A', 'Not yet paid');


ALTERING THE MEMBER

UPDATE member_account
SET status = 'Not yet paid'
WHERE member_id = '20-020456';

-- delete picture--
UPDATE member_account SET payment_receipt = NULL WHERE member_id = '20-020123';
