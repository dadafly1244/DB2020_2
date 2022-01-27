--이미지 indexing_hospital_id
--병원 번호로 환자 찾기 
select * from PATIENTINFO where  hospital_id= 15;

--hospital_id를 인덱스로 만들기 
CREATE INDEX idx_hospital_id ON PATIENTINFO(hospital_id);

--idx_hospital_id를 인덱스로 병원 번호에 해당하는 환자 찾기   
explain select * from PATIENTINFO where  hospital_id= 15;
--5162개 검색에서 133개 검색으로 성능 향상됨. 

--이미지 indexing_hospital_id_r2
--idx_hospital_id를 인덱스로 병원 번호에 해당하는 환자 찾기2  
select patient_id, hospital_id from PATIENTINFO where hospital_id = 35;

explain select patient_id, hospital_id from PATIENTINFO where hospital_id = 35;


--idx_patient_id 성능향상 없음
CREATE INDEX idx_patient_id ON PATIENTINFO(patient_id);

explain select * from PATIENTINFO  use index (idx_patient_id)where  hospital_id= 15;
explain select patient_id, hospital_id  from PATIENTINFO use index (idx_patient_id) where hospital_id = 35;

--hospital_id로 만드는게 제일 좋았음!! 