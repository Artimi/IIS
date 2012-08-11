SET foreign_key_checks = 0;

DROP TABLE IF EXISTS darce;
CREATE TABLE darce (
    id        		INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    nick			VARCHAR(50) NOT NULL,
    password		CHAR(128) NOT NULL,
    jmeno           VARCHAR(50) NOT NULL,
    prijmeni        VARCHAR(50) NOT NULL,
    psc             INT(5) UNSIGNED,
    mesto           VARCHAR(100),
    ulice           VARCHAR(100),
    telefon         CHAR(13),
    email           VARCHAR(50),
    krevni_typ      CHAR(3),
    rodne_cislo     INT(10) UNSIGNED NOT NULL UNIQUE,
    aktivni         TINYINT NOT NULL,
    pref_pobocka    INT(5) UNSIGNED NOT NULL,
    poznamka        VARCHAR(150),
    PRIMARY KEY (id),
    CONSTRAINT fk_darce_pref_pobocka FOREIGN KEY (pref_pobocka) REFERENCES stanice (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS odber;
CREATE TABLE odber (
    id		        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    datum           DATETIME NOT NULL,
    darce           INT(7) UNSIGNED NOT NULL, 
    krevni_typ      CHAR(3), 
    odebiral        INT(5) UNSIGNED NOT NULL, 
    sklad           INT(3) UNSIGNED NOT NULL,
    rezervace       INT(10) UNSIGNED, 
    kvalita         TINYINT,
    PRIMARY KEY (id),
    CONSTRAINT fk_odber_darce FOREIGN KEY (darce) REFERENCES darce (id),
    CONSTRAINT fk_odber_odebiral FOREIGN KEY (odebiral) REFERENCES personal (id),
    CONSTRAINT fk_odber_sklad FOREIGN KEY (sklad) REFERENCES stanice (id),
    CONSTRAINT fk_odber_rezervace FOREIGN KEY (rezervace) REFERENCES rezervace (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS pozvanka;
CREATE TABLE pozvanka (
    id			    INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    darce           INT(7) UNSIGNED NOT NULL, 
    datum           DATETIME,
    stanice         INT(3) UNSIGNED NOT NULL,
    typ             CHAR(6),
    PRIMARY KEY (id),
    CONSTRAINT fk_pozvanka_darce FOREIGN KEY (darce) REFERENCES darce (id),
    CONSTRAINT fk_pozvanka_stanice FOREIGN KEY (stanice) REFERENCES stanice (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS stanice;
CREATE TABLE stanice (
    id 			    INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    nazev           VARCHAR(100) NOT NULL,
    psc             INT(5) UNSIGNED,
    mesto           VARCHAR(100),
    ulice           VARCHAR(100),
    PRIMARY KEY (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS personal;
CREATE TABLE personal (
    id			    INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    nick			VARCHAR(50) NOT NULL,
    password		CHAR(128) NOT NULL,
    jmeno           VARCHAR(50) NOT NULL,
    prijmeni        VARCHAR(50) NOT NULL,
    funkce          INT(3),
    pracoviste      INT(3) UNSIGNED,
    psc             INT(5) NOT NULL,
    mesto           VARCHAR(100) NOT NULL,
    ulice           VARCHAR(100) NOT NULL,
    rodne_cislo     INT(10) NOT NULL UNIQUE,
    telefon         CHAR(13),
    PRIMARY KEY (id),
    CONSTRAINT fk_persona_pracoviste FOREIGN KEY (pracoviste) REFERENCES stanice (id),
    CONSTRAINT un_personal_rodne_cislo UNIQUE (rodne_cislo)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS rezervace;
CREATE TABLE rezervace (
    id    			INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    komu            VARCHAR(200),
    krevni_typ      CHAR(3),
    mnozstvi         INT,
    datum           DATETIME,
    poznamka        VARCHAR(200),
    PRIMARY KEY (id)
)DEFAULT CHARSET=utf8;
