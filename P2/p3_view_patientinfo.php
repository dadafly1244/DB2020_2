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
	<!-- MOVIES	 talble =-->
    <p><h3> PATIENT_REGION table </h3></p>
	
        <p>
        

            <form action="" method="post">
            
				 <select name="state" id="state">
				 	<option value="none">=== 선택 ===</option>
                    <option value="Seoul">Seoul</option>
                    <option value="Busan">Busan</option>
                    <option value="Daegu">Daegu</option>
                    <option value="Incheon">Incheon</option>
                    <option value="Ulsan">Ulsan</option>
                    <option value="Chungcheongbuk-do">Chungcheongbuk-do</option>
                    <option value="Chungcheongnam-do">Chungcheongnam-do</option>
                    <option value="Jeollabuk-do">Jeollabuk-do</option>
                    <option value="Gyeonggi-do">Gyeonggi-do</option>
                    <option value="Daejeon">Daejeon</option>
                    <option value="Sejong">Sejong</option>
                    <option value="Gangwon-do">Gangwon-do</option>
                    <option value="Gyeongsangbuk-do">Gyeongsangbuk-do</option>
                    <option value="Gyeongsangnam-do">Gyeongsangnam-do</option>
                    <option value="Jeollanam-do">Jeollanam-do</option>
                    <option value="Jeju-do">Jeju-do</option>


                <input type=submit value="submit" name="s">
            </form>
            <script type="text/javascript">
                document.getElementById('state').value = "<?php echo $_POST['state'];?>";
            </script>
        </p>

       
        
    <p>
        <?php
			require_once 'dbconfig.php';
		?>
        
		<?php
       
         if(isset($_POST['s'])){
            
			$post_province=$_POST['state'];
            $sql = "select count(*) as num_province from patient_region where province='$post_province';";
		    $result = mysqli_query($link, $sql);
		    $data = mysqli_fetch_assoc($result);	
            
		    if($data['num_province']==0){
				echo '값 없음';
				}
				else{
					echo  $post_province ,' province : num of tuples = ', $data['num_province'];
					echo "	<table calss=&quot;table table-striped&quot;>
				<tr>

	        		<th>province</th>
					<th>city</th>
					<th>Patient_id</th>
					<th>Age</th>
					<th>Infection_Case</th>
					<th>Elementary_school_count</th>

            		</tr>";
							};
		
		}
         else{
             echo '값 받기 실패';
         };
         
		 
		?>    
    </p>


		
		<?php
        if(isset($_POST['s'])){
           
			$post_province=$_POST['state'];
            $sql = "select * from patient_region where province='$post_province' order by city, age;";
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                print "<tr>";
                foreach($row as $key => $val){
                    print "<td>" . $val . "</td>";
                }
                print "</tr>";
            }
        }
        

      ?>




</body>


