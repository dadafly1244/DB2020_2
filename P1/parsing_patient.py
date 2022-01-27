# -*- coding: utf-8 -*- 
import pymysql
import csv

# mysql server 연결
conn = pymysql.connect(host='localhost',
                        port = 3306,
                        user='root', 
                        password='GOT_got77', 
                        db='k_covid19', 
                        charset='utf8')

# Connection 으로부터 Cursor 생성
cursor = conn.cursor()

# 중복된 case 제거를 위해 checking list
patient_ID = []
with open("./K_COVID19.csv", 'r') as file:
    file_read = csv.reader(file)

    # index = column - 1
    col_list = { 
        'patient_id' :0,
        'sex' :1,
        'age' : 2,
        'country' : 3,
        'province' : 4,
        'city' :5,
        'infection_case' : 6,
        'infected_by' : 7,
        'contact_number' : 8,
        'symptom_onset_date' : 9,
        'confirmed_date' : 10,
        'released_date' : 11,
        'deceased_date' : 12,
        'state' : 13}

    for i,line in enumerate(file_read):

        #첫줄은 속성이름이라서 제외하기 
        if not i:                           
            continue

        #  patient_id중복 이거나 "NULL" 값이 아니면 삽입하기.
        if (line[col_list['patient_id']] in patient_ID) or (line[col_list['patient_id']] == "NULL") :
            continue
        else:
            patient_ID.append(line[col_list['patient_id']])

        #sql_data 즉 sql로 넣을 데이터 list 선언하고 쿼리문 만들기. 
        sql_data = []
        print(line)
        #"NULL" -> None (String -> null)
        print(col_list.values())
        for idx in col_list.values() :
            if line[idx] == "NULL" :
                line[idx] = None
            else:
                line[idx] = line[idx].strip()

            sql_data.append(line[idx])
        print(sql_data)
        query = """INSERT INTO `patientInfo`(patient_id,sex,age,country,province,city,infection_case,infected_by,contact_number,symptom_onset_date,confirmed_date,released_date,deceased_date,state) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
        sql_data = tuple(sql_data)
       #버그 체크 
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to patientInfo"%(line[col_list['patient_id']]))
        except (pymysql.Error, pymysql.Warning) as e :
            # print("[Error]  %s"%(pymysql.IntegrityError))
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['patient_id']],e))
            break

conn.commit()
cursor.close()

print(len(patient_ID))