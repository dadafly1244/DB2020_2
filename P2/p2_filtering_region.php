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
    <p><h3> REGION table </h3></p>
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
                </select>
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
            $post_province= $_POST['state'];
            $sql = "select count(*) as num_province from REGION where province = '$post_province';";
		    $result = mysqli_query($link, $sql);
		    $data = mysqli_fetch_assoc($result);	
            
		    echo  $post_province ,' : num of tuples = ', $data['num_province'];
         }
         else{
             echo '값 받기 실패';
         }
         
		 
		?>    
    </p>
	<table calss="table table-striped">
    <tr>
            <th>region_code</th>
            <th>province</th>
            <th>city</th>
            <th>latitude</th>
            <th>longitude</th>
            <th>elementary_school_count</th>
            <th>kindergarten_count</th>
            <th>university_count</th>
            <th>academy_ratio</th>
            <th>elderly_population_ratio</th>
            <th>elderly_alone_ratio</th>
            <th>nursing_home_count</th>

		</tr>

		
		<?php
        if(isset($_POST['s'])){
            
            $post_province= $_POST['state'];
            $sql = "select * from REGION where province = '$post_province';";
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


