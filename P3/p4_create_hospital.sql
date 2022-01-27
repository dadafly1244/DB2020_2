drop TABLE HOSPITAL;
CREATE table HOSPITAL(
    hospital_id INT NOT NULL,
    hospital_name VARCHAR(100),
    hospital_province VARCHAR(50),
    hospital_city VARCHAR(50),
    hospital_latitude FLOAT DEFAULT NULL,
    hospital_longitude FLOAT DEFAULT NULL,
    capacity INT,
    current INT,

    PRIMARY KEY (hospital_id)
);

ALTER TABLE PATIENTINFO add column hospital_id INT DEFAULT NULL;