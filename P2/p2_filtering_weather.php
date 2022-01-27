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
    <p><h3> WEATHER table </h3></p>
        <p>
        

            <form action="" method="post">
            <td>
                <select name="y" id ="y">
                <option value="2020">2020 </option>
                </select>
                <select name="m" id = "m">
                <option value="1">1 </option>
                <option value="2">2 </option>
                <option value="3"> 3 </option>
                <option value="4"> 4 </option>
                <option value="5"> 5 </option>
                <option value="6"> 6 </option>
               
                </select>
                Month
                </td>
                <td>
                <select name="d" id = "d">
                <option value="1"> 1 </option>
                <option value="2"> 2 </option>
                <option value="3"> 3 </option>
                <option value="4"> 4 </option>
                <option value="5"> 5 </option>
                <option value="6"> 6 </option>
                <option value="7"> 7 </option>
                <option value="8"> 8 </option>
                <option value="9"> 9 </option>
                <option value="10"> 10 </option>
                <option value="11"> 11 </option>
                <option value="12"> 12 </option>
                <option value="13"> 13 </option>
                <option value="14"> 14 </option>
                <option value="15"> 15 </option>
                <option value="16"> 16 </option>
                <option value="17"> 17 </option>
                <option value="18"> 18 </option>
                <option value="19"> 19 </option>
                <option value="20"> 20 </option>
                <option value="21"> 21 </option>
                <option value="22"> 22 </option>
                <option value="23"> 23 </option>
                <option value="24"> 24 </option>
                <option value="25"> 25 </option>
                <option value="26"> 26 </option>
                <option value="27"> 27 </option>
                <option value="28"> 28 </option>
                <option value="29"> 29 </option>
                <option value="30"> 30 </option>
                <option value="31"> 31 </option>
                </select>
                Day
                </td>
                <input type=submit value="submit" name="s">
            </form>
            <script type="text/javascript">
                document.getElementById('y').value = "<?php echo $_POST['y'];?>";
                document.getElementById('m').value = "<?php echo $_POST['m'];?>";
                document.getElementById('d').value = "<?php echo $_POST['d'];?>";
            </script>
        </p>

       
        
    <p>
        <?php
			require_once 'dbconfig.php';
		?>
        
		<?php
       
         if(isset($_POST['s'])){
            $post_year = $_POST['y'];
            $post_month = $_POST['m'];
            $post_date= $_POST['d'];
            $sql = "select count(*) as num_weather from WEATHER where wdate = '$post_year-$post_month-$post_date';";
		    $result = mysqli_query($link, $sql);
		    $data = mysqli_fetch_assoc($result);	
            
		    echo  $post_year,"Y ",$post_month,"M ",$post_date ,"D ",' : num of tuples = ', $data['num_weather'];
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
        <th>wdate</th>
        <th>avg_temp</th>
        <th>min_temp</th>
        <th>max_temp</th>
            
	</tr>

		
		<?php
        if(isset($_POST['s'])){
            
            $post_year = $_POST['y'];
            $post_month = $_POST['m'];
            $post_date= $_POST['d'];
            $sql = "select *  from WEATHER where wdate = '$post_year-$post_month-$post_date';";
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


