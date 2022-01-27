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
    <p><h3> Patientinfo table </h3></p>
        <p>
            <form action="" method="post">
                <select name="state" id="state">
                    <option value="none">=== 선택 ===</option>
                    <option value="released">released</option>
                    <option value="isolated">isolated</option>
                    <option value="deceased">deceased</option>
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
            $post_state= $_POST['state'];
            $sql = "select count(*) as num_patient from PATIENTINFO where state = '$post_state';";
		    $result = mysqli_query($link, $sql);
		    $data = mysqli_fetch_assoc($result);	
            
		    echo  $post_state ,' : num of tuples = ', $data['num_patient'];
         }
         else{
             echo '값 받기 실패';
         }
         
		 
		?>    
    </p>
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

		</tr>

		
		<?php
        if(isset($_POST['s'])){

            $post_state= $_POST['state'];
            $sql = "select * from PATIENTINFO where state = '$post_state';";
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