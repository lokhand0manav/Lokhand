<script>
$(document).ready(function(){
  $(".1").attr("class","active");
});
</script>
<?php 
ob_start();
if(session_status() == PHP_SESSION_NONE)
{
    //session has not started
    session_start();
}
$conn=connection(); //this is required, andhence GLOBALS is used IVSql.php


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
$id=-999;

$permission="";
$report ="";
$certificate="";
$attendance="";

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
 $employee=mysqli_fetch_assoc(IV("*","organized",$id,"select"));
 $count = 1;
}

else if(!isset($_SESSION['id']) && !isset($_GET['count']))
{

	header("location:template.php?x=../IV/select_menu/addcount.php"); //go to add once refreshed
}
// else if(!isset($_SESSION['id']) && !isset($_GET['count']))
// {
// 	echo $_SESSION['id'];
// 	echo $_GET['count'];
// 	header("location:template.php?x=../IV/select_menu/addcoun.php"); //go to add once refreshed
// 	exit(0);
// }
else
	$id=-999;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['add']))
	{
		//the form was submitted
    	$f_id = $_POST['fid'];
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
			// $fname = $username;
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

			$val = array($id,$f_id,$ind,$city,$purpose,$ivdate,$t_audience,$staff,$permission,$report,$certificate,$attendance,$from,$to);
			if($id!=-999)
				{

					$result = IV("what","organized",$val,"update");	
				}
				else
				{		
					$result = IV("what","organized",$val,"insert");
				}
		
			if(!$result)
			{
				echo"Not Inserted";
			
			}
			else
			{
				//echo"Record Inserted Successfully !";
			}
		}
				mysqli_close($GLOBALS[conn]);
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
		<form role="form" method="POST" class="row" action= "template.php?x=../IV/organized/form.php" style= "margin:10px;" >
				<div class="form-group col-md-10">

                         <label for="faculty-name">Faculty Name</label>
                         <?php
                    	if($id!=-999) //not a new entry i.e editing as id is set
                    	{
                    		$f_name = mysqli_fetch_assoc(getFacultyDetails($employee['f_id']))['F_NAME'];
                    		$f_id = $employee['f_id'];
                    	}
                    	else //new Entry
                    	{	
                    		$f_name = $_SESSION['loggedInUser'];
                    		$f_id = $_SESSION['f_id'];	
                    	}

                    	//if HOD then give drop down
                    	if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
                    	{
                    	?>
                    	<select name="fid" class="form-control input-lg" > 

                    	<?php
                              $temp="";
                              $temp = getFacultyDetails($temp);
                              while($fac=mysqli_fetch_assoc($temp))
                                {
                                    if($fac[Fac_ID]!=9) //not HOD
                                    {
                                      echo "<option value = '$fac[Fac_ID]'>$fac[F_NAME]</option>";
									}
                                }
                        ?>
                        </select>

                        <?php        
                    	}
                    	else
                    	{
                    		echo "<input required type='hidden' name='fid' value=$f_id >"; //for faculty id
                    		echo "<input required type='text' class='form-control input-lg' id='faculty-name' name='fname' value='$f_name' readonly>";
                    	}	
                    	?>

                     	 </div><br/> <br/> <br/> <br/>

				<?php
					for($k=0; $k<$count ; $k++)
					{

				?>
            <p>***************************************************************************************</p>
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
					<input type="text" class="form-control" name="t_audience[]" value=<?php if($id!=-999){ echo $employee['t_audience'];}?>>
					<span class="error"><?php echo $taerror; ?></span>
					</div>


					<div class="form-group col-md-8">
					<label>Staff</label><span class="required"> *</span>
					<input type="text" class="form-control" name="staff[]" value=<?php if($id!=-999){ echo $employee['staff'];}?>>
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
