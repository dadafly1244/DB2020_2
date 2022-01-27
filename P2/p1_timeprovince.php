<style>
	table{
		width:100%;
		border:1px solid #444444;
		border-collapse:collapse;
	}
	th,td{
		border:1px solid #444444;
	}
</style>
<?php
	require_once 'dbconfig.php';
?>
<body>
<?php
	$sql="select count(*) as count_num from (select 1 from TIMEPROVINCE)t;";
	$result=mysqli_query($link,$sql);

	
	$count=mysqli_fetch_assoc($result);
	//echo $count;
	print "<p><h3>TIMEPROVINCE table(current " .$count["count_num"]. " TIMEPROVINCE in databases)</h3></p>";
?>

	<table class="table table-striped">
		<tr>

			<th>Date</th>
			<th>province</th>
			<th>confirmed</th>
			<th>released</th>
			<th>deceased</th>

		</tr>
		<?php
			$sql="select * from (select * from TIMEPROVINCE)t;";
			$result=mysqli_query($link,$sql);
			while($row=mysqli_fetch_assoc($result)){
				print "<tr>";
				foreach($row as $key => $val){
					print "<td>".$val."</td>";
				}
				print"</tr>";
			}
		?>
	</table>
</body>