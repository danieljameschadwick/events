USE Locations;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS ublCountry;
DROP TABLE IF EXISTS ublRegion;
DROP TABLE IF EXISTS tblAddress;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE ublCountry
(
    intCountryId   INT(70)     NOT NULL AUTO_INCREMENT,
    strCountryName VARCHAR(70) NOT NULL,
    strCountryCode VARCHAR(4)  NOT NULL,
    PRIMARY KEY (intCountryId),
    UNIQUE KEY UK_intCountryId (intCountryId),
    KEY K_intCountryId (intCountryId)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


CREATE TABLE ublRegion
(
    intRegionId   INT(70)     NOT NULL AUTO_INCREMENT,
    intCountryId  INT(70)     NOT NULL,
    strRegionCode VARCHAR(8)  NOT NULL,
    strRegionName VARCHAR(80) NOT NULL,
    PRIMARY KEY (intRegionId),
    UNIQUE KEY UK_intRegionId (intRegionId),
    KEY K_intRegionId (intRegionId),
    CONSTRAINT FK_ublCountry_intCountryId FOREIGN KEY (intCountryId) REFERENCES ublCountry (intCountryId)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


CREATE TABLE tblAddress
(
    intAddressId    INT(10)       NOT NULL AUTO_INCREMENT,
    strUserUuid     VARCHAR(40)   NOT NULL,
    intRegionId     INT(70)       NOT NULL,
    intCountryId    INT(70)       NOT NULL,
    strAddressName  VARCHAR(70)   NULL,
    strAddressLine1 VARCHAR(70)   NOT NULL,
    strAddressLine2 VARCHAR(70)   NULL,
    strAddressLine3 VARCHAR(70)   NULL,
    strAddressLine4 VARCHAR(70)   NULL,
    strPostCode     VARCHAR(7)    NOT NULL,
    decLongtitude   DECIMAL(9, 6) NULL,
    decLatitude     DECIMAL(8, 6) NULL,
    PRIMARY KEY (intAddressId),
    UNIQUE KEY UK_intAddressId (intAddressId),
    KEY K_intRegionId (intRegionId),
    KEY K_intCountryId (intCountryId),
    CONSTRAINT FK_tblAddress_strUserUuid FOREIGN KEY (strUserUuid) REFERENCES Users (strUuid),
    CONSTRAINT FK_tblAddress_intRegionId FOREIGN KEY (intRegionId) REFERENCES ublRegion (intRegionId),
    CONSTRAINT FK_tblAddress_intCountryId FOREIGN KEY (intCountryId) REFERENCES ublCountry (intCountryId)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


START TRANSACTION;

USE Users;

SET @DAN = (SELECT strUuid FROM tblUser WHERE strUsername = 'dan');

USE Locations;

INSERT INTO ublCountry
    (strCountryName, strCountryCode)
VALUES
    ('United Kingdom', 'GBR');

SET @GBR = (SELECT intCountryId FROM ublCountry WHERE strCountryCode = 'GBR');

INSERT INTO ublRegion
    (intCountryId, strRegionCode, strRegionName)
VALUES
    (@GBR, 'LANCS', 'Lancashire');

SET @LANCS = (SELECT intRegionId FROM ublRegion WHERE strRegionCode = 'LANCS');

INSERT INTO tblAddress
    (strAddressName, strAddressLine1, strPostCode, intRegionId, intCountryId, strUserUuid)
VALUES
    ('Home', '9 Ennerdale Close', 'BB7 2PH', @LANCS, @GBR, @DAN)
;

COMMIT;
