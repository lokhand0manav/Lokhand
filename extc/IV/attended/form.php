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
$conn=connection();

//$conn=mysqli_connect('localhost','root','','preyash');

if($_SESSION['username']=="")
{
  header("refresh:1,url=index.php");
  die("Login Required");
}
else
{
  $username = $_SESSION['username'];
}

$count = $GLOBALS['count']; //found in template
$flag=0;
$dateerr = "";
$nameerr = "";
$inderr = "";
$cityerr = "";
$perr = "";
$id = -999;
$permission="";
$report ="";
$certificate="";

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
 $employee=mysqli_fetch_assoc(IV("*",$attended,$id,"select")); //function will be found in IVSql.php
 $count = 1;
}
else if(!isset($_SESSION['id']) && !isset($_GET['count']))
{
	header("location:template.php?x=IV/select_menu/addcount.php"); //go to add once refreshed
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['add']))
	{

		//the form was submitted
    	// $fname_array=$_POST['fname'];
    	//$fname = $_POST['fname'];
    	$f_id_array = $_POST['fid'];
		$ivdate_array = $_POST['ivdate'];
		$ind_array = $_POST['ind'];
		$city_array = $_POST['city'];
		$purpose_array = $_POST['purpose'];
		
		for($i=0; $i<count($ivdate_array);$i++)
		{
			$f_id = mysqli_real_escape_string($conn,$f_id_array[$i]);
			$ivdate = mysqli_real_escape_string($conn,$ivdate_array[$i]);
			$ind = mysqli_real_escape_string($conn,$ind_array[$i]);
			$city = mysqli_real_escape_string($conn,$city_array[$i]);
			$purpose = mysqli_real_escape_string($conn,$purpose_array[$i]);	
	
			if(empty($_POST['ivdate[]']))
			{
				$dateerr="Please enter a date";
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

				$val = array($id,$f_id,$ind,$city,$purpose,$ivdate,$permission,$report,$certificate);
				if($id!=-999)
				{
					
					$result = IV("what",$attended,$val,"update");
					//$sql="UPDATE attended set f_name ='$fname' ,ind ='$ind', city='$city', purpose='$purpose', date='$ivdate' where f_id= $id;";		
				}
				else
				{
					
				 	$result = IV("what",$attended,$val,"insert");
				 	//$sql="INSERT INTO attended (f_name,ind,city,purpose,date) VALUES ('$fname','$ind','$city','$purpose','$ivdate')";
				}

				if(!$result)
				{
					echo"Not Inserted";
				}
				else
				{
			
				}
			//}
		}
				mysqli_close($GLOBALS[conn]);
				if(isset($_SESSION['id'])) //if editing
				{
				  unset($_SESSION['id']);		
				  header("location:template.php?x=IV/select_menu/edit_menu.php&alert=update&type=attended");
				}
				else //new addition
				{
				  header("location:template.php?x=IV/select_menu/edit_menu.php&type=attended");
				}
				
	}
}
?>


  <!-- Content Header (Page header) -->
     
    <section class="content">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              	<div class="box box-primary">
                	<div class="box-header with-border">
                 		<h3 class="box-title">IV Activity Attended Form</h3>	 
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

                         
                </div><br/> <br/> <br/> <br/> 
							
                	 <div class="form-group col-md-6">
                		 <label >Industry Name</label><span class="required">*</span>         
         	 			 <input type="textarea" rows="5" cols="5" class="form-control" name="ind[]" value=<?php if($id!=-999){ echo $employee['ind'];}?>>
          				 <span class="error"><?php echo $inderr; ?></span>
                	 </div>

                     <div class="form-group col-md-6">
                         <label>Date of visit:</label><span class="required">*</span>
          				 <input type="date" name="ivdate[]" class="form-control" value=<?php if($id!=-999){ echo $employee['date'];}?>>
         				 <span class="error"><?php echo $dateerr; ?></span>
                     </div>
                     <div class="form-group col-md-12">
                         <label >Purpose</label><span class="required">*</span>        
          				<textarea rows="5" cols="5" class="form-control" name="purpose[]"><?php if($id!=-999){ echo $employee['purpose'];}?>
          				</textarea>
          				<span class="error"><?php echo $inderr; ?></span>
                     </div>

                     <div class="form-group col-md-8"> 
                         <label>City</label><span class="required">*</span>
          				 <input type="text" class="form-control" name="city[]" value=<?php if($id!=-999){ echo $employee['city'];}?>>
          				 <span class="error"><?php echo $cityerr; ?></span>
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
    </section>
       
       