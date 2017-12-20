<script>
$(document).ready(function(){
  $(".1").attr("class","active");
});
</script>
<?php 
if(session_status() == PHP_SESSION_NONE){
    //session has not started
    session_start();
}
$conn=mysqli_connect('localhost','root','','preyash');
if($_SESSION['username']=="")
{
  header("refresh:1,url=../login.php");
  die("Login Required");
}
else
{
  $username = $_SESSION['username'];
}
$flag=0;
$dateerr = "";
$nameerr = "";
$inderr = "";
$cityerr = "";
$perr = "";
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
		
		for($i=0; $i<count($ivdate_array);$i++)
		{
			$ivdate = mysqli_real_escape_string($conn,$ivdate_array[$i]);
			$fname = mysqli_real_escape_string($conn,$fname_array[$i]);
			$ind = mysqli_real_escape_string($conn,$ind_array[$i]);
			$city = mysqli_real_escape_string($conn,$city_array[$i]);
			$purpose = mysqli_real_escape_string($conn,$purpose_array[$i]);	
	
			if(empty($_POST['ivdate[]']))
			{
				$dateerr="Please enter a date";
				$flag++;
			}
			if(empty($_POST['fname[]']))
			{
				$nameerr="Enter a name";
				$flag++;
			}
			else   
			{
				$name = test_input($_POST['fname[]']);
				if (!preg_match("/^[a-zA-Z]*$/",$name))
				{
					$nameerr = "Only letters and whitespace allowed";
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

			//echo $flag;
			//if($flag=0)
			//{
				$sql="INSERT INTO attended (f_name,ind,city,purpose,date) VALUES ('$fname','$ind','$city','$purpose','$ivdate')";
				if(!mysqli_query($conn,$sql))
				{
					echo"Not Inserted";
				}
				else
				{
			
				}
			//}
		}
				mysqli_close($conn);
				header("location:template.php?x=../attended/view_admin.php");
	}
}
?>


  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container " style="border: 1px solid black;padding: 10px 60px;width:50%">
	<h2>Attended</h2>
	<label for="faculty-name">HOD</label>
	<?php
			
					for($k=0; $k<$_SESSION['count'] ; $k++)
					{

				?>
				____________________________________________________________
      <form class="form-horizontal" method="post" action="">
        <div class="form-group">
          
        </div>  
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
        
        <!-- <div class="form-group">
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
        </div> --> 
		<?php
					}
		?>
        <div class="form-group">        
          <button type="submit" name="add" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </section>

