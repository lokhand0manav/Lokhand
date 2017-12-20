<script>
$(document).ready(function(){
  $(".4").attr("class","active");
});
</script>
<?php 
ob_start();
if(session_status() == PHP_SESSION_NONE){
    //session has not started
    session_start();
}
$conn=mysqli_connect('localhost','root','','preyash');
if($_SESSION['username']=="")
{
  header("refresh:2,url=../login.php");
  die("Login Required");
}
else
{
  $username = $_SESSION['username'];
}
$flag=0;
$dateerr = "";
$fnameerr = "";
$inderr = "";
$cityerr = "";
$perr = "";
$taerror="";
$serror="";
function test_input($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['add']))
	{

		//the form was submitted
    
		$ivdate_array = $_POST['ivdate'];
		$fname_array = $_POST['fname'];
		$ind_array = $_POST['ind'];
		$city_array = $_POST['city'];
		$purpose_array = $_POST['purpose'];
		$from_array= $_POST['from'];
		$t_audience_array = $_POST['t_audience'];
		$staff_array = $_POST['staff'];
		$to_array= $_POST['to'];
		
		for($i=0; $i<count($city_array);$i++)
		{
			$ivdate = mysqli_real_escape_string($conn,$ivdate_array[$i]);
			$fname = mysqli_real_escape_string($conn,$fname_array[$i]);
			$ind = mysqli_real_escape_string($conn,$ind_array[$i]);
			$city = mysqli_real_escape_string($conn,$city_array[$i]);
			$purpose = mysqli_real_escape_string($conn,$purpose_array[$i]);	
			$t_audience = mysqli_real_escape_string($conn,$t_audience_array[$i]);
			$staff = mysqli_real_escape_string($conn,$staff_array[$i]);	
			$from = mysqli_real_escape_string($conn,$from_array[$i]);
			$to = mysqli_real_escape_string($conn,$to_array[$i]);
			
			if(empty($_POST['ivdate[]']))
			{
				$dateerr="Please enter a date";
				$flag++;
			}
			if(empty($_POST['fname[]']))
			{
				$fnameerr="Enter a name";
				$flag++;
			}else 
				{
					$name = test_input($_POST['fname[]']);
					if (!preg_match("/^[a-zA-Z]*$/",$name))
					{
						$fnameerr = "Only letters and whitespace allowed";
						$flag++;
					}
				}
			if(empty($_POST['sname[]']))
			{
				$snameerr="Enter a name";
				$flag++;
			}
			else
			{
				$name = test_input($_POST['sname[]']);
				if (!preg_match("/^[a-zA-Z]*$/",$name))
				{
					$snameerr = "Only letters and whitespace allowed";
					$flag++;
				}
			}
			if(empty($_POST['ind[]']))
			{
				$inderr="Please enter the details";
				$flag++;
			}
			if(empty($_POST['city[]']))
			{
				$cityerr="Enter the city";
				$flag++;
			}
			else 
			{
				$city = test_input($_POST['city[]']);
				if (!preg_match("/^[a-zA-Z]*$/",$city))
				{
					$cityerr = "City name cannot contain number";
					$flag++;
				}
			}
			if(empty($_POST['purpose[]']))
			{
				$perr="Please enter a date";
				$flag++;
			}
			if(empty($_POST['t_audience[]']))
			{
				$taerror = "Please Enter Target Audience";
				$flag++;
			}
			if(empty($_POST['staff[]']))
			{
				$serror = "Please Enter the Staff";
				$flag++;
			}

			$sql="INSERT INTO organized (f_name,ind,city,purpose,date,t_audience,staff,permission,report,certificate,attendance,t_from,t_to) VALUES ('$fname','$ind','$city','$purpose','$ivdate','$t_audience','$staff','','','','','$from','$to')";
			if(!mysqli_query($conn,$sql))
			{
				echo"Not Inserted";
			}
			else
			{
				//echo"Record Inserted Successfully !";
				
			}
		}
				mysqli_close($conn);
				header("refresh:1; url=template.php?x=../organized/view_admin.php");
	}
}

?>



	<section class="content-header">
		<div class="container " style="border: 1px solid black;padding: 10px 60px;width:50%">
			<h2>Organized</h2>
			<label for="faculty-name">HOD</label>
       
			<?php
			
					for($k=0; $k<$_SESSION['count'] ; $k++)
					{

				?>
				________________________________________________________
			<form class="form-horizontal" method="post" action="">

				<div class="form-group">
					<label>Date of visit:</label>
					<input type="date" name="ivdate[]" class="form-control">
					<span class="error"><?php echo $dateerr; ?></span>
				</div>

				<div class="form-group">
					<label >Faculty Name:</label>      
					<?php
					//include("includes/connection.php");
        			$conn=mysqli_connect('localhost','root','','preyash');
					$query="SELECT * from signin";
					$result=mysqli_query($conn,$query);
					echo "<select name='fname[]' id='fname' class='form-control input-lg'>";
					while ($row =mysqli_fetch_assoc($result)) {
						echo "<option value='" . $row['Username'] ."'>" . $row['Username'] ."</option>";
					}
					echo "</select>";
		   ?>

				</div>

				<!--<div class="form-group">
					<label >Staff Name:</label>      
					<input type="text" class="form-control" name="sname[]">
					<span class="error"><?php echo $snameerr; ?></span>
				</div>-->

				<div class="form-group">
					<label >Industry Details</label>         
					<input type="textarea" rows="5" cols="5" class="form-control" name="ind[]">
					<span class="error"><?php echo $inderr; ?></span>
				</div>

				<div class="form-group">
					<label>City</label>
					<input type="text" class="form-control" name="city[]">
					<span class="error"><?php echo $cityerr; ?></span>
				</div>

				<div class="form-group">
					<label>Purpose</label>
					<input type="text" class="form-control" name="purpose[]">
					<span class="error"><?php echo $perr; ?></span>
				</div>

				<div class="form-group">
					<label>Target Audience</label>
					<input type="text" class="form-control" name="t_audience[]">
					<span class="error"><?php echo $taerror; ?></span>
				</div>

				<div class="form-group">
					<label>Staff</label>
					<input type="text" class="form-control" name="staff[]">
					<span class="error"><?php echo $serror; ?></span>
				</div>


				<div class="form-group">
					<label>Duration</label><br>
					From: <input type="date" name="from[]" placeholder="from">
					To :<input type="date" name="to[]" placeholder="to"><br>
				</div>  

				<!--<div class="form-group">
					<label>Attach Attendance Record</label><br>
					<input type="file" class="btn btn-file" value="Browse.." name="attendance" id="attendance">
				</div>

				<div class="form-group">
					<label>Attach Permission Letter</label><br>
					<input type="file" class="btn btn-file" value="Browse..." name="permission" id="permission">
				</div>  
				<div class="form-group">
					<label>Attach Report</label><br>
					<input type="file" class="btn btn-file" value="Browse.." name="report" id="report">
				</div>

				<div class="form-group">
					<label>Attach Certificate</label><br>
					<input type="file" class="btn btn-file" value="Browse..." name="certificate" id="certificate">
				</div>  -->
				<?php
					}
				?>

				<div class="form-group">        
					<button type="submit" name="add" class="btn btn-primary">Submit</button>
				</div>
			</form>

		</div>
	</section>

</body>
 </html>
