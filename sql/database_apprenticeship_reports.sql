-- Berichtsheftverwaltung

CREATE DATABASE apprenticeship_reports;

-- Tabelle t_apprentices

CREATE TABLE t_apprentices(
	id SERIAL,
	email VARCHAR(255) NOT NULL,
	firstname VARCHAR(255) NOT NULL,
	lastname VARCHAR(255) NOT NULL,
	occupation VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY(id)
);

-- Daten für t_apprentices

INSERT INTO t_apprentices (id, email, firstname, lastname, occupation, password) VALUES
(1, 'hans@peter.de', 'Hans', 'Peter', 'Fachinformatiker Anwendungsentwicklung', '1234'),
(2, 'Heinz@dieter.de', 'Heinz', 'Dieter', 'Fachinformatiker Systemintegration', '5678');

-- -------------------------------------------------------------------------------------------------------

-- Tabelle t_categories

CREATE TABLE t_categories(
	id SERIAL,
	description VARCHAR(255) NOT NULL,
	PRIMARY KEY(id)
);

-- Daten für t_categories

INSERT INTO t_categories (id, description) VALUES
(1, 'Besprechung'),
(2, 'Projekt'),
(3, 'Berufsschule');

-- -------------------------------------------------------------------------------------------------------

-- Tabelle t_booklets

CREATE TABLE t_booklets(
	id SERIAL,
	creationdate DATE NOT NULL,
	subject VARCHAR(255) NOT NULL,
	id_creator BIGINT UNSIGNED NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(id_creator) REFERENCES t_apprentices(id)
);

INSERT INTO t_booklets (id, creationdate, subject, id_creator) VALUES
(1, '2021-08-01', 'SuperInnovativeDEVS', 1),
(2, '2021-08-01', 'TheBestITSupportGuys', 2),
(3, '2021-08-05', 'Zusammenarbeit IT & DEV', 1);

-- -------------------------------------------------------------------------------------------------------

-- Tabelle t_reports

CREATE TABLE t_reports(
	id SERIAL,
	reportdate DATE NOT NULL,
	creationdate DATE NOT NULL,
	id_author BIGINT UNSIGNED,
	id_booklet BIGINT UNSIGNED,
	id_category BIGINT UNSIGNED,
	description LONGTEXT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(id_author) REFERENCES t_apprentices(id),
	FOREIGN KEY(id_booklet) REFERENCES t_booklets(id),
	FOREIGN KEY(id_category) REFERENCES t_categories(id)
);

-- Daten für t_reports

INSERT INTO t_reports (id, reportdate, creationdate, id_author, id_booklet, id_category, description) VALUES
(1, '2021-08-01', '2021-08-01', 1, 1, 1, 'Liebes Berichtsheft, heute war mein erster Tag bei SuperInnovativeDEVS. In diesem Meeting wurden mir alle vorgestellt und alle hatten sich ganz doll lieb.' ),
(2, '2021-08-02', '2021-08-03', 1, 1, 2, 'Liebes Berichtsheft, Es tut mir leid, dass ich gestern vergessen hab in dich reinzuschreiben. Deshalb hole ich das heute nach. Heute hab ich "Hallo Welt" in Assemblersprache programmiert. Das war komisch.');

-- -------------------------------------------------------------------------------------------------------

-- Tabelle t_memberof

CREATE TABLE t_memberof(
	id_booklet BIGINT UNSIGNED NOT NULL,
	id_apprentice BIGINT UNSIGNED NOT NULL,
	FOREIGN KEY(id_booklet) REFERENCES t_booklets(id),
	FOREIGN KEY(id_apprentice) REFERENCES t_apprentices(id)
);

INSERT INTO t_memberof (id_booklet, id_apprentice) VALUES
(3, 2);

-- -------------------------------------------------------------------------------------------------------

