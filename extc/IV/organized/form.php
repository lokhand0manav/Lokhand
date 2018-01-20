<script>
$(document).ready(function(){
  $(".1").attr("class","active");
});
</script>
<style>
.error {
    color: red;
}
</style>
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
  header("refresh:2,url=index.php");
  die("Login Required");
}
else
{
  $username = $_SESSION['username'];
}

$count = $GLOBALS['count'];
$flag=0;
$dateerr = "";
$derror = "";
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

//this cond is must, if user jumps from page of updating to add, session[id] will be considered from update
if(isset($_SESSION['id']) && !isset($_GET['count']) ) 
{
 $id = $_SESSION['id'];
 $employee=mysqli_fetch_assoc(IV("*",$organized,$id,"select"));
 $count = 1;
}

else if(!isset($_SESSION['id']) && !isset($_GET['count']))
{

	//header("location:template.php?x=IV/select_menu/addcount.php"); //go to add once refreshed
}

else
	$id=-999;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['add']))
	{
		//the form was submitted
    	$f_id_array = $_POST['fid'];
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
			$f_id = mysqli_real_escape_string($conn,$f_id_array[$i]);
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
			
			if(empty($_POST['ivdate'][$i]))
			{
				$dateerr="Please enter a date";
				$flag++;
			}
			
			if(empty($_POST['ind'][$i]))
			{
				$inderr="Please enter the details";
				$flag++;
			}
			if(empty($_POST['city'][$i]))
			{
				$cityerr="Enter the city";
				$flag++;
			}
			else 
			{
				$city = test_input($_POST['city'][$i]);
				if (!preg_match("/^[a-zA-Z]*$/",$city))
				{
					$cityerr = "City name cannot contain number";
					$flag++;
				}
			}
			if(empty($_POST['purpose'][$i]))
			{
				$perr="Please enter a date";
				$flag++;
			}
			if(empty($_POST['t_audience'][$i]))
			{
				$taerror = "Please Enter Target Audience";
				$flag++;
			}
			if(empty($_POST['staff'][$i]))
			{
				$serror = "Please Enter the Staff";
				$flag++;
			}
			if(empty($_POST['from'][$i]) && empty($_POST['to'][$i]))
				{
					$derror="Enter the duration";
					$flag++;
				}
				else if((strtotime($_POST['from'][$i]))>(strtotime($_POST['to'][$i])))
				{
					$derror="Incorrect date entered. Date from cannot be greater than Date to";
					$flag++;
				}
		
			if($flag==0)
			{
				$val = array($id,$f_id,$ind,$city,$purpose,$ivdate,$t_audience,$staff,$permission,$report,$certificate,$attendance,$from,$to);
				if($id!=-999)
					{
						$result = IV("what",$organized,$val,"update");	
						unset($_SESSION['id']);		
				  		header("location:template.php?x=IV/select_menu/edit_menu.php&alert=update&type=organized");	
					}
					else
					{		
						$result = IV("what",$organized,$val,"insert");
						header("location:template.php?x=IV/select_menu/edit_menu.php&type=organized");
					}
			}
			else
			{
				//$result= 0;
			}
			
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
		<form role="form" method="POST" class="row" action= "" style= "margin:10px;" >
				

				<?php
					for($k=0; $k<$count ; $k++)
					{
						//show faculty names multiple time only when HOD, not when user
						echo "<div class='form-group col-md-12 box-header with-border'>";
                        if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
                        	echo "<label for='faculty-name'>Faculty Name</label>";
                    	else
                    		if($k==0)
                    			echo "<label for='faculty-name'>Faculty Name</label>";

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
                    	<select name="fid[]" class="form-control input-lg" > 

                    	<?php
                              $temp="";
                              $temp = getFacultyDetails($temp);
                              while($fac=mysqli_fetch_assoc($temp))
                                {
                                    if($fac[Email]!="hodextc@somaiya.edu" && $fac[Email]!="member@somaiya.edu" ) //not HOD
                                    {
                                      	if($id!=-999 && $fac['Fac_ID']==$f_id) //not a new entry i.e editing as id is set
                                      		echo "<option value = '$fac[Fac_ID]' SELECTED>$fac[F_NAME]</option>";
										else
                                      		echo "<option value = '$fac[Fac_ID]'>$fac[F_NAME]</option>";

									}
                                }
                        ?>
                        </select>

                        <?php        
                    	}
                    	else
                    	{
                    		if($k==0)
                    		 {
                    		 echo "<input required type='hidden' name='fid[]' value=$f_id >"; //for faculty id
                    		 echo "<input required type='text' class='form-control input-lg' id='faculty-name' name='fname' value='$f_name' readonly>";
                    		 }
                    		 else
                    		 {
                    		 echo "<input required type='hidden' name='fid[]' value=$f_id >"; //for faculty id
                    		 echo "<input required type='hidden' class='form-control input-lg' id='faculty-name' name='fname' value='$f_name'>";
                    		 }
                    	}	
                    	?>

                </div>
           
                <div class="form-group col-md-6">
               	<label>Date of Visit:</label><span class="required">*</span>
					<input type="date" name="ivdate[]" class="form-control" value=<?php if(isset($_POST['ivdate'][$k])){echo $_POST['ivdate'][$k];} else if($id!=-999){ echo $employee['date'];}?>>
					<span class="error"><?php echo $dateerr; ?></span>
                </div>

                     <div class="form-group col-md-6"><span class="required">*</span>
                         <label >Industry Name</label>         
						<input type="text" class="form-control" name="ind[]" value='<?php if(isset($_POST['ind'][$k])){echo $_POST['ind'][$k];} else if($id!=-999){ echo $employee['ind'];}?>'>
					<span class="error"><?php echo $inderr; ?></span>
                     </div>
                     <div class="form-group col-md-12">
                         <label >Purpose</label><span class="required">*</span>        
          				<textarea rows="5" cols="5" class="form-control" name="purpose[]"><?php if(isset($_POST['purpose'][$k])){echo $_POST['purpose'][$k];} else if($id!=-999){ echo $employee['purpose'];} ?>
          				</textarea>
          				<span class="error"><?php echo $perr; ?></span>
                     </div>

                     <div class="form-group col-md-8"> 
                     <label>City</label><span class="required">*</span>
					<input type="text" class="form-control" name="city[]" value=<?php if(isset($_POST['city'][$k])){echo $_POST['city'][$k];} else if($id!=-999){ echo $employee['city'];}?>>
					<span class="error"><?php echo $cityerr; ?></span>
                         
                     </div>
                     
                     <div class="form-group col-md-8"> 
                     <label>Target Audience</label><span class="required">*</span>
					<input type="text" class="form-control" name="t_audience[]" value='<?php if(isset($_POST['t_audience'][$k])){echo $_POST['t_audience'][$k];} else if($id!=-999){ echo $employee['t_audience'];} ?>'>
					<span class="error"><?php echo $taerror; ?></span>
					</div>


					<div class="form-group col-md-8">
					<label>Staff</label><span class="required"> *</span>
					<input type="text" class="form-control" name="staff[]" value='<?php if(isset($_POST['staff'][$k])){echo $_POST['staff'][$k];} else if($id!=-999){ echo $employee['staff'];} ?>'>
					<span class="error"><?php echo $serror; ?></span>
					</div>

					<div class="form-group col-md-12">

					<label>Duration</label><span class="required"> *</span>
					<br>
					<b>From:</b> &emsp;<input type="date" name="from[]" placeholder="from" value=<?php if(isset($_POST['from'][$k])){echo $_POST['from'][$k];} else if($id!=-999){ echo $employee['t_from'];}?>>
					
					&emsp;
					<b>To:</b>&emsp;<input type="date" name="to[]" placeholder="to" value=<?php if(isset($_POST['to'][$k])){echo $_POST['to'][$k];} else if($id!=-999){ echo $employee['t_to'];}?>><br>
					<span class="error"><?php echo $derror; ?></span>
					</div>
 <p>************************************************************************************</p>
                   <?php
					}
					?>
					<br/>
                    <div class="form-group col-md-12">
                         <a href="template.php?x=IV/select_menu/addcount.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <input name="add" type="submit" class="btn btn-success pull-right btn-lg">
                    </div>
                </form>
                </div>
              </div>
           </div>      
        </section>
</body>
 </html>
