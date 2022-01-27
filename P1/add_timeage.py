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
region_code = []
with open("addtional_Timeinfo.csv", 'r') as file:
    file_read = csv.reader(file)

    col_list = {
        'date': 0,
}
    con=[0,0,0,0,0,0,0,0,0,0,0,0];
    rel=0;
    de=[0,0,0,0,0,0,0,0,0,0,0,0];
    confe=0;
    defe=0;
    for i, line in enumerate(file_read):

        #첫줄은 속성이름이라서 제외하기 
        if not i:
            continue

        # 중복 이거나 "NULL" 값이 아니면 삽입하기.
        if (line[col_list['date']] in region_code) or (line[col_list['date']] == "NULL"):
            continue
        else:
            region_code.append(line[col_list['date']])
        #sql_data 즉 sql로 넣을 데이터 list 선언하고 쿼리문 만들기. 
        sql_data = []
   
        # "NULL" -> None (String -> null)
        for idx in col_list.values():
            if line[idx] == "NULL":
                line[idx] = None
            else:
                line[idx] = line[idx].strip()
            sql_data.append(line[idx])
        age="(SELECT DISTINCT AGE FROM PATIENTINFO)"
        cursor.execute(age)
        age=cursor.fetchall()
      
        for j in range(0,11):

            confirmed="(SELECT COUNT(*) FROM PATIENTINFO WHERE confirmed_date = %s and age=%s)"%('"{}"'.format(line[col_list['date']]),'"{}"'.format(age[j][0]))
            cursor.execute(confirmed)
            result1=cursor.fetchall()
            con[j]=con[j]+int(result1[0][0])

            deceased = "(SELECT COUNT(*) FROM PATIENTINFO WHERE deceased_date = %s and age=%s)"%('"{}"'.format(line[col_list['date']]),'"{}"'.format(age[j][0]))
            cursor.execute(deceased)
            result3 = cursor.fetchall()
            de[j] = de[j] + int(result3[0][0])
            
            movie_vals = "%s,%s,%s,%s" % (
            '"{}"'.format(sql_data[0]), '"{}"'.format(age[j][0]), con[j],de[j])
         
            sql = 'INSERT INTO TIMEAGE VALUES (%s)' % (movie_vals)
            
            #버그 체크 
            try:
                cursor.execute(sql);
                print("inserting" )
            except pymysql.IntegrityError:
                print("%s is already in movie")
            sql="select confirmed from timeinfo"

    conn.commit()
cursor.close()
