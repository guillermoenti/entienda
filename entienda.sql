DROP TABLE IF EXISTS users_products;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS developers_groups;
DROP TABLE IF EXISTS developers;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS groups;
DROP TABLE IF EXISTS engines_versions;
DROP TABLE IF EXISTS engines;

CREATE TABLE users (
	id_user INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user VARCHAR(16) NOT NULL,
	password CHAR(32) NOT NULL,
	email VARCHAR(32) NOT NULL,
	name VARCHAR(24) NOT NULL,
	surname VARCHAR(48) NOT NULL, 
	birthdate DATE NOT NULL,
	registered DATETIME NOT NULL default now(),
	admin BOOLEAN NOT NULL DEFAULT false 
);

INSERT INTO users (user, password, email, name, surname, birthdate, admin)
VALUES ('root', md5('enti'), 'root@root.com', 'Guille', 'Barrasa', '2001-10-02', true);


CREATE TABLE groups (
	id_group INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`group` VARCHAR(32) NOT NULL,
	course INT NOT NULL,
	jam_year YEAR NOT NULL,
	mark FLOAT NOT NULL
);

INSERT INTO groups (`group`, course, jam_year, mark)
VALUES ('Grupo 2', 1, 2021, 8.7),
('Grupo 4', 2, 2021, 10);


CREATE TABLE developers (
	id_developer INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(32) NOT NULL,
	surname VARCHAR(48) NOT NULL,
	email VARCHAR(32) NOT NULL,
	website VARCHAR(255) NOT NULL,
	birthdate DATE NOT NULL
);

INSERT INTO developers (name, surname, email, website, birthdate)
VALUES ('Guille', 'Barrasa', 'guillermo.barrasa@enti.cat', 'https://twitter.com/Sedy___', '2001-10-02'),
('Pedro', 'Fernández', 'pedro.fernandez@enti.cat', 'https://www.leagueoflegends.com/es-es/', '1221-02-10');


CREATE TABLE developers_groups (
	id_developer_group INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_developer INT UNSIGNED,
	FOREIGN KEY(id_developer) REFERENCES developers(id_developer),
	id_group INT UNSIGNED,
	FOREIGN KEY(id_group) REFERENCES groups(id_group)
);

INSERT INTO developers_groups (id_developer, id_group)
VALUES (1, 1),
(1, 2),
(2, 1),
(2, 2);


CREATE TABLE engines (
	id_engine INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	engine VARCHAR(32) NOT NULL
);

INSERT INTO engines (engine)
VALUES ('Unreal Engine'),
('Unity');


CREATE TABLE engines_versions (
	id_engine_version INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	version VARCHAR(24),
	id_engine INT UNSIGNED,
	FOREIGN KEY(id_engine) REFERENCES engines(id_engine)
);

INSERT INTO engines_versions (version, id_engine)
VALUES ('4', 1), ('2020.4.2', 2);


CREATE TABLE products (
	id_product INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	product VARCHAR(128),
	description TEXT,
	price DECIMAL(6,2),
	reference VARCHAR(8),
	discount INT,
	units_sold INT UNSIGNED,
	website VARCHAR(255),
	size INT,
	duration INT,
	release_date DATE,
	id_group INT UNSIGNED,
	FOREIGN KEY (id_group) REFERENCES groups(id_group),
	id_engine_version INT UNSIGNED,
	FOREIGN KEY (id_engine_version) REFERENCES engines_versions(id_engine_version)
);

INSERT INTO products (product, description, price, reference, discount, units_sold, website, size, duration, release_date, id_group, id_engine_version)
VALUES ('CocoRun', 'El mejor juego de la historia. Eres un mono y huyes de un coco gigante', 0, '1', 0, 0, 'Próximamente', 500, 0, '2021-04-02', 1, 2),
('Parade', 'Rescata a los intrumentos y disfruta', 0, '2', 0, 0, 'Próximamente', 500, 0, '2021-10-04', 2, 1);


CREATE TABLE users_products (
	id_user_product INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_user INT UNSIGNED NOT NULL,
	id_product INT UNSIGNED NOT NULL,
	FOREIGN KEY (id_user) REFERENCES users(id_user),
	FOREIGN KEY (id_product) REFERENCES products(id_product)
);


