<script>
$(document).ready(function(){
  $(".3").attr("class","active");
  $("button.close").click(function(){
  	window.location.replace("../includes/template.php?x=../IV/select_menu/view_menu.php");
  });
  $(".update").click(function(){
  	//alert("bahinikzavrya");	
  });
});

</script>
<?php  
$min_date ="";
$max_date ="";
		
				//header("location:../includes/template.php");
				
			 if(isset($_POST['update']) ||isset($_POST['attended']) ||isset($_POST['organized']))
			{
				
				if(empty($_POST['min_date']) && empty($_POST['max_date']))
				{
				//header("location:../includes/template.php");
				$attended_sql="from attended where f_name='".$_SESSION['username']."'";
				$organized_sql="from organized where f_name='".$_SESSION['username']."'";	
				$sql="SELECT count(f_id) as total ".$attended_sql;
				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
			
				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				$total2= mysqli_fetch_assoc($result);	
				}	
				else
				{				
				$min_date = $_POST['min_date'];
				$max_date= $_POST['max_date'];
				$attended_sql="from attended where f_name='".$_SESSION['username']."'AND date >='".$min_date."' AND date <='".$max_date."'";
			
				$organized_sql="from organized where f_name='".$_SESSION['username']."'AND date >='".$min_date."' AND date <='".$max_date."'";

				$sql="SELECT count(f_id) as total ".$attended_sql;

				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
			
				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				$total2= mysqli_fetch_assoc($result);

			 	$_POST['min_date'] = $min_date; 
				$_POST['max_date'] = $max_date; 
				}	
			}
			else
			{
				$attended_sql="from attended where f_name='".$_SESSION['username']."'";
				$organized_sql="from organized where f_name='".$_SESSION['username']."'";	
				$sql="SELECT count(f_id) as total ".$attended_sql;
				$result=mysqli_query($conn,$sql);
				$total1= mysqli_fetch_assoc($result);
			
				$sql="SELECT count(f_id) as total ".$organized_sql;
				$result=mysqli_query($conn,$sql);
				$total2= mysqli_fetch_assoc($result);
			}	

			?>
<!-- <script>
function count_query() {
	window.alert= (1);
         xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("display").innerHTML = this.responseText;
            }
        }
        window.alert= (1);
        var min_date = document.getElementById('min_date').value;
        var max_date = document.getElementById('max_date').value;
        if(min_date=="" && max_date=="")
        {
        	 window.alert= ("Khali");
        }	
        var query = "?min_date=" + min_date +"&max_date=" + max_date;
        xmlhttp.open("GET","count_query.php="+query,true);
        xmlhttp.send();
    }
}
</script> -->


<div class="box">
	<div class='box-body'>
			<form action="" method="POST">
			<label for="InputDateFrom">Date from :</label>
			<input type="date" name="min_date" value=<?php echo $min_date; ?>>
			&emsp;&emsp;
 			<label for="InputDateTo">Date To :</label>
			<input type="date" name="max_date" value=<?php echo $max_date; ?>>
			<input type="submit" name="update" >
			
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

	<!-- <div class="box-body">

		<form role='form' action='' method='POST'>
			
			<div class='box-header with-border'>
				<h3 class='box-title'>View/Edit Activities</h3>
				<select name="activity" class="box-title" style="margin-left: 100px;">
					<option value="attended">Attended</option>
					<option value="organized">Organized</option>
				</select>
			
						
			<div class='box-footer'>
				<button type='submit' name='submit_view' id='submit' value='' class='btn btn-primary'>View</button>
				<button type='submit' name='cancel' id='cancel' value='' class='btn btn-primary'>Cancel</button>
			</div>
				
		</form>
		
	</div> -->

