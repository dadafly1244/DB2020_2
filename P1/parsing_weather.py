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
region_code = []
with open("./K_COVID19.csv", 'r') as file:
    file_read = csv.reader(file)

  
    col_list = { 
        'region_code' : 23,
        'province' : 4,
        'confirmed_date' : 10,
        'avg_temp' : 14,
        'min_temp' : 15,
        'max_temp' : 16}

    for i,line in enumerate(file_read):

        #Skip first line
        if not i:                           
            continue

        # region_code  중복 이거나 "NULL" 값이 아니면 삽입하기.
        if ((line[col_list['region_code']],line[col_list['confirmed_date']]) in region_code) or (line[col_list['region_code']] == "NULL") or (line[col_list['confirmed_date']]=="NULL") :
            continue
        else:
            region_code.append((line[col_list['region_code']],line[col_list['confirmed_date']]))

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
        query = """INSERT INTO `WEATHER`(Region_code,Province,Wdate,Avg_temp,Min_temp,Max_temp) VALUES (%s,%s,%s,%s,%s,%s)"""
        sql_data = tuple(sql_data)
       
       #버그 체크 
        try:
            cursor.execute(query, sql_data)
            print("[OK] Inserting [%s] to WEATHER"%(line[col_list['region_code']]))
        except (pymysql.Error, pymysql.Warning) as e :
            # print("[Error]  %s"%(pymysql.IntegrityError))
            if e.args[0] == 1062: continue
            print('[Error] %s | %s'%(line[col_list['region_code']],e))
            break

conn.commit()
cursor.close()
