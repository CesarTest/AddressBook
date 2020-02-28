/*------------------------------------
 *  BRAIN IT - ADDRESS BOOK EXERCISE
 *     User/Database/Table Creation
 *------------------------------------
 *      Root Privileges Required
 *------------------------------------*/

/* 1.-  User / Database */
CREATE USER 'addressbook'@'localhost' IDENTIFIED BY 'password';
CREATE database 'exercise';
GRANT ALL ON exercise.* TO 'addressbook'@'localhost' IDENTIFIED BY 'brainit';
FLUSH PRIVILEGES;

/* 2.-  Create Table (might work as "addressbook" user) */
USE database "exercise";
CREATE TABLE contact(
  contact_id INT NOT NULL AUTO_INCREMENT,
  lastname VARCHAR(50) NOT NULL,
  firstname VARCHAR(50) NOT NULL,
  email VARCHAR(150) NOT NULL,
  address VARCHAR(255),
  phone VARCHAR(20),
  PRIMARY KEY(contact_id)
);
/*------------------------------------
 *            END SCRIPT
 *------------------------------------*/
