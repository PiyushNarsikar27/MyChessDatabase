CREATE TABLE titles(
    titleId INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titleName VARCHAR(4) NOT NULL)
    ENGINE=InnoDB;
CREATE TABLE users(
    userId INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    elo INTEGER,
    titleId INTEGER NOT NULL,
    verified TINYINT(1) NOT NULL DEFAULT 0,
    vKey VARCHAR(45) NOT NULL,
    CONSTRAINT FOREIGN KEY (titleId)
    REFERENCES titles(titleId)
    ON DELETE CASCADE ON UPDATE CASCADE)
    ENGINE=InnoDB;
CREATE TABLE results(
    resultId INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    score VARCHAR(10) NOT NULL)
    ENGINE=InnoDB;
CREATE TABLE categories(
  categoryId INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  categoryName VARCHAR(255) NOT NULL)
  ENGINE=InnoDB;
CREATE TABLE games(
    gameId INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pgn VARCHAR(65535) NOT NULL,
    whiteName VARCHAR(255) NOT NULL,
    blackName VARCHAR(255) NOT NULL,
    eventName VARCHAR(255),
    dateOfGame DATE,
    timeControl VARCHAR(10),
    gameDescription VARCHAR(65535),
    resultId INTEGER NOT NULL,
    CONSTRAINT FOREIGN KEY (resultId)
    REFERENCES results(resultId)
    ON DELETE CASCADE ON UPDATE CASCADE,
    categoryId INTEGER NOT NULL,
    CONSTRAINT FOREIGN KEY (categoryId)
    REFERENCES categories(categoryId)
    ON DELETE CASCADE ON UPDATE CASCADE)
    ENGINE=InnoDB;