USE Events;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS tblArticle;
DROP TABLE IF EXISTS tblEvent;
DROP TABLE IF EXISTS tblFeature;
DROP TABLE IF EXISTS tblPayment;
DROP TABLE IF EXISTS tblSignUp;
DROP TABLE IF EXISTS tblToken;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE tblArticle
(
	intArticleId   int(10)     NOT NULL AUTO_INCREMENT,
	strTitle       varchar(60) NOT NULL,
	strText        text        NOT NULL,
	strAuthorUuid  varchar(40) NOT NULL,
	strImagePath   varchar(240) DEFAULT NULL,
	strStrapLine   varchar(240) DEFAULT NULL,
	dtmPublishDate datetime     DEFAULT NULL,
	PRIMARY KEY (intArticleId),
	KEY tblArticle_strAuthorUuid (strAuthorUuid),
	CONSTRAINT tblArticle_strAuthorUuid FOREIGN KEY (strAuthorUuid) REFERENCES Users.tblUser (strUuid)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE tblEvent
(
	intEventId       int(10)      NOT NULL AUTO_INCREMENT,
	intAddressId     int(10)      NULL,
	strOrganisedUuid varchar(40)  NOT NULL,
	strName          varchar(120) NOT NULL,
	strDescription   text     DEFAULT NULL,
	dtmStartDateTime datetime     NOT NULL,
	dtmEndDateTime   datetime DEFAULT NULL,
	PRIMARY KEY (intEventId),
    UNIQUE KEY UK_intEventId (intEventId),
    UNIQUE KEY UK_intAddressId (intAddressId),
	KEY K_strOrganisedUuid (strOrganisedUuid),
    CONSTRAINT tblArticle_strOrganisedUuid FOREIGN KEY (strOrganisedUuid) REFERENCES Users.tblUser (strUuid),
    CONSTRAINT tblArticle_intAddressId FOREIGN KEY (intAddressId) REFERENCES Locations.tblAddress (intAddressId)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE tblFeature
(
	intFeatureId    int(10)      NOT NULL AUTO_INCREMENT,
	strHandle       varchar(60)  NOT NULL,
	strDescription  varchar(240) NOT NULL,
	bolActive       tinyint(1)   NOT NULL DEFAULT 0,
	intDisplayOrder int(4)       NOT NULL DEFAULT 0,
	PRIMARY KEY (intFeatureId),
	UNIQUE KEY UK_strHandle (strHandle)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE tblSignUp
(
	intSignUpId   INT(10)     NOT NULL AUTO_INCREMENT,
	strFirstName  varchar(70) NOT NULL,
	strLastName   varchar(70) NOT NULL,
	dtmSignUpDate datetime    DEFAULT NULL,
	intEventId    int(10)     NOT NULL,
	strUuid       varchar(40) DEFAULT NULL,
	PRIMARY KEY (intSignUpId),
	UNIQUE KEY UK_intSignUpId (intSignUpId),
	KEY K_intEventId (intEventId),
	KEY K_strUuid (strUuid),
	CONSTRAINT FK_tblEvent_intEventId FOREIGN KEY (intEventId) REFERENCES tblEvent (intEventId)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8mb4;

START TRANSACTION;

INSERT INTO tblEvent (strName, strDescription, strOrganisedUuid, dtmStartDateTime, dtmEndDateTime) VALUES ('Weekend Scrimmage', 'Test Scrimmage Description.', '690ecd86-fc46-11ea-ae6d-acde48001122', '2020-11-20 11:00:00', '2020-11-20 13:00:00');

SET @EVENT_ID = (SELECT intEventId FROM tblEvent WHERE strName = 'Weekend Scrimmage');

INSERT INTO tblSignUp (strFirstName, strLastName, dtmSignUpDate, intEventId, strUuid) VALUES ('Daniel', 'Chadwick', '2020-10-07 19:24:00', @EVENT_ID, '690ecd86-fc46-11ea-ae6d-acde48001122');

SET @SIGN_UP_ID = (SELECT intSignUpId FROM tblSignUp WHERE strUuid = '690ecd86-fc46-11ea-ae6d-acde48001122');

INSERT INTO tblArticle (strTitle, strText, strAuthorUuid, strImagePath, strStrapLine, dtmPublishDate) VALUES ('Welcome to events!', 'The only way to organise.', '690ecd86-fc46-11ea-ae6d-acde48001122', '/images/news/kobe.jpg', 'The only way to organise.', '2020-10-19 20:55:33');

INSERT INTO
	tblFeature (strHandle, strDescription, bolActive, intDisplayOrder)
VALUES
	('NEWS', 'Enable entire News component.', 1, 0),
	('WEB_APPLICATION', 'Enable the Web Application. Used prior to release or disable all web features and go back to pre-release.', 1, 0)
;

COMMIT;

