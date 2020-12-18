USE Users;

CREATE TABLE tblUser
(
	strUuid      char(36)                     not null comment '(DC2Type:guid)' primary key,
	strUsername  varchar(40)                  not null,
	strFirstName varchar(80)                  null,
	strLastName  varchar(120)                 null,
	strPassword  varchar(120)                 not null,
	strEmail     varchar(80)                  not null,
	jsnRoles     longtext collate utf8mb4_bin null,
	CONSTRAINT UK_strUsername UNIQUE (strUsername),
	CONSTRAINT UK_strEmail UNIQUE (strEmail),
	CONSTRAINT jsnRoles CHECK (json_valid(`jsnRoles`))
);

CREATE TABLE tblUserPreferences
(
    intUserPreferencesId INT AUTO_INCREMENT PRIMARY KEY,
    strUuid char(36) NOT NULL,
    bolDarkMode BOOLEAN NOT NULL DEFAULT FALSE,
    CONSTRAINT UK_strUuid UNIQUE (strUuid),
    CONSTRAINT FK_tblUserPreferences_strUuid FOREIGN KEY (strUuid) REFERENCES tblUser (strUuid)
);

CREATE TABLE ublRole
(
	intRoleId int auto_increment primary key,
	strHandle varchar(255) not null,
	strName   varchar(255) null,
	CONSTRAINT UK_strHandle unique (strHandle)
);

CREATE TABLE tblGroup
(
	intGroupId INT AUTO_INCREMENT PRIMARY KEY,
	strName   VARCHAR(255) NULL,
	strOwnerUuid VARCHAR(40)  NOT NULL,
	CONSTRAINT UK_strName UNIQUE (strName),
	CONSTRAINT tblGroup_strOwnerUuid FOREIGN KEY (strOwnerUuid) REFERENCES tblUser (strUuid)
);

CREATE TABLE tblUserGroup
(
	intUserGroupId INT AUTO_INCREMENT PRIMARY KEY,
	strUuid CHAR(36) NOT NULL,
	intGroupId INT NOT NULL,
	CONSTRAINT tblUserGroup_strUuid FOREIGN KEY (strUuid) REFERENCES tblUser (strUuid),
	CONSTRAINT tblUserGroup_intGroupId FOREIGN KEY (intGroupId) REFERENCES tblGroup (intGroupId)
);

START TRANSACTION;

INSERT INTO tblUser (strUuid, strUsername, strFirstName, strLastName, strPassword, strEmail, jsnRoles) VALUES ('690ecd86-fc46-11ea-ae6d-acde48001122', 'Dan', 'Daniel', 'Chadwick', '$argon2id$v=19$m=65536,t=4,p=1$t9v2+RT1NSjDRd96IIa9+Q$9chA9Jau0/vrLP5P+kWBfa/BGt9Y4hNUyq85JAq6MMY', 'daniel@chadwk.com', '[]');

INSERT INTO ublRole (strHandle, strName) VALUES ('ROLE_USER', 'User');
INSERT INTO ublRole (strHandle, strName) VALUES ('ROLE_ADMIN', 'Admin');

COMMIT;