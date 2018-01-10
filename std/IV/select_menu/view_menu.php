<!--queries can be found in IV/IVSql.php-->
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
		

					if(isset($_POST['faculty']))
					{
  						$f_id = $_POST['faculty'];

					}
				else
					{
  						$f_id = $_SESSION['f_id'];
					}

			 if(isset($_POST['update']) ||isset($_POST['attended']) ||isset($_POST['organized']))
			{

				if(empty($_POST['min_date']) && empty($_POST['max_date']))
				{	
				$total1 = mysqli_fetch_assoc(count_query("attended",$f_id,0));
				$total2 = mysqli_fetch_assoc(count_query("organized",$f_id,0));	
				}	
				else
				{				
				$GLOBALS['min_date'] = $_POST['min_date'];
				$GLOBALS['max_date']= $_POST['max_date'];

				$total1= mysqli_fetch_assoc(count_query("attended",$f_id,1)); 
				$total2= mysqli_fetch_assoc(count_query("organized",$f_id,1)); 
				

			 	$_POST['min_date'] = $GLOBALS['min_date']; 
				$_POST['max_date'] = $GLOBALS['max_date']; 
				}	
			}
			else
			{
				$total1 = mysqli_fetch_assoc(count_query("attended",$f_id,0));
				$total2 = mysqli_fetch_assoc(count_query("organized",$f_id,0));
			}	

			?>


 <div class="box">
	<div class='box-header with-border'>
			<form action="" method="POST">
			<label for="InputDateFrom">Date from :</label>
			<input type="date" name="min_date" value=<?php echo $GLOBALS['min_date']; ?>>
			&emsp;&emsp;
 			<label for="InputDateTo">Date To :</label>
			<input type="date" name="max_date" value=<?php echo $GLOBALS['max_date']; ?>>
			
			
	</div>
	<?php
//When HOD
	if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
	{
?>			<div class='box-header with-border'>
				<h3 class='box-title'>Select Faculty</h3>
				<select name="faculty" class="box-title" style="margin-left: 140px;">
				<?php
				echo "<option value = '0'>ALL</option>";
							  $temp="";
                              $temp = getFacultyDetails($temp);
                              while($fac=mysqli_fetch_assoc($temp))
                                {
                                    if($fac[Fac_ID]!=9) //not HOD
                                    {
                          				 if(isset($_POST['faculty']) && $_POST['faculty']==$fac['Fac_ID'])
                          				 {
                          					echo "<option value = '$fac[Fac_ID]' SELECTED >$fac[F_NAME]</option>";	 	
                          				 }
                          				 else
											echo "<option value = '$fac[Fac_ID]'".">$fac[F_NAME]</option>";
									}
                                }
				?>	
				</select>		
			</div><!-- /.box-header   -->
<?php 
	}
?>		
	<div class='box-footer'>
		<button type='submit' name='update' id='submit' value='' class='btn btn-primary'>View</button>
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
					//$_SESSION['view_query']=$attended_sql;
					include_once("../IV/select_menu/view.php");
					}
				
				if (isset($_POST['organized'])) {
					//$_SESSION['view_query']=$organized_sql;
					include_once("../IV/select_menu/view.php");
					
					}
		?>			
	</div>
</div>

