<script>
$(document).ready(function(){
  $(".2").attr("class","active");
  $("button.close").click(function(){
  	window.location.replace("../includes/template.php?x=../IV/select_menu/edit_menu.php");
  });
});

</script>
<?php 
function change()
{
	echo "SELECTED";
}
if(isset($_GET['alert']))
			{
				//header("Refresh:0;url=../includes/template.php?x=../IV/select_menu/edit_menu.php");
				
			}
?>
<div class="box">
	<div class="box-body">

		<form role='form' action='' method='POST'>
			<!-- ===== Select Activity==== -->
			<div class='box-header with-border'>
				<h3 class='box-title'>View/Edit Activities</h3>
				<select name="activity" class="box-title" style="margin-left: 100px;">
					<option value="attended"  <?php if(isset($_POST['activity'])){if($_POST['activity']=="attended") change();}?>>Attended</option>
					<option value="organized" <?php if(isset($_POST['activity'])){if($_POST['activity']=="organized") change();}?>>Organized</option>
				</select>

			</div><!-- /.box-header   -->
<?php
//When HOD
	if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
	{
?>			<div class='box-header with-border'>
				<h3 class='box-title'>Select Faculty</h3>
				<select name="faculty" class="box-title" style="margin-left: 140px;">
				<?php
				echo "<option value = '0'>ALL</option>";
							  $temp="";
                              $temp = getFacultyDetails($temp);
                              while($fac=mysqli_fetch_assoc($temp))
                                {
                                    if($fac[Fac_ID]!=9) //not HOD
                                    {
                          				 if(isset($_POST['faculty']) && $_POST['faculty']==$fac['Fac_ID'])
                          				 {
                          					echo "<option value = '$fac[Fac_ID]' SELECTED >$fac[F_NAME]</option>";	 	
                          				 }
                          				 else
											echo "<option value = '$fac[Fac_ID]'".">$fac[F_NAME]</option>";
									}
                                }
				?>	
				</select>
				
			</div><!-- /.box-header   -->
<?php 
	}
?>			
			<div class='box-footer'>
				<button type='submit' name='submit_view' id='submit' value='' class='btn btn-primary'>View</button>
				<button type='submit' name='cancel' id='cancel' value='' class='btn btn-primary'>Cancel</button>
			</div>
			
		</form>
		
	</div>
	
	<?php 
	if(isset($_POST['submit_view']))
	{		
	  	$_SESSION['edit_menu_faculty'] = $_POST['faculty']; 
		
		include_once("../IV/".$_POST['activity']."/edit.php");// $_POST['submit_view']="";
	}
	

	if(isset($_POST['cancel']))
	{
		
		header("location:template.php");
		
		
	}
	
	?>