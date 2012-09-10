SET foreign_key_checks = 0;

DROP TABLE IF EXISTS donor;
CREATE TABLE donor (
    id			CHAR(7) NOT NULL,
    password		CHAR(128) NOT NULL,
    name	        VARCHAR(50) NOT NULL,
    surname         VARCHAR(50) NOT NULL,
    postal_code     INT(5) UNSIGNED,
    city            VARCHAR(100),
    street          VARCHAR(100),
    phone           CHAR(13),
    email           VARCHAR(50),
    blood_type      CHAR(3),
    national_id     DECIMAL(10) UNSIGNED NOT NULL UNIQUE,
    active          TINYINT NOT NULL,
    pref_station    INT(5) UNSIGNED NOT NULL,
    note           VARCHAR(150),
    PRIMARY KEY (id),
    CONSTRAINT fk_donor_pref_station FOREIGN KEY (pref_station) REFERENCES station (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS drawn;
CREATE TABLE drawn (
    id		        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    date            DATETIME NOT NULL,
    donor           CHAR(7) NOT NULL, 
    blood_type      CHAR(3), 
    nurse           CHAR(7) NOT NULL,
    store           INT(3) UNSIGNED NOT NULL,
    reservation     INT(10) UNSIGNED, 
    quality         TINYINT,
    PRIMARY KEY (id),
    CONSTRAINT fk_drawn_donor FOREIGN KEY (donor) REFERENCES donor (id),
    CONSTRAINT fk_drawn_nurse FOREIGN KEY (nurse) REFERENCES nurse (id),
    CONSTRAINT fk_drawn_store FOREIGN KEY (store) REFERENCES station (id),
    CONSTRAINT fk_odber_reservation FOREIGN KEY (reservation) REFERENCES reservation (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS invitation;
CREATE TABLE invitation (
    id			    INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    donor           CHAR(7) NOT NULL, 
    date            DATETIME,
    station         INT(3) UNSIGNED NOT NULL,
    type            CHAR(6),
    state           TINYINT,
    PRIMARY KEY (id),
    CONSTRAINT fk_invitation_donor FOREIGN KEY (donor) REFERENCES donor (id),
    CONSTRAINT fk_invitation_station FOREIGN KEY (station) REFERENCES station (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS station;
CREATE TABLE station (
    id 			    INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    name            VARCHAR(100) NOT NULL,
    postal_code     INT(5) UNSIGNED,
    city            VARCHAR(100),
    street          VARCHAR(100),
    PRIMARY KEY (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS nurse;
CREATE TABLE nurse (
    id			CHAR(7) NOT NULL,
    password		CHAR(128) NOT NULL,
    name            VARCHAR(50) NOT NULL,
    surname         VARCHAR(50) NOT NULL,
    station		    INT(3) UNSIGNED,
    postal_code     INT(5) NOT NULL,
    city            VARCHAR(100) NOT NULL,
    street          VARCHAR(100) NOT NULL,
    national_id     DECIMAL(10) NOT NULL UNIQUE,
    phone           CHAR(13),
    PRIMARY KEY (id),
    CONSTRAINT fk_nurse_station FOREIGN KEY (station) REFERENCES station (id)
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS reservation;
CREATE TABLE reservation (
    id    			INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    order_from      VARCHAR(200),
    blood_type      CHAR(3),
    quantity        INT(6) UNSIGNED,
    date            DATETIME,
    note            VARCHAR(200),
    state			VARCHAR(20),
    PRIMARY KEY (id)
)DEFAULT CHARSET=utf8;
