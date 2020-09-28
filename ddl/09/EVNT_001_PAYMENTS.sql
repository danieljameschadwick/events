Use events;

START TRANSACTION;

DROP TABLE IF EXISTS tblPayment;

CREATE TABLE tblPayment
(
    intPaymentId int(10) not null primary key auto_increment
);

COMMIT;
