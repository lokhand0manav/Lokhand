<div class="box">
	<div class="box-body">

		<form role='form' action='' method='POST'>
			<!-- ===== Select Activity==== -->
			<div class='box-header with-border'>
				<h3 class='box-title'>View/Edit Activities</h3>
				<select name="activity" class="box-title" style="margin-left: 100px;">
					<option value="attended">Attended</option>
					<option value="organized">Organized</option>
				</select>
			</div><!-- /.box-header   -->
			
			<div class='box-footer'>
				<button type='submit' name='submit_view' id='submit' value='' class='btn btn-primary'>View</button>
				<button type='submit' name='cancel' id='cancel' value='' class='btn btn-primary'>Cancel</button>
			</div>
			
		</form>
		
	</div>
	<?php 
	if(isset($_POST['submit_view']))
	{	
		$_SESSION['activity']=$_POST['activity'];
		if($_SESSION['username'] == 'hodextc@somaiya.edu' || $_SESSION['username'] == 'member@somaiya.edu')
		{
			include("../IV/".$_SESSION['activity']."/edit_admin.php");

		}
		else
		{
			include("../IV/".$_SESSION['activity']."/edit.php");
			
		}
							// $_POST['submit_view']="";
	}
	

	if(isset($_POST['cancel']))
	{
		
		header("location:template.php");
		
		
	}
	
	?>