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
else if($_SESSION['username']!='hodextc@somaiya.edu')
{
  $fname = $_SESSION['username'];
}
else{
	$fname="";
}

$count = $GLOBALS['count'];
$flag=0;
$dateerr = "";
$nameerr = "";
$inderr = "";
$cityerr = "";
$perr = "";
$id = -999;
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
 $sql="SELECT * FROM attended where f_id = $id";
 $records=mysqli_query($conn,$sql); 
 $employee=mysqli_fetch_assoc($records);
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
    	// $fname_array=$_POST['fname'];
    	$fname = $_POST['fname'];
		$ivdate_array = $_POST['ivdate'];
		$ind_array = $_POST['ind'];
		$city_array = $_POST['city'];
		$purpose_array = $_POST['purpose'];
		
		for($i=0; $i<count($ivdate_array);$i++)
		{
			$ivdate = mysqli_real_escape_string($conn,$ivdate_array[$i]);
			// $fname = mysqli_real_escape_string($conn,$fname_array[$i]);;
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

			//echo $flag;
			//if($flag=0)
			//{
				//if edit or not
				if($id!=-999)
				{
					$sql="UPDATE attended set f_name ='$fname' ,ind ='$ind', city='$city', purpose='$purpose', date='$ivdate' where f_id= $id;";		
				}
				else
				{
					
					$sql="INSERT INTO attended (f_name,ind,city,purpose,date) VALUES ('$fname','$ind','$city','$purpose','$ivdate')";
				}

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
		<form role="form" method="POST" class="row" action= "" style= "margin:10px;" >	
				<div class="form-group col-md-12">

                         <label for="faculty-name">Faculty Name</label>
                         <?php 
                         if($fname!="")
                         { 
                         ?> 
                         <input required type="text" class="form-control input-lg" id="faculty-name" name="fname" value=<?php echo $fname; ?> readonly>
                     	 </div><br/> <br/> <br/> <br/>
                    
                    <?php 
                 			}
                 			else{			
					?>
						<input required type="text" class="form-control input-lg" id="faculty-name" name="fname" value=<?php if($id!=-999){ echo $employee['f_name'];}?>>
                     	 </div><br/> <br/> <br/> <br/>
                     	<?php 
                     	}
                     	 ?> 




				<?php
			
					for($k=0; $k<$count ; $k++)
					{

				?>
            <p>********************************************************************</p>
			
					
				
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
        <!-- <div class="form-group">        
          <button type="submit" name="add" class="btn btn-primary">Submit</button>
        </div> -->
