# -*- coding: utf-8 -*-
import pymysql
import csv

# mysql server 연결, port 및 host 주의!
conn = pymysql.connect(host='localhost',
                        port = 3306,
                        user='root', 
                        password='GOT_got77', 
                        db='k_covid19', 
                        charset='utf8')

# Connection 으로부터 Cursor 생성
cursor = conn.cursor()

# 중복된 case 제거를 위해 checking list
timeinfo_date = []
with open("addtional_Timeinfo.csv", 'r') as file:
    file_read = csv.reader(file)

    col_list = {
        'date': 0,
        'test': 1,
        'negative': 2,
}
    con=0;
    rel=0;
    de=0;
    for i, line in enumerate(file_read):

       #첫줄은 속성이름이라서 제외하기
        if not i:
            continue

        # timeinfo_date 중복 이거나 "NULL" 값이 아니면 삽입하기.
        if (line[col_list['date']] in timeinfo_date) or (line[col_list['date']] == "NULL"):
            continue
        else:
            timeinfo_date.append(line[col_list['date']])
            
        #sql_data 즉 sql로 넣을 데이터 list 선언하고 쿼리문 만들기. 
        sql_data = []
        print(line)
        # "NULL" -> None (String -> null)
        print(col_list.values())
        for idx in col_list.values():
            if line[idx] == "NULL":
                line[idx] = None
            else:
                line[idx] = line[idx].strip()
            sql_data.append(line[idx])

        confirmed="(SELECT COUNT(*) FROM PATIENTINFO WHERE confirmed_date = %s)"%('"{}"'.format(line[col_list['date']]))
        cursor.execute(confirmed)
        result1=cursor.fetchall()
        con=con+int(result1[0][0])

        released = "(SELECT COUNT(*) FROM PATIENTINFO WHERE released_date = %s)"%('"{}"'.format(line[col_list['date']]))
        cursor.execute(released)
        result2 = cursor.fetchall()
        rel = rel + int(result2[0][0])

        deceased = "(SELECT COUNT(*) FROM PATIENTINFO WHERE deceased_date = %s)"%('"{}"'.format(line[col_list['date']]))
        cursor.execute(deceased)
        result3 = cursor.fetchall()
        de = de + int(result3[0][0])
        sql_data.append(con)
        sql_data.append(rel)
        sql_data.append(de)
        print(sql_data)
        query = """INSERT INTO `TIMEINFO`(date,test,negative,confirmed,released,deceased) VALUES (%s,%s,%s,%s,%s,%s)"""
        print(sql_data[4])
        sql_data = tuple(sql_data)
        print(query)
        
        #버그 체크 
        timeinfo_vals = "%s,%s,%s,%s,%s,%s" % (
        '"{}"'.format(sql_data[0]), sql_data[1], sql_data[2],sql_data[3],sql_data[4],sql_data[5])
        sql = 'INSERT INTO TIMEINFO VALUES (%s)' % (timeinfo_vals)
        try:
            cursor.execute(sql);
            print("inserting" )
        except pymysql.IntegrityError:
            print("%s is already in movie")
        sql="select confirmed from timeinfo"


    conn.commit()
cursor.close()
