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

START TRANSACTION;

INSERT INTO tblFeature
    (strHandle, strDescription, bolActive, intDisplayOrder)
VALUES
    ('WEB_APPLICATION', 'Enable the Web Application. Used prior to release or disable all web features and go back to pre-release.', 1, 0)
;


COMMIT;
