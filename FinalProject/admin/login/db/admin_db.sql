SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `adminlogin` (
  id int(11) NOT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (id);

ALTER TABLE `adminlogin`
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

INSERT INTO `adminlogin` (id, username, password) VALUES
(1, 'admin', '123');

