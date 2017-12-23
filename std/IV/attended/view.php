<script>
$(document).ready(function(){
  $(".3").attr("class","active");
});
</script>

<?php 
ob_start();
 if(session_status() == PHP_SESSION_NONE)
   {
    //session has not started
    session_start();
   }
 if(!isset($_SESSION['username']))
   {
    header("refresh:2,url=../login.php");
   }
   
include_once("../includes/connection.php");
 ?>



              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Analysis</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action = "" method="post">
                  <div class="box-body">
                    
					 <div class="form-group">

						<input type="radio" name="choose" value="attended" <?php if($_SESSION['tbname'] == "attended"){ echo 'checked="checked"';}?>><label>Attended</label>&nbsp&nbsp&nbsp
						<input type="radio" name="choose" value="organized" <?php if($_SESSION['tbname'] == "organized"){ echo 'checked="checked"';}?>><label>Organized</label>&nbsp&nbsp&nbsp
						<input type="submit" class="btn btn-warning btn-lg" name="ok" value = "OK"></input><br><br>
						
			
                        <label for="InputDateFrom">Date from :</label>
						<input type="date" name="min_date">
<p>
 						<label for="InputDateTo">Date To :</label>
						<input type="date" name="max_date"></p>
						<label>Faculty :</label>
						<select name="fac">
						<option value="Not Choosen">&nbsp&nbsp&nbspSelect&nbsp&nbsp&nbsp</option>
						<?php	
						
						$_SESSION['tbname'] = $_POST['choose'];						
						$tbname = $_SESSION['tbname'];
						$sql="SELECT * FROM `{$tbname}`";
						$records=mysqli_query($conn,$sql);
						while($employee=mysqli_fetch_assoc($records))
						{
							$name=$employee['f_name'];
							echo "<option value=".$name.">".$name."</option>";
						}				
						?>
						</select>
                    </div>
                   
                   
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-warning btn-lg" name="count_total" value = "Analyize"></input>
                    <a href="template.php?x=../IV/attended/addcount.php" type="button" class="btn btn-warning btn-lg">Back to Home </a>

                  </div>
				   <?php
					$_SESSION['count1'] = 0;
					//$_SESSION['tbname'] = $_POST['choose'];						
					$tbname = $_SESSION['tbname'];
					if(isset($_POST['min_date'])){
						$_SESSION['from_date'] = $_POST['min_date'];
						$_SESSION['to_date'] = $_POST['max_date'];
						$from_date =  $_SESSION['from_date'] ;
						$to_date = $_SESSION['to_date'] ;						
					}
					
				   if(isset($_POST['count_total']))
						{
							if((strtotime($_POST['min_date']))<(strtotime($_POST['max_date'])))
							{
								$sql="SELECT f_name,ind,city,purpose,date FROM `$tbname` WHERE date >= '$from_date' and date <= '$to_date' ORDER BY DATE ASC";
							}
							else
							{
								$sql="SELECT f_name,ind,city,purpose,date FROM `$tbname` WHERE f_name='$_POST[fac]'";
							}
							$_SESSION['fac']=$_POST['fac'];
							if($res1 = mysqli_query($conn,$sql))
							{
									if(mysqli_num_rows($res1) > 0)
									{
										while($row = $res1->fetch_assoc()) 
										{
											$fname[] = $row['f_name'];
											$ind [] = $row['ind'];
											$city[] = $row['city'];
											$purp[] = $row['purpose'];
											$date[] = $row['date'];
											$_SESSION['count1'] = mysqli_num_rows($res1);
										}
									}
							}
						
				   ?>
				<h4></h4>

				<table  class='table table-stripped table-bordered' id = 'example1'>
				<tr> 
							
 							<td><strong>Faculty : <?php echo $_SESSION['fac']; ?></strong></td>
							<td><strong>From :<?php echo $_SESSION['from_date']; ?></strong></td>
							<td><strong>To :<?php echo $_SESSION['to_date']; ?></strong></td>
							<td><strong>Visits Attended :<?php echo $_SESSION['count1']; ?></strong></td>
							
				</tr>	
				</table>
				<div style="margin:20px;">
				<?php
					for($i = 0; $i<$_SESSION['count1']; $i++)
							{
								echo "<table  class='table table-stripped table-bordered' id = 'example1'><td>";
								echo "<strong>Faculty name :</strong>".$fname[$i]."<br>";
								echo "<strong>Industrial Visit Details :</strong>".$ind[$i]."<br>";
								echo "<strong>City :</strong>".$city[$i]."<br>";
								echo "<strong>Purpose of Visit :</strong>" .$purp[$i]."<br>";
								echo "<strong>Date :</strong>".$date[$i]."<br>";
								echo "</td><table>";
								echo "<br>";
							}
				?>
				</div>
				<?php
						}
				?>
				</form>
              </div>
