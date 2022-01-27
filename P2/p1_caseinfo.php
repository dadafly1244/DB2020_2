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
		<p><h3> CASEINFO table</h3></p>

    <p>
        <?php
			require_once 'dbconfig.php';
		?>
        
		<?php
		 $sql = "select count(*) as num_caseinfo from CASEINFO;";
		 $result = mysqli_query($link, $sql);
		 $data = mysqli_fetch_assoc($result);	
		 echo 'num of tuples = ', $data['num_caseinfo'];
		?>    
    </p>
	<table calss="table table-striped">
		<tr>
            <th>case_id</th>
            <th>province</th>
            <th>city</th>
            <th>infection_group</th>
            <th>infection_case</th>
            <th>confirmed</th>
            <th>latitude</th>
            <th>longitude</th>

		</tr>

		
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




</body>