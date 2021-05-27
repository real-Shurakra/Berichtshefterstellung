-- Berichtsheftverwaltung

CREATE DATABASE apprenticeship_reports;

-- Tabelle t_apprenties

CREATE TABLE t_apprentices(
	id SERIAL NOT NULL,
	email VARCHAR(255) NOT NULL,
	firstname VARCHAR(255) NOT NULL,
	lastname VARCHAR(255) NOT NULL,
	occupation VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

-- Tabelle t_categories

CREATE TABLE t_categories(
	description VARCHAR(255) NOT NULL,
	PRIMARY KEY (description)
);

-- Tabelle t_reports

CREATE TABLE t_reports(
	reportdate DATE NOT NULL,
	creationdate DATE NOT NULL,
	id_author BIGINT UNSIGNED,
	category VARCHAR(255) NOT NULL,
	description LONGTEXT NOT NULL,
	FOREIGN KEY (id_author) REFERENCES t_apprentices (id),
	FOREIGN KEY (category) REFERENCES t_categories (description)
);

-- Tabelle t_booklets

CREATE TABLE t_booklets(
	id SERIAL NOT NULL,
	creationdate DATE NOT NULL,
	subject VARCHAR(255) NOT NULL,
	id_creator BIGINT UNSIGNED,
	PRIMARY KEY (id),
	FOREIGN KEY (id_creator) REFERENCES t_apprentices (id)
);

-- Tabelle t_memberof

CREATE TABLE t_memberof(
	id_booklet BIGINT UNSIGNED,
	id_apprentice BIGINT UNSIGNED,
	FOREIGN KEY (id_booklet) REFERENCES t_booklets (id),
	FOREIGN KEY (id_apprentice) REFERENCES t_apprentices (id)
);

