START TRANSACTION;

DROP TABLE IF EXISTS tblFeature;

CREATE TABLE tblFeature
(
    intFeatureId    int(10)      not null primary key auto_increment,
    strHandle       varchar(60)  not null,
    strDescription  varchar(240) not null,
    bolActive       bool         not null default 0,
    intDisplayOrder int(4)       not null default 0,
    constraint UK_strHandle UNIQUE (strHandle)
);

COMMIT;
