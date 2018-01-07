<script>
$(document).ready(function(){
  $(".3").attr("class","active");
  $("button.close").click(function(){
  	window.location.replace("../includes/template.php?x=../IV/select_menu/view_menu.php");
  });
  $(".update").click(function(){	
  });
});

</script>
<?php  
$min_date ="";
$max_date ="";
$fname="";

			 if(isset($_POST['update']) ||isset($_POST['attended']) ||isset($_POST['organized']))
			{
				$fname=$_POST['fname'];
				
				if(empty($_POST['min_date']) && empty($_POST['max_date']) && !empty($_POST['fname']))
				{
				echo "<h1>11</h1>";
			
				$attended_sql="from attended where f_name='".$fname."'";
				$organized_sql="from organized where f_name='".$fname."'";	
				$sql="SELECT count(f_id) as total ".$attended_sql;
				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
			
				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				$total2= mysqli_fetch_assoc($result);	
				}	
				

				else if(!empty($_POST['fname']))
				{	
				echo "<h1>2</h1>";
					
				$min_date = $_POST['min_date'];
				$max_date= $_POST['max_date'];
				$attended_sql="from attended where f_name='".$fname."'AND date >='".$min_date."' AND date <='".$max_date."'";
			
				$organized_sql="from organized where f_name='".$fname."'AND date >='".$min_date."' AND date <='".$max_date."'";

				$sql="SELECT count(f_id) as total ".$attended_sql;

				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
			
				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				$total2= mysqli_fetch_assoc($result);

			 	$_POST['min_date'] = $min_date; 
				$_POST['max_date'] = $max_date; 
				}	
				
				else if((!empty($_POST['min_date']) && !empty($_POST['max_date'])) && empty($_POST['fname']))
				{	
				echo "<h1>3</h1>";
							
				$min_date = $_POST['min_date'];
				$max_date= $_POST['max_date'];
				$attended_sql="from attended where date >='".$min_date."' AND date <='".$max_date."'";
			
				$organized_sql="from organized where date >='".$min_date."' AND date <='".$max_date."'";

				$sql="SELECT count(f_id) as total ".$attended_sql;

				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
				//echo mysqli_error($conn);

				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				//echo mysqli_error($conn);
				$total2= mysqli_fetch_assoc($result);

			 	$_POST['min_date'] = $min_date; 
				$_POST['max_date'] = $max_date; 
				}	

				else
				{
				echo "<h1>4</h1>";
				
				$attended_sql="from attended";
				$organized_sql="from organized";	
				$sql="SELECT count(f_id) as total ".$attended_sql;
				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
			
				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				$total2= mysqli_fetch_assoc($result);
				}	

			}
			
			else
			{
				$attended_sql="from attended";
				$organized_sql="from organized";	
				$sql="SELECT count(f_id) as total ".$attended_sql;
				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
			
				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				$total2= mysqli_fetch_assoc($result);
			}	

			?>


<div class="box">
	<div class='box-body'>
			<form method="POST">
			<label for="InputDateFrom">Date from :</label>
			<input type="date" name="min_date" value=<?php echo $min_date; ?>>
			&emsp;&emsp;
 			<label for="InputDateTo">Date To :</label>
			<input type="date" name="max_date" value=<?php echo $max_date; ?>>
			&emsp;&emsp;
 			<label for="Faculty-name">Faculty Name</label>
			<input type="text" name="fname">
			&emsp;&emsp;
			<input type="submit" name="update"	>
			
			</div>	

	<div class="box-body">
		
		<table class="table table-striped table-bordered">
			<tr>

			<th>Activity Name</th>
			<th>Total Number of Activities</th>
			<th>Action</th>
			</tr>

			<tr>
			<td>Attended</td>	
			<td>
				<?php echo $total1['total']; ?>
			</td>
			
			<td>
			<button type="submit" class="btn btn-primary" name="attended">View</button>	
			</td>


			</tr>
			<tr>
			<td>Organized</td>
			<td>
				<?php echo $total2['total']; ?>
			</td>
			<td>
			<button type="submit" class="btn btn-primary" name="organized">View</button>	
			</td>
			</tr>
		</table>
		</form>
	</div>
		
	<div class="box-body">
		<?php
		if (isset($_POST['attended'])) 
					{
					$_SESSION['view_query']=$attended_sql;
					include_once("../IV/select_menu/view.php");
					}
				
			if (isset($_POST['organized'])) {
					$_SESSION['view_query']=$organized_sql;
					include_once("../IV/select_menu/view.php");
					
					}
		?>			
	</div>	

	