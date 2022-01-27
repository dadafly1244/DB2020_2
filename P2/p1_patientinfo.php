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
		<p><h3> PATIENTINFO table </h3></p>

    <p>
        <?php
			require_once 'dbconfig.php';
		?>
        
		<?php
		 $sql = "select count(*) as num_patient from PATIENTINFO;";
		 $result = mysqli_query($link, $sql);
		 $data = mysqli_fetch_assoc($result);	
		 echo 'num of tuples = ', $data['num_patient'];
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

        $sql = "select * from PATIENTINFO;";
        $result = mysqli_query($link, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            print "<tr>";
            foreach($row as $key => $val){
                print "<td>" . $val . "</td>";
            }
            print "</tr>";
        }

      ?>




</body>