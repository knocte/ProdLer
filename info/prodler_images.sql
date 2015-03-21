-- Tables creation script

CREATE TABLE Images_info(
	cod			INT NOT NULL,
	filename		CHAR(30) NOT NULL,
        type                    CHAR(30) NOT NULL,
        size			DOUBLE,
	description		CHAR(50),
        referenced		INT NOT NULL,
        date_created		DATETIME,
        date_modified		DATETIME,
	PRIMARY KEY(cod)
);

CREATE TABLE Images_data(
        cod			INT NOT NULL,
	filedata		LONGBLOB,
	PRIMARY KEY(cod),
        FOREIGN KEY(cod) REFERENCES Images_info(cod)
);