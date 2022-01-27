drop TABLE CASEINFO;
CREATE TABLE CASEINFO(
   case_id INT NOT NULL,
   province VARCHAR(50) DEFAULT NULL,
   city VARCHAR(50) DEFAULT NULL,
   infection_group TINYINT(1) DEFAULT NULL,
   infection_case VARCHAR(50)DEFAULT NULL,
   confirmed INT DEFAULT NULL ,
   latitude FLOAT DEFAULT NULL,
   longitude FLOAT DEFAULT NULL,
   PRIMARY KEY (case_id)
   );


drop TABLE REGION;
CREATE TABLE REGION(
    region_code INT NOT NULL,
    province VARCHAR(50)  DEFAULT NULL,
    city VARCHAR(50) DEFAULT NULL,
    latitude FLOAT DEFAULT NULL,
    longitude FLOAT DEFAULT NULL,
    elementary_school_count INT DEFAULT NULL,
    kindergarten_count INT DEFAULT NULL,
    university_count INT DEFAULT NULL,
    academy_ratio FLOAT DEFAULT NULL,
    elderly_population_ratio FLOAT DEFAULT NULL,
    elderly_alone_ratio FLOAT DEFAULT NULL,
    nursing_home_count INT DEFAULT NULL,
    PRIMARY KEY (region_code)
);

drop TABLE TIMEINFO;
CREATE TABLE TIMEINFO(
    dete DATE NOT NULL,
    test INT(11) DEFAULT NULL,
    negative INT(11) DEFAULT NULL,
    confirmed INT(11) DEFAULT NULL,
    released INT(11) DEFAULT NULL,
    deceased INT(11) DEFAULT NULL,
    PRIMARY KEY (dete)
);

drop TABLE WEATHER;
CREATE TABLE WEATHER(
    region_code INT NOT NULL,
    province VARCHAR(50) DEFAULT NULL,
    wdate DATE NOT NULL,
    avg_temp FLOAT DEFAULT NULL,
    min_temp FLOAT DEFAULT NULL,
    max_temp FLOAT DEFAULT NULL,
    PRIMARY KEY (region_code, wdate)
);

drop TABLE PATIENTINFO;
CREATE TABLE PATIENTINFO (
    patient_id BIGINT NOT NULL,
    sex VARCHAR(10),
    age VARCHAR(10),
    country VARCHAR(50),
    province VARCHAR(50),
    city VARCHAR(50),
    infection_case VARCHAR(50),
    infected_by BIGINT,
    contact_number INT,
    symptom_onset_date DATE,
    confirmed_date DATE,
    released_date DATE,
    deceased_date DATE,
    state VARCHAR(20),

    PRIMARY KEY(patient_id)
);

drop TABLE TIMEINFO;
CREATE TABLE TIMEINFO (
    date date NOT NULL,
    test int(11),
    negative int(11),
    confirmed int(11),
    released int(11),
    deceased int(11),

    PRIMARY KEY(date)
);

drop TABLE TIMEAGE;
CREATE TABLE TIMEAGE (
    date DATE NOT NULL,
    age VARCHAR(10) NOT NULL,
    confirmed int(11),
    deceased int(11),

    PRIMARY KEY(date, age)
);

drop TABLE TIMEGENDER;
CREATE TABLE TIMEGENDER (
    date DATE NOT NULL,
    sex VARCHAR(10) NOT NULL,
    confirmed int(11),
    deceased int(11),

    PRIMARY KEY(date, sex)
);


drop TABLE TIMEPROVINCE;
CREATE TABLE TIMEPROVINCE (
    date DATE NOT NULL,
    province VARCHAR(50) NOT NULL,
    confirmed int(11),
    released int(11),
    deceased int(11),

    PRIMARY KEY(date, province)
);

--ALTER TABLE PATIENTINFO ADD  region_code INT NOT NULL;
--ALTER TABLE PATIENTINFO ADD CONSTRAINT `fk_PATIENTINFO_region_code_REGION_region_code` FOREIGN KEY (region_code) REFERENCES REGION (code) ON DELETE SET NULL ON UPDATE CASCADE;