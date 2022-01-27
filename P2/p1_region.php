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
        <?php
			require_once 'dbconfig.php';
		?>
        
		<?php
		 $sql = "select count(*) as num_region from REGION;";
		 $result = mysqli_query($link, $sql);
		 $data = mysqli_fetch_assoc($result);	
		 echo 'num of tuples = ', $data['num_region'];
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

        $sql = "select * from REGION order by province;";
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