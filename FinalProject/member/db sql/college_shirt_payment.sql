CREATE TABLE college_shirt_payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    status ENUM('Payment Successful', 'Not yet paid') NOT NULL,
    payment_receipt BLOB,
    FOREIGN KEY (account_id) REFERENCES member_account(id)
);


-- to delete the picture --

UPDATE college_shirt_payment SET payment_receipt = NULL WHERE id = 1;

