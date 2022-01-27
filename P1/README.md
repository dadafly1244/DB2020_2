# 한국 코로나 데이터 DATABASE 설계 
by 양다영, 최예린


## 과제 1 
>'k_covid19.csv'파일과 additional_Timeinfo.csv 파일을 이용해서 PATIENTINFO, CASEINFO, REGRION, WEATHER, TIME, TIMEAGE, TIMEGENDER, TIMEPROVINCE 테이블을 생성하기. 

# Project 소개 
## [소스 파일 설명]

- README.md          <- 프로젝트 설명 readme 파일
- - 테이블생성.sql <- 테이블 생성 _mysql console에서 실행하기_
- K_COVID19.csv <- PATIENTINFO, CASEINFO, REGRION, WEATHER 테이블 생성 시 사용할 csv 파일
- additional_Timeinfo.csv <- TIME, TIMEAGE, TIMEGENDER, TIMEPROVINCE 테이블 생성시 추가로 사용할 csv 파일. 
- parsing_case.py <- CASEINFO 테이블에 데이터 넣기
- parsing_patient.py <- PATIENTINFO 테이블에 데이터 넣기
- parsing_region.py <-  REGRION 테이블에 데이터 넣기
- parsing_weather.py <- WEATHER 테이블에 데이터 넣기
- add_timeage.py <- TIMEAGE 테이블에 데이터 넣기
- add_timegender.py <- TIMEGENDER 테이블에 데이터 넣기
- add_timeprovince.py <- TIMEPROVINCE 테이블에 데이터 넣기

## [데이터 설명]
* K_COVID19.csv
   * 속성 33개   :  
        patient_id, sex, age, country, province, city,infection_case, infected_by, contact_number,symptom_onset_date, confirmed_date, released_date,deceased_date, state, avg_temp, min_temp, max_temp,case_id, city, infection_group, confirmed, latitude, longitude, region_code, latitude, longitude, elementary_school_count, kindergarten_count, university_count, academy_ratio, elderly_population_ratio, elderly_alone_ratio, nursing_home_count
* additional_Timeinfo.csv 
  * 속성 3개 :  
    date, test, negative

## [테이블 설명]
> * 속성 (data_type) :  속성 설명
### PATIENTINFO

* patient_id (bigint) : PK, region_code(5) + patient_number(5)
* sex (varchar(10)) : female / male 
* age (varchar(10)) : 나이대 ex) 50s : 50대
* country  (varchar(10)) : 한국, 중국 같은 나라
* provice (varchar(10)) : 서울, 부산 같은 특별시 및 광역시 또는 경기도 강원도 와 같은 도
* city (varchar(10)) :
  1. province가 서울 부산 같은 특별시, 광역시인 경우 City는
강남구, 서초구, 해운대구
  2. province가 경상북도 경기도 같은 경우에는 City가
구미시, 안동시
* Infection_case (varchar(10)) : 감염 원인
ex) overseas inflow, contact with patient, Eunpyeong St. Mary's Hospital
* infected_by (bigint) : the ID of who infected this patient  cf) this column refers to the 'patient_id' column.
* contact_number (int) : 접촉한 사람들 수
* symptom_onset_date (date) : 증상발생 날짜
* confirmed_date (date) : 확진(양성 판정) 일
* released_date (date) : 완치(퇴원)날짜
* deceased_date (date) : 사망일
* state (varchar(20)) : isolated / released / deceased

### CASEINFO

* Case_id (int) : PK, The ID of the infection case case_id(7) = region_code(5)+case_number(2)
* province (varchar(50)) : 서울, 부산 같은 특별시 및 광역시 또는 경기도 강원도 와 같은 도
* city (varchar(50)) :
  1. province가 서울 부산 같은 특별시, 광역시인 경우 City는
강남구, 서초구, 해운대구
  2. province가 경상북도 경기도 같은 경우에는 City가
구미시, 안동시
* Infection_group (tinyint(1)): 집단감염 여부
    TRUE = Group infection
    FALSE =not group
