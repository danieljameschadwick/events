USE Payments;

CREATE TABLE tblPayment
(
    intPaymentId        int(10)     NOT NULL AUTO_INCREMENT,
    strReference        varchar(35) DEFAULT NULL,
    strDescription      varchar(30) DEFAULT NULL,
    strEmail            varchar(40) NOT NULL,
    strClientId         varchar(40) NOT NULL,
    intCentesimalAmount int(11)     NOT NULL,
    strCurrencyCode     varchar(7)  NOT NULL,
    PRIMARY KEY (intPaymentId)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE tblToken
(
    intTokenId     int(10)      NOT NULL AUTO_INCREMENT,
    strGatewayName varchar(30)  NOT NULL,
    strAfterUrl    varchar(500) DEFAULT NULL,
    strTargetUrl   varchar(500) DEFAULT NULL,
    strHash        varchar(150) NOT NULL,
    PRIMARY KEY (intTokenId),
    KEY K_intTokenId (intTokenId)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;