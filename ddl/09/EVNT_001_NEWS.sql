START TRANSACTION;

CREATE TABLE tblArticle
(
    intArticleId   int(10)      not null primary key auto_increment,
    strTitle       varchar(60)  not null,
    strText        TEXT         not null,
    strAuthorUuid  varchar(40)  not null,
    strImagePath   varchar(240) null,
    strStrapLine   varchar(240) null,
    dtmPublishDate DATETIME     null,
    FOREIGN KEY tblArticle_strAuthorUuid (strAuthorUuid) REFERENCES tblUser (strUuid)
);

DROP TABLE IF EXISTS tblArticle;

INSERT INTO tblFeature
    (strHandle, strDescription, bolActive, intDisplayOrder)
VALUES
    ('NEWS', 'Enable entire News component.', 1, 0)
;

COMMIT;