* infection_case (varchar(50)) : the infection case (the name of group or other cases) ex) Itaewon Clubs, Guro-gu Call Center
* Confirmed (int) : 확진자 수
* latitude (float) : 위도
* longitude (float) : 경도

### REGRION

* region_code (int) : PK, 지역 코드
* province (varchar(50)) : 서울, 부산 같은 특별시 및 광역시 또는 경기도 강원도 와 같은 도
* city (varchar(50)) :
1. province가 서울 부산 같은 특별시, 광역시인 경우 City는
강남구, 서초구, 해운대구
  2. province가 경상북도 경기도 같은 경우에는 City가
구미시, 안동시
* latitude (float) : 위도
* longitude (float) : 경도
* elementary_school_count (int) : 초등학교 확진자 수(교육기관 별 확진자 수)
* kindergarten_count (int) : 유치원 확진자 수(교육기관 별 확진자 수)
* university_count (int) : 대학교 확진자 수(교육기관 별 확진자 수)
* academy_ratio (float) : 학원 감염자 비율
* elderly_population_ratio (float) : 노인 감염자 비율
* ederly_alone_ratio (float) : 독거 노인 감염자 비율
* nursing_home_count (int) : 요양원 확진자 수

### WEATHER

* region_code (int) : COMPOSITE PK, 지역 코드
* province (varchar(50)) : 서울, 부산 같은 특별시 및 광역시 또는 경기도 강원도 와 같은 도
* wdate (date): COMPOSITE PK, 날짜
* avg_temp (float) : 날짜별, 지역별 평균기온
* min_temp (float) : 날짜별, 지역별 최저기온
* max_temp (float) : 날짜별, 지역별 최고기온

### TIMEINFO
1) date, test, negative 는 additional_time.csv에서 가져옴
* date (date) : PK, 코로나 터진 이후 2020-06-30일 까지의 날짜
* test (int(11)) : 날짜별 누적 코로나 검사 수
* negative (int(11)) : 날짜별 누적 음성 판정 수
2) confirmed, relased, deceased는 patientinfo 에서 누적 사람 수를 count 해서 python variable로 가져옴
* confirmed (int(11)) : 날짜별 누적 확진자 수
* released (int(11)) : 날짜별 누적 격리해제 수
* deceased (int(11)) : 날짜별 누적 사망자 수

### TIMEAGE

* date (date) (int(11)) : COMPOSITE PK, 코로나 터진 이후 2020-06-30일 까지의 날짜
* age (varchar(10)) : COMPOSITE PK,
* confirmed (int(11)) : 날짜별, 연령대별 누적 확진자 수
* deceased (int(11)) : 날짜별, 연령대별 누적 사망자 수

### TIMEGENDER

* date (date) : COMPOSITE PK, 코로나 터진 이후 2020-06-30일 까지의 날짜
* sex (varchar(10)) : COMPOSITE PK,
* confirmed (int(11)) : 날짜별, 성별별 누적 확진자 수
* deceased (int(11)) : 날짜별, 성별별 누적 사망자 수

### TIMEPROVINCE

* date (date) : COMPOSITE PK, 코로나 터진 이후 2020-06-30일 까지의 날짜
* province (varchar(50)) : COMPOSITE PK, PATIENTINFO.Province
* confirmed (int(11)) : 날짜별, 지역별 누적 확진자 수
* released (int(11)) : 날짜별, 지역별 누적 격리해제 수
* deceased (int(11)) : 날짜별, 지역별 누적 사망자 수



## 오류 해결 
1. wampserver가 초록색이 아니라 주황색
    - mysql이 실행이 안되었음. 
    - mysql log에 "[ERROR] Do you already have another mysqld server running on port: 3306 ?" 라는 에러가 나왔음 
    - 해결 참고 블로그 :  "https://dana-study-log.tistory.com/entry/MySQL-MySQL-%EC%84%A4%EC%B9%98-3306-Port-%EC%98%A4%EB%A5%98"
     1. cmd 창에서 다음 코드 입력
    > netstat -ano
    2. 3306 port를 사용하는 PID 확인하기 
    3. cmd 에서 관리자 권한으로 아래 명령어 입력 
    > taskkill /F /PID [해당 PID번호]


  