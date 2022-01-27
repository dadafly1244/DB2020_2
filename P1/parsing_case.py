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
case_ID = []
with open("./K_COVID19.csv", 'r') as file:
    file_read = csv.reader(file)

    col_list = {
        'case_id' : 17,
        'province' : 4,
        'city' : 5,
        'infection_group' : 19,
        'infection_case' : 6,
        'confirmed' : 20,
        'latitude' : 24,
        'longitude' : 25 }

    for i,line in enumerate(file_read):

        #첫줄 건너 뛰기. 
        if not i:                           
            continue

        #  case_id 중복 이거나 "NULL" 값이 아니면 삽입하기. 
        if (line[col_list['case_id']] in case_ID) or (line[col_list['case_id']]=="NULL") :
            continue
        else:
            case_ID.append(line[col_list['case_id']])

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
        query = """INSERT INTO `caseINFo`(case_id,province,city,infection_group,
        infection_case,confirmed,latitude,longitude) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)"""

        sql_data = tuple(sql_data)
        
        
        #버그 체크 
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to caseINFo"%(line[col_list['case_id']]))
        except (pymysql.Error, pymysql.Warning) as e :
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['case_id']],e))
            break

conn.commit()
cursor.close()

