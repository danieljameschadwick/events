CREATE TABLE tblUser
(
    strUuid       char(36)     not null comment '(DC2Type:guid)' primary key,
    strUsername   varchar(40)  not null,
    strEmail      varchar(80)  not null,
    strPassword   varchar(120) not null,
    intUserTeamId int          null,
    constraint UNIQ_9050B9301259FE56 unique (intUserTeamId),
    constraint UNIQ_9050B93049BAF0E7 unique (strUsername),
    constraint UNIQ_9050B930F941B585 unique (strEmail)
);

CREATE TABLE ublRole
(
    intRoleId int auto_increment primary key,
    strHandle varchar(255) not null, constraint UNIQ_ECDDEEA75B24319A unique (strHandle)
);
