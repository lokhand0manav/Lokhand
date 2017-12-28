<script>
$(document).ready(function(){
  $(".1").attr("class","active");
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
$count = $GLOBALS['count'];
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

//this cond is must, if user jumps from page of updating to add, session[id] wiil be considered from update
if(isset($_SESSION['id']) && !isset($_GET['count']) ) 
{
 $id = $_SESSION['id'];
 $sql="SELECT * FROM organized where f_id = $id";
 $records=mysqli_query($conn,$sql); 
 $employee=mysqli_fetch_assoc($records);
 $count = 1;
}
else if(!isset($_SESSION['id']) && !isset($_GET['count']))
{

	header("location:template.php?x=../IV/organized/addcount.php"); //go to add once refreshed
}
else
	$id=-999;


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['add']))
	{

		//the form was submitted
    
		$ivdate_array = $_POST['ivdate'];
		//$fname_array = $_POST['fname'];
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
			$fname = $username;
			//$fname = mysqli_real_escape_string($conn,$fname_array[$i]);
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

			if($id!=-999)
				{
					$sql="UPDATE organized set ind ='$ind', city='$city', purpose='$purpose', date='$ivdate',s_name='$staff',t_from='$from',t_to='$to' where f_id= $id;";		
				}
			else
			{		
			$sql="INSERT INTO organized (f_name,ind,city,purpose,date,tAudience,s_name,t_from,t_to) VALUES ('$fname','$ind','$city','$purpose','$ivdate','$t_audience','$staff','$from','$to')";
			}

			if(!mysqli_query($conn,$sql))
			{
				echo"Not Inserted";
				echo mysqli_error($conn);
				exit(0);

			}
			else
			{
				//echo"Record Inserted Successfully !";
			}
		}
				mysqli_close($conn);
				if(isset($_SESSION['id'])) //if editing
				{
				  unset($_SESSION['id']);		
				  header("location:template.php?x=../IV/select_menu/view_menu.php&alert=update");	
				}
				else //new addition
				{
				  header("location:template.php?x=../IV/select_menu/view_menu.php");
				}
				
	}
}

?>
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">IV Activity Organized Form</h3>
				 
                </div><!-- /.box-header -->
                <!-- form start -->
	
				<div class="form-group col-md-10">

                         <label for="faculty-name">Faculty Name</label>
                         <input required type="text" class="form-control input-lg" id="faculty-name" name="facultyName" value="<?php echo $username; ?>" readonly>
                     </div><br/> <br/> <br/> <br/> 
				
				<?php
					for($k=0; $k<$count ; $k++)
					{

				?>
            <p>***************************************************************************************</p>
			<form role="form" method="POST" class="row" action= "template.php?x=../IV/organized/form.php" style= "margin:10px;" >
					
				
                <div class="form-group col-md-6">
               	<label>Date of Visit:</label><span class="required">*</span>
					<input type="date" name="ivdate[]" class="form-control" value=<?php if($id!=-999){ echo $employee['date'];}?>>
					<span class="error"><?php echo $dateerr; ?></span>
                </div>

                     <div class="form-group col-md-6"><span class="required">*</span>
                         <label >Industry Name</label>         
						<input type="text" class="form-control" name="ind[]" value=<?php if($id!=-999){ echo $employee['ind'];}?>>
					<span class="error"><?php echo $inderr; ?></span>
                     </div>
                     <div class="form-group col-md-12">
                         <label >Purpose</label><span class="required">*</span>        
          				<textarea rows="5" cols="5" class="form-control" name="purpose[]"><?php if($id!=-999){ echo $employee['purpose'];}?>
          				</textarea>
          				<span class="error"><?php echo $perr; ?></span>
                     </div>

                     <div class="form-group col-md-8"> 
                     <label>City</label><span class="required">*</span>
					<input type="text" class="form-control" name="city[]" value=<?php if($id!=-999){ echo $employee['city'];}?>>
					<span class="error"><?php echo $cityerr; ?></span>
                         
                     </div>
                     
                     <div class="form-group col-md-8"> 
                     <label>Target Audience</label><span class="required">*</span>
					<input type="text" class="form-control" name="t_audience[]" value=<?php if($id!=-999){ echo $employee['tAudience'];}?>>
					<span class="error"><?php echo $taerror; ?></span>
					</div>


					<div class="form-group col-md-8">
					<label>Staff</label><span class="required"> *</span>
					<input type="text" class="form-control" name="staff[]" value=<?php if($id!=-999){ echo $employee['s_name'];}?>>
					<span class="error"><?php echo $serror; ?></span>
					</div>

					<div class="form-group col-md-12">

					<label>Duration</label><span class="required"> *</span>
					<br>
					<b>From:</b> &emsp;<input type="date" name="from[]" placeholder="from" value=<?php if($id!=-999){ echo $employee['t_from'];}?>>
					
					&emsp;
					<b>To:</b>&emsp;<input type="date" name="to[]" placeholder="to" value=<?php if($id!=-999){ echo $employee['t_to'];}?>><br>
					</div>

                   <?php
					}
					?>
					<br/>
                    <div class="form-group col-md-12">
                         <a href="template.php?x=../select_menu/addcount.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <input name="add" type="submit" class="btn btn-success pull-right btn-lg">
                    </div>
                </form>
                </div>
              </div>
           </div>      
        </section>
</body>
 </html>
