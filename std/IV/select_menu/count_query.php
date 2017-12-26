<?php 
include_once("../includes/connection.php"); 
$min_date = $_GET['min_date'];
$max_date = $_GET['max_date'];

$sql="SELECT count(f_id) as total1 from attended where f_name='".$_SESSION['username']."'AND date >=".$min_date." AND date <=".$max_date;
			$result=mysqli_query($conn,$sql);
			$total= mysqli_fetch_assoc($result);

$sql="SELECT count(f_id) as total2 from organized where f_name='".$_SESSION['username']."'AND date >=".$min_date." AND date <=".$max_date;	
			$result=mysqli_query($conn,$sql);
			$total= mysqli_fetch_assoc($result);

			echo $total['total1'];
 ?>