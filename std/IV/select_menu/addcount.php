<script>
$(document).ready(function(){
  $(".1").attr("class","active");
});
</script>	
              <div class='box box-primary'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Form for applying activity</h3>
				</div><!-- /.box-header -->
                <!-- form start -->
				<?php 
				echo "&emsp;Logged In User: <b>".$_SESSION['loggedInUser']."</b>";
				?>

                <form role='form' action='' method='POST'>
                  <div class='box-body'>
                    <div class='form-group'>
                    <label for='activity'>Number of Activity</label>
                    <input type='number' id='count' name='count'/>
                    &emsp;&emsp;

                 		<!-- ===== Select Activity==== -->
                 	<b>Select Activity:</b> 	
                    <select name="activity">
  					<option value="attended">Attended</option>
  					<option value="organized">Organized</option>
  					</select>

                    
                  </div>
                  </div><!-- /.box-body -->

                  <div class='box-footer'>
                    <button type='submit' name='submit_count' id='submit' value='' class='btn btn-primary'>Log Activity!</button>
                    <button type='submit' name='cancel' id='cancel' value='' class='btn btn-primary'>Cancel</button>
                  </div>
				  
                </form>
                
                </div>
                <?php
				  	$username = $_SESSION['username'];
					if ($_SERVER["REQUEST_METHOD"] == "POST") 
						{
					 		if(isset($_POST['submit_count']))
					  		{
								$count = $_POST["count"];
					  		}
					  		else
					  		{
					  			$count = 0;
					  		}
							
							if($count <=0 )
							{
								$result="Don't enter zero or negative value<br>";
								echo '<div class="error">'.$result.'</div>';

							}
							else
							{	
								$_SESSION['activity']=$_POST['activity'];
									header("location:template.php?x=../IV/".$_SESSION['activity']."/form.php&count=".$count);
							}
						}
						 
					if(isset($_POST['cancel']))
					  	{
			
								header("location:template.php");
							
					  	}
						
					?>
		