<style>
	table{
		width : 100%
		border : 1px solid #444444;
		border-collapse: collapse;
		}
		th, td{
			border: 1px solid #444444;
		}
	}
</style>


<body>
	<!--병원 별 환자 표시해 주는 페이지 =-->
    <p><h3> 환자는 어느 병원에 입원 중일까요? </h3></p>
        <p>
            <!-- 병원에 번호 입력 -->

            <form action="" method="post">
                hospital_id : <input type="text" name="id"  placeholder="Enter id here" />
                <input type=submit value="submit" name="s">
            </form>
            
        </p>

       
        
    <p>
        <?php
			require_once 'dbconfig.php';
		?>
        
		<?php
            // 병원에 입원한 환자 수 표시 
         if(isset($_POST['s'])){
            $post_hopital_id= $_POST['id'];
            $sql = "select count(*) as num_patient from PATIENTINFO where hospital_id = '$post_hopital_id';";
		    $result = mysqli_query($link, $sql);
		    $data = mysqli_fetch_assoc($result);	
            
		    echo  $post_hopital_id ,'번 병원에 입원한 환자의 수 = ', $data['num_patient'];
         }
         else{
             echo '값 받기 실패';
         }
         
		 
		?>    
    </p>
    <!-- 환자 정보 -->
	<table calss="table table-striped">
    <tr>
            <th>patient_id</th>
            <th>sex</th>
            <th>age</th>
            <th>country</th>
            <th>province</th>
            <th>city</th>
            <th>infection_case</th>
            <th>infected_by</th>
            <th>contact_number</th>
            <th>symptom_onset_date</th>
            <th>confirmed_date</th>
            <th>released_date</th>
            <th>deceased_date</th>
            <th>state</th>
            <th>hospital_id</th>
            
        </tr>

		
		<?php
        if(isset($_POST['s'])){
            // 입력된 병원 번호에 해당하는 환자 정보 불러오기 
            $post_hopital_id= $_POST['id'];
            $sql = "select * from PATIENTINFO where  hospital_id= '$post_hopital_id';";
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                print "<tr>";
                foreach($row as $key => $val){
                    
                    // 병원 번호에 지도 페이지로 링크 걸기
                    if($key=='hospital_id'){
                        print "<td> <a href='p4_map?hospital_id={$val}' target='_blank'>". $val . "</a></td>";
                        
                    }
                    else{
                    print "<td>" . $val . "</td>";}
                }
                print "</tr>";
            }
        }
        

      ?>




</body>


