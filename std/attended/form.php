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
		$ind_array = $_POST['ind'];
		$city_array = $_POST['city'];
		$purpose_array = $_POST['purpose'];
		
		for($i=0; $i<count($ivdate_array);$i++)
		{
			$ivdate = mysqli_real_escape_string($conn,$ivdate_array[$i]);
			$fname = $username;
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
				header("location:template.php?x=../attended/view.php");
	}
}
?>


  <!-- Content Header (Page header) -->
  

  <div class="content-wrapper">
    
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
                         <input required type="text" class="form-control input-lg" id="faculty-name" name="fname" value="<?php echo $username; ?>" readonly>
                     </div><br/> <br/> <br/> <br/> 
				
				<?php
			
					for($k=0; $k<$_SESSION['count'] ; $k++)
					{

				?>
            <p>********************************************************************</p>
			<form role="form" method="POST" class="row" action= "template.php?x=../attended/form.php" style= "margin:10px;" >
					
				
                <div class="form-group col-md-6">
                <label >Industry Name</label><span class="required">*</span>         
         	 	<input type="textarea" rows="5" cols="5" class="form-control" name="ind[]">
          		<span class="error"><?php echo $inderr; ?></span>
                </div>

                     <div class="form-group col-md-6">
                         <label>Date of visit:</label><span class="required">*</span>
          				 <input type="date" name="ivdate[]" class="form-control">
         				 <span class="error"><?php echo $dateerr; ?></span>
                     </div>
                     <div class="form-group col-md-12">
                         <label >Purpose</label><span class="required">*</span>        
          				<textarea rows="5" cols="5" class="form-control" name="purpose[]">
          				</textarea>
          				<span class="error"><?php echo $inderr; ?></span>
                     </div>

                     <div class="form-group col-md-8"> 
                         <label>City</label><span class="required">*</span>
          				 <input type="text" class="form-control" name="city[]">
          				 <span class="error"><?php echo $cityerr; ?></span>
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
