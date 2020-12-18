USE Users;

CREATE TABLE tblNewsletter
(
    intNewsletterId integer(10)                  not null primary key,
    strEmail        varchar(80)                  not null,
    bolSubscribed   boolean                      not null,
    strUserUuid     char(36)                     null,
    CONSTRAINT UK_strEmail UNIQUE (strEmail),
    FOREIGN KEY FK_tblNewsletter_strUserUuid (strUserUuid) REFERENCES tblUser (strUuid)
);
