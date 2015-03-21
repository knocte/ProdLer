-- Tables creation script

CREATE TABLE Brands(
	cod			INT NOT NULL,
	name			CHAR(30) NOT NULL,
        url			CHAR(50),
        date_created		DATETIME,
        date_modified		DATETIME,
        img_cod                 INT,
        img_filename            CHAR(30),
	PRIMARY KEY(cod)
);

CREATE TABLE Categories(
	cod			INT NOT NULL,
	type			INT NOT NULL,
		-- accesory/generic
	name			CHAR(30) NOT NULL,
	parent			INT,
        date_created		DATETIME,
        date_modified		DATETIME,
        img_cod                 INT,
        img_filename            CHAR(30),
	PRIMARY KEY(cod)
);

CREATE TABLE Products(
	cod			INT NOT NULL,
	brand			INT NOT NULL,
	category		INT NOT NULL,
	model			CHAR(30) NOT NULL,
	description		CHAR(50),
        characts                BLOB,
	specs			BLOB,
	offer			INT NOT NULL,
		-- yes/no
	occasion		INT NOT NULL,
		-- yes/no
	accesory_category	INT,
        date_created		DATETIME,
        date_modified		DATETIME,
        img_cod                 INT,
        img_filename            CHAR(30),
	PRIMARY KEY(cod),
	FOREIGN KEY(category) REFERENCES Categories(cod),
	FOREIGN KEY(brand) REFERENCES Brands(cod)
);

CREATE TABLE Dealers(
        cod			INT NOT NULL,
	name			CHAR(50) NOT NULL,
        alias			CHAR(15) NOT NULL,
	id			CHAR(15),
        url			CHAR(50),
	address			CHAR(255),
	phone_1			CHAR(15),
	phone_2			CHAR(15),
	contact			CHAR(30),
	payment			INT,
        notes			CHAR(255),
        date_created		DATETIME,
        date_modified		DATETIME,
	PRIMARY KEY(cod)
);

CREATE TABLE Provisions(
	dealer			INT NOT NULL,
	product			INT NOT NULL,
	price			DOUBLE (11,2),
        date_created		DATETIME,
        date_modified		DATETIME,
	PRIMARY KEY(dealer,product),
	FOREIGN KEY(dealer) REFERENCES Dealers(cod),
	FOREIGN KEY(product) REFERENCES Products(cod)
);

CREATE TABLE Variables(
	name			CHAR(25) NOT NULL,
	char_value		CHAR(50),
	int_value		INT,
	PRIMARY KEY(name)
);
