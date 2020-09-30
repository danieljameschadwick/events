Use events;

START TRANSACTION;

DROP TABLE IF EXISTS tblPayment;
DROP TABLE IF EXISTS tblToken;

CREATE TABLE tblPayment
(
    intPaymentId INT(10) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY PK_intPaymentId (intPaymentId)
);

CREATE TABLE tblToken
(
    intTokenId     INT(10)      NOT NULL AUTO_INCREMENT,
    strGatewayName VARCHAR(30)  NOT NULL,
    strAfterUrl    VARCHAR(500) NULL,
    strTargetUrl   VARCHAR(500) NULL,
    strHash        VARCHAR(150) NOT NULL,
    KEY K_intTokenId (intTokenId)
);

create unique index tblToken_intTokenId_uindex
    on tblToken (intTokenId);

alter table tblToken
    add constraint tblToken_pk
        primary key (intTokenId);



COMMIT;
