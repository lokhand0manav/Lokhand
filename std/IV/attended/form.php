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
$attended = attended();
//$conn=mysqli_connect('localhost','root','','preyash');

if($_SESSION['username']=="")
{
  header("refresh:1,url=../login.php");
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

//this cond is must, if user jumps from page of updating to add, session[id] wiil be considered from update

if(isset($_SESSION['id']) && !isset($_GET['count']) ) 
{
 $id = $_SESSION['id'];
 $temp=mysqli_fetch_assoc(IV("*","attended",$id,"select")); //function will be found in IVSql.php
 $employee = changeAssociation("attended",$temp);
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
 
		$ind_array = $_POST[$attended[2]];
		$city_array = $_POST[$attended[3]];
		$purpose_array = $_POST[$attended[4]];
		$ivdate_array = $_POST[$attended[5]];

		for($i=0; $i<count($ivdate_array);$i++)
		{
			$ivdate = mysqli_real_escape_string($conn,$ivdate_array[$i]);
			$fname = $username;
			$ind = mysqli_real_escape_string($conn,$ind_array[$i]);
			$city = mysqli_real_escape_string($conn,$city_array[$i]);
			$purpose = mysqli_real_escape_string($conn,$purpose_array[$i]);	
			//not important but used somehow:
			if(isset($employee[6]))
			{
				$permission = $employee[6];
				$report     = $employee[7];
				$certificate = $employee[8];
			}
			
			if(empty($_POST[$attended[5].'[]']))
			{
				$dateerr="Please enter a date";
				$flag++;
			}
			
			else   
			{
				$name = test_input($_POST[$attended[1].'[]']);
				if (!preg_match("/^[a-zA-Z]*$/",$name))
				{
					$nameerr = "Only letters and whitespace allowed";
					$flag++;
				}
			}
			if(empty($_POST[$attended[2].'[]']))
			{
				$inderr="Please enter the details";
				$flag++;
			}
			if(empty($_POST[$attended[3].'[]']))
			{
				$cityerr="Enter the city";
				$flag++;
			}
			else
			{
				$city = test_input($_POST[$attended[3].'[]']);
				if (!preg_match("/^[a-zA-Z]*$/",$city))
				{
					$cityerr = "City name cannot contain number";
					$flag++;
				}
			}
			if(empty($_POST[$attended[4].'[]']))
			{
				$perr="Please enter a date";
				$flag++;
			}

			//echo $flag;
			//if($flag=0)
			//{
				//if edit or not
				$val = array($id,$fname,$ind,$city,$purpose,$ivdate,$permission,$report,$certificate);
				if($id!=-999)
				{
					
					$result = IV("what","attended",$val,"update");
					//$sql="UPDATE attended set f_name ='$fname' ,ind ='$ind', city='$city', purpose='$purpose', date='$ivdate' where f_id= $id;";		
				}
				else
				{
					
				 	$result = IV("what","attended",$val,"insert");
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
				  header("location:template.php?x=../IV/select_menu/view_menu.php&alert=update");	
				}
				else //new addition
				{
				  header("location:template.php?x=../IV/select_menu/view_menu.php");
				}
				
	}
}
?>


  <!-- Content Header (Page header) -->
  


    
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">IV Activity Attended Form</h3>
				 
                </div><!-- /.box-header -->
                <!-- form start -->
	
				<div class="form-group col-md-12">

                         <label for="faculty-name">Faculty Name</label>
                         <input required type="text" class="form-control input-lg" id="faculty-name" name="<?php echo $attended[1];//fname?>" value="<?php echo $username; ?>" readonly>
                     </div><br/> <br/> <br/> <br/> 
				
				<?php
			
					for($k=0; $k<$count ; $k++)
					{

				?>
            <p>********************************************************************</p>
			<form role="form" method="POST" class="row" action= "" style= "margin:10px;" >
					
				
                <div class="form-group col-md-6">
                <label >Industry Name</label><span class="required">*</span>         
         	 	<input type="textarea" rows="5" cols="5" class="form-control" name="<?php echo $attended[2];//ind[]?>[]" value=<?php if($id!=-999){ echo $employee[2];}?>>
          		<span class="error"><?php echo $inderr; ?></span>
                </div>

                     <div class="form-group col-md-6">
                         <label>Date of visit:</label><span class="required">*</span>
          				 <input type="date" name="<?php echo $attended[5];//ivdate[]?>[]" class="form-control" value=<?php if($id!=-999){ echo $employee[5];}?>>
         				 <span class="error"><?php echo $dateerr; ?></span>
                     </div>
                     <div class="form-group col-md-12">
                         <label >Purpose</label><span class="required">*</span>        
          				<textarea rows="5" cols="5" class="form-control" name="<?php echo $attended[4];//purpose[]?>[]"><?php if($id!=-999){ echo $employee[4];}?>
          				</textarea>
          				<span class="error"><?php echo $inderr; ?></span>
                     </div>

                     <div class="form-group col-md-8"> 
                         <label>City</label><span class="required">*</span>
          				 <input type="text" class="form-control" name="<?php echo $attended[3];//city[]?>[]" value=<?php if($id!=-999){ echo $employee[3];}?>>
          				 <span class="error"><?php echo $cityerr; ?></span>
                     </div>
                     
                   <?php
					}
					?>
					<br/>
                    <div class="form-group col-md-12">
                         <a href="template.php?x=../IV/select_menu/addcount.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <input name="add" type="submit" class="btn btn-success pull-right btn-lg">
                    </div>
                </form>
                </div>
              </div>
         
        </section>
       