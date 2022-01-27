# 한국 코로나 데이터 DATABASE 설계 
by 양다영, 최예린

<br>
<br>

## 과제 3 
>2 차시에서 팀별로 parsing하고 데이터베이스에 insert한 데이터들을 이용하여 web 상에 출력하면서 의미 있는 data들을 뽑아내는 것(Patientinfo, Case, Region, Weather, Time_info 5개의 테이블 이용)

<br>
<br>

## 과제 설명
1. Patientinfo, Case, Region, Weather, Time_info 테이블을 웹 페이지 상에 출력, 최상단에 row갯수(select된 튜플 수)를 출력한다.

2. 테이블들 attribute들중에서 하나를 고르고, 선택한 attribute를 기준으로 filtering한 것을 웹 페이지 상에 출력, 최상단에 row갯수(select된 튜플 수)를 출력한다.

3. 5개의 테이블을 자유롭게 사용하여(select, join, where, group by, having, union등) 하나의 의미 있는 view를 뽑아낸 후 웹페이지 상에 출력한다.

<br>
<br>

# 문제 1
> Patientinfo, Case, Region, Weather, Time_info 테이블을 web상에 출력한다.

CASEINFO 테이블 출력 코드를 예시로 가져왔다.

<br>
<br>

## [PHP로 모든 테이블 데이터 출력하기]
```php
	<?php

        $sql = "select * from CASEINFO;";
        $result = mysqli_query($link, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            print "<tr>";
            foreach($row as $key => $val){
                print "<td>" . $val . "</td>";
            }
            print "</tr>";
        }

    ?>
```
$sql 변수에 CASEINFO의 모든 데이터를 가져오는 SQL문을 문자열로 저장하고 실행시킨다. 반복문을 돌면서 웹에 테이블을 출력한다. 
- mysqli_fetch_assoc(): mysqli_query 를 통해 얻은 리절트 셋(result set)에서 레코드를 1개씩 리턴해주는 함수

<br>
<br>

## [PHP로 테이블 ROW 수 출력하기]
```php
		<?php
		 $sql = "select count(*) as num_caseinfo from CASEINFO;";
		 $result = mysqli_query($link, $sql);
		 $data = mysqli_fetch_assoc($result);	
		 echo 'num of tuples = ', $data['num_caseinfo'];
		?>    
```
위와 동일하지만 이번에는 $sql 변수에 count(*)를 이용해 row 수를 출력하는 SQL문을 저장하고 실행시킨다.
실행 결과를 출력된 데이터의 튜플 수를 알려주는 문장과 함께 출력한다.

<br>
<br>

# 문제 2
> 테이블 3개를 골라 한 가지 attribute로 필터링한다.

PATIENTINFO, REGION, WEATHER 테이블을 선택해 SELECT BOX를 사용해 필터링한 데이터를 확인할 수 있도록 했다.

<br>
<br>

## [PATIENTINFO TABLE]
### 필터링에 사용된 attribute

    state = 환자의 상태

- released(격리해제)
- isolated(격리)
- deceased(사망)

## [REGION TABLE]
### 필터링에 사용된 attribute

    province = 지역

- Seoul
- Busan
- Incheon
- Ulsan
- Chungcheongbuk...등


## [WEATHER TABLE]
### 필터링에 사용된 attribute
    wdate = 날짜
- year
- month
- date 

<br>
<br>

# 문제 3
## [선택한 테이블]
* PATIENTINFO
* REGION

<br>
<br>

## [CREATE VIEW SQL문]
```sql
CREATE VIEW patient_region AS 
SELECT P.Province,P.city,P.patient_id,P.age,P.infection_case,R.elementary_school_count 
FROM PATIENTINFO AS P, REGION AS R 
WHERE P.province=R.province and R.city=P.city;
```

PATIENTINFO 테이블과 REGION 테이블을 같은 PROVINCE, CITY별로 JOIN한 결과를 VIEW로 생성한 뒤 PHP로 웹페이지에 데이터를 출력했다.


<br>
<br>

# 오류해결
### [셀렉트 박스(SELECT BOX) 오류]
```javascript
<script
type="text/javascript">document.getElementById('state') value = "<?php echo $_POST['state'];?>";
</script>
```


박스에서 state를 선택한 후 값은 잘 불러와졌지만 선택 박스의 텍스트는 바뀌지 않았던 문제를 위와 같은 코드로 해결했다.