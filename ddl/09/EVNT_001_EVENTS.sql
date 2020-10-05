Use events;

START TRANSACTION;

DROP TABLE IF EXISTS tblPayment;
DROP TABLE IF EXISTS tblToken;

CREATE TABLE tblEvents
(
    intEventId INT(10) NOT NULL AUTO_INCREMENT UNIQUE,
    strName    VARCHAR(120) NOT NULL,
    strUuid VARCHAR(24) NOT NULL UNIQUE,
    strOrganisedUuid VARCHAR(40) NOT NULL,
    KEY K_strUuid (strUuid),
    KEY K_strOrganisedUuid (strOrganisedUuid),
    PRIMARY KEY PK_intEventId (intEventId)
);

COMMIT;
