Use events;

START TRANSACTION;

DROP TABLE IF EXISTS tblEvent;
DROP TABLE IF EXISTS tblSignUp;

CREATE TABLE tblEvent
(
    intEventId       INT(10)      NOT NULL AUTO_INCREMENT UNIQUE,
    strName          VARCHAR(120) NOT NULL,
    strUuid          VARCHAR(24)  NOT NULL UNIQUE,
    strOrganisedUuid VARCHAR(40)  NOT NULL,
    dtmStartDateTime DATETIME     NULL,
    dtmEndDateTime   DATETIME     NULL,
    KEY K_strUuid (strUuid),
    KEY K_strOrganisedUuid (strOrganisedUuid),
    PRIMARY KEY PK_intEventId (intEventId)
);

CREATE TABLE tblSignUp
(
    intSignUpId   INT(10)     NOT NULL AUTO_INCREMENT UNIQUE,
    intEventId    INT(10)     NOT NULL,
    strFirstName  VARCHAR(70) NOT NULL,
    strLastName   VARCHAR(70) NOT NULL,
    dtmSignUpDate DATETIME    NOT NULL,
    strUuid       VARCHAR(40) DEFAULT NULL,
    PRIMARY KEY PK_intSignUpId (intSignUpId),
    KEY K_intEventId (intEventId),
    KEY K_strUuid (strUuid),
#     UNIQUE KEY K_intEventId_strUuid (intEventId, strUuid),
    CONSTRAINT FK_tblEvent_intEventId FOREIGN KEY (intEventId) REFERENCES tblEvent (intEventId),
    CONSTRAINT FK_tblUser_strUuid FOREIGN KEY (strUuid) REFERENCES tblUser (strUuid)
);


COMMIT;
