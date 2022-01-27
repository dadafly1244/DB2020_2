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
hospital_id = []


with open(".\Hospital.csv", 'r', encoding='UTF8') as file:
    file_read = csv.reader(file)

    # index = column - 1
    col_list = { 
                
        'hospital_id' : 0,
        'hospital_name' :1,
        'hospital_province':2,
        'hospital_city' :3 ,
        'hospital_latitude' :4,
        'hospital_longitude' :5,
        'capacity' :6,
        'current' :7,     
        
        }

    for i,line in enumerate(file_read):

        #첫줄은 속성이름이라서 제외하기
        if not i:                           
            continue

        # region_code 중복 이거나 "NULL" 값이 아니면 삽입하기.
        if (line[col_list['hospital_id']] in hospital_id) or (line[col_list['hospital_id']] == "NULL") :
            continue
        else:
            hospital_id.append(line[col_list['hospital_id']])

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
        query = """INSERT INTO `hospital`(hospital_id,hospital_name,hospital_province,hospital_city,hospital_latitude,
        hospital_longitude,capacity,current) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)"""
        sql_data = tuple(sql_data)
       
       #버그 체크 
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to hospital"%(line[col_list['hospital_id']]))
        except (pymysql.Error, pymysql.Warning) as e :
            
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['hospital_id']],e))
            break

conn.commit()
cursor.close()
