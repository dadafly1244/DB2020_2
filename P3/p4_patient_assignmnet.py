# -*- coding: utf-8 -*- 
import pymysql
import numpy as np
import math

#유클리디안거리 구하는 함수 
def euclidean_distance(x, y):   
    return np.sqrt(np.sum((x - y) ** 2))

# mysql server 연결
conn = pymysql.connect(host='localhost',
                        port = 3306,
                        user='root', 
                        password='GOT_got77', 
                        db='k_covid19', 
                        charset='utf8')


# Connection 으로부터 Cursor 생성
cursor = conn.cursor()

sql_hospital_location = "SELECT hospital_id, hospital_latitude, hospital_longitude ,capacity, current from HOSPITAL"
cursor.execute(sql_hospital_location)


hospital_location = cursor.fetchall()



sql_location="SELECT p.patient_id, r.latitude, r.longitude FROM PATIENTINFO p, REGION r WHERE p.province = r.province AND p.city = r.city "
cursor.execute(sql_location)


### current, capaticy count 해야해...... ㅋㅋㅋㅋ 그리고 나중에 인서트 해야해..... 그리고... patientdinfo도 업데이트해햇ㅂtlqkf tlqkf 
# current 값을 받아올 배열 선언
hospital_current=[0 for i in range(45)]

patient_location = cursor.fetchall()
#patient 전체 받아와서 하나씩 돌리기
for patient_data in patient_location: 
    min_dis = 99999999
    min_hospital_id = 1
    patient_lat_long = []
    
    patient_lat_long.append(patient_data[1])
    patient_lat_long.append(patient_data[2])
    #print(hospital_lat_long)
    #print()
    
    #환자 한명이랑 병원 한개씩 거리 계산하기
    for hospital_data in hospital_location:
        
        #만약 수용인원을 넘겼다면 그 병원은 제외하기.
        if hospital_data[3] <= hospital_current[hospital_data[0]]:
             # 처리처리 
            continue
        
        hospital_lat_long = []
        hospital_lat_long.append(hospital_data[1])
        hospital_lat_long.append(hospital_data[2])
        
        # 병원과 환자간의 유클리디안 거리 구하기 
        euc_result = math.floor(euclidean_distance(np.array(patient_lat_long*10000), np.array(hospital_lat_long*10000)))
        #print(euc_result)
        #최단거리 구하기업뎃해주기 
        if euc_result <=  min_dis:
            min_dis = euc_result
            min_hospital_id = hospital_data[0]
    
    #어디 병원에 patientinfo가 있는지 업데이트 해주기 
    print(min_hospital_id,min_dis)
    query = "UPDATE PATIENTINFO SET hospital_id= {0} WHERE patient_id = {1}".format(min_hospital_id,patient_data[0])
    print(query)
    #버그 체크 
    try:
        cursor.execute(query)
        print("[OK] Inserting [%s] to hospital"%(min_hospital_id))
    except (pymysql.Error, pymysql.Warning) as e :     
        if e.args[0] == 1062: continue
        print('[Error] %s'%(min_hospital_id))
        break   
    hospital_current[min_hospital_id]+=1
    
    #hospital에 current 업데이트 해주기 
    query = "UPDATE HOSPITAL SET current= {0} WHERE hospital_id = {1}".format(hospital_current[min_hospital_id],min_hospital_id)
    #버그 체크
    print(query)
    try:
        cursor.execute(query)
        print("[OK] Inserting [%s] to hospital"%(min_hospital_id))
    except (pymysql.Error, pymysql.Warning) as e :     
        if e.args[0] == 1062: continue
        print('[Error] %s'%(min_hospital_id))
        break   

            
    
    



conn.commit()
cursor.close()