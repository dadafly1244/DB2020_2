CREATE VIEW patient_region AS 
SELECT P.Province,P.city,P.patient_id,P.age,P.infection_case,R.elementary_school_count 
FROM PATIENTINFO AS P, REGION AS R 
WHERE P.province=R.province and R.city=P.city;