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
$organized = organized();

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
 $temp=mysqli_fetch_assoc(IV("*","organized",$id,"select"));
 $employee = changeAssociation("organized",$temp);
 $count = 1;
}
else if(!isset($_SESSION['id']) && !isset($_GET['count']))
{

	header("location:template.php?x=../IV/select_menu/addcount.php"); //go to add once refreshed
}


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['add']))
	{

		//the form was submitted
		//$fname_array = $_POST['fname'];
		$ind_array = $_POST[$organized[2]];
		$city_array = $_POST[$organized[3]];
		$purpose_array = $_POST[$organized[4]];
		$ivdate_array = $_POST[$organized[5]];
		$t_audience_array = $_POST[$organized[6]];
		$staff_array = $_POST[$organized[7]];
		$from_array= $_POST[$organized[12]];
		$to_array= $_POST[$organized[13]];
		
		for($i=0; $i<count($ivdate_array);$i++)
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
			if(isset($employee[8]))
			{
				$permission = $employee[8];
				$report     = $employee[9];
				$certificate = $employee[10];
				$attendance = $employee[11];		
			}
			
			if(empty($_POST[$organized[2].'[]']))
			{
				$inderr="Please enter the details";
				$flag++;
			}
			if(empty($_POST[$organized[3].'[]']))
			{
				$cityerr="Enter the city";
				$flag++;
			}
			else 
			{
				$city = test_input($_POST[$organized[3].'[]']);
				if (!preg_match("/^[a-zA-Z]*$/",$city))
				{
					$cityerr = "City name cannot contain number";
					$flag++;
				}
			}
			if(empty($_POST[$organized[4].'[]']))
			{
				$perr="Please enter a date";
				$flag++;
			}
			if(empty($_POST[$organized[5].'[]']))
			{
				$dateerr="Please enter a date";
				$flag++;
			}
			if(empty($_POST[$organized[6].'[]']))
			{
				$taerror = "Please Enter Target Audience";
				$flag++;
			}
			if(empty($_POST[$organized[7].'[]']))
			{
				$serror = "Please Enter the Staff";
				$flag++;
			}

			$val = array($id,$fname,$ind,$city,$purpose,$ivdate,$t_audience,$staff,$permission,$report,$certificate,$attendance,$from,$to);
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
	
				<div class="form-group col-md-10">

                         <label for="faculty-name">Faculty Name</label>
                         <input required type="text" class="form-control input-lg" id="faculty-name" name="<?php echo $organized[1];//facultyName ?>" value="<?php echo $username; ?>" readonly>
                     </div><br/> <br/> <br/> <br/> 
				
				<?php
					for($k=0; $k<$count ; $k++)
					{

				?>
            <p>***************************************************************************************</p>
			<form role="form" method="POST" class="row" action= "template.php?x=../IV/organized/form.php" style= "margin:10px;" >
					
				
                <div class="form-group col-md-6">
               	<label>Date of Visit:</label><span class="required">*</span>
					<input type="date" name="<?php echo $organized[5];//ivdate[] ?>[]" class="form-control" value=<?php if($id!=-999){ echo $employee[5];}?>>
					<span class="error"><?php echo $dateerr; ?></span>
                </div>

                     <div class="form-group col-md-6"><span class="required">*</span>
                         <label >Industry Name</label>         
						<input type="text" class="form-control" name="<?php echo $organized[2];//ind[] ?>[]" value=<?php if($id!=-999){ echo $employee[2];}?>>
					<span class="error"><?php echo $inderr; ?></span>
                     </div>
                     <div class="form-group col-md-12">
                         <label >Purpose</label><span class="required">*</span>        
          				<textarea rows="5" cols="5" class="form-control" name="<?php echo $organized[4];//purpose[] ?>[]"><?php if($id!=-999){ echo $employee[4];}?>
          				</textarea>
          				<span class="error"><?php echo $perr; ?></span>
                     </div>

                     <div class="form-group col-md-8"> 
                     <label>City</label><span class="required">*</span>
					<input type="text" class="form-control" name="<?php echo $organized[3];//city[] ?>[]" value=<?php if($id!=-999){ echo $employee[3];}?>>
					<span class="error"><?php echo $cityerr; ?></span>
                         
                     </div>
                     
                     <div class="form-group col-md-8"> 
                     <label>Target Audience</label><span class="required">*</span>
					<input type="text" class="form-control" name="<?php echo $organized[6];//t_audience[] ?>[]" value=<?php if($id!=-999){ echo $employee[6];}?>>
					<span class="error"><?php echo $taerror; ?></span>
					</div>


					<div class="form-group col-md-8">
					<label>Staff</label><span class="required"> *</span>
					<input type="text" class="form-control" name="<?php echo $organized[7];//staff[] ?>[]" value=<?php if($id!=-999){ echo $employee[7];}?>>
					<span class="error"><?php echo $serror; ?></span>
					</div>

					<div class="form-group col-md-12">

					<label>Duration</label><span class="required"> *</span>
					<br>
					<b>From:</b> &emsp;<input type="date" name="<?php echo $organized[12];//from[] ?>[]" placeholder="from" value=<?php if($id!=-999){ echo $employee[12];}?>>
					
					&emsp;
					<b>To:</b>&emsp;<input type="date" name="<?php echo $organized[13];//to[] ?>[]" placeholder="to" value=<?php if($id!=-999){ echo $employee[13];}?>><br>
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
