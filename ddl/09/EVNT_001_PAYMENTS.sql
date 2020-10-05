Use events;

START TRANSACTION;

DROP TABLE IF EXISTS tblPayment;
DROP TABLE IF EXISTS tblToken;

CREATE TABLE tblPayment
(
    intPaymentId        INT(10)     NOT NULL AUTO_INCREMENT UNIQUE,
    strReference        VARCHAR(35) NULL,
    strDescription      VARCHAR(30) NULL,
    strEmail            VARCHAR(40) NOT NULL,
    strClientId         VARCHAR(40) NOT NULL,
    intCentesimalAmount INT         NOT NULL,
    strCurrencyCode     VARCHAR(7)  NOT NULL,
    PRIMARY KEY PK_intPaymentId (intPaymentId)
);

CREATE TABLE tblToken
(
    intTokenId     INT(10)      NOT NULL AUTO_INCREMENT UNIQUE,
    strGatewayName VARCHAR(30)  NOT NULL,
    strAfterUrl    VARCHAR(500) NULL,
    strTargetUrl   VARCHAR(500) NULL,
    strHash        VARCHAR(150) NOT NULL,
    PRIMARY KEY PK_intTokenId (intTokenId)
);



COMMIT;
